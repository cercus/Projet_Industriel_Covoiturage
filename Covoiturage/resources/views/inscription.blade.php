@extends('base')

@section('title')
Inscription
@endsection

@section('style')
    <link rel="stylesheet" href="css/style.css">
@endsection

@section('navbarSequel')
    @if(session()->has('user'))

        <div class="pmd-user-info "> 
                <div class="dropdown">
                    <button data-toggle="dropdown" class="dropdown-toggle" type="button" style="background-color: rgb(51, 63, 80); border: 1px solid rgb(51, 63, 80);"><img class="avatar-img rounded-circle" src="/images/avatar_photo.jpg" width="73" height="73" alt="avatar"></button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <li class="sous-menu"><a tabindex="-1">{{session()->get('user')['prenom']}} {{session()->get('user')['nom']}}</a></li>
                            <hr>
                            <li><a tabindex="-1" class="dropdown-item sous-menu" href="{{route('user', ['idUtilisateur' => session()->get('user')['id']])}}">Mon Profil</a></li>
                            <form method="POST" action="{{route('logout.post')}}">@csrf<button class="dropdown-item nav-link" type="submit">Déconnexion</button></form>
                            
                        </div> 
                </div>
        </div>
    @else
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="{{route('inscription')}}">Inscription</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('connexion')}}">Connexion</a>
            </li>
        </ul>
    @endif
@endsection

@section('content')
<h1 class="center-title">S'inscrire sur le site</h1>

