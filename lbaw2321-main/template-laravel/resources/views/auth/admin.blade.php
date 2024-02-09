<?php
session_start();
?>
@extends('layouts.app')

@section('content')

<!-- Adicione o script da API do Google -->

<title> GetTogether - ADM </title>
<script src="https://apis.google.com/js/platform.js" async defer></script>

<meta name="google-signin-client_id" content="gettogether@praxis-water-408115.iam.gserviceaccount.com">

<script>
    Bem vindo <?php echo $_SESSION['userName']; ?>!
</script>
<a href="login.blade.php" onclick="signOut();">Sign out</a>
<script>
  function signOut() {
    var auth2 = gapi.auth2.getAuthInstance();
    auth2.signOut().then(function () {
      console.log('User signed out.');
    });
  }
</script>
@endsection