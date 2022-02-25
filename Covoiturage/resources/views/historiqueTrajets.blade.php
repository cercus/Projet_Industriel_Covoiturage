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
                <a class="nav-link" href="#">Ismail IDBOURHIM</a>
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

<div class="row justify-content-center align-items-center" style="padding-top: 20px;">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Conducteur</th>
                    <th>Passager</th>
                    <th>IdAdresse départ</th>
                    <th>Heure départ</th>
                    <th>Adresse destination</th>
                    <th>Heure d'arrivée</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr style="background-color: rgb(247,206,151) ">
                    <td>24/01/2022</td>
                    <td>Nicolas Dufour</td>
                    <td>Ismail IDBOURHIM</td>
                    <td>Metro Malpassé 13013 Marseille</td>
                    <td>7H50</td>
                    <td>Luminy 13009 Marseille</td>
                    <td>8H20</td>
                    <td></td>
                </tr>
            </tbody>
            <tbody>
                <tr style="background-color: rgb(247,206,151) ">
                    <td>24/01/2022</td>
                    <td>Nicolas Dufour</td>
                    <td>Ismail IDBOURHIM</td>
                    <td>Metro Malpassé 13013 Marseille</td>
                    <td>7H50</td>
                    <td>Luminy 13009 Marseille</td>
                    <td>8H20</td>
                    <td></td>
                </tr>
            </tbody>
            <tbody>
                <tr style="background-color: rgb(251, 229, 200)">
                    <td>24/01/2022</td>
                    <td>Ismail IDBOURHIM</td>
                    <td>Nicolas Dufour</td>
                    <td>Metro Malpassé 13013 Marseille</td>
                    <td>7H50</td>
                    <td>Luminy 13009 Marseille</td>
                    <td>8H20</td>
                    <td></td>
                </tr>
            </tbody>
            <tbody>
                <tr style="background-color: rgb(247,206,151) ">
                    <td>24/01/2022</td>
                    <td>Nicolas Dufour</td>
                    <td>Ismail IDBOURHIM</td>
                    <td>Metro Malpassé 13013 Marseille</td>
                    <td>7H50</td>
                    <td>Luminy 13009 Marseille</td>
                    <td>8H20</td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@endsection