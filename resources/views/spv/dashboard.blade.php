@extends('layout.app')

@section('content')
    {{-- <div class="row">
        <div class="col-4 mb-4">
            <div class="card">
                <div class="card-body d-flex justify-content-between">
                    <div class="me-2">
                        <span class="fw-semibold d-block mb-1">Profit</span>
                        <h3 class="card-title mb-2">$12,628</h3>
                    </div>
                    <div class="card-title d-flex align-items-center justify-content-center">
                        <div class="avatar flex-shrink-0">
                            <img src="../assets/img/icons/unicons/chart-success.png" alt="chart success" class="rounded" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-4 mb-4">
            <div class="card">
                <div class="card-body d-flex justify-content-between">
                    <div class="me-2">
                        <span class="fw-semibold d-block mb-1">Profit</span>
                        <h3 class="card-title mb-2">$12,628</h3>
                    </div>
                    <div class="card-title d-flex align-items-center justify-content-center">
                        <div class="avatar flex-shrink-0">
                            <img src="../assets/img/icons/unicons/chart-success.png" alt="chart success" class="rounded" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-4 mb-4">
            <div class="card">
                <div class="card-body d-flex justify-content-between">
                    <div class="me-2">
                        <span class="fw-semibold d-block mb-1">Profit</span>
                        <h3 class="card-title mb-2">$12,628</h3>
                    </div>
                    <div class="card-title d-flex align-items-center justify-content-center">
                        <div class="avatar flex-shrink-0">
                            <img src="../assets/img/icons/unicons/chart-success.png" alt="chart success" class="rounded" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <div class="card w-100">
        <div class="card-header">
            <h5>Sales Overview</h5>
        </div>
        <div class="card-body">
            <div id="chart" style="height: 40px"></div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-5">
                    <h5>Detail History Barang</h5>
                </div>
                <div class="col-sm-7">
                    <div class="d-flex justify-content-end text-end">
                        <button type="button" class="btn btn-sm btn-success d-flex align-items-center" id="exportBtn">
                            <i class="ti ti-file-export me-1"></i>
                            Export Excel
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table table-striped w-100" id="dataDetailBarang">
                    <thead>
                        <tr class="text-center">
                            <th colspan="3"></th>
                            <th colspan="2">Week 1</th>
                            <th colspan="2">Week 2</th>
                            <th colspan="2">Week 3</th>
                            <th colspan="2">Week 4</th>
                            <th colspan="2">Week 5</th>
                        </tr>
                        <tr class="text-center">
                            <th style="width: 20px">No</th>
                            <th>Kode JS</th>
                            <th>Nama</th>
                            <th>In</th>
                            <th>Out</th>
                            <th>In</th>
                            <th>Out</th>
                            <th>In</th>
                            <th>Out</th>
                            <th>In</th>
                            <th>Out</th>
                            <th>In</th>
                            <th>Out</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="text-center">
                            <td>1</td>
                            <td>Tes</td>
                            <td>Tes</td>
                            <td>20</td>
                            <td>20</td>
                            <td>20</td>
                            <td>20</td>
                            <td>20</td>
                            <td>20</td>
                            <td>20</td>
                            <td>20</td>
                            <td>20</td>
                            <td>20</td>
                        </tr>
                        <tr class="text-center">
                            <td>2</td>
                            <td>Tes</td>
                            <td>Tes</td>
                            <td>20</td>
                            <td>20</td>
                            <td>20</td>
                            <td>20</td>
                            <td>20</td>
                            <td>20</td>
                            <td>20</td>
                            <td>20</td>
                            <td>20</td>
                            <td>20</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        $(function() {

            var chart = {
                chart: {
                    type: "area",
                    height: 280
                },
                colors: ["#00BAEC"],
                stroke: {
                    width: 3,
                    curve: "straight"
                },
                dataLabels: {
                    enabled: false

                },
                fill: {
                    gradient: {
                        enabled: true,
                        opacityFrom: 0.55,
                        opacityTo: 0
                    }
                },
                markers: {
                    size: 5,
                    colors: ["#fff"],
                    strokeColor: "#00BAEC",
                    strokeWidth: 3
                },
                series: [{
                    name: "Series 1",
                    data: [45, 52, 38, 45, 19, 23, 2, 30, 29, 28, 29, 19, 41, 45, 52, 38, 45, 19, 23, 2,
                        30, 29, 28, 29, 19, 41, 45, 52, 38, 45, 19
                    ]
                }],
                xaxis: {
                    categories: [
                        "01 Jan",
                        "02 Jan",
                        "03 Jan",
                        "04 Jan",
                        "05 Jan",
                        "06 Jan",
                        "07 Jan",
                        "08 Jan",
                        "09 Jan",
                        "10 Jan",
                        "11 Jan",
                        "12 Jan",
                        "13 Jan",
                        "14 Jan",
                        "15 Jan",
                        "16 Jan",
                        "17 Jan",
                        "18 Jan",
                        "19 Jan",
                        "20 Jan",
                        "21 Jan",
                        "22 Jan",
                        "23 Jan",
                        "24 Jan",
                        "25 Jan",
                        "26 Jan",
                        "27 Jan",
                        "28 Jan",
                        "29 Jan",
                        "30 Jan",
                        "31 Jan",
                    ]
                },
                yaxis: {
                    title: {
                        text: "Price($)"
                    }
                }
            };

            var chart = new ApexCharts(document.querySelector("#chart"), chart);
            chart.render();

            var chart2 = {
                chart: {
                    type: "bar",
                    height: 280
                },
                colors: ["#00BAEC"],
                stroke: {
                    width: 3,
                    curve: "straight"
                },
                dataLabels: {
                    enabled: false

                },
                fill: {
                    gradient: {
                        enabled: true,
                        opacityFrom: 0.55,
                        opacityTo: 0
                    }
                },
                markers: {
                    size: 5,
                    colors: ["#fff"],
                    strokeColor: "#00BAEC",
                    strokeWidth: 3
                },
                series: [{
                    name: "Series 1",
                    data: [45, 52, 38, 45, 19, 23, 2, 30, 29, 28, 29, 19, 41, 45, 52, 38, 45, 19, 23, 2,
                        30, 29, 28, 29, 19, 41, 45, 52, 38, 45, 19
                    ]
                }],
                xaxis: {
                    categories: [
                        "01 Jan",
                        "02 Jan",
                        "03 Jan",
                        "04 Jan",
                        "05 Jan",
                        "06 Jan",
                        "07 Jan",
                        "08 Jan",
                        "09 Jan",
                        "10 Jan",
                        "11 Jan",
                        "12 Jan",
                        "13 Jan",
                        "14 Jan",
                        "15 Jan",
                        "16 Jan",
                        "17 Jan",
                        "18 Jan",
                        "19 Jan",
                        "20 Jan",
                        "21 Jan",
                        "22 Jan",
                        "23 Jan",
                        "24 Jan",
                        "25 Jan",
                        "26 Jan",
                        "27 Jan",
                        "28 Jan",
                        "29 Jan",
                        "30 Jan",
                        "31 Jan",
                    ],
                },
                yaxis: {
                    title: {
                        text: "Price($)"
                    }
                }
            };

            var chart2 = new ApexCharts(document.querySelector("#chart2"), chart2);
            chart2.render();
        })
    </script>
@endsection
