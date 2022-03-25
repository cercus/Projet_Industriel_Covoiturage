@extends('base')

@section('title')
    Annuler ma reservation
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
    <h1 class="center-title" style="padding-bottom: 27px;">
        <Strong>Annuler ma reservation</Strong>
    </h1>
    <form class="border border-dark" method="POST" action="{{route('acceptAnnulerReservation.store', $idReservation)}}" style="padding-top: 20px; padding-bottom: 20px;" >
        @csrf
        @if($errors->any())
            <div class="alert alert-warning">
                la reservation n'a pas été annulé &#9785;
            </div>
        @endif
        @if ( session()->has('errors'))
            <div class="alert alert-danger">
                {{session()->get('errors')}}&#9785; 
            </div>
        @endif
        <div class="form-group col-md-8 mx-auto">
            <label>Motif d'annulation</label>
            <input type="text" name="motif-annulation" class="input-form @error('motif-annulation') is-invalid @enderror" required value="{{old('motif-annulation')}}"/>
        </div>
        <div class="form-group col-md-8 mx-auto">
            <label>Message au conducteur</label>
            <textarea class="form-control textarea-form @error('message-passager') is-invalid @enderror" name="message-passager" value="{{old('message-passager')}}" rows=3></textarea>
            @error('message-passager')
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
                        Souhaitez-vous vraiment supprimer cette reservation ??
                    </div>
                    <div class="modal-footer m-auto">
                        <button type="submit" class="btn btn-danger" >Oui</button>
                        <a href="/passager/reservation_en_cours/{{session()->get('user')['id']}}" class="btn btn-success">Non</a>
                    </div>
                </div>
            </div>
        </div>
    </form>


@endsection