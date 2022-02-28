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
                            <input type="number" placeholder="1"  class="input-form @error('place') is-invalid @enderror" id="place" name="place" aria-describedby="placeError">
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


<h2 class="center-title space-bottom-title">Les trajets aux meilleurs prix aujourd'hui</h2>
<div>
    <!-- div global -->
    <div class="border border-dark margin-trajetsBest">
        <div class="row ml-5 mt-3">
            <div class="v-list-item__title">
                <div class=" text-h6">7h30</div> 
                <div class="text-body-2">
                Jeu 24/02
                </div>
            </div>
            
            <!-- trajet -->
            <div class="col-md-7 detail-trajet">
                <div class="row">
                    <div class="col-md-5 text-center lieu-depart">
                        <span>Marseille</span>
                    </div> 
                    <div class="col-md-2 pl-2 temps-image">
                        <!-- photo de destination -->
                        <img src="/images/trajet_bleu.png" width="74" height="17" alt=""/>
                        <div class="font-weight-bold ml-2">
                            <span>30 min</span>
                        </div>
                    </div> 
                    <div class="col-md-5 text-center lieu-arrive">
                        <span>Luminy</span>
                    </div>
                </div>
            </div>

            <!-- nbr de place -->
            <div class="col-md-2 places-dispo">
                4 Place.s
            </div>

            <!-- prix -->
            <div class="col-md-1 prix">
                5 €
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
    <div class="border border-dark margin-trajetsBest" style="margin-top: 20px;">
        <div class="row ml-5 mt-3">
            <div class="v-list-item__title">
                <div class=" text-h6">9h30</div> 
                <div class="text-body-2">
                Ven 25/02
                </div>
            </div>
            
            <!-- trajet -->
            <div class="col-md-7 detail-trajet">
                <div class="row">
                    <div class="col-md-5 text-center lieu-depart">
                        <span>Marseille</span>
                    </div> 
                    <div class="col-md-2 pl-2 temps-image">
                        <!-- photo de destination -->
                        <img src="/images/trajet_bleu.png" width="74" height="17" alt=""/>
                        <div class="font-weight-bold ml-2">
                            <span>120 min</span>
                        </div>
                    </div> 
                    <div class="col-md-5 text-center lieu-arrive">
                        <span>Luminy</span>
                    </div>
                </div>
            </div>

            <!-- nbr de place -->
            <div class="col-md-2 places-dispo">
                2 Place.s
            </div>

            <!-- prix -->
            <div class="col-md-1 prix">
                5 €
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
                <span class="text-h6">Y. Kenza</span>
            </div>
            <!-- button plus détails -->
            <div class="col-md-4 mt-2">
                <a href="{{route('details_result_recherche_trajet')}}"><button class="btn button-form ml-5">PLUS DÉTAILS</button></a>
            </div>
        </div> 
    </div>



</div>


@endsection