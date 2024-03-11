$(function () {
    'use strict';


    var formTraitement = $('#formTraitement');

    $.validator.methods.number = function (value, element) {
        return this.optional(element) || /\d{1,3}(\.\d{3})*(\.\d\d)?|\.\d\d/.test(value);
    }

    $.validator.addMethod('filesize', function (value, element, param) {
        return this.optional(element) || (element.files[0].size <= param)
    }, 'la taille maximale doit être de 5 MegaOctets');

    // jQuery Validation
    // --------------------------------------------------------------------
    if (formTraitement.length) {
        formTraitement.validate({
            rules: {
                'titre_projet_instruction': {
                    required: true,
                },
                'montant_demande_projet': {
                    required: true,
                    number: true
                },

                'id_secteur_activite': {
                    required: true,
                },

                'contexte_probleme_instruction': {
                    required: true,
                },
                'objectif_general_instruction': {
                    required: true,
                },
                'objectif_specifique_instruction': {
                    required: true,
                },

                'resultat_attendu_instruction': {
                    required: true,
                },

                'champ_etude_instruction': {
                    required: true,
                },

                'cible_instruction': {
                    required: true,
                },

                'montant_projet_instruction': {
                    required: true,
                },

                'fichier_instruction': {
                    required: true,
                    filesize: 5242880,
                    extension: "png|jpg|jpeg|pdf|PNG|JPG|JPEG|PDF"
                },
            },
            messages: {
                titre_projet_instruction: "Veuillez ajouter un titre de projet",
                montant_demande_projet: "Veuillez ajouter le montant du projet",
                id_secteur_activite: "Veuillez sélectionner un secteur d'activité",
                contexte_probleme_instruction: "Veuillez ajouter un contexte ou problème constaté",
                objectif_general_instruction: "Veuillez ajouter un objectif général",
                objectif_specifique_instruction: "Veuillez ajouter des objectifs spécifiques",
                resultat_attendu_instruction: "Veuillez ajouter un résultat attendu",
                champ_etude_instruction: "Veuillez ajouter un champ d'étude",
                cible_instruction: "Veuillez ajouter une cible",
                montant_projet_instruction: "Veuillez ajouter une cible",
                fichier_instruction: "Veuillez ajouter une cible",
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



    var formAddCommentairePiece = $('#formAddCommentairePiece');

    if (formAddCommentairePiece.length) {
        formAddCommentairePiece.validate({
            rules: {
                'commentaire_piece': {
                    required: true,
                },
            },
            messages: {
                commentaire_piece: "Veuillez ajouter un commentaire",
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
