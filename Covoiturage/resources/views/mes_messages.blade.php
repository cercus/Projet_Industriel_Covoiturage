@extends('base')

@section('title')
    Mes messages
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

<h1 class="center-title">Mes messages</h1>

<div class="row justify-content-center align-items-center" style="padding-top: 20px;">
    <form method="POST" action="{{route('message.new')}}">
        @csrf
        <button type="submit" class="btn button-form">Ecrire un nouveau message</button>
    </form>
</div>

<div class="row justify-content-center align-items-center" style="padding-top: 20px;">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Destinataire</th>
                    <th>Objet</th>
                    <th>Identifiant du trajet</th>
                    <th>Message</th>
                    <th>Etat</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>24/01/2022 16:54:12</td>
                    <td>Nicolas Dufour</td>
                    <td>Covoiturage</td>
                    <td>12</td>
                    <td>Bonjour, j'ai un petit...</td>
                    <td><p class="balise-lu">Lu</p></td>
                    <td style="display: flex;" class="justify-content-center align-items-center">
                        <form>@csrf<button type="submit" class="button-fond"><img src="/images/check_button.png"></button></form>
                        <form>@csrf<button type="submit" class="button-fond"><img src="/images/cancel_button.png"></button></form>
                    </td>
                </tr>

                <tr>
                    <td>24/01/2022 16:57:12</td>
                    <td>Jacques Freder</td>
                    <td>Salut</td>
                    <td>4</td>
                    <td>Hello, petit probleme...</td>
                    <td><p class="balise-non-lu">Non lu</p></td>
                    <td style="display: flex;" class="justify-content-center align-items-center">
                        <form>@csrf<button type="submit" class="button-fond"><img src="/images/check_button.png"></button></form>
                        <form>@csrf<button type="submit" class="button-fond"><img src="/images/cancel_button.png"></button></form>
                    </td>
                </tr>

                <tr>
                    <td>24/01/2022 16:54:12</td>
                    <td>Nicolas Dufour</td>
                    <td>Covoiturage</td>
                    <td>12</td>
                    <td>Bonjour, j'ai un petit...</td>
                    <td><p class="balise-lu">Lu</p></td>
                    <td style="display: flex;" class="justify-content-center align-items-center">
                        <form>@csrf<button type="submit" class="button-fond"><img src="/images/check_button.png"></button></form>
                        <form>@csrf<button type="submit" class="button-fond"><img src="/images/cancel_button.png"></button></form>
                    </td>
                </tr>

                <tr>
                    <td>24/01/2022 16:54:12</td>
                    <td>Nicolas Dufour</td>
                    <td>Covoiturage</td>
                    <td>12</td>
                    <td>Bonjour, j'ai un petit...</td>
                    <td><p class="balise-lu">Lu</p></td>
                    <td style="display: flex;" class="justify-content-center align-items-center">
                        <form>@csrf<button type="submit" class="button-fond"><img src="/images/check_button.png"></button></form>
                        <form>@csrf<button type="submit" class="button-fond"><img src="/images/cancel_button.png"></button></form>
                    </td>
                </tr>

                <tr>
                    <td>24/01/2022 16:54:12</td>
                    <td>Nicolas Dufour</td>
                    <td>Covoiturage</td>
                    <td>12</td>
                    <td>Bonjour, j'ai un petit...</td>
                    <td><p class="balise-lu">Lu</p></td>
                    <td style="display: flex;" class="justify-content-center align-items-center">
                        <form>@csrf<button type="submit" class="button-fond"><img src="/images/check_button.png"></button></form>
                        <form>@csrf<button type="submit" class="button-fond"><img src="/images/cancel_button.png"></button></form>
                    </td>
                </tr>

                <tr>
                    <td>24/01/2022 16:54:12</td>
                    <td>Nicolas Dufour</td>
                    <td>Covoiturage</td>
                    <td>12</td>
                    <td>Bonjour, j'ai un petit...</td>
                    <td><p class="balise-lu">Lu</p></td>
                    <td style="display: flex;" class="justify-content-center align-items-center">
                        <form>@csrf<button type="submit" class="button-fond"><img src="/images/check_button.png"></button></form>
                        <form>@csrf<button type="submit" class="button-fond"><img src="/images/cancel_button.png"></button></form>
                    </td>
                </tr>

                
            </tbody>
        </table>
    </div>
</div>

@endsection