<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Redeem Voucher
            </h2>
        </div>
    </x-slot>

    <div class="py-6">
        <form
            action="{{route('vouchers.redeemVoucher', $tenant)}}"
            method="POST"
            class="w-full max-w-4xl mx-auto p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-6 md:p-8 dark:bg-gray-800 dark:border-gray-700">
            @csrf
            <h5 class="text-xl font-medium text-gray-900 dark:text-white">Masukkan kode voucher</h5>
            <div class="mt-5">
                <input type="text"
                       placeholder="Kode Voucher"
                       required
                       autofocus
                       autocomplete="off"
                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                       name="code">
            </div>

            <button type="submit"
                    class="focus:outline-none w-fit mt-5 text-white bg-[#02AF81] hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                Redeem
            </button>
        </form>
    </div>
</x-app-layout>
