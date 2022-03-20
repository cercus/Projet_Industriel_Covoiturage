@extends('base')

@section('title')
    Informations personnelles
@endsection

@section('style')
    <link rel="stylesheet" href="/css/style.css">
@endsection

@section('navbarSequel')
    <ul class="navbar-nav mr-auto"> 
        <li class="nav-item">
            <a class="nav-link" href="{{route('user', ['idUtilisateur' => session()->get('user')['id']])}}">{{ $infoPerso->prenomUtilisateur }} {{ $infoPerso->nomUtilisateur }}</a>
        </li>
    </ul>
    <div class="pmd-user-info ">
        <a href="{{route('user', ['idUtilisateur' => session()->get('user')['id']])}}" class="nav-user-img" > 
            @if ($infoPerso->photoProfil != null)
                <img class="avatar-img rounded-circle" src="{{ $infoPerso->photoProfil }}" width="73" height="73" alt="avatar"> 
            @else
                <img class="avatar-img rounded-circle" src="/images/avatar_photo.jpg" width="73" height="73" alt="avatar">
            @endif   
        </a>
    </div>
@endsection

@section('content')

<h1 class="center-title mb-2"><strong>Vos informations personnelles</strong></h1>
@if($errors->any())
    <div class="alert alert-warning col-md-10 mx-auto">
    Impossible de modifier votre profil &#9785; 
    </div>
@endif
@if(session()->has('success'))
    <div class="alert alert-success col-md-11 mx-auto">
            {{session()->get('success')}}&#9786;
    </div>
@endif
<div class="cadre-arrondis space-bottom-title" style="padding-bottom: 30px;">
    <div class="row space-bottom-title">
        <div class="col">
            <p>
                <span class="bold-text">Adresse mail : </span>{{ $infoPerso->emailUtilisateur }}
            </p>
        </div>
        <div class="col">
            <p>
                <span class="bold-text">Numéro de téléphone : </span>{{ $infoPerso->numTelUtilisateur }}
            </p>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <p><span class="bold-text">Nom sur le site : </span> 
                {{ $infoPerso->prenomUtilisateur }} {{ $infoPerso->nomUtilisateur }}
            </p>
        </div>
        <div class="col">
            <p><span class="bold-text">Date de naissance :</span> {{ $infoPerso->dateNaiss }}</p>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <p><span class="bold-text">Numéro de permis : </span> {{ $infoPerso->numPermisConduire }}</p>
        </div>
        <div class="col">
        <p><span class="bold-text">Numéro d'identité (NNI) : </span> {{ $infoPerso->numeroIdentite }} </p>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <p><span class="bold-text">Nombre de trajet en tant que conducteur : </span> {{$nbrTrajetConducteur}}</p>
        </div>
        <div class="col">
        <p><span class="bold-text">Nombre de trajet en tant que passager : </span> {{$nbrTrajetPassager}}</p>
        </div>
    </div>

    <div class="row small-cadre-arrondis">
        @if ($infoPerso->descriptionUtilisateur == null)
            <span class="bold-text m-auto">Vous n'avez pas écrit votre description.</span>       
        @else
            <p><span class="bold-text">Description : </span> {{ $infoPerso->descriptionUtilisateur }}</p>    
        @endif
    </div>
</div>

@if ( $estConducteur != 0)
    <h1 class="center-title space-bottom-title mb-2">Vos informations techniques</h1>

    <div class="cadre-arrondis">

        <div class="row  space-bottom-title">
            <div class="col">
                <p><span class="bold-text">Immatriculation : </span>{{ $infoTechnique->immatriculation}}</p>
            </div>

            <div class="col">
                <p><span class="bold-text">Marque : </span>{{ $infoTechnique->marqueModelVoiture }}</p>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <p><span class="bold-text">Couleur de la voiture : </span>{{ $infoTechnique->couleurVoiture }}</p>
            </div>

            <div class="col">
                <p><span class="bold-text">Nombre de places : </span>{{ $infoTechnique->nbPlaceMax }}</p>
            </div>
        </div>

        <div class="row">
            <div class="col">
                @if ($infoTechnique->autoriserFumer == 0)
                    <p><span class="bold-text">Fumer à bord ? </span>non</p>
                @else
                    <p><span class="bold-text">Fumer à bord ? </span>oui</p>
                @endif
                
            </div>

            <div class="col">
                @if ($infoTechnique->autoriserAnimal == 0)
                    <p><span class="bold-text">Autoriser les animaux ? </span>non</p>
                @else
                    <p><span class="bold-text">Autoriser les animaux ? </span>oui</p> 
                @endif
                
            </div>
        </div>
    </div>
@else 
    <div class="row small-cadre-arrondis mt-3">
        <p class="bold-text m-auto">Vous n'avez pas la section "informations techniques", car vous n'êtes pas conducteur</p>
    </div>
@endif

<div class="col justify-content-center align-items-center" style="display: flex; padding-top: 30px;">
    @if ( $estConducteur == 0)
        <a href="/commun/modification_profil/{{$infoPerso->idUtilisateur}}"><button type="submit" class="btn button-form" style="margin-right: 5%;">Modifier les informations personnelles</button></a>
    @else
        <a href="/commun/modification_profil/{{$infoPerso->idUtilisateur}}"><button type="submit" class="btn button-form" style="margin-right: 5%;">Modifier les informations personnelles</button></a>
        <a href="/commun/modification_technique/{{$infoPerso->idUtilisateur}}"><button type="submit" class="btn button-form" style="margin-left: 5%;">Modifier les informations techniques</button></a>
    @endif
</div>

@endsection