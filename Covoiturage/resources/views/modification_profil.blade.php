@extends('base')

@section('title')
Modification du profil
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
<h1 class="center-title">Modifier votre profil</h1>
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
            <label for="email">Modifier l'adresse mail</label>
            <input type="email" placeholder="dorian.bourdontpe@gmail.com"  class="input-form @error('email') is-invalid @enderror" id="email" name="email" aria-describedby="emailError">
            @error('email')
                <small id="emailError" class="form-text text-muted">{{$message}}</small>
            @enderror
        </div>
        <div class="col-left-input">
            <label for="tel">Modifier le numero de téléphone</label>
            <input type="tel" placeholder="01 02 03 04 05"  class="input-form @error('tel') is-invalid @enderror" id="tel" name="tel" aria-describedby="telError">
            @error('tel')
                <small id="telError" class="form-text text-muted">{{$message}}</small>
            @enderror
        </div>
    </div>

    <div class="col-md-10 mx-auto" style="padding-top: 20px;">
        <div class="col-right-input">
            <label for="prenom">Modifier le prénom</label>
            <input type="text" placeholder="Dorian"  class="input-form @error('prenom') is-invalid @enderror" id="prenom" name="prenom" aria-describedby="prenomError">
            @error('prenom')
                <small id="prenomError" class="form-text text-muted">{{$message}}</small>
            @enderror
        </div>
        <div class="col-left-input">
            <label for="nom">Modifier le nom</label>
            <input type="text" placeholder="Bourdon"  class="input-form @error('nom') is-invalid @enderror" id="nom" name="nom" aria-describedby="nomError">
            @error('nom')
                <small id="nomError" class="form-text text-muted">{{$message}}</small>
            @enderror

        </div>
    </div>

    <div class="col-md-10 mx-auto" style="padding-top: 20px;">
        <div class="col-right-input">
            <label for="dateNaiss">Modifier la date de naissance</label>
            <input type="date" class="input-form @error('dateNaiss') is-invalid @enderror" id="dateNaiss" name="dateNaiss" aria-describedby="dateError">
            @error('dateNaiss')
                <small id="dateError" class="form-text text-muted">{{$message}}</small>
            @enderror
        </div>
        <div class="col-left-input">
            <label for="profil">Modifier la photo de profil</label>
            <input type="file" class="input-form-file @error('profil') is-invalid @enderror" id="profil" name="profil" aria-describedby="profilError">   
            @error('profil')
                <small id="profilError" class="form-text text-muted">{{$message}}</small>
            @enderror
        </div>
    </div>
    <div class="col-md-10 mx-auto" style="padding-top: 20px;">
        <div class="col-right-input">
            <label for="nni">Modifier le numero d'identité (NNI)</label>
            <input type="text" placeholder="939049615866" class="input-form @error('nni') is-invalid @enderror" id="nni" name="nni" aria-describedby="nniError">
            @error('nni')
                <small id="nniError" class="form-text text-muted">{{$message}}</small>
            @enderror
        </div>
        <div class="col-left-input">
            <label for="numPermis">Modifier le numéro du permis</label>
            <input type="text" placeholder="950713706342" class="input-form @error('numPermis') is-invalid @enderror" id="numPermis" name="numPermis" aria-describedby="numPermisError">   
            @error('numPermis')
                <small id="numPermisError" class="form-text text-muted">{{$message}}</small>
            @enderror
        </div>
    </div>

    <div class="col-md-10 mx-auto" style="padding-top: 20px;">
        <div class="col-right-input">
            <label for="description">Modifier la description</label>
            <textarea class="form-control textarea-form @error('description') is-invalid @enderror" id="description" name="description" rows=3></textarea>
        </div>
        <div class="col-left-input">
            <label for="oldPassword">Modifier le mot de passe</label>
            <input type="password" placeholder="Ancien mot de passe" class="input-form @error('oldPassword') is-invalid @enderror" id="oldPassword" name="oldPassword" aria-describedby="oldPasswordError">   
            @error('oldPassword')
                <small id="oldPasswordError" class="form-text text-muted">{{$message}}</small>
            @enderror
            <div style="padding-top: 30px;"></div>
            <input type="password" placeholder="Nouveau mot de passe" class="input-form @error('newPassword') is-invalid @enderror" id="newPassword" name="newPassword" aria-describedby="newPasswordError">   
            @error('newPassword')
                <small id="newPasswordError" class="form-text text-muted">{{$message}}</small>
            @enderror
        </div>
    </div>

    <div class="row justify-content-center align-items-center">
        <button type="submit" class="btn button-form">Envoyer</button>
    </div>
</form>

@endsection