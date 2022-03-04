@extends('base')

@section('title')
Proposer un trajet
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
<h1 class="center-title">Proposer un trajet</h1>
<div>
    <form method="POST" action="{{route('store.proposer_trajet')}}">
        <div>
            <div class="col-right-input-trajet">
                <div class="border border-dark">
                    <h2 class="center-title">Départ</h2>
                    <div class="col-md-10 mx-auto space-bottom-title">
                        <div class="col-right-input">
                            <label for="numRueDep">Numero de rue</label>
                            <input type="text" placeholder="3" class="input-form @error('numRueDep') is-invalid @enderror" id="numRueDep" name="numRueDep" aria-describedby="numRueDepError">
                            @error('numRueDep')
                            <small id="numRueDepError" class="form-text text-muted">{{$message}}</small>
                            @enderror
                        </div>
                        <div class="col-left-input">
                            <label for="rueDep">Nom de la voie</label>
                            <input type="text" placeholder="Boulevard Baille" class="input-form @error('rueDep') is-invalid @enderror" id="rueDep" name="rueDep" aria-describedby="rueDepError">
                            @error('rueDep')
                            <small id="rueDepError" class="form-text text-muted">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-10 mx-auto space-bottom-title" style="padding-bottom: 20px;">
                        <div class="col-right-input">
                            <label for="cpDep">Code postal</label>
                            <input type="number" placeholder="13010" class="input-form @error('cpDep') is-invalid @enderror" id="cpDep" name="cpDep" aria-describedby="cpDepError">
                            @error('cpDep')
                            <small id="cpDepError" class="form-text text-muted">{{$message}}</small>
                            @enderror
                        </div>
                        <div class="col-left-input">
                            <label for="villeDep">Ville</label>
                            <input type="text" placeholder="Marseille" class="input-form @error('villeDep') is-invalid @enderror" id="villeDep" name="villeDep" aria-describedby="villeDepError">
                            @error('rueDep')
                            <small id="villeDepError" class="form-text text-muted">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="border border-dark" style="margin-top: 20px;">
                    <h2 class="center-title">Destination</h2>
                    <div class="col-md-10 mx-auto space-bottom-title">
                        <div class="col-right-input">
                            <label for="numRueDep">Numero de rue</label>
                            <input type="text" placeholder="3" class="input-form @error('numRueArr') is-invalid @enderror" id="numRueArr" name="numRueArr" aria-describedby="numRueArrError">
                            @error('numRueArr')
                            <small id="numRueArrError" class="form-text text-muted">{{$message}}</small>
                            @enderror
                        </div>
                        <div class="col-left-input">
                            <label for="rueDep">Nom de la voie</label>
                            <input type="text" placeholder="Boulevard Baille" class="input-form @error('rueArr') is-invalid @enderror" id="rueArr" name="rueArr" aria-describedby="rueArrError">
                            @error('rueArr')
                            <small id="rueArrError" class="form-text text-muted">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-10 mx-auto space-bottom-title" style="padding-bottom: 20px;">
                        <div class="col-right-input">
                            <label for="cpArr">Code postal</label>
                            <input type="number" placeholder="13010" class="input-form @error('cpArr') is-invalid @enderror" id="cpArr" name="cpArr" aria-describedby="cpArrError">
                            @error('cpArr')
                            <small id="cpArrError" class="form-text text-muted">{{$message}}</small>
                            @enderror
                        </div>
                        <div class="col-left-input">
                            <label for="villeArr">Ville</label>
                            <input type="text" placeholder="Marseille" class="input-form @error('villeArr') is-invalid @enderror" id="villeArr" name="villeArr" aria-describedby="villeArrError">
                            @error('villeArr')
                            <small id="villeArrError" class="form-text text-muted">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-left-input-trajet">
                <div>
                    <img src="/images/map_example.png" width="100%">
                    <div class="row justify-content-center align-items-center col-button-trajet" style="padding-top: 20px;">

                        <button type="submit" class="btn button-form">Rechercher</button>
                        <button type="submit" class="btn button-form">Voir l'itinéraire</button>


                    </div>

                </div>
            </div>


        </div>

        <div class="col-right-input-accueil">
            <div style="padding-bottom: 20px;">
                <div class="col-md-10 mx-auto space-bottom-title">
                    <div class="col-right-input">
                        <label for="date">Date de départ</label>
                        <input type="datetime-local" class="input-form @error('date') is-invalid @enderror" id="date" name="date" aria-describedby="dateError">
                        @error('date')
                        <small id="dateError" class="form-text text-muted">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="col-left-input">
                        <label for="place">Nombre de place(s)</label>
                        <input type="number" placeholder="1" class="input-form @error('place') is-invalid @enderror" id="place" name="place" aria-describedby="placeError">
                        @error('place')
                        <small id="placeError" class="form-text text-muted">{{$message}}</small>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!--
        <div class="col-left-input-accueil">
            <div style="padding-bottom: 50px;">

                <div class="row justify-content-center align-items-center col-button-trajet" style="padding-top: 40px;">

                    <button type="submit" class="btn button-form">Rechercher</button>
                    <button type="submit" class="btn button-form">Voir l'itinéraire</button>


                </div>
            </div>
        </div>
        -->
        
    </form>
</div>


@endsection