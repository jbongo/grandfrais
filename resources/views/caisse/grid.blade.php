@foreach ($caisses as $caisse)

    <div class=" col-sm-6 col-md-6 col-lg-6  col-xl-4  ">
        <div class="card">
            <div class="card-body" @if($caisse->est_actif == false) style="background-color: #e7e8e7;" @endif>
                <div class="dropdown float-end">
                    <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="mdi mdi-dots-horizontal"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end">
                        <!-- item-->
                        <a href="{{route('caisse.show', Crypt::encrypt($caisse->id))}}" class="dropdown-item">Détails</a>                       
                    </div>
                </div>

                <div class="text-center">
                    <a href="{{route('caisse.show', Crypt::encrypt($caisse->id))}}" class="text-dark">  
                        <img src="{{asset('/images/logo-caisse.jpg')}}" class="rounded-circle avatar-md img-thumbnail" alt="friend">
                    </a>
                    <h4 class="mt-3 my-1"> <a href="{{route('caisse.show', Crypt::encrypt($caisse->id))}}" class="text-dark"> {{$caisse->nom}} </a> </h4>
                    <p class="mb-0 text-muted mt-2">
                        <div class="flex-grow-1 ms-3">
                            <h4 class="mt-0 mb-1 font-20 text-primary">{{number_format($caisse->solde, 0, ',', '.')}} FCFA</h4>
                     
                        </div>
                    </p>
                    <hr class="bg-dark-lighten my-3">
                  
                    <div class="row">
                        <div class="col-6">
                            <a href="#" data-href="{{route('caisse.operation',[ Crypt::encrypt($caisse->id), "dépot"])}}" class="btn btn-info w-100 depot-caisse" data-bs-toggle="modal" data-bs-target="#depot-caisse"  data-bs-toggle="tooltip" data-bs-placement="top" title="Dépot"> Dépot</a>
                        </div>      
                                                    
                        <div class="col-6">
                            <a href="#" data-href="{{route('caisse.operation',[ Crypt::encrypt($caisse->id), "retrait"])}}" class="btn btn-danger w-100 retrait-caisse" data-bs-toggle="modal" data-bs-target="#retrait-caisse"    data-bs-toggle="tooltip" data-bs-placement="top" title="Retrait"> Retrait</a>
                        </div>   
                    </div>
                    
                    <div class="row mt-4" style="overflow-wrap: normal;display: flex; flex-direction: row; justify-content:center" >                    
                            
                        <div class="col-4">
                            <a href="" class="btn w-100 btn-light text-success" data-bs-toggle="tooltip" data-bs-placement="top" title="Modifier la caisse"><i class="mdi mdi-lead-pencil"></i></a>
                        </div>
                        <div class="col-4">
                            <a href="{{route('caisse.show', Crypt::encrypt($caisse->id))}}" class="btn w-100 btn-light text-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Détail de la caisse"><i class="mdi mdi-eye-outline"></i></a>
                        </div>
                        <div class="col-4">
                            <a href="" class=" btn w-100 btn-light  text-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Archiver la caisse"><i class="mdi mdi-content-duplicate"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- End col -->

@endforeach

