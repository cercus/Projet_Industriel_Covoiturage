@extends('base')

@section('title')
Rechercher un trajet
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
                            <input type="text" placeholder="3" class="input-form @error('numRueDep') is-invalid @enderror" id="numRueDep" name="numRueDep" aria-describedby="numRueDepError" value="{{ $trajet['numRueDep'] }}">
                            @error('numRueDep')
                                <small id="numRueDepError" class="form-text text-muted">{{$message}}</small>
                            @enderror
                        </div>
                        <div class="col-left-input">
                            <label for="adresseRueDep">Nom de la voie</label>
                            <input type="text" placeholder="Boulevard Baille"  class="input-form @error('adresseRueDep') is-invalid @enderror" id="adresseRueDep" name="adresseRueDep" aria-describedby="adresseRueDepError" value="{{ $trajet['adresseRueDep'] }}">
                            @error('adresseRueDep')
                                <small id="adresseRueDepError" class="form-text text-muted">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-10 mx-auto space-bottom-title" style="padding-bottom: 20px;">
                        <div class="col-right-input">
                            <label for="cpDep">Code postal</label>
                            <input type="number" placeholder="13010" class="input-form @error('cpDep') is-invalid @enderror" id="cpDep" name="cpDep" aria-describedby="cpDepError" value="{{ $trajet['cpDep'] }}">
                            @error('cpDep')
                                <small id="cpDepError" class="form-text text-muted">{{$message}}</small>
                            @enderror
                        </div>
                        <div class="col-left-input">
                            <label for="villeDep">Ville</label>
                            <input type="text" placeholder="Marseille"  class="input-form @error('villeDep') is-invalid @enderror" id="villeDep" name="villeDep" aria-describedby="villeDepError" value="{{ $trajet['villeDep'] }}">
                            @error('rueDep')
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
                            <input type="text" placeholder="170" class="input-form @error('numRueArr') is-invalid @enderror" id="numRueArr" name="numRueArr" aria-describedby="numRueArrError" value="{{ $trajet['numRueArr'] }}">>
                            @error('numRueArr')
                                <small id="numRueArrError" class="form-text text-muted">{{$message}}</small>
                            @enderror
                        </div>
                        <div class="col-left-input">
                            <label for="adresseRueArr">Nom de la voie</label>
                            <input type="text" placeholder="Avenue de Luminy"  class="input-form @error('adresseRueArr') is-invalid @enderror" id="adresseRueArr" name="adresseRueArr" aria-describedby="adresseRueArrError" value="{{ $trajet['adresseRueArr'] }}">
                            @error('adresseRueArr')
                                <small id="adresseRueArrError" class="form-text text-muted">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-10 mx-auto space-bottom-title" style="padding-bottom: 20px;">
                        <div class="col-right-input">
                            <label for="cpArr">Code postal</label>
                            <input type="number" placeholder="13009" class="input-form @error('cpArr') is-invalid @enderror" id="cpArr" name="cpArr" aria-describedby="cpArrError" value="{{ $trajet['cpArr'] }}">
                            @error('cpArr')
                                <small id="cpArrError" class="form-text text-muted">{{$message}}</small>
                            @enderror
                        </div>
                        <div class="col-left-input">
                            <label for="villeArr">Ville</label>
                            <input type="text" placeholder="Marseille"  class="input-form @error('villeArr') is-invalid @enderror" id="villeArr" name="villeArr" aria-describedby="villeArrError" value="{{ $trajet['villeArr'] }}">
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
                            <input type="number" placeholder="1"  class="input-form @error('nbPlace') is-invalid @enderror" id="nbPlace" name="nbPlace" aria-describedby="nbPlaceError" value="{{ $trajet['nbPlace'] }}">
                            @error('nbPlace')
                                <small id="nbPlaceError" class="form-text text-muted">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                    
                </div>
            </div>

        </div>
    </form>
</div>


<h2 class="center-title space-bottom-title">Les trajets associés</h2>
<div>
    @foreach ($trajetsProposes as $trajetProposes)
    <!-- div global -->
    <div class="border border-dark margin-trajetsBest">
        <div class="row ml-5 mt-3">
            <div class="v-list-item__title">
                <div class=" text-h6">{{ $trajetProposes['dateHeureDepart'] }}</div> 
                <div class="text-body-2">
                {{ $trajetProposes['dateHeureDepart'] }}
                </div>
            </div>
            
            <!-- trajet -->
            <div class="col-md-7 detail-trajet">
                <div class="row">
                    <div class="col-md-5 text-center lieu-depart">
                        <span>{{ $trajetProposes['villeDep'] }}</span>
                    </div> 
                    <div class="col-md-2 pl-2 temps-image">
                        <!-- photo de destination -->
                        <img src="/images/trajet_bleu.png" width="74" height="17" alt=""/>
                        <div class="font-weight-bold ml-2">
                            <span>{{ $trajetProposes['min'] }} min</span>
                        </div>
                    </div> 
                    <div class="col-md-5 text-center lieu-arrive">
                        <span>{{ $trajetProposes['villeArr'] }}</span>
                    </div>
                </div>
            </div>

            <!-- nbr de place -->
            <div class="col-md-2 places-dispo">
            {{ $trajetProposes['nbPlace'] }} Place.s
            </div>

            <!-- prix -->
            <div class="col-md-1 prix">
            {{ $trajetProposes['prixTrajet'] }} €
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
                <span class="text-h6">D. Nicolas</span>
            </div>
            <!-- button plus détails -->
            <div class="col-md-4 mt-2">
                <a href="{{route('details_result_recherche_trajet')}}"><button class="btn button-form ml-5">PLUS DÉTAILS</button></a>
            </div>
        </div> 
    </div>
    &nbsp
    @endforeach
</div>


@endsection