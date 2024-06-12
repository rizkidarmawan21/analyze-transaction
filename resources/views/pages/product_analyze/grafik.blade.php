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
            Grafik Analisis
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
                        <div class="flex gap-5 w-full my-5">
                            <div class="flex-grow">
                                <h1 class="font-bold">
                                    Patterns
                                </h1>
                                <canvas id="medicalItemsChart"></canvas>
                            </div>
                            <div class="w-[35%]">
                                <h1 class="font-bold">
                                    Top Product 10
                                </h1>
                                <canvas id="medicalItemsChartDonat"></canvas>
                            </div>
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


        document.addEventListener('DOMContentLoaded', function() {
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

        document.addEventListener('DOMContentLoaded', function() {
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
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('newCharts').getContext('2d');

            const labels = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII', 'XIII', 'XIV',
                'XV', 'XVI'
            ];
            const datasets = [{
                    label: 'Thn 2022',
                    data: [532, 337, 789, 1354, 800, 948, 1293, 302, 740, 507, 211, 98, 275, 41, 116, 170],
                    borderColor: 'rgba(255, 99, 132, 1)',
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    fill: false,
                    lineTension: 0.1
                },
                {
                    label: 'Thn 2023',
                    data: [373, 350, 681, 1233, 742, 675, 512, 255, 115, 318, 98, 74, 147, 18, 123, 312],
                    borderColor: 'rgba(54, 162, 235, 1)',
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    fill: false,
                    lineTension: 0.1
                },
                {
                    label: 'Thn 2024',
                    data: [554, 574, 991, 1698, 987, 1321, 1800, 567, 1088, 826, 430, 123, 397, 129, 183, 312],
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    fill: false,
                    lineTension: 0.1
                }
            ];

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
                        display: true,
                        text: 'DRTPM 2024'
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
                                                    <td class="py-2 px-4 border-b border-gray-200 text-xs">${dataset.label}</td>
                                                    ${dataset.data.map(dataPoint => `<td class="py-1 px-2 border-b border-gray-200 text-xs">${dataPoint}</td>`).join('')}
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
