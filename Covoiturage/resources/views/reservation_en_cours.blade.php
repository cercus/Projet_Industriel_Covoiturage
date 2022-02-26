@extends('base')

@section('title')
    Mes réservations en cours
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
    <h1 class="center-title">
        <Strong>Mes réservations en cours</Strong>
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
            <div class="col-md-9 detail-trajet ml-5" id="detail-trajet">
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
        </div>

        <!-- séparateur -->
        <div class="h-divider ml-5"></div>

        <!-- la ligne du conducteur -->
        <div class="passager-reserv">
            <div class="row">
                <div class="col-md-7">
                    <label class="col-md-4 ml-5">conducteur : </label>
                    <span class="col-md-4 text-h6 ml-5">Nicolas DUFOUR</span>    
                </div>
                <div class="col-md-4 ml-5 photo-conducteur">
                    <a href="#" class="nav-user-img ml-5">   
                        <img class="avatar-img rounded-circle" src="/images/avatar_photo.jpg" width="73" height="73" alt="avatar">
                    </a>    
                </div>
            </div>
            <!-- la ligne du montant -->
            <div class="row">
                <div class="col-md-10">
                    <label class="col-md-3 ml-5">Montant à payer</label>
                    <span class="col-md-9 text-h6 ml-5">5€</span> 
                </div>   
            </div>

            <!-- la ligne d'etat de reservation -->
            <div class="row mt-3">
                <div class="col-md-10">
                    <label class="col-md-3 ml-5">Etat de réservation</label>
                    <span class="col-md-9 text-h6 ml-5 text-success">En attente d'acceptation par le conducteur</span> 
                </div>   
            </div>

            <!-- la ligne des buttons -->
            <div class="row mt-3 btn-payer-annuler">
                <div class="col-md-3" ></div>
                <div class="col-md-3 btn-payer">
                    <button type="submit" heigth="40" class="btn ml-5 btn-success shadow rounded-lg">Payer !</button>
                </div>
                <div class="col-md-4 mb-3 btn-annuler">
                    <button type="submit" class="btn btn-danger shadow rounded-lg">Annuler la réservation</button>
                </div>
                
            </div>
        </div>
    </div>

@endsection