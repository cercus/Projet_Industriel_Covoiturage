@extends('base')

@section('title')
    Mes trajets en cours
@endsection

@section('style')
    <link rel="stylesheet" href="/css/style.css">
@endsection
           
@section('navbarSequel')
    <ul class="navbar-nav mr-auto"> 
        <li class="nav-item">
            <a class="nav-link" href="{{route('user', ['idUtilisateur' => session()->get('user')['id']])}}"></a>
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
        <Strong>Mes trajets en cours</Strong>
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
                        <img src="/images/trajet_bleu.png" width="74" height="17" alt=""/>
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
        <div class="h-divider ml-5"></div>

        <label class="ml-5">Passagers : </label>

        <!-- conducteur et buttons -->
        {{-- @foreach ($Passagers as $passager) --}}
            <div class="row mb-3 mt-2 ml-5">
                <div class="pmd-user-info col-md-5 user-info" style="margin-left: 13%;">
                    <!-- photo et le nom de passager-->
                    <a href="#" class="nav-user-img" >   
                        <img class="avatar-img rounded-circle mr-3" src="/images/avatar_photo.jpg" width="73" height="73" alt="avatar">
                    </a>
                    <span class="text-h6 ml-5">Nicolas DUFOUR</span>
                </div>
                <!-- les buttons -->
                <div class="col-md-1 mt-2 ml-5 btn-accept">
                    <button type="submit" class="btn-md border-0 bg-transparent">
                        <img src="/images/check_button.png" width="56" height="51" alt=""/>
                    </button>
                </div>
                <div class="col-md-1 mt-2 btn-refuse">
                    <button type="submit" class="btn-md border-0 bg-transparent">
                        <img src="/images/cancel_button.png" width="56" height="51" alt=""/>
                    </button>
                </div>
            </div> 

            <div class="row mb-3 mt-2 ml-5">
                <div class="pmd-user-info col-md-5 user-info" style="margin-left: 13%;">
                    <!-- photo et le nom de passager-->
                    <a href="#" class="nav-user-img" >   
                        <img class="avatar-img rounded-circle mr-3" src="/images/avatar_photo.jpg" width="73" height="73" alt="avatar">
                    </a>
                    <span class="text-h6 ml-5">Ismail IDBOURHIM</span>
                </div>
                <!-- les buttons -->
                <div class="col-md-1 mt-2 ml-5 btn-accept" >
                    <button type="submit" class="btn-md border-0 bg-transparent">
                        <img src="/images/check_button.png" width="56" height="51" alt=""/>
                    </button>
                </div>
                <div class="col-md-1 mt-2 btn-refuse">
                    <button type="submit" class="btn-md border-0 bg-transparent">
                        <img src="/images/cancel_button.png" width="56" height="51" alt=""/>
                    </button>
                </div>
            </div>
        {{-- @endforeach --}}
    </div>

@endsection