@extends('layouts.app')
@section('css')
    <link href="{{ asset('assets/css/vendor/dataTables.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/vendor/responsive.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('title', 'Achats')

@section('content')
    <div class="content">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('achat.index') }}">Achats</a></li>
                        </ol>
                    </div>
                    <h4 class="page-title">Achats</h4>
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
                            @can('permission', 'ajouter-contact')
                                <div class="d-flex justify-content-start">
                                  
                                    <a class="btn btn-primary add-achat mb-2" href="#standard-modal-achat" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#standard-modal-achat">
                                        <i class="mdi mdi-plus-circle me-2"></i> Ajouter achat
                                    </a>   
                                    


                                </div>
                            @endcan
                            
                            @if(Auth::user()->is_admin)
                            
                                <div class="">
                                    <strong>Montant total des achats :<span class="badge bg-danger text-white font-bold px-2 fs-5">  {{ $montant_total_achats }} €</span></strong>                  
                                </div>
                            @endif
                          
                            <div class="d-flex justify-content-end">
                                @can('permission', 'archiver-contact')
                                    <a href="{{ route('achat.archives') }}" class="btn btn-warning mb-2">
                                        <i class="mdi mdi-archive me-2"></i> Achats archivées
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
                                    <livewire:achat.index-table />
                                </div>
                            </div>
                        </div>

                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div> <!-- end col -->
        </div>
        <!-- end row -->



{{-- Ajout d'un achat --}}
<div id="standard-modal-achat" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content ">
            <div class="modal-header">
                <h4 class="modal-title" id="standard-modalLabel">Ajouter un achat</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{ route('achat.store') }}" method="post" id="form-add-achat">
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
    
                                                <select name="produit_id" id="produit_id"  class="select2 form-control select2-multiplex" data-toggle="select2"  required data-placeholder=" ...">                                                  
                                                    <option value=""></option>
                                                    @foreach ($produits as $produit)
                                                        <option value="{{ $produit->id }}">{{ $produit->nom }}</option>
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
                                                <label for="date_achat" class="form-label">
                                                    Date de achat <span class="text-danger">*</span>
                                                </label>
                                                <input type="date" id="date_achat" name="date_achat" required
                                                    value="{{date('Y-m-d')}}"
                                                    class="form-control">
    
                                                @if ($errors->has('date_achat'))
                                                    <br>
                                                    <div class="alert alert-warning text-secondary " role="alert">
                                                        <button type="button" class="btn-close btn-close-white"
                                                            data-bs-dismiss="alert" aria-label="Close"></button>
                                                        <strong>{{ $errors->first('date_achat') }}</strong>
                                                    </div>
                                                @endif
                                            </div>
                                            
                                            
                                           

                                        </div>
    
                                        <div class="col-sm-6">    
                                            <div class="mb-3">
                                                <label for="quantite" class="form-label">
                                                    Quantité (en kilo ou unité) <span class="text-danger">*</span>
                                                </label>
                                                <input type="number"  min="1" step="0.01" id="quantite" name="quantite" required value="{{ old('quantite') ? old('quantite') : '' }}" class="form-control">
    
                                                @if ($errors->has('quantite'))
                                                    <br>
                                                    <div class="alert alert-warning text-secondary " role="alert">
                                                        <button type="button" class="btn-close btn-close-white"
                                                            data-bs-dismiss="alert" aria-label="Close"></button>
                                                        <strong>{{ $errors->first('quantite') }}</strong>
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="mb-3">
                                                <label for="prix_total" class="form-label">
                                                    Prix total d'achat <span class="text-danger">*</span>
                                                </label>
                                                <input type="number"  min="1"  id="prix_total" name="prix_total" required value="{{ old('prix_total') ? old('prix_total') : '' }}" class="form-control">
    
                                                @if ($errors->has('prix_total'))
                                                    <br>
                                                    <div class="alert alert-warning text-secondary " role="alert">
                                                        <button type="button" class="btn-close btn-close-white"
                                                            data-bs-dismiss="alert" aria-label="Close"></button>
                                                        <strong>{{ $errors->first('prix_total') }}</strong>
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="mb-3">
                                                <label for="autres_charges" class="form-label">
                                                    Autres charges  <span class="text-danger">(livraison, transport, etc)</span>
                                                </label>
                                                <input type="number"  min="1" id="autres_charges" name="autres_charges" required value="{{ old('autres_charges') ? old('autres_charges') : '' }}" class="form-control">
    
                                                @if ($errors->has('autres_charges'))
                                                    <br>
                                                    <div class="alert alert-warning text-secondary " role="alert">
                                                        <button type="button" class="btn-close btn-close-white"
                                                            data-bs-dismiss="alert" aria-label="Close"></button>
                                                        <strong>{{ $errors->first('autres_charges') }}</strong>
                                                    </div>
                                                @endif
                                            </div>

                                          
                                        </div>
                                    </div>
    
                                    <br>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class=" mb-3">
                                                <label for="fournisseur_id" class="form-label">
                                                    Sélectionnez le fournisseur 
                                                </label>
                                                <select name="fournisseur_id" id="fournisseur_id" class=" form-control select2"
                                                    data-toggle="select2" >
                                                    <option value=""></option>
                                                    @foreach ($contacts as $contact)
                                                        @if($contact->nature == 'Personne physique')
                                                            <option value="{{ $contact->id }}">
                                                                {{ $contact->individu?->nom }} {{ $contact->individu?->prenom }}
                                                            </option>
                                                        @else 
                                                            <option value="{{ $contact->id }}">{{ $contact->entite?->raison_sociale }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('fournisseur_id'))
                                                    <br>
                                                    <div class="alert alert-warning text-secondary " role="alert">
                                                        <button type="button" class="btn-close btn-close-white"
                                                            data-bs-dismiss="alert" aria-label="Close"></button>
                                                        <strong>{{ $errors->first('fournisseur_id') }}</strong>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class=" mb-3">
                                                <label for="caisse_id" class="form-label">
                                                    Déduis de la caisse :  
                                                </label>
                                                <select name="caisse_id" id="caisse_id" class=" form-control select2"
                                                    data-toggle="select2" >
                                                   
                                                    @foreach ($caisses as $caisse)
                                                       <option value="{{ $caisse->id }}">{{ $caisse->nom }}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('caisse_id'))
                                                    <br>
                                                    <div class="alert alert-warning text-secondary " role="alert">
                                                        <button type="button" class="btn-close btn-close-white"
                                                            data-bs-dismiss="alert" aria-label="Close"></button>
                                                        <strong>{{ $errors->first('caisse_id') }}</strong>
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


