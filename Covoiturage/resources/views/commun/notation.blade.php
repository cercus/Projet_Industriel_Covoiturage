@extends('base')

@section('title')
    Notations
@endsection

@section('style')
    <link rel="stylesheet" href="/css/style.css">
@endsection

@section('navbarSequel')
    @if(session()->has('user'))
        <div class="pmd-user-info "> 
                <div class="dropdown">
                    <button data-toggle="dropdown" class="dropdown-toggle" type="button" style="background-color: rgb(51, 63, 80); border: 1px solid rgb(51, 63, 80);"><img class="avatar-img rounded-circle" src="/images/avatar_photo.jpg" width="73" height="73" alt="avatar"></button>
                        <div class="dropdown-menu">
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

@if($errors->any())
        <div class="alert alert-warning">
            notation &#9785; {{implode('', $errors->all('<div>:message</div>'))}}
        </div>
    @endif

<h1 class="center-title">
    <Strong>Notation  {{$trajetConducteur['idReservation']}}</Strong>
</h1><br>
<!-- div global -->
@if($_GET['Conducteur'] == 'True')
    <form method="POST", action="{{route('store.notation', ['idReservation' => $trajetConducteur['idReservation'], 'idUtilisateur' => $trajetConducteur['idPassager']])}}">
@elseif($_GET['Conducteur'] == 'False')
    <form method="POST", action="{{route('store.notation', ['idReservation' => $trajetPassager['idReservation'], 'idUtilisateur' => $trajetPassager['idConducteur']])}}">
@endif
    @csrf
    <div class="border border-dark">
        <div class="row ml-5 mt-3 justify-content-center align-items-center">
            <div class="v-list-item__title">
                <div class=" text-h6">
                    @if($_GET['Conducteur'] == 'True')
                        {{date('H:i', strtotime($trajetConducteur['heureDepart']))}}
                    @elseif($_GET['Conducteur'] == 'False')
                        {{date('H:i', strtotime($trajetPassager['heureDepart']))}}    
                    @endif
                </div> 
                <div class="text-body-2">
                    @if($_GET['Conducteur'] == 'True')
                        {{strftime('%a %d %b', strtotime($trajetConducteur['date']))}}
                    @elseif($_GET['Conducteur'] == 'False')
                        {{strftime('%a %d %b', strtotime($trajetPassager['date']))}}
                    @endif
                </div>
            </div>
            
            <!-- trajet -->
            <div class="col-md-7 detail-trajet">
                <div class="row">
                    <div class="col-md-5 text-center lieu-depart">
                        @if($_GET['Conducteur'] == 'True')
                            <span>{{$trajetConducteur['adresseDepart']}}</span>
                        @elseif($_GET['Conducteur'] == 'False')
                            <span>{{$trajetPassager['adresseDepart']}}</span>
                        @endif
                    </div> 
                    <div class="col-md-2 pl-2 temps-image">
                        <!-- photo de destination -->
                        <img src="/images/trajet_bleu.png" width="74" height="17" alt=""/>
                        <div class="font-weight-bold ml-2">
                            @if($_GET['Conducteur'] == 'True')
                            <span>{{date('H:i', strtotime($trajetConducteur['heureArrivee'])-strtotime($trajetConducteur['heureDepart']))}}</span>
                            @elseif($_GET['Conducteur'] == 'False')
                            <span>{{date('H:i', strtotime($trajetPassager['heureArrivee'])-strtotime($trajetPassager['heureDepart']))}}</span>
                            @endif
                        </div>
                    </div> 
                    <div class="col-md-5 text-center lieu-arrive">
                        @if($_GET['Conducteur'] == 'True')
                            <span>{{$trajetConducteur['adresseArrivee']}}</span>
                        @elseif($_GET['Conducteur'] == 'False')
                            <span>{{$trajetPassager['adresseArrivee']}}</span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- nbr de place -->
            <div class="col-md-2 places-dispo">
                3 Places
            </div>

            <!-- prix -->
            <div class="col-md-1 prix">
                5€       
            </div> 
        </div>

        <!-- séparateur -->
        <div class="h-divider"></div>

        <!-- conducteur et button -->
        <div class="row ">
                <div class="pmd-user-info col mt-3 pl-5 center-title">
                
                    <!-- photo -->
                    <a href="#" class="nav-user-img" >   
                        <img class="avatar-img rounded-circle mr-3" src="/images/avatar_photo.jpg" width="73" height="73" alt="avatar"><br/>
                    </a>

                    <!-- nom du conducteur -->
                    @if($_GET['Conducteur'] == 'True')
                        <span class="text-h6">{{$trajetConducteur['passager']}}</span>
                    @elseif($_GET['Conducteur'] == 'False')
                        <span class="text-h6">{{$trajetPassager['conducteur']}}</span>
                    @endif                
                </div>

            <!-- notation d'un utilisateur -->
            <div class="rating-csse col mr-5 center-title">
                <div class="star-icon " style="float:right; margin: 0 auto;">
                    
                    <input class="star" type="checkbox" name="star1" id="star1" onclick="validate()" value="1">
                    <input class="star" type="checkbox" name="star2" id="star2" onclick="validate1()" value="2">
                    <input class="star" type="checkbox" name="star3" id="star3" onclick="validate2()" value="3">
                    <input class="star" type="checkbox" name="star4" id="star4" onclick="validate3()" value="4">
                    <input class="star" type="checkbox" name="star5" id="star5" onclick="validate4()" value="5">
                    
                    <div style=" text-align: center;">
                        <button type="submit" class="btn button-form mr-4" style="float:right ">{{__('Valider')}}</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- remarque notation utilisateur -->
        <div class="row" style="padding-top: 20px;">
            <div class="form-group col mx-auto pl-5 pr-5">
                <textarea class="textarea-form border border-dark @error('message') is-invalid @enderror" id="message" name="message" rows=3></textarea>
                @error('message')
                <div id="message_feedback" class="border border-dark invalid-feedback">
                    {{$message}}
                </div>
                @enderror
            </div>
        </div>
    </div>
