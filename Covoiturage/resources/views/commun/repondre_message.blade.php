@extends('base')

@section('title')
    Répondre à un message
@endsection

@section('style')
    <link rel="stylesheet" href="/css/style.css">
@endsection

@section('navbarSequel')
    @if(session()->has('user'))
        <div class="pmd-user-info "> 
                <div class="dropdown">
                    <button data-toggle="dropdown" class="dropdown-toggle" type="button" style="background-color: rgb(51, 63, 80); border: 1px solid rgb(51, 63, 80);"><img class="avatar-img rounded-circle" src="/images/avatar_photo.jpg" width="73" height="73" alt="avatar"></button>
                        <div class="dropdown-menu">
                            <li class="sous-menu"><a tabindex="-1">{{session()->get('user')['prenom']}} {{session()->get('user')['nom']}}</a></li>
                            <hr>
                            <li><a tabindex="-1" class="dropdown-item sous-menu" href="{{route('user', ['idUtilisateur' => session()->get('user')['id']])}}">Mon Profil</a></li>
                            <form method="POST" action="{{route('logout.post')}}">@csrf<button class="dropdown-item nav-link" type="submit">Déconnexion</button></form>
                            
                        </div> 
                </div>
        </div>
    @endif
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