@extends('base')

@section('title')
    Mon profil
@endsection

@section('style')
    <link rel="stylesheet" href="/css/style.css">
@endsection
           
@section('navbarSequel')
    <ul class="navbar-nav mr-auto"> 
        <li class="nav-item">
            <a class="nav-link" href="#">Ismail IDBOURHIM</a>
        </li>
    </ul>
    <div class="pmd-user-info ">
        <a href="javascript:void(0);" class="nav-user-img" >   
            <img class="avatar-img rounded-circle" src="/images/avatar_photo.jpg" width="73" height="73" alt="avatar">
        </a>
    </div>
@endsection

@section('content')

<h1 class="center-title"><Strong>Bienvenue {{__('user')}} sur votre profil</Strong></h1></br>
<div style="text-align:center">>
    <div class="row">
        <div class="col espace-bottom" >
            <button type="button" class="button-icon" autofocus>
                <div><h3>
                    trajet Effectué
                </div></h3>
                <div class="icon-button">
                    <img src="/images/car-solid.svg" style="float:left" >
                </div>
            </button>
        </div>
        <div class="col espace-bottom">
            <button type="button" class="button-icon" autofocus>
                <div><h3>
                    Modification profil
                </div><h3>
                <div class="icon-button">
                    <img src="/images/pencil-alt-solid.svg" style="float:left" >
                </div>
            </button>
        </div>
        <div class="col espace-bottom">
            <button type="button" class="button-icon" autofocus>
                <div><h3>
                    Mes messages
                </div><h3>
                <div class="icon-button">
                    <img src="/images/envelope-regular.svg" style="float:left" >
                </div>
            </button>
        </div>
        <div class="col espace-bottom">
            <button type="button" class="button-icon" autofocus>
                <div><h3>
                    Mes infos
                </div><h3>
                <div class="icon-button">
                    <img src="/images/eye-solid.svg" style="float:left" >
                </div>
            </button>
        </div>
    <!--</div>
    <div class="row">-->
        <div class="col espace-bottom" >
            <button type="button" class="button-icon" autofocus>
                <div><h3>
                        Trajets disponibles
                </div></h3>
                <div class="icon-button">
                    <img src="/images/itineraire.svg" style="float:left" >
                </div>
            </button>
        </div>
        <div class="col espace-bottom">
            <button type="button" class="button-icon" autofocus>
                <div><h3>
                        Données techniques
                </div><h3>
                <div class="icon-button">
                    <img src="/images/microchip-solid.svg" style="float:left" >
                </div>
            </button>
        </div>
        <div class="col espace-bottom">
            <button type="button" class="button-icon" autofocus>
                <div><h3>
                        Mes trajets en cours
                </div><h3> 
                <div class="icon-button">
                    <img src="/images/car-side-solid.svg" style="float:left" >
                </div>
            </button>
        </div>
        <div class="col espace-bottom">
            <button type="button" class="button-icon" autofocus>
                <div><h3>
                        Proposer un trajet
                </div><h3>
                <div class="icon-button">
                    <img src="/images/plus-solid.svg" style="float:left" width="30%" height="30%">
                    <img src="/images/itineraire.svg" style="float:left" width="80%" height="80%">
                </div>
            </button>
        </div>
        <div class="col espace-bottom">
            <button type="button" class="button-icon" autofocus>
                <div><h3>
                        reservation en cours
                </div><h3>
                <div class="icon-button">
                    <img src="/images/spinner-solid.svg" style="float:left" >
                </div>
            </button>
        </div>
    </div>
</div>

@endsection
