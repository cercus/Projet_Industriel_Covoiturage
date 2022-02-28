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
                <a class="nav-link" href="{{route('user')}}">Ismail IDBOURHIM</a>
            </li>
        </ul>
        <div class="pmd-user-info ">
            <a href="javascript:void(0);" class="nav-user-img" >   
                <img class="avatar-img rounded-circle" src="/images/avatar_photo.jpg" width="73" height="73" alt="avatar">
            </a>
    </div>
@endsection

@section('content')

<h1 class="center-title">Vos informations personnelles</h1>

<div class="cadre-arrondis space-bottom-title" style="padding-bottom: 30px;">
    <div class="row space-bottom-title">
        <div class="col">
            <p><span class="bold-text">Adresse mail : </span>dorian.bourdontpe@gmail.com</p>
        </div>
        <div class="col">
            <p><span class="bold-text">Numéro de téléphone : </span>01 02 03 04 05</p>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <p><span class="bold-text">Nom sur le site : </span> Dorian Bourdon</p>
        </div>
        <div class="col">
            <p><span class="bold-text">Date de naissance :</span> 04/04/1998</p>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <p><span class="bold-text">Numéro de permis : </span> 950713706342</p>
        </div>
        <div class="col">
        <p><span class="bold-text">Numéro d'identité (NNI) : </span> 939049615866</p>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <p><span class="bold-text">Nombre de trajet en tant que conducteur :</span> 5</p>
        </div>
        <div class="col">
        <p><span class="bold-text">Nombre de trajet en tant que passager : </span> 10</p>
        </div>
    </div>

    <div class="row small-cadre-arrondis">
        <p><span class="bold-text">Description : </span>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla eget augue ex. Morbi lectus nisl, molestie non nisl a, fringilla iaculis nunc. Curabitur ullamcorper malesuada placerat. Integer rhoncus luctus elementum. Nullam gravida tincidunt quam eu dictum. Duis in lacus dui. Vivamus quis est lobortis, mollis ex nec, rhoncus libero. </p>
    </div>
</div>

<h1 class="center-title  space-bottom-title">Vos informations techniques</h1>

<div class="cadre-arrondis">
    <div class="row  space-bottom-title">
        <div class="col">
            <p><span class="bold-text">Immatriculation : </span>FD-547-AQ</p>
        </div>

        <div class="col">
            <p><span class="bold-text">Marque : </span>Alpha Roméo</p>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <p><span class="bold-text">Couleur de la voiture : </span>Rouge</p>
        </div>

        <div class="col">
            <p><span class="bold-text">Nombre de places : </span>3</p>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <p><span class="bold-text">Fumer à bord ? </span>Non</p>
        </div>

        <div class="col">
            <p><span class="bold-text">Autoriser les animaux ? </span>Oui</p>
        </div>
    </div>
</div>

<div class="col justify-content-center align-items-center" style="display: flex; padding-top: 30px;">
    <form method="POST" action="{{route('modification_profil')}}">@csrf<button type="submit" class="btn button-form" style="margin-right: 5%;">Modifier les informations personnelles</button></form>
    <form method="POST" action="{{route('modification_technique')}}">@csrf<button type="submit" class="btn button-form" style="margin-left: 5%;">Modifier les informations techniques</button></form>
</div>

@endsection