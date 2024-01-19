<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Riwayat Vouchers
            </h2>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="relative overflow-x-auto">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            No
                        </th>
                        <th scope="col" class="px-6 py-3">
                            KODE VOUCHER
                        </th>
                        <th scope="col" class="px-6 py-3">
                            REWARD
                        </th>
                        <th scope="col" class="px-6 py-3">
                            TERPAKAI
                        </th>
                        <th scope="col" class="px-6 py-3">
                        </th>
                    </tr>
                    </thead>
                    <tbody>

                    @php(\Carbon\Carbon::setLocale('id'))

                    @forelse($vouchers as $voucher)
                        <tr class="bg-white dark:bg-gray-800">
                            <th scope="row" class="px-6 py-4 whitespace-nowrap dark:text-white">
                                {{$loop->iteration}}
                            </th>
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{$voucher->code}}
                            </th>
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                Rp. {{number_format($voucher->amount, 2, ',', '.')}}
                            </th>
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{$voucher->is_redeemed ? 'Sudah' : 'Belum'}}
                            </th>
                            <td class="px-6 py-4">
                                <div class="gap-2 items-center flex">
                                    <a href="{{route('vouchers.show', [$tenant, $voucher])}}"
                                       class="focus:outline-none w-fit flex gap-2 items-center text-white bg-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:focus:ring-yellow-900">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                             stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z"/>
                                        </svg>
                                        Lihat Voucher
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr class="bg-white dark:bg-gray-800">
                            <th
                                colspan="4"
                                scope="row"
                                class="px-6 py-4 font-medium text-gray-700 whitespace-nowrap dark:text-white">
                                Belum ada voucher
                            </th>
                        </tr>
                    @endforelse
                    </tbody>

                    <tfoot>
                    <tr>
                        <td colspan="5">
                            <div class="mt-3">
                                {{ $vouchers->links() }}
                            </div>
                        </td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

</x-app-layout>

