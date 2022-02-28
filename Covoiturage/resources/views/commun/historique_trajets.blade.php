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

<div class="row justify-content-center align-items-center space-bottom-title">
    <div class="table-responsive">
        <table class="table">
            <thead>
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
                <tr class="fond-conducteur-row">
                    <td>24/01/2022</td>
                    <td>Nicolas Dufour</td>
                    <td>Ismail IDBOURHIM</td>
                    <td>Metro Malpassé 13013 Marseille</td>
                    <td>7H50</td>
                    <td>Luminy 13009 Marseille</td>
                    <td>8H20</td>
                    <td><button type="submit" class="btn button-form mx-auto">{{__('Noter')}}</button></td>
                </tr>
            </tbody>
            <tbody>
                <tr class="fond-conducteur-row">
                    <td>24/01/2022</td>
                    <td>Nicolas Dufour</td>
                    <td>Ismail IDBOURHIM</td>
                    <td>Metro Malpassé 13013 Marseille</td>
                    <td>7H50</td>
                    <td>Luminy 13009 Marseille</td>
                    <td>8H20</td>
                    <td><button type="submit" class="btn button-form mx-auto">{{__('Noter')}}</button></td>
                </tr>
            </tbody>
            <tbody>
                <tr class="fond-passager-row">
                    <td>24/01/2022</td>
                    <td>Ismail IDBOURHIM</td>
                    <td>Nicolas Dufour</td>
                    <td>Metro Malpassé 13013 Marseille</td>
                    <td>7H50</td>
                    <td>Luminy 13009 Marseille</td>
                    <td>8H20</td>
                    <td>
                        <div class="col rating-css" >
                            <div class="row" style="white-space:nowrap;  width:3cm; text-shadow: 0 0 3px #000;">
                                <label class="fa fa-star"></label>
                                <label class="fa fa-star"></label>
                                <label class="fa fa-star"></label>
                                <label class="fa fa-star"></label>
                                <label class="fa fa-star"></label>
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
            <tbody>
                <tr class="fond-conducteur-row">
                    <td>24/01/2022</td>
                    <td>Nicolas Dufour</td>
                    <td>Ismail IDBOURHIM</td>
                    <td>Metro Malpassé 13013 Marseille</td>
                    <td>7H50</td>
                    <td>Luminy 13009 Marseille</td>
                    <td>8H20</td>
                    <td>
                        <div class="col rating-css" >
                            <div class="row" style="white-space:nowrap;  width:3cm; text-shadow: 0 0 3px #000;">
                                <label class="fa fa-star"></label>
                                <label class="fa fa-star"></label>
                                <label class="fa fa-star"></label>
                                <label class="fa fa-star"></label>
                                <label class="fa fa-star"></label>
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@endsection