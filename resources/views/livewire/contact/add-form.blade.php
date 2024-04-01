<form action="{{ route('contact.store') }}" method="post" id="add-contact">
    @csrf


    <div class="row">
        <div class="col-12 mb-3" style="background:#7e7b7b; color:white!important; padding:10px ">
            <strong>Informations principales
        </div>

        <div class="row">

            <div class="col-md-12 col-lg-9">
                <div class="card">
                    <div class="card-body">

                        @if ($displaytypecontact == true)
                            <div class="row">
                                <div class="col-6">

                                    <div class="mb-3 ">
                                        <label for="type" class="form-label">
                                            Type de contact <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-select select2" id="type" name="type"
                                            wire:model="type">
                                            @foreach ($typecontacts as $type)
                                                <option value="{{ $type->type }}">{{ $type->type }}</option>
                                            @endforeach
                                        </select>

                                        @if ($errors->has('type'))
                                            <br>
                                            <div class="alert alert-warning text-secondary " role="alert">
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="alert" aria-label="Close">
                                                </button>
                                                <strong>{{ $errors->first('type') }}</strong>
                                            </div>
                                        @endif
                                    </div>

                                </div>
                            </div>
                        @else 
                            <input type="hidden" name="type" wire:model="type">

                        @endif
                        





                        <div class="row">


                            <div class="col-sm-6">

                              
                                    <div class="mb-3 div_personne_physique">
                                        <label for="nom" class="form-label">
                                            Nom <span class="text-danger">*</span>
                                        </label>

                                        <div class="container_indicatif">                                         
                                                <div class="item_indicatif">
                                                    <select class="form-select select2" id="civilite"
                                                        name="civilite" wire:model.defer="civilite">

                                                        <option value="M.">M.</option>
                                                        <option value="Mme">Mme</option>
                                                    </select>

                                                    @if ($errors->has('civilite'))
                                                        <br>
                                                        <div class="alert alert-warning text-secondary "
                                                            role="alert">
                                                            <button type="button" class="btn-close btn-close-white"
                                                                data-bs-dismiss="alert" aria-label="Close"></button>
                                                            <strong>{{ $errors->first('civilite') }}</strong>
                                                        </div>
                                                    @endif


                                                </div>
                                           
                                            <div class="item_input">
                                                <input type="text" id="nom" name="nom"
                                                    wire:model.defer="nom" required
                                                    value="{{ old('nom') ? old('nom') : '' }}" class="form-control">
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
                                                name="indicatif_1" style="width:100%"
                                                wire:model.defer="indicatif_1">
                                                @include('livewire.indicatifs-pays')

                                            </select>

                                            </select>
                                        </div>
                                        <div class="item_input">
                                            <input type="text" id="telephone_1" name="telephone_1"
                                                wire:model.defer="telephone_1"
                                                value="{{ old('telephone_1') ? old('telephone_1') : '' }}"
                                                class="form-control telephones">
                                        </div>

                                    </div>
                                    @if ($errors->has('telephone_1'))
                                        <br>
                                        <div class="alert alert-warning text-secondary " role="alert">
                                            <button type="button" class="btn-close btn-close-white"
                                                data-bs-dismiss="alert" aria-label="Close"></button>
                                            <strong>{{ $errors->first('telephone_1') }}</strong>
                                        </div>
                                    @endif
                                </div>

                                <div class="mb-3 ">
                                    <label for="email" class="form-label">
                                        Email
                                    </label>
                                    <input type="email" id="email" name="email" wire:model.defer="email" 
                                        value="{{ old('email') ? old('email') : '' }}" class="form-control">

                                    @if ($errors->has('email'))
                                        <br>
                                        <div class="alert alert-warning text-secondary " role="alert">
                                            <button type="button" class="btn-close btn-close-white"
                                                data-bs-dismiss="alert" aria-label="Close"></button>
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </div>
                                    @endif
                                </div>
                                
                            </div>



                            <div class="col-sm-6">

                                <div class="mb-3 div_personne_physique">
                                    <label for="prenom" class="form-label">
                                        Prénom(s) 
                                    </label>
                                    <input type="text" id="prenom" name="prenom"
                                        wire:model.defer="prenom" 
                                        value="{{ old('prenom') ? old('prenom') : '' }}" class="form-control">

                                    @if ($errors->has('prenom'))
                                        <br>
                                        <div class="alert alert-warning text-secondary " role="alert">
                                            <button type="button" class="btn-close btn-close-white"
                                                data-bs-dismiss="alert" aria-label="Close"></button>
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
                                                name="indicatif_2" style="width:100%"
                                                wire:model.defer="indicatif_2">
                                                @include('livewire.indicatifs-pays')
    
                                            </select>
    
                                            </select>
                                        </div>
                                        <div class="item_input">
                                            <input type="text" id="telephone_2" name="telephone_2"
                                                wire:model.defer="telephone_2"
                                                value="{{ old('telephone_2') ? old('telephone_2') : '' }}"
                                                class="form-control telephones">
                                        </div>
    
                                    </div>
                                    @if ($errors->has('telephone_2'))
                                        <br>
                                        <div class="alert alert-warning text-secondary " role="alert">
                                            <button type="button" class="btn-close btn-close-white"
                                                data-bs-dismiss="alert" aria-label="Close"></button>
                                            <strong>{{ $errors->first('telephone_2') }}</strong>
                                        </div>
                                    @endif
                                </div>
                            </div>

                       


                        </div>

                        <div class="row mb-3">
                            <div class="col-12 " style="background:#7e7b7b; color:white!important; padding:10px ">
                                <strong>Informations Complémentaires</strong>
                            </div>
                        </div>

                        <div class="row" wire:ignore>


                            <div class="col-6">
                              
                                <div class="mb-3">
                                    <label for="ville" class="form-label">
                                        Ville
                                    </label>
                                    <input type="text" id="ville" name="ville" wire:model.defer="ville"
                                        value="{{ old('ville') ? old('ville') : '' }}" class="form-control">

                                    @if ($errors->has('ville'))
                                        <br>
                                        <div class="alert alert-warning text-secondary " role="alert">
                                            <button type="button" class="btn-close btn-close-white"
                                                data-bs-dismiss="alert" aria-label="Close"></button>
                                            <strong>{{ $errors->first('ville') }}</strong>
                                        </div>
                                    @endif
                                </div>

                            </div>



                            <div class="col-6">

                                <div class="mb-3">
                                    <label for="quartier" class="form-label">
                                        quartier/commune
                                    </label>
                                    <input type="text" id="quartier" name="quartier" wire:model.defer="quartier"
                                        value="{{ old('quartier') ? old('quartier') : '' }}"
                                        class="form-control">

                                    @if ($errors->has('quartier'))
                                        <br>
                                        <div class="alert alert-warning text-secondary " role="alert">
                                            <button type="button" class="btn-close btn-close-white"
                                                data-bs-dismiss="alert" aria-label="Close"></button>
                                            <strong>{{ $errors->first('quartier') }}</strong>
                                        </div>
                                    @endif
                                </div>

                             



                                <div class="mb-3">
                                    <label for="notes" class="form-label">Notes</label>
                                    <textarea name="notes" wire:model.defer="notes" class="form-control" id="notes" rows="5"
                                        placeholder="...">{{ old('notes') ? old('notes') : '' }}</textarea>
                                    @if ($errors->has('notes'))
                                        <br>
                                        <div class="alert alert-warning text-secondary " role="alert">
                                            <button type="button" class="btn-close btn-close-white"
                                                data-bs-dismiss="alert" aria-label="Close"></button>
                                            <strong>{{ $errors->first('notes') }}</strong>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>



                        <div class="row mt-3">
                            <div class="modal-footer">

                                <button type="submit" id="enregistrer" wire:click="submit"
                                    class="btn btn-primary">Enregistrer</button>

                            </div>
                        </div>
                        <!-- end row -->

                    </div> <!-- end card-body -->
                </div> <!-- end card-->
            </div> <!-- end col-->


            <div class="col-md-12 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="row">

                            <div class="col-12">
                               
                                    <div class="mb-3 ">
                                        <label for="entreprise" class="form-label">
                                            Entreprise
                                        </label>
                                        <input type="text" id="entreprise" name="entreprise" wire:model.defer="entreprise"
                                            value="{{ old('entreprise') ? old('entreprise') : '' }}" class="form-control">

                                        @if ($errors->has('entreprise'))
                                            <br>
                                            <div class="alert alert-warning text-secondary " role="alert">
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="alert" aria-label="Close">
                                                </button>
                                                <strong>{{ $errors->first('entreprise') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                
                            </div>



                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
    <!-- end row-->
</form>
