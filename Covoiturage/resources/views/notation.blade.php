@extends('base')

@section('title')
    Notations
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

<h1 class="center-title">
    <Strong>Notation</Strong>
</h1><br>
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

    <!-- conducteur et button -->
    <div class="row ">
            <div class="pmd-user-info col mt-3 pl-5 center-title">
            
                <!-- photo -->
                <a href="#" class="nav-user-img" >   
                    <img class="avatar-img rounded-circle mr-3" src="/images/avatar_photo.jpg" width="73" height="73" alt="avatar"><br/>
                </a>

                <!-- nom du conducteur -->
                <span class="text-h6">Nicolas DUFOUR</span> 
            </div>

        <!-- notation d'un utilisateur -->
        <div class="rating-css col mr-5 center-title">
            <div class="star-icon " style="float:right">
                <input type="radio" value="1" name="product_rating" checked id="rating1">
                <label for="rating1" class="fa fa-star"></label>
                <input type="radio" value="2" name="product_rating" id="rating2">
                <label for="rating2" class="fa fa-star"></label>
                <input type="radio" value="3" name="product_rating" id="rating3">
                <label for="rating3" class="fa fa-star"></label>
                <input type="radio" value="4" name="product_rating" id="rating4">
                <label for="rating4" class="fa fa-star"></label>
                <input type="radio" value="5" name="product_rating" id="rating5">
                <label for="rating5" class="fa fa-star"></label>
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

@endsection