@extends('base')

@section('title')
Inscription
@endsection

@section('style')
    <link rel="stylesheet" href="css/style.css">
@endsection

@section('navbarSequel')
    @if (session()->has('user'))
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
    @else
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="/inscription">Inscription</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/connexion">Connexion</a>
            </li>
        </ul>
    @endif
@endsection

@section('content')
<h1 class="center-title">S'inscrire sur le site</h1>

<form id="register">
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

    <div class="col-md-8 mx-auto" style="padding-top: 20px;">

        <!-- Nom -->
        <div class="col-right-input">
            <label for="nom">Nom*</label>
            <input type="text" class="input-form @error('nom') is-invalid @enderror" id="nom" name="nom" required value="{{old('nom')}}" aria-describedby="nomError">
            @error('nom')
                <small id="nomError" class="form-text text-muted">{{$message}}</small>
            @enderror
        </div>

        <!-- prenom -->
        <div class="col-left-input">
            <label for="prenom">Prénom*</label>
            <input type="text" class="input-form @error('prenom') is-invalid @enderror" id="prenom" name="prenom" required value="{{old('prenom')}}" aria-describedby="prenomError">
            @error('prenom')
                <small id="prenomError" class="form-text text-muted">{{$message}}</small>
            @enderror
        </div>      
    </div>

    <div class="col-md-8 mx-auto" style="padding-top: 20px;">

        <!-- Adresse mail -->
        <div class="col-right-input">
            <label for="email">Adresse mail*</label>
            <input type="email" class="input-form @error('email') is-invalid @enderror" id="email" name="email" required value="{{old('email')}}" aria-describedby="emailError">
            @error('email')
                <small id="emailError" class="form-text text-muted">{{$message}}</small>
            @enderror
        </div>

        <!-- Mot de passe -->
        <div class="col-left-input">
            <label for="mdp">Mot de passe*</label>
            <input type="password" class="input-form @error('mdp') is-invalid @enderror" id="mdp" name="mdp" required aria-describedby="mdpError">
            @error('mdp')
                <small id="mdpError" class="form-text text-muted">{{$message}}</small>
            @enderror
        </div>      
    </div>

    <div class="col-md-8 mx-auto" style="padding-top: 20px;">

        <!-- Mot de passe 2 -->
        <div class="col-right-input">
            <label for="repeterMdp">Répétez mot de passe*</label>
            <input type="password" class="input-form @error('repeterMdp') is-invalid @enderror" id="repeterMdp" name="repeterMdp" required aria-describedby="mdp2Error">
            @error('repeterMdp')
                <small id="mdp2Error" class="form-text text-muted">{{$message}}</small>
            @enderror
        </div>

        <!-- Date de naissance -->
        <div class="col-left-input">
            <label for="dateNaiss">Date de naissance</label>
            <input type="date" class="input-form @error('dateNaiss') is-invalid @enderror" id="dateNaiss" name="dateNaiss" value="{{old('dateNaiss')}}" aria-describedby="dateError">
            @error('date')
                <small id="dateError" class="form-text text-muted">{{$message}}</small>
            @enderror
        </div>      
    </div>

    <!-- Numéro de téléphone -->
    <div class="col-md-8 mx-auto" style="padding-top: 20px;">
        <label for="telephone">Numéro de téléphone*</label>
        <input type="tel" class="input-form @error('telephone') is-invalid @enderror" id="telephone" name="telephone" required placeholder="01 02 03 04 05" pattern="[0-9]{2} [0-9]{2} [0-9]{2} [0-9]{2} [0-9]{2}" aria-describedby="telError">    
        @error('telephone')
                <small id="telError" class="form-text text-muted">{{$message}}</small>
            @enderror
    </div>

    <!-- Photo de profil -->
    <div class="col-md-8 mx-auto" style="padding-top: 20px;">
        <label for="profil">Photo de profil</label>
        <input type="file" class="input-form-file @error('profil') is-invalid @enderror" id="profil" name="profil" aria-describedby="profilError">   
        @error('profil')
                <small id="profilError" class="form-text text-muted">{{$message}}</small>
            @enderror
    </div>

    <h3 style="padding-top: 50px;" class="text-center">Informations en plus si vous possédez une voiture</h3>

    <div class="col-md-8 mx-auto" style="padding-top: 20px;">

        <!-- Plaque d'immatriculation -->
        <div class="col-right-input">
            <label for="immatriculation">Plaque d'immatriculation</label>
            <input type="text" class="input-form @error('immatriculation') is-invalid @enderror" id="immatriculation" name="immatriculation" aria-describedby="immatError">
            @error('immatriculation')
                <small id="immatError" class="form-text text-muted">{{$message}}</small>
            @enderror
        </div>

        <!-- Marque de la voiture -->
        <div class="col-left-input">
            <label for="marqueVoiture">Marque de la voiture</label>
            <input type="text" class="input-form @error('marqueVoiture') is-invalid @enderror" id="marqueVoiture" name="marqueVoiture" value="{{old('marqueVoiture')}}" aria-describedby="marqueError">
            @error('marqueVoiture')
                <small id="marqueError" class="form-text text-muted">{{$message}}</small>
            @enderror
        </div>      
    </div>

    
    <div class="col-md-8 mx-auto" style="padding-top: 20px;">
        <!-- Nombre de place max dans la voiture -->
        <div class="col-right-input">
            <label for="nbPlace">Nombre de place max</label>
            <input type="number" class="input-form @error('nbPlace') is-invalid @enderror" id="nbPlace" name="nbPlace" value="{{old('nbPlace')}}" aria-describedby="placeError">
            @error('nbPlace')
                <small id="placeError" class="form-text text-muted">{{$message}}</small>
            @enderror
        </div>
        <!-- Couleur de la voiture -->
        <div class="col-left-input">
            <label for="couleurVoiture">Couleur de la voiture</label>
            <input type="text" class="input-form @error('couleurVoiture') is-invalid @enderror" id="couleurVoiture" name="couleurVoiture" value="{{old('couleurVoiture')}}" aria-describedby="couleurError">
            @error('couleurVoiture')
                <small id="couleurError" class="form-text text-muted">{{$message}}</small>
            @enderror
        </div>      
    </div>

    <!-- Photo de la voiture -->
    <div class="col-md-8 mx-auto" style="padding-top: 20px;">
        <label for="photoVoiture">Photo de la voiture</label>
        <input type="file" class="input-form-file @error('photoVoiture') is-invalid @enderror" id="photoVoiture" name="photoVoiture" aria-describedby="photoVError">
        @error('photoVoiture')
                <small id="photoVError" class="form-text text-muted">{{$message}}</small>
        @enderror   
    </div>
    
    <!-- Google reCaptcha -->
    <div class="row justify-content-center align-items-center" style="padding-top: 20px;">
        <div class="g-recaptcha captcha-resize" data-sitekey="{{config('services.recaptcha.sitekey')}}"></div>
    </div>

    @error('g-recaptcha')
        <div id="captcha_feedback" class="invalid-feedback">
            {{$message}}
        </div>
    @enderror

    <div style="padding-top: 30px;" class="row justify-content-center align-items-center">
        <p>Déja un compte ? <a href="/connexion">Connectez-vous !</a></p>
    </div>
    <div class="row justify-content-center align-items-center">
        <button type="submit" class="btn button-form">Inscription</button>
    </div>
</form>

@endsection