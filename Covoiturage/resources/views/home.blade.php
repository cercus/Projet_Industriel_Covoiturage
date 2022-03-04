@extends('base')

@section('title')
Accueil
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

<div class="margin-bottom-accueil center-title">
    <p>Vous souhaitez etre plus écologique et priopriser le covoiturage ?</p>
    <p>Vous souhaitez vous rendre au campus de luminy où y revenir :
    A l'heure que vous souhaitez ? Sans vous inquiéter de la question des horaires du bus ?
    </p>
    <p>Vous faites des trajets vers luminy dans votre voiture, vous
        avez de la place et vous souhaitez gagner de l'argent ?
    </p>
    <p>Alors Columiny est fait pour vous !</p>
</div>
<div style="position: sticky; top: 0; z-index: 1; position:-webkit-sticky; background-color: rgba(241, 241, 239, 0.6);">
    <form method="POST" action="">
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
                            <input type="text" placeholder="3" class="input-form @error('numRueDep') is-invalid @enderror" id="numRueDep" name="numRueDep" aria-describedby="numRueDepError">
                            @error('numRueDep')
                                <small id="numRueDepError" class="form-text text-muted">{{$message}}</small>
                            @enderror
                        </div>
                        <div class="col-left-input">
                            <label for="rueDep">Nom de la voie</label>
                            <input type="text" placeholder="Boulevard Baille"  class="input-form @error('rueDep') is-invalid @enderror" id="rueDep" name="rueDep" aria-describedby="rueDepError">
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
                            <input type="text" placeholder="Marseille"  class="input-form @error('villeDep') is-invalid @enderror" id="villeDep" name="villeDep" aria-describedby="villeDepError">
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
                            <input type="text" placeholder="170" class="input-form @error('numRueArr') is-invalid @enderror" id="numRueArr" name="numRueArr" aria-describedby="numRueArrError">
                            @error('numRueArr')
                                <small id="numRueArrError" class="form-text text-muted">{{$message}}</small>
                            @enderror
                        </div>
                        <div class="col-left-input">
                            <label for="rueArr">Nom de la voie</label>
                            <input type="text" placeholder="Avenue de Luminy"  class="input-form @error('rueArr') is-invalid @enderror" id="rueArr" name="rueArr" aria-describedby="rueArrError">
                            @error('rueArr')
                                <small id="rueArrError" class="form-text text-muted">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-10 mx-auto space-bottom-title" style="padding-bottom: 20px;">
                        <div class="col-right-input">
                            <label for="cpArr">Code postal</label>
                            <input type="number" placeholder="13009" class="input-form @error('cpArr') is-invalid @enderror" id="cpArr" name="cpArr" aria-describedby="cpArrError">
                            @error('cpArr')
                                <small id="cpArrError" class="form-text text-muted">{{$message}}</small>
                            @enderror
                        </div>
                        <div class="col-left-input">
                            <label for="villeArr">Ville</label>
                            <input type="text" placeholder="Marseille"  class="input-form @error('villeArr') is-invalid @enderror" id="villeArr" name="villeArr" aria-describedby="villeArrError">
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
                            <label for="date">Date de départ</label>
                            <input type="datetime-local" class="input-form @error('date') is-invalid @enderror" id="date" name="date" aria-describedby="dateError">
                            @error('date')
                                <small id="dateError" class="form-text text-muted">{{$message}}</small>
                            @enderror
                        </div>
                        <div class="col-left-input">
                            <label for="place">Nombre de place(s)</label>
                            <input type="number" placeholder="1"  class="input-form @error('place') is-invalid @enderror" id="place" name="place" aria-describedby="placeError"  min="1", max="10">
                            @error('place')
                                <small id="placeError" class="form-text text-muted">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                    
                </div>
            </div>

            <div class="col-left-input-accueil">
                <div style="padding-bottom: 5px;">
                
                    <div class="row justify-content-center align-items-center" style="padding-top: 40px;">
                        <button type="submit" class="btn button-form">Rechercher</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel">
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img class="d-block w-100" src="/images/carousel/imagesEntreeLuminy.png" alt="First slide">
    </div>
    <div class="carousel-item">
      <img class="d-block w-100" src="/images/carousel/imagesAerienneLuminy.png" alt="Second slide">
    </div>
    <div class="carousel-item">
      <img class="d-block w-100" src="/images/carousel/luminyBu.png" alt="Third slide">
    </div>
  </div>
</div>

@endsection
