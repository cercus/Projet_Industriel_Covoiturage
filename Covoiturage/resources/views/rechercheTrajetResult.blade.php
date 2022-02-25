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
            <a class="nav-link" href="#">Inscription</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">Connexion</a>
        </li>
    </ul>
@endsection

@section('content')


<div class="margin-bottom-accueil center-title">
    <h1>Avec Columiny, aller à luminy n'a jamais été aussi simple...</h1>
</div>


<form class="margin-bottom-accueil">
    @csrf
    @if ($errors->any())
        <div class="alert alert-warning">
            La recherche n'a pas pu etre effectuée &#9785;
        </div>
    @endif
    <div class="row">
        <div class="colonne-6">
            <h3 class="center-title">Départ</h3>
            <div class="row fond">
                <div class="colonne-5">
                <label for="numRueDep">Numéro de rue</label>


              
                <input type="text" id="numRueDep" name="numRueDep"  
                        aria-describedby="numRueDep_feedback" 
                        class="input-form form-control @error('numRueDep') is-invalid @enderror"
                        required value="{{ $trajet['numRueDep'] }}">




                @error('numRueDep')
                <div id="numRueDep_feedback" class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
                </div>

                <div class="colonne-6">
                <label for="adresseRueDep">Adresse de la rue</label>
                <input type="text" id="adresseRueDep" name="adresseRueDep"  
                        aria-describedby="adresseRueDep_feedback" 
                        class="input-form form-control @error('adresseRueDep') is-invalid @enderror"
                        required value="{{ $trajet['adresseRueDep'] }}">
                @error('adresseRueDep')
                <div id="adresseRueDep_feedback" class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
                </div>
            </div>

            <div class="row fond">
                <div class="colonne-5">
                <label for="villeDep">Ville</label>
                <input type="text" id="villeDep" name="villeDep"  
                        aria-describedby="villeDep_feedback" 
                        class="input-form form-control @error('villeDep') is-invalid @enderror"
                        required value="{{ $trajet['villeDep'] }}">
                @error('adresseRueDep')
                <div id="villeDep_feedback" class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
                </div>

                <div class="colonne-6">
                <label for="cpDep">Code postal</label>
                <input type="number" id="cpDep" name="cpDep"  
                        aria-describedby="cpDep_feedback" 
                        class="input-form form-control @error('cpDep') is-invalid @enderror"
                        required value="{{ $trajet['cpDep'] }}">
                @error('numRueDep')
                <div id="cpDep_feedback" class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
                </div>
            </div>

            <div class="row fond">

                <div class="colonne-6">
                <label for="dateDep">Date</label>
                <input type="date" id="dateDep" name="dateDep"
                aria-describedby="dateDep_feedback" 
                        class="input-form form-control @error('dateDep') is-invalid @enderror" required value="{{ $trajet['dateDep'] }}">
                @error('date')
                <div id="dateDep_feedback" class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
                </div>

                <div class="colonne-6">
                <label for="timeDep">Heure</label>
                <input type="time" id="timeDep" name="timeDep"
                aria-describedby="timeDep_feedback" 
                        class="input-form form-control @error('timeDep') is-invalid @enderror" required value="{{ $trajet['timeDep'] }}">
                @error('time')
                <div id="timeDep_feedback" class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
                </div>

            </div>
                
            
        </div>

        <div class="colonne-6">
            <h3 class="center-title">Arrivée</h3>
            <div class="row fond2">
                <div class="colonne-5">
                <label for="numRueArr">Numéro de rue</label>
                <input type="text" id="numRueArr" name="numRueArr"  
                        aria-describedby="numRueArr_feedback" 
                        class="input-form form-control @error('numRueArr') is-invalid @enderror"
                        required value="{{ $trajet['numRueArr'] }}">
                @error('numRueArr')
                <div id="numRueArr_feedback" class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
                </div>

                <div class="colonne-6">
                <label for="adresseRueArr">Adresse de la rue</label>
                <input type="text" id="adresseRueArr" name="adresseRueArr"  
                        aria-describedby="adresseRueArr_feedback" 
                        class="input-form form-control @error('adresseRueArr') is-invalid @enderror"
                        required value="{{ $trajet['adresseRueArr'] }}">
                @error('adresseRueArr')
                <div id="adresseRueArr_feedback" class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
                </div>
            </div>

            <div class="row fond2">
                <div class="colonne-5">
                <label for="villeArr">Ville</label>
                <input type="text" id="villeArr" name="villeArr"  
                        aria-describedby="villeArr_feedback" 
                        class="input-form form-control @error('villeArr') is-invalid @enderror"
                        required value="{{ $trajet['villeArr'] }}">
                @error('adresseRueArr')
                <div id="villeArr_feedback" class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
                </div>

                <div class="colonne-6">
                <label for="cpArr">Code postal</label>
                <input type="number" id="cpArr" name="cpArr"  
                        aria-describedby="cpArr_feedback" 
                        class="input-form form-control @error('cpArr') is-invalid @enderror"
                        required value="{{ $trajet['cpArr'] }}">
                @error('numRueArr')
                <div id="cpArr_feedback" class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
                </div>
            </div>

            <div class="row fond2">
                <div class="colonne-5">
                <label for="nbPlace">Nombre de place.s</label>
                <input type="number" id="nbPlace" name="nbPlace"  
                        aria-describedby="nbPlace_feedback" 
                        class="input-form form-control @error('nbPlace') is-invalid @enderror"
                        required value="{{ $trajet['nbPlace'] }}">
                @error('nbPlace')
                <div id="nbPlace_feedback" class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
                </div>
            </div>

            
            </div>
        </div>  
    </div>
</form>

<div class="margin-bottom-accueil center-title">
    <h2>Trajets correspondants à la recherche</h2>
</div>

<div>
@foreach ($trajetsProposes as $trajetProposes)
    <!-- div global -->
    <div class="border border-dark margin-trajetsBest">
        <div class="row ml-5 mt-3">
            <div class="v-list-item__title">
                <div class=" text-h6">
                {{ $trajetProposes['heure'] }} 
                </div> 
                <div class="text-body-2">
                {{ $trajetProposes['jour'] }} {{ $trajetProposes['date'] }}
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
                        <img src="/images/Picture2.jpg" width="74" height="17" alt=""/>
                        <div class="font-weight-bold ml-2">
                            <span>{{ $trajetProposes['duree'] }} min</span>
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
            {{ $trajetProposes['prix'] }}€       
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
                <span class="text-h6">{{ $trajetProposes['nom'] }} {{ $trajetProposes['prenom'] }}</span>
            </div>
            <!-- button plus détails -->
            <div class="col-md-4 mt-2">
                <button class="btn button-form ml-5"><a href="{{route('detailsResultRechercheTrajet', ['trajetId'=>$trajetProposes['id']])}}">PLUS DÉTAILS</a></button>
            </div>
        </div> 
    </div>
&nbsp
@endforeach
</div>




@endsection