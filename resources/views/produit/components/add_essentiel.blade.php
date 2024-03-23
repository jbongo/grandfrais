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
        <div class="col-12 mb-3" wire:ignore>
            <label for="description" class="form-label">Description *</label>

            <textarea rows="5" id="description" name="description" wire:model.defer="description"> </textarea>
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

    </div>
</div>

<div class="row mt-4">
    <div class="col-lg-8 mb-2">
        <hr style="height: 10px; ">

    </div>
    <div class="col-12">

        <div class="row">
            <div class="col-sm-2 mb-2 mb-sm-0">
                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <a class="nav-link active show" id="v-pills-photo-tab" data-bs-toggle="pill" href="#v-pills-photo"
                        role="tab" aria-controls="v-pills-photo" aria-selected="true">
                        <i class="mdi mdi-align-vertical-distribute d-md-none d-block"></i>
                        <span class="d-none d-md-block">Photos du produit</span>
                    </a>

                </div>
            </div> <!-- end col-->

            <div class="col-sm-9">
                <div class="tab-content" id="v-pills-tabContent">
                    <div class="tab-pane fade active show" id="v-pills-photo" role="tabpanel"
                        aria-labelledby="v-pills-photo-tab">


                        <div class="col-12 mb-3">
                            <label for="images" class="form-label fw-bold fs-5 mb-2">Photo(s) du produit </label>
                            <div class="fallback">
                                <input name="images[]" wire:model.defer="images" id="images"
                                    class=" btn btn-secondary image-multiple" accept="image/*" type="file"
                                    multiple />
                            </div>
                        </div>

                    </div>

                </div> <!-- end tab-content-->
            </div> <!-- end col-->
        </div>
        <!-- end row-->
    </div>
</div>