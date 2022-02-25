@extends('base')

@section('title')
    Ecrire un nouveau message
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
<h1 class="center-title">Ecrire un nouveau message</h1>

<form style="padding-top: 60px;">
    @csrf
    @if($errors->any())
        <div class="alert alert-warning">
            Le message n'a pas pu être envoyé &#9785; {{implode('', $errors->all('<div>:message</div>'))}}
        </div>
    @endif
    @if(session()->has('success'))
        <div class="alert alert-success">
                  {{session()->get('success')}}&#9786;
        </div>
    @endif
    <div class="form-group col-md-8 mx-auto">
        <label for="destinataire">Destinataire</label>
        <br />
        <select class="input-form input-select  @error('destinataire') is-invalid @enderror" id="destinataire" name="destinataire" required value="{{old('destinataire')}}">
            <option value="Dorian_Bourdon">Dorian Bourdon</option>
            <option value="Nicolas_Dufour">Nicolas Dufour</option>
            <option value="Ismail_Idbourhim">Ismail Idbourhim</option>
        </select>
        @error('destinataire')
        <div id="objet_feedback" class="invalid-feedback">
            {{$message}}
        </div>
        @enderror
    </div>

    <div class="form-group col-md-8 mx-auto">
        <label for="objet">{{__('Objet')}}</label>
        <input type="text" id="objet" name="objet" class="input-form @error('objet') is-invalid @enderror" required value="{{old('objet')}}"/>
        @error('objet')
        <div id="objet_feedback" class="invalid-feedback">
            {{$message}}
        </div>
        @enderror
    </div>

    <div class="form-group col-md-8 mx-auto">
        <label for="message">{{__('Message')}}</label>
        <textarea class="form-control textarea-form @error('message') is-invalid @enderror" id="message" name="message" rows=3></textarea>
        @error('message')
        <div id="message_feedback" class="invalid-feedback">
            {{$message}}
        </div>
        @enderror
    </div>

    <button type="submit" class="btn button-form mx-auto">{{__('Envoyer')}}</button>
</form>


@endsection