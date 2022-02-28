@extends('base')

@section('title')
    Répondre à un message
@endsection

@section('style')
    <link rel="stylesheet" href="/css/style.css">
@endsection

@section('navbarSequel')
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
@endsection

@section('content')
<h1 class="center-title">Conversation avec Nicolas Dufour sur l'objet : Covoiturage</h1>

<div class="row justify-content-center align-items-center space-bottom-title">
    <div class="field-message col-md-8">
        <div>
            <div class="message-user-left">
                <span>Bonjour, comment vas tu ?</span>
            </div>
            <div>
                <p class="small-text-chat-left">Ecrit par Dorian Bourdon le 24/01/2022 15:45:12</p>
            </div>
        </div>
        <div>
            <div class="message-user-right">
                <span>Bonjour, comment vas tu ? Ceic est un test pour si ca marhe</span>
            </div>
            <div>
                <p class="small-text-chat-right">Ecrit par Nicolas Dufour le 24/01/2022 15:45:12</p>
            </div>
        </div>
        <div>
            <div class="message-user-left">
                <span>Bonjour, comment vas tu ? Ceic est un test pour si ca marhe</span>
            </div>
            <div>
                <p class="small-text-chat-left">Ecrit par Dorian Bourdon le 24/01/2022 15:45:12</p>
            </div>
        </div>

        <div>
            <div class="message-user-left">
                <span>Bonjour, comment vas tu ? Ceic est un test pour si ca marhe</span>
            </div>
            <div>
                <p class="small-text-chat-left">Ecrit par Dorian Bourdon le 24/01/2022 15:45:12</p>
            </div>
        </div>

        <div>
            <div class="message-user-right">
                <span>Bonjour, comment vas tu ? Ceic est un test pour si ca marhe</span>
            </div>
            <div>
                <p class="small-text-chat-right">Ecrit par Nicolas Dufour le 24/01/2022 15:45:12</p>
            </div>
        </div>

        <div>
            <div class="message-user-left">
                <span>Bonjour, comment vas tu ? Ceic est un test pour si ca marhe</span>
            </div>
            <div>
                <p class="small-text-chat-left">Ecrit par Dorian Bourdon le 24/01/2022 15:45:12</p>
            </div>
        </div>

        <div>
            <div class="message-user-right">
                <span>Bonjour, comment vas tu ? Ceic est un test pour si ca marhe</span>
            </div>
            <div>
                <p class="small-text-chat-right">Ecrit par Nicolas Dufour le 24/01/2022 15:45:12</p>
            </div>
        </div>
    </div>
    
</div>
<form>
    <div class="row justify-content-center align-items-center space-bottom-title">
        <div class="col-md-8" style="margin-top: 20px;">
            <div style="display: left; padding: 0;">
                <input type="text" class="input-form-message" name="message" id="message" placeholder="Votre message" aria-describedby="messError">
            </div>
            @error('message')
                <small id="messError" class="form-text text-muted">{{$message}}</small>
            @enderror
        </div>
    </div>

    <div class="row justify-content-center align-items-center" style="padding-top: 20xp;">
        <div class="col-md-8" style="margin-top: 20px;">
            <div style="display: left; padding: 0;">
                <button class="button-form-message">Envoyer</button>
            </div>
        </div>
    </div>

</form>
@endsection