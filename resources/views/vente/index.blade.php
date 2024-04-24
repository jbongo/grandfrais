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
                        <div class="d-flex justify-content-between">
                            @can('permission', 'ajouter-vente')
                                {{-- <div class="d-flex justify-content-start">
                                    <a class="btn btn-primary mb-2" href="#add-vente" class="btn btn-primary mb-2" data-bs-toggle="modal"
                                    data-bs-target="#standard-modal-vente">
                                        <i class="mdi mdi-plus-circle me-2"></i> Ajouter vente
                                    </a>                             
                                </div> --}}
                                <div class="d-flex justify-content-start">
                                    <a class="btn btn-primary mb-2" href="{{ route('vente.create')}}" class="btn btn-primary mb-2" >
                                        <i class="mdi mdi-plus-circle me-2"></i> Ajouter vente
                                    </a>                             
                                </div>
                            @endcan
                            
                            @if(Auth::user()->is_admin)
                            
                                <div class="">
                                    <strong>Montant total des ventes :<span class="badge bg-danger text-white font-bold px-2 fs-5">  {{ $montant_total_ventes }} FCFA</span></strong>                  
                                </div>
                            @endif
                          
                            <div class="d-flex justify-content-end">
                                @can('permission', 'archiver-vente')
                                    <a href="{{ route('vente.archives') }}" class="btn btn-warning mb-2">
                                        <i class="mdi mdi-archive me-2"></i> Ventes archivées
                                    </a>
                                @endcan
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-6">
                                @if (session('message'))
                                    <div class="alert alert-success text-secondary alert-dismissible ">
                                        <i class="dripicons-checkmark me-2"></i>
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        <a href="#" class="alert-link"><strong> {{ session('message') }}</strong></a>
                                    </div>
                                @endif
                                @if ($errors->has('role'))
                                    <br>
                                    <div class="alert alert-warning text-secondary " role="alert">
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                        <strong>{{ $errors->first('role') }}</strong>
                                    </div>
                                @endif

                            </div>
                        </div>


                        <div class="row">
                            <div class="col-12">
                                <div class="table-responsive">
                                    <livewire:vente.index-table />
                                </div>
                            </div>
                        </div>

                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div> <!-- end col -->
        </div>
        <!-- end row -->




