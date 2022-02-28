@extends('base')

@section('title')
{{__('Reinitialisation')}}
@endsection

@section('style')
    <link rel="stylesheet" href="css/style.css">
@endsection
    
@section('navbarSequel')
    @if (session()->has('user'))
        <ul class="navbar-nav mr-auto"> 
            <li class="nav-item">
                <a class="nav-link" href="{{route('user')}}">Ismail IDBOURHIM</a>
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