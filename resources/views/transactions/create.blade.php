<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Buat Transaksi Baru
            </h2>
        </div>
    </x-slot>

    <div class="py-6">
        <form
            action="{{ route('transactions.store', $tenant) }}"
            method="POST"
            class="w-full max-w-4xl mx-auto p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-6 md:p-8 dark:bg-gray-800 dark:border-gray-700">
            @csrf
            <h5 class="text-xl font-medium text-gray-900 dark:text-white">Data Pelanggan dan Pembelian</h5>
            <div class="mt-5">
                <input list="customers"
                       placeholder="Masukkan nama pelanggan"
                       required
                       autofocus
                       autocomplete="off"
                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                       name="customer_name">
                <datalist id="customers">
                    @foreach($customers as $customer)
                        <option value="{{ $customer->name }}">
                    @endforeach
                </datalist>
            </div>

            <div class="mt-5 transaction-list flex flex-col gap-2">
                <div class="flex gap-4 items-end transaction-item">
                    <div>
                        <label for="product_name"
                               class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Produk</label>
                        <input type="text"
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-fit p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                               name="product_name[]"
                               autocomplete="off"
                               placeholder="Rexona">
                    </div>

                    <div>
                        <label for="product_price"
                               class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Harga</label>
                        <input type="number"
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-fit p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                               min="0" name="product_price[]" placeholder="25000">
                    </div>

                    <div>
                        <label for="product_quantity"
                               class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jumlah</label>
                        <input type="number"
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-fit p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                               min="1" name="product_quantity[]" placeholder="3">
                    </div>

                    <button type="button"
                            id="transaction-add"
                            class="text-white bg-gradient-to-r from-cyan-500 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-cyan-300 dark:focus:ring-cyan-800 font-medium rounded-lg text-sm px-5 py-3 text-center">
                        Tambah
                    </button>
                </div>
            </div>

            <hr class="h-px my-7 bg-gray-200 border-0 dark:bg-gray-700">

            <div class="flex flex-col gap-2">
                <h5 class="text-xl font-medium text-gray-900 dark:text-white">
                    Masukkan Voucher (jika ada)
                </h5>
                <input type="text"
                       id="voucher_code"
                       placeholder="Kode Voucher"
                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                       name="voucher_code">
            </div>

            <div class="flex flex-col mt-3 gap-2">
                <h5 class="text-xl font-medium text-gray-900 dark:text-white">Total Belanja</h5>
                <input type="number"
                       readonly
                       id="total_transaction"
                       placeholder="Total belanja akan otomatis muncul disini"
                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                       name="total_transaction">
            </div>

            <button type="submit"
                    class="focus:outline-none w-fit mt-5 text-white bg-[#02AF81] hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                Simpan Transaksi
            </button>

        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#transaction-add').click(function () {
                var transactionItem = $('.transaction-item').first().clone();
                transactionItem.find('#transaction-add').remove();
                transactionItem.find('input').val('');
                $('.transaction-list').append(transactionItem);
            });

            $(document).on('keyup', 'input[name="product_price[]"], input[name="product_quantity[]"]', function () {
                calculatePrice();
            });

            function calculatePrice() {
                var total = 0;
                $('.transaction-item').each(function () {
                    var price = $(this).find('input[name="product_price[]"]').val();
                    var quantity = $(this).find('input[name="product_quantity[]"]').val();
                    total += price * quantity;
                });
                $('#total_transaction').val(total);
            }
        });
    </script>
</x-app-layout>
