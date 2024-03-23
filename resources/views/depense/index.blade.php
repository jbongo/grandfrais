@extends('layouts.app')
@section('css')
    <link href="{{ asset('assets/css/vendor/dataTables.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/vendor/responsive.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('title', 'Dépenses')

@section('content')
    <div class="content">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('depense.index') }}">Dépenses</a></li>
                        </ol>
                    </div>
                    <h4 class="page-title">Dépenses</h4>
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
                            @can('permission', 'ajouter-depense')
                                <div class="d-flex justify-content-start">
                                    <a class="btn btn-primary mb-2" href="#add-depense" class="btn btn-primary mb-2" data-bs-toggle="modal"
                                    data-bs-target="#standard-modal-depense">
                                        <i class="mdi mdi-plus-circle me-2"></i> Ajouter depense
                                    </a>                             
                                </div>
                            @endcan
                            
                            @if(Auth::user()->is_admin)
                            
                                <div class="">
                                    <strong>Montant total des depenses :<span class="badge bg-danger text-white font-bold px-2 fs-5">  {{ $montant_total_depenses }} €</span></strong>                  
                                </div>
                            @endif
                          
                            <div class="d-flex justify-content-end">
                                @can('permission', 'archiver-depense')
                                    <a href="{{ route('depense.archives') }}" class="btn btn-warning mb-2">
                                        <i class="mdi mdi-archive me-2"></i> Dépenses archivées
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
                                    <livewire:depense.index-table />
                                </div>
                            </div>
                        </div>

                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div> <!-- end col -->
        </div>
        <!-- end row -->


        {{--  --}}

        {{-- Ajout d'une dépense --}}
<div id="standard-modal-depense" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
<div class="modal-dialog modal-lg">
    <div class="modal-content ">
        <div class="modal-header">
            <h4 class="modal-title" id="standard-modalLabel">Ajouter une dépense</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="{{ route('depense.store') }}" method="post" id="form-add-depensexx">
            <div class="modal-body">
                @csrf


                <div class="row">
                  
                    <div class="col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-body">

                                <div class="row">


                                    <div class="col-sm-6">


                                        <div class="mb-3">
                                            <label for="typedepense_id" class="form-label">
                                                Type de dépense <span class="text-danger">*</span>
                                            </label>

                                            <select name="typedepense_id" id="typedepense_id"  class="select2 form-control select2-multiplex" data-toggle="select2" multiple="multiple" data-placeholder=" ...">
                                              
                                                @foreach ($typedepenses as $typedepense)
                                                    <option value="{{ $typedepense->id }}">{{ $typedepense->type }}
                                                @endforeach
                                            </select>

                                          

                                            @if ($errors->has('typedepense_id'))
                                                <br>
                                                <div class="alert alert-warning text-secondary " role="alert">
                                                    <button type="button" class="btn-close btn-close-white"
                                                        data-bs-dismiss="alert" aria-label="Close"></button>
                                                    <strong>{{ $errors->first('typedepense_id') }}</strong>
                                                </div>
                                            @endif
                                        </div>



                                        <div class="mb-3">
                                            <label for="details" class="form-label">
                                                Détails de la dépense
                                            </label>
                                            <textarea type="text" id="details" class="form-control" name="details"
                                               
                                                value="{{ old('details') ? old('details') : '' }}"
                                                class="form-control"></textarea>

                                            @if ($errors->has('details'))
                                                <br>
                                                <div class="alert alert-warning text-secondary " role="alert">
                                                    <button type="button" class="btn-close btn-close-white"
                                                        data-bs-dismiss="alert" aria-label="Close"></button>
                                                    <strong>{{ $errors->first('details') }}</strong>
                                                </div>
                                            @endif
                                        </div>                 
                                    </div>

                                    <div class="col-sm-6">

                                        <div class="mb-3">
                                            <label for="montant" class="form-label">
                                                Montant <span class="text-danger">*</span>
                                            </label>
                                            <input type="number" step="0.01" min="0" id="montant" name="montant"
                                            required
                                                value="{{ old('montant') ? old('montant') : '' }}"
                                                class="form-control">

                                            @if ($errors->has('montant'))
                                                <br>
                                                <div class="alert alert-warning text-secondary " role="alert">
                                                    <button type="button" class="btn-close btn-close-white"
                                                        data-bs-dismiss="alert" aria-label="Close"></button>
                                                    <strong>{{ $errors->first('montant') }}</strong>
                                                </div>
                                            @endif
                                        </div>

                                        <div class="mb-3">
                                            <label for="date_depense" class="form-label">
                                                Date de dépense <span class="text-danger">*</span>
                                            </label>
                                            <input type="date" id="date_depense" name="date_depense"
                                                value="{{date('Y-m-d')}}"
                                                class="form-control">

                                            @if ($errors->has('date_depense'))
                                                <br>
                                                <div class="alert alert-warning text-secondary " role="alert">
                                                    <button type="button" class="btn-close btn-close-white"
                                                        data-bs-dismiss="alert" aria-label="Close"></button>
                                                    <strong>{{ $errors->first('date_depense') }}</strong>
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


{{-- Modifier une dépense --}}
<div id="edit-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content ">
            <div class="modal-header">
                <h4 class="modal-title" id="standard-modalLabel">Modifier une dépense</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="post" id="form-edit-depense">
                <div class="modal-body">
                    @csrf
    
    
                    <div class="row">
                        
                        <div class="col-md-12 col-lg-12">
                            <div class="card">
                                <div class="card-body">
    
                                    <div class="row">
    
    
                                        <div class="col-sm-6">
    
    
                                            <div class="mb-3">
                                                <label for="edit-typedepense_id" class="form-label">
                                                    Type de dépense <span class="text-danger">*</span>
                                                </label>
    
                                                <select name="typedepense_id" id="edit-typedepense_id"  class=" form-select "  >
                                                    
                                                    @foreach ($typedepenses as $typedepense)
                                                        <option value="{{ $typedepense->id }}">{{ $typedepense->type }}
                                                    @endforeach
                                                </select>
    
                                                
    
                                                @if ($errors->has('typedepense_id'))
                                                    <br>
                                                    <div class="alert alert-warning text-secondary " role="alert">
                                                        <button type="button" class="btn-close btn-close-white"
                                                            data-bs-dismiss="alert" aria-label="Close"></button>
                                                        <strong>{{ $errors->first('typedepense_id') }}</strong>
                                                    </div>
                                                @endif
                                            </div>
    
    
    
                                            <div class="mb-3">
                                                <label for="edit-details" class="form-label">
                                                    Détails de la dépense
                                                </label>
                                                <textarea type="text" id="edit-details" class="form-control" name="details"
                                                    
                                                    value="{{ old('details') ? old('details') : '' }}"
                                                    class="form-control"></textarea>
    
                                                @if ($errors->has('details'))
                                                    <br>
                                                    <div class="alert alert-warning text-secondary " role="alert">
                                                        <button type="button" class="btn-close btn-close-white"
                                                            data-bs-dismiss="alert" aria-label="Close"></button>
                                                        <strong>{{ $errors->first('details') }}</strong>
                                                    </div>
                                                @endif
                                            </div>                 
                                        </div>
    
                                        <div class="col-sm-6">
    
                                            <div class="mb-3">
                                                <label for="edit-montant" class="form-label">
                                                    Montant <span class="text-danger">*</span>
                                                </label>
                                                <input type="number" step="0.01" min="0" id="edit-montant" name="montant"
                                                required
                                                    value="{{ old('montant') ? old('montant') : '' }}"
                                                    class="form-control">
    
                                                @if ($errors->has('montant'))
                                                    <br>
                                                    <div class="alert alert-warning text-secondary " role="alert">
                                                        <button type="button" class="btn-close btn-close-white"
                                                            data-bs-dismiss="alert" aria-label="Close"></button>
                                                        <strong>{{ $errors->first('montant') }}</strong>
                                                    </div>
                                                @endif
                                            </div>
    
                                            <div class="mb-3">
                                                <label for="edit-date_depense" class="form-label">
                                                    Date de dépense <span class="text-danger">*</span>
                                                </label>
                                                <input type="date" id="edit-date_depense" name="date_depense"
                                                    value="{{date('Y-m-d')}}"
                                                    class="form-control">
    
                                                @if ($errors->has('date_depense'))
                                                    <br>
                                                    <div class="alert alert-warning text-secondary " role="alert">
                                                        <button type="button" class="btn-close btn-close-white"
                                                            data-bs-dismiss="alert" aria-label="Close"></button>
                                                        <strong>{{ $errors->first('date_depense') }}</strong>
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

    {{-- selection des statuts du depense --}}

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

    {{-- selection du type de depense --}}

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


    {{-- Modification d'un depense --}}
    <script>
        $('.edit-depense').click(function(e) {

            let that = $(this);

            // $('#edit-typedepense_id').val(that.data('typedepense_id'));
            $('#edit-montant').val(that.data('montant'));
            $('#edit-details').val(that.data('details'));
            $('#edit-date_depense').val(that.data('date_depense'));
            

            let currentFormAction = that.data('href');
            console.log(currentFormAction);
            $('#form-edit-depense').attr('action', currentFormAction);




            //    selection du type de depense


            let currentType = that.data('typedepense_id');
            let currentTypeentite = that.data('typeentite');
         
            $('#edit-typedepense_id option[value='+currentType+']').attr('selected', 'selected');

            $('#edit-type_entite option[value=' + currentTypeentite + ']').attr('selected', 'selected');




        })



        // selection des statuts du depense  Modal modifier
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
            $('body').on('click', 'a.archive_depense', function(event) {
                let that = $(this)
                event.preventDefault();

                const swalWithBootstrapButtons = swal.mixin({
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger',
                    buttonsStyling: false,
                });

                swalWithBootstrapButtons.fire({
                    title: 'Archiver la dépense',
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
                                    'Dépense archivée avec succès',
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
                            'Dépense non archivée',
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
