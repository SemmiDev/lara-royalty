<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Ajukan Voucher
            </h2>
        </div>
    </x-slot>

    <div class="py-6">
        <form
            action="{{ route('vouchers.store', ['tenant' => $tenant]) }}"
            method="POST"
            id="check"
            class="w-full max-w-4xl mx-auto p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-6 md:p-8 dark:bg-gray-800 dark:border-gray-700">
            @csrf

            <div class="flex justify-between items-center">
                <h1 class="text-lg font-medium text-gray-900 dark:text-white">Silahkan Masukkan Kode Invoice</h1>
                <button type="button"
                        id="invoice-add"
                        class="text-white flex-grow-0 bg-gradient-to-r from-cyan-500 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-cyan-300 dark:focus:ring-cyan-800 font-medium rounded-lg text-sm px-5 py-3 text-center">
                    Tambah
                </button>
            </div>

            <div class="mt-5 flex justify-start gap-2">
                <div class="invoice-item">
                    <input type="text"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-fit p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                           name="invoice_numbers[]"
                           placeholder="Kode invoice">
                </div>

                <div class="invoice-list flex flex-wrap gap-2">
                </div>
            </div>

            <button type="submit"
                    class="focus:outline-none w-fit mt-5 text-white bg-[#02AF81] hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                Cek Status
            </button>

            <div class="relative mt-5 overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Kode Invoice
                        </th>
                        <th scope="col" class="px-6 py-3 text-center">
                            Status
                        </th>
                    </tr>
                    </thead>
                    <tbody class="transactions-check">
                    </tbody>
                </table>
            </div>

            <div class="p-3 mt-5">
                <div id="message" class="text-sm text-gray-900">
                </div>
                <div id="amount" class="text-lg text-green-800">
                </div>
            </div>

            <a href=""
               id="lihat-detail-voucher"
               class="hidden text-gray-900 bg-[#F7BE38] hover:bg-[#F7BE38]/90 focus:ring-4 focus:outline-none focus:ring-[#F7BE38]/50 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-[#F7BE38]/50 me-2 mb-2">
                Lihat Detail Voucher
            </a>

        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#invoice-add').click(function () {
                var invoiceItem = $('.invoice-item').first().clone();
                invoiceItem.find('#invoice-add').remove();
                invoiceItem.find('input').val('');
                $('.invoice-list').append(invoiceItem);
            });

            $('#check').submit(function (e) {
                e.preventDefault();
                var invoiceNumbers = [];
                $('.invoice-item input').each(function () {
                    invoiceNumbers.push($(this).val());
                });

                if (invoiceNumbers[0] === '') {
                    alert('Kode invoice tidak boleh kosong');
                    return;
                }

                $.ajax({
                    url: '{{ route('vouchers.store', ['tenant' => $tenant]) }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        invoice_numbers: invoiceNumbers
                    },
                    success: function (data) {
                        const transactions = data.transactions;
                        const error = data.error;
                        const voucher = data.voucher;
                        const amount = data.amount;

                        var transactionsCheck = $('.transactions-check');
                        transactionsCheck.html('');

                        transactions.forEach(function (transaction) {
                            var status = transaction.status;
                            var invoiceNumber = transaction.invoice_number;

                            if (status === 'INVOICE TELAH DIGUNAKAN') {
                                status = '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100">' + status + '</span>';
                            } else if (status === 'OK') {
                                status = '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100">' + status + '</span>';
                            } else if (status === 'TRANSAKSI TIDAK DITEMUKAN') {
                                status = '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100">' + status + '</span>';
                            }

                            var row = '<tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">' +
                                '<th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">' +
                                invoiceNumber +
                                '</th>' +
                                '<td class="px-6 text-center py-4">' +
                                status +
                                '</td>' +
                                '</tr>';

                            transactionsCheck.append(row);
                        });

                        var message = $('#message');
                        message.html(
                            '<span class="text-sm text-gray-900 font-semibold text-center ">' +
                            error +
                            '</span>'
                        );

                        var total = $('#amount');
                        if (voucher === null) {
                            total.html('');
                            return;
                        } else {
                            total.html(
                                '<span class="text-lg text-green-800 font-semibold text-center ">' +
                                'Anda Mendapatkan Voucher Senilai: Rp ' + parseFloat(amount).toLocaleString('id-ID') +
                                '</span>'
                            );

                            var lihatDetailVoucher = $('#lihat-detail-voucher');
                            lihatDetailVoucher.attr('href', '/tenants/' + voucher.tenant_id + '/vouchers/' + voucher.id);
                            lihatDetailVoucher.removeClass('hidden');
                        }
                    }
                });
            });
        });
    </script>
</x-app-layout>
