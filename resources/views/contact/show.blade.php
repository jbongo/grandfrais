@extends('layouts.app')
@section('css')
    <link href="{{ asset('assets/css/vendor/dataTables.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/vendor/responsive.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('title', 'Contact')

@section('content')
<div class="content">
                        
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Contact</a></li>
                     
                    </ol>
                </div>
                <h4 class="page-title">Contact - {{ $contact->nom }} {{ $contact->prenom }}</h4>
            </div>
        </div>
        <div class="col-12">
            <div class="card widget-inline">
                <div class="card-body p-0">
                    <div class="row g-0">

                        <div class="col-sm-6">

                            <div class="col-sm-4 ">
                                <a href="{{ route('contact.index') }}" type="button" class="btn btn-outline-primary"><i
                                        class="uil-arrow-left"></i>
                                    Contact</a>

                            </div>
                            @if (session('ok'))
                                <div class="col-6">
                                    <div class="alert alert-success alert-dismissible text-center border-0 fade show"
                                        role="alert">
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                        <strong> {{ session('ok') }}</strong>
                                    </div>
                                </div>
                            @endif
                        </div>

                    </div> <!-- end row -->
                </div>
            </div> <!-- end card-box-->
        </div>
    </div>
    <!-- end page title --> 

    <div class="row">
        <div class=" col-lg-7">
            <div class="card text-center">
                <div class="card-body">
                    
                 
                    <h4 class="mb-0 mt-2">{{ $contact->civilite }} {{ $contact->nom }} {{ $contact->prenom }}<a href="{{ route('contact.edit', Crypt::encrypt($contact->id)) }}" class="text-muted"><i class="mdi mdi-square-edit-outline ms-2"></i></a></h4>

                    @if($contact->type == "Prospect")
                        <div class="badge bg-secondary btn-sm font-12 mt-2">{{$contact->type}}</div>
                    @elseif($contact->type == "Client")
                        <div class="badge bg-info btn-sm font-12 mt-2">{{$contact->type}}</div>
                    @elseif($contact->type == "Fournisseur")
                        <div class="badge bg-warning btn-sm font-12 mt-2">{{$contact->type}}</div>
                    
                    @elseif($contact->type == "Collaborateur")
                        <div class="badge bg-danger btn-sm font-12 mt-2">{{$contact->type}}</div>
                    
                    @elseif($contact->type == "Bénéficiaire")                        
                        <div class="badge bg-primary btn-sm font-12 mt-2">{{$contact->type}}</div>                
                    @else 
                        <div class="badge bg-light btn-sm font-12 mt-2">{{$contact->type}}</div>                    
                    @endif
                    
                        
            
                

                    <div class="text-start mt-3">
                        
                        <p class="text-muted mb-2 font-13"><strong>Email :</strong> <span class="ms-2 ">{{ $contact->email }}</span></p>
                        <p class="text-muted mb-2 font-13"><strong>Téléphone 1 :</strong> 
                            <span class="ms-2 "> @if($contact->telephone_1!= null) {{ $contact->indicatif_1 }} {{ $contact->telephone_1 }} @endif</span>
                        </p>
                        <p class="text-muted mb-2 font-13"><strong>Téléphone 2 :</strong> 
                            <span class="ms-2 "> @if($contact->telephone_2!= null) {{ $contact->indicatif_2 }} {{ $contact->telephone_2 }} @endif</span>
                        </p>
                        <p class="text-muted mb-2 font-13"><strong> Adresse :</strong> 
                            <span class="ms-2 "> {{$contact->numero_voie}} {{$contact->nom_voie }} {{$contact->complement_voie }}, {{$contact->code_postal }}, {{$contact->ville }} </span>
                        </p>
                        
                        <h4 class="text-muted mb-2 font-13">Notes :</h4>
                        <p class="text-muted font-13 mb-3">
                           {{$contact->notes }}
                        </p>
                       
                        <p class="text-muted mb-2 font-13"><strong>Ville :</strong> <span class="ms-2 ">{{ $contact->ville }}</span></p>
                        <p class="text-muted mb-2 font-13"><strong>Quartier/commune :</strong> <span class="ms-2 ">{{ $contact->quartier }}</span></p>

                    </div>

            
                  
                </div> <!-- end card-body -->
            </div> <!-- end card -->

            <!-- Messages-->
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h4 class="header-title">Entreprises</h4>                       
                    </div>

                    <div class="inbox-widget">
                        <div class="inbox-item">
                            <h4 class="header-title"></h4>
                            <span class="badge text-info font-15"><li> {{$contact->entreprise}}</span>
                        </div>
                       

                       
                    </div> <!-- end inbox-widget -->
                </div> <!-- end card-body-->
            </div> <!-- end card-->

        </div> <!-- end col-->

        <div class="col-lg-3">
            <div class="card">
                <div class="card-body">
                   
                </div> <!-- end card body -->
            </div> <!-- end card -->
        </div> <!-- end col -->
    </div>
    <!-- end row-->
  
    
</div> <!-- End Content -->

@endsection

@section('script')
    <script src="{{ asset('assets/js/sweetalert2.all.js') }}"></script>


    <script src="{{ asset('assets/js/vendor/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/dataTables.bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/responsive.bootstrap5.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            "use strict";
            $("#tab1").
            DataTable({
                language: {
                    paginate: {
                        previous: "<i class='mdi mdi-chevron-left'>",
                        next: "<i class='mdi mdi-chevron-right'>"
                    },
                    info: "Showing actions _START_ to _END_ of _TOTAL_",
                    lengthMenu: 'Afficher <select class=\'form-select form-select-sm ms-1 me-1\'><option value="5">5</option><option value="10">10</option><option value="20">20</option><option value="-1">All</option></select> '
                },
                pageLength: 100,

                select: {
                    style: "multi"
                },
                drawCallback: function() {
                    $(".dataTables_paginate > .pagination").addClass("pagination-rounded"),
                        document.querySelector(".dataTables_wrapper .row").querySelectorAll(".col-md-6")
                        .forEach(function(e) {
                            e.classList.add("col-sm-6"), e.classList.remove("col-sm-12"), e
                                .classList.remove("col-md-6")
                        })
                }
            })
        });
    </script>

    <script src="/js/mesfonctions.js"></script>
    <script>
        formater_tel("#telephone_1", "#indicatif_1");
        formater_tel("#telephone_2", "#indicatif_2");
    </script>
@endsection