{{-- Ajout d'une vente --}}
<div id="standard-modal-vente" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content ">
            <div class="modal-header">
                <h4 class="modal-title" id="standard-modalLabel">Ajouter une vente</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('vente.store') }}" method="post" id="form-add-vente">
                <div class="modal-body">
                    @csrf
    
    
                    <div class="row">
                      
                        <div class="col-md-12 col-lg-12">
                            <div class="card">
                                <div class="card-body">
    
                                    <div class="row">
    
    
                                        <div class="col-sm-6">
    
    
                                            <div class="mb-3">
                                                <label for="produit_id" class="form-label">
                                                    Produit <span class="text-danger">*</span>
                                                </label>
    
                                                {{-- <select name="produit_id" id="produit_id"   class="select2 form-control select2-multiple"  data-toggle="select2"  data-placeholder=" ..."> --}}
                                                <select name="produit_id" id="produit_id"  class="select2 form-control select2-multiplex" data-toggle="select2" multiple="multiple" required data-placeholder=" ...">                                                  
                                                    @foreach ($produits as $produit)
                                                        <option value="{{ $produit->id }}">{{ $produit->nom }}
                                                    @endforeach
                                                </select>                                             
    
                                                @if ($errors->has('produit_id'))
                                                    <br>
                                                    <div class="alert alert-warning text-secondary " role="alert">
                                                        <button type="button" class="btn-close btn-close-white"
                                                            data-bs-dismiss="alert" aria-label="Close"></button>
                                                        <strong>{{ $errors->first('produit_id') }}</strong>
                                                    </div>
                                                @endif
                                            </div>
    
    
    
                                            <div class="mb-3">
                                                <label for="date_vente" class="form-label">
                                                    Date de vente <span class="text-danger">*</span>
                                                </label>
                                                <input type="date" id="date_vente" name="date_vente" required
                                                    value="{{date('Y-m-d')}}"
                                                    class="form-control">
    
                                                @if ($errors->has('date_vente'))
                                                    <br>
                                                    <div class="alert alert-warning text-secondary " role="alert">
                                                        <button type="button" class="btn-close btn-close-white"
                                                            data-bs-dismiss="alert" aria-label="Close"></button>
                                                        <strong>{{ $errors->first('date_vente') }}</strong>
                                                    </div>
                                                @endif
                                            </div>        
                                        </div>
    
                                        <div class="col-sm-6">
    
                                            <div class="mb-3">
                                                <label for="quantite" class="form-label">
                                                    Quantité <span class="text-danger">*</span>
                                                </label>
                                                <input type="number"  min="1" id="quantite" name="quantite" required value="{{ old('quantite') ? old('quantite') : '' }}" class="form-control">
    
                                                @if ($errors->has('quantite'))
                                                    <br>
                                                    <div class="alert alert-warning text-secondary " role="alert">
                                                        <button type="button" class="btn-close btn-close-white"
                                                            data-bs-dismiss="alert" aria-label="Close"></button>
                                                        <strong>{{ $errors->first('quantite') }}</strong>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
    
    
                                    <!-- end row -->
    
                                </div> <!-- end card-body -->
                            </div> <!-- end card-->
                        </div> <!-- end col-->
                    </div>
    
    
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fermer</button>
    
                </div>
            </form>
        </div>
    </div>
    </div>
    
    
    {{-- Modifier une vente --}}
    <div id="edit-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content ">
                <div class="modal-header">
                    <h4 class="modal-title" id="standard-modalLabel">Modifier une vente</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="post" id="form-edit-vente">
                    <div class="modal-body">
                        @csrf
        
        
                        <div class="row">
                      
                            <div class="col-md-12 col-lg-12">
                                <div class="card">
                                    <div class="card-body">
        
                                        <div class="row">
        
        
                                            <div class="col-sm-6">
        
        
                                                <div class="mb-3">
                                                    <label for="edit_produit_id" class="form-label">
                                                        Produit <span class="text-danger">*</span>
                                                    </label>        
                                                    <select name="produit_id" id="edit_produit_id"  class="select2x form-select select2x" data-toggle="select2"  data-placeholder=" ...">
                                                      
                                                        @foreach ($produits as $produit)
                                                            <option value="{{ $produit->id }}">{{ $produit->nom }}
                                                        @endforeach
                                                    </select>
                                                    @if ($errors->has('produit_id'))
                                                        <br>
                                                        <div class="alert alert-warning text-secondary " role="alert">
                                                            <button type="button" class="btn-close btn-close-white"
                                                                data-bs-dismiss="alert" aria-label="Close"></button>
                                                            <strong>{{ $errors->first('produit_id') }}</strong>
                                                        </div>
                                                    @endif
                                                </div>
        
        
        
                                                <div class="mb-3">
                                                    <label for="edit_date_vente" class="form-label">
                                                        Date de vente <span class="text-danger">*</span>
                                                    </label>
                                                    <input type="date" id="edit_date_vente" name="date_vente" value=""
                                                        class="form-control">
        
                                                    @if ($errors->has('date_vente'))
                                                        <br>
                                                        <div class="alert alert-warning text-secondary " role="alert">
                                                            <button type="button" class="btn-close btn-close-white"
                                                                data-bs-dismiss="alert" aria-label="Close"></button>
                                                            <strong>{{ $errors->first('date_vente') }}</strong>
                                                        </div>
                                                    @endif
                                                </div>        
                                            </div>
        
                                            <div class="col-sm-6">
        
                                                <div class="mb-3">
                                                    <label for="edit_quantite" class="form-label">
                                                        Quantité <span class="text-danger">*</span>
                                                    </label>
                                                    <input type="number"  min="0" id="edit_quantite" name="quantite" required
                                                        value="{{ old('quantite') ? old('quantite') : '' }}"
                                                        class="form-control">
        
                                                    @if ($errors->has('quantite'))
                                                        <br>
                                                        <div class="alert alert-warning text-secondary " role="alert">
                                                            <button type="button" class="btn-close btn-close-white"
                                                                data-bs-dismiss="alert" aria-label="Close"></button>
                                                            <strong>{{ $errors->first('quantite') }}</strong>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
        
        
                                        <!-- end row -->
        
                                    </div> <!-- end card-body -->
                                </div> <!-- end card-->
                            </div> <!-- end col-->
                        </div>
        
        
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fermer</button>
        
                    </div>
                </form>
            </div>
        </div>
    </div>

    </div> <!-- End Content -->
