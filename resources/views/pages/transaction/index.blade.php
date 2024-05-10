<x-app-layout>
    <div x-data="{
        modalCreate: false,
        confirmDesc: 'Are you sure you want to delete this data?',
        confirmMethod: 'DELETE',
        confirmUrl: '',
    }">
        <h2 class="flex items-center mb-5 text-3xl font-medium">
            Transaction Data
        </h2>
        <div
            class="rounded-sm border border-stroke bg-white px-5 py-6 shadow-default dark:border-strokedark dark:bg-boxdark sm:px-7.5">

            <div class="max-w-full overflow-x-auto">
                <div>
                    <div class="flex justify-between mb-5">
                        <select name="" id="" x-data
                            x-on:change="window.location.href = '?dataset_id=' + $event.target.value"
                            class="rounded-lg border border-stroke bg-transparent pl-6 pr-10 outline-none focus:border-primary focus-visible:shadow-none dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary !py-2 !px-3 w-1/4">
                            <option value="">-- Pilih Dataset --</option>
                            @foreach ($listDataset as $item)
                                <option value="{{ $item->id }}" @selected($dataset->id == $item->id)>{{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                        <input type="text" placeholder="Search by name or number transaction"
                            class="w-1/4 rounded-full px-5 border-slate-400" x-data
                            x-on:keydown.enter="
                                const url = new URL(window.location.href);
                                url.searchParams.set('search', $event.target.value);
                                url.searchParams.delete('page');
                                window.location.href = url.href;
                            "
                            value="{{ request('search') }}">
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
                            {{-- <th class="min-w-[100px] px-4 py-4 font-medium text-black dark:text-white">
                                Total Price
                            </th> --}}
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
                                                <th
                                                    class="border border-[#eee] text-left px-2 py-1 font-medium text-black dark:text-white">
                                                    Sub Total
                                                </th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @php
                                                $total_price = 0;
                                            @endphp
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
                                                            {{ 'Rp ' . number_format($detail->price, 0, ',', '.') }}
                                                        </p>
                                                    </td>
                                                    <td class="border border-[#eee] px-2 py-2 dark:border-strokedark">
                                                        <p class="text-black dark:text-white">
                                                            {{-- quantity * price --}}
                                                            {{ 'Rp ' . number_format($detail->quantity * $detail->price, 0, ',', '.') }}
                                                        </p>
                                                    </td>
                                                </tr>

                                                @php
                                                    $total_price += $detail->quantity * $detail->price;
                                                @endphp
                                            @endforeach
                                        </tbody>
                                    </table>
                                </td>

                            </tr>
                            <tr class="bg-slate-100/25">
                                <td colspan="4" class="border border-[#eee] px-4 py-5 dark:border-strokedark">
                                    <p class="text-black font-semibold dark:text-white text-right">
                                        Total Price
                                    </p>
                                </td>
                                <td class="border border-[#eee] px-4 py-5 dark:border-strokedark">
                                    <p class="text-black font-semibold dark:text-white">
                                        {{ 'Rp ' . number_format($total_price, 0, ',', '.') }}
                                    </p>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-5">
                    {{ $transactions->appends(['search' => request('search'), 'dataset_id' => request('dataset_id')])->links() }}

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
