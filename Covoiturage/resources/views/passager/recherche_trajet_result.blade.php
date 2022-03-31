@extends('base')

@section('title')
Rechercher un trajet
@endsection

@section('style')
    <link rel="stylesheet" href="/css/style.css">
@endsection
           
@section('navbarSequel')
    @if(session()->has('user'))
        <div class="pmd-user-info "> 
                <div class="dropdown">
                    <button data-toggle="dropdown" class="dropdown-toggle" type="button" style="background-color: rgb(51, 63, 80); border: 1px solid rgb(51, 63, 80);"><img class="avatar-img rounded-circle" src="/images/avatar_photo.jpg" width="73" height="73" alt="avatar"></button>
                        <div class="dropdown-menu">
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

<h2 class="center-title" style="padding-bottom: 20px;">Avec Columiny, aller à luminy n'a jamais été aussi simple...</h2>

<div>
    <form>
        @csrf
        @if ($errors->any())
            <div class="alert alert-warning">
                La recherche n'a pas pu etre effectuée &#9785;
            </div>
        @endif
        <div>
            
            <div class="col-right-input-accueil">
                <div class="border border-dark">
                <h2 class="center-title">Départ</h2>
                
                    <div class="col-md-10 mx-auto space-bottom-title">
                        <div class="col-right-input">
                            <label for="numRueDep">Numero de rue</label>
                            <input type="text" class="input-form @error('numRueDep') is-invalid @enderror" id="numRueDep" name="numRueDep" aria-describedby="numRueDepError" value="{{ $trajet['numRueDep'] }}">
                            @error('numRueDep')
                                <small id="numRueDepError" class="form-text text-muted">{{$message}}</small>
                            @enderror
                        </div>
                        <div class="col-left-input">
                            <label for="adresseRueDep">Nom de la voie</label>
                            <input type="text" class="input-form @error('adresseRueDep') is-invalid @enderror" id="adresseRueDep" name="adresseRueDep" aria-describedby="adresseRueDepError" value="{{ $trajet['adresseRueDep'] }}">
                            @error('adresseRueDep')
                                <small id="adresseRueDepError" class="form-text text-muted">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-10 mx-auto space-bottom-title" style="padding-bottom: 20px;">
                        <div class="col-right-input">
                            <label for="cpDep">Code postal</label>
                            <input type="number" class="input-form @error('cpDep') is-invalid @enderror" id="cpDep" name="cpDep" aria-describedby="cpDepError" value="{{ $trajet['cpDep'] }}">
                            @error('cpDep')
                                <small id="cpDepError" class="form-text text-muted">{{$message}}</small>
                            @enderror
                        </div>
                        <div class="col-left-input">
                            <label for="villeDep">Ville</label>
                            <input type="text" class="input-form @error('villeDep') is-invalid @enderror" id="villeDep" name="villeDep" aria-describedby="villeDepError" value="{{ $trajet['villeDep'] }}">
                            @error('villeDep')
                                <small id="villeDepError" class="form-text text-muted">{{$message}}</small>
                            @enderror
                        </div>
                    </div>    
                </div>
            </div>

            <div class="col-left-input-accueil">
                <div class="border border-dark">
                <h2 class="center-title">Arrivé</h2>
                    <div class="col-md-10 mx-auto space-bottom-title">
                        <div class="col-right-input">
                            <label for="numRueArr">Numero de rue</label>
                            <input type="text" class="input-form @error('numRueArr') is-invalid @enderror" id="numRueArr" name="numRueArr" aria-describedby="numRueArrError" value="{{ $trajet['numRueArr'] }}">
                            @error('numRueArr')
                                <small id="numRueArrError" class="form-text text-muted">{{$message}}</small>
                            @enderror
                        </div>
                        <div class="col-left-input">
                            <label for="adresseRueArr">Nom de la voie</label>
                            <input type="text" class="input-form @error('adresseRueArr') is-invalid @enderror" id="adresseRueArr" name="adresseRueArr" aria-describedby="adresseRueArrError" value="{{ $trajet['adresseRueArr'] }}">
                            @error('adresseRueArr')
                                <small id="adresseRueArrError" class="form-text text-muted">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-10 mx-auto space-bottom-title" style="padding-bottom: 20px;">
                        <div class="col-right-input">
                            <label for="cpArr">Code postal</label>
                            <input type="number" class="input-form @error('cpArr') is-invalid @enderror" id="cpArr" name="cpArr" aria-describedby="cpArrError" value="{{ $trajet['cpArr'] }}">
                            @error('cpArr')
                                <small id="cpArrError" class="form-text text-muted">{{$message}}</small>
                            @enderror
                        </div>
                        <div class="col-left-input">
                            <label for="villeArr">Ville</label>
                            <input type="text" class="input-form @error('villeArr') is-invalid @enderror" id="villeArr" name="villeArr" aria-describedby="villeArrError" value="{{ $trajet['villeArr'] }}">
                            @error('villeArr')
                                <small id="villeArrError" class="form-text text-muted">{{$message}}</small>
                            @enderror
                        </div>
                    </div>    
                </div>
            </div>
        </div>

        <div>
            <div class="col-right-input-accueil">
                <div style="padding-bottom: 20px;">
                
                    <div class="col-md-10 mx-auto space-bottom-title">
                        <div class="col-right-input">
                            <label for="dateDep">Date de départ</label>
                            <input type="datetime-local" class="input-form @error('dateDep') is-invalid @enderror" id="dateDep" name="dateDep" aria-describedby="dateDepError" value="{{ $trajet['dateDep'] }}">
                            @error('dateDep')
                                <small id="dateDepError" class="form-text text-muted">{{$message}}</small>
                            @enderror
                        </div>
                        <div class="col-left-input">
                            <label for="nbPlace">Nombre de place(s)</label>
                            <input type="number" class="input-form @error('nbPlace') is-invalid @enderror" id="nbPlace" name="nbPlace" aria-describedby="nbPlaceError" value="{{ $trajet['nbPlace'] }}">
                            @error('nbPlace')
                                <small id="nbPlaceError" class="form-text text-muted">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                    
                </div>
            </div>

        </div>
    </form>
    <br>
    <br>
    <div class="col-md-4 mt-2">
    <a href="{{ route('recherche_trajet') }}"><button class="btn button-form ml-5">Faire une autre recherche</button></a>
    </div>
</div>

@if(empty($trajetsProposes))
<h2 class="center-title space-bottom-title">
    
    <br>
    Désolé, aucun trajet proposé ne correspond à votre recherche &#9785;
    <br>
    <br>
</h2>
@if(!empty($bestTrajets))
<h2 class="center-title space-bottom-title">Les trajets aux meilleurs prix aujourd'hui</h2>
<div>
    @foreach ($bestTrajets as $bestTrajet)
    <!-- div global -->
    <div class="border border-dark margin-trajetsBest">
        <div class="row ml-5 mt-3">
            <div class="v-list-item__title">
                <div class=" text-h6">{{ date('H:i',strtotime($bestTrajet['dateHeureDepart'])) }}</div> 
                <div class="text-body-2">
                {{ strftime('%a %d %b',strtotime($bestTrajet['dateHeureDepart'])) }} 
                {{ date('Y',strtotime($bestTrajet['dateHeureDepart'])) }} 
                </div>
            </div>
            
            <!-- trajet -->
            <div class="col-md-7 detail-trajet">
                <div class="row">
                    <div class="col-md-5 text-center lieu-depart">
                        <span>{{$bestTrajet['numRueDep']}} {{$bestTrajet['adresseRueDep']}} {{ ucfirst(strtolower($bestTrajet['villeDep'])) }}</span>
                    </div> 
                    <div class="col-md-2 pl-2 temps-image">
                        <!-- photo de destination -->
                        <img src="/images/trajet_bleu.png" width="74" height="17" alt=""/>
                        <div class="font-weight-bold ml-2">
                            <span> {{ date('i',strtotime($bestTrajet['dateHeureArrivee'])) - date('i',strtotime($bestTrajet['dateHeureDepart'])) }} min</span>
                        </div>
                    </div> 
                    <div class="col-md-5 text-center lieu-arrive">
                        <span>{{$bestTrajet['numRueArr']}} {{$bestTrajet['adresseRueArr']}} {{ ucfirst(strtolower($bestTrajet['villeArr'])) }}</span>
                    </div>
                </div>
            </div>

            <!-- nbr de place -->
            <div class="col-md-2 places-dispo">
            {{ $bestTrajet['nbPlace'] }} Place.s
            </div>

            <!-- prix -->
            <div class="col-md-1 prix">
            {{ $bestTrajet['prixTrajet'] }} €
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
                <span class="text-h6"> {{ ucfirst(strtolower($bestTrajet['prenom'])) }} {{ ucfirst(strtolower($bestTrajet['nom'])) }} </span>
            </div>
            <!-- button plus détails -->
            <div class="col-md-4 mt-2">
            <a href="{{route('detailsResultRechercheTrajet', ['trajetId'=>$bestTrajet['idTrajet']])}}"><button class="btn button-form ml-5">PLUS DÉTAILS</button></a>
            </div>
        </div> 
    </div>
    &nbsp
