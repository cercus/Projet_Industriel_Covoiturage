@extends('base')

@section('title')
Rechercher un trajet
@endsection

@section('style')
    <link rel="stylesheet" href="/css/style.css">
@endsection
           
@section('navbarSequel')
    <ul class="navbar-nav mr-auto">
        <li class="nav-item">
            <a class="nav-link" href="#">Inscription</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">Connexion</a>
        </li>
    </ul>
@endsection

@section('content')


<div class="center-title">
    <h2>Paiement</h2>
</div>

<div class="bordurePaiement">
<form>
    @csrf
    @if ($errors->any())
        <div class="alert alert-warning">
            Le paiement n'a pas pu etre effectué &#9785;
        </div>
    @endif
<div class="row">
<div class="colonne-12">
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
</div>

<div class="row">
    <div class="colonne-6">
        <label for="exDate">Date d'expiration</label>
        <input type="date" id="exDate" name="exDate"  
                aria-describedby="exDate_feedback" 
                class="input-form form-control @error('exDate') is-invalid @enderror"
                required>
        @error('exDate')
        <div id="exDate_feedback" class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
    <div class="colonne-6">
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
    <button type="submit" class="button-paiement">Payer</button>

</form>
</div>
@endsection