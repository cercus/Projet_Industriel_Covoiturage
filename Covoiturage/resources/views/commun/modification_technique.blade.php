@extends('base')

@section('title')
Modification technique
@endsection

@section('style')
    <link rel="stylesheet" href="/css/style.css">
@endsection

@section('navbarSequel')
    <ul class="navbar-nav mr-auto"> 
        <li class="nav-item">
            <a class="nav-link" href="{{route('user')}}">{{ $infoPerso->prenomUtilisateur }} {{ $infoPerso->nomUtilisateur }}</a>
        </li>
    </ul>
    <div class="pmd-user-info ">
        <a href="{{route('user')}}" class="nav-user-img" > 
            @if ($infoPerso->photoProfil != null)
                <img class="avatar-img rounded-circle" src="{{ $infoPerso->photoProfil }}" width="73" height="73" alt="avatar"> 
            @else
                <img class="avatar-img rounded-circle" src="/images/avatar_photo.jpg" width="73" height="73" alt="avatar">
            @endif   
        </a>
    </div>
@endsection

@section('content')
<h1 class="center-title">Modifier vos informations techniques</h1>
<form method="POST" action="{{route('modify.technique')}}">
    @csrf
    @if($errors->any())
        <div class="alert alert-warning col-md-10 mx-auto">
           Impossible de modifier vos informations techniques &#9785; {{implode('', $errors->all('<div>:message</div>'))}}
        </div>
    @endif

    <div class="col-md-10 mx-auto space-bottom-title">
        <div class="col-right-input ">
            <label for="marque">Modifier la marque de la voiture</label>
            <input type="text" placeholder="Alpha Roméo"  class="input-form @error('marque') is-invalid @enderror" id="marque" name="marque" aria-describedby="marqueError" value = {{$infoTechno->marqueModelVoiture}}>
            @error('email')
                <small id="marqueError" class="invalid-feedback">{{$message}}</small>
            @enderror
        </div>
        <div class="col-left-input">
            <label for="couleur">Modifier la couleur de la voiture</label>
            <input type="text" placeholder="Rouge"  class="input-form @error('couleur') is-invalid @enderror" id="couleur" name="couleur" aria-describedby="couleurError" value = {{$infoTechno->couleurVoiture}}>
            @error('couleur')
                <small id="couleurError" class="invalid-feedback">{{$message}}</small>
            @enderror
        </div>
    </div>

    <div class="col-md-10 mx-auto space-bottom-title">
        <div class="col-right-input">
            <label for="nbPlace">Modifier le nombre de place</label>
            <input type="number" placeholder="3" class="input-form @error('nbPlace') is-invalid @enderror" id="nbPlace" name="nbPlace" aria-describedby="placeError" value = {{$infoTechno->nbPlaceMax}} max='9'>
            @error('nbPlace')
                <small id="placeError" class="invalid-feedback">{{$message}}</small>
            @enderror
        </div>
        <div class="col-left-input">
            <label for="immatriculation">Modifier la plaque d'immatriculation </label>
            <input type="text" placeholder="ED-145-TR"  class="input-form @error('immatriculation') is-invalid @enderror" id="immatriculation" name="immatriculation" aria-describedby="immError" value = {{$infoTechno->immatriculation}}>
            @error('immatriculation')
                <small id="immError" class="invalid-feedback">{{$message}}</small>
            @enderror
        </div>
    </div>

    <div class="col-md-10 mx-auto space-bottom-title">
        <div class="col-right-input">
            <label for="fumer">Autoriser les fumeurs ?</label>
            <select class="input-form @error('fumer') is-invalid @enderror" id="fumer" name="fumer" value = {{$infoTechno->autoriserFumer}} aria-describedby="fumerError">
                @if($infoTechno->autoriserFumer == 1)
                    <option value="1" selected>Oui</option>
                    <option value="0">Non</option>
                @else
                <option value="1">Oui</option>
                    <option value="0" selected>Non</option>
                @endif
            </select>
            @error('fumer')
                <small id="fumerError" class="invalid-feedback">{{$message}}</small>
            @enderror
        </div>
        <div class="col-left-input">
            <label for="animaux">Autoriser les animaux ?</label>
            <select class="input-form @error('animaux') is-invalid @enderror" id="animaux" name="animaux" value = {{$infoTechno->autoriserAnimal}} aria-describedby="animauxError">
                @if($infoTechno->autoriserAnimal == 1)
                    <option value="1" selected>Oui</option>
                    <option value="0">Non</option>
                @else
                <option value="1">Oui</option>
                    <option value="0" selected>Non</option>
                @endif
            </select>
            @error('animaux')
                <small id="animauxError" class="invalid-feedback">{{$message}}</small>
            @enderror
        </div>
    </div>

    <div class="col-md-10 mx-auto space-bottom-title">
        <label for="photoVoiture">Photo de la voiture</label>
        <input type="file" class="input-form-file @error('photoVoiture') is-invalid @enderror" id="photoVoiture" name="photoVoiture" aria-describedby="photoVError">
        @error('photoVoiture')
                <small id="photoVError" class="invalid-feedback">{{$message}}</small>
        @enderror   
    </div>

    <div class="row justify-content-center align-items-center space-bottom-title">
        <button type="submit" class="btn button-form">Appliquer les changements</button>
    </div>
</form>
@endsection