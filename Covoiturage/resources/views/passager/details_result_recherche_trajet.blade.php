@extends('base')

@section('title')
Détails trajet
@endsection

@section('style')
    <link rel="stylesheet" href="/css/style.css">
@endsection
           
@section('navbarSequel')
    @if(session()->has('user'))
        <div class="pmd-user-info "> 
                <div class="dropdown">
                    <button data-toggle="dropdown" class="dropdown-toggle" type="button" style="background-color: rgb(51, 63, 80); border: 1px solid rgb(51, 63, 80);"><img class="avatar-img rounded-circle" src="/images/avatar_photo.jpg" width="73" height="73" alt="avatar"></button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <li class="sous-menu"><a tabindex="-1">{{session()->get('user')['prenom']}} {{session()->get('user')['nom']}}</a></li>
                            <hr>
                            <li><a tabindex="-1" class="dropdown-item sous-menu" href="{{route('user', ['idUtilisateur' => session()->get('user')['id']])}}">Mon Profil</a></li>
                            <form method="POST" action="{{route('logout.post')}}">@csrf<button class="dropdown-item nav-link" type="submit">Déconnexion</button></form>
                            
                        </div> 
                </div>
        </div>
    @endif
@endsection

@section('content')
<h1 class="center-title">Détails du trajet</h1>

<div class="border border-dark margin-bottom-accueil">
    <div class="row ml-5 mt-3">
        <div class="v-list-item__title">
            <div class=" text-h6">
            {{ date('H:i',strtotime($unTrajet['dateHeureDepart'])) }}
            </div>
            <div class="text-body-2">
            {{ strftime('%a %d %b',strtotime($unTrajet['dateHeureDepart'])) }}
            {{ date('Y',strtotime($unTrajet['dateHeureDepart'])) }} 
            </div>
        </div>
        <!-- trajet -->
        <div class="col-md-9 detail-trajet ml-5" id="detail-trajet">
            <div class="row">
                <div class="col-md-5 text-center lieu-depart">
                    <span>{{$unTrajet['numRueDep']}} {{$unTrajet['adresseRueDep']}} {{ ucfirst(strtolower($unTrajet['villeDep'])) }}</span>
                </div>
                <div class="col-md-2 pl-2 temps-image">
                    <!-- photo de destination -->
                    <img src="/images/trajet_bleu.png" width="74" height="17" alt="" />
                    <div class="font-weight-bold ml-2">
                        <span>{{ date('i',strtotime($unTrajet['dateHeureArrivee'])) - date('i',strtotime($unTrajet['dateHeureDepart'])) }} min</span>
                    </div>
                </div>
                <div class="col-md-5 text-center lieu-arrive">
                    <span>{{$unTrajet['numRueArr']}} {{$unTrajet['adresseRueArr']}} {{ ucfirst(strtolower($unTrajet['villeArr'])) }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="h-divider ml-5"></div>

    <div class="row">
        <div class="col-md-10">
            <label class="col-md-3 ml-5">Montant à payer </label>
            <span class="col-md-9 text-h6 ml-5">{{ $unTrajet['prixTrajet'] }} €</span>
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
                <label class="col-md-4 ml-5">{{ ucfirst(strtolower($unProfil['prenom'])) }} {{ ucfirst(strtolower($unProfil['nom'])) }} </label>
                @if(!empty($uneNote))
                <span class="col-md-4 text-h6 ml-5"><i class="fa fa-star" style="color: #ffe400"></i><!--<img src="{{URL::asset('images/starNotation.GIF')}}" class="starTrajetImg">--> {{ round(floatval($uneNote['notation']), 1) }}</span>
                @endif
            </div>
        </div>

        <div class="row">
            <div class="col-md-7">
                <label class="col-md-4 ml-5">
                @if($unProfil['animal']==1)
                <br>J'accepte le fait qu'on amène un animal.   
                @endif
                @if($unProfil['fumer']==1)
                <br>J'accepte le fait qu'on fume dans la voiture.  
                @endif
                @if($unProfil['animal']==0)
                <br>Je n'accepte pas les animaux.    
                @endif
                @if($unProfil['fumer']==0)
                <br>Je n'accepte pas qu'on fume dans la voiture.  
                @endif
                </label>
            </div>
            <div class="col-md-4 ml-5 photo-conducteur">
                <a href="#" class="nav-user-img ml-5">
                    <img class="avatar-img rounded-circle" src="/images/photoVoiture.jpg" width="73" height="73" alt="avatar">
                </a>
            </div>
        </div>
        
        <div class="h-divider ml-5"></div>

        @if(!empty($passagers))
        <!-- Ligne des passagers -->
        <h3 class="center-title">Passagers</h3>
        @foreach ($passagers as $passager)
        <div class="row mb-3 mt-2 ml-5">
            <div class="pmd-user-info col-md-5 user-info" style="margin-left: 13%;">
                <!-- photo et le nom de passager-->
                <a href="#" class="nav-user-img" >   
                    <img class="avatar-img rounded-circle mr-3" src="/images/avatar_photo.jpg" width="73" height="73" alt="avatar">
                </a>
                <span class="text-h6 ml-5">{{ ucfirst(strtolower($passager['prenom'])) }} {{ ucfirst(strtolower($passager['nom'])) }}</span>
            </div>
        </div> 
        @endforeach
        @endif
    </div>
    <div class="col-md-4 mt-2">
        <form method="POST" action="{{route('reservation')}}">
            @csrf
            <div style="display: none;">
                <input type="datetime-local" name="dateHeureRDV" id="dateHeureRDV" value='{{date("Y-m-d\TH:i:s", strtotime($unTrajet["dateHeureDepart"]))}}'>
                <input type="number" name="prixResa" id="prixResa" 
                value="{{ $unTrajet['prixTrajet'] }}">
                <input type="number" name="idLieuRencontre" id="idLieuRencontre" 
                value="{{ $unTrajet['idLieuDepart'] }}">
                <input type="number" name="idLieuDepot" id="idLieuDepot" 
                value="{{ $unTrajet['idLieuArrivee'] }}">
                <input type="number" name="idTrajet" id="idTrajet" 
                value="{{ $unTrajet['idTrajet'] }}">
            </div>
            <button type="submit" class="btn button-form ml-5">
                Reserver
            </button>
        </form>
    </div>
</div>
@endsection