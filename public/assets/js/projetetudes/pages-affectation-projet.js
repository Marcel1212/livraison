$(function () {
    'use strict';
    var affectProjetChefDepartForm = $('#affectProjetChefDepartForm');
    var affectProjetChefServForm = $('#affectProjetChefServForm');

    if (affectProjetChefDepartForm.length) {
        affectProjetChefDepartForm.validate({
            rules: {
                'id_chef_serv': {
                    required: true,
                },
                'commentaires_cd': {
                    required: true,
                },
            },
            messages: {
                id_chef_serv: "Veuillez sélectionner un chef de service",
                commentaires_cd: "Veuillez ajouter un commentaire",
            },

            errorPlacement: function (error, element) {
                if (element.parent('.input-group').length) {
                    error.insertAfter(element.parent());      // radio/checkbox?
                } else if (element.hasClass('select2')) {
                    error.insertAfter(element.next('span'));  // select2
                } else {
                    error.insertAfter(element);               // default
                }
            }
        });
    }

    if (affectProjetChefServForm.length) {
        affectProjetChefServForm.validate({
            rules: {
                'id_charge_etude': {
                    required: true,
                },
                'commentaires_cs': {
                    required: true,
                },
            },
            messages: {
                id_charge_etude: "Veuillez sélectionner un chargé d'étude",
                commentaires_cs: "Veuillez ajouter un commentaire",
            },

            errorPlacement: function (error, element) {
                if (element.parent('.input-group').length) {
                    error.insertAfter(element.parent());      // radio/checkbox?
                } else if (element.hasClass('select2')) {
                    error.insertAfter(element.next('span'));  // select2
                } else {
                    error.insertAfter(element);               // default
                }
            }
        });
    }

});
