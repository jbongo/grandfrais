@extends('layouts.app')
@section('css')
    <link href="{{ asset('assets/css/vendor/dataTables.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/vendor/responsive.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('title', 'Caisses')

@section('content')
    <div class="content">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('caisse.index') }}">Caisses</a></li>
                        </ol>
                    </div>
                    <h4 class="page-title">Caisses</h4>
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
                            @can('permission', 'ajouter-caisse')
                                <div class="d-flex justify-content-start">
                                    <a class="btn btn-primary mb-2" href="#add-caisse" class="btn btn-primary mb-2" data-bs-toggle="modal"
                                    data-bs-target="#standard-modal-caisse">
                                        <i class="mdi mdi-plus-circle me-2"></i> Ajouter caisse
                                    </a>                             
                                </div>
                            @endcan
                            
                            @if(Auth::user()->is_admin)
                            
                                <div class="">
                                    <strong>Montant total des caisses :<span class="badge bg-danger text-white font-bold px-2 fs-5">  {{ $montant_total_caisses }} €</span></strong>                  
                                </div>
                            @endif
                          
                            <div class="d-flex justify-content-end">
                                @can('permission', 'archiver-caisse')
                                    <a href="{{ route('caisse.archives') }}" class="btn btn-warning mb-2">
                                        <i class="mdi mdi-archive me-2"></i> Caisses archivées
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
                            @include('caisse.grid', ['caisses' => $caisses])
                        </div>

                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div> <!-- end col -->
        </div>
        <!-- end row -->




{{-- Ajout d'une caisse --}}
<div id="standard-modal-caisse" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content ">
            <div class="modal-header">
                <h4 class="modal-title" id="standard-modalLabel">Ajouter une caisse</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('caisse.store') }}" method="post" id="form-add-caisse">
                <div class="modal-body">
                    @csrf
    
    
                    <div class="row">
                      
                        <div class="col-md-12 col-lg-12">
                            <div class="card">
                                <div class="card-body">
    
                                    <div class="row">
    
    
                                        <div class="col-sm-6">
    
                                            <div class="mb-3">
                                                <label for="nom" class="form-label">
                                                    Nom de la caisse <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" id="nom" name="nom" required
                                                    value="{{ old('nom') ? old('nom') : '' }}"
                                                    class="form-control">
    
                                                @if ($errors->has('nom'))
                                                    <br>
                                                    <div class="alert alert-warning text-secondary " role="alert">
                                                        <button type="button" class="btn-close btn-close-white"
                                                            data-bs-dismiss="alert" aria-label="Close"></button>
                                                        <strong>{{ $errors->first('nom') }}</strong>
                                                    </div>
                                                @endif
                                            </div>      
                                            
                                            <div class="mb-3">
                                                <label for="description" class="form-label">
                                                    Description de la caisse
                                                </label>
                                                <textarea class="form-control" name="description" id="description"  ></textarea>
    
                                                @if ($errors->has('description'))
                                                    <br>
                                                    <div class="alert alert-warning text-secondary " role="alert">
                                                        <button type="button" class="btn-close btn-close-white"
                                                            data-bs-dismiss="alert" aria-label="Close"></button>
                                                        <strong>{{ $errors->first('description') }}</strong>
                                                    </div>
                                                @endif
                                            </div> 

                                        </div>
    
                                        <div class="col-sm-6">
    
                                            <div class="mb-3">
                                                <label for="solde" class="form-label">
                                                    Solde <span class="text-danger">*</span>
                                                </label>
                                                <input type="number"  min="0" step="0.01" id="solde" name="solde" required value="{{ old('solde') ? old('solde') : '' }}" class="form-control">
    
                                                @if ($errors->has('solde'))
                                                    <br>
                                                    <div class="alert alert-warning text-secondary " role="alert">
                                                        <button type="button" class="btn-close btn-close-white"
                                                            data-bs-dismiss="alert" aria-label="Close"></button>
                                                        <strong>{{ $errors->first('solde') }}</strong>
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
    
    
    {{-- Modifier une caisse --}}
    <div id="edit-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content ">
                <div class="modal-header">
                    <h4 class="modal-title" id="standard-modalLabel">Modifier une caisse</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="post" id="form-edit-caisse">
                    <div class="modal-body">
                        @csrf
        
        
                        <div class="row">
                      
                            <div class="col-md-12 col-lg-12">
                                <div class="card">
                                    <div class="card-body">
        
                                        <div class="row">
    
    
                                            <div class="col-sm-6">
        
                                                <div class="mb-3">
                                                    <label for="edit_nom" class="form-label">
                                                        Nom de la caisse <span class="text-danger">*</span>
                                                    </label>
                                                    <input type="text" id="edit_nom" name="nom" required
                                                        value="{{ old('nom') ? old('nom') : '' }}"
                                                        class="form-control">
        
                                                    @if ($errors->has('nom'))
                                                        <br>
                                                        <div class="alert alert-warning text-secondary " role="alert">
                                                            <button type="button" class="btn-close btn-close-white"
                                                                data-bs-dismiss="alert" aria-label="Close"></button>
                                                            <strong>{{ $errors->first('nom') }}</strong>
                                                        </div>
                                                    @endif
                                                </div>      
                                                
                                                <div class="mb-3">
                                                    <label for="edit_description" class="form-label">
                                                        Description de la caisse
                                                    </label>
                                                    <textarea class="form-control" name="description" id="edit_description"  ></textarea>
        
                                                    @if ($errors->has('description'))
                                                        <br>
                                                        <div class="alert alert-warning text-secondary " role="alert">
                                                            <button type="button" class="btn-close btn-close-white"
                                                                data-bs-dismiss="alert" aria-label="Close"></button>
                                                            <strong>{{ $errors->first('description') }}</strong>
                                                        </div>
                                                    @endif
                                                </div> 
    
                                            </div>
        
                                            <div class="col-sm-6">
        
                                                <div class="mb-3">
                                                    <label for="edit_solde" class="form-label">
                                                        Solde <span class="text-danger">*</span>
                                                    </label>
                                                    <input type="number"  min="0" step="0.01" id="edit_solde" name="solde" required value="{{ old('solde') ? old('solde') : '' }}" class="form-control">
        
                                                    @if ($errors->has('solde'))
                                                        <br>
                                                        <div class="alert alert-warning text-secondary " role="alert">
                                                            <button type="button" class="btn-close btn-close-white"
                                                                data-bs-dismiss="alert" aria-label="Close"></button>
                                                            <strong>{{ $errors->first('solde') }}</strong>
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
                        <button type="submit" class="btn btn-success">Modifier</button>
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



    {{-- Modification d'un caisse --}}
    <script>
        $('.edit-caisse').click(function(e) {

            let that = $(this);
            // $('#edit-typedepense_id').val(that.data('typedepense_id'));
            $('#edit_quantite').val(that.data('quantite'));
            $('#edit_nom').val(that.data('nom'));
            

            let currentFormAction = that.data('href');

            $('#form-edit-caisse').attr('action', currentFormAction);


            //    selection du produit
            let currentProduit = that.data('produit_id');
            $('#edit_produit_id').val(currentProduit).trigger('change');

        })



        // selection des statuts du caisse  Modal modifier
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
            $('body').on('click', 'a.archive_caisse', function(event) {
                let that = $(this)
                event.preventDefault();

                const swalWithBootstrapButtons = swal.mixin({
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger',
                    buttonsStyling: false,
                });

                swalWithBootstrapButtons.fire({
                    title: 'Archiver la caisse',
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
                                    'Caisse archivée avec succès',
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
                            'Caisse non archivée',
                            'error'
                        )
                    }
                });
            })

        });
    </script>


@endsection
