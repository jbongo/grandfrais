@extends('layouts.app')
@section('css')
    <link href="{{ asset('assets/css/vendor/dataTables.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/vendor/responsive.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/css/intlTelInput.css">
@endsection

@section('content')
    <div class="content">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="">Utilisateurs</a></li>
                        </ol>
                    </div>
                    <h4 class="page-title">Utilisateurs</h4>
                </div>
            </div>

            <div class="col-12">
                <div class="card widget-inline">
                    <div class="card-body p-0">
                        <div class="row g-0">

                            <div class="col-sm-2 ">
                                {{-- <a href="{{ URL::previous() }}" type="button" class="btn btn-outline-primary"><i
                                        class="uil-arrow-left"></i>
                                    Retour</a> --}}
                                <a href="{{ route('utilisateur.index') }}" type="button" class="btn btn-outline-primary"><i
                                        class="uil-arrow-left"></i>
                                    Utilisateurs</a>

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


                       

                        <form action="{{ route('utilisateur.update', Crypt::encrypt($user->id)) }}" method="post">
                            @csrf

                            <div class="row">
                        
                                <div class="col-md-12 col-lg-9">
                                    <div class="card">
                                        <div class="card-body">
                        
                                            <div class="row mb-3">
                                                <div class="col-12 " style="background:#7e7b7b; color:white!important; padding:10px ">
                                                    <strong>Informations de connexion</strong>
                                                </div>
                                            </div>
                        
                                            <div class="row">
                                                <div class="col-sm-6">
                        
                                                    <div class="mb-3">
                                                        <label for="email" class="form-label">
                                                            Email de connexion<span class="text-danger">*</span>
                                                        </label>
                        
                                                        <input type="email" id="email" name="email" required
                                                            value="{{ old('email') ? old('email') : $user->email }}" class="form-control emails">
                                                        @if ($errors->has('email'))
                                                        <br>
                                                        <div class="alert alert-warning text-secondary " role="alert">
                                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                                                                aria-label="Close"></button>
                                                            <strong>{{ $errors->first('email') }}</strong>
                                                        </div>
                                                        @endif
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="password" class="form-label">
                                                            Mot de passe <span class="text-danger">(Si seulement vous souhaitez le modifier)</span>
                                                        </label>
                        
                                                        <input type="text" id="password" name="password"  value="{{ old('password') ? old('password') : '' }}" class="form-control ">
                                                        @if ($errors->has('password'))
                                                            <br>
                                                            <div class="alert alert-warning text-secondary " role="alert">
                                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                                                                    aria-label="Close"></button>
                                                                <strong>{{ $errors->first('password') }}</strong>
                                                            </div>
                                                        @endif
                                                    </div>
                        
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="mb-3">
                                                        <label for="role" class="form-label">
                                                            Rôle <span class="text-danger">*</span>
                                                        </label>
                        
                                                        <select class="form-select select2" id="role" name="role">
                                                            <option value="{{ $user->role_id}}">{{ $user->role?->nom }}</option>
                                                            @foreach ($roles as $role)
                                                            <option value="{{ $role->id }}">{{ $role->nom }}</option>
                                                            @endforeach
                                                        </select>
                        
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
                        
                                            </div>
                        
                        
                                            <div class="nouveau_contact" >
                                                <div class="row mb-3">
                                                    <div class="col-12 " style="background:#7e7b7b; color:white!important; padding:10px ">
                                                        <strong>Informations principales</strong>
                                                    </div>
                                                </div>
                        
                                                <input type="hidden" name="nature" value="Personne physique">
                                                <input type="hidden" name="type_contact" value="Collaborateur">
                        
                                                <div class="row">
                        
                                                    <div class="col-sm-6">
                                                        <div class="mb-3 div_personne_physique">
                                                            <label for="nom" class="form-label">
                                                                Nom <span class="text-danger">*</span>
                                                            </label>
                        
                                                            <div class="container_indicatif">
                        
                                                                <div class="item_indicatif">
                                                                    <select class="form-select select2" id="civilite" name="civilite">
                                                                        <option value="{{ $user->contact?->civilite }}">{{ $user->contact?->civilite }}</option>
                                                                        <option value="M.">M.</option>
                                                                        <option value="Mme">Mme</option>
                                                                    </select>
                        
                                                                    @if ($errors->has('civilite'))
                                                                    <br>
                                                                    <div class="alert alert-warning text-secondary " role="alert">
                                                                        <button type="button" class="btn-close btn-close-white"
                                                                            data-bs-dismiss="alert" aria-label="Close"></button>
                                                                        <strong>{{ $errors->first('civilite') }}</strong>
                                                                    </div>
                                                                    @endif
                        
                        
                                                                </div>
                        
                                                                <div class="item_input">
                                                                    <input type="text" id="nom" name="nom" required
                                                                        value="{{ old('nom') ? old('nom') : $user->contact?->nom }}" class="form-control">
                                                                    @if ($errors->has('nom'))
                                                                    <br>
                                                                    <div class="alert alert-warning text-secondary " role="alert">
                                                                        <button type="button" class="btn-close btn-close-white"
                                                                            data-bs-dismiss="alert" aria-label="Close"></button>
                                                                        <strong>{{ $errors->first('nom') }}</strong>
                                                                    </div>
                                                                    @endif
                                                                </div>
                        
                                                            </div>
                        
                                                        </div>
                        
                        
                                                        <style>
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
                        
                                                        <div class="mb-3">
                                                            <label for="telephone_1" class="form-label">
                                                                Téléphone 1
                                                            </label>
                        
                                                            <div class="container_indicatif">
                                                                <div class="item_indicatif">
                                                                    <select class="form-select select2" id="indicatif_1"
                                                                        name="indicatif_1" style="width:100%">
                        
                                                                        @include('livewire.indicatifs-pays')
                        
                                                                    </select>                        
                        
                                                                </div>
                                                                
                                                                <div class="item_input">
                                                                    <input type="text" id="telephone_1" name="telephone_1"
                                                                        value="{{ old('telephone_1') ? old('telephone_1') : $user->contact?->telephone_1 }}"
                                                                        class="form-control">
                                                                </div>
                        
                                                            </div>
                        
                                                            @if ($errors->has('telephone_1'))
                                                            <br>
                                                            <div class="alert alert-warning text-secondary " role="alert">
                                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                                                                    aria-label="Close"></button>
                                                                <strong>{{ $errors->first('telephone_1') }}</strong>
                                                            </div>
                                                            @endif
                                                        </div>
                        
                                                    </div>
                        
                        
                        
                                                    <div class="col-sm-6">
                        
                                                        <div class="mb-3 ">
                                                            <label for="prenom" class="form-label">
                                                                Prénom(s)
                                                            </label>
                                                            <input type="text" id="prenom" name="prenom"
                                                                value="{{ old('prenom') ? old('prenom') : $user->contact?->prenom }}" class="form-control">
                        
                                                            @if ($errors->has('prenom'))
                                                            <br>
                                                            <div class="alert alert-warning text-secondary " role="alert">
                                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                                                                    aria-label="Close"></button>
                                                                <strong>{{ $errors->first('prenom') }}</strong>
                                                            </div>
                                                            @endif
                                                        </div>
                        
                                                        <div class="mb-3">
                                                            <label for="telephone_2" class="form-label">
                                                                Téléphone 2
                                                            </label>
                                                            <div class="container_indicatif">
                                                                <div class="item_indicatif">
                                                                    <select class="form-select select2" id="indicatif_2"
                                                                        name="indicatif_2" style="width:100%">
                                                                        @include('livewire.indicatifs-pays')
                        
                                                                    </select>
                        
                                                                    </select>
                                                                </div>
                                                                <div class="item_input">
                                                                    <input type="text" id="telephone_2" name="telephone_2"
                                                                        value="{{ old('telephone_2') ? old('telephone_2') : $user->contact?->telephone_2 }}"
                                                                        class="form-control">
                                                                </div>
                        
                                                            </div>
                        
                                                            @if ($errors->has('telephone_2'))
                                                            <br>
                                                            <div class="alert alert-warning text-secondary " role="alert">
                                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                                                                    aria-label="Close"></button>
                                                                <strong>{{ $errors->first('telephone_2') }}</strong>
                                                            </div>
                                                            @endif
                                                        </div>
                        
                                                    </div>
                        
                                                </div>
                        
                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="mb-3">
                                                            <label for="ville" class="form-label">
                                                                Ville
                                                            </label>
                                                            <input type="text" id="ville" name="ville"
                                                                value="{{ old('ville') ? old('ville') : 'Abidjan' }}" class="form-control">
                        
                                                            @if ($errors->has('ville'))
                                                            <br>
                                                            <div class="alert alert-warning text-secondary " role="alert">
                                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                                                                    aria-label="Close"></button>
                                                                <strong>{{ $errors->first('ville') }}</strong>
                                                            </div>
                                                            @endif
                                                        </div>
                        
                                                    </div>
                        
                        
                        
                                                    <div class="col-6">
                                                        <div class="mb-3">
                                                            <label for="quartier" class="form-label">
                                                                Quartier
                                                            </label>
                                                            <input type="text" id="quartier" name="quartier"
                                                                value="{{ old('quartier') ? old('quartier') : $user->contact?->quartier }}" class="form-control">
                        
                                                            @if ($errors->has('quartier'))
                                                            <br>
                                                            <div class="alert alert-warning text-secondary " role="alert">
                                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                                                                    aria-label="Close"></button>
                                                                <strong>{{ $errors->first('quartier') }}</strong>
                                                            </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                        
                                            </div>
                        
                                            <div class="row mt-3">
                                                <div class="modal-footer">
                        
                                                    <button type="submit" id="enregistrerx" wire:click="submit"
                                                        class="btn btn-primary">Modifier</button>
                        
                                                </div>
                                            </div>
                                            <!-- end row -->
                        
                                        </div> <!-- end card-body -->
                                    </div> <!-- end card-->
                                </div> <!-- end col-->
                            </div>
                            <!-- end row-->                        
                        
                        
                        </form>
                    </div>


                        <style>
                            .select2-container .select2-selection--single {
                                height: calc(1.69em + 0.9rem + 2px);
                            }
                        </style>



                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div> <!-- end col -->
        </div>
        <!-- end row -->





    </div> <!-- End Content -->
@endsection

@section('script')


    @include('components.contact.edit_script')
@endsection
