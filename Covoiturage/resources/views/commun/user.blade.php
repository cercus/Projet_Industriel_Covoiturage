@extends('base')

@section('title')
    Mon profil
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

<h1 class="center-title">Bienvenue {{session()->get('user')['prenom']}} {{session()->get('user')['nom']}} sur votre profil</h1>

<div style="text-align:center" class="space-bottom-title">
    <div class="row">
        <div class="col espace-bottom vignets" >
            <a href="{{route('historique_trajets', ['idUtilisateur' => session()->get('user')['id']])}}">
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
            <a href="{{route('modification_profil', ['idUtilisateur' => session()->get('user')['id']])}}">
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
            <a href="{{route('informations_personnelles', ['idUtilisateur' => session()->get('user')['id']])}}">
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
            <a href="{{route('recherche_trajet')}}">
                <button type="button" class="button-icon" autofocus>
                    <div>
                        <h3>Trajets disponibles</h3>
                    </div>
                    <div class="icon-button">
                        <img src="/images/icons/itineraire.svg" style="float:left" >
                    </div>
                </button>
            </a>
        </div>
        <div class="col espace-bottom vignets">
            <a href="{{route('modification_technique', ['idUtilisateur' => session()->get('user')['id']])}}">
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
            <a href="{{route('reservation_en_cours', ['idPassager' => session()->get('user')['id']])}}">
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
        @if($conducteur)
            <div class="col espace-bottom vignets">
                <a href="{{route('trajets_en_cours', ['idConducteur'=>session()->get('user')['id']])}}">
                    <button type="button" class="button-icon" autofocus>
                        <div>
                            <h3>Mes trajets à venir</h3>
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
        @endif
    </div>
</div>

<script>
    $(function() {
        $('.vignets').addClass("load");
    })
</script>

@endsection
