@extends('layouts.app')
@section('css')
    <link href="{{ asset('assets/css/vendor/dataTables.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/vendor/responsive.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/css/intlTelInput.css">
    <link rel="stylesheet" href="{{ asset('assets/css/vendor/dropzone.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/vendor/dropzone-custom.css') }}">
@endsection

@section('title', 'Afficher vente')

@section('content')


    <style>
        .container-titre {

            display: flex;
            justify-content: flex-start;
            gap: 10px;

        }
    </style>
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

            <div class="col-12">
                <div class="card widget-inline">
                    <div class="card-body p-0">
                        <div class="row g-0">

                            <div class="col-sm-6">

                                <div class="col-sm-4 ">
                                    <a href="{{ route('vente.index') }}" type="button" class="btn btn-outline-primary"><i
                                            class="uil-arrow-left"></i>
                                        Ventes</a>

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

        <!-- end row-->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">



                        <!-- end row-->
                        <div class="row">

                            <div class="col-6">
                                @if (session('message'))
                                    <div class="alert alert-success text-secondary alert-dismissible ">
                                        <i class="dripicons-checkmark me-2"></i>
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        <a href="#" class="alert-link"><strong> {{ session('message') }}</strong></a>
                                    </div>
                                @endif
                            </div>
                        </div>



                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                               
                                            <div class="col-lg-5">
                                                <form class="">


                                                    <div class="container-titre">

                                                        <div class="item-titre">
                                                            <!-- Product title -->
                                                            <h3 class="mt-0">{{$vente->nom }}
                                                                <a href="{{ route('vente.edit', Crypt::encrypt($vente->id)) }}"
                                                                    class="text-muted">
                                                                    <i class="mdi mdi-square-edit-outline ms-2"></i>
                                                                </a>
                                                            </h3>
                                                        </div>
                                                        <div class="item-titre">
                                                            <!-- Product stock -->
                                                            <span class="mt-0">
                                                                <span class="badge badge-success-lighten">
                                                                    Modifier
                                                                </span>
                                                            </span>

                                                            
                                                            <span class="badge bg-danger  text-white font-bold py-1 px-2 fs-5 ">Vente n° {{$vente->numero}}</span> 
                                                        </div>
                                                        <div class="item-titre">
                                                            <!-- Product title -->
                                                            <span class="mt-0 ">{{$vente->nature }} </span>
                                                        </div>
                                                    </div>

                                                    <p class="mb-1">Date de vente:
                                                        {{$vente->date_vente }}
                                                    </p>
                                                    <!-- Product description -->
                                                    <div class="mt-4">
                                                        <h6 class="font-14">Prix total vente </h6>
                                                        <h4> {{ number_format($vente->montant, 0, ',', ' ') }} FCFA </h4>
                                                    </div>



                                                    <!-- Product description -->
                                                    <div class="mt-4">
                                                        <h6 class="font-14">Description:</h6>
                                                        <p>{!!$vente->description !!}</p>
                                                    </div>

                                                </form>
                                            </div> <!-- end col -->


                                            <div class="col-lg-7">

                                                <div class="table-responsive">
                                                    <table class="table mb-0" id="tab1">
                                                        <thead class="table-light">
                                                            <tr>
                                                                <th>produit</th>
                                                                <th>Quantité</th>
                                                                <th>Prix unitaire</th>
                                                                <th>Prix modifié</th>
                                                                <th>Prix total</th>
                                                                <th>Bénéfices</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                            @foreach ($vente->produits as $produit)
                                                                
                                          
                                                                <tr>
                                                                    <td>
                                                                        <span class="fw-bold me-2">{{$produit->nom }}</span>    
                                                                    </td>
                                                                    <td>
                                                                        <span class="fw-bold me-2">{{$produit->pivot->quantite }}</span> 
                                                                    </td>

                                                                    
                                                                    
                                                                    <td>
                                                                        <span class="fw-bold me-2">{{$produit->pivot->prix_unitaire }}</span> 
                                                                    </td>
                                                                    <td>
                                                                        @if($produit->pivot->prix_unitaire_modifie == true)
                                                                            <span class=" badge bg-danger text-white fw-bold me-2">Oui</span>
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        <span class="fw-bold me-2">{{$produit->pivot->prix_total }}</span> 
                                                                    </td>
                                                                    <td>
                                                                        @if($produit->pivot->benefice > 0)
                                                                            <span class="fw-bold me-2">{{$produit->pivot->benefice }}</span> 
                                                                        @else 
                                                                            <span class=" text-danger fw-bold me-2">{{$produit->pivot->benefice }}</span> 
                                                                        @endif

                                                                    </td>
                                                                </tr>
                                                            @endforeach


                                                            
    
                                                        </tbody>
                                                    </table>
                                                </div>
    

                                                
    
                                            </div> <!-- end col -->




                                        </div> <!-- end row-->

                                    </div> <!-- end card-body-->
                                </div> <!-- end card-->
                            </div> <!-- end col-->
                        </div>
                        <!-- end row-->








                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div> <!-- end col -->
        </div>
        <!-- end row -->





    </div> <!-- End Content -->
