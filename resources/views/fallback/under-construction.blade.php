@extends('layout.fe_master')

@section('title', 'Under Construction')

@section('content')
<div class="register-page container-fluid">
    <div class="header-container mx-auto">

        <!-- Logo no topo, alinhada à esquerda -->
        <div class="layout-logo">
            <img src="{{ asset('images/logo.png') }}" class="logo-img raise-up" alt="Logo">
        </div>


        <div class="message-circle">
            <img src="{{ asset('images/message-circle.png') }}" class="message-circle" alt="message-circle">
        </div>

        <!-- Conteúdo central da página -->
        <div class="under-construction-content">
            <h1>We're stitching the details</h1>
            <p>STAY TUNED</p>
        </div>

    </div>
</div>
@endsection
