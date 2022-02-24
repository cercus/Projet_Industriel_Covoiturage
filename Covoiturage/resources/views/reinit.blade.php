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
<h1 class="center-title">{{__('Reinitialisation')}}</h1>

<div style="padding-top: 60px; text-indent: 30px;" class="col-md-8 mx-auto">
    {{__('Réinitialisation de votre mot de passe.')}}
</div>

<form style="padding-top: 60px;" method="POST" action="{{route('store.question')}}">
    @csrf
    @if($errors->any())
        <div class="alert alert-warning">
            La question n'a pas pu etre posé &#9785; {{implode('', $errors->all('<div>:message</div>'))}}
        </div>
    @endif
    @if(session()->has('success'))
        <div class="alert alert-success">
                  {{session()->get('success')}}&#9786;
        </div>
    @endif
    <div class="form-group col-md-8 mx-auto">
        <label for="email">{{__('Adresse mail')}}</label>
        <input type="email" id="email" name="email" class="input-form @error('email') is-invalid @enderror" required value="{{old('email')}}"/>
    </div>

    <div class="form-group col-md-8 mx-auto">
        <label for="objet">{{__('Objet')}}</label>
        <input type="text" id="objet" name="objet" class="input-form @error('objet') is-invalid @enderror" required value="{{old('objet')}}"/>
        @error('objet')
        <div id="objet_feedback" class="invalid-feedback">
            {{$message}}
        </div>
        @enderror
    </div>

    <div class="form-group col-md-8 mx-auto">
        <label for="message">{{__('Message')}}</label>
        <textarea class="form-control textarea-form @error('message') is-invalid @enderror" id="message" name="message" rows=3></textarea>
        @error('message')
        <div id="message_feedback" class="invalid-feedback">
            {{$message}}
        </div>
        @enderror
    </div>

    <button type="submit" class="btn button-form mx-auto">{{__('Envoyer')}}</button>
</form>

@endsection