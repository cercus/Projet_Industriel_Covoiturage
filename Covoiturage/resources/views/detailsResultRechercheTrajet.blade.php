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
            <a class="nav-link" href="#">Inscription</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">Connexion</a>
        </li>
    </ul>
@endsection

@section('content')

<div class="margin-bottom-accueil center-title">
    <h2>Détails du trajet</h2>
</div>

<div class="border border-dark margin-bottom-accueil">
        <div class="row ml-5 mt-3">
            <div class="v-list-item__title">
                <div class=" text-h6">
                {{ $UnTrajet['heure'] }}
                </div> 
                <div class="text-body-2">
                {{ $UnTrajet['jour'] }} {{ $UnTrajet['date'] }}
                </div>
            </div>

            <!-- trajet -->
            <div class="col-md-9 detail-trajet ml-5" id="detail-trajet">
                <div class="row">
                    
                    <div class="col-md-5 text-center lieu-depart">
                        <span>{{ $UnTrajet['villeDep'] }}</span>
                    </div> 
                    <div class="col-md-2 pl-2 temps-image">
                        <!-- photo de destination -->
                        <img src="/images/Picture2.jpg" width="74" height="17" alt=""/>
                        <div class="font-weight-bold ml-2">
                            <span>{{ $UnTrajet['duree'] }} min</span>
                        </div>
                    </div> 
                    <div class="col-md-5 text-center lieu-arrive">
                        <span>{{ $UnTrajet['villeArr'] }}</span>
                    </div>
                </div>
            </div>
        </div>
        <!-- séparateur -->
        <div class="h-divider ml-5"></div>

<!-- la ligne du montant -->
            <div class="row">
                <div class="col-md-10">
                    <label class="col-md-3 ml-5">Montant à payer </label>
                    <span class="col-md-9 text-h6 ml-5">5€</span> 
                </div>   
            </div>

        <!-- séparateur -->
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
                    <label class="col-md-4 ml-5">{{ $UnProfil['nom'] }} {{ $UnProfil['prenom'] }} </label>
                    <span class="col-md-4 text-h6 ml-5"><img src="{{URL::asset('images/starNotation.GIF')}}" class="starTrajetImg"> {{ $UnProfil['notation'] }}/5</span>    
                </div>
                
            </div>
            
            <div class="row">
                <div class="col-md-7">
                    <label class="col-md-4 ml-5">{{ $UnProfil['commentaire'] }} </label>    
                </div>
                <div class="col-md-4 ml-5 photo-conducteur">
                    <a href="#" class="nav-user-img ml-5">   
                        <img class="avatar-img rounded-circle" src="/images/photoVoiture.GIF" width="73" height="73" alt="avatar">
                    </a>    
                </div>
            </div>
            </div>
            </div>



 
<table class="marginTrajet margin-bottom-accueil">
<tr>
<td>
<h3 class="center-title"> Passagers </h3>
 </td>
</tr>
@foreach ($passagers as $passager)
<tr>
<td>
<img src="{{URL::asset('images/avatar_photo.jpg')}}" class="trajetProfilImg">
{{ $passager['nom'] }}
{{ $passager['prenom'] }}
 </td>
</tr>
@endforeach
</table>

<form>
<button class="button-form-details margin-bottom-accueil">Réserver</button>
</form>





@endsection