<span id="tooltip-show">
    @if ($permission)
        <a href="{{ $route }}" data-bs-toggle="modal" data-bs-target="#edit-modal" data-bs-container="#tooltip-show"           
            data-bs-toggle="tooltip" data-bs-placement="top" 
            title="{{ $tooltip }}"
            data-produit_id = "{{$vente->produit_id}}" data-quantite = "{{$vente->quantite}}"
             data-date_vente = {{$datevente}}  data-href = "{{$href}}"
            class="action-icon edit-vente text-success"> <i class="mdi mdi-square-edit-outline"></i>
        </a>

    @endif
</span>
