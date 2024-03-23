<span id="tooltip-show">
    @if ($permission)
        <a href="{{ $route }}" data-bs-toggle="modal" data-bs-target="#edit-modal" data-bs-container="#tooltip-show"           
            data-bs-toggle="tooltip" data-bs-placement="top" data-details = "{{$details}}"   title="{{ $tooltip }}"
            data-montant = "{{$montant}}" data-date_depense = "{{$datedepense}}" data-typedepense_id = {{$typedepenseid}}  data-href = "{{$href}}"
            class="action-icon edit-depense text-success"> <i class="mdi mdi-square-edit-outline"></i>
        </a>
    @endif
</span>
