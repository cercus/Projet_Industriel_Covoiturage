@extends('base')

@section('title')
    Confirmation d'annuler mon trajet
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
    <h1 class="center-title">
        Confirmation
    </h1>
    <div class="col-md-8 border border-dark ml-auto mr-auto mt-4">
        <div class="media mt-4 ">
            <img src="/images/confirmation.png" class="bg-transparent" alt="..." width="120" height="120">
            <div class="media-body">
              <p class="mt-4 mb-4">Vous avez annulé votre trajet !</p>
              <p>Votre message sera transmis aux passagers</p>
            </div>
        </div>
        <div class="col-md-6 mt-3 btn-profil">
            <a href="{{route('trajets_en_cours', $idConducteur)}}">
                <button type="submit" class="btn button-form mb-4">Mes trajets en cours</button>
            </a>
        </div>
    </div>
    
@endsection