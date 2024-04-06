<div class="row">
    <div class="col-lg-8">
        <div class="col-12">
            <div class="mb-3">
                <label for="nom" class="form-label">Nom du produit *</label>
                <input type="text" class="form-control" name="nom" wire:model.defer="nom" value="{{ old('nom') }}"
                    id="nom" required>
                @if ($errors->has('nom'))
                    <br>
                    <div class="alert alert-danger" role="alert">
                        <i class="dripicons-wrong me-2"></i>
                        <strong>{{ $errors->first('nom') }}</strong>
                    </div>
                @endif
            </div>
        </div>
    


        <div class="row mb-3">
            <div class="col-12 " style="background:#7e7b7b; color:white!important; padding:10px ">
                <strong>Prix</strong>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <div class="col-12">
                    <label for="nom" id="tooltip-prix" class="form-label fs-5 mb-2 text-bold">Prix de Vente
                        <i class=" mdi mdi-information text-primary " data-bs-container="#tooltip-prix" data-bs-toggle="tooltip"
                            data-bs-placement="right" title="Prix de vente conseillé"></i>
                    </label>
                </div>
                
                <div class=" col-lg-6 col-xl-6 ">
    
                    <label for="prix_vente_ttc" class="form-label">Montant TTC </label>
                    <input type="number" step="0.001" min="0" class="form-control"
                        wire:model.defer="prix_vente_ttc" name="prix_vente_ttc" value="{{ old('prix_vente_ttc') }}"
                        id="prix_vente_ttc">
                    @if ($errors->has('prix_vente_ttc'))
                        <br>
                        <div class="alert alert-danger" role="alert">
                            <i class="dripicons-wrong me-2"></i>
                            <strong>{{ $errors->first('prix_vente_ttc') }}</strong>
                        </div>
                    @endif
    
                </div>
        
            </div>
        
        
            <div class="col-sm-6">
                <div class="col-12">
                    <label for="nom" id="tooltip-prix" class="form-label fs-5 mb-2 text-bold">Prix d'Achat
                        <i class=" mdi mdi-information text-primary " data-bs-container="#tooltip-prix"
                            data-bs-toggle="tooltip" data-bs-placement="right" title="Prix d'achat réel"></i>
                    </label>
                </div>
        
                <div class="row">
                    <div class=" col-lg-6 col-xl-6 mb-3">
                        <label for="prix_achat_ttc" class="form-label">Montant TTC </label>
                        <input type="number" step="0.001" min="0" class="form-control"
                            wire:model.defer="prix_achat_ttc" name="prix_achat_ttc" value="{{ old('prix_achat_ttc') }}"
                            id="prix_achat_ttc">
                            @if ($errors->has('prix_achat_ttc'))
                                <br>
                                <div class="alert alert-danger" role="alert">
                                    <i class="dripicons-wrong me-2"></i>
                                    <strong>{{ $errors->first('prix_achat_ttc') }}</strong>
                                </div>
                            @endif
                    </div>
                </div>
            </div>

        </div>
        




        <div class="row mb-3">
            <div class="col-12 " style="background:#7e7b7b; color:white!important; padding:10px ">
                <strong>Stock</strong>
            </div>
        </div>
        
        <div class="row">
            <div class="col-lg-6 div_stock">
                <div class="col-12">
                    <label for="nom" id="tooltip-prix" class="form-label fs-5 mb-2 text-bold">Quantités
                        <i class=" mdi mdi-information text-primary " data-bs-container="#tooltip-prix" data-bs-toggle="tooltip"
                            data-bs-placement="right" title="Quantité du produit en stock"></i>
                    </label>
                </div>
        
                <div class="row">
        
                    <div class="col-sm-6 col-xxl-6 mb-3">
                        <label for="quantite" class="form-label">Quantité</label>
                        <input type="number" min="0" class="form-control" wire:model.defer="quantite" name="quantite"
                            value="{{ old('quantite') }}" id="quantite">
                        @if ($errors->has('quantite'))
                            <br>
                            <div class="alert alert-danger" role="alert">
                                <i class="dripicons-wrong me-2"></i>
                                <strong>{{ $errors->first('quantite') }}</strong>
                            </div>
                        @endif
                    </div>
        
                    <div class="col-sm-6 col-xxl-6 mb-3">              
                        <div class="mb-3">
                            <label for="unite_mesure" class="form-label">Unité de mésure</label>
                            <select wire:model.defer="unite_mesure" name="unite_mesure" id="unite_mesure"
                                class="form-select select2">
                                <option value="Kilo">Kilo</option>
                                <option value="Unité">Unité</option>
                            </select>
                        </div>               
                    </div>        
                </div>
        
            </div>
        

        </div>
        
        
        <div class="row mt-3 div_stock">
            <div class="col-lg-6">
                <div class="col-12">
                    <label for="nom" id="tooltip-stock" class="form-label fs-5 mb-2 text-bold">Alertes
                        <i class=" mdi mdi-information text-primary " data-bs-container="#tooltip-stock"
                            data-bs-toggle="tooltip" data-bs-placement="right" title="Prix de vente à ne pas dépasser"></i>
                    </label>
                </div>
        
                <div class="row">
        
                    <div class="col-md-6 col-xxl-6">
                        <label for="seuil_alerte_stock" class="form-label">Niveau de stock au quel vous souhaitez être
                            alerté
                        </label>
                        <input type="number" min="0" class="form-control" placeholder="Laisser vide pour désactiver"
                            wire:model.defer="seuil_alerte_stock" name="seuil_alerte_stock"
                            value="{{ old('seuil_alerte_stock') }}" id="seuil_alerte_stock">
                        @if ($errors->has('seuil_alerte_stock'))
                            <br>
                            <div class="alert alert-danger" role="alert">
                                <i class="dripicons-wrong me-2"></i>
                                <strong>{{ $errors->first('seuil_alerte_stock') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>
        
        
            </div>
        
        
            <div class="col-6">
        
            </div>
        </div>
        

    </div>


   


    <div class="col-lg-4 ">

        <div class="row">
            <div class="col-sm-6 col-lg-12 mb-3">

                <div class="form-check form-check-inline">
                    <input type="radio" id="nature1" name="nature" wire:model.defer="nature" value="Matériel"
                        required class="form-check-input">
                    <label class="form-check-label" for="nature1">
                        Matériel
                    </label>

                </div>

                <div class="form-check form-check-inline">
                    <input type="radio" id="nature2" name="nature" wire:model.defer="nature"
                        value="Prestation de service" class="form-check-input">
                    <label class="form-check-label" for="nature2">
                        Prestation de service
                    </label>
                </div>

            </div>
        </div>

        <div class="col-12" wire:ignore>
            <div class="mb-3">
                <label for="categorie_id" class="form-label fw-bold fs-5 mb-2">Catégories </label>

                @include('produit.components.input-checkbox', ['categories' => $categories])

                <hr>
            </div>
        </div>

        <div class="col-12 mb-3">
            <label for="images" class="form-label fw-bold fs-5 mb-2">Photo(s) du produit </label>
            <div class="fallback">
                <input name="images[]" wire:model.defer="images" id="images"
                    class=" btn btn-secondary image-multiple" accept="image/*" type="file"
                    multiple />
            </div>
        </div>


    </div>
</div>

<div class="row mt-4">
    <div class="col-lg-8 mb-2">
        <hr style="height: 10px; ">

    </div>
  
</div>