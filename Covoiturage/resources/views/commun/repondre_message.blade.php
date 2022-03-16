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
<h1 class="center-title">Conversation sur l'objet : {{ $unMessages[0]['objet'] }}</h1>

<form method="POST" action="{{route('messages.reply_post')}}">
@csrf
<div class="row justify-content-center align-items-center space-bottom-title">
    <div class="field-message col-md-8">
    @foreach($unMessages as $unMessage)
        @if($unMessage['idEmetteur']!=$idProfil)
        <div>
            <div class="message-user-left">
                <span>{{ $unMessage['texteMessage'] }}</span>
            </div>
            <div>
                <p class="small-text-chat-left">
                    Ecrit par 
                    {{ ucfirst(strtolower($unMessage['prenomEmetteur'])) }} {{ ucfirst(strtolower($unMessage['nomEmetteur'])) }}
                     le {{ date('d/m/Y H:i',strtotime($unMessage['dateMessage'])) }}</p>
            </div>
        </div>
        @endif
        @if($unMessage['idEmetteur']==$idProfil)
        <div>
            <div class="message-user-right">
                <span>{{ $unMessage['texteMessage'] }}</span>
            </div>
            <div>
                <p class="small-text-chat-right">
                    Ecrit par 
                    {{ ucfirst(strtolower($unMessage['prenomEmetteur'])) }} {{ ucfirst(strtolower($unMessage['nomEmetteur'])) }}
                     le {{ $unMessage['dateMessage'] }}</p>
            </div>
        </div>
        @endif
    @endforeach
    </div>
    
</div>


<div style="display: none;">
    <input type="text" name="objet" id="objet" 
    value="{{ $unMessages[0]['objet'] }}">
</div>
@if($unMessages[0]['idEmetteur']==$idProfil)
<div style="display: none;">
    <input type="number" name="idEmetteur" id="idEmetteur" 
    value="{{ $unMessages[0]['idEmetteur'] }}">
</div>
<div style="display: none;">
    <input type="number" name="idDestinataire" id="idDestinataire" 
    value="{{ $unMessages[0]['idDestinataire'] }}">
</div>
@endif
@if($unMessages[0]['idDestinataire']==$idProfil)
<div style="display: none;">
    <input type="number" name="idEmetteur" id="idEmetteur" 
    value="{{ $unMessages[0]['idDestinataire'] }}">
</div>
<div style="display: none;">
    <input type="number" name="idDestinataire" id="idDestinataire" 
    value="{{ $unMessages[0]['idEmetteur'] }}">
</div>
@endif
<div style="display: none;">
    <input type="text" name="objet" id="objet" 
    value="{{ $unMessages[0]['objet'] }}">
</div>
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

    <button type="submit" class="btn button-form mx-auto">Envoyer</button>
</form>

@endsection