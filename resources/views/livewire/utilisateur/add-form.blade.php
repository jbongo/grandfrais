<form action="{{ route('utilisateur.store') }}" method="post">
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

                                <input type="email" id="email" name="email" wire:model.defer="email" required
                                    value="{{ old('email') ? old('email') : '' }}" class="form-control emails">
                                @if ($errors->has('email'))
                                    <br>
                                    <div class="alert alert-warning text-secondary " role="alert">
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </div>
                                @endif
                            </div>

                            <div class="mb-3" wire:ignore>
                                <label for="telephone_mobile" class="form-label">
                                    Sélectionner un contact existant
                                </label>

                                <p>
                                    <input type="checkbox" id="contact_existant" wire:model.defer="contact_existant" name="contact_existant" data-switch="primary" />
                                    <label for="contact_existant" data-on-label="Oui" data-off-label="Non"></label>
                                </p>



                            </div>

                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="nom" class="form-label">
                                    Rôle <span class="text-danger">*</span>
                                </label>

                                <select class="form-select select2" id="role" name="role"
                                    wire:model.defer="role">

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




                            <div class="mb-3 ancien_contact" wire:ignore>
                                <label for="individu_id" class="form-label">
                                    Contact
                                </label>

                                <select class="form-control select2" data-toggle="select2" id="individu_id" name="individu_id"
                                    style="width:100%" wire:model.defer="individu_id">
                                    @foreach ($individus as $individu)
                                        <option value="{{ $individu->id }}">{{ $individu->prenom }}
                                            {{ $individu->nom }}
                                        </option>
                                    @endforeach
                                </select>

                                @if ($errors->has('individu_id'))
                                    <br>
                                    <div class="alert alert-warning text-secondary " role="alert">
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                        <strong>{{ $errors->first('individu_id') }}</strong>
                                    </div>
                                @endif
                            </div>

                        </div>


                    </div>

                    <div class="nouveau_contact" wire:ignore>
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
                                            <select class="form-select select2" id="civilite" name="civilite"
                                                wire:model.defer="civilite">

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
                                            <input type="text" id="nom" name="nom" wire:model.defer="nom"
                                                required value="{{ old('nom') ? old('nom') : '' }}"
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

                                    </div>

                                </div>


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

                                {{-- <input type="text" name="emailx" wire:model.defer="emailx" id="emailx"
                                    value="" hidden> --}}
                


                                <div class="mb-3">
                                    <label for="telephone_fixe" class="form-label">
                                        Téléphone Fixe
                                    </label>

                                    <div class="container_indicatif">
                                        <div class="item_indicatif">
                                            <select class="form-select select2" id="indicatif_fixe"
                                                name="indicatif_fixe" style="width:100%"
                                                wire:model.defer="indicatif_fixe">

                                                @include('livewire.indicatifs-pays')

                                            </select>


                                        </div>
                                        <div class="item_input">
                                            <input type="text"  id="telephone_fixe"
                                                name="telephone_fixe" wire:model.defer="telephone_fixe"
                                                value="{{ old('telephone_fixe') ? old('telephone_fixe') : '' }}"
                                                class="form-control">
                                        </div>

                                    </div>

                                    @if ($errors->has('telephone_fixe'))
                                        <br>
                                        <div class="alert alert-warning text-secondary " role="alert">
                                            <button type="button" class="btn-close btn-close-white"
                                                data-bs-dismiss="alert" aria-label="Close"></button>
                                            <strong>{{ $errors->first('telephone_fixe') }}</strong>
                                        </div>
                                    @endif
                                </div>

                            </div>



                            <div class="col-sm-6">

                                <div class="mb-3 ">
                                    <label for="prenom" class="form-label">
                                        Prénom(s)
                                    </label>
                                    <input type="text" id="prenom" name="prenom" wire:model.defer="prenom"
                                         value="{{ old('prenom') ? old('prenom') : '' }}"
                                        class="form-control">

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
                                    <label for="telephone_mobile" class="form-label">
                                        Téléphone Mobile
                                    </label>
                                    <div class="container_indicatif">
                                        <div class="item_indicatif">
                                            <select class="form-select select2" id="indicatif_mobile"
                                                name="indicatif_mobile" style="width:100%"
                                                wire:model.defer="indicatif_mobile">
                                                @include('livewire.indicatifs-pays')

                                            </select>

                                            </select>
                                        </div>
                                        <div class="item_input">
                                            <input type="text"  id="telephone_mobile"
                                                name="telephone_mobile" wire:model.defer="telephone_mobile"
                                                value="{{ old('telephone_mobile') ? old('telephone_mobile') : '' }}"
                                                class="form-control">
                                        </div>

                                    </div>



                                    @if ($errors->has('telephone_mobile'))
                                        <br>
                                        <div class="alert alert-warning text-secondary " role="alert">
                                            <button type="button" class="btn-close btn-close-white"
                                                data-bs-dismiss="alert" aria-label="Close"></button>
                                            <strong>{{ $errors->first('telephone_mobile') }}</strong>
                                        </div>
                                    @endif
                                </div>

                            </div>

                        </div>

                        <div class="row mb-3">
                            <div class="col-12 " style="background:#7e7b7b; color:white!important; padding:10px ">
                                <strong>Informations Complémentaires
                            </div>
                        </div>

                        <div class="row">


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
                                        Quartier
                                    </label>
                                    <input type="text" id="quartier" name="quartier" wire:model.defer="quartier"
                                        value="{{ old('quartier') ? old('quartier') : '' }}" class="form-control">

                                    @if ($errors->has('quartier'))
                                        <br>
                                        <div class="alert alert-warning text-secondary " role="alert">
                                            <button type="button" class="btn-close btn-close-white"
                                                data-bs-dismiss="alert" aria-label="Close"></button>
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
                                class="btn btn-primary">Enregistrer</button>

                        </div>
                    </div>
                    <!-- end row -->

                </div> <!-- end card-body -->
            </div> <!-- end card-->
        </div> <!-- end col-->
    </div>
    <!-- end row-->



</form>
