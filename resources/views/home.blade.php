@extends('layouts.kai')
@section('page_title')
    Analytics Dashboard
@endsection

@section('content')
    <div class="row mb-4">
        <div class="col-12">
            <h5 class="text-muted text-center">Analytics Dashboard Period: 01 Jan {{ date('Y') }} – 31 Dec
                {{ date('Y') }}</h5>
        </div>
    </div>

    <div class="row mt-4">

        <div class="col-sm-6 col-md-3 mb-4">
            <div class="card card-stats card-round" style="background-color: #fd7e14; color: white;">
                <div class="card-body p-3">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="icon-big text-center icon-white bubble-shadow-small">
                                <i class="fas fa-exchange-alt"></i>
                            </div>
                        </div>
                        <div class="col col-stats ms-3 ms-sm-0">
                            <div class="numbers text-white">
                                <p class="card-category text-white op-8 mb-1" style="font-size: 0.85rem;">Total Transaksi
                                </p>
                                <h4 class="card-title mb-0" style="font-size: 1.1rem;">{{ number_format($totalItemsIn) }}
                                    Masuk</h4>
                                <h4 class="card-title mb-0" style="font-size: 1.1rem;">{{ number_format($totalItemsOut) }}
                                    Keluar</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-md-3 mb-4">
            <div class="card card-stats card-round" style="background-color: #1572e8; color: white;">
                <div class="card-body p-3">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="icon-big text-center icon-white bubble-shadow-small">
                                <i class="fas fa-money-bill-wave"></i>
                            </div>
                        </div>
                        <div class="col col-stats ms-3 ms-sm-0">
                            <div class="numbers text-white">
                                <p class="card-category text-white op-8 mb-1" style="font-size: 0.85rem;">Biaya Keluar</p>
                                <h4 class="card-title mb-0" style="font-size: 1.25rem;">Rp.
                                    {{ number_format($totalExpenses, 0, ',', '.') }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-md-3 mb-4">
            <div class="card card-stats card-round" style="background-color: #6861ce; color: white;">
                <div class="card-body p-3">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="icon-big text-center icon-white bubble-shadow-small">
                                <i class="fas fa-wallet"></i>
                            </div>
                        </div>
                        <div class="col col-stats ms-3 ms-sm-0">
                            <div class="numbers text-white">
                                <p class="card-category text-white op-8 mb-1" style="font-size: 0.85rem;">Biaya Diterima</p>
                                <h4 class="card-title mb-0" style="font-size: 1.25rem;">Rp.
                                    {{ number_format($totalRevenue, 0, ',', '.') }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-md-3 mb-4">
            <div class="card card-stats card-round" style="background-color: #31ce36; color: white;">
                <div class="card-body p-3">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="icon-big text-center icon-white bubble-shadow-small">
                                <i class="fas fa-chart-line"></i>
                            </div>
                        </div>
                        <div class="col col-stats ms-3 ms-sm-0">
                            <div class="numbers text-white">
                                <p class="card-category text-white op-8 mb-1" style="font-size: 0.85rem;">Margin</p>
                                <h4 class="card-title mb-0" style="font-size: 1.25rem;">Rp.
                                    {{ number_format($margin, 0, ',', '.') }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title justify-content-center text-center">Perbandingan Pendapatan dan Pengeluaran</div>
                </div>
                <div class="card-body">
                    @if ($hasIncomeExpenseData)
                        <div id="revenueExpenseChart"></div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-chart-bar fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Tidak ada data transaksi</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card card-stats card-round h-100">
                <div class="card-header" style="background-color: red; color: #721c24;">
                    <h4 class="card-title" style="color: white;">Produk dengan stok minimal</h4>
                    <p class="card-category" style="color: white;">Menampilkan produk dengan stok kurang dari 10 unit</p>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Produk</th>
                                    <th>Stok</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($lowStockProducts as $index => $item)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <div class="fw-bold">{{ optional($item->produk)->nama_produk ?? 'N/A' }}</div>
                                            <small class="text-muted">{{ $item->nama_varian }}</small>
                                        </td>
                                        <td>
                                            <span class="badge {{ $item->stok_varian <= 0 ? 'bg-black' : 'bg-warning' }}">
                                                {{ $item->stok_varian }} Unit
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">Tidak ada produk dengan stok minimal</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="text-center mt-3">
                        <a href="{{ route('master-data.stok-barang.index') }}" class="btn btn-outline-danger btn-sm">Lihat
                            Selengkapnya</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header" style="background-color: #31ce36; color: white;">
                    <h4 class="card-title text-white">Chart produk terlaris</h4>
                    <p class="card-category text-white ">Produk dengan transaksi terbanyak</p>
                </div>
                <div class="card-body">
                    @if ($hasBestSellingData)
                        <div id="bestSellingChart"></div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-shopping-basket fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Tidak ada data penjualan</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" style="background-color: #fd7e14; color: white;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="card-title text-white">Data Kenaikan Harga Produk</h4>
                            <p class="card-category text-white op-8">Konfirmasi segera</p>
                        </div>
                        <i class="fas fa-exclamation-circle text-white fa-2x"></i>
                    </div>
                </div>
                <div class="card-body">
                    @if ($hasPriceIncreaseData)
                        <div id="priceIncreaseChart"></div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-tag fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Tidak ada data kenaikan harga produk</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if ($hasIncomeExpenseData)
                var incomeData = @json($incomeData);
                var expenseData = @json($expenseData);

                var optionsRevenueExpense = {
                    series: [{
                        name: 'Pengeluaran',
                        type: 'column',
                        data: expenseData
                    }, {
                        name: 'Pendapatan',
                        type: 'line',
                        data: incomeData
                    }],
                    chart: {
                        height: 350,
                        type: 'line',
                        fontFamily: 'Nunito, sans-serif',
                        toolbar: {
                            show: false
                        }
                    },
                    colors: ['#fd7e14', '#31ce36'],
                    stroke: {
                        width: [0, 4],
                        curve: 'smooth'
                    },
                    plotOptions: {
                        bar: {
                            borderRadius: 4,
                            columnWidth: '40%'
                        }
                    },
                    dataLabels: {
                        enabled: false
                    },
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov',
                        'Dec'
                    ],
                    xaxis: {
                        type: 'category',
                        title: {
                            text: 'Bulan'
                        }
                    },
                    yaxis: [{
                        title: {
                            text: 'Pengeluaran',
                            style: {
                                color: '#fd7e14'
                            }
                        },
                        labels: {
                            formatter: function(value) {
                                return "Rp " + new Intl.NumberFormat('id-ID', {
                                    notation: "compact"
                                }).format(value);
                            }
                        }
                    }, {
                        opposite: true,
                        title: {
                            text: 'Pendapatan',
                            style: {
                                color: '#31ce36'
                            }
                        },
                        labels: {
                            formatter: function(value) {
                                return "Rp " + new Intl.NumberFormat('id-ID', {
                                    notation: "compact"
                                }).format(value);
                            }
                        }
                    }],
                    tooltip: {
                        y: {
                            formatter: function(val) {
                                return "Rp " + new Intl.NumberFormat('id-ID').format(val);
                            }
                        }
                    },
                    legend: {
                        position: 'top'
                    }
                };
                var chartRevExp = new ApexCharts(document.querySelector("#revenueExpenseChart"),
                    optionsRevenueExpense);
                chartRevExp.render();
            @endif

            @if ($hasBestSellingData)
                var bestSellingData = @json($bestSellingProducts);
                var bestSellingNames = bestSellingData.map(item => item.produk + ' ' + item.varian);
                var bestSellingQty = bestSellingData.map(item => item.total_qty);

                var optionsBestSelling = {
                    series: [{
                        name: 'Transaksi',
                        data: bestSellingQty
                    }],
                    chart: {
                        type: 'bar',
                        height: 350,
                        fontFamily: 'Nunito, sans-serif',
                        toolbar: {
                            show: false
                        }
                    },
                    colors: ['#20c997'],
                    plotOptions: {
                        bar: {
                            borderRadius: 4,
                            horizontal: true,
                            dataLabels: {
                                position: 'center',
                            }
                        }
                    },
                    dataLabels: {
                        enabled: true,
                        formatter: function(val) {
                            return val;
                        },
                        style: {
                            colors: ['#fff']
                        }
                    },
                    xaxis: {
                        categories: bestSellingNames,
                        title: {
                            text: 'Jumlah Transaksi'
                        }
                    },
                    title: {
                        text: 'Produk Paling Banyak Terjual',
                        align: 'center'
                    }
                };
                var chartBestSelling = new ApexCharts(document.querySelector("#bestSellingChart"),
                    optionsBestSelling);
                chartBestSelling.render();
            @endif

            @if ($hasPriceIncreaseData)
                var priceIncreaseData = @json($priceIncreaseData);
                var priceNames = priceIncreaseData.map(item => {
                    let name = (item.varian && item.varian.produk) ? item.varian.produk.nama_produk + ' ' +
                        item.varian.nama_varian : 'Item #' + item.id;
                    return name.length > 20 ? name.substring(0, 20) + '...' : name;
                });
                var oldPrices = priceIncreaseData.map(item => item.harga_lama);
                var newPrices = priceIncreaseData.map(item => item.harga_beli);

                var optionsPriceIncrease = {
                    series: [{
                        name: 'Harga Lama',
                        data: oldPrices
                    }, {
                        name: 'Harga Baru',
                        data: newPrices
                    }],
                    chart: {
                        type: 'bar',
                        height: 350,
                        fontFamily: 'Nunito, sans-serif',
                        toolbar: {
                            show: false
                        }
                    },
                    colors: ['#fd7e14', '#31ce36'],
                    plotOptions: {
                        bar: {
                            horizontal: false,
                            columnWidth: '55%',
                            borderRadius: 4,
                            dataLabels: {
                                position: 'top',
                            }
                        },
                    },
                    dataLabels: {
                        enabled: true,
                        offsetY: -20,
                        style: {
                            fontSize: '12px',
                            colors: ["#304758"]
                        },
                        formatter: function(val) {
                            return "Rp " + new Intl.NumberFormat('id-ID', {
                                notation: "compact",
                                compactDisplay: "short"
                            }).format(val);
                        }
                    },
                    stroke: {
                        show: true,
                        width: 2,
                        colors: ['transparent']
                    },
                    xaxis: {
                        categories: priceNames,
                    },
                    yaxis: {
                        title: {
                            text: 'Harga'
                        },
                        labels: {
                            formatter: function(value) {
                                return "Rp " + new Intl.NumberFormat('id-ID', {
                                    notation: "compact",
                                    compactDisplay: "short"
                                }).format(value);
                            }
                        }
                    },
                    fill: {
                        opacity: 1
                    },
                    tooltip: {
                        y: {
                            formatter: function(val) {
                                return "Rp " + new Intl.NumberFormat('id-ID').format(val)
                            }
                        }
                    }
                };

                var chartPriceIncrease = new ApexCharts(document.querySelector("#priceIncreaseChart"),
                    optionsPriceIncrease);
                chartPriceIncrease.render();
            @endif
        });
    </script>
@endpush