@endforeach
</div>
@endif


@else
<h2 class="center-title space-bottom-title">Les trajets associés</h2>
<div>
    @foreach ($trajetsProposes as $trajetPropose)
    <!-- div global -->
    <div class="border border-dark margin-trajetsBest">
        <div class="row ml-5 mt-3">
            <div class="v-list-item__title">
                <div class=" text-h6">{{ date('H:i',strtotime($trajetPropose['dateHeureDepart'])) }}</div> 
                <div class="text-body-2">
                {{ strftime('%a %d %b',strtotime($trajetPropose['dateHeureDepart'])) }}
                {{ date('Y',strtotime($trajetPropose['dateHeureDepart'])) }} 
                </div>
            </div>
            
            <!-- trajet -->
            <div class="col-md-7 detail-trajet">
                <div class="row">
                    <div class="col-md-5 text-center lieu-depart">
                        <span> {{$trajetPropose['numRueDep']}} {{$trajetPropose['adresseRueDep']}} {{ ucfirst(strtolower($trajetPropose['villeDep'])) }}</span>
                    </div> 
                    <div class="col-md-2 pl-2 temps-image">
                        <!-- photo de destination -->
                        <img src="/images/trajet_bleu.png" width="74" height="17" alt=""/>
                        <div class="font-weight-bold ml-2">
                            <span>{{ date('i',strtotime($trajetPropose['dateHeureArrivee'])) - date('i',strtotime($trajetPropose['dateHeureDepart'])) }} min</span>
                        </div>
                    </div> 
                    <div class="col-md-5 text-center lieu-arrive">
                        <span> {{$trajetPropose['numRueArr']}} {{$trajetPropose['adresseRueArr']}} {{ ucfirst(strtolower($trajetPropose['villeArr'])) }}</span>
                    </div>
                </div>
            </div>

            <!-- nbr de place -->
            <div class="col-md-2 places-dispo">
            {{ $trajetPropose['nbPlace'] }} Place.s
            </div>

            <!-- prix -->
            <div class="col-md-1 prix">
            {{ $trajetPropose['prixTrajet'] }} €
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
                <span class="text-h6">{{ ucfirst(strtolower($trajetPropose['prenom'])) }} {{ ucfirst(strtolower($trajetPropose['nom'])) }}</span>
            </div>
            <!-- button plus détails -->
            <div class="col-md-4 mt-2">
                <a href="{{route('detailsResultRechercheTrajet', ['trajetId'=>$trajetPropose['idTrajet']])}}"><button class="btn button-form ml-5">PLUS DÉTAILS</button></a>
            </div>
        </div> 
    </div>
    &nbsp
    @endforeach
</div>
@endif


@endsection