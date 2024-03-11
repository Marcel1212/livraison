$(function () {
    'use strict';
    var demandeProjetForm = $('#demandeProjetForm');
    var demandeProjetPieceForm = $('#demandeProjetPieceForm');

    $.validator.methods.number = function (value, element) {
        return this.optional(element) || /\d{1,3}(\.\d{3})*(\.\d\d)?|\.\d\d/.test(value);
    }

    $.validator.addMethod('filesize', function (value, element, param) {
        return this.optional(element) || (element.files[0].size <= param)
    }, 'la taille maximale doit être de 5 MegaOctets');

    // jQuery Validation
    // --------------------------------------------------------------------
    if (demandeProjetForm.length) {
        demandeProjetForm.validate({
            rules: {
                'titre_projet': {
                    required: true,
                },
                'montant_demande_projet': {
                    required: true,
                    number: true
                },

                'id_secteur_activite': {
                    required: true,
                },

                'contexte_probleme': {
                    required: true,
                },
                'objectif_general': {
                    required: true,
                },
                'objectif_specifique': {
                    required: true,
                },

                'resultat_attendu': {
                    required: true,
                },

                'champ_etude': {
                    required: true,
                },

                'cible': {
                    required: true,
                },

            },
            messages: {
                titre_projet: "Veuillez ajouter un titre de projet",
                montant_demande_projet: "Veuillez ajouter le montant du projet",
                id_secteur_activite: "Veuillez sélectionner un secteur d'activité",
                contexte_probleme: "Veuillez ajouter un contexte ou problème constaté",
                objectif_general: "Veuillez ajouter un objectif général",
                objectif_specifique: "Veuillez ajouter des objectifs spécifiques",
                resultat_attendu: "Veuillez ajouter un résultat attendu",
                champ_etude: "Veuillez ajouter un champ d'étude",
                cible: "Veuillez ajouter une cible",
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

    if (demandeProjetPieceForm.length) {
        demandeProjetPieceForm.validate({
            rules: {
                'type_pieces': {
                    required: true,
                },
                'libelle_piece': {
                    required: true,
                },
                'pieces': {
                    required: true,
                    filesize: 5242880,
                    extension: "png|jpg|jpeg|pdf|PNG|JPG|JPEG|PDF"
                },
            },
            messages: {
                type_pieces: "Sélectionner un type de pièce",
                pieces:{
                    required: "Veuillez ajouter une pièce",
                    extension: "Les formats requis pour la pièce sont: png,jpg,jpeg,pdf,PNG,JPG,JPEG,PDF",
                },
                libelle_piece: "Veuillez ajouter un libellé de pièce",

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