</form>

<script>
    function validate() {
        if(document.getElementById("star1").checked == 1) {
            document.getElementById("star1").checked = 1;
            document.getElementById("star2").checked = 0;
            document.getElementById("star3").checked = 0;
            document.getElementById("star4").checked = 0;
            document.getElementById("star5").checked = 0;
        } else {
            document.getElementById("star2").checked = 0;
            document.getElementById("star3").checked = 0;
            document.getElementById("star4").checked = 0;
            document.getElementById("star5").checked = 0;
        }
    }

    function validate1() {
        if(document.getElementById("star2").checked == 1) {
            document.getElementById("star1").checked = 1;
            document.getElementById("star2").checked = 1;
            document.getElementById("star3").checked = 0;
            document.getElementById("star4").checked = 0;
            document.getElementById("star5").checked = 0;
        } else {
            document.getElementById("star3").checked = 0;
            document.getElementById("star4").checked = 0;
            document.getElementById("star5").checked = 0;
        }
    }

    function validate2() {
        if(document.getElementById("star3").checked == 1) {
            document.getElementById("star1").checked = 1;
            document.getElementById("star2").checked = 1;
            document.getElementById("star3").checked = 1;
            document.getElementById("star4").checked = 0;
            document.getElementById("star5").checked = 0;
        } else {
            document.getElementById("star4").checked = 0;
            document.getElementById("star5").checked = 0;
        }
    }
    function validate3() {
        if(document.getElementById("star4").checked == 1) {
            document.getElementById("star1").checked = 1;
            document.getElementById("star2").checked = 1;
            document.getElementById("star3").checked = 1;
            document.getElementById("star4").checked = 1;
            document.getElementById("star5").checked = 0;
        } else {
            document.getElementById("star5").checked = 0;
        }
    }
    function validate4() {
        if(document.getElementById("star5").checked == 1) {
            document.getElementById("star1").checked = 1;
            document.getElementById("star2").checked = 1;
            document.getElementById("star3").checked = 1;
            document.getElementById("star4").checked = 1;
            document.getElementById("star5").checked = 1;
        }
    }
</script>

@endsection