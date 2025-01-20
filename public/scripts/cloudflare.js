document.querySelectorAll('.renewal-form select').forEach(select => {
    select.addEventListener('change', function()    
        {
            const renewalType = this.value;
            if (renewalType) {
                swal({
                    title: "Confirmation",
                    text: "Êtes-vous sûr de vouloir renouveler cet abonnement en tant que " + renewalType + " ?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Oui",
                    cancelButtonText: "Non",
                    closeOnConfirm: false
                }, function() {
                    // Soumettre le formulaire si l'utilisateur confirme
                    select.form.submit();
                });
            } else {
                // Alerte si aucune option n'est sélectionnée
                swal("Erreur", "Veuillez sélectionner un type de renouvellement.", "error");
            }
        });
});


document.querySelectorAll('.delete-button').forEach(button => {
    button.addEventListener('click', function() {
        const form = this.closest('form'); // Récupère le formulaire parent
        swal({
        title: "Êtes-vous sûr ?",
        text: "Vous ne pourrez pas récupérer cet abonnement !",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Oui, supprimer !",
        cancelButtonText: "Non, annuler !",
        closeOnConfirm: false
        }, function() {
            form.submit(); // Soumet le formulaire si l'utilisateur confirme
                    });
                });
            });
