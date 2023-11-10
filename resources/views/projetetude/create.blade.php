@extends('layouts.backLayout.designadmin')

@section('content')
    @php($Module = 'projetetude')
    @php($titre = 'Liste des  projets')
    @php($soustitre = 'Ajouter un projet etude ')
    @php($lien = 'projetetude')


    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper ">
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-1">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-start mb-0">{{ $soustitre }}</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">{{ $Module }}</a></li>
                                    <li class="breadcrumb-item"><a href="/{{ $lien }}">{{ $titre }}</a></li>
                                    <li class="breadcrumb-item active">{{ $soustitre }} </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="content-body">
                @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <div class="alert-body">
                            {{ $message }}
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <section id="multiple-column-form">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">{{ $soustitre }} </h4>
                                </div>
                                <div class="card-body">
                                    <form method="POST" class="form" action="{{ route($lien . '.store') }}"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">

                                            <div class="accordion mt-3" id="accordionExample">
                                                <div class="card accordion-item active">
                                                    <h2 class="accordion-header" id="headingOne">
                                                        <button type="button" class="accordion-button"
                                                            data-bs-toggle="collapse" data-bs-target="#accordionOne"
                                                            aria-expanded="true" aria-controls="accordionOne">
                                                            Details de l'entreprise
                                                        </button>
                                                    </h2>

                                                    <div id="accordionOne" class="accordion-collapse collapse show"
                                                        data-bs-parent="#accordionExample" style="">
                                                        <div class="accordion-body">

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card accordion-item">
                                                    <h2 class="accordion-header" id="headingTwo">
                                                        <button type="button" class="accordion-button collapsed"
                                                            data-bs-toggle="collapse" data-bs-target="#accordionTwo"
                                                            aria-expanded="false" aria-controls="accordionTwo">
                                                            Informations du projet d'etude
                                                        </button>
                                                    </h2>
                                                    <div id="accordionTwo" class="accordion-collapse collapse"
                                                        aria-labelledby="headingTwo" data-bs-parent="#accordionExample"
                                                        style="">
                                                        <div class="accordion-body">
                                                            <div class="row gy-3">
                                                                <div class="col-md-12 col-10" align="center">
                                                                    <div class="mb-1">
                                                                        <label>Titre du projet </label>
                                                                        <input type="text" name="titre_projet"
                                                                            id="titre_projet"
                                                                            class="form-control form-control-sm"
                                                                            placeholder="ex : Perfectionnement ..">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4 col-12">
                                                                    <div class="mb-1">
                                                                        <label>Contexte ou Problèmes constatés</label>
                                                                        {{-- <div>
                                                                            <div class="form-control p-0 pt-1">
                                                                                <div
                                                                                    class="comment-toolbar border-0 border-bottom ql-toolbar ql-snow">
                                                                                    <div
                                                                                        class="d-flex justify-content-start">
                                                                                        <span class="ql-formats me-0">
                                                                                            <button class="ql-bold"
                                                                                                type="button"><svg
                                                                                                    viewBox="0 0 18 18">
                                                                                                    <path class="ql-stroke"
                                                                                                        d="M5,4H9.5A2.5,2.5,0,0,1,12,6.5v0A2.5,2.5,0,0,1,9.5,9H5A0,0,0,0,1,5,9V4A0,0,0,0,1,5,4Z">
                                                                                                    </path>
                                                                                                    <path class="ql-stroke"
                                                                                                        d="M5,9h5.5A2.5,2.5,0,0,1,13,11.5v0A2.5,2.5,0,0,1,10.5,14H5a0,0,0,0,1,0,0V9A0,0,0,0,1,5,9Z">
                                                                                                    </path>
                                                                                                </svg></button>
                                                                                            <button class="ql-italic"
                                                                                                type="button"><svg
                                                                                                    viewBox="0 0 18 18">
                                                                                                    <line class="ql-stroke"
                                                                                                        x1="7"
                                                                                                        x2="13"
                                                                                                        y1="4"
                                                                                                        y2="4">
                                                                                                    </line>
                                                                                                    <line class="ql-stroke"
                                                                                                        x1="5"
                                                                                                        x2="11"
                                                                                                        y1="14"
                                                                                                        y2="14">
                                                                                                    </line>
                                                                                                    <line class="ql-stroke"
                                                                                                        x1="8"
                                                                                                        x2="10"
                                                                                                        y1="14"
                                                                                                        y2="4">
                                                                                                    </line>
                                                                                                </svg></button>
                                                                                            <button class="ql-underline"
                                                                                                type="button"><svg
                                                                                                    viewBox="0 0 18 18">
                                                                                                    <path class="ql-stroke"
                                                                                                        d="M5,3V9a4.012,4.012,0,0,0,4,4H9a4.012,4.012,0,0,0,4-4V3">
                                                                                                    </path>
                                                                                                    <rect class="ql-fill"
                                                                                                        height="1"
                                                                                                        rx="0.5"
                                                                                                        ry="0.5"
                                                                                                        width="12"
                                                                                                        x="3" y="15"></rect>
                                                                                                </svg></button>
                                                                                            <button class="ql-list"
                                                                                                value="ordered"
                                                                                                type="button"><svg
                                                                                                    viewBox="0 0 18 18">
                                                                                                    <line class="ql-stroke"
                                                                                                        x1="7"
                                                                                                        x2="15"
                                                                                                        y1="4"
                                                                                                        y2="4">
                                                                                                    </line>
                                                                                                    <line class="ql-stroke"
                                                                                                        x1="7"
                                                                                                        x2="15"
                                                                                                        y1="9"
                                                                                                        y2="9">
                                                                                                    </line>
                                                                                                    <line class="ql-stroke"
                                                                                                        x1="7"
                                                                                                        x2="15"
                                                                                                        y1="14"
                                                                                                        y2="14">
                                                                                                    </line>
                                                                                                    <line
                                                                                                        class="ql-stroke ql-thin"
                                                                                                        x1="2.5"
                                                                                                        x2="4.5"
                                                                                                        y1="5.5"
                                                                                                        y2="5.5">
                                                                                                    </line>
                                                                                                    <path class="ql-fill"
                                                                                                        d="M3.5,6A0.5,0.5,0,0,1,3,5.5V3.085l-0.276.138A0.5,0.5,0,0,1,2.053,3c-0.124-.247-0.023-0.324.224-0.447l1-.5A0.5,0.5,0,0,1,4,2.5v3A0.5,0.5,0,0,1,3.5,6Z">
                                                                                                    </path>
                                                                                                    <path
                                                                                                        class="ql-stroke ql-thin"
                                                                                                        d="M4.5,10.5h-2c0-.234,1.85-1.076,1.85-2.234A0.959,0.959,0,0,0,2.5,8.156">
                                                                                                    </path>
                                                                                                    <path
                                                                                                        class="ql-stroke ql-thin"
                                                                                                        d="M2.5,14.846a0.959,0.959,0,0,0,1.85-.109A0.7,0.7,0,0,0,3.75,14a0.688,0.688,0,0,0,.6-0.736,0.959,0.959,0,0,0-1.85-.109">
                                                                                                    </path>
                                                                                                </svg></button>
                                                                                            <button class="ql-list"
                                                                                                value="bullet"
                                                                                                type="button"><svg
                                                                                                    viewBox="0 0 18 18">
                                                                                                    <line class="ql-stroke"
                                                                                                        x1="6"
                                                                                                        x2="15"
                                                                                                        y1="4"
                                                                                                        y2="4">
                                                                                                    </line>
                                                                                                    <line class="ql-stroke"
                                                                                                        x1="6"
                                                                                                        x2="15"
                                                                                                        y1="9"
                                                                                                        y2="9">
                                                                                                    </line>
                                                                                                    <line class="ql-stroke"
                                                                                                        x1="6"
                                                                                                        x2="15"
                                                                                                        y1="14"
                                                                                                        y2="14">
                                                                                                    </line>
                                                                                                    <line class="ql-stroke"
                                                                                                        x1="3"
                                                                                                        x2="3"
                                                                                                        y1="4"
                                                                                                        y2="4">
                                                                                                    </line>
                                                                                                    <line class="ql-stroke"
                                                                                                        x1="3"
                                                                                                        x2="3"
                                                                                                        y1="9"
                                                                                                        y2="9">
                                                                                                    </line>
                                                                                                    <line class="ql-stroke"
                                                                                                        x1="3"
                                                                                                        x2="3"
                                                                                                        y1="14"
                                                                                                        y2="14">
                                                                                                    </line>
                                                                                                </svg></button>

                                                                                        </span>
                                                                                    </div>
                                                                                    <input type="file"
                                                                                        accept="image/png, image/gif, image/jpeg, image/bmp, image/x-icon"
                                                                                        class="ql-image">
                                                                                </div>
                                                                                <div class="comment-editor border-0 pb-4 ql-container ql-snow"
                                                                                    id="ecommerce-category-description"
                                                                                    >
                                                                                    <div class="ql-editor ql-blank"
                                                                                        data-gramm="false"
                                                                                        contenteditable="true"
                                                                                        name="textarea">
                                                                                    </div>
                                                                                    <div class="ql-clipboard"
                                                                                        contenteditable="true"
                                                                                        tabindex="-1">
                                                                                    </div>
                                                                                    <div class="ql-tooltip ql-hidden"><a
                                                                                            class="ql-preview"
                                                                                            rel="noopener noreferrer"
                                                                                            href="about:blank"></a><input
                                                                                            type="text"
                                                                                            data-formula="e=mc^2"
                                                                                            data-link="https://quilljs.com"
                                                                                            data-video="Embed URL"><a
                                                                                            class="ql-action"></a><a
                                                                                            class="ql-remove"></a></div>
                                                                                </div>
                                                                            </div>
                                                                        </div> --}}
                                                                        <textarea class="form-control" rows="3" id="exampleFormControlTextarea" name="contexte_probleme"
                                                                            style="height: 121px;"></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4 col-12">
                                                                    <div class="mb-1">
                                                                        <label>Objectif Général </label>
                                                                        {{-- <div>
                                                                            <div class="form-control p-0 pt-1">
                                                                                <div
                                                                                    class="comment-toolbar border-0 border-bottom ql-toolbar ql-snow">
                                                                                    <div
                                                                                        class="d-flex justify-content-start">
                                                                                        <span class="ql-formats me-0">
                                                                                            <button class="ql-bold"
                                                                                                type="button"><svg
                                                                                                    viewBox="0 0 18 18">
                                                                                                    <path class="ql-stroke"
                                                                                                        d="M5,4H9.5A2.5,2.5,0,0,1,12,6.5v0A2.5,2.5,0,0,1,9.5,9H5A0,0,0,0,1,5,9V4A0,0,0,0,1,5,4Z">
                                                                                                    </path>
                                                                                                    <path class="ql-stroke"
                                                                                                        d="M5,9h5.5A2.5,2.5,0,0,1,13,11.5v0A2.5,2.5,0,0,1,10.5,14H5a0,0,0,0,1,0,0V9A0,0,0,0,1,5,9Z">
                                                                                                    </path>
                                                                                                </svg></button>
                                                                                            <button class="ql-italic"
                                                                                                type="button"><svg
                                                                                                    viewBox="0 0 18 18">
                                                                                                    <line class="ql-stroke"
                                                                                                        x1="7"
                                                                                                        x2="13"
                                                                                                        y1="4"
                                                                                                        y2="4">
                                                                                                    </line>
                                                                                                    <line class="ql-stroke"
                                                                                                        x1="5"
                                                                                                        x2="11"
                                                                                                        y1="14"
                                                                                                        y2="14">
                                                                                                    </line>
                                                                                                    <line class="ql-stroke"
                                                                                                        x1="8"
                                                                                                        x2="10"
                                                                                                        y1="14"
                                                                                                        y2="4">
                                                                                                    </line>
                                                                                                </svg></button>
                                                                                            <button class="ql-underline"
                                                                                                type="button"><svg
                                                                                                    viewBox="0 0 18 18">
                                                                                                    <path class="ql-stroke"
                                                                                                        d="M5,3V9a4.012,4.012,0,0,0,4,4H9a4.012,4.012,0,0,0,4-4V3">
                                                                                                    </path>
                                                                                                    <rect class="ql-fill"
                                                                                                        height="1"
                                                                                                        rx="0.5"
                                                                                                        ry="0.5"
                                                                                                        width="12"
                                                                                                        x="3" y="15"></rect>
                                                                                                </svg></button>
                                                                                            <button class="ql-list"
                                                                                                value="ordered"
                                                                                                type="button"><svg
                                                                                                    viewBox="0 0 18 18">
                                                                                                    <line class="ql-stroke"
                                                                                                        x1="7"
                                                                                                        x2="15"
                                                                                                        y1="4"
                                                                                                        y2="4">
                                                                                                    </line>
                                                                                                    <line class="ql-stroke"
                                                                                                        x1="7"
                                                                                                        x2="15"
                                                                                                        y1="9"
                                                                                                        y2="9">
                                                                                                    </line>
                                                                                                    <line class="ql-stroke"
                                                                                                        x1="7"
                                                                                                        x2="15"
                                                                                                        y1="14"
                                                                                                        y2="14">
                                                                                                    </line>
                                                                                                    <line
                                                                                                        class="ql-stroke ql-thin"
                                                                                                        x1="2.5"
                                                                                                        x2="4.5"
                                                                                                        y1="5.5"
                                                                                                        y2="5.5">
                                                                                                    </line>
                                                                                                    <path class="ql-fill"
                                                                                                        d="M3.5,6A0.5,0.5,0,0,1,3,5.5V3.085l-0.276.138A0.5,0.5,0,0,1,2.053,3c-0.124-.247-0.023-0.324.224-0.447l1-.5A0.5,0.5,0,0,1,4,2.5v3A0.5,0.5,0,0,1,3.5,6Z">
                                                                                                    </path>
                                                                                                    <path
                                                                                                        class="ql-stroke ql-thin"
                                                                                                        d="M4.5,10.5h-2c0-.234,1.85-1.076,1.85-2.234A0.959,0.959,0,0,0,2.5,8.156">
                                                                                                    </path>
                                                                                                    <path
                                                                                                        class="ql-stroke ql-thin"
                                                                                                        d="M2.5,14.846a0.959,0.959,0,0,0,1.85-.109A0.7,0.7,0,0,0,3.75,14a0.688,0.688,0,0,0,.6-0.736,0.959,0.959,0,0,0-1.85-.109">
                                                                                                    </path>
                                                                                                </svg></button>
                                                                                            <button class="ql-list"
                                                                                                value="bullet"
                                                                                                type="button"><svg
                                                                                                    viewBox="0 0 18 18">
                                                                                                    <line class="ql-stroke"
                                                                                                        x1="6"
                                                                                                        x2="15"
                                                                                                        y1="4"
                                                                                                        y2="4">
                                                                                                    </line>
                                                                                                    <line class="ql-stroke"
                                                                                                        x1="6"
                                                                                                        x2="15"
                                                                                                        y1="9"
                                                                                                        y2="9">
                                                                                                    </line>
                                                                                                    <line class="ql-stroke"
                                                                                                        x1="6"
                                                                                                        x2="15"
                                                                                                        y1="14"
                                                                                                        y2="14">
                                                                                                    </line>
                                                                                                    <line class="ql-stroke"
                                                                                                        x1="3"
                                                                                                        x2="3"
                                                                                                        y1="4"
                                                                                                        y2="4">
                                                                                                    </line>
                                                                                                    <line class="ql-stroke"
                                                                                                        x1="3"
                                                                                                        x2="3"
                                                                                                        y1="9"
                                                                                                        y2="9">
                                                                                                    </line>
                                                                                                    <line class="ql-stroke"
                                                                                                        x1="3"
                                                                                                        x2="3"
                                                                                                        y1="14"
                                                                                                        y2="14">
                                                                                                    </line>
                                                                                                </svg></button>

                                                                                        </span>
                                                                                    </div>
                                                                                    <input type="file"
                                                                                        accept="image/png, image/gif, image/jpeg, image/bmp, image/x-icon"
                                                                                        class="ql-image">
                                                                                </div>
                                                                                <div class="comment-editor border-0 pb-4 ql-container ql-snow"
                                                                                    id="ecommerce-category-description">
                                                                                    <div class="ql-editor ql-blank"
                                                                                        data-gramm="false"
                                                                                        contenteditable="true">
                                                                                    </div>
                                                                                    <div class="ql-clipboard"
                                                                                        contenteditable="true"
                                                                                        tabindex="-1">
                                                                                    </div>
                                                                                    <div class="ql-tooltip ql-hidden"><a
                                                                                            class="ql-preview"
                                                                                            rel="noopener noreferrer"
                                                                                            target="_blank"
                                                                                            href="about:blank"></a><input
                                                                                            type="text"
                                                                                            data-formula="e=mc^2"
                                                                                            data-link="https://quilljs.com"
                                                                                            data-video="Embed URL"><a
                                                                                            class="ql-action"></a><a
                                                                                            class="ql-remove"></a></div>
                                                                                </div>
                                                                            </div>
                                                                        </div> --}}
                                                                        <textarea class="form-control" rows="3" id="exampleFormControlTextarea" name="objectif_general"
                                                                            style="height: 121px;"></textarea>

                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4 col-12">
                                                                    <div class="mb-1">
                                                                        <label>Objectifs spécifiques </label>
                                                                        {{-- <div>
                                                                            <div class="form-control p-0 pt-1">
                                                                                <div
                                                                                    class="comment-toolbar border-0 border-bottom ql-toolbar ql-snow">
                                                                                    <div
                                                                                        class="d-flex justify-content-start">
                                                                                        <span class="ql-formats me-0">
                                                                                            <button class="ql-bold"
                                                                                                type="button"><svg
                                                                                                    viewBox="0 0 18 18">
                                                                                                    <path class="ql-stroke"
                                                                                                        d="M5,4H9.5A2.5,2.5,0,0,1,12,6.5v0A2.5,2.5,0,0,1,9.5,9H5A0,0,0,0,1,5,9V4A0,0,0,0,1,5,4Z">
                                                                                                    </path>
                                                                                                    <path class="ql-stroke"
                                                                                                        d="M5,9h5.5A2.5,2.5,0,0,1,13,11.5v0A2.5,2.5,0,0,1,10.5,14H5a0,0,0,0,1,0,0V9A0,0,0,0,1,5,9Z">
                                                                                                    </path>
                                                                                                </svg></button>
                                                                                            <button class="ql-italic"
                                                                                                type="button"><svg
                                                                                                    viewBox="0 0 18 18">
                                                                                                    <line class="ql-stroke"
                                                                                                        x1="7"
                                                                                                        x2="13"
                                                                                                        y1="4"
                                                                                                        y2="4">
                                                                                                    </line>
                                                                                                    <line class="ql-stroke"
                                                                                                        x1="5"
                                                                                                        x2="11"
                                                                                                        y1="14"
                                                                                                        y2="14">
                                                                                                    </line>
                                                                                                    <line class="ql-stroke"
                                                                                                        x1="8"
                                                                                                        x2="10"
                                                                                                        y1="14"
                                                                                                        y2="4">
                                                                                                    </line>
                                                                                                </svg></button>
                                                                                            <button class="ql-underline"
                                                                                                type="button"><svg
                                                                                                    viewBox="0 0 18 18">
                                                                                                    <path class="ql-stroke"
                                                                                                        d="M5,3V9a4.012,4.012,0,0,0,4,4H9a4.012,4.012,0,0,0,4-4V3">
                                                                                                    </path>
                                                                                                    <rect class="ql-fill"
                                                                                                        height="1"
                                                                                                        rx="0.5"
                                                                                                        ry="0.5"
                                                                                                        width="12"
                                                                                                        x="3" y="15"></rect>
                                                                                                </svg></button>
                                                                                            <button class="ql-list"
                                                                                                value="ordered"
                                                                                                type="button"><svg
                                                                                                    viewBox="0 0 18 18">
                                                                                                    <line class="ql-stroke"
                                                                                                        x1="7"
                                                                                                        x2="15"
                                                                                                        y1="4"
                                                                                                        y2="4">
                                                                                                    </line>
                                                                                                    <line class="ql-stroke"
                                                                                                        x1="7"
                                                                                                        x2="15"
                                                                                                        y1="9"
                                                                                                        y2="9">
                                                                                                    </line>
                                                                                                    <line class="ql-stroke"
                                                                                                        x1="7"
                                                                                                        x2="15"
                                                                                                        y1="14"
                                                                                                        y2="14">
                                                                                                    </line>
                                                                                                    <line
                                                                                                        class="ql-stroke ql-thin"
                                                                                                        x1="2.5"
                                                                                                        x2="4.5"
                                                                                                        y1="5.5"
                                                                                                        y2="5.5">
                                                                                                    </line>
                                                                                                    <path class="ql-fill"
                                                                                                        d="M3.5,6A0.5,0.5,0,0,1,3,5.5V3.085l-0.276.138A0.5,0.5,0,0,1,2.053,3c-0.124-.247-0.023-0.324.224-0.447l1-.5A0.5,0.5,0,0,1,4,2.5v3A0.5,0.5,0,0,1,3.5,6Z">
                                                                                                    </path>
                                                                                                    <path
                                                                                                        class="ql-stroke ql-thin"
                                                                                                        d="M4.5,10.5h-2c0-.234,1.85-1.076,1.85-2.234A0.959,0.959,0,0,0,2.5,8.156">
                                                                                                    </path>
                                                                                                    <path
                                                                                                        class="ql-stroke ql-thin"
                                                                                                        d="M2.5,14.846a0.959,0.959,0,0,0,1.85-.109A0.7,0.7,0,0,0,3.75,14a0.688,0.688,0,0,0,.6-0.736,0.959,0.959,0,0,0-1.85-.109">
                                                                                                    </path>
                                                                                                </svg></button>
                                                                                            <button class="ql-list"
                                                                                                value="bullet"
                                                                                                type="button"><svg
                                                                                                    viewBox="0 0 18 18">
                                                                                                    <line class="ql-stroke"
                                                                                                        x1="6"
                                                                                                        x2="15"
                                                                                                        y1="4"
                                                                                                        y2="4">
                                                                                                    </line>
                                                                                                    <line class="ql-stroke"
                                                                                                        x1="6"
                                                                                                        x2="15"
                                                                                                        y1="9"
                                                                                                        y2="9">
                                                                                                    </line>
                                                                                                    <line class="ql-stroke"
                                                                                                        x1="6"
                                                                                                        x2="15"
                                                                                                        y1="14"
                                                                                                        y2="14">
                                                                                                    </line>
                                                                                                    <line class="ql-stroke"
                                                                                                        x1="3"
                                                                                                        x2="3"
                                                                                                        y1="4"
                                                                                                        y2="4">
                                                                                                    </line>
                                                                                                    <line class="ql-stroke"
                                                                                                        x1="3"
                                                                                                        x2="3"
                                                                                                        y1="9"
                                                                                                        y2="9">
                                                                                                    </line>
                                                                                                    <line class="ql-stroke"
                                                                                                        x1="3"
                                                                                                        x2="3"
                                                                                                        y1="14"
                                                                                                        y2="14">
                                                                                                    </line>
                                                                                                </svg></button>

                                                                                        </span>
                                                                                    </div>
                                                                                    <input type="file"
                                                                                        accept="image/png, image/gif, image/jpeg, image/bmp, image/x-icon"
                                                                                        class="ql-image">
                                                                                </div>
                                                                                <div class="comment-editor border-0 pb-4 ql-container ql-snow"
                                                                                    id="ecommerce-category-description">
                                                                                    <div class="ql-editor ql-blank"
                                                                                        data-gramm="false"
                                                                                        contenteditable="true"
                                                                                        data-placeholder="">

                                                                                    </div>
                                                                                    <div class="ql-clipboard"
                                                                                        contenteditable="true"
                                                                                        tabindex="-1"></div>
                                                                                    <div class="ql-tooltip ql-hidden"><a
                                                                                            class="ql-preview"
                                                                                            rel="noopener noreferrer"
                                                                                            target="_blank"
                                                                                            href="about:blank"></a><input
                                                                                            type="text"
                                                                                            data-formula="e=mc^2"
                                                                                            data-link="https://quilljs.com"
                                                                                            data-video="Embed URL"><a
                                                                                            class="ql-action"></a><a
                                                                                            class="ql-remove"></a></div>
                                                                                </div>
                                                                            </div>
                                                                        </div> --}}
                                                                        <textarea class="form-control" rows="3" id="exampleFormControlTextarea" name="objectif_specifique"
                                                                            style="height: 121px;"></textarea>

                                                                    </div>
                                                                </div>

                                                                <div class="col-md-4 col-12">
                                                                    <div class="mb-1">
                                                                        <label>Résultats attendus </label>
                                                                        {{-- <div>
                                                                            <div class="form-control p-0 pt-1">
                                                                                <div
                                                                                    class="comment-toolbar border-0 border-bottom ql-toolbar ql-snow">
                                                                                    <div
                                                                                        class="d-flex justify-content-start">
                                                                                        <span class="ql-formats me-0">
                                                                                            <button class="ql-bold"
                                                                                                type="button"><svg
                                                                                                    viewBox="0 0 18 18">
                                                                                                    <path class="ql-stroke"
                                                                                                        d="M5,4H9.5A2.5,2.5,0,0,1,12,6.5v0A2.5,2.5,0,0,1,9.5,9H5A0,0,0,0,1,5,9V4A0,0,0,0,1,5,4Z">
                                                                                                    </path>
                                                                                                    <path class="ql-stroke"
                                                                                                        d="M5,9h5.5A2.5,2.5,0,0,1,13,11.5v0A2.5,2.5,0,0,1,10.5,14H5a0,0,0,0,1,0,0V9A0,0,0,0,1,5,9Z">
                                                                                                    </path>
                                                                                                </svg></button>
                                                                                            <button class="ql-italic"
                                                                                                type="button"><svg
                                                                                                    viewBox="0 0 18 18">
                                                                                                    <line class="ql-stroke"
                                                                                                        x1="7"
                                                                                                        x2="13"
                                                                                                        y1="4"
                                                                                                        y2="4">
                                                                                                    </line>
                                                                                                    <line class="ql-stroke"
                                                                                                        x1="5"
                                                                                                        x2="11"
                                                                                                        y1="14"
                                                                                                        y2="14">
                                                                                                    </line>
                                                                                                    <line class="ql-stroke"
                                                                                                        x1="8"
                                                                                                        x2="10"
                                                                                                        y1="14"
                                                                                                        y2="4">
                                                                                                    </line>
                                                                                                </svg></button>
                                                                                            <button class="ql-underline"
                                                                                                type="button"><svg
                                                                                                    viewBox="0 0 18 18">
                                                                                                    <path class="ql-stroke"
                                                                                                        d="M5,3V9a4.012,4.012,0,0,0,4,4H9a4.012,4.012,0,0,0,4-4V3">
                                                                                                    </path>
                                                                                                    <rect class="ql-fill"
                                                                                                        height="1"
                                                                                                        rx="0.5"
                                                                                                        ry="0.5"
                                                                                                        width="12"
                                                                                                        x="3" y="15"></rect>
                                                                                                </svg></button>
                                                                                            <button class="ql-list"
                                                                                                value="ordered"
                                                                                                type="button"><svg
                                                                                                    viewBox="0 0 18 18">
                                                                                                    <line class="ql-stroke"
                                                                                                        x1="7"
                                                                                                        x2="15"
                                                                                                        y1="4"
                                                                                                        y2="4">
                                                                                                    </line>
                                                                                                    <line class="ql-stroke"
                                                                                                        x1="7"
                                                                                                        x2="15"
                                                                                                        y1="9"
                                                                                                        y2="9">
                                                                                                    </line>
                                                                                                    <line class="ql-stroke"
                                                                                                        x1="7"
                                                                                                        x2="15"
                                                                                                        y1="14"
                                                                                                        y2="14">
                                                                                                    </line>
                                                                                                    <line
                                                                                                        class="ql-stroke ql-thin"
                                                                                                        x1="2.5"
                                                                                                        x2="4.5"
                                                                                                        y1="5.5"
                                                                                                        y2="5.5">
                                                                                                    </line>
                                                                                                    <path class="ql-fill"
                                                                                                        d="M3.5,6A0.5,0.5,0,0,1,3,5.5V3.085l-0.276.138A0.5,0.5,0,0,1,2.053,3c-0.124-.247-0.023-0.324.224-0.447l1-.5A0.5,0.5,0,0,1,4,2.5v3A0.5,0.5,0,0,1,3.5,6Z">
                                                                                                    </path>
                                                                                                    <path
                                                                                                        class="ql-stroke ql-thin"
                                                                                                        d="M4.5,10.5h-2c0-.234,1.85-1.076,1.85-2.234A0.959,0.959,0,0,0,2.5,8.156">
                                                                                                    </path>
                                                                                                    <path
                                                                                                        class="ql-stroke ql-thin"
                                                                                                        d="M2.5,14.846a0.959,0.959,0,0,0,1.85-.109A0.7,0.7,0,0,0,3.75,14a0.688,0.688,0,0,0,.6-0.736,0.959,0.959,0,0,0-1.85-.109">
                                                                                                    </path>
                                                                                                </svg></button>
                                                                                            <button class="ql-list"
                                                                                                value="bullet"
                                                                                                type="button"><svg
                                                                                                    viewBox="0 0 18 18">
                                                                                                    <line class="ql-stroke"
                                                                                                        x1="6"
                                                                                                        x2="15"
                                                                                                        y1="4"
                                                                                                        y2="4">
                                                                                                    </line>
                                                                                                    <line class="ql-stroke"
                                                                                                        x1="6"
                                                                                                        x2="15"
                                                                                                        y1="9"
                                                                                                        y2="9">
                                                                                                    </line>
                                                                                                    <line class="ql-stroke"
                                                                                                        x1="6"
                                                                                                        x2="15"
                                                                                                        y1="14"
                                                                                                        y2="14">
                                                                                                    </line>
                                                                                                    <line class="ql-stroke"
                                                                                                        x1="3"
                                                                                                        x2="3"
                                                                                                        y1="4"
                                                                                                        y2="4">
                                                                                                    </line>
                                                                                                    <line class="ql-stroke"
                                                                                                        x1="3"
                                                                                                        x2="3"
                                                                                                        y1="9"
                                                                                                        y2="9">
                                                                                                    </line>
                                                                                                    <line class="ql-stroke"
                                                                                                        x1="3"
                                                                                                        x2="3"
                                                                                                        y1="14"
                                                                                                        y2="14">
                                                                                                    </line>
                                                                                                </svg></button>
                                                                                            <button class="ql-link"
                                                                                                type="button"><svg
                                                                                                    viewBox="0 0 18 18">
                                                                                                    <line class="ql-stroke"
                                                                                                        x1="7"
                                                                                                        x2="11"
                                                                                                        y1="7"
                                                                                                        y2="11">
                                                                                                    </line>
                                                                                                    <path
                                                                                                        class="ql-even ql-stroke"
                                                                                                        d="M8.9,4.577a3.476,3.476,0,0,1,.36,4.679A3.476,3.476,0,0,1,4.577,8.9C3.185,7.5,2.035,6.4,4.217,4.217S7.5,3.185,8.9,4.577Z">
                                                                                                    </path>
                                                                                                    <path
                                                                                                        class="ql-even ql-stroke"
                                                                                                        d="M13.423,9.1a3.476,3.476,0,0,0-4.679-.36,3.476,3.476,0,0,0,.36,4.679c1.392,1.392,2.5,2.542,4.679.36S14.815,10.5,13.423,9.1Z">
                                                                                                    </path>
                                                                                                </svg></button>
                                                                                            <button class="ql-image"
                                                                                                type="button"><svg
                                                                                                    viewBox="0 0 18 18">
                                                                                                    <rect class="ql-stroke"
                                                                                                        height="10"
                                                                                                        width="12"
                                                                                                        x="3" y="4"></rect>
                                                                                                    <circle class="ql-fill"
                                                                                                        cx="6"
                                                                                                        cy="7"
                                                                                                        r="1"></circle>
                                                                                                    <polyline
                                                                                                        class="ql-even ql-fill"
                                                                                                        points="5 12 5 11 7 9 8 10 11 7 13 9 13 12 5 12">
                                                                                                    </polyline>
                                                                                                </svg></button>
                                                                                        </span>
                                                                                    </div>
                                                                                    <input type="file"
                                                                                        accept="image/png, image/gif, image/jpeg, image/bmp, image/x-icon"
                                                                                        class="ql-image">
                                                                                </div>
                                                                                <div class="comment-editor border-0 pb-4 ql-container ql-snow"
                                                                                    id="ecommerce-category-description">
                                                                                    <div class="ql-editor ql-blank"
                                                                                        data-gramm="false"
                                                                                        contenteditable="true"
                                                                                        data-placeholder="">

                                                                                    </div>
                                                                                    <div class="ql-clipboard"
                                                                                        contenteditable="true"
                                                                                        tabindex="-1"></div>
                                                                                    <div class="ql-tooltip ql-hidden"><a
                                                                                            class="ql-preview"
                                                                                            rel="noopener noreferrer"
                                                                                            target="_blank"
                                                                                            href="about:blank"></a><input
                                                                                            type="text"
                                                                                            data-formula="e=mc^2"
                                                                                            data-link="https://quilljs.com"
                                                                                            data-video="Embed URL"><a
                                                                                            class="ql-action"></a><a
                                                                                            class="ql-remove"></a></div>
                                                                                </div>
                                                                            </div>
                                                                        </div> --}}
                                                                        <textarea class="form-control" rows="3" id="exampleFormControlTextarea" name="resultat_attendu"
                                                                            style="height: 121px;"></textarea>

                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4 col-12">
                                                                    <div class="mb-1">
                                                                        <label>Champ de l’étude </label>
                                                                        {{-- <div>
                                                                            <div class="form-control p-0 pt-1">
                                                                                <div
                                                                                    class="comment-toolbar border-0 border-bottom ql-toolbar ql-snow">
                                                                                    <div
                                                                                        class="d-flex justify-content-start">
                                                                                        <span class="ql-formats me-0">
                                                                                            <button class="ql-bold"
                                                                                                type="button"><svg
                                                                                                    viewBox="0 0 18 18">
                                                                                                    <path class="ql-stroke"
                                                                                                        d="M5,4H9.5A2.5,2.5,0,0,1,12,6.5v0A2.5,2.5,0,0,1,9.5,9H5A0,0,0,0,1,5,9V4A0,0,0,0,1,5,4Z">
                                                                                                    </path>
                                                                                                    <path class="ql-stroke"
                                                                                                        d="M5,9h5.5A2.5,2.5,0,0,1,13,11.5v0A2.5,2.5,0,0,1,10.5,14H5a0,0,0,0,1,0,0V9A0,0,0,0,1,5,9Z">
                                                                                                    </path>
                                                                                                </svg></button>
                                                                                            <button class="ql-italic"
                                                                                                type="button"><svg
                                                                                                    viewBox="0 0 18 18">
                                                                                                    <line class="ql-stroke"
                                                                                                        x1="7"
                                                                                                        x2="13"
                                                                                                        y1="4"
                                                                                                        y2="4">
                                                                                                    </line>
                                                                                                    <line class="ql-stroke"
                                                                                                        x1="5"
                                                                                                        x2="11"
                                                                                                        y1="14"
                                                                                                        y2="14">
                                                                                                    </line>
                                                                                                    <line class="ql-stroke"
                                                                                                        x1="8"
                                                                                                        x2="10"
                                                                                                        y1="14"
                                                                                                        y2="4">
                                                                                                    </line>
                                                                                                </svg></button>
                                                                                            <button class="ql-underline"
                                                                                                type="button"><svg
                                                                                                    viewBox="0 0 18 18">
                                                                                                    <path class="ql-stroke"
                                                                                                        d="M5,3V9a4.012,4.012,0,0,0,4,4H9a4.012,4.012,0,0,0,4-4V3">
                                                                                                    </path>
                                                                                                    <rect class="ql-fill"
                                                                                                        height="1"
                                                                                                        rx="0.5"
                                                                                                        ry="0.5"
                                                                                                        width="12"
                                                                                                        x="3" y="15"></rect>
                                                                                                </svg></button>
                                                                                            <button class="ql-list"
                                                                                                value="ordered"
                                                                                                type="button"><svg
                                                                                                    viewBox="0 0 18 18">
                                                                                                    <line class="ql-stroke"
                                                                                                        x1="7"
                                                                                                        x2="15"
                                                                                                        y1="4"
                                                                                                        y2="4">
                                                                                                    </line>
                                                                                                    <line class="ql-stroke"
                                                                                                        x1="7"
                                                                                                        x2="15"
                                                                                                        y1="9"
                                                                                                        y2="9">
                                                                                                    </line>
                                                                                                    <line class="ql-stroke"
                                                                                                        x1="7"
                                                                                                        x2="15"
                                                                                                        y1="14"
                                                                                                        y2="14">
                                                                                                    </line>
                                                                                                    <line
                                                                                                        class="ql-stroke ql-thin"
                                                                                                        x1="2.5"
                                                                                                        x2="4.5"
                                                                                                        y1="5.5"
                                                                                                        y2="5.5">
                                                                                                    </line>
                                                                                                    <path class="ql-fill"
                                                                                                        d="M3.5,6A0.5,0.5,0,0,1,3,5.5V3.085l-0.276.138A0.5,0.5,0,0,1,2.053,3c-0.124-.247-0.023-0.324.224-0.447l1-.5A0.5,0.5,0,0,1,4,2.5v3A0.5,0.5,0,0,1,3.5,6Z">
                                                                                                    </path>
                                                                                                    <path
                                                                                                        class="ql-stroke ql-thin"
                                                                                                        d="M4.5,10.5h-2c0-.234,1.85-1.076,1.85-2.234A0.959,0.959,0,0,0,2.5,8.156">
                                                                                                    </path>
                                                                                                    <path
                                                                                                        class="ql-stroke ql-thin"
                                                                                                        d="M2.5,14.846a0.959,0.959,0,0,0,1.85-.109A0.7,0.7,0,0,0,3.75,14a0.688,0.688,0,0,0,.6-0.736,0.959,0.959,0,0,0-1.85-.109">
                                                                                                    </path>
                                                                                                </svg></button>
                                                                                            <button class="ql-list"
                                                                                                value="bullet"
                                                                                                type="button"><svg
                                                                                                    viewBox="0 0 18 18">
                                                                                                    <line class="ql-stroke"
                                                                                                        x1="6"
                                                                                                        x2="15"
                                                                                                        y1="4"
                                                                                                        y2="4">
                                                                                                    </line>
                                                                                                    <line class="ql-stroke"
                                                                                                        x1="6"
                                                                                                        x2="15"
                                                                                                        y1="9"
                                                                                                        y2="9">
                                                                                                    </line>
                                                                                                    <line class="ql-stroke"
                                                                                                        x1="6"
                                                                                                        x2="15"
                                                                                                        y1="14"
                                                                                                        y2="14">
                                                                                                    </line>
                                                                                                    <line class="ql-stroke"
                                                                                                        x1="3"
                                                                                                        x2="3"
                                                                                                        y1="4"
                                                                                                        y2="4">
                                                                                                    </line>
                                                                                                    <line class="ql-stroke"
                                                                                                        x1="3"
                                                                                                        x2="3"
                                                                                                        y1="9"
                                                                                                        y2="9">
                                                                                                    </line>
                                                                                                    <line class="ql-stroke"
                                                                                                        x1="3"
                                                                                                        x2="3"
                                                                                                        y1="14"
                                                                                                        y2="14">
                                                                                                    </line>
                                                                                                </svg></button>

                                                                                        </span>
                                                                                    </div>
                                                                                    <input type="file"
                                                                                        accept="image/png, image/gif, image/jpeg, image/bmp, image/x-icon"
                                                                                        class="ql-image">
                                                                                </div>
                                                                                <div class="comment-editor border-0 pb-4 ql-container ql-snow"
                                                                                    id="ecommerce-category-description">
                                                                                    <div class="ql-editor ql-blank"
                                                                                        data-gramm="false"
                                                                                        contenteditable="true"
                                                                                        data-placeholder="">

                                                                                    </div>
                                                                                    <div class="ql-clipboard"
                                                                                        contenteditable="true"
                                                                                        tabindex="-1"></div>
                                                                                    <div class="ql-tooltip ql-hidden"><a
                                                                                            class="ql-preview"
                                                                                            rel="noopener noreferrer"
                                                                                            target="_blank"
                                                                                            href="about:blank"></a><input
                                                                                            type="text"
                                                                                            data-formula="e=mc^2"
                                                                                            data-link="https://quilljs.com"
                                                                                            data-video="Embed URL"><a
                                                                                            class="ql-action"></a><a
                                                                                            class="ql-remove"></a></div>
                                                                                </div>
                                                                            </div>
                                                                        </div> --}}
                                                                        <textarea class="form-control" rows="3" id="exampleFormControlTextarea" name="champ_etude"
                                                                            style="height: 121px;"></textarea>

                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4 col-12">
                                                                    <div class="mb-1">
                                                                        <label>Cible </label>
                                                                        {{-- <div>
                                                                            <div class="form-control p-0 pt-1">
                                                                                <div
                                                                                    class="comment-toolbar border-0 border-bottom ql-toolbar ql-snow">
                                                                                    <div
                                                                                        class="d-flex justify-content-start">
                                                                                        <span class="ql-formats me-0">
                                                                                            <button class="ql-bold"
                                                                                                type="button"><svg
                                                                                                    viewBox="0 0 18 18">
                                                                                                    <path class="ql-stroke"
                                                                                                        d="M5,4H9.5A2.5,2.5,0,0,1,12,6.5v0A2.5,2.5,0,0,1,9.5,9H5A0,0,0,0,1,5,9V4A0,0,0,0,1,5,4Z">
                                                                                                    </path>
                                                                                                    <path class="ql-stroke"
                                                                                                        d="M5,9h5.5A2.5,2.5,0,0,1,13,11.5v0A2.5,2.5,0,0,1,10.5,14H5a0,0,0,0,1,0,0V9A0,0,0,0,1,5,9Z">
                                                                                                    </path>
                                                                                                </svg></button>
                                                                                            <button class="ql-italic"
                                                                                                type="button"><svg
                                                                                                    viewBox="0 0 18 18">
                                                                                                    <line class="ql-stroke"
                                                                                                        x1="7"
                                                                                                        x2="13"
                                                                                                        y1="4"
                                                                                                        y2="4">
                                                                                                    </line>
                                                                                                    <line class="ql-stroke"
                                                                                                        x1="5"
                                                                                                        x2="11"
                                                                                                        y1="14"
                                                                                                        y2="14">
                                                                                                    </line>
                                                                                                    <line class="ql-stroke"
                                                                                                        x1="8"
                                                                                                        x2="10"
                                                                                                        y1="14"
                                                                                                        y2="4">
                                                                                                    </line>
                                                                                                </svg></button>
                                                                                            <button class="ql-underline"
                                                                                                type="button"><svg
                                                                                                    viewBox="0 0 18 18">
                                                                                                    <path class="ql-stroke"
                                                                                                        d="M5,3V9a4.012,4.012,0,0,0,4,4H9a4.012,4.012,0,0,0,4-4V3">
                                                                                                    </path>
                                                                                                    <rect class="ql-fill"
                                                                                                        height="1"
                                                                                                        rx="0.5"
                                                                                                        ry="0.5"
                                                                                                        width="12"
                                                                                                        x="3" y="15"></rect>
                                                                                                </svg></button>
                                                                                            <button class="ql-list"
                                                                                                value="ordered"
                                                                                                type="button"><svg
                                                                                                    viewBox="0 0 18 18">
                                                                                                    <line class="ql-stroke"
                                                                                                        x1="7"
                                                                                                        x2="15"
                                                                                                        y1="4"
                                                                                                        y2="4">
                                                                                                    </line>
                                                                                                    <line class="ql-stroke"
                                                                                                        x1="7"
                                                                                                        x2="15"
                                                                                                        y1="9"
                                                                                                        y2="9">
                                                                                                    </line>
                                                                                                    <line class="ql-stroke"
                                                                                                        x1="7"
                                                                                                        x2="15"
                                                                                                        y1="14"
                                                                                                        y2="14">
                                                                                                    </line>
                                                                                                    <line
                                                                                                        class="ql-stroke ql-thin"
                                                                                                        x1="2.5"
                                                                                                        x2="4.5"
                                                                                                        y1="5.5"
                                                                                                        y2="5.5">
                                                                                                    </line>
                                                                                                    <path class="ql-fill"
                                                                                                        d="M3.5,6A0.5,0.5,0,0,1,3,5.5V3.085l-0.276.138A0.5,0.5,0,0,1,2.053,3c-0.124-.247-0.023-0.324.224-0.447l1-.5A0.5,0.5,0,0,1,4,2.5v3A0.5,0.5,0,0,1,3.5,6Z">
                                                                                                    </path>
                                                                                                    <path
                                                                                                        class="ql-stroke ql-thin"
                                                                                                        d="M4.5,10.5h-2c0-.234,1.85-1.076,1.85-2.234A0.959,0.959,0,0,0,2.5,8.156">
                                                                                                    </path>
                                                                                                    <path
                                                                                                        class="ql-stroke ql-thin"
                                                                                                        d="M2.5,14.846a0.959,0.959,0,0,0,1.85-.109A0.7,0.7,0,0,0,3.75,14a0.688,0.688,0,0,0,.6-0.736,0.959,0.959,0,0,0-1.85-.109">
                                                                                                    </path>
                                                                                                </svg></button>
                                                                                            <button class="ql-list"
                                                                                                value="bullet"
                                                                                                type="button"><svg
                                                                                                    viewBox="0 0 18 18">
                                                                                                    <line class="ql-stroke"
                                                                                                        x1="6"
                                                                                                        x2="15"
                                                                                                        y1="4"
                                                                                                        y2="4">
                                                                                                    </line>
                                                                                                    <line class="ql-stroke"
                                                                                                        x1="6"
                                                                                                        x2="15"
                                                                                                        y1="9"
                                                                                                        y2="9">
                                                                                                    </line>
                                                                                                    <line class="ql-stroke"
                                                                                                        x1="6"
                                                                                                        x2="15"
                                                                                                        y1="14"
                                                                                                        y2="14">
                                                                                                    </line>
                                                                                                    <line class="ql-stroke"
                                                                                                        x1="3"
                                                                                                        x2="3"
                                                                                                        y1="4"
                                                                                                        y2="4">
                                                                                                    </line>
                                                                                                    <line class="ql-stroke"
                                                                                                        x1="3"
                                                                                                        x2="3"
                                                                                                        y1="9"
                                                                                                        y2="9">
                                                                                                    </line>
                                                                                                    <line class="ql-stroke"
                                                                                                        x1="3"
                                                                                                        x2="3"
                                                                                                        y1="14"
                                                                                                        y2="14">
                                                                                                    </line>
                                                                                                </svg></button>


                                                                                        </span>
                                                                                    </div>
                                                                                    <input type="file"
                                                                                        accept="image/png, image/gif, image/jpeg, image/bmp, image/x-icon"
                                                                                        class="ql-image">
                                                                                </div>
                                                                                <div class="comment-editor border-0 pb-4 ql-container ql-snow"
                                                                                    id="ecommerce-category-description">
                                                                                    <div class="ql-editor ql-blank"
                                                                                        data-gramm="false"
                                                                                        contenteditable="true"
                                                                                        data-placeholder="">

                                                                                    </div>
                                                                                    <div class="ql-clipboard"
                                                                                        contenteditable="true"
                                                                                        tabindex="-1"></div>
                                                                                    <div class="ql-tooltip ql-hidden"><a
                                                                                            class="ql-preview"
                                                                                            rel="noopener noreferrer"
                                                                                            target="_blank"
                                                                                            href="about:blank"></a><input
                                                                                            type="text"
                                                                                            data-formula="e=mc^2"
                                                                                            data-link="https://quilljs.com"
                                                                                            data-video="Embed URL"><a
                                                                                            class="ql-action"></a><a
                                                                                            class="ql-remove"></a></div>
                                                                                </div>
                                                                            </div>
                                                                        </div> --}}
                                                                        <textarea class="form-control" rows="3" id="exampleFormControlTextarea" name="cible"
                                                                            style="height: 121px;"></textarea>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card accordion-item">
                                                    <h2 class="accordion-header" id="headingThree">
                                                        <button type="button" class="accordion-button collapsed"
                                                            data-bs-toggle="collapse" data-bs-target="#accordionThree"
                                                            aria-expanded="false" aria-controls="accordionThree">
                                                            Pieces jointes du projet
                                                        </button>
                                                    </h2>
                                                    <div id="accordionThree" class="accordion-collapse collapse"
                                                        aria-labelledby="headingThree" data-bs-parent="#accordionExample"
                                                        style="">
                                                        <div class="accordion-body">
                                                            <div class="row gy-3">

                                                                <div class="col-md-4">
                                                                    <label class="form-label">Avant-projet TDR * (PDF, JPG,
                                                                        JPEG, PNG)
                                                                        5M</label>
                                                                    <input type="file" name="avant_projet_tdr"
                                                                        class="form-control" placeholder=""
                                                                        required="required" />
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label class="form-label">Courrier de demande de
                                                                        financement* (PDF,
                                                                        JPG, JPEG, PNG)5M</label>
                                                                    <input type="file" name="courier_demande_fin"
                                                                        class="form-control" placeholder=""
                                                                        required="required" />
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label class="form-label">Dossier d’intention * (PDF,
                                                                        JPG,
                                                                        JPEG, PNG) 5M</label>
                                                                    <input type="file" name="dossier_intention"
                                                                        class="form-control" placeholder=""
                                                                        required="required" />
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label class="form-label">Lettre d’engagement * (PDF,
                                                                        JPG, JPEG,
                                                                        PNG) 5M</label>
                                                                    <input type="file" name="lettre_engagement"
                                                                        class="form-control" placeholder=""
                                                                        required="required" />
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label class="form-label">Offre technique* (PDF, JPG,
                                                                        JPEG, PNG)
                                                                        5M</label>
                                                                    <input type="file" name="offre_technique"
                                                                        class="form-control" placeholder=""
                                                                        required="required" />
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label class="form-label">Offre financière * (PDF, JPG,
                                                                        JPEG, PNG) 5M</label>
                                                                    <input type="file" name="offre_financiere"
                                                                        class="form-control" placeholder=""
                                                                        required="required" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <br>
                                            <div class="col-12" align="left">

                                                <div class="col-12" align="right">
                                                    <button type="submit"
                                                        class="btn btn-sm btn-primary me-1 waves-effect waves-float waves-light">
                                                        Enregistrer
                                                    </button>
                                                    <a class="btn btn-sm btn-outline-secondary waves-effect"
                                                        href="/{{ $lien }}">
                                                        Retour</a>
                                                </div>
                                            </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
    <!-- END: Content-->
@endsection
