@extends('base')

@section('title')
{{__('Reinitialisation')}}
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
<h1 class="center-title">{{__('Reinitialisation de votre mot de passe')}}</h1>
<form style="padding-top: 60px;" method="POST" action="">
    @csrf
    @if($errors->any())
        <div class="alert alert-warning">
            le mail de réinitialisation n'a pas pu etre envoyé <h1>&#9785</h1>; {{implode('', $errors->all('<div>:message</div>'))}}
        </div>
    @endif
    @if(session()->has('success'))
        <div class="alert alert-success">
                  {{session()->get('success')}}<h1>&#9786</h1>;
        </div>
    @endif
    <div class="form-group col-md-8 mx-auto">
        <label for="email">{{__('Adresse mail')}}</label>
        <input type="text" id="email" name="email" class="input-form @error('email') is-invalid @enderror" required value="{{old('email')}}"/>
        @error('email')
        <div id="email_feedback" class="invalid-feedback">
            {{$message}}
        </div>
        @enderror
    </div>
    <div class="space"><br/><br/></div>
    
    <button type="submit" class="btn button-form mx-auto">{{__('Envoyer')}}</button>

</form>

@endsection