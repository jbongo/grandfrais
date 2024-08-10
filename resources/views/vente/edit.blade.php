@extends('layouts.app')
@section('css')
    <link href="{{ asset('assets/css/vendor/dataTables.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/vendor/responsive.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/css/intlTelInput.css">

@endsection

@section('title', 'Modifier vente')

@section('content')


    <style>
        .container-gauche {

            display: flex;
            justify-content: flex-end;
            gap: 10px;

        }
        body {

        font-size: 15px!important;
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

                        <form action="{{ route('vente.update', Crypt::encrypt($vente->id)) }}" method="post">
                            <div class="modal-body">

                                @csrf                               

                                <div class="row mb-3">
                                    <div class="col-12 " style="background:#7e7b7b; color:white!important; padding:10px ">
                                        <strong>Modifiez vos produits vendus</strong>
                                    </div>
                                </div>


                                           
                                <div class="row">
                                    <div class="col-12">
                                        <div class="mb-3 mt-2 ">
                                            <button class="btn btn-warning  modifier_charge" id="modifier_charge"
                                                style="margin-left: 53px;">
                                                <i class="mdi mdi-plus">Modifier produit</i>
                                            </button>
                                        </div>
                                        <hr>
                                        <div class="produit-vendu">
                                            
                                            @foreach ($vente->produits as $key =>$prod)
                                                
                                                
                                                <div class="row">
                                                    <div class="col-md-4 col-xl-3 ">
                                                        <div class=" mb-3">
                                                            <label for="produit{{$key}}" class="form-label">
                                                                Produits
                                                            </label>
                                                            <select name="produit{{$key}}" id="produit{{$key}}" class=" select_produit form-control select2" required
                                                                data-toggle="select2">
                                                                <option value="{{ $prod->id }}">{{$prod->nom}}</option>
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
                                                            <label for="quantite{{$key}}" class="form-label">
                                                            <span class="libelle_quantite"></span> <span class="text-danger">*</span>
                                                            </label>
                                                            <input type="number" id="quantite{{$key}}"  name="quantite{{$key}}" min="0" step="0.01"  value="{{$prod->pivot?->quantite}}" 
                                                                class="form-control quantite_nombre_kilo_produit" required>
                                                        
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3 col-xl-2 ">
                                                        <div class="mb-3 ">
                                                            <label for="prix{{$key}}" class="form-label">
                                                            Prix total<span class="text-danger">*</span>
                                                            </label>
                                                            <input type="number" id="prix{{$key}}" name="prix{{$key}}" min="0" step="1" value="{{$prod->pivot?->prix_total}}"
                                                                class="form-control prix_ttc" required>                                
                                                        </div>
                                                    </div>


                                                    
                                                    <input type="hidden" name="pivot_id{{$key}}" value="{{ $prod->pivot->id }}">

                                                    <div class="col-md-1 col-xl-1 mb-3 mt-3"> <label class="form-label" for="">&nbsp;</label> <a href="#" class="supprimer_produit btn btn-danger btn-sm"><i class="mdi mdi-delete"></i></a></div></br>

                                                    </div>

                                            @endforeach

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
                                                value="{{ old('date_vente') ? old('date_vente') : $vente->date_vente }}"
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
                class="btn btn-success btn-flat btn-addon btn-lg">Modifier
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
            var y = {{$produits->count()}};

            $('.modifier_charge').click(function(e) {
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
                                            {{ $produit->nom }} |
                                            {{ number_format($produit->prix_vente_ttc, 2, ',', ' ') }}
                                            FCFA
                                        </option>
                                    @endforeach
                                </select>                                
                            </div>

                        </div>
                        <div class="col-md-3 col-xl-2 ">
                            <div class="mb-3 ">
                                <label for="quantite${y}" class="form-label">
                                <span class="libelle_quantite"></span> <span class="text-danger">*</span>
                                </label>
                                <input type="number" id="quantite${y}"  name="quantite${y}" min="0" step="0.01" value="" 
                                    class="form-control quantite_nombre_kilo_produit" required>
                               
                            </div>
                        </div>

                        <div class="col-md-3 col-xl-2 ">
                            <div class="mb-3 ">
                                <label for="prix${y}" class="form-label">
                                Prix total <span class="text-danger">*</span>
                                </label>
                                <input type="number" id="prix${y}" name="prix${y}" min="0" step="1" value=""
                                    class="form-control prix_ttc" required>                                
                            </div>
                        </div>


                       
                        <input type="hidden" name="pivot_id${y}" value="">

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
            var prix_unitaire_ttc = tab_produits[id].prix_vente_ttc;
            
            var unite_mesure = tab_produits[id].unite_mesure_stock;
            var text = unite_mesure == "Kilo" ? "Nombre de kilos" : "Quantité";
            $(this).parent().parent().parent().find('.libelle_quantite').text(text );     
            // console.log(tab_produits);       
      
            // console.log( $(this).parent().parent());
            var quantite = $(this).parent().parent().parent().find('.quantite_nombre_kilo_produit').val();

            var total = prix_unitaire_ttc != null ? quantite * prix_unitaire_ttc : 0;
            $(this).parent().parent().parent().find('.prix_ttc').val(total);
          
        });

        // Lorsqu'on saisi la quantité du produit        
        $(document).on('keyup', '.quantite_nombre_kilo_produit', function() { 
            var id =  $(this).parent().parent().parent().find('.select_produit').val()
            
            var quantite = $(this).val();
            var prix_unitaire_ttc = tab_produits[id]?.prix_vente_ttc;
            var total = prix_unitaire_ttc != null ? quantite * prix_unitaire_ttc : 0;
            $(this).parent().parent().parent().find('.prix_ttc').val(total);
     
          
        });
        
    </script>

   
@endsection