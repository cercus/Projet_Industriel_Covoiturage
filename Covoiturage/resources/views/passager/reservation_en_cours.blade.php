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
            <a class="nav-link" href="{{route('user')}}">{{session()->get('user')['prenom']}} {{session()->get('user')['nom']}}</a>
        </li>
    </ul>
    <div class="pmd-user-info ">
        <a href="javascript:void(0);" class="nav-user-img" >
            {{-- @if ({{session()->get('user')['photoProfil']}} == null) --}}
                <img class="avatar-img rounded-circle" src="/images/avatar_photo.jpg" width="73" height="73" alt="avatar">
            {{-- @else
                <img class="avatar-img rounded-circle" src="/images/avatar_photo.jpg" width="73" height="73" alt="avatar">
            @endif   --}}
        </a>
    </div>
@endsection

@section('content')
    <h1 class="center-title">
        <Strong>Mes réservations en cours</Strong>
    </h1><br>
    <!-- div global -->
    @if (count($reservationsEnCours) == 0)
        <div class="border border-dark">
            <h4 class= "text-center mb-4 mt-3 font-weight-bold text-danger">Vous n'avez aucune réservation</h4>
        </div>
    @endif
    @for ($pos = 0; $pos < count($reservationsEnCours); $pos++)
    <div class="border border-dark">
        <div class="row ml-5 mt-3">
            <div class="v-list-item__title">
                <div class=" text-h6">
                    {{date('H\\hi', strtotime($reservationsEnCours[$pos]->dateHeureDepart))}}
                </div> 
                <div class="text-body-2">
                    {{$tabDateFrenche[$pos]}}
                </div>
            </div>
            
            <!-- trajet -->
            <div class="col-md-9 detail-trajet ml-5" id="detail-trajet">
                <div class="row">
                    
                    <div class="col-md-5 text-center lieu-depart">
                        <span>{{$reservationsEnCours[$pos]->numRueDep}} {{$reservationsEnCours[$pos]->rueDep}} {{$reservationsEnCours[$pos]->numRueDep}}, {{$reservationsEnCours[$pos]->cpDep}} {{$reservationsEnCours[$pos]->villeDep}}</span>
                    </div> 
                    <div class="col-md-2 pl-2 temps-image">
                        <!-- photo de destination -->
                        <img src="/images/trajet_bleu.png" width="74" height="17" alt=""/>
                        <div class="font-weight-bold ml-2">
                            <span>{{$tableTime[$pos]}}min</span>
                        </div>
                    </div> 
                    <div class="col-md-5 text-center lieu-arrive">
                        <span>{{$reservationsEnCours[$pos]->numRueArr}} {{$reservationsEnCours[$pos]->rueArr}} {{$reservationsEnCours[$pos]->numRueArr}}, {{$reservationsEnCours[$pos]->cpArr}} {{$reservationsEnCours[$pos]->villeArr}}</span>
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
                    <span class="col-md-4 text-h6 ml-5">{{$conducteurs[$pos][0]->prenomCond}} {{$conducteurs[$pos][0]->nomCond}}</span>    
                </div>
                <div class="col-md-4 ml-5 photo-conducteur">
                    <div class="nav-user-img ml-5">
                        @if ($conducteurs[$pos][0]->photoProfil == null)
                            <img class="avatar-img rounded-circle" src="/images/avatar_photo.jpg" width="73" height="73" alt="avatar">
                        @else
                            <img class="avatar-img rounded-circle" src="{{$conducteurs[$pos][0]->photoProfil}}" width="73" height="73" alt="avatar">
                        @endif   
                    </div>    
                </div>
            </div>
            <!-- la ligne du montant -->
            <div class="row">
                <div class="col-md-10">
                    <label class="col-md-3 ml-5">Montant à payer</label>
                    <span class="col-md-9 text-h6 ml-5">{{$reservationsEnCours[$pos]->prixResa}}€</span> 
                </div>   
            </div>
            <!-- la ligne d'etat de reservation -->
            <div class="row mt-3">
                <div class="col-md-10">
                    <label class="col-md-3 ml-5">Etat de réservation</label>
                    @if ($reservationsEnCours[$pos]->estAccepte == 0)
                        <span class="col-md-9 text-h6 ml-5 text-danger">En attente d'acceptation par le conducteur</span>
                    @else
                        <span class="col-md-9 text-h6 ml-5 text-success">Votre réservation a été acceptée par le conducteur</span>
                    @endif
                     
                </div>   
            </div>

            <!-- la ligne des buttons -->
            <div class="row mt-3 btn-payer-annuler">
                <div class="col-md-3" ></div>
                <div class="col-md-3 btn-payer">
                    @if ($reservationsEnCours[$pos]->estPaye == 0)
                        <button type="submit" heigth="40" class="btn ml-5 btn-success shadow rounded-lg">Payer !</button>
                    @else
                        <button type="submit" heigth="40" class="btn ml-5 btn-success shadow rounded-lg" disabled>Payer !</button>
                    @endif
                </div>
                <div class="col-md-4 mb-3 btn-annuler">
                    <button type="submit" class="btn btn-danger shadow rounded-lg">Annuler la réservation</button>
                </div>
            </div>
        </div>
    </div><br>
    @endfor
@endsection