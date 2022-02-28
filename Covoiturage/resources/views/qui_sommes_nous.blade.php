@extends('base')

@section('title')
Qui sommes nous ?
@endsection

@section('style')
<link rel="stylesheet" href="/css/style.css">
@endsection

@section('navbarSequel')
<ul class="navbar-nav mr-auto">
    <li class="nav-item">
        <a class="nav-link" href="{{route('inscription')}}">Inscription</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{route('connexion')}}">Connexion</a>
    </li>
</ul>
@endsection

@section('content')

<div id="intro" class="margin-bottom-div">
    <h1 class="center-title">Qui sommes nous ?</h1>
    <p style="text-indent: 30px;">
        Cette page web est néé grace à un projet universitaire.
        L'objectif est de réaliser, en groupe, un site web de A à Z comme si nous étions en entreprise.
        Chaque membre du groupe à ses motivations personnelles, ses compétences et ses aspirations.
    </p>

</div>

<div id="equipeDev" class="margin-bottom-div">

    <h2 class="center-title">Équipe de développement</h2>

    <div>
        <div class="col-right-input-accueil gallery">
            <div class="floatLeft">
                <img src="{{URL::asset('images/PhotoSwd.GIF')}}">
            </div>
            <div class="desc">
                Je m'appelle Sawda Abdoulaye, titulaire d’un master en mathématiques appliquées et statistique.
                Peu importe le problème de programmation auquel je suis confrontée, j'ai toujours su le résoudre.
                J'ai alors compris que le métier de programmeur est fait pour moi. Mon souhait est d’évoluer en
                tant qu'ingénieur d'études et développement. Pour le réaliser, j’ai besoin de plus de compétences
                en développement ; raison pour laquelle j’ai opté pour le master CCI.
            </div>
        </div>

        <div class="col-left-input-accueil gallery">
            <div class="floatLeft">
                <img src="{{URL::asset('images/PhotoNcl.jpg')}}">
            </div>
            <div class="desc">
                Je suis Nicolas Dufour. Muni d’un diplôme d’ingénieur de production, je travaille depuis déjà 30 ans
                dans différents secteurs d’entreprise liés à la fabrication. D’employé à directeur de plusieurs
                sites, l’informatique m’a toujours passionné. Cet outil m’a également aidé à résoudre nombre de
                problématiques industrielles. Passions, compétences et besoin des entreprises me conduisent à
                réaliser cette reconversion professionnelle vers la transition numérique.
            </div>
        </div>

        <div>
            <div class="col-right-input-accueil gallery">
                <div class="floatLeft">
                    <img src="{{URL::asset('images/PhotoDrn.jpg')}}">
                </div>
                <div class="desc">
                    Je m’appelle Dorian Bourdon et suis titulaire d’un master en Sciences de l’Océan, de l’Atmosphère
                    et du Climat (SOAC). L’informatique m’attirant plus que la science, je me suis tournée vers le
                    master CCI. J’ai choisi d’une part ce master pour la qualité des enseignements et le fait que ce
                    master permet d’ouvrir beaucoup de portes dans le monde de l’informatique. D’autre part, j’ai
                    commencé la programmation il y a de cela 5 ans, en partie grâce à Minecraft
                    et depuis je n’arrête pas de créer des programmes dans divers langages.
                </div>
            </div>
            <div class="col-left-input-accueil gallery">
                <div class="floatLeft">
                    <img src="{{URL::asset('images/PhotoIsm.jpg')}}">
                </div>
                <div class="desc">
                    Je m’appelle Ismail IDBOURHIM, titulaire d’un master en chimie durable organique.
                    J’ai intégré le master CCI « Compétences Complémentaires en Informatique » afin
                    d'acquérir des compétences en informatique et de m'évoluer dans ce domaine.
                    À travers les projets antérieurs réalisés au cours de cette formation,
                    j’ai pu développer mes compétences en programmation et en résolution des problèmes, 
                    tout en possédant de solides bases en développement, qui me permet une projection facile 
                    sur les technologies fréquentes du Web.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection