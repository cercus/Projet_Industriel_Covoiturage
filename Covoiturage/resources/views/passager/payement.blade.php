@extends('base')

@section('title')
Payement du trajet
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


<div class="center-title">
    <h2>Paiement</h2>
</div>

<div class="border border-dark">
    <form>
        @csrf
        @if ($errors->any())
            <div class="alert alert-warning">
                Le paiement n'a pas pu etre effectué &#9785;
            </div>
        @endif

        <div class="col-md-10 mx-auto">
            <label for="numCard">Numéro de carte</label>
            <input type="number" id="numCard" name="numCard"  
                    aria-describedby="numCard_feedback" 
                    class="input-form form-control @error('numCard') is-invalid @enderror"
                    required>
            @error('numCard')
            <div id="numCard_feedback" class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>

        <div class="col-md-10 mx-auto">
            <div class="col-right-input">
                <label for="exDate">Date d'expiration</label>
                <input type="month" id="exDate" name="exDate"  
                        aria-describedby="exDate_feedback" 
                        class="input-form form-control @error('exDate') is-invalid @enderror"
                        required>
                @error('exDate')
                <div id="exDate_feedback" class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="col-left-input">
                <label for="cvcCard">CVC/CVV</label>
                <input type="number" id="cvcCard" name="cvcCard"  
                        aria-describedby="cvcCard_feedback" 
                        class="input-form form-control @error('cvcCard') is-invalid @enderror"
                        required>
                @error('cvcCard')
                <div id="cvcCard_feedback" class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
        </div>
        <div class="row justify-content-center align-items-center space-bottom-title">
            <button type="submit" class="btn button-form">Payer</button>
        </div>

    </form>
</div>
@endsection