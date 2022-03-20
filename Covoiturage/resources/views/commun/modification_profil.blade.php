@extends('base')

@section('title')
    Modification du profil
@endsection

@section('style')
    <link rel="stylesheet" href="/css/style.css">
@endsection

@section('navbarSequel')
    <ul class="navbar-nav mr-auto"> 
        <li class="nav-item">
            <a class="nav-link" href="{{route('user', ['idUtilisateur' => session()->get('user')['id']])}}">{{ $infoPerso->prenomUtilisateur }} {{ $infoPerso->nomUtilisateur }}</a>
        </li>
    </ul>
    <div class="pmd-user-info ">
        <a href="{{route('user', ['idUtilisateur' => session()->get('user')['id']])}}" class="nav-user-img" > 
            @if ($infoPerso->photoProfil != null)
                <img class="avatar-img rounded-circle" src="{{ $infoPerso->photoProfil }}" width="73" height="73" alt="avatar"> 
            @else
                <img class="avatar-img rounded-circle" src="/images/avatar_photo.jpg" width="73" height="73" alt="avatar">
            @endif   
        </a>
    </div>
@endsection

@section('content')
    <h1 class="center-title">Modifier votre profil</h1>
    <form method="POST" action="{{route('modify.profil')}}" id="from-profil">
        @csrf
        @if($errors->any())
            <div class="alert alert-warning col-md-10 mx-auto">
            Impossible de modifier vos informations personnelles &#9785; {{implode('', $errors->all('<div>:message</div>'))}}
            </div>
        @endif
        <div class="col-md-10 mx-auto space-bottom-title">
            <div class="col-right-input">
                <label for="email">Modifier l'adresse mail</label>
                <input type="email" class="input-form @error('email') is-invalid @enderror" id="email" name="email" aria-describedby="emailError" value = {{$infoPerso->emailUtilisateur}} placeholder="dorian.bourdontpe@gmail.com">
                @error('email')
                    <small id="emailError" class="invalid-feedback" >{{$message}}</small>
                @enderror
            </div>
            <div class="col-left-input">
                <label for="tel">Modifier le numero de téléphone</label>
                <input type="tel" placeholder="01 02 03 04 05" class="input-form @error('tel') is-invalid @enderror" id="tel" name="tel" aria-describedby="telError" value = {{$infoPerso->numTelUtilisateur}}>
                @error('tel')
                    <small id="telError" class="invalid-feedback">{{$message}}</small>
                @enderror
            </div>
        </div>

        <div class="col-md-10 mx-auto space-bottom-title">
            <div class="col-right-input">
                <label for="prenom">Modifier le prénom</label>
                <input type="text" placeholder="Dorian"  class="input-form @error('prenom') is-invalid @enderror" id="prenom" name="prenom" aria-describedby="prenomError" value = {{$infoPerso->prenomUtilisateur}}>
                @error('prenom')
                    <small id="prenomError" class="invalid-feedback">{{$message}}</small>
                @enderror
            </div>
            <div class="col-left-input">
                <label for="nom">Modifier le nom</label>
                <input type="text" placeholder="Bourdon"  class="input-form @error('nom') is-invalid @enderror" id="nom" name="nom" aria-describedby="nomError" value = {{$infoPerso->nomUtilisateur}}>
                @error('nom')
                    <small id="nomError" class="invalid-feedback">{{$message}}</small>
                @enderror
            </div>
        </div>

        <div class="col-md-10 mx-auto space-bottom-title">
            <div class="col-right-input">
                <label for="dateNaiss">Modifier la date de naissance</label>
                <input type="date" class="input-form @error('dateNaiss') is-invalid @enderror" id="dateNaiss" name="dateNaiss" aria-describedby="dateError" value = {{$infoPerso->dateNaiss}}>
                @error('dateNaiss')
                    <small id="dateError" class="invalid-feedback">{{$message}}</small>
                @enderror
            </div>
            <div class="col-left-input">
                <label for="profil">Modifier la photo de profil</label>
                <input type="file" class="input-form-file @error('profil') is-invalid @enderror" id="profil" name="profil" aria-describedby="profilError">   
                @error('profil')
                    <small id="profilError" class="invalid-feedback">{{$message}}</small>
                @enderror
            </div>
        </div>
        <div class="col-md-10 mx-auto space-bottom-title">
            <div class="col-right-input">
                <label for="nni">Modifier le numero d'identité (NNI)</label>
                <input type="text" placeholder="939049615866" class="input-form @error('nni') is-invalid @enderror" id="nni" name="nni" aria-describedby="nniError" value = {{$infoPerso->numeroIdentite}}>
                @error('nni')
                    <small id="nniError" class="invalid-feedback">{{$message}}</small>
                @enderror
            </div>
            <div class="col-left-input">
                <label for="numPermis">Modifier le numéro du permis</label>
                <input type="text" placeholder="950713706342" class="input-form @error('numPermis') is-invalid @enderror" id="numPermis" name="numPermis" aria-describedby="numPermisError" value = {{$infoPerso->numPermisConduire}}>   
                @error('numPermis')
                    <small id="numPermisError" class="invalid-feedback">{{$message}}</small>
                @enderror
            </div>
        </div>

        <div class="col-md-10 mx-auto space-bottom-title">
            <div class="col-right-input">
                <label for="description">Modifier la description</label>
                <textarea class="form-control textarea-form @error('description') is-invalid @enderror" id="description" name="description" rows=3 ><?=$infoPerso->descriptionUtilisateur?></textarea>
            </div>
        </div>

        <div class="row justify-content-center align-items-center">
            <button type="submit" class="btn button-form">Envoyer</button>
        </div>
    </form>

@endsection