<!-- Dépot caisse -->
<div id="depot-caisse" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="info-header-modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header modal-colored-header bg-info">
                <h4 class="modal-title" id="info-header-modalLabel">Faire un dépot</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <form action="#" method="post" id="form-depot">
                <div class="modal-body">
                    @csrf
    
    
                    <div class="row">
                      
                        <div class="col-md-12 col-lg-12">
                            <div class="card">
                                <div class="card-body">
    
                                    <div class="row">
    
    
                                        <div class="col-12">
                                            <div class="mb-3">
                                                <label for="montant" class="form-label">
                                                    Montant <span class="text-danger">*</span>
                                                </label>
                                                <input type="number"  min="0" step="1" id="montant" name="montant" required value="{{ old('montant') ? old('montant') : '' }}" class="form-control">
    
                                                @if ($errors->has('montant'))
                                                    <br>
                                                    <div class="alert alert-warning text-secondary " role="alert">
                                                        <button type="button" class="btn-close btn-close-white"
                                                            data-bs-dismiss="alert" aria-label="Close"></button>
                                                        <strong>{{ $errors->first('montant') }}</strong>
                                                    </div>
                                                @endif
                                            </div>   
                                            <div class="mb-3">
                                                <label for="date_operation" class="form-label">
                                                    Date de dépot <span class="text-danger">*</span> 
                                                </label>
                                                <input type="date"  id="date_operation" name="date_operation" required value="{{ old('date_operation') ? old('date_operation') : date('Y-m-d') }}" class="form-control">
    
                                                @if ($errors->has('date_operation'))
                                                    <br>
                                                    <div class="alert alert-warning text-secondary " role="alert">
                                                        <button type="button" class="btn-close btn-close-white"
                                                            data-bs-dismiss="alert" aria-label="Close"></button>
                                                        <strong>{{ $errors->first('date_operation') }}</strong>
                                                    </div>
                                                @endif
                                            </div> 
                                            <div class="mb-3">
                                                <label for="description" class="form-label">
                                                    Origine des fonds <span class="text-danger">(Facultatif)</span> 
                                                </label>
                                                <textarea class="form-control" name="description" id="description"  > Fonds propres</textarea>
    
                                                @if ($errors->has('description'))
                                                    <br>
                                                    <div class="alert alert-warning text-secondary " role="alert">
                                                        <button type="button" class="btn-close btn-close-white"
                                                            data-bs-dismiss="alert" aria-label="Close"></button>
                                                        <strong>{{ $errors->first('description') }}</strong>
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
                    <button type="submit" class="btn btn-info">Enregistrer</button>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fermer</button>
    
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<!-- Retrait caisse -->
<div id="retrait-caisse" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="info-header-modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header modal-colored-header bg-danger">
                <h4 class="modal-title" id="info-header-modalLabel">Faire un retrait</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <form action="#" method="post" id="form-retrait">
                <div class="modal-body">
                    @csrf
    
    
                    <div class="row">
                      
                        <div class="col-md-12 col-lg-12">
                            <div class="card">
                                <div class="card-body">
    
                                    <div class="row">
    
    
                                        <div class="col-12">
                                            <div class="mb-3">
                                                <label for="montant" class="form-label">
                                                    Montant <span class="text-danger">*</span>
                                                </label>
                                                <input type="number"  min="0" step="1" id="montant" name="montant" required value="{{ old('montant') ? old('montant') : '' }}" class="form-control">
    
                                                @if ($errors->has('montant'))
                                                    <br>
                                                    <div class="alert alert-warning text-secondary " role="alert">
                                                        <button type="button" class="btn-close btn-close-white"
                                                            data-bs-dismiss="alert" aria-label="Close"></button>
                                                        <strong>{{ $errors->first('montant') }}</strong>
                                                    </div>
                                                @endif
                                            </div>   
                                            <div class="mb-3">
                                                <label for="date_operation" class="form-label">
                                                    Date de retrait <span class="text-danger">*</span> 
                                                </label>
                                                <input type="date"  id="date_operation" name="date_operation" required value="{{ old('date_operation') ? old('date_operation') : date('Y-m-d') }}" class="form-control">
    
                                                @if ($errors->has('date_operation'))
                                                    <br>
                                                    <div class="alert alert-warning text-secondary " role="alert">
                                                        <button type="button" class="btn-close btn-close-white"
                                                            data-bs-dismiss="alert" aria-label="Close"></button>
                                                        <strong>{{ $errors->first('date_operation') }}</strong>
                                                    </div>
                                                @endif
                                            </div> 
                                            <div class="mb-3">
                                                <label for="description" class="form-label">
                                                    Origine des fonds <span class="text-danger">(Facultatif)</span> 
                                                </label>
                                                <textarea class="form-control" name="description" id="description"  > </textarea>
    
                                                @if ($errors->has('description'))
                                                    <br>
                                                    <div class="alert alert-warning text-secondary " role="alert">
                                                        <button type="button" class="btn-close btn-close-white"
                                                            data-bs-dismiss="alert" aria-label="Close"></button>
                                                        <strong>{{ $errors->first('description') }}</strong>
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
                    <button type="submit" class="btn btn-danger">Enregistrer</button>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fermer</button>
    
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->