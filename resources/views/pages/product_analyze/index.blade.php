<x-app-layout>

    {{-- Loading Screen --}}
    <div x-data="{ isLoading: true }" x-init="setTimeout(() => { isLoading = false }, 2000);">
        <div x-show="isLoading"
            class="fixed inset-0 flex flex-col items-center justify-center text-2xl  bg-black bg-opacity-95 transition-opacity">
            <div class="h-16 w-16 animate-spin rounded-full border-4 border-solid border-primary border-t-transparent">
            </div>
            <div class="text-center mt-3">
                <label for="" class="text-white">
                    Loading...
                </label>
                <p class="text-white text-base">
                    Menunggu hasil analisis data
                </p>
            </div>
        </div>


    </div>

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
                    <div class="mb-5">
                        <select name="" id="" x-data
                            x-on:change="window.location.href = '?dataset_id=' + $event.target.value"
                            class="rounded-lg border border-stroke bg-transparent pl-6 pr-10 outline-none focus:border-primary focus-visible:shadow-none dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary !py-2 !px-3 w-1/4">
                            <option value="">-- Pilih Dataset --</option>
                            @foreach ($listDataset as $item)
                                <option value="{{ $item->id }}" @selected($dataset->id == $item->id)>{{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                @if ($dataset)
                    <div>
                        <div class="my-5">
                            <h1 class="mt-10 text-xl">
                                Dataset :
                            </h1>
                            <table class="mt-3 table-auto">
                                <tr class="bg-slate-100/25">
                                    <td class="border text-sm border-[#eee] px-4 py-1 dark:border-strokedark ">
                                        Dataset Name :
                                    </td>
                                    <td class="border text-sm border-[#eee] px-4 py-1 dark:border-strokedark ">
                                        {{ $dataset->name }}
                                    </td>
                                </tr>
                                <tr class="bg-slate-100/25">
                                    <td class="border text-sm border-[#eee] px-4 py-1 dark:border-strokedark ">
                                        Created By
                                    </td>
                                    <td class="border text-sm border-[#eee] px-4 py-1 dark:border-strokedark ">
                                        {{ $dataset->user->name }}
                                    </td>
                                </tr>
                                <tr class="bg-slate-100/25">
                                    <td class="border text-sm border-[#eee] px-4 py-1 dark:border-strokedark ">
                                        Created At
                                    </td>
                                    <td class="border text-sm border-[#eee] px-4 py-1 dark:border-strokedark ">
                                        {{ $dataset->created_at }}
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="grid grid-cols-2">
                            <div class="col-span-2">
                                <div class="mb-5">
                                    <h1 class="mt-10 text-xl">
                                        Produk Terlaris :
                                    </h1>
                                    <table class="mt-3 table-auto">
                                        <tr class="bg-slate-100/25">
                                            <th class="border text-sm border-[#eee] px-4 py-1 dark:border-strokedark ">
                                                No
                                            </th>
                                            <th class="border text-sm border-[#eee] px-4 py-1 dark:border-strokedark ">
                                                Product
                                            </th>
                                            <th class="border text-sm border-[#eee] px-4 py-1 dark:border-strokedark ">
                                                Qty
                                            </th>
                                        </tr>
                                        @foreach ($output['frequent_1'] as $key => $item)
                                            <tr class="bg-slate-100/25">
                                                <td
                                                    class="border text-sm border-[#eee] px-4 py-1 dark:border-strokedark ">
                                                    {{ $loop->iteration }}
                                                </td>
                                                <td
                                                    class="border text-sm border-[#eee] px-4 py-1 dark:border-strokedark ">
                                                    {{ mb_convert_case($key, MB_CASE_TITLE, 'UTF-8') }}
                                                </td>
                                                <td
                                                    class="border text-sm border-[#eee] px-4 py-1 dark:border-strokedark ">
                                                    {{ mb_convert_case($item, MB_CASE_TITLE, 'UTF-8') }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                            </div>
                            <div class="col-span-2 flex gap-10">
                                <div class="mb-5">
                                    <h1 class="mt-10 text-xl">
                                        10 Produk Terlaris :
                                    </h1>
                                    <table class="mt-3 table-auto">
                                        <tr class="bg-slate-100/25">
                                            <th class="border text-sm border-[#eee] px-4 py-1 dark:border-strokedark ">
                                                No
                                            </th>
                                            <th class="border text-sm border-[#eee] px-4 py-1 dark:border-strokedark ">
                                                Product
                                            </th>
                                            <th class="border text-sm border-[#eee] px-4 py-1 dark:border-strokedark ">
                                                Qty
                                            </th>
                                        </tr>
                                        @foreach ($output['frequent'] as $key => $item)
                                            <tr class="bg-slate-100/25">
                                                <td
                                                    class="border text-sm border-[#eee] px-4 py-1 dark:border-strokedark ">
                                                    {{ $loop->iteration }}
                                                </td>
                                                <td
                                                    class="border text-sm border-[#eee] px-4 py-1 dark:border-strokedark">
                                                    {{ mb_convert_case($key, MB_CASE_TITLE, 'UTF-8') }}
                                                </td>
                                                <td
                                                    class="border text-sm border-[#eee] px-4 py-1 dark:border-strokedark">
                                                    {{ mb_convert_case($item, MB_CASE_TITLE, 'UTF-8') }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                                <div class="mb-5" x-data="{ page: 1, perPage: 10, items: {{ json_encode($output['patterns']) }} }">
                                    <h1 class="mt-10 text-xl">
                                        Patterns :
                                    </h1>
                                    <table class="mt-3 table-auto">
                                        <tr class="bg-slate-100/25">
                                            <th class="border text-sm border-[#eee] px-4 py-1 dark:border-strokedark ">
                                                No
                                            </th>
                                            <th class="border text-sm border-[#eee] px-4 py-1 dark:border-strokedark ">
                                                Products
                                            </th>
                                            <th class="border text-sm border-[#eee] px-4 py-1 dark:border-strokedark ">
                                                Qty
                                            </th>
                                        </tr>
                                        <template
                                            x-for="(item, index) in Object.entries(items).slice((page - 1) * perPage, page * perPage)"
                                            :key="index">
                                            <tr class="bg-slate-100/25">
                                                <td class="border text-sm border-[#eee] px-4 py-1 dark:border-strokedark"
                                                    x-text="index + 1"></td>
                                                <td class="border text-sm border-[#eee] px-4 py-1 dark:border-strokedark"
                                                    x-text="item[0]"></td>
                                                <td class="border text-sm border-[#eee] px-4 py-1 dark:border-strokedark"
                                                    x-text="item[1]"></td>
                                            </tr>
                                        </template>
                                    </table>
                                    <div class="flex justify-start mt-2">
                                        <button
                                            class="text-xs px-2 py-1 bg-blue-500 text-white rounded hover:bg-blue-700 disabled:opacity-50"
                                            :disabled="page <= 1" @click="page > 1 ? page-- : null">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"
                                                class="w-3 h-3 fill-current">
                                                <path
                                                    d="M41.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.3 256 246.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z" />
                                            </svg>
                                        </button>
                                        <button class="text-xs px-2 py-1 mx-2 bg-slate-200 text-black rounded"
                                            x-text="page">
                                        </button>
                                        <button
                                            class="text-xs px-2 py-1 bg-blue-500 text-white rounded hover:bg-blue-700 disabled:opacity-50"
                                            :disabled="page >= Math.ceil(Object.keys(items).length / perPage)"
                                            @click="page < Math.ceil(Object.keys(items).length / perPage) ? page++ : null">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"
                                                class="w-3 h-3 fill-current">
                                                <path
                                                    d="M278.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-160 160c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L210.7 256 73.4 118.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l160 160z" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-5">
                            <h1 class="mt-10 text-xl">
                                Rules :
                            </h1>
                            <table class="mt-3 table-auto">
                                <tr class="bg-slate-100/25">
                                    <th class="border text-sm border-[#eee] px-4 py-1 dark:border-strokedark ">
                                        No
                                    </th>
                                    <th class="border text-sm border-[#eee] px-4 py-1 dark:border-strokedark ">
                                        Products
                                    </th>
                                </tr>
                                @foreach ($output['rules'] as $item)
                                    <tr class="bg-slate-100/25">

                                        <td class="border text-sm border-[#eee] px-4 py-1 dark:border-strokedark ">
                                            {{ $loop->iteration }}
                                        </td>
                                        <td class="border text-sm border-[#eee] px-4 py-1 dark:border-strokedark ">
                                            {!! $item !!}
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                @else
                    <div class="mt-20">
                        <p class="text-center text-lg">
                            Data tidak ditemukan, anda belum memiliki dataset transaksi untuk dianalisis <br>
                            <a href="{{ route('datasets.index') }}" class="text-sky-400 hover:text-sky-600">
                                Silahkan import dataset
                            </a>
                        </p>

                    </div>
                @endif

            </div>
        </div>
    </div>


    <script>
        const labelsPattern = @json(array_keys($output['patterns']));
        const dataPattern = @json(array_values($output['patterns']));

        const labelTop10 = @json(array_keys($output['frequent']));
        const dataTop10 = @json(array_values($output['frequent']));
    

        document.addEventListener('DOMContentLoaded', function () {
            var ctx = document.getElementById('medicalItemsChart').getContext('2d');
            var medicalItemsChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labelsPattern,
                    datasets: [{
                        label: 'Patterns',
                        data: dataPattern,
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                // options: {
                //     scales: {
                //         y: {
                //             beginAtZero: true
                //         }
                //     }
                // }
                options: {
                            indexAxis: 'y',
                            scales: {
                                x: {
                                    beginAtZero: true
                                }
                            }
                        }
            });
        });

        document.addEventListener('DOMContentLoaded', function () {
            var ctx = document.getElementById('medicalItemsChartDonat').getContext('2d');
            var medicalItemsChartDonat = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: labelTop10,
                    datasets: [{
                        label: 'Quantity',
                        data: dataTop10,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)',
                            'rgba(201, 203, 207, 0.2)',
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)',
                            'rgba(201, 203, 207, 1)',
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            enabled: true
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>