<form id="register"method="POST" action="{{route('store.inscription')}}">
    @csrf
    @if($errors->any())
        <div class="alert alert-warning">
           Impossible de s'inscrire. &#9785;
        </div>
    @endif
    @if(session()->has('success'))
        <div class="alert alert-success">
                  {{session()->get('success')}}&#9786;
        </div>
    @endif

    <div class="col-md-8 mx-auto space-bottom_title">

        <!-- Nom -->
        <div class="col-right-input">
            <label for="nom">Nom*</label>
            <input type="text" class="input-form @error('nom') is-invalid @enderror" id="nom" name="nom" required value="{{old('nom')}}" aria-describedby="nomError">
            @error('nom')
                <span id="nomError" class="form-text text-muted">{{$message}}</span>
            @enderror
        </div>

        <!-- prenom -->
        <div class="col-left-input">
            <label for="prenom">Prénom*</label>
            <input type="text" class="input-form @error('prenom') is-invalid @enderror" id="prenom" name="prenom" required value="{{old('prenom')}}" aria-describedby="prenomError">
            @error('prenom')
                <span id="prenomError" class="form-text text-muted">{{$message}}</span>
            @enderror
        </div>      
    </div>

    <div class="col-md-8 mx-auto" style="padding-top: 20px;">

        <!-- Adresse mail -->
        <div class="col-right-input">
            <label for="email">Adresse mail*</label>
            <input type="email" class="input-form @error('email') is-invalid @enderror" id="email" name="email" required value="{{old('email')}}" aria-describedby="emailError">
            @error('email')
                <span id="emailError" class="form-text text-muted">{{$message}}</span>
            @enderror
        </div>

        <!-- Date de naissance -->
        <div class="col-left-input">
            <label for="dateNaiss">Date de naissance</label>
            <input type="date" class="input-form @error('dateNaiss') is-invalid @enderror" id="dateNaiss" name="dateNaiss" value="{{old('dateNaiss')}}" aria-describedby="dateError">
            @error('date')
                <span id="dateError" class="form-text text-muted">{{$message}}</span>
            @enderror
        </div>  
    </div>

    <div class="col-md-8 mx-auto" style="padding-top: 20px;">

        <!-- Mot de passe -->
        <div class="col-right-input">
            <label for="mdp">Mot de passe*</label>
            <input type="password" class="input-form @error('mdp') is-invalid @enderror" id="mdp" name="mdp" required aria-describedby="mdpError">
            @error('mdp')
                <span id="mdpError" class="text-danger">{{$message}}</span>
            @enderror
        </div>    

        <!-- Mot de passe 2 -->
        <div class="col-left-input">
            <label for="repeterMdp">Répétez mot de passe*</label>
            <input type="password" class="input-form @error('repeterMdp') is-invalid @enderror" id="repeterMdp" name="repeterMdp" required aria-describedby="mdp2Error">
            @error('repeterMdp')
                <span id="mdp2Error" class="form-text text-muted">{{$message}}</span>
            @enderror
        </div>
    </div>

    <div class="col-md-8 mx-auto" style="padding-top: 20px;">

        <!-- Identitié -->
        <div class="col-right-input">
            <label for="nni"> numero d'identité (NNI)</label>
            <input type="text" placeholder="939049615866" class="input-form @error('nni') is-invalid @enderror" id="nni" name="nni" aria-describedby="nniError">
            @error('nni')
                <small id="nniError" class="form-text text-muted">{{$message}}</small>
            @enderror
        </div>

        <!-- Numéro de téléphone -->
        <div class="col-left-input">
            <label for="telephone">Numéro de téléphone*</label>
            <input type="tel" class="input-form @error('telephone') is-invalid @enderror" id="telephone" name="telephone" required placeholder="01 02 03 04 05" pattern="(([0-9]{2}\s)|[0-9]{2})(([0-9]{2}\s)|[0-9]{2})(([0-9]{2}\s)|[0-9]{2})(([0-9]{2}\s)|[0-9]{2})(([0-9]{2}\s)|[0-9]{2})" aria-describedby="telError">    
            @error('telephone')
                <span id="telError" class="form-text text-muted">{{$message}}</span>
             @enderror
        </div>
    </div>
    <div>

        <!-- description -->
        <div class="col-md-8 mx-auto" style="padding-top: 20px;">
            <label for="description">description visible par les abonnés</label>
            <textarea class="form-control textarea-form @error('description') is-invalid @enderror" id="description" name="description" rows=3></textarea>
        </div>
    </div>

    <!-- Photo de profil -->
    <div class="col-md-8 mx-auto" style="padding-top: 20px;">
        <label for="profil">Photo de profil</label>
        <input type="file" class="input-form-file @error('profil') is-invalid @enderror" id="profil" name="profil" aria-describedby="profilError">   
        @error('profil')
            <span id="profilError" class="form-text text-muted">{{$message}}</span>
        @enderror
    </div>

    <h3 style="padding-top: 50px;" class="text-center">Informations en plus si vous possédez une voiture</h3>

    <div class="col-md-8 mx-auto" style="padding-top: 20px;">

        <!-- Plaque d'immatriculation -->
        <div class="col-right-input">
            <label for="immatriculation">Plaque d'immatriculation</label>
            <input type="text" class="input-form @error('immatriculation') is-invalid @enderror" id="immatriculation" name="immatriculation" aria-describedby="immatError">
            @error('immatriculation')
                <span id="immatError" class="form-text text-muted">{{$message}}</span>
            @enderror
        </div>
            
        <!-- numéro du permis de conduire -->
        <div class="col-left-input">
            <label for="numPermis">numéro du permis</label>
            <input type="text" placeholder="950713706342" class="input-form @error('numPermis') is-invalid @enderror" id="numPermis" name="numPermis" aria-describedby="numPermisError">   
            @error('numPermis')
                <small id="numPermisError" class="form-text text-muted">{{$message}}</small>
            @enderror
        </div>
    </div>

    <div class="col-md-8 mx-auto" style="padding-top: 20px;">

        <!-- Marque de la voiture -->
        <div class="col-right-input">
            <label for="marqueVoiture">Marque de la voiture</label>
            <input type="text" class="input-form @error('marqueVoiture') is-invalid @enderror" id="marqueVoiture" name="marqueVoiture" value="{{old('marqueVoiture')}}" aria-describedby="marqueError">
            @error('marqueVoiture')
                <span id="marqueError" class="form-text text-muted">{{$message}}</span>
            @enderror
        </div>

        <!-- Couleur de la voiture -->
        <div class="col-left-input">
            <label for="couleurVoiture">Couleur de la voiture</label>
            <input type="text" class="input-form @error('couleurVoiture') is-invalid @enderror" id="couleurVoiture" name="couleurVoiture" value="{{old('couleurVoiture')}}" aria-describedby="couleurError">
            @error('couleurVoiture')
                <span id="couleurError" class="form-text text-muted">{{$message}}</span>
            @enderror
        </div>
    </div>

    <div class="col-md-8 mx-auto" style="padding-top: 20px;">
        <!-- Nombre de place max dans la voiture -->
        <div class="col-right-input">
            <label for="nbPlace">Nombre de place max</label>
            <input type="number" class="input-form @error('nbPlace') is-invalid @enderror" id="nbPlace" name="nbPlace" value="{{old('nbPlace')}}" aria-describedby="placeError">
            @error('nbPlace')
                <span id="placeError" class="form-text text-muted">{{$message}}</span>
            @enderror
        </div>
            <!-- option fumer et animal-->

                <div class="col-left-input">
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
    </div>

     <!-- Photo de la voiture -->
    <div class="col-md-8 mx-auto" style="padding-top: 20px;">
        <label for="photoVoiture">Photo de la voiture</label>
        <input type="file" class="input-form-file @error('photoVoiture') is-invalid @enderror" id="photoVoiture" name="photoVoiture" aria-describedby="photoVError">
        @error('photoVoiture')
            <span id="photoVError" class="form-text text-muted">{{$message}}</span>
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