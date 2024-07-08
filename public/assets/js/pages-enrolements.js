$(function () {
    'use strict';
        var enrolementForm = $('#enrolementForm');

    $.validator.addMethod('filesize', function (value, element, param) {
        return this.optional(element) || (element.files[0].size <= param)
    }, 'la taille maximale doit être de 5 MegaOctets');

    $.validator.addMethod('numbertel', function (value) {
        return value.substr(0, 2)!=='27' && value.substr(0, 2)!=='21' && value.substr(0, 2)!=='25';
    }, 'les numéros fixes ne sont pas acceptés');

    // --------------------------------------------------------------------
    if (enrolementForm.length) {
        enrolementForm.validate({
            rules: {
                'id_forme_juridique': {
                    required: true,
                },
                'raison_sociale_demande_enroleme': {
                    required: true,
                },
                'sigl_demande_enrolement': {
                    required: true,
                },
                'email_demande_enrolement': {
                    required: true,
                },
                'indicatif_demande_enrolement': {
                    required: true,
                },
                'tel_demande_enrolement': {
                    required: true,
                    maxlength:10,
                    minlength:10,
                    numbertel: true
                },
                'id_localite': {
                    required: true,
                },
                'id_centre_impot': {
                    required: true,
                },
                'id_secteur_activite': {
                    required: true,
                },

                'ncc_demande_enrolement': {
                    required: true,
                    minlength:6,
                    maxlength:9
                },
                'rccm_demande_enrolement': {
                    required: true,
                },
                'numero_cnps_demande_enrolement': {
                    required: true,
                },
                'piece_dfe_demande_enrolement': {
                    required: true,
                    filesize: 5242880,
                    extension: "png|jpg|jpeg|pdf|PNG|JPG|JPEG|PDF"
                },
                'piece_rccm_demande_enrolement': {
                    required: true,
                    filesize: 5242880,
                    extension: "png|jpg|jpeg|pdf|PNG|JPG|JPEG|PDF"
                },
                'piece_attestation_immatriculati': {
                    required: true,
                    filesize: 5242880,
                    extension: "png|jpg|jpeg|pdf|PNG|JPG|JPEG|PDF"
                },
                'g-recaptcha-response': {
                    required: true,
                },

            },
            messages: {
                raison_sociale_demande_enroleme: "Veuillez ajouter votre raison sociale",
                sigl_demande_enrolement: "Veuillez ajouter votre sigle",
                email_demande_enrolement: "Veuillez ajouter un email",
                indicatif_demande_enrolement: "Veuillez ajouter un indicatif",

                tel_demande_enrolement:{
                    required: "Veuillez ajouter un contact",
                    maxlength: "Le contact doit être composé de {0} caractères",
                    minlength: "Le contact doit être composé de {0} caractères",
                },

                id_localite: "Veuillez sélectionner une localité",
                id_centre_impot: "Veuillez sélectionner un centre d\'impôt",
                id_secteur_activite: "Veuillez sélectionner un secteur activité",

                ncc_demande_enrolement:{
                    required: "Veuillez ajouter un numéro de compte contribuable (NCC)",
                    minlength: "Le numéro NCC doit avoir au moins {0} caractères",
                    maxlength: "Le numéro NCC doit avoir au plus {0} caractères",
                },

                rccm_demande_enrolement: "Veuillez ajouter un numéro du registre de commerce (RCCM)",
                numero_cnps_demande_enrolement: "Veuillez ajouter un numéro CNPS",

                piece_dfe_demande_enrolement:{
                    required: "Veuillez ajouter une pièce DFE",
                    extension: "Les formats requis pour la pièce de la DFE sont: png,jpg,jpeg,pdf,PNG,JPG,JPEG,PDF",
                },

                piece_rccm_demande_enrolement:{
                    required:  "Veuillez ajouter une piéce RCCM",
                    extension: "Les formats requis pour la pièce de la RCCM sont: png,jpg,jpeg,pdf,PNG,JPG,JPEG,PDF",
                },


                piece_attestation_immatriculati:{
                    required: "Veuillez ajouter une pièce d\'attestation d\'immatriculation",
                    extension: "Les formats requis pour la pièce de l\'attestataion d\'immatriculation sont: png,jpg,jpeg,pdf,PNG,JPG,JPEG,PDF",
                },

                'g-recaptcha-response': {
                    required: "Veuillez saisir le vérificateur de securité",
                },
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
