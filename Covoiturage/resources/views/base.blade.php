<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
            {{-- le titre de la page --}}
            <title>@yield('title')</title>
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
            <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.4.3/css/mdb.min.css" rel="stylesheet">
            <script src="https://kit.fontawesome.com/ae49975df8.js" crossorigin="anonymous"></script>
            <script src="https://www.google.com/recaptcha/api.js"></script>
            <link rel="icon" href="{!! asset('images/logo_min2.png') !!}"/>
            
            {{-- le style de la page --}}
            @yield('style')
    </head>
    <body>
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand" href="#">
                <img id="logo-img" src="/images/logo_min2.png" alt="logo">
            </a>
            <a class="navbar-brand" href="#">
                <img id="name-logo" src="/images/CoLuminy.png" alt="CoLuminy">
            </a>
                @if(session()->get('profil') == "Conducteur")
                    <button type="submit" class="btn button-form">Passager</button>
                @elseif(session()->get('profil') == "Passager")<!-- Ajoute fonction possedeVoiture() -->
                <button type="submit" class="btn button-form">Conducteur</button>
                @endif
            
            <div class="ml-auto">
                <button type="button" class="navbar-toggler collapsed" data-toggle="collapse" data-target="#navbarSupportedContent" aria-expanded="false" aria-controls="navbarSupportedContent">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="navbar-collapse collapse ml-auto" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item ">
                        <a class="nav-link" href="{{route('recherche_trajet')}}">Recherche de trajets <span class="sr-only">(current)</span></a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" href="{{route('proposer_trajet')}}">Proposer un trajet</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('apropos')}}">A propos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">News</a>
                        </li>
                    </ul>

                    {{-- la suite de navbar --}}
                    @yield('navbarSequel')

                </div>  
                
            </div>
        </nav><br>
        
        <!-- Contenant de la page -->
        <div class="container">
            @yield('content')
        </div>
        
        <!-- Footer -->
        <footer class="page-footer font-small mdb-color">
            <div class="container">
                <div class="row text-center d-flex justify-content-center pt-5 mb-3">
                    <div class="col-md-3 mb-1">
                    <h6 class="text-uppercase font-weight-bold">
                        <a href="{{route('qui_sommes_nous')}}">Qui sommes-nous?</a>
                    </h6>
                    </div>
                    <div class="col-md-3 mb-1">
                        <h6 class="text-uppercase font-weight-bold">
                            <a href="{{route('question')}}">Poser une question</a>
                        </h6>
                    </div>
                    <div class="col-md-3 mb-1">
                        <h6 class="text-uppercase font-weight-bold">Choix de langue :&nbsp
                            <a class="langue" href="locale/en">en</a>&nbsp | &nbsp<a class="langue" href="locale/fr">fr</a>
                        </h6>
                        <span>
                                <div id="google_translate_element"></div> 
                                <script type="text/javascript"> 
                                    function googleTranslateElementInit() { 
                                    new google.translate.TranslateElement({pageLanguage: 'ar en'},
                                    'google_translate_element'); 
                                    } 
                                </script> 
                                <script type="text/javascript"
                                    src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script> 
                            </span>
                        
                    </div>
                </div>
                <hr class="rgba-white-light" style="margin: 0 15%;">
                <div class="row d-flex text-center justify-content-center mb-md-0 mb-4">
                    <div class="col-md-8 col-12 mt-5">
                    <p style="line-height: 1.7rem"> L'objet de notre site est de permettre aux 
                        utilisateurs de proposer des trajets en voiture (à moindre coût) avec 
                        la faculté de Luminy comme point de départ ou d'arrivée et Marseille 
                        comme zone de travail, d'autre part, de réserver des trajets en fonction de leurs 
                        besoins, dans le but de décongestionner le trafic en direction de Luminy 
                        (le matin), ainsi qu'en direction du centre-ville le soir.
                    </p>
                    </div>
                </div>
                <hr class="clearfix d-md-none rgba-white-light" style="margin: 10% 15% 5%;">
                <div class="row pb-3">
                    <div class="col-md-12">
                        <div class="mb-5 flex-center fa-big">
                            <!-- Facebook -->
                            <a class="fb-ic">
                            <i class="fab fa-facebook-f font-lg white-text mr-4"> </i>
                            </a>
                            <!-- Twitter -->
                            <a class="tw-ic">
                            <i class="fab fa-twitter fa-lg white-text mr-4"> </i>
                            </a>
                            <!-- Google +-->
                            <a class="gplus-ic">
                            <i class="fab fa-google-plus-g fa-lg white-text mr-4"> </i>
                            </a>
                            <!--Linkedin -->
                            <a class="li-ic">
                            <i class="fab fa-linkedin-in fa-lg white-text mr-4"> </i>
                            </a>
                            <!--Instagram-->
                            <a class="ins-ic">
                            <i class="fab fa-instagram fa-lg white-text mr-4"> </i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-copyright text-center py-1">
                <span id="Copyright">© {{date('Y')}} Copyright-M2 CCI MARSEILLE</span> 
            </div>
        </footer>


    </body>
</html>