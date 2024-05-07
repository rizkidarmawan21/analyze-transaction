<x-app-layout>
    <div x-data="{
        modalCreate: false,
        confirmDesc: 'Are you sure you want to delete this data?',
        confirmMethod: 'DELETE',
        confirmUrl: '',
    }">
        <h2 class="flex items-center mb-5 text-3xl font-medium">
            Dataset Management
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mx-2 fill-current"
                viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                <path
                    d="M470.6 278.6c12.5-12.5 12.5-32.8 0-45.3l-160-160c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L402.7 256 265.4 393.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0l160-160zm-352 160l160-160c12.5-12.5 12.5-32.8 0-45.3l-160-160c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L210.7 256 73.4 393.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0z" />
            </svg>
            Show
        </h2>
        <div
            class="rounded-sm border border-stroke bg-white px-5 py-6 shadow-default dark:border-strokedark dark:bg-boxdark sm:px-7.5">

            <div class="max-w-full overflow-x-auto">
                <div>
                    <div class="flex justify-between mb-5">
                        <a href="{{ route('datasets.index') }}"
                            class="px-5 py-2 text-sm font-medium text-white transition border rounded-full cursor-pointer border-primary bg-primary hover:bg-opacity-90">
                            Back
                        </a>
                    </div>
                </div>
                <div class="my-5">
                    <h1 class="text-2xl">
                        Total Data : {{ $dataset->transactions->count() }}
                    </h1>
                </div>
                <table class="w-full table-auto">
                    <thead>
                        <tr class="text-left bg-slate-100 dark:bg-meta-4">
                            <th class="w-10 px-4 py-4 font-medium text-black dark:text-white xl:pl-11">
                                No
                            </th>
                            <th class="min-w-[100px] px-4 py-4 font-medium text-black dark:text-white">
                                ID Transaction
                            </th>
                            <th class="min-w-[100px] px-4 py-4 font-medium text-black dark:text-white">
                                Date
                            </th>
                            <th class="min-w-[100px] px-4 py-4 font-medium text-black dark:text-white">
                                Customer Name
                            </th>
                            <th class="min-w-[100px] px-4 py-4 font-medium text-black dark:text-white">
                                Items
                            </th>
                            <th class="min-w-[100px] px-4 py-4 font-medium text-black dark:text-white">
                                Total Price
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transactions as $transaction)
                            <tr class="bg-slate-100/25">
                                <td class="border border-[#eee] px-4 py-2 pl-9 dark:border-strokedark xl:pl-11">
                                    <h5 class="font-medium text-black dark:text-white">
                                        {{ $loop->iteration }}
                                    </h5>
                                </td>
                                <td class="border border-[#eee] px-4 py-2 dark:border-strokedark">
                                    <p class="text-black dark:text-white">
                                        {{ $transaction->no_transaction }}
                                    </p>
                                </td>
                                <td class="border border-[#eee] px-4 py-2 dark:border-strokedark">
                                    <p class="text-black dark:text-white">
                                        {{ $transaction->transaction_date }}
                                    </p>
                                </td>
                                <td class="border border-[#eee] px-4 py-5 dark:border-strokedark">
                                    <p class="text-black dark:text-white">
                                        {{ $transaction->customer_name }}
                                    </p>
                                </td>
                                <td class="border border-[#eee] px-4 py-5 dark:border-strokedark">
                                    {{-- table of product  name product,qty,price --}}
                                    <table class="w-full border">
                                        <thead>
                                            <tr>
                                                <th
                                                    class="border border-[#eee] text-left px-2 py-1 font-medium text-black dark:text-white">
                                                    No
                                                </th>
                                                <th
                                                    class="border border-[#eee] text-left px-2 py-1 font-medium text-black dark:text-white">
                                                    Name
                                                </th>
                                                <th
                                                    class="border border-[#eee] text-left px-2 py-1 font-medium text-black dark:text-white">
                                                    Qty
                                                </th>
                                                <th
                                                    class="border border-[#eee] text-left px-2 py-1 font-medium text-black dark:text-white">
                                                    Price
                                                </th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach ($transaction->details as $detail)
                                                <tr>
                                                    <td class="border border-[#eee] px-2 py-2 dark:border-strokedark">
                                                        <p class="text-black dark:text-white">
                                                            {{ $loop->iteration }}
                                                        </p>
                                                    </td>
                                                    <td class="border border-[#eee] px-2 py-2 dark:border-strokedark">
                                                        <p class="text-black dark:text-white">
                                                            {{ $detail->product_name }}
                                                        </p>
                                                    </td>
                                                    <td class="border border-[#eee] px-2 py-2 dark:border-strokedark">
                                                        <p class="text-black dark:text-white">
                                                            {{ $detail->quantity }}
                                                        </p>
                                                    </td>
                                                    <td class="border border-[#eee] px-2 py-2 dark:border-strokedark">
                                                        <p class="text-black dark:text-white">
                                                            {{ $detail->price }}
                                                        </p>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </td>
                                <td class="border border-[#eee] px-4 py-5 dark:border-strokedark">
                                    <p class="text-black dark:text-white">
                                        400.000
                                    </p>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-5">
                    {{ $transactions->links() }}

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
