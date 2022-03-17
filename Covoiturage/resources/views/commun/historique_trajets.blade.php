
@extends('base')

@section('title')
    Historique de mes trajets
@endsection

@section('style')
    <link rel="stylesheet" href="/css/style.css">
@endsection

@section('navbarSequel')
    @if(session()->has('user'))
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="{{route('logout.post')}}">Déconnexion</a>
                <!--<form method="POST" action="{{route('logout.post')}}">@csrf<button type="submit">Déconnexion</button></form>-->
            </li>
        </ul>
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

<h1 class="center-title">Historique de mes trajets</h1>
<h3 class="center-title" style="padding-top: 30px;">Trajets en tant que conducteur</h3>
<div class="row justify-content-center align-items-center space-bottom-title">
    <div class="table-responsive">
        <table class="table table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>Date</th>
                    <th>Conducteur</th>
                    <th>Passager</th>
                    <th>Adresse départ</th>
                    <th>Heure départ</th>
                    <th>Adresse destination</th>
                    <th>Heure d'arrivée</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @if(count($trajetsConducteur) == 0)
                    <tr>
                        <td>----</td>
                        <td>----</td>
                        <td>----</td>
                        <td>----</td>
                        <td>----</td>
                        <td>----</td>
                        <td>----</td>
                        <td>----</td>
                    </tr>
                @else
                    
                    @foreach ((array)$trajetsConducteur as $conducteur)
                        <tr>
                            <td style="font-size: 12px; padding-bottom: -10px;">{{explode(' ', $conducteur['dateHeureDepart'])[0]}}</td>
                            <td style="font-size: 12px; padding-bottom: -10px; ">{{$conducteur['conducteur']}}</td>
                            <td style="font-size: 12px; padding-bottom: -10px; ">{{$conducteur['passager']}}</td>
                            <td style="font-size: 12px; padding-bottom: -10px; ">{{$conducteur['adresseDepart']}}</td>
                            <td style="font-size: 12px; padding-bottom: -10px; ">{{explode(' ', $conducteur['dateHeureDepart'])[1]}}</td>
                            <td style="font-size: 12px; padding-bottom: -10px; ">{{$conducteur['adresseArrivee']}}</td>
                            <td style="font-size: 12px; padding-bottom: -10px; ">{{explode(' ', $conducteur['dateHeureArrivee'])[1]}}</td>
                            @if($conducteur['note'] < 0)
                                <td style="font-size: 12px; padding-bottom: -10px;"><a href="/commun/notation_conducteur/{{$conducteur['idPassager']}}/{{$conducteur['idReservation']}}" class="btn button-form mx-auto small-button-form">{{__('Noter')}}</a></td>
                            @else
                            <td>
                                @for ($i = 0; $i < $conducteur['note']; $i++)
                                    <label class="fa fa-star" style="color: #ffe400; text-shadow: 0 0 3px #000"></label>
                                @endfor
                                @for($i = 5; $i > $conducteur['note']; $i--)
                                <label class="fa fa-star"></label>
                                @endfor
                            </td>
                            @endif
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>

<h3 class="center-title">Trajets en tant que passager</h3>
<div class="row justify-content-center align-items-center space-bottom-title">
    <div class="table-responsive">
        <table class="table table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>Date</th>
                    <th>Conducteur</th>
                    <th>Passager</th>
                    <th>Adresse départ</th>
                    <th>Heure départ</th>
                    <th>Adresse destination</th>
                    <th>Heure d'arrivée</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @if(count($trajetsPassager) == 0)
                    <tr>
                        <td>----</td>
                        <td>----</td>
                        <td>----</td>
                        <td>----</td>
                        <td>----</td>
                        <td>----</td>
                        <td>----</td>
                        <td>----</td>
                    </tr>
                @else
                    @foreach ($trajetsPassager as $passager)
                        <tr>
                            <td style="font-size: 12px; padding-bottom: -10px;">{{explode(' ', $passager['dateHeureRDV'])[0]}}</td>
                            <td style="font-size: 12px; padding-bottom: -10px;">{{$passager['conducteur']}} </td>
                            <td style="font-size: 12px; padding-bottom: -10px;">{{$passager['passager']}} </td>
                            <td style="font-size: 12px; padding-bottom: -10px;">{{$passager['adresseDepart']}}</td>
                            <td style="font-size: 12px; padding-bottom: -10px;">{{explode(' ', $passager['dateHeureRDV'])[1]}}</td>
                            <td style="font-size: 12px; padding-bottom: -10px;">{{$passager['adresseArrivee']}}</td>
                            <td style="font-size: 12px; padding-bottom: -10px;">{{explode(' ', $passager['dateHeureArrivee'])[1]}}</td>
                            @if($passager['note'] < 0)
                                <td style="font-size: 12px; padding-bottom: -10px;"><a href="/commun/notation_passager/{{$passager['idConducteur']}}/{{$passager['idReservation']}}" class="btn button-form mx-auto small-button-form">{{__('Noter')}}</a></td>
                            @else
                            <td>
                                @for ($i = 0; $i < $passager['note']; $i++)
                                    <label class="fa fa-star" style="color: #ffe400; text-shadow: 0 0 3px #000"></label>
                                @endfor
                                @for($i = 5; $i > $passager['note']; $i--)
                                <label class="fa fa-star"></label>
                                @endfor
                            </td>
                            @endif
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>

@endsection
