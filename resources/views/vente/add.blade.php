@extends('layouts.app')
@section('css')
    <link href="{{ asset('assets/css/vendor/dataTables.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/vendor/responsive.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/css/intlTelInput.css">

@endsection

@section('title', 'Ajouter vente')

@section('content')


    <style>
        .container-gauche {

            display: flex;
            justify-content: flex-end;
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
                            <li class="breadcrumb-item"><a href="{{ route('vente.index') }}">Vente</a></li>
                        </ol>
                    </div>
                    <h4 class="page-title">Vente</h4>
                </div>
            </div>

            <div class="col-12">
                <div class="card widget-inline">
                    <div class="card-body p-0">
                        <div class="row g-0">

                            <div class="col-sm-6">

                                <div class="col-sm-4 ">
                                    <a href="{{ route('vente.index') }}"
                                        type="button" class="btn btn-outline-primary"><i class="uil-arrow-left"></i>
                                        Retour</a>

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
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">



                        <!-- end row-->
                        <div class="row">

                            <div class="col-6">
                                @if (session('message'))
                                    <div class="alert alert-success text-secondary alert-dismissible ">
                                        <i class="dripicons-checkmark me-2"></i>
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        <a href="#" class="alert-link"><strong>
                                                {{ session('message') }}</strong></a>
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- Formulaire de d'ajout de la vente --}}

                        <form action="{{ route('vente.store') }}" method="post">
                            <div class="modal-body">

                                @csrf                               

                                <div class="row mb-3">
                                    <div class="col-12 " style="background:#7e7b7b; color:white!important; padding:10px ">
                                        <strong>Ajoutez vos produits vendus</strong>
                                    </div>
                                </div>


                                           
                                <div class="row">
                                    <div class="col-12">
                                        <div class="mb-3 mt-2 ">
                                            <button class="btn btn-warning  ajouter_charge" id="ajouter_charge"
                                                style="margin-left: 53px;">
                                                <i class="mdi mdi-plus">Ajouter produit</i>
                                            </button>
                                        </div>
                                        <hr>
                                        <div class="produit-vendu">

                                        </div>
                                    </div>
                                </div>

                                <br><hr>
                                <div class="row">

                                    

                                    <div class="col-sm-6 col-xl-3 ">
                                        <div class="mb-3 ">
                                            <label for="date_vente" class="form-label">
                                                Date de la vente
                                            </label>
                                            <input type="date" id="date_vente" name="date_vente"
                                                value="{{ old('date_vente') ? old('date_vente') : date('Y-m-d') }}"
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

                                </div>

                            </div>


                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div> <!-- end col -->


           
             
            <button type="submit"
                style="position: fixed;bottom: 10px; margin: 0;  left: 50%; z-index:1 ; width:200px; height:50px;"
                class="btn btn-dark btn-flat btn-addon btn-lg">Enregistrer
            </button>
           
            </form>

        </div>
        <!-- end row -->


    </div> <!-- End Content -->


    <style>
        .container_email_label {
            display: flex;
            flex-flow: row wrap;
            gap: 5px;
        }

        .container_email_input {
            display: flex;
            flex-flow: row nowrap;
            justify-content: space-between;
            /* gap: 5px; */
        }

        .item_email {
            flex-grow: 11;
        }

        .item_btn_remove {
            flex-grow: 1;
        }

        .container_indicatif {
            display: flex;
            flex-flow: row wrap;
            gap: 5px;

        }

        .item_indicatif {
            flex-grow: 2;
        }

        .item_input {
            flex-grow: 10;
        }
    </style>
@endsection

@section('script')

    <script src="{{ asset('assets/js/sweetalert2.all.js') }}"></script>




    <script>
        $(document).ready(function() {
            var y = 1;

            $('.ajouter_charge').click(function(e) {
                e.preventDefault();    
                
                    var ligne_nouveau_produit = `
                                  
                    <div class="row">

                        <div class="col-md-4 col-xl-3 ">
                            <div class=" mb-3">
                                <label for="produit${y}" class="form-label">
                                    Produits
                                </label>
                                <select name="produit${y}" id="produit${y}" class=" select_produit form-control select2" required
                                    data-toggle="select2">
                                    <option value=""></option>
                                    @foreach ($produits as $produit)
                                        <option value="{{ $produit->id }}"
                                            prix="{{ $produit->prix_vente_ttc }}" unite_mesure="{{ $produit->unite_mesure }}" >
                                            {{ $produit->nom }} 
                                        </option>
                                    @endforeach
                                </select>                                
                            </div>

                        </div>


                        <div class="col-md-3 col-xl-2 ">
                            <div class="mb-3 ">
                                <label for="prix${y}" class="form-label">
                                Prix <span class="text-danger">*</span>
                                </label>
                                <input type="number" id="prix${y}" name="prix${y}" min="0" step="1" value=""
                                    class="form-control prix_ttc" required>                                
                            </div>
                        </div>


                        <div class="col-md-3 col-xl-2 ">
                            <div class="mb-3 ">
                                <label for="quantite${y}" class="form-label">
                                <span class="libelle_quantite"></span> <span class="text-danger">*</span>
                                </label>
                                <input type="number" id="quantite${y}" name="quantite${y}" min="0" step="0.01"  value=""                                 
                                    class="form-control" required>
                               
                            </div>
                        </div>
                        <div class="col-md-1 col-xl-1 mb-3 mt-3"> <label class="form-label" for="">&nbsp;</label> <a href="#" class="supprimer_produit btn btn-danger btn-sm"><i class="mdi mdi-delete"></i></a></div></br>

                        </div>
                        `;

                $('.produit-vendu').append(ligne_nouveau_produit);
                // Réinitialiser le plugin select2 pour le nouveau champ ajouté
                $('#produit'+y).select2();
                y++;

            });



            $(".produit-vendu").on("click", ".supprimer_produit", function(e) {
                e.preventDefault();
                $(this).parent().parent('div').remove();
                y--;
            })



        });
    </script>

    
    <script>
        var produits = @json($produits);
        var tab_produits = [];
        
        
        produits.forEach(element => {
            tab_produits[element.id] = element;
        });
            
     
        //    Lorsqu'on change le produit
        
        $(document).on('change', '.select_produit', function() { 
            var id = $(this).val();
            var prix_ttc = tab_produits[id].prix_vente_ttc;
            
            var unite_mesure = tab_produits[id].unite_mesure_stock;
            var text = unite_mesure == "Kilo" ? "Nombre de kilos" : "Quantité";
            $(this).parent().parent().parent().find('.libelle_quantite').text(text );     
            console.log(tab_produits);       
      
            console.log( $(this).parent().parent());
            $(this).parent().parent().parent().find('.prix_ttc').val(prix_ttc);
          
        });
        
    </script>

   
@endsection