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
    <div class="row ml-5 mt-3 ">
        <div class="v-list-item__title">
            <div class=" text-h6">
                09h39
            </div> 
            <div class="text-body-2">
                ven. 25/02
            </div>
        </div>
        
        <!-- trajet -->
        <div class="col center-title">
            <div class="row">
                <div class="col center-title text-center">
                    <span>Prado</span>
                </div> 
                <div class="col center-title pl-2 center-title">
                    <!-- photo de destination -->
                    <img src="/images/Picture2.jpg" width="74" height="17" alt=""/>
                    <div class="font-weight-bold ml-2 center-title">
                        <span>35min</span>
                    </div>
                </div> 
                <div class="col center-title text-center">
                    <span>Faculté, Luminy</span>
                </div>
            </div>
        </div>

        <!-- nbr de place -->
        <div class=" col center-title">
            <div class="text-h6 center-title">
                3 
            </div>
            <div class="text-body-2 center-title">
                Places
            </div>
        </div>

        <!-- prix -->
        <div class=" col center-title">
            5€       
        </div> 
    </div>

    <!-- séparateur -->
    <div class="h-divider ml-5 "></div>

    <!-- conducteur et button -->
    <div class="row mb-3 mt-2 ml-5">
        <div class="pmd-user-info col mt-3 pl-5">

            <!-- photo -->
            <a href="#" class="nav-user-img" >   
                <img class="avatar-img rounded-circle mr-3" src="/images/avatar_photo.jpg" width="73" height="73" alt="avatar">
            </a>

            <!-- nom du conducteur -->
            <span class="text-h6">Nicolas DUFOUR</span> 
        </div>

        <!-- notation d'un utilisateur -->
        <div class="rating-css col mt-4 ">
            <div class="star-icon">
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
            </div>
        </div >
        <div class="col mt-3">
            <button type="submit" class="btn button-form ">{{__('Valider')}}</button>
        </div>
    </div>

    <!-- remarque notation utilisateur -->
    <div class="row" style="padding-top: 20px;">
        <div class="form-group col mx-auto pl-5 pr-5">
            <textarea class="form-control border border-dark @error('message') is-invalid @enderror" id="message" name="message" rows=3></textarea>
            @error('message')
            <div id="message_feedback" class="border border-dark invalid-feedback">
                {{$message}}
            </div>
            @enderror
        </div>
    </div>
</div>

@endsection