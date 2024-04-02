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
                                    <a href="javascript:void(0);" data-href="" class="btn btn-primary w-100 depot_caisse"   data-bs-toggle="tooltip" data-bs-placement="top" title="Dépot"> Dépot</a>
                                </div>      
                                                           
                                <div class="col-6">
                                    <a href="javascript:void(0);" data-href="" class="btn btn-danger w-100 retrait_caisse"   data-bs-toggle="tooltip" data-bs-placement="top" title="Retrait"> Retrait</a>
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