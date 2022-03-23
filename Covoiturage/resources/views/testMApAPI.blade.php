@extends('base')

@section('title')
Proposer un trajet
@endsection

@section('style')
<link rel="stylesheet" href="/css/style.css">
<link rel="stylesheet" href="/css/cssAPI.css">
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
    
<div class="alert alert-success" role="alert" id="successMsg" style="display: none" >
  Thank you for getting in touch! 
</div>

<form id="SubmitForm">
      <div class="mb-3">
        <label for="InputName" class="form-label">Name</label>
        <input type="text" class="form-control" id="InputName">
        <span class="text-danger" id="nameErrorMsg"></span>
      </div>

      <div class="mb-3">
        <label for="InputEmail" class="form-label">Email address</label>
        <input type="email" class="form-control" id="InputEmail">
        <span class="text-danger" id="emailErrorMsg"></span>
      </div>

      <div class="mb-3">
        <label for="InputMobile" class="form-label">Mobile</label>
        <input type="number" class="form-control" id="InputMobile">
        <span class="text-danger" id="mobileErrorMsg"></span> 
      </div>

      <div class="mb-3">
        <label for="InputMessage" class="form-label">Message</label>
        <textarea class="form-control" id="InputMessage" cols="30" rows="4"></textarea>
        <span class="text-danger" id="messageErrorMsg"></span>
      </div>
      
      
      <button type="submit" class="btn btn-primary">Submit</button>
</form>

<script type="text/javascript">

$('#SubmitForm').on('submit',function(e){
    e.preventDefault();

    let name = $('#InputName').val();
    let email = $('#InputEmail').val();
    let mobile = $('#InputMobile').val();
    let message = $('#InputMessage').val();
    
    $.ajax({
      url: "/submit-testAPIMap",
      type:"POST",
      data:{
        "_token": "{{ csrf_token() }}",
        name:name,
        email:email,
        mobile:mobile,
        message:message,
      },
      success:function(response){
        $('#successMsg').show();
        console.log(response);
        window.location("/");
      },
      error: function(response) {
        $('#nameErrorMsg').text(response.responseJSON.errors.name);
        $('#emailErrorMsg').text(response.responseJSON.errors.email);
        $('#mobileErrorMsg').text(response.responseJSON.errors.mobile);
        $('#messageErrorMsg').text(response.responseJSON.errors.message);
      },
      });
    });
  </script>
    
@endsection