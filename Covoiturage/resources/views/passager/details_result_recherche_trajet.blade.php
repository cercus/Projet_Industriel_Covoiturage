@extends('base')

@section('title')
Détails trajet
@endsection

@section('style')
<link rel="stylesheet" href="/css/style.css">
@endsection

@section('navbarSequel')
<ul class="navbar-nav mr-auto">
    <li class="nav-item">
        <a class="nav-link" href="{{route('inscription')}}">Inscription</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{route('connexion')}}">Connexion</a>
    </li>
</ul>
@endsection

@section('content')
<h1 class="center-title">Détails du trajet</h1>


<div class="border border-dark margin-bottom-accueil">
    <div class="row ml-5 mt-3">
        <div class="v-list-item__title">
            <div class=" text-h6">
                7h30
            </div>
            <div class="text-body-2">
                Jeu 24/02
            </div>
        </div>
        <!-- trajet -->
        <div class="col-md-9 detail-trajet ml-5" id="detail-trajet">
            <div class="row">
                <div class="col-md-5 text-center lieu-depart">
                    <span>Marseille</span>
                </div>
                <div class="col-md-2 pl-2 temps-image">
                    <!-- photo de destination -->
                    <img src="/images/trajet_bleu.png" width="74" height="17" alt="" />
                    <div class="font-weight-bold ml-2">
                        <span>30 min</span>
                    </div>
                </div>
                <div class="col-md-5 text-center lieu-arrive">
                    <span>Luminy</span>
                </div>
            </div>
        </div>
    </div>

    <div class="h-divider ml-5"></div>

    <div class="row">
        <div class="col-md-10">
            <label class="col-md-3 ml-5">Montant à payer </label>
            <span class="col-md-9 text-h6 ml-5">5€</span>
        </div>
    </div>

    <div class="h-divider ml-5"></div>


    <!-- la ligne du conducteur -->
    <div class="passager-reserv">
        <div class="row">
            <div class="col-md-4 ml-5 photo-conducteur">
                <a href="#" class="nav-user-img ml-5">
                    <img class="avatar-img rounded-circle" src="/images/avatar_photo.jpg" width="73" height="73" alt="avatar">
                </a>
            </div>
            <div class="col-md-7">
                <label class="col-md-4 ml-5">D. Nicolas </label>
                <span class="col-md-4 text-h6 ml-5"><img src="{{URL::asset('images/starNotation.GIF')}}" class="starTrajetImg"> 4/5</span>
            </div>
        </div>

        <div class="row">
            <div class="col-md-7">
                <label class="col-md-4 ml-5">Commentaire </label>
            </div>
            <div class="col-md-4 ml-5 photo-conducteur">
                <a href="#" class="nav-user-img ml-5">
                    <img class="avatar-img rounded-circle" src="/images/photoVoiture.GIF" width="73" height="73" alt="avatar">
                </a>
            </div>
        </div>

        <div class="h-divider ml-5"></div>

        <!-- Ligne des passagers -->
        <h3 class="center-title">Passagers</h3>
        <div class="row mb-3 mt-2 ml-5">
            <div class="pmd-user-info col-md-5 user-info" style="margin-left: 13%;">
                <!-- photo et le nom de passager-->
                <a href="#" class="nav-user-img" >   
                    <img class="avatar-img rounded-circle mr-3" src="/images/avatar_photo.jpg" width="73" height="73" alt="avatar">
                </a>
                <span class="text-h6 ml-5">Ismail IDBOURHIM</span>
            </div>
        </div>

        <div class="row mb-3 mt-2 ml-5">
            <div class="pmd-user-info col-md-5 user-info" style="margin-left: 13%;">
                <!-- photo et le nom de passager-->
                <a href="#" class="nav-user-img" >   
                    <img class="avatar-img rounded-circle mr-3" src="/images/avatar_photo.jpg" width="73" height="73" alt="avatar">
                </a>
                <span class="text-h6 ml-5">Nicolas Dufour</span>
            </div>
        </div>
    </div>
</div>
@endsection