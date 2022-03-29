@extends('base')

@section('title')
    Mes trajets à venir
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
    <h1 class="center-title">
        <Strong>Mes trajets à venir</Strong>
    </h1><br>
    @if ( session()->has('errors'))
        <div class="alert alert-danger">
            {{session()->get('errors')}}&#9785; 
        </div>
    @endif
    @if(session()->has('success'))
        <div class="alert alert-success">
                {{session()->get('success')}}&#9786;
        </div>
    @endif
    <!-- div global -->
    @for ($pos = 0; $pos < count($trajetsEnCours) ; $pos++)
    <div class="border border-dark">
        <div class="row ml-5 mt-3">
            <div class="v-list-item__title">
                <div class=" text-h6">
                    {{date('H\\hi', strtotime($trajetsEnCours[$pos]->dateHeureDepart))}}
                </div> 
                <div class="text-body-2">
                    {{$tabDateFrenche[$pos]}}
                </div>
            </div>
            <!-- trajet -->
            <div class="col-md-7 ml-4 detail-trajet">
                <div class="row">
                    <div class="col-md-5 text-center lieu-depart">
                        <span>{{$trajetsEnCours[$pos]->numRueDep}} {{$trajetsEnCours[$pos]->rueDep}} {{$trajetsEnCours[$pos]->cpDep}} {{$trajetsEnCours[$pos]->villeDep}}</span>
                    </div> 
                    <div class="col-md-2 pl-2 temps-image">
                        <!-- photo de destination -->
                        <img src="/images/trajet_bleu.png" width="74" height="17" alt="photo de destination"/>
                        <div class="font-weight-bold ml-2">
                            <span>{{$tableTime[$pos]}}min</span>
                        </div>
                    </div> 
                    <div class="col-md-5 text-center lieu-arrive">
                        <span>{{$trajetsEnCours[$pos]->numRueArr}} {{$trajetsEnCours[$pos]->rueArr}} {{$trajetsEnCours[$pos]->cpArr}} {{$trajetsEnCours[$pos]->villeArr}}</span>
                    </div>
                </div>
            </div>

            <!-- nbr de place -->
            <div class="col-md-2 ml-4 places-dispo">
                Max : {{$trajetsEnCours[$pos]->nbPlace}} Places
            </div>

            <!-- prix -->
            <div class="col-md-1 prix">
                <strong>{{$trajetsEnCours[$pos]->prixTrajet}}€</strong>
            </div> 
        </div>

        <!-- séparateur -->
        <div class="h-divider ml-5"></div>

        <label class="ml-5">Passagers : </label>
        <!-- conducteur et buttons -->
        @if(count($passagers[$pos])==0)
            <div class= "text-center mb-4 font-weight-bold text-danger">Vous n'avez pas encore de passagers</div>  
        @else
            @for ($i = 0; $i < count($passagers[$pos]); $i++) 
                <div class="row mb-3 mt-2 ml-4">
                    <div class="pmd-user-info col-md-5 user-info" style="margin-left: 8%;">
                        <!-- photo et le nom de passager-->
                        @if ($trajetsEnCours[0]->photoProfil != null)
                        <a href="#" class="nav-user-img" >   
                            <img src="{{$passagers[$pos][$i]->photoProfil}}" class="avatar-img rounded-circle mr-3" width="73" height="73" alt="photo de profil"> 
                        </a>
                        @else
                        <a href="#" class="nav-user-img" >
                            <img class="avatar-img rounded-circle mr-3" src="/images/avatar_photo.jpg" width="73" height="73" alt="photo de profil">
                        </a>
                        @endif 
                        <span class="text-h6 ml-3">{{$passagers[$pos][$i]->prenomUtilisateur}} {{$passagers[$pos][$i]->nomUtilisateur}}</span>
                        
                    </div>
                    <!--nombre de places réservées par passager-->
                    <div class="col-md-2" style="margin-top:20px;">{{$passagers[$pos][$i]->nbPlace}} Place(s)</div>
                    <!-- Etat de paiement de passager -->
                    @if($passagers[$pos][$i]->estPaye == 1)
                        <div class="col-md-1 font-weight-bold" style="margin-top:20px; color:green;">Payé</div> 
                    @else
                        <div class="col-md-1 font-weight-bold" style="margin-top:10px; color:red;">Non payé</div>
                    @endif
                    <!-- les buttons -->
                    @if ($passagers[$pos][$i]->estAccepte == 0)
                        <form method="POST" action="{{route('validerPassager.store', ['idReservation'=>$passagers[$pos][$i]->idReservation])}}">
                            @csrf   
                            <input type="hidden" name="idPassager" value="{{$passagers[$pos][$i]->idPassager}}">
                            <input type="hidden" name="idTrajet" value="{{$trajetsEnCours[$pos]->idTrajet}}">
                            <input type="hidden" name="nbrplaces" value="{{$passagers[$pos][$i]->nbPlace}}">
                            <div class="col-md-1 ml-5 mt-1 btn-accept" >
                                <button type="submit" class="btn-md border-0 bg-transparent">
                                    <img src="/images/check_button.png" width="52" height="48" alt=""/>
                                </button>
                            </div>
                        </form>
                        <form method="POST" action="{{route('refuserPassager.store', ['idReservation'=>$passagers[$pos][$i]->idReservation])}}">
                            @csrf
                            <input type="hidden" name="idPassager" value="{{$passagers[$pos][$i]->idPassager}}">
                            <div class="col-md-1 mt-1 btn-refuse">
                                <button type="submit" class="btn-md border-0 bg-transparent">
                                    <img src="/images/cancel_button.png" width="52" height="48" alt=""/>
                                </button>
                            </div>
                        </form>
                    @endif
                </div>
            @endfor
        @endif 
        
        <div class="col-md-3 mx-auto mb-4 mt-3 ">
            <a href="{{route('annuler_trajet', $trajetsEnCours[$pos]->idTrajet)}}">    
                <button type="submit" class="btn button-form">Annuler le trajet</button>
            </a>
        </div>
        
    </div><br>
    @endfor
@endsection