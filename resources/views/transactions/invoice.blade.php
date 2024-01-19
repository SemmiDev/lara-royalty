<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
            href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,600;1,700&display=swap"
            rel="stylesheet">


    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #FFFFFF;
        }
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="text-gray-900 antialiased">

<div>
    @php(\Carbon\Carbon::setLocale('id'))

    <div class="max-w-4xl w-full mx-auto mt-8 p-8 rounded shadow">
        <div class="flex justify-between">
            <h1 class="text-[#02AF81] font-semibold text-2xl">
                {{config('app.name')}}
            </h1>
            <div>
                <h1 class="font-semibold text-2xl">
                    INVOICE
                </h1>
                <span class="text-[#02AF81] text-sm font-semibold">
                    {{$transaction->invoice_number}}
                </span>
            </div>
        </div>

        <div class="flex justify-between mt-5">
            <div>
                <h1 class="uppercase font-semibold text-lg">
                    DITERBITKAN ATAS NAMA
                </h1>
                <span class="text-sm">
                    Penjual: <span class="font-semibold"> {{$tenant->name}} </span>
                </span>
            </div>
            <div>
                <h1 class="uppercase font-semibold text-lg">
                    UNTUK
                </h1>
                <table>
                    <tr>
                        <td class="text-sm w-48">Pembeli</td>
                        <td class="font-semibold text-sm">: {{$transaction->customer->name}} </td>
                    </tr>
                    <tr>
                        <td class="text-sm">Tanggal Pembelian</td>
                        <td class="font-semibold text-sm">:
                            {{\Carbon\Carbon::parse($transaction->created_at)->isoFormat('dddd, D MMMM Y')}}
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="relative mt-7 overflow-x-auto">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        NAMA PRODUK
                    </th>
                    <th scope="col" class="px-6 py-3">
                        HARGA
                    </th>
                    <th scope="col" class="px-6 py-3">
                        JUMLAH
                    </th>
                    <th scope="col" class="px-6 py-3">
                        TOTAL HARGA
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach($transactionDetails as $tx)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{$tx->product_name}}
                        </th>
                        <td class="px-6 py-4">
                            {{'Rp. ' . number_format($tx->unit_price, 0, ',', '.')}}
                        </td>
                        <td class="px-6 py-4">
                            {{$tx->quantity}}
                        </td>
                        <td class="px-6 py-4">
                            {{'Rp. ' . number_format($tx->unit_price * $tx->quantity, 0, ',', '.')}}
                        </td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr class="bg-white font-bold border-b dark:bg-gray-800 dark:border-gray-700">
                    <th scope="row"
                        colspan="3"
                        class="px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                        TOTAL BELANJA
                    </th>

                    <td class="px-6 py-4 text-[#02AF81]">
                        {{'Rp. ' . number_format($transaction->amount, 0, ',', '.')}}
                        @if($transactionDetails->sum(function ($tx) { return $tx->unit_price * $tx->quantity; }) > $transaction->amount) (+1 Voucher)
                        @endif
                    </td>
                </tfoot>
            </table>
        </div>

        <div class="flex justify-end mt-5">
            <button
                id="print"
                class="bg-[#02AF81] text-white px-4 py-2 rounded-md hover:bg-[#02AF81] hover:text-white transition duration-300">
                Cetak
            </button>
        </div>
    </div>
</div>
<script>
    document.getElementById('print').addEventListener('click', function () {
        // remove button
        this.remove();
        window.print();
    })
</script>
</body>
</html>
