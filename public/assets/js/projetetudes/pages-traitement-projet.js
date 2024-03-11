$(function () {
    'use strict';
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
