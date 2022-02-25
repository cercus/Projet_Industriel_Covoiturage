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
            <a class="nav-link" href="#">Inscription</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">Connexion</a>
        </li>
    </ul>
@endsection

@section('content')

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

<div class="row margin-bottom-accueil">

<div class="slideshow luminyImg"><style>

.slideshow {

   width: 300px;

   height: 300px;

   overflow: hidden;

   border: 3px solid #F2F2F2;

}

.slideshow ul {

    /* 3 images donc 4 x 100% */

   width: 300%;

   height: 300px;

   padding:0; margin:0;

   list-style: none;

}

.slideshow li {

   float: left;

}</style>

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>

<script type="text/javascript">

   $(function(){

      setInterval(function(){

         $(".slideshow ul").animate({marginLeft:-350},800,function(){

            $(this).css({marginLeft:0}).find("li:last").after($(this).find("li:first"));

         })

      }, 3500);

   });

</script>

<ul>

             <li><img src="{{URL::asset('images/campusLuminy4.jpg')}}" alt="" width="300" height="300"/></li>

             <li><img src="{{URL::asset('images/campusLuminy1.jpg')}}" alt="" width="300" height="300" /></li>

             <li><img src="{{URL::asset('images/campusLuminy2.jpg')}}" alt="" width="300" height="300" /></li>
             
             <li><img src="{{URL::asset('images/campusLuminy3.jpg')}}" alt="" width="300" height="300" /></li>

       </ul>

</div>

</div>

<div class="margin-bottom-accueil center-title">
    <h2>Avec Columiny, aller à luminy n'a jamais été aussi simple...</h2>
</div>


<form method="POST" action="{{route('accueil.post')}}">
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
                         required value="{{ old('numRueDep') }}">
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
                        required value="{{ old('adresseRueDep') }}">
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
                        required value="{{ old('villeDep') }}">
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
                        required value="{{ old('cpDep') }}">
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
                        class="input-form form-control @error('dateDep') is-invalid @enderror" required value="{{ old('dateDep') }}">
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
                        class="input-form form-control @error('timeDep') is-invalid @enderror" required value="{{ old('timeDep') }}">
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
                        required value="{{ old('numRueArr') }}">
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
                        required value="{{ old('adresseRueArr') }}">
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
                        required value="{{ old('villeArr') }}">
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
                        required value="{{ old('cpArr') }}">
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
                        required value="{{ old('nbPlace') }}">
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

    <button type="submit" class="button-form-accueil">Rechercher</button>
</form>




@endsection