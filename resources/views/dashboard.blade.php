@extends('layouts.app')
@section('css')
    <link href="{{ asset('assets/css/vendor/dataTables.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/vendor/responsive.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('title', 'Ventes')

@section('content')
    <div class="content">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('vente.index') }}">Ventes</a></li>
                        </ol>
                    </div>
                    <h4 class="page-title">Ventes</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <style>
            body {

                font-size: 13px;
            }
        </style>

        <!-- end row-->


        <div class="row">
            <div class="col-lg-12">
                <div class="card widget-inline">
                    <div class="card-body p-0">
                        <div class="row g-0">

                            <div class="col-sm-2 mr-14 ">
                                {{-- <a href="{{route('permission.index')}}" type="button" class="btn btn-outline-primary"><i class="uil-arrow-left"></i> Permissions</a> --}}
                            </div>
                            @if (session('ok'))
                                <div class="col-6">
                                    <div class="alert alert-success alert-dismissible bg-success text-white text-center border-0 fade show"
                                        role="alert">
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                        <strong> {{ session('ok') }}</strong>
                                    </div>
                                </div>
                            @endif

                        </div> <!-- end row -->
                    </div>
                </div> <!-- end card-box-->
            </div> <!-- end col-->
        </div>
        <!-- end row-->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">


                        <div class="col-xxl-12">
                            <div class="row">
                                <div class="col-xl-4">
                                    <div class="card">
                                        <div class="card-body">
                                           
                                            <div class="d-flex">
                                                <div class="flex-shrink-0">
                                                    <div class="avatar-sm rounded">
                                                        <span class="avatar-title bg-primary-lighten h3 my-0 text-primary rounded">
                                                            <i class="mdi mdi-cash"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h4 class="mt-0 mb-1 font-20">{{number_format($montantCaisse, 2, '.', ' ')}} Fcfa</h4>
                                                   
                                                </div>
                                            </div>
                    
                                            <div class="row align-items-end justify-content-between mt-3">
                                                <div class="col-sm-6">
                                                    <h4 class="mt-0 text-danger fw-bold mb-1">Montant en caisse</h4>
                                                   
                                                    
                                                </div> <!-- end col -->
                    
                                                <div class="col-sm-5">
                                                    <div class="text-end">
                                                        <div id="currency-btc-chart" data-colors="#536de6"></div>
                                                    </div>
                                                </div> <!-- end col -->
                                            </div>
                                        </div> <!-- end card-body -->
                                    </div> <!-- end card -->
                                </div> <!-- end col -->
                    
                                {{-- <div class="col-xl-4">
                                    <div class="card">
                                        <div class="card-body">
                                           
                                            <div class="d-flex">
                                                <div class="flex-shrink-0">
                                                    <div class="avatar-sm rounded">
                                                        <span class="avatar-title bg-primary-lighten h3 my-0 text-primary rounded">
                                                            <i class="mdi mdi-currency-cny"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h4 class="mt-0 mb-1 font-20">$9,250</h4>
                                                    <p class="mb-0 text-muted"><i class="mdi mdi-arrow-up-bold text-success"></i> 32% This Week</p>
                                                </div>
                                            </div>
                    
                                            <div class="row align-items-end justify-content-between mt-3">
                                                <div class="col-sm-6">
                                                    <h4 class="mt-0 text-muted fw-semibold mb-1">Rate</h4>
                                                    <p class="text-muted mb-0">1.00 CNY = $0.6</p>
                                                    
                                                </div> <!-- end col -->
                    
                                                <div class="col-sm-5">
                                                    <div class="text-end">
                                                        <div id="currency-cny-chart" data-colors="#536de6"></div>
                                                    </div>
                                                </div> <!-- end col -->
                                            </div>
                                        </div> <!-- end card-body -->
                                    </div> <!-- end card -->
                                </div> <!-- end col --> --}}
                    
                                {{-- <div class="col-xl-4">
                                    <div class="card">
                                        <div class="card-body">
                                          
                                            <div class="d-flex">
                                                <div class="flex-shrink-0">
                                                    <div class="avatar-sm rounded">
                                                        <span class="avatar-title bg-primary-lighten h3 my-0 text-primary rounded">
                                                            <i class="mdi mdi-currency-eth"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h4 class="mt-0 mb-1 font-20">$12,500</h4>
                                                    <p class="mb-0 text-muted"><i class="mdi mdi-arrow-up-bold text-success"></i> 60% This Week</p>
                                                </div>
                                            </div>
                    
                                            <div class="row align-items-end justify-content-between mt-3">
                                                <div class="col-sm-6">
                                                    <h4 class="mt-0 text-muted fw-semibold mb-1">Rate</h4>
                                                    <p class="text-muted mb-0">1.00 ETH = $3,783.68</p>
                                                    
                                                </div> <!-- end col -->
                    
                                                <div class="col-sm-5">
                                                    <div class="text-end">
                                                        <div id="currency-eth-chart" data-colors="#536de6"></div>
                                                    </div>
                                                </div> <!-- end col -->
                                            </div>
                                        </div> <!-- end card-body -->
                                    </div> <!-- end card -->
                                </div> <!-- end col --> --}}
                            </div> <!-- end row -->
                    
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <h4 class="header-title">Chiffre d'affaires  / Bénéfices / Dépenses</h4>
                                                            <div dir="ltr">
                                                                <div id="basic-column" class="apex-charts" data-colors="#536de6,#35b8e0,#cfe1f6"></div>    
                                                            </div>
                                                        </div>
                                                        <!-- end card body-->
                                                    </div>
                                                    <!-- end card -->
                                                </div>
                                                <!-- end col-->
                        
                                                
                                                <!-- end col-->
                                            </div>
                                            <!-- end row-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- end col -->
                    
                    </div> <!-- end row -->
                    
                   

                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div> <!-- end col -->
        </div>
        <!-- end row -->
    </div> <!-- End Content -->