@endsection

@section('script')


    {{-- Gestion de stock Ajout déclinaison --}}
    <script>
        var gerer_stock = @json($vente->gerer_stock);

        if (gerer_stock == false) {
            $(".div_stock").hide();
            $(".div_stock_decli").hide();
        }
        $('#gerer_stock').change(function() {
            if ($("#gerer_stock").is(":checked")) {
                $(".div_stock").slideDown();
            } else {
                $(".div_stock").slideUp();

            }

        });

        $('#gerer_stock_decli').change(function() {
            if ($("#gerer_stock_decli").is(":checked")) {
                $(".div_stock_decli").slideDown();
            } else {
                $(".div_stock_decli").slideUp();
            }
        });
    </script>


    <script src="https://cdn.tiny.cloud/1/ieugu2pgq0vkrn7vrhnp69zprqpp5xfwh9iewe7v24gtdj8f/tinymce/6/tinymce.min.js"
        referrerpolicy="origin"></script>

    <script>
        tinymce.init({
            selector: '#description',
            plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
        });
    </script>




    <script>
        // Désarchiver

        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
            $('[data-toggle="tooltip"]').tooltip()
            $('body').on('click', 'a.unarchive-produit-decli', function(event) {
                let that = $(this)
                event.preventDefault();

                const swalWithBootstrapButtons = swal.mixin({
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger',
                    buttonsStyling: false,
                });

                swalWithBootstrapButtons.fire({
                    title: 'Désarchiver',
                    text: "Confirmer ?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Oui',
                    cancelButtonText: 'Non',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {

                        $('[data-toggle="tooltip"]').tooltip('hide')
                        $.ajax({
                                url: that.attr('data-href'),
                                type: 'POST',
                                success: function(data) {

                                    // document.location.reload();
                                },
                                error: function(data) {
                                    console.log(data);
                                }
                            })
                            .done(function() {

                                swalWithBootstrapButtons.fire(
                                        'Désarchivée',
                                        '',
                                        'success'
                                    )
                                    .then((result) => {
                                        if (result.isConfirmed) {
                                            document.location.reload();
                                        }
                                    })
                            })


                    } else if (
                        /* Read more about handling dismissals below */
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                        swalWithBootstrapButtons.fire(
                            'Annulé',
                            'Caracteristique non désarchivée :)',
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
                    info: "Affichage de  _START_ à _END_ sur _TOTAL_",
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


    {{-- Modification d'une déclinaison --}}
    <script>
        $('.edit-declinaison').click(function(e) {

            let that = $(this);
            let currentCaracteristique = that.data('nom');

            let currentFormAction = that.data('href');


            $('#edit_form_decli').attr('action', currentFormAction);


            $('#edit_prix_vente_ht_decli').val(that.data('prix_vente_ht'));
            $('#edit_prix_vente_ttc_decli').val(that.data('prix_vente_ttc'));
            $('#edit_prix_vente_max_ht_decli').val(that.data('prix_vente_max_ht'));
            $('#edit_prix_vente_max_ttc_decli').val(that.data('prix_vente_max_ttc'));
            $('#edit_prix_achat_ht_decli').val(that.data('prix_achat_ht'));
            $('#edit_prix_achat_ttc_decli').val(that.data('prix_achat_ttc'));
            $('#edit_prix_achat_commerciaux_ht_decli').val(that.data('prix_achat_commerciaux_ht'));
            $('#edit_prix_achat_commerciaux_ttc_decli').val(that.data('prix_achat_commerciaux_ttc'));
            $('#edit_gerer_stock_decli').val(that.data('gerer_stock'));
            $('#edit_valeurcaracteristique_decli').val(that.data('valeurcaracteristique'));
            $('#edit_produitdecli_id_decli').val(that.data('produitdecli_id'));
            $('#edit_quantite_decli').val(that.data('quantite'));
            $('#edit_quantite_min_vente_decli').val(that.data('quantite_min'));
            $('#edit_seuil_alerte_stock_decli').val(that.data('seuil_alerte'));


            var check_declis = $('.check-decli');



            valeursExistantes = that.data('valeurcaracteristique');
            // Parcourez les valeurs existantes et cochez les boutons radio correspondants
            valeursExistantes.forEach(function(valeurId) {
                $('input[value="' + valeurId + '"]').prop('checked', true);
            });


            // {{-- Gestion de stock modification déclinaison --}}

            var gerer_stock = that.data('gerer_stock');

            if (gerer_stock == false) {
                $(".div_edit_stock_decli").hide();
                $(".div_edit_stock_decli").hide();
                $("#edit_gerer_stock_decli").prop("checked", false);

            } else {
                $(".div_edit_stock_decli").show();
                $(".div_edit_stock_decli").show();
                $("#edit_gerer_stock_decli").prop("checked", true);

            }



        });

        $('#edit_gerer_stock_decli').change(function() {
            if ($("#edit_gerer_stock_decli").is(":checked")) {
                $(".div_edit_stock_decli").slideDown();
            } else {
                $(".div_edit_stock_decli").slideUp();
            }
        });
    </script>

@endsection
