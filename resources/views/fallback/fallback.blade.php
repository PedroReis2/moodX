@extends('layout.fe_master')

@section('title', 'fallback')

@section('content')
<div class="register-page container-fluid">
    <div class="header-container mx-auto">

        <!-- Logo no topo, alinhada à esquerda -->
        <div class="layout-logo">
            <img src="{{ asset('images/logo.png') }}" class="logo-img raise-up" alt="Logo">
        </div>

<div class="alert-square-wrapper">
    <img src="{{ asset('images/alert-square.png') }}" alt="Alert Square">
    <span class="alert-exclamation">!</span>
</div>

<p class="alert-text">404 PAGE<BR>NOT FOUND</p>


        <!-- Conteúdo central da página -->
        <div class="under-construction-content">
            <h1>Looks like you've lost the thread!</h1>
            <p>
                Even the best designs unravel sometimes,<br>
                let's stitch this back together and get you where you need to go.
            </p>

            <!-- Botão GO BACK -->
            <a href="{{ route('welcome') }}" class="btn-go-back">GO BACK</a>
        </div>

    </div>
</div>
@endsection