@endsection

@section('script')

<script src="{{ asset('/js/lib/apexcharts.min.js') }}"></script>



  <script>
    var colors = ["#1e1b4b", "#84cc16", "#e11d48", "#f97316"];
    dataColors = $("#basic-column").data("colors");
    var ca_n = {!! json_encode($ca_n) !!};
    var benefices_n = {!! json_encode($benefices_n) !!}; 
    var depenses_n = {!! json_encode($depenses_n) !!};
    var achats_n = {!! json_encode($achats_n) !!};

// dataColors && (colors = dataColors.split(","));
var options = {
        chart: { height: 396, type: "bar", toolbar: { show: !1 } },
        plotOptions: { bar: { horizontal: !1, endingShape: "rounded", columnWidth: "55%" } },
        dataLabels: { enabled: !1 },
        stroke: { show: !0, width: 2, colors: ["transparent"] },
        colors: colors,
        series: [
            { name: "Chiffre d'affaires", data: ca_n },
            { name: "Bénéfices", data: benefices_n },
            { name: "Dépenses", data: depenses_n },
            { name: "Achats marchandises", data: achats_n },
        ],
        xaxis: { categories: ["Jan", "Feb", "Mar", "Avr", "Mai", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"] },
        legend: { offsetY: 7 },
        yaxis: { title: { text: "Montant " } },
        fill: { opacity: 1 },
        grid: { row: { colors: ["transparent", "transparent"], opacity: 0.2 }, borderColor: "#f1f3fa", padding: { bottom: 5 } },
        tooltip: {
            y: {
                formatter: function (o) {
                    return  o + " Fcfa";
                },
            },
        },
    },
    chart = new ApexCharts(document.querySelector("#basic-column"), options);
chart.render();


(chart = new ApexCharts(document.querySelector("#range-column"), options)).render();

  </script>
  
@endsection
