@extends('base')

@section('title')
Modification technique
@endsection

@section('style')
    <link rel="stylesheet" href="css/style.css">
@endsection

@section('navbarSequel')
    <ul class="navbar-nav mr-auto"> 
        <li class="nav-item">
            <a class="nav-link" href="#">Ismail IDBOURHIM</a>
        </li>
    </ul>
    <div class="pmd-user-info ">
        <a href="javascript:void(0);" class="nav-user-img" >   
            <img class="avatar-img rounded-circle" src="/images/avatar_photo.jpg" width="73" height="73" alt="avatar">
        </a>
    </div>
@endsection

@section('content')
<h1 class="center-title">Modifier vos informations techniques</h1>
<form>
    @csrf
    @if($errors->any())
        <div class="alert alert-warning">
           Impossible de s'inscrire &#9785; {{implode('', $errors->all('<div>:message</div>'))}}
        </div>
    @endif
    @if(session()->has('success'))
        <div class="alert alert-success">
                  {{session()->get('success')}}&#9786;
        </div>
    @endif

    <div class="col-md-10 mx-auto" style="padding-top: 20px;">
        <div class="col-right-input">
            <label for="marque">Modifier la marque de la voiture</label>
            <input type="text" placeholder="Alpha Roméo"  class="input-form @error('marque') is-invalid @enderror" id="marque" name="marque" aria-describedby="marqueError">
            @error('email')
                <small id="marqueError" class="form-text text-muted">{{$message}}</small>
            @enderror
        </div>
        <div class="col-left-input">
            <label for="couleur">Modifier la couleur de la voiture</label>
            <input type="text" placeholder="Rouge"  class="input-form @error('couleur') is-invalid @enderror" id="couleur" name="couleur" aria-describedby="couleurError">
            @error('couleur')
                <small id="couleurError" class="form-text text-muted">{{$message}}</small>
            @enderror
        </div>
    </div>

    <div class="col-md-10 mx-auto" style="padding-top: 20px;">
        <div class="col-right-input">
            <label for="nbPlace">Modifier le nombre de place</label>
            <input type="number" placeholder="3" class="input-form @error('nbPlace') is-invalid @enderror" id="nbPlace" name="nbPlace" aria-describedby="placeError">
            @error('nbPlace')
                <small id="placeError" class="form-text text-muted">{{$message}}</small>
            @enderror
        </div>
        <div class="col-left-input">
            <label for="immatriculation">Modifier la plaque d'immatriculation </label>
            <input type="text" placeholder="ED-145-TR"  class="input-form @error('immatriculation') is-invalid @enderror" id="immatriculation" name="immatriculation" aria-describedby="immError">
            @error('immatriculation')
                <small id="immError" class="form-text text-muted">{{$message}}</small>
            @enderror
        </div>
    </div>

    <div class="col-md-10 mx-auto" style="padding-top: 20px;">
        <div class="col-right-input">
            <label for="fumer">Autoriser les fumeurs ?</label>
            <select class="input-form @error('fumer') is-invalid @enderror" id="fumer" name="fumer" value="{{old('fumer')}}" aria-describedby="fumerError">
                <option value="Oui">Oui</option>
                <option value="Non">Non</option>
            </select>
            @error('fumer')
                <small id="fumerError" class="form-text text-muted">{{$message}}</small>
            @enderror
        </div>
        <div class="col-left-input">
            <label for="animaux">Autoriser les animaux ?</label>
            <select class="input-form @error('animaux') is-invalid @enderror" id="animaux" name="animaux" value="{{old('animaux')}}" aria-describedby="animauxError">
                <option value="Oui">Oui</option>
                <option value="Non">Non</option>
            </select>
            @error('animaux')
                <small id="animauxError" class="form-text text-muted">{{$message}}</small>
            @enderror
        </div>
    </div>

    <div class="col-md-10 mx-auto" style="padding-top: 20px;">
        <label for="photoVoiture">Photo de la voiture</label>
        <input type="file" class="input-form-file @error('photoVoiture') is-invalid @enderror" id="photoVoiture" name="photoVoiture" aria-describedby="photoVError">
        @error('photoVoiture')
                <small id="photoVError" class="form-text text-muted">{{$message}}</small>
        @enderror   
    </div>

    <div class="row justify-content-center align-items-center" style="padding-top: 20px;">
        <button type="submit" class="btn button-form">Appliquer les changements</button>
    </div>
</form>
@endsection