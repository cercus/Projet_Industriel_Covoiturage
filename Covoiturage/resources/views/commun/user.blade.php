@extends('base')

@section('title')
    Mon profil
@endsection

@section('style')
    <link rel="stylesheet" href="/css/style.css">
@endsection

@section('navbarSequel')
    <ul class="navbar-nav mr-auto"> 
        <li class="nav-item">
            <a class="nav-link" href="{{route('user',['idUtilisateur'=>$Utilisateur['idUtilisateur']])}}"> {{ $Utilisateur['prenom'] }} {{ $Utilisateur['nom'] }}</a>
        </li>
    </ul>
    <div class="pmd-user-info ">
        <a href="javascript:void(0);" class="nav-user-img" > 
            @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
            @endif

            <img class="avatar-img rounded-circle" src="/images/avatar_photo.jpg" width="73" height="73" alt="avatar">
        </a>
    </div>
    <div class="nav-item">
        <form method="POST" href="{{route('logout.post')}}">
            @csrf
            <button type="submit" >
                <img  width="30" src="/images/quit.png" height="30" style="float:left" >
            </button>
        </form>
    </div>
@endsection

@section('content')

<h1 class="center-title">Bienvenue {{ $Utilisateur['prenom'] }} {{ $Utilisateur['nom'] }} sur votre profil</h1> 

<div style="text-align:center" class="space-bottom-title">
    <div class="row">
        <div class="col espace-bottom vignets" >
            <a href="{{route('historique_trajets')}}">
                <button type="button" class="button-icon" autofocus>
                    <div>
                        <h3>Trajet effectué</h3>
                    </div>
                    <div class="icon-button">
                        <img src="/images/icons/car-solid.svg" style="float:left" >
                    </div>
                </button>
            </a> 
        </div>
        <div class="col espace-bottom vignets">
            <a href="{{route('modification_profil')}}">
                <button type="button" class="button-icon" autofocus>
                    <div>
                        <h3>Modification profil</h3>
                    </div>
                    <div class="icon-button">
                        <img src="/images/icons/pencil-alt-solid.svg" style="float:left" >
                    </div>
                </button>
            </a>
        </div>
        <div class="col espace-bottom vignets">
            <a href="{{route('messages.all')}}">
                <button type="button" class="button-icon" autofocus>
                    <div>
                        <h3>Mes messages</h3>
                    </div>
                    <div class="icon-button">
                        <img src="/images/icons/envelope-regular.svg" style="float:left" >
                    </div>
                </button>
            </a>
        </div>
        <div class="col espace-bottom vignets">
            <a href="{{route('informations_personnelles')}}">
                <button type="button" class="button-icon" autofocus>
                    <div>
                        <h3>Mes infos</h3>
                    </div>
                    <div class="icon-button">
                        <img src="/images/icons/eye-solid.svg" style="float:left" >
                    </div>
                </button>
            </a>
        </div>
        <div class="col espace-bottom vignets" >
            <button type="button" class="button-icon" autofocus>
                <div>
                    <h3>Trajets disponibles</h3>
                </div>
                <div class="icon-button">
                    <img src="/images/icons/itineraire.svg" style="float:left" >
                </div>
            </button>
        </div>
        <div class="col espace-bottom vignets">
            <a href="{{route('modification_technique')}}">
                <button type="button" class="button-icon" autofocus>
                    <div>
                        <h3>Données techniques</h3>
                    </div>
                    <div class="icon-button">
                        <img src="/images/icons/microchip-solid.svg" style="float:left" >
                    </div>
                </button>
            </a>
        </div>
        <div class="col espace-bottom vignets">
            <a href="{{route('trajets_en_cours')}}">
                <button type="button" class="button-icon" autofocus>
                    <div>
                        <h3>Mes trajets en cours</h3>
                    </div> 
                    <div class="icon-button">
                        <img src="/images/icons/car-side-solid.svg" style="float:left" >
                    </div>
                </button>
            </a>
        </div>
        <div class="col espace-bottom vignets">
            <a href="{{route('proposer_trajet')}}">
                <button type="button" class="button-icon" autofocus>
                    <div>
                        <h3>Proposer un trajet</h3>
                    </div>
                    <div class="icon-button">
                        <img src="/images/icons/plus-solid.svg" style="float:left" width="30%" height="30%">
                        <img src="/images/icons/itineraire.svg" style="float:left" width="80%" height="80%">
                    </div>
                </button>
            </a>
        </div>
        <div class="col espace-bottom vignets">
            <a href="{{route('reservation_en_cours')}}">
                <button type="button" class="button-icon" autofocus>
                    <div>
                        <h3>Reservation en cours</h3>
                    </div>
                    <div class="icon-button">
                        <img src="/images/icons/spinner-solid.svg" style="float:left" >
                    </div>
                </button>
            </a>
        </div>
    </div>
</div>

<script>
    $(function() {
        $('.vignets').addClass("load");
    })
</script>

@endsection
