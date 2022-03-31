@extends('base')

@section('title')
    Annuler mon trajet
@endsection

@section('style')
    <link rel="stylesheet" href="/css/style.css">
@endsection
           
@section('navbarSequel')
@if(session()->has('user'))
        <div class="pmd-user-info "> 
                <div class="dropdown">
                    <button data-toggle="dropdown" class="dropdown-toggle" type="button" style="background-color: rgb(51, 63, 80); border: 1px solid rgb(51, 63, 80);"><img class="avatar-img rounded-circle" src="/images/avatar_photo.jpg" width="73" height="73" alt="avatar"></button>
                        <div class="dropdown-menu dropdown-menu-right">
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
{{-- {{dd($idConducteur, $idTrajet)}} --}}
    <h1 class="center-title" style="padding-bottom: 27px;">
        <Strong>Annuler mon trajet</Strong>
    </h1>
    @if($errors->any())
            <div class="alert alert-warning">
                le trajet n'a pas été annulé &#9785; {{implode('', $errors->all('<div>:message</div>'))}}
            </div>
    @endif
    @if ( session()->has('errors'))
        <div class="alert alert-danger">
            {{session()->get('errors')}}&#9785; 
        </div>
    @endif
    <form class="border border-dark" method="POST" action="{{route('acceptAnnulerTrajet.store', $idTrajet)}}" style="padding-top: 20px; padding-bottom: 20px;" >
        @csrf
        <div class="form-group col-md-8 mx-auto">
            <label for="motif-annulation">Motif d'annulation*</label>
            <input type="text" name="motif-annulation" class="input-form @error('motif-annulation') is-invalid @enderror" required value="{{old('motif-annulation')}}"/>
        </div>
        <div class="form-group col-md-8 mx-auto">
            <label for="message-conducteur">Message aux passagers</label>
            <textarea class="form-control textarea-form @error('message-conducteur') is-invalid @enderror" name="message-conducteur" value="{{old('message-conducteur')}}" rows=3></textarea>
            @error('message-conducteur')
            <div id="message_feedback" class="invalid-feedback">
                {{$message}}
            </div>
            @enderror
        </div>
        <!-- Button trigger modal -->
        <button type="button" class="btn button-form mx-auto" data-toggle="modal" data-target="#staticBackdrop">Envoyer</button>
    
        <!-- Modal -->
        <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        Souhaitez-vous vraiment supprimer ce trajet ??
                    </div>
                    <!-- Les button de modal -->
                    <div class="modal-footer m-auto">
                        <button type="submit" class="btn btn-danger" >Oui</button>
                        <a href="/conducteur/trajets_en_cours/{{$idConducteur}}" class="btn btn-success">Non</a>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection