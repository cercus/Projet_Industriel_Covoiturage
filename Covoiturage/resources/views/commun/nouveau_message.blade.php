@extends('base')

@section('title')
    Ecrire un nouveau message
@endsection

@section('style')
    <link rel="stylesheet" href="/css/style.css">
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
    @endif
@endsection

@section('content')
<h1 class="center-title">Ecrire un nouveau message</h1>

<form method="POST" action="{{route('messages.new_post')}}" style="padding-top: 60px;">
    @csrf
    @if($errors->any())
        <div class="alert alert-warning">
            Le message n'a pas pu être envoyé &#9785;
        </div>
    @endif
    @if(session()->has('success'))
        <div class="alert alert-success">
                  {{session()->get('success')}}&#9786;
        </div>
    @endif
    <div class="form-group col-md-8 mx-auto">
        <label for="destinataire">Destinataire</label>
        <br />
        <select class="input-form input-select  @error('destinataire') is-invalid @enderror" id="destinataire" name="destinataire" required value="{{old('destinataire')}}">
            @foreach($trajetsReservations as $trajetReservation)
            <option value="{{$trajetReservation['idUtilisateur']}}">{{ ucfirst(strtolower($trajetReservation['prenom'])) }} {{ ucfirst(strtolower($trajetReservation['nom'])) }}</option>
            @endforeach
        </select>
        @error('destinataire')
        <div id="objet_feedback" class="invalid-feedback">
            {{$message}}
        </div>
        @enderror
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