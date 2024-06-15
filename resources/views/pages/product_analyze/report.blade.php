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
            Report
        </h2>
        <div
            class="rounded-sm border border-stroke bg-white px-5 py-6 shadow-default dark:border-strokedark dark:bg-boxdark sm:px-7.5">

            <div class="max-w-full overflow-x-auto">
                <div class="mb-10">
                    {{-- Filter Year Start & End --}}

                    @php
                        // start today year - 10
                        $startYear = date('Y') - 20;
                        $endYear = date('Y');

                        // loop to get the year
                        $years = [];
                        for ($i = $startYear; $i <= $endYear; $i++) {
                            $years[] = $i;
                        }
                    @endphp

                    <h1 class="font-bold text-xl">
                        Filter
                    </h1>
                    <div class="">
                        <form class="mt-2 gap-3 bg-slate-200/25 p-2 inline-flex rounded-lg" action=""
                            method="get">
                            <div class="flex items-center space-x-4">
                                <label for="start_year"
                                    class="text-sm font-medium text-gray-700 dark:text-gray-300">Year
                                    Start</label>
                                <select name="start_year" id="start_year" required
                                    class="w-32 px-4 py-1 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-primary focus:border-primary dark:bg-boxdark dark:border-strokedark dark:text-gray-300">
                                    <option value="">Pilih Tahun</option>
                                    @foreach ($years as $year)
                                        <option value="{{ $year }}" @selected($startYearSelected == $year)>
                                            {{ $year }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="flex items-center space-x-4">
                                <label for="end_year" class="text-sm font-medium text-gray-700 dark:text-gray-300">Year
                                    End</label>
                                <select name="end_year" id="end_year" required
                                    class="w-32 px-4 py-1 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-primary focus:border-primary dark:bg-boxdark dark:border-strokedark dark:text-gray-300">
                                    <option value="">Pilih Tahun</option>
                                    @foreach ($years as $year)
                                        <option value="{{ $year }}" @selected($endYearSelected == $year)>
                                            {{ $year }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="flex items-center space-x-4">
                                <button
                                    class="px-4 py-1 bg-primary text-white rounded-md focus:outline-none focus:ring focus:ring-primary focus:border-primary hover:bg-primary/60">Filter</button>
                            </div>
                        </form>
                    </div>


                    @if ($result)
                        <div class="my-5">
                            <h1 class="font-bold">Top 10 Product Sales By Year</h1>

                            <div>
                                <table class="mt-3 table-auto">
                                    <tr class="bg-slate-100/25">
                                        <th class="border text-sm border-[#eee] px-4 py-1 dark:border-strokedark ">No
                                        </th>
                                        @foreach ($dataWithFrequency as $item)
                                            <th class="border text-sm border-[#eee] px-4 py-1 dark:border-strokedark"
                                                colspan="2">{{ $item['year'] }}</th>
                                        @endforeach
                                    </tr>

                                    @php
                                        $maxItems = max(
                                            array_map('count', array_column($dataWithFrequency, 'frequent')),
                                        );
                                    @endphp

                                    @for ($i = 0; $i < $maxItems; $i++)
                                        <tr>
                                            <td class="border text-sm border-[#eee] px-4 py-1 dark:border-strokedark ">
                                                {{ $i + 1 }}</td>
                                            @foreach ($dataWithFrequency as $item)
                                                @php
                                                    $keys = array_keys($item['frequent']);
                                                    $key = $keys[$i] ?? null;
                                                    $data = $item['frequent'][$key] ?? null;
                                                @endphp
                                                <td
                                                    class="border text-sm border-[#eee] px-4 py-1 dark:border-strokedark ">
                                                    {{ $key }}
                                                </td>
                                                <td
                                                    class="border text-sm border-[#eee] px-4 py-1 dark:border-strokedark ">
                                                    {{ $data }}
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endfor
                                </table>
                            </div>
                        </div>
                    @endif
                </div>

                @if ($result)
                    <div class="w-[100%]">
                        <h1 class="font-bold">
                            Top Sales by Year
                        </h1>
                        <div class="max-w-full mx-auto bg-white p-4 rounded-lg shadow-md">
                            <canvas id="newCharts"></canvas>
                            <div id="dataTableContainer" class="mt-4 overflow-x-auto"></div>
                        </div>
                    </div>
                @else
                    <div class="mt-20">
                        <p class="text-center text-lg">
                            Tidak ada data transaksi pada rentang tahun yang dipilih
                        </p>

                    </div>
                @endif

            </div>
        </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const ctx = document.getElementById('newCharts').getContext('2d');

            // const labels = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII', 'XIII', 'XIV',
            //     'XV', 'XVI'
            // ];
            const labels = @json(array_values($labels))
            // const datasets = [{
            //         label: 'Thn 2022',
            //         data: [532, 337, 789, 1354, 800, 948, 1293, 302, 740, 507, 211, 98, 275, 41, 116, 170],
            //         borderColor: 'rgba(255, 99, 132, 1)',
            //         backgroundColor: 'rgba(255, 99, 132, 0.2)',
            //         fill: false,
            //         lineTension: 0.1
            //     },
            //     {
            //         label: 'Thn 2023',
            //         data: [373, 350, 681, 1233, 742, 675, 512, 255, 115, 318, 98, 74, 147, 18, 123, 312],
            //         borderColor: 'rgba(54, 162, 235, 1)',
            //         backgroundColor: 'rgba(54, 162, 235, 0.2)',
            //         fill: false,
            //         lineTension: 0.1
            //     },
            //     {
            //         label: 'Thn 2024',
            //         data: [554, 574, 991, 1698, 987, 1321, 1800, 567, 1088, 826, 430, 123, 397, 129, 183, 312],
            //         borderColor: 'rgba(75, 192, 192, 1)',
            //         backgroundColor: 'rgba(75, 192, 192, 0.2)',
            //         fill: false,
            //         lineTension: 0.1
            //     }
            // ];
            const datasets = @json(array_values($result));

            const data = {
                labels: labels,
                datasets: datasets
            };

            const options = {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: false,
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            };

            const myChart = new Chart(ctx, {
                type: 'line',
                data: data,
                options: options
            });

            // Function to create the data table
            // function createDataTable(datasets, labels) {
            //     let tableHtml = '<table class="data-table"><thead><tr><th>Thn</th>';
            //     labels.forEach(label => {
            //         tableHtml += `<th>${label}</th>`;
            //     });
            //     tableHtml += '</tr></thead><tbody>';

            //     datasets.forEach(dataset => {
            //         tableHtml += `<tr><td>${dataset.label}</td>`;
            //         dataset.data.forEach(dataPoint => {
            //             tableHtml += `<td>${dataPoint}</td>`;
            //         });
            //         tableHtml += '</tr>';
            //     });

            //     tableHtml += '</tbody></table>';
            //     document.getElementById('dataTableContainer').innerHTML = tableHtml;
            // }

            function createDataTable(datasets, labels) {
                let tableHtml = `
                        <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="py-1 px-2 border-b border-gray-200 text-xs">Thn</th>
                                    ${labels.map(label => `<th class="py-1 px-2 border-b border-gray-200 text-xs">${label}</th>`).join('')}
                                </tr>
                            </thead>
                            <tbody>
                                ${datasets.map(dataset => `
                                                                                                                                                                                                                <tr>
                                                                                                                                                                                                                    <td class="py-2 px-4 border-b border-gray-200 text-xs text-center">${dataset.label}</td>
                                                                                                                                                                                                                    ${dataset.data.map(dataPoint => `<td class="py-1 px-2 border-b border-gray-200 text-xs text-center">${dataPoint}</td>`).join('')}
                                                                                                                                                                                                                </tr>
                                                                                                                                                                                                            `).join('')}
                            </tbody>
                        </table>
                    `;
                document.getElementById('dataTableContainer').innerHTML = tableHtml;
            }

            // Create the data table
            createDataTable(datasets, labels);


        });
    </script>
</x-app-layout>
