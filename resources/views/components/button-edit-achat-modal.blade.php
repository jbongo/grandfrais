<span id="tooltip-show">
    @if ($permission)
        <a href="{{ $route }}" data-bs-toggle="modal" data-bs-target="#modal-edit-achat" data-bs-container="#tooltip-show"           
            data-bs-toggle="tooltip" data-bs-placement="top" 
            title="{{ $tooltip }}"
            data-produitid = "{{$produitId}}"
            data-quantite = "{{$quantite}}"
            data-dateachat = {{$dateAchat}}
            data-prixtotal = "{{$prixTotal}}"
            data-fournisseurid = "{{$fournisseurId}}"
            data-caisseid = "{{$caisseId}}"
            data-href = "{{$route}}"
            class="action-icon edit-achat text-success"> <i class="mdi mdi-square-edit-outline"></i>
        </a>

    @endif
</span>
