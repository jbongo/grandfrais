
<script async
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCD0y8QWgApdFG33-i8dVHWia-fIXcOMyc&libraries=places&callback=initAutocomplete"
    defer></script>
<script src="/js/mesfonctions.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        initAutocomplete();
    });
    formater_tel("#telephone", "#indicatif");
    formater_tel("#telephone_1", "#indicatif_1");
    formater_tel("#telephone_2", "#indicatif_2");

</script>











{{-- ####### --}}

{{-- Lorsqu'on submit le formulaire --}}
<script>
    $('#modifier').on("click", function(e) {
        e.preventDefault();

        var emails = [];
        var telephones = [];

        var email_inputs = $('.emails');
        var telephone_inputs = $('.telephones');

        email_inputs.each(function(index, input) {
            if (input.value !== "") emails.push(input.value);
        });

        telephone_inputs.each(function(index, input) {
            if (input.value !== "") telephones.push(input.value);
        });

        if (emails.length === 0 && telephones.length === 0) {
            swal.fire(
                'Erreur',
                'Veuillez renseigner au moins une adresse mail ou un numéro de téléphone',
                'error'
            );
        } else {
            $('#modifier').trigger("soumettreFormulaire");
        }
    });

    // Créez un événement personnalisé pour soumettre le formulaire
    var evenementSoumissionFormulaire = new Event('soumettreFormulaire');

    // Liez un gestionnaire d'événements à l'événement personnalisé
    $('#modifier').on('soumettreFormulaire', function(event) {
        $('#edit-contact').submit();
    });
</script>