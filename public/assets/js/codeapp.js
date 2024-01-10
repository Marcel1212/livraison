$(function() {

    //alert('test');
            $('#profiles').on('change', function (e) {
                var roles = e.target.value;
            });
            $('#direction').on('change', function (e) {
                //alert('test');
               // alert('id_direction');
                var id_direction = e.target.value;
                 //alert('test');
                telUpdate(id_direction);
                //alert(id_direction);
            });

            function telUpdate(id) {
                //alert('testanc'); //exit;
                $.get('/departementlist/' + id, function (data) {
                    // alert(data); //exit;
                    $('#departement').empty();
                    $.each(data, function (index, tels) {
                        $('#departement').append($('<option>', {
                            value: tels.id_departement,
                            text: tels.libelle_departement,
                        }));

                        $.get('/servicelist/' + tels.id_departement, function (data) {
                            $('#service').empty();
                            $.each(data, function (index, tels) {
                                $('#service').append($('<option>', {
                                    value: tels.id_service,
                                    text: tels.libelle_service,
                                }));


                            });
                        });
                    });
                });
            }

            $('#departement').on('change', function (e) {
                //alert('test');
                // alert('id_direction');
                var id_departement = e.target.value;
                //alert('test');
                telUpdate1(id_departement);
                //alert(id_direction);
            });

            function telUpdate1(id) {
                //alert('testanc'); //exit;
                        $.get('/servicelist/' + id, function (data) {
                            $('#service').empty();
                            $.each(data, function (index, tels) {
                                $('#service').append($('<option>', {
                                    value: tels.id_service,
                                    text: tels.libelle_service,
                                }));


                            });
                        });
            }
});
