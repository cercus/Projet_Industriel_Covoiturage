@extends('base')

@section('title')
Confirmation
@endsection

@section('style')
    <link rel="stylesheet" href="/css/style.css">
@endsection
           
@section('navbarSequel')
    <ul class="navbar-nav mr-auto">
        <li class="nav-item">
            <a class="nav-link" href="#">Inscription</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">Connexion</a>
        </li>
    </ul>
@endsection

@section('content')

<div>
    <h1 class="center-title">Confirmation</h1>
</div>

<div class="bordureAnnulation">
<div class="floatLeft">  
<img src="{{URL::asset('images/confirmation.GIF')}}" class="confirmationImg">
</div>
<div> 
<p class="textAnnulation">Vous avez annulé votre réservation <br> Votre message sera transmis au conducteur</p>
</div>

<div>
<button type="submit" class="button-annulation">Profil</button>
</div>
</div>

@endsection