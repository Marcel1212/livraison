$(function () {
    'use strict';
    var actionformationForm = $('#actionformationForm');

    $.validator.methods.number = function (value, element) {
        return this.optional(element) || /\d{1,3}(\.\d{3})*(\.\d\d)?|\.\d\d/.test(value);
    }

    $.validator.addMethod('filesize', function (value, element, param) {
        return this.optional(element) || (element.files[0].size <= param)
    }, 'la taille maximale doit être de 5 MegaOctets');

    // jQuery Validation
    // --------------------------------------------------------------------
    if (actionformationForm.length) {
        actionformationForm.validate({
            rules: {
                'intitule_action_formation_plan': {
                    required: true,
                },
                'nombre_groupe_action_formation_': {
                    required: true,
                    number: true
                },

                'nombre_heure_action_formation_p': {
                    required: true,
                },

                'cout_action_formation_plan': {
                    required: true,
                },
                'id_type_formation': {
                    required: true,
                },
                'id_caracteristique_type_formation': {
                    required: true,
                },

                'id_entreprise_structure_formation_plan_formation': {
                    required: true,
                },

                'id_but_formation': {
                    required: true,
                },

                'lieu_formation_fiche_agrement': {
                    required: true,
                },

                'id_secteur_activite': {
                    required: true,
                },

                'cadre_fiche_demande_agrement': {
                    required: true,
                },

                'agent_maitrise_fiche_demande_ag': {
                    required: true,
                },

                'employe_fiche_demande_agrement': {
                    required: true,
                },

                'objectif_pedagogique_fiche_agre': {
                    required: true,
                },

                'file_beneficiare': {
                    required: true,
                    filesize: 5242880,
                    extension: "xlsx|XLSX"
                },
                'facture_proforma_action_formati': {
                    required: true,
                    filesize: 5242880,
                    extension: "pdf|PDF"
                },
            },
            messages: {
                intitule_action_formation_plan: "Veuillez ajoutez l\'intitule de l\'action.",
                id_caracteristique_type_formation: "Veuillez sélectionner une caractéristique.",
                id_entreprise_structure_formation_plan_formation: "Veuillez ajoutez une structure ou etablissement.",
                nombre_groupe_action_formation_: "Veuillez ajoutez le nombre de groupe.",
                nombre_heure_action_formation_p: "Veuillez ajoutez le nombre d\'heure.",
                cout_action_formation_plan: "Veuillez ajoutez le cout de la formation.",
                id_type_formation: "Veuillez selectionnez un type de formation.",
                id_but_formation: "Veuillez selectionnez le but de la formation.",
                lieu_formation_fiche_agrement: "Veuillez ajoutez le lieu de formation.",
                facture_proforma_action_formati: {
                    required: "Veuillez ajouter une proforma",
                    extension: "Les formats requises pour la proformat est: PDF,PNG.",
                    filesize: "la taille maximale doit etre 5 MegaOctets.",
                },
                file_beneficiare: {
                    required: "Veuillez ajoutez le fichier excel contenant la liste des beneficiaires.",
                    extension: "Les formats requises pour le fichier excel contenant la liste des beneficiaires est: xlsx,XLSX.",
                    filesize: "la taille maximale doit etre 5 MegaOctets.",
                },
                id_secteur_activite: "Veuillez selectionner un secteur activité.",
                employe_fiche_demande_agrement: "Veuillez ajoutez le nombre d\employe .",
                agent_maitrise_fiche_demande_ag: "Veuillez ajoutez le nombre d\'agent de maitrise.",
                cadre_fiche_demande_agrement: "Veuillez ajoutez le nombre de cadre.",
                objectif_pedagogique_fiche_agre: "Veuillez ajoutez l\'objectif pedagogique.",
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


