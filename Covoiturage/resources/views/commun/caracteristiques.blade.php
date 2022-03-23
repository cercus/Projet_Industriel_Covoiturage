@extends('base')

@section('title')
Caractéristiques
@endsection

@section('style')
    <link rel="stylesheet" href="/css/style.css">
@endsection

@section('navbarSequel')
    <ul class="navbar-nav mr-auto">
        <li class="nav-item">
            <a class="nav-link" href="{{route('user', ['idUtilisateur' => session()->get('user')['id']])}}">{{session()->get('user')['prenom']}} {{session()->get('user')['nom']}} </a>
        </li>
    </ul>
    <div class="pmd-user-info ">
        <a href="javascript:void(0);" class="nav-user-img" >
            <img class="avatar-img rounded-circle" src="/images/avatar_photo.jpg" width="73" height="73" alt="avatar">
        </a>
    </div>
@endsection

@section('content')
<h1 class="center-title">informations sur {{ ucfirst(strtolower($notations[0]['prenomNote'])) }} {{ ucfirst(strtolower($notations[0]['nomNote'])) }} </h1>
<form>
    <!-- utilisateur  -->
    <div class="row ">
        <div class="pmd-user-info col pl-5 center-title">

            <!-- photo -->
            <a href="#" class="nav-user-img" >
                <img class="avatar-img rounded-circle mr-3" src="/images/avatar_photo.jpg" width="73" height="73" alt="avatar"><br/>
            </a>


            <!-- nom du conducteur -->
            <span class="text-h6">{{ ucfirst(strtolower($notations[0]['prenomNote'])) }} {{ ucfirst(strtolower($notations[0]['nomNote'])) }}</span>
        </div>
        @if ($voitureConducteur!=Null)
                <div class="col text-h7">
                    <!-- nbr de place -->
                    <div>
                        Nbre de place Max : <a class ="h6" style="color:brown"><strong>{{ $voitureConducteur['nbPlaceMax']}}</strong></a>
                    </div>

                    <!-- modele et parque du vehicule -->
                    <div>
                        type de véhicule : <a class ="h6" style="color:brown"><strong>{{ $voitureConducteur['marqueModelVoiture']}}</strong></a>
                    </div>

                    <!-- couleur du vehicule -->
                    <div>
                        Couleur du véhicule : <a class ="h6" style="color:brown"><strong>{{ $voitureConducteur['couleurVoiture']}}</strong></a>
                    </div>

                    <!-- immatriculation -->
                    <div>
                        immatriculation : <a class ="h6" style="color:brown"><strong>{{ $voitureConducteur['immatriculation']}}</strong></a>
                    </div>

                    <!-- photo de la voiture -->
                </div>

                <div class="col ">
                    <img class="avatar-img rounded-circle" src="/images/voiture.jpg" width="100" height="73" alt="avatar">
                </div>
        @endif

        <!-- notation d'un utilisateur -->

            <div class="mr-5 h3">
                @for ($i = 0; $i < $noteUtilisateur; $i++)
                    <label class="fa fa-star" style="color: #ffe400; text-shadow: 0 0 3px #000"></label>
                @endfor
                @for($i = 5; $i > $noteUtilisateur; $i--)
                    <label class="fa fa-star"></label>
                @endfor
                <br>
                {{ round(($sumNoteUtilisateur['sumNote']/$countNoteUtilisateur['countNote'])*10)/10 }}  /  5
            </div>


    </div>
    <!-- séparateur -->
    <div class="h-divider"></div>

<!-- div global -->
@foreach ((array)$notations as $notation)
    <div class="border border-dark">
        <div class="row ml-5 mt-3">
            <div class="v-list-item__title">
                <div class=" text-h6">
                    {{ strftime('%a %d %b',strtotime($notation['DateHeureRDV'])) }}
                </div>
                <div class="text-body-2 h5">
                    {{ date('H:i',strtotime($notation['DateHeureRDV'])) }}
                </div>
            </div>

            <!-- trajet -->
            <div class="col-md-7 detail-trajet">
                <div class="row">
                    <div class="col-md-5 text-center lieu-depart">
                        <span>{{ $notation['numRueRencontre']}}
                              {{ $notation['adresseRueRencontre']}}<br>
                              {{ $notation['cPRencontre']}}
                              {{ ucfirst($notation['villeRencontre'])}}</span>
                    </div>
                    <div class="col-md-2 pl-2 temps-image">
                        <!-- photo de destination -->
                        <img src="/images/trajet_bleu.png" width="74" height="17" alt=""/>
                    </div>
                    <div class="col-md-5 text-center lieu-arrive">
                        <span>{{ $notation['numRueDepot']}} 
                            {{ $notation['adresseRueDepot']}}<br>
                            {{ $notation['cPDepot']}}
                            {{ ucfirst($notation['villeDepot'])}}</span>
                    </div>
                </div>
            </div>

            <!-- prix -->
            <div class="col-md-1 prix">
                {{ $notation['prixResa']}} €
            </div>

        </div>
        <!-- séparateur -->
        <div class="h-divider"></div>

        <!-- Conduteur et passager -->
        <div class="col-md-3">

                <div class="col-md ">
                    Conducteur : <a class ="h6" style="color:brown"><strong>{{ ucfirst(strtolower($notation['prenomConducteur']))}} {{ ucfirst(strtolower($notation['nomConducteur']))}}</strong></a>
                    Passager   : <a class ="h6" style="color:brown"><strong>{{ ucfirst(strtolower($notation['prenomPassager']))}} {{ ucfirst(strtolower($notation['nomPassager']))}}</strong></a>
                </div>
        </div>
        <div class="row" >

            <div class="ml-5 mt-2">
                @for ($i = 0; $i < $notation['note']; $i++)
                    <label class="fa fa-star" style="color: #ffe400; text-shadow: 0 0 3px #000"></label>
                @endfor
                @for($i = 5; $i > $notation['note']; $i--)
                    <label class="fa fa-star"></label>
                @endfor
            </div>
            <div class=" ml-5 mr-3 h3">
                {{ $notation['texteMessage']}}
            </div>

        </div>
    </div>
    <div>. </div>
@endforeach

@endsection