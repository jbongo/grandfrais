@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/css/intlTelInput.css">

@endsection

@section('title', 'Calculer bénéfices')

@section('content')


    <div class="content">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('vente.index') }}">Bénéfices</a></li>
                        </ol>
                    </div>
                    <h4 class="page-title">Bénéfices</h4>
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

                        <form action="{{ route('benefices') }}" id="form-calcul" method="post">
                            <div class="modal-body">

                                @csrf
                                <div class="row">

                                    <div class="col-sm-4 col-xl-2 ">
                                        <div class="mb-3 ">
                                            <label for="date_debut" class="form-label">
                                                Date de début
                                            </label>
                                            <input type="date" id="date_debut" name="date_debut"
                                                value="{{ old('date_debut') ? old('date_debut') : date('Y-m-d') }}"
                                                class="form-control">

                                            @if ($errors->has('date_debut'))
                                                <br>
                                                <div class="alert alert-warning text-secondary " role="alert">
                                                    <button type="button" class="btn-close btn-close-white"
                                                        data-bs-dismiss="alert" aria-label="Close"></button>
                                                    <strong>{{ $errors->first('date_debut') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-sm-4 col-xl-2 ">
                                        <div class="mb-3 ">
                                            <label for="date_fin" class="form-label">
                                                Date de fin
                                            </label>
                                            <input type="date" id="date_fin" name="date_fin"
                                                value="{{ old('date_fin') ? old('date_fin') : date('Y-m-d') }}"
                                                class="form-control">

                                            @if ($errors->has('date_fin'))
                                                <br>
                                                <div class="alert alert-warning text-secondary " role="alert">
                                                    <button type="button" class="btn-close btn-close-white"
                                                        data-bs-dismiss="alert" aria-label="Close"></button>
                                                    <strong>{{ $errors->first('date_fin') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-sm-4 col-xl-2 ">
                                        <div class="mb-3 ">
                                            <label for="produit_id" class="form-label">
                                                Produits
                                            </label>
                                            
                                            <select name="produit_id" id="produit_id" class="form-control">
                                                <option value="">Tous les produits</option>
                                                @foreach ($produits as $produit)
                                                    <option value="{{ $produit->id }}"
                                                        {{ old('produit_id') == $produit->id ? 'selected' : '' }}>
                                                        {{ $produit->nom }}</option>
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
                                    </div>

                                </div>
                                
                                {{-- Afficher le montant du bénéfice --}}
                                <div class="row">

                                    <div class=" ">
                                        <label style="font-size: 18px; font-weight: bold"> Bénéfices : </label> <span style="font-size: 18px; font-weight: bold; color: #772e7b" id="benefices"></span>
                                    </div>
                                        

                            </div>

                        </div> <!-- end card-body-->
                    </div> <!-- end card-->
                </div> <!-- end col -->
            
                
                <button type="submit"
                    style="position: fixed;bottom: 10px; margin: 0;  left: 50%; z-index:1 ; width:200px; height:50px;"
                    class="btn btn-dark btn-flat btn-addon btn-lg">calculer
                </button>
           
            </form>

        </div>
        <!-- end row -->


    </div> <!-- End Content -->


@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $("form").submit(function(e) {
                e.preventDefault();
                $.post("/benefices", $(this).serialize(), function(data) {
                    let formattedData = new Intl.NumberFormat('fr-FR', { style: 'currency', currency: 'XOF' }).format(data).replace('XOF', 'Fcfa');
                    $("#benefices").text(formattedData);
                    // $("#benefices").text(data);
                });
            });
        });
    </script>
   
@endsection