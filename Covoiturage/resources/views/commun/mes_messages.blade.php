@extends('base')

@section('title')
    Mes messages
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

<h1 class="center-title">Mes messages</h1>

<div class="row justify-content-center align-items-center space-bottom-title">
    <button class="btn button-form"><a href="{{route('messages.new')}}">Ecrire un nouveau message</button>
</div>

<div class="row justify-content-center align-items-center space-bottom-title">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Destinataire</th>
                    <th>Objet</th>
                    <th>Emetteur</th>
                    <th>Message</th>
                    <th>Etat</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            @foreach($messagesProfil as $messageProfil)
                <tr>
                    <td>{{ date('d/m/Y H:i',strtotime($messageProfil['dateMessage'])) }}</td>
                    <td>{{ ucfirst(strtolower($messageProfil['prenomDestinataire'])) }} {{ ucfirst(strtolower($messageProfil['nomDestinataire'])) }}</td>
                    <td>{{ $messageProfil['objet'] }}</td>
                    <td>{{ ucfirst(strtolower($messageProfil['prenomEmetteur'])) }} {{ ucfirst(strtolower($messageProfil['nomEmetteur'])) }}</td>
                    <td>{{ $messageProfil['texteMessage'] }}</td>
                    <td><p class="balise-message balise-message-lu">Lu</p></td>
                    <td style="display: flex;" class="justify-content-center align-items-center">
                        <a href="{{route('messages.reply', ['msgId'=>$messageProfil['idMessage']])}}">
                            <img src="/images/check_button.png" width="40" height="40">  
                        </a>
                        <form method="POST" action="{{route('messagessup.all')}}">
                            @csrf
                            <div style="display: none;">
                                <input type="number" name="idMessage" id="idMessage" 
                                value="{{ $messageProfil['idMessage'] }}">
                            </div>
                            <button type="submit" class="button-fond">
                                <img src="/images/cancel_button.png" width="40" height="40">
                            </button>
                        </form>          
                    </td>
                </tr>  
            @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection