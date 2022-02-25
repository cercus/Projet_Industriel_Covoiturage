@extends('base')

@section('title')
    Recherche de trajet
@endsection

@section('style')
    <link rel="stylesheet" href="/css/style.css">
@endsection

@section('navbarSequel')
    @if (session()->has('user'))
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
    @else
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="/inscription">Inscription</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/connexion">Connexion</a>
            </li>
        </ul>
    @endif
@endsection

@section('content')
    <h1 class="center-title">
        <Strong>Recherche de trajet</Strong>
    </h1><br>
    <!-- div global -->
    <div class="border border-dark">
        <div class="row ml-5 mt-3">
            <div class="v-list-item__title">
                <div class=" text-h6">
                    09h39
                </div> 
                <div class="text-body-2">
                    ven. 25/02
                </div>
            </div>
            
            <!-- trajet -->
            <div class="col-md-7 detail-trajet">
                <div class="row">
                    <div class="col-md-5 text-center lieu-depart">
                        <span>9 Rue Prado, 13111 Marseille</span>
                    </div> 
                    <div class="col-md-2 pl-2 temps-image">
                        <!-- photo de destination -->
                        <img src="/images/Picture2.jpg" width="74" height="17" alt=""/>
                        <div class="font-weight-bold ml-2">
                            <span>35min</span>
                        </div>
                    </div> 
                    <div class="col-md-5 text-center lieu-arrive">
                        <span>Faculté des sciences, Luminy</span>
                    </div>
                </div>
            </div>

            <!-- nbr de place -->
            <div class="col-md-2 places-dispo">
                3 Places
            </div>

            <!-- prix -->
            <div class="col-md-1 prix">
                5€       
            </div> 
        </div>

        <!-- séparateur -->
        <div class="h-divider ml-5"></div>
        <!-- conducteur et button -->
        <div class="row mb-3 mt-2 ml-5">
            <div class="pmd-user-info col-md-8">
                <!-- photo -->
                <a href="#" class="nav-user-img" >   
                    <img class="avatar-img rounded-circle mr-3" src="/images/avatar_photo.jpg" width="73" height="73" alt="avatar">
                </a>
                <!-- nom du conducteur -->
                <span class="text-h6">Nicolas DUFOUR</span>
            </div>
            <!-- button plus détails -->
            <div class="col-md-4 mt-2">
                <button type="submit" class="btn button-form ml-5">PLUS DÉTAILS</button>
            </div>
        </div> 
    </div>

@endsection