@extends('base')

@section('title')
Caractéristiques
@endsection

@section('style')
    <link rel="stylesheet" href="css/style.css">
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
<h1 class="center-title">informations utilisateur</h1>
<form>
    <!-- utilisateur  -->
    <div class="row ">
        <div class="pmd-user-info col pl-5 center-title">
        
            <!-- photo -->
            <a href="#" class="nav-user-img" >   
                <img class="avatar-img rounded-circle mr-3" src="/images/avatar_photo.jpg" width="73" height="73" alt="avatar"><br/>
            </a>

            <!-- nom du conducteur -->
            <span class="text-h6">Nicolas DUFOUR</span> 
        </div>
        <div class="col ">
            <!-- nbr de place -->
            <div>
                3 Places
            </div>

            <!-- modele et parque du vehicule -->
            <div>
            Alpha Romeo
            </div>

            <!-- couleur du vehicule -->
            <div>
                Rouge
            </div>
            
            <!-- immatriculation -->
            <div>
                ED-145-TR
            </div>

            <!-- photo de la voiture -->
        </div>
        <div class="col ">
            <img class="avatar-img rounded-circle" src="/images/voiture.jpg" width="100" height="73" alt="avatar">
        </div>
        <div class="col ml-4">
            <!-- note -->
            
            <div class="row">
                <div>fumeurs : <a>oui</a></div>
            </div>
            <div class="row">
                <div>animaux : <a>oui</a></div>
            </div>
        </div>

        <!-- notation d'un utilisateur -->
        
        <div class="col rating-css" style="float:right;" >
            <div class="row" style="color:black;  height: 0.7cm; width:3cm;" >
                note
            </div>
            <div class="row" style="white-space:nowrap;  width:3cm;">
                <label class="fa fa-star"></label>
                <label class="fa fa-star"></label>
                <label class="fa fa-star"></label>
                <label class="fa fa-star"></label>
                <label class="fa fa-star"></label>
            </div>
        </div>

    </div>
    <!-- séparateur -->
    <div class="h-divider"></div>

<!-- div global -->
<div class="border border-dark">
    <div class="row ml-5 mt-3">
        <div class="v-list-item__title">
            <div class=" text-h6">
                09h39
            </div> 
            <div class="text-body-2">
                ven. 25/02
            </div>
        </div>
        
        <!-- trajet -->
        <div class="col-md-7 detail-trajet">
            <div class="row">
                <div class="col-md-5 text-center lieu-depart">
                    <span>9 Rue Prado, 13111 Marseille</span>
                </div> 
                <div class="col-md-2 pl-2 temps-image">
                    <!-- photo de destination -->
                    <img src="/images/Picture2.jpg" width="74" height="17" alt=""/>
                    <div class="font-weight-bold ml-2">
                        <span>35min</span>
                    </div>
                </div> 
                <div class="col-md-5 text-center lieu-arrive">
                    <span>Faculté des sciences, Luminy</span>
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
    <div class="row" >
        <div class="ml-5">
            <label class="fa fa-star"></label>
            <label class="fa fa-star"></label>
            <label class="fa fa-star"></label>
            <label class="fa fa-star"></label>
            <label class="fa fa-star"></label>
        </div>

        <div class=" ml-3 mr-3">
            message
        </div>
    </div>
    <!-- séparateur -->
    <div class="h-divider"></div>
    <div class="row" >
        <div class="ml-5">
            <label class="fa fa-star"></label>
            <label class="fa fa-star"></label>
            <label class="fa fa-star"></label>
            <label class="fa fa-star"></label>
            <label class="fa fa-star"></label>
        </div>

        <div class=" ml-3 mr-3">
            message
        </div>
    </div>
</div>
<div>. </div>
<div class="border border-dark">
    <div class="row ml-5 mt-3">
        <div class="v-list-item__title">
            <div class=" text-h6">
                09h39
            </div> 
            <div class="text-body-2">
                ven. 25/02
            </div>
        </div>
        
        <!-- trajet -->
        <div class="col-md-7 detail-trajet">
            <div class="row">
                <div class="col-md-5 text-center lieu-depart">
                    <span>9 Rue Prado, 13111 Marseille</span>
                </div> 
                <div class="col-md-2 pl-2 temps-image">
                    <!-- photo de destination -->
                    <img src="/images/Picture2.jpg" width="74" height="17" alt=""/>
                    <div class="font-weight-bold ml-2">
                        <span>35min</span>
                    </div>
                </div> 
                <div class="col-md-5 text-center lieu-arrive">
                    <span>Faculté des sciences, Luminy</span>
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
    <div class="row" >
        <div class="ml-5">
            <label class="fa fa-star"></label>
            <label class="fa fa-star"></label>
            <label class="fa fa-star"></label>
            <label class="fa fa-star"></label>
            <label class="fa fa-star"></label>
        </div>

        <div class=" ml-3 mr-3">
            message
        </div>
    </div>
    <!-- séparateur -->
    <div class="h-divider"></div>
    <div class="row" >
        <div class="ml-5">
            <label class="fa fa-star"></label>
            <label class="fa fa-star"></label>
            <label class="fa fa-star"></label>
            <label class="fa fa-star"></label>
            <label class="fa fa-star"></label>
        </div>

        <div class=" ml-3 mr-3">
            message
        </div>
    </div>
</div>

</form>
@endsection