{{-- Modification d'un achat --}}

<div id="modal-edit-achat" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content ">
            <div class="modal-header">
                <h4 class="modal-title" id="standard-modalLabel">Modification de l'achat</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="" method="post" id="form-edit-achat">
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
                                                <select name="produit_id" id="edit_produit_id"  class="select2 form-control select2-multiplex" data-toggle="select2"   required >       
                                                                                        
                                                    @foreach ($produits as $produit)
                                                        <option value="{{ $produit->id }}">{{ $produit->nom }}</option>
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
                                                <label for="edit_dateachat" class="form-label">
                                                    Date de achat <span class="text-danger">*</span>
                                                </label>
                                                <input type="date" id="edit_dateachat" name="date_achat" required value=""
                                                    class="form-control">
    
                                                @if ($errors->has('date_achat'))
                                                    <br>
                                                    <div class="alert alert-warning text-secondary " role="alert">
                                                        <button type="button" class="btn-close btn-close-white"
                                                            data-bs-dismiss="alert" aria-label="Close"></button>
                                                        <strong>{{ $errors->first('date_achat') }}</strong>
                                                    </div>
                                                @endif
                                            </div>
                                            
                                            
                                            

                                        </div>
    
                                        <div class="col-sm-6">    
                                            <div class="mb-3">
                                                <label for="edit_quantite" class="form-label">
                                                    Quantité (en kilo ou unité) <span class="text-danger">*</span>
                                                </label>
                                                <input type="number"  min="1" step="0.01" id="edit_quantite" name="quantite" required value="{{ old('quantite') ? old('quantite') : '' }}" class="form-control">
    
                                                @if ($errors->has('quantite'))
                                                    <br>
                                                    <div class="alert alert-warning text-secondary " role="alert">
                                                        <button type="button" class="btn-close btn-close-white"
                                                            data-bs-dismiss="alert" aria-label="Close"></button>
                                                        <strong>{{ $errors->first('quantite') }}</strong>
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="mb-3">
                                                <label for="edit_prix_total" class="form-label">
                                                    Prix total d'achat <span class="text-danger">*</span>
                                                </label>
                                                <input type="number"  min="1"  id="edit_prix_total" name="prix_total" required value="{{ old('prix_total') ? old('prix_total') : '' }}" class="form-control">
    
                                                @if ($errors->has('prix_total'))
                                                    <br>
                                                    <div class="alert alert-warning text-secondary " role="alert">
                                                        <button type="button" class="btn-close btn-close-white"
                                                            data-bs-dismiss="alert" aria-label="Close"></button>
                                                        <strong>{{ $errors->first('prix_total') }}</strong>
                                                    </div>
                                                @endif
                                            </div>   
                                            
                                            <div class="mb-3">
                                                <label for="edit_autres_charges" class="form-label">
                                                    Autres charges <span class="text-danger">(livraison, transport, etc)</span>
                                                </label>
                                                <input type="number"  min="1"  id="edit_autres_charges" name="autres_charges" required value="{{ old('autres_charges') ? old('autres_charges') : '' }}" class="form-control">
    
                                                @if ($errors->has('autres_charges'))
                                                    <br>
                                                    <div class="alert alert-warning text-secondary " role="alert">
                                                        <button type="button" class="btn-close btn-close-white"
                                                            data-bs-dismiss="alert" aria-label="Close"></button>
                                                        <strong>{{ $errors->first('autres_charges') }}</strong>
                                                    </div>
                                                @endif
                                            </div>

                                        </div>

                                    </div>

                                    <br>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-6">

                                            <div class=" mb-3">
                                                <label for="edit_fournisseur_id" class="form-label">
                                                    Sélectionnez le fournisseur 
                                                </label>
                                                <select name="fournisseur_id" id="edit_fournisseur_id" class="form-select " >
                                                    <option value=""></option>
                                                    @foreach ($contacts as $contact)
                                                        @if($contact->nature == 'Personne physique')
                                                            <option value="{{ $contact->id }}">
                                                                {{ $contact->individu?->nom }} {{ $contact->individu?->prenom }}
                                                            </option>
                                                        @else 
                                                            <option value="{{ $contact->id }}">{{ $contact->entite?->raison_sociale }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('fournisseur_id'))
                                                    <br>
                                                    <div class="alert alert-warning text-secondary " role="alert">
                                                        <button type="button" class="btn-close btn-close-white"
                                                            data-bs-dismiss="alert" aria-label="Close"></button>
                                                        <strong>{{ $errors->first('fournisseur_id') }}</strong>
                                                    </div>
                                                @endif
                                            </div>

                                        </div>
                                        <div class="col-sm-6">

                                            <div class=" mb-3">
                                                <label for="edit_caisse_id" class="form-label">
                                                    Déduis de la caisse :  
                                                </label>
                                                <select name="caisse_id" id="edit_caisse_id" class=" form-control select2"
                                                    data-toggle="select2" >
                                                   
                                                    @foreach ($caisses as $caisse)
                                                       <option value="{{ $caisse->id }}">{{ $caisse->nom }}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('caisse_id'))
                                                    <br>
                                                    <div class="alert alert-warning text-secondary " role="alert">
                                                        <button type="button" class="btn-close btn-close-white"
                                                            data-bs-dismiss="alert" aria-label="Close"></button>
                                                        <strong>{{ $errors->first('caisse_id') }}</strong>
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

 

    {{-- Modification d'un achat --}}
    <script>
        $('.edit-achat').click(function(e) {

            let that = $(this);
            
            that.data('produitid') != "" ? $('#edit_produit_id option[value="' + that.data('produitid') + '"]').prop('selected', true) : $('#edit_produit_id').val('');

            that.data('fournisseurid') != "" ?  $('#edit_fournisseur_id option[value="' + that.data('fournisseurid') + '"]').prop('selected', true) :  $('#edit_fournisseur_id').val(''); ; 
            that.data('caisseid') != "" ?  $('#edit_caisse_id option[value="' + that.data('caisseid') + '"]').prop('selected', true) :  $('#edit_caisse_id').val(''); ; 
        

            $('#edit_dateachat').val(that.data('dateachat'));
            
            $('#edit_quantite').val(that.data('quantite'));
            $('#edit_prix_total').val(that.data('prixtotal'));       
            $('#edit_autres_charges').val(that.data('autrescharges'));       

            let currentFormAction = that.data('href');
            $('#form-edit-achat').attr('action', currentFormAction);

              // Recharger le select 2
            $('#edit_fournisseur_id').select2({
                dropdownParent: $('#modal-edit-achat')
             });

              // Recharger le select 2
            $('#edit_caisse_id').select2({
                dropdownParent: $('#modal-edit-achat')
             });
             $('#edit_produit_id').select2({
                dropdownParent: $('#modal-edit-achat')
            });

        });

    </script>

{{-- Ajout d'un achat --}}
    <script>
        // Recharger le select 2
      $('#fournisseur_id').select2({
            dropdownParent: $('#standard-modal-achat')
        });
        
        $('#caisse_id').select2({
            dropdownParent: $('#standard-modal-achat')
        });
        $('#produit_id').select2({
            dropdownParent: $('#standard-modal-achat')
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
            $('body').on('click', 'a.archive_achat', function(event) {
                let that = $(this)
                event.preventDefault();

                const swalWithBootstrapButtons = swal.mixin({
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger',
                    buttonsStyling: false,
                });

                swalWithBootstrapButtons.fire({
                    title: 'Archiver l\'achat',
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
                                type: 'PUT',
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
                                    'Achat archivée avec succès',
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
                            'Achat non archivé',
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
