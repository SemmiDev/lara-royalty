<x-app-layout>
    <div class="max-w-md mx-auto bg-white p-8 mt-12 rounded-lg shadow-md">
        <div class="flex justify-end mb-5">
            <button
                id="print"
                class="bg-[#02AF81] text-white px-4 py-2 rounded-md hover:bg-[#02AF81] hover:text-white transition duration-300">
                Cetak
            </button>
        </div>
        <h2 class="text-2xl font-semibold mb-4 text-gray-800">Voucher Eksklusif Anda</h2>

        <p class="text-gray-600 mb-4">
            Terima kasih karena sudah menjadi pelanggan setia! Tunjukkan voucher ini untuk menikmati keuntungan spesial.
        </p>

        <div class="bg-gray-100 p-4 rounded-md mb-4">
            <p class="text-lg font-semibold text-green-700">Kode Voucher:</p>
            <p class="text-2xl font-bold">
                {{$voucher->code}}
            </p>
        </div>

        <div class="flex justify-between items-center bg-gray-200 p-4 rounded-md">
            <p class="text-lg font-semibold text-gray-800">Berakhir dalam:</p>
            <p class="text-xl font-bold text-red-600">
                @php
                    $now = \Carbon\Carbon::now();
                    $expired = \Carbon\Carbon::parse($voucher->expired_at);
                    $diff = $now->diffInDays($expired);
                @endphp

                @if($voucher->is_redeemed)
                    0 Hari
                @else
                    {{$diff}} Hari
                @endif
            </p>
        </div>

        <div class="mt-4">
            <p class="text-gray-600">
                Syarat dan Ketentuan:
            </p>
            <ul class="list-disc pl-6 mt-2">
                <li>Voucher ini hanya dapat digunakan sekali.</li>
                <li>Berlaku selama
                    <span class="font-semibold">3 bulan</span>
                    sejak tanggal penerbitan.</li>
                <li>Berlaku untuk toko
                    <span class="font-semibold">
                        {{$voucher->tenant->name}}
                    </span>.</li>
            </ul>
        </div>

        @php(\Carbon\Carbon::setLocale('id'))
        @if($voucher->is_redeemed)
            <span class="text-sm text-red-600 text-justify mt-5">
                Voucher ini telah digunakan pada
                <span class="font-semibold">
                    {{\Carbon\Carbon::parse($voucher->redeemed_at)->isoFormat('dddd, D MMMM Y')}}
                </span>
            </span>
        @endif
    </div>

    <script>
        document.getElementById('print').addEventListener('click', function () {
            this.remove();
            document.getElementById('navigation').remove();
            window.print();
        })
    </script>
</x-app-layout>