@endsection

@section('script')
    <script src="{{ asset('assets/js/sweetalert2.all.js') }}"></script>

    {{-- selection des statuts du vente --}}

    <script>
        $('#client').click(function(e) {
            if (e.currentTarget.checked == true) {
                $('#prospect').prop('checked', false);
            }

        });

        $('#prospect').click(function(e) {
            if (e.currentTarget.checked == true) {
                $('#client').prop('checked', false);
            }

        });
    </script>

    {{-- selection du type de vente --}}

    <script>
        $('.div-entite').hide();

        $('#type').change(function(e) {

            if (e.currentTarget.value == "entité") {
                $('.div-entite').show();
                $('.div-individu').hide();

            } else {
                $('.div-entite').hide();
                $('.div-individu').show();
            }

        });
    </script>


    {{-- Modification d'un vente --}}
    <script>
        $('.edit-vente').click(function(e) {

            let that = $(this);
            // $('#edit-typedepense_id').val(that.data('typedepense_id'));
            $('#edit_quantite').val(that.data('quantite'));
            $('#edit_date_vente').val(that.data('date_vente'));
            

            let currentFormAction = that.data('href');

            $('#form-edit-vente').attr('action', currentFormAction);


            //    selection du produit
            let currentProduit = that.data('produit_id');
            $('#edit_produit_id').val(currentProduit).trigger('change');

        })



        // selection des statuts du vente  Modal modifier
        $('#edit-client').click(function(e) {
            if (e.currentTarget.checked == true) {
                $('#edit-prospect').prop('checked', false);
            }

        });

        $('#edit-prospect').click(function(e) {
            if (e.currentTarget.checked == true) {
                $('#edit-client').prop('checked', false);
            }

        });
    </script>

    <script>
        // Archiver
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
            $('[data-toggle="tooltip"]').tooltip()
            $('body').on('click', 'a.archive_vente', function(event) {
                let that = $(this)
                event.preventDefault();

                const swalWithBootstrapButtons = swal.mixin({
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger',
                    buttonsStyling: false,
                });

                swalWithBootstrapButtons.fire({
                    title: 'Archiver la vente',
                    text: "Confirmer ?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Oui',
                    cancelButtonText: 'Non',
                    reverseButtons: false
                }).then((result) => {
                    if (result.isConfirmed) {

                        $('[data-toggle="tooltip"]').tooltip('hide')
                        $.ajax({
                                url: that.attr('data-href'),
                                type: 'POST',
                                success: function(data) {
                                    document.location.reload();
                                },
                                error: function(data) {
                                    console.log(data);
                                }
                            })
                            .done(function() {

                                swalWithBootstrapButtons.fire(
                                    'Confirmation',
                                    'Vente archivée avec succès',
                                    'success'
                                )
                                document.location.reload();

                               
                            })


                    } else if (
                        /* Read more about handling dismissals below */
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                        swalWithBootstrapButtons.fire(
                            'Annulation',
                            'Vente non archivée',
                            'error'
                        )
                    }
                });
            })

        });
    </script>

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
@endsection
