<?php

use App\Helpers\AnneeExercice;

$anneexercice = AnneeExercice::get_annee_exercice();

?>

@if(auth()->user()->can('habilitationrendezvous-index'))

    @extends('layouts.backLayout.designadmin')

    @section('content')

        @php($Module='Habilitation')
        @php($titre='Liste des rendez-vous')
        @php($lien='habilitationrendezvous')

        <!-- BEGIN: Content-->

        <h5 class="py-2 mb-1">
            <span class="text-muted fw-light"> <i class="ti ti-home"></i>  Accueil / {{$Module}} / </span> {{$titre}}
        </h5>

        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <div class="alert-body">
                    {{ $message }}
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif


        <!-- Basic Layout & Basic with Icons -->
        <div class="row">
            <!-- Basic Layout -->
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">{{$titre}}</h5>

                    </div>
                    <div class="card-body">
                                            <!-- Full calendar start -->

                                            <div id="success_text"></div>
                                            <div id="success_text_rapport"></div>
                                            <section>
                                                <div class="app-calendar overflow-hidden border">
                                                    <div class="row ">
                                                        <!-- Sidebar -->
                                                        <div class="col-md-2 ps-4 pt-4 pe-4 app-calendar-sidebar flex-grow-0 overflow-hidden d-flex flex-column" id="app-calendar-sidebar">
                                                            <div class="sidebar-wrapper">
                                                                <div class="filter-section">
                                                                    <label for="filter-status" class="form-label">Filtrer par statut</label>
                                                                    <select id="filter-status" class="form-select w-100">
                                                                        <option value="">Tous</option>
                                                                        <option value="planifier">Planifier</option>
                                                                        <option value="commencer">Commencer</option>
                                                                        <option value="terminer">Terminer</option>
                                                                        <option value="annuler">Annuler</option>
                                                                        <option value="reporter">Reporter</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- /Sidebar -->

                                                        <!-- Calendar -->
                                                        <div class="col-md-10 position-relative">
                                                            <div class="card shadow-none border-0 mb-0 rounded-0">
                                                                <div class="card-body pb-0">
                                                                    <div id="calendar"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- /Calendar -->
                                                        <div class="body-content-overlay"></div>
                                                    </div>
                                                </div>
                                                <!-- Calendar Add/Update/Delete event modal-->
                                                <div class="modal modal-slide-in event-sidebar fade" id="add-new-sidebar">
                                                    <div class="modal-dialog sidebar-lg">
                                                        <div class="modal-content p-0">
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
                                                            <div class="modal-header mb-1">
                                                                <h5 class="modal-title">Ajouter un evenement</h5>
                                                            </div>
                                                            <div class="modal-body flex-grow-1 pb-sm-0 pb-3">
                                                                <div id="error_text"></div>



                                                                <!-- Formulaire d'événement -->
                                                                    <form class="event-form needs-validation" id="event-form" data-ajax="false" novalidate>
                                                                        <!-- Champ caché pour l'ID de la demande d'habilitation -->



                                                                        <!-- Sélection du statut -->
                                                                        <div class="mb-1">
                                                                            <label for="select-label" class="form-label">Statut</label>
                                                                            <select class="select2 select-label form-select w-100" id="select-label" name="select-label" required>
                                                                                <option data-label="primary" value="planifier">Planifier</option>
                                                                                <option data-label="info" value="commencer">Commencer</option>
                                                                                <option data-label="success" value="terminer">Terminer</option>
                                                                                <option data-label="danger" value="annuler">Annuler</option>
                                                                                <option data-label="warning" value="reporter">Reporter</option>
                                                                            </select>
                                                                        </div>

                                                                        <!-- Date de début -->
                                                                        <div class="mb-1 position-relative">
                                                                            <label for="start-date" class="form-label">Date de début provisoire</label>
                                                                            <input type="date" class="form-control" id="start-date" name="start-date" placeholder="Date de début" required />
                                                                        </div>

                                                                        <!-- Heure de fin -->
                                                                        <div class="mb-1 position-relative">
                                                                            <label for="end-date" class="form-label">Heure de debut provisoire </label>
                                                                            <input type="time" class="form-control" id="end-date" name="end-date" placeholder="Heure de fin provisoire" required />
                                                                        </div>

                                                                        <div class="mb-1 position-relative">
                                                                            <label for="enddateP" class="form-label">Heure de fin provisoire </label>
                                                                            <input type="time" class="form-control" id="enddateP" name="enddateP" placeholder="Heure de fin provisoire" required />
                                                                        </div>

                                                                        <div class="mb-1 position-relative">
                                                                            <label for="enddateR" class="form-label">Heure de fin reel </label>
                                                                            <input type="time" class="form-control" id="enddateR" name="enddateR" placeholder="Heure de fin reel" required />
                                                                        </div>

                                                                        <!-- Description de l'événement -->
                                                                        <div class="mb-1">
                                                                            <label for="event-description-editor" class="form-label">Description</label>
                                                                            <textarea class="form-control" id="event-description-editor" name="event-description-editor" required></textarea>
                                                                        </div>

                                                                        <!-- Boutons d'action -->
                                                                        <div class="d-flex mb-1">
                                                                            <button type="submit" class="btn btn-primary add-event-btn me-1">Ajouter</button>
                                                                            <button type="button" class="btn btn-outline-secondary btn-cancel" data-bs-dismiss="modal">Annuler</button>
                                                                            <button type="submit" class="btn btn-primary update-event-btn d-none me-1">Mettre à jour</button>
                                                                            <a href="" class="btn btn-success update-lien-event-btn d-none me-1">Aller sur le dossier</a>
                                                                            <button type="button" class="btn btn-outline-danger btn-delete-event d-none">Supprimer</button>
                                                                        </div>
                                                                    </form>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--/ Calendar Add/Update/Delete event modal-->
                                            </section>
                                        <!-- Full calendar end -->
                    </div>

                </div>
            </div>
        </div>
        <input name="id_visite" class="id_visite"  type="hidden" id="id_visite"/>

    @endsection



    @section('js_perso')



    <script>



        document.addEventListener('DOMContentLoaded', function () {

        var calendarEl = document.getElementById('calendar');
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    editable: false,
                    selectable: true,
                    allDaySlot: true,
                    locale: 'fr',
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,listWeek'
                    },
                    businessHours: {
                        //daysOfWeek: [1, 2, 3, 4, 5], // Lundi à vendredi
                        startTime: '08:00',
                        endTime: '18:00'
                    },
                    allDaySlot: true,
                    buttonText: {
                        today:    'Aujourd\'hui',
                        month:    'Mois',
                        week:     'Semaine',
                        day:      'Jour',
                        list:     'Liste'
                    },
                    hiddenDays: [0,6],
                    aspectRatio: 3,
                    events: {
                        url: '/habilitationrendezvous/calendar-events', // Route Laravel pour récupérer les événements
                        method: 'GET',
                        extraParams: function() {
                            return {
                                statut: $('#filter-status').val() // Filtrer les événements selon le statut sélectionné
                            };
                        },
                        failure: function() {
                            alert('Erreur lors du chargement des événements.');
                        }
                    },
                    eventDidMount: function(info) {
                        var statut = info.event.extendedProps.selectlabel;
                        if (statut === 'planifier') {
                        info.el.style.backgroundColor = '#007bff';
                        info.el.style.borderColor = '#007bff';
                        info.el.style.color = '#000000';
                        info.el.style.fontSize = '12px';
                        } else if (statut === 'commencer') {
                        info.el.style.backgroundColor = '#17a2b8';
                        info.el.style.borderColor = '#17a2b8';
                        info.el.style.color = '#000000';
                        info.el.style.fontSize = '12px';
                        } else if (statut === 'terminer') {
                        info.el.style.backgroundColor = '#28a745';
                        info.el.style.borderColor = '#28a745';
                        info.el.style.color = '#000000';
                        info.el.style.fontSize = '12px';
                        } else if (statut === 'annuler') {
                        info.el.style.backgroundColor = '#dc3545';
                        info.el.style.borderColor = '#dc3545';
                        info.el.style.color = '#000000';
                        info.el.style.fontSize = '12px';
                        } else if (statut === 'reporter') {
                        info.el.style.backgroundColor = '#ffc107';
                        info.el.style.borderColor = '#ffc107';
                        info.el.style.color = '#000000';
                        info.el.style.fontSize = '12px';
                        }
                    },
                    dateClick: function(info) {
                        //alert(info);
                    resetModalForm(); // Réinitialise les champs du formulaire
                    $('#start-date').val(info.dateStr); // Remplit la date de début automatiquement
                    $('.add-event-btn').removeClass('d-none'); // Affiche le bouton "Add"
                    $('.update-event-btn, .update-lien-event-btn').addClass('d-none'); // Cache les boutons "Update" et "Delete"
                    $('#add-new-sidebar').modal('show');
                     },
                    eventClick: function(info) {
                        // Récupération de l'ID de l'événement (visite) cliqué
                       // var visiteId = info.event.id;
                       resetModalForm();
                       var visiteId = getVisiteId(info.event);
                       openAndRefreshModal(info.event.id);
                        //populateModalForm(info.event); // Remplit les champs du formulaire avec les informations de l'événement
                       // alert(info.event.extendedProps.selectlabel)
                       if (info.event.extendedProps.selectlabel === "terminer") {
                            $('.add-event-btn').addClass('d-none');
                            $('.update-event-btn').addClass('d-none');
                            $('.update-lien-event-btn').removeClass('d-none'); // Affiche un bouton spécifique pour les événements terminés
                        } else {
                            $('.add-event-btn').addClass('d-none');
                            $('.update-lien-event-btn').addClass('d-none');
                            $('.update-event-btn').removeClass('d-none'); // Affiche le bouton de mise à jour pour les autres statuts
                        }
                        $('#add-new-sidebar').modal('show');
                    },
                    eventDrop: function(info) {
                        updateEvent(info.event); // Met à jour l'événement après un drag and drop
                    }
                });

                calendar.render();

                    // Apply filter when the select option changes
                $('#filter-status').on('change', function() {
                    calendar.refetchEvents(); // Recharge les événements avec le nouveau filtre
                });

                // Fonction pour récupérer l'ID de la visite sélectionnée
                function getVisiteId(event) {
                    return event.id;
                }

                // Fonction pour réinitialiser le modal
                function resetModal() {
                    $('#event-form')[0].reset();  // Réinitialiser le formulaire
                    $('#event-form .is-invalid').removeClass('is-invalid');  // Retirer les validations précédentes
                    $('#event-form .is-valid').removeClass('is-valid');      // Retirer les validations précédentes
                }



                $('#add-new-sidebar').on('hidden.bs.modal', function () {
                    resetModal();  // Réinitialiser le modal à chaque fermeture
                });



                // Rafraîchir le contenu du modal
                function refreshModal(eventId) {
                   // alert(eventId)
                    $.ajax({
                        url: '/habilitationrendezvous/calendar-events/get-event-data/' + eventId,  // URL pour récupérer les données de l'événement
                        type: 'GET',
                        success: function(response) {
                            //console.log(response)
                            // Injecter les nouvelles données dans le modal
                            $('#id_demande_habilitation').val(response.id_demande_habilitation);
                            $('#title').val(response.title);
                            $('#end-date').val(response.timestart);
                            $('#event-description-editor').val(response.eventdescriptioneditor);
                            $('#select-label').val(response.selectlabel).change();
                            let formattedStartDate = moment(response.datevisite).format('YYYY-MM-DD');
                            $('#start-date').val(formattedStartDate);
                            $('#enddateP').val(response.timeend);
                            $('#enddateR').val(response.timeendr);
                            $('#id_visite').val(response.id); // Stocker l'ID dans un champ caché pour une utilisation ultérieure
                            $('.update-lien-event-btn').attr('href', response.url);
                            // Ouvrir le modal après mise à jour
                            $('#add-new-sidebar').modal('show');
                        },
                        error: function(error) {
                            alert('Erreur lors du rafraîchissement du modal')
                            console.log('Erreur lors du rafraîchissement du modal', error);
                        }
                    });
                }


                function openAndRefreshModal(eventId) {
                    resetModal();  // Réinitialiser le contenu
                    refreshModal(eventId);  // Charger les nouvelles données
                }

                // Bouton d'édition
                $('.edit-event-btn').on('click', function(e) {
                    e.preventDefault();
                    let eventId = $(this).data('event-id');  // Récupérer l'ID de l'événement
                    openAndRefreshModal(eventId);  // Rafraîchir et ouvrir le modal
                });

                // Fonction pour réinitialiser le formulaire du modal
                function resetModalForm() {
                    $('#title').val('');
                    $('#start-date').val('');
                    $('#end-date').val('');
                    $('#enddateP').val('');
                    $('#enddateR').val('');
                    $('#event-description-editor').val('');
                    $('#id_visite').val('');
                    $('#select-label').val('planifier').change();
                    $('#id_demande_habilitation').val('');
                }



                // Fonction pour remplir le formulaire du modal avec les détails de l'événement
                function populateModalForm(event) {
                    const formattedDate = formatDateToDDMMYYYY(event.extendedProps.datevisite);
                    //alert(event.extendedProps.timeendr);
                   // alert(formattedDate);
                   // console.log(event);
                    // $('#title').val(event.title);
                    // $('#start-date').val(moment(event.startStr).format('DD/MM/YYYY'));
                    // $('#end-date').val(event.endStr);
                    // $('#event-description-editor').append(event.eventdescriptioneditor);
                    // $('#select-label').val(event.selectlabelStr);
                   // console.log(event)
                    $('#title').val(event.title);
                    let formattedStartDate = moment(event.extendedProps.datevisite).format('YYYY-MM-DD');
                    $('#start-date').val(formattedStartDate);
                    $('#end-date').val(event.extendedProps.timestart);
                    $('#enddateP').val(event.extendedProps.timeend);
                    $('#enddateR').val(event.extendedProps.timeendr);
                    $('#id_visite').val(event.id); // Stocker l'ID dans un champ caché pour une utilisation ultérieure
                    $('#id_demande_habilitation').val(event.extendedProps.iddemandehabilitation);
                    $('#event-description-editor').val(event.extendedProps.eventdescriptioneditor);
                    $("#select-label").val(event.extendedProps.selectlabel);
                }



                // Fonction pour mettre à jour un événement existant
                $('.update-event-btn').on('click', function (e) {
                    e.preventDefault();
                    var eventId = $('#id_visite').val();
                    sendEventRequest('/habilitationrendezvous/' + eventId  + '/update/visite', 'POST', 'Événement mis à jour avec succès');
                });



                // Fonction générique pour envoyer une requête Ajax
                function sendEventRequest(url, method, successMessage) {
                    $.ajax({
                        url: url,
                        type: method,
                        data: {
                            title: $('#title').val(),
                            iddemandehabilitation: $('#id_demande_habilitation').val(),
                            start: $('#start-date').val(),
                            end: $('#end-date').val(),
                            endfin: $('#enddateP').val(),
                            endfinR: $('#enddateR').val(),
                            eventdescriptioneditor: $('#event-description-editor').val(),
                            selectlabel: $('#select-label').val(),
                            _token: '{{ csrf_token() }}'
                        },
                        success: function (response) {
                            resetModal();  // Réinitialiser le modal
                            $('#add-new-sidebar').modal('hide');
                            calendar.refetchEvents(); // Rafraîchir les événements du calendrier
                            displayMessage('success', successMessage);
                        },
                        error: function (xhr) {
                            var errors = xhr.responseJSON.errors;
                            if (typeof errors === 'object') {
                                displayMessage('error', formatErrors(errors)); // Fonction pour formater les erreurs
                            }else{
                                displayMessage('error', errors);
                            }

                        }
                    });
                }




                // Fonction pour formater la date
                function formatDateToDDMMYYYY(dateStr) {
                    // Convertir la chaîne en objet Date
                    const dateObj = new Date(dateStr);

                    // Vérifier si la date est valide
                    if (isNaN(dateObj.getTime())) {
                        throw new Error('Date invalide');
                    }

                    // Extraire le jour, le mois et l'année
                    const day = String(dateObj.getDate()).padStart(2, '0'); // Ajouter un 0 devant si nécessaire
                    const month = String(dateObj.getMonth() + 1).padStart(2, '0'); // Les mois commencent à 0
                    const year = dateObj.getFullYear();

                    // Retourner la date au format jj/mm/aaaa
                    return `${day}/${month}/${year}`;
                }
                // Fonction pour afficher des messages (succès ou erreur)
                function displayMessage(type, message) {
                    //alert(message);
                    if (type === 'success') {
                        suces = $("#success_text")
                        suces.empty();
                        alertBox = suces.append('<div class="alert alert-' + (type === 'success' ? 'success' : 'danger') + '">'+message+'</div>')
                    } else {
                        error = $("#error_text")
                        error.empty();
                        alertBox = error.append('<div class="alert alert-' + (type === 'success' ? 'success' : 'danger') + '">'+message+'</div>')
                    }

                }



                // Fonction pour formater les messages d'erreur
                function formatErrors(errors) {
                    var errorMessage = '';
                    $.each(errors, function (key, value) {
                        errorMessage += value + '<br>';
                    });

                    return errorMessage;
                }

            });


        </script>
    @endsection
@else
 <script type="text/javascript">
    window.location = "{{ url('/403') }}";//here double curly bracket
</script>
@endif


