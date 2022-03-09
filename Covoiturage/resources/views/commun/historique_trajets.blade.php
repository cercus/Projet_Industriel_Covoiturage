@extends('base')

@section('title')
    Historique de mes trajets
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
                            <td style="font-size: 12px; padding-bottom: -10px;">{{$conducteur['date']}}</td>
                            <td style="font-size: 12px; padding-bottom: -10px; ">{{$conducteur['conducteur']}}</td>
                            <td style="font-size: 12px; padding-bottom: -10px; ">{{$conducteur['passager']}}</td>
                            <td style="font-size: 12px; padding-bottom: -10px; ">{{$conducteur['adresseDepart']}}</td>
                            <td style="font-size: 12px; padding-bottom: -10px; ">{{$conducteur['heureDepart']}}</td>
                            <td style="font-size: 12px; padding-bottom: -10px; ">{{$conducteur['adresseArrivee']}}</td>
                            <td style="font-size: 12px; padding-bottom: -10px; ">{{$conducteur['heureArrivee']}}</td>
                            @if($conducteur['notation'] < 0)
                                <td style="font-size: 12px; padding-bottom: -10px;"><button type="submit" class="btn button-form mx-auto small-button-form">{{__('Noter')}}</button></td>
                            @else
                            <td>
                                @for ($i = 0; $i < $conducteur['notation']; $i++)
                                    <label class="fa fa-star" style="color: #ffe400; text-shadow: 0 0 3px #000"></label>
                                @endfor
                                @for($i = 5; $i > $conducteur['notation']; $i--)
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
                    @foreach ((array)$trajetsPassager as $passager)
                        <tr>
                            <td style="font-size: 12px; padding-bottom: -10px;">{{$passager['date']}}</td>
                            <td style="font-size: 12px; padding-bottom: -10px;">{{$passager['conducteur']}}</td>
                            <td style="font-size: 12px; padding-bottom: -10px;">{{$passager['passager']}}</td>
                            <td style="font-size: 12px; padding-bottom: -10px;">{{$passager['adresseDepart']}}</td>
                            <td style="font-size: 12px; padding-bottom: -10px;">{{$passager['heureDepart']}}</td>
                            <td style="font-size: 12px; padding-bottom: -10px;">{{$passager['adresseArrivee']}}</td>
                            <td style="font-size: 12px; padding-bottom: -10px;">{{$passager['heureArrivee']}}</td>
                            @if($passager['notation'] < 0)
                                <td style="font-size: 12px; padding-bottom: -10px;"><button type="submit" class="btn button-form mx-auto small-button-form">{{__('Noter')}}</button></td>
                            @else
                            <td>
                                @for ($i = 0; $i < $passager['notation']; $i++)
                                    <label class="fa fa-star" style="color: #ffe400; text-shadow: 0 0 3px #000"></label>
                                @endfor
                                @for($i = 5; $i > $passager['notation']; $i--)
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