<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }} Dashboard</title>
    <link rel="icon" href="{{asset('/images/logo/l.png')}}">
    <style>
        #loader {
            transition: all .3s ease-in-out;
            opacity: 1;
            visibility: visible;
            position: fixed;
            height: 100vh;
            width: 100%;
            background: #fff;
            z-index: 90000
        }

        #loader.fadeOut {
            opacity: 0;
            visibility: hidden
        }

        .spinner {
            width: 40px;
            height: 40px;
            position: absolute;
            top: calc(50% - 20px);
            left: calc(50% - 20px);
            background-color: #333;
            border-radius: 100%;
            -webkit-animation: sk-scaleout 1s infinite ease-in-out;
            animation: sk-scaleout 1s infinite ease-in-out
        }

        @-webkit-keyframes sk-scaleout {
            0% {
                -webkit-transform: scale(0)
            }
            100% {
                -webkit-transform: scale(1);
                opacity: 0
            }
        }

        @keyframes sk-scaleout {
            0% {
                -webkit-transform: scale(0);
                transform: scale(0)
            }
            100% {
                -webkit-transform: scale(1);
                transform: scale(1);
                opacity: 0
            }
        }
        .header.navbar {

            position: absolute;

        }
    </style>
    <link href="https://cdn.jsdelivr.net/gh/lykmapipo/themify-icons@0.1.2/css/themify-icons.css" rel="stylesheet">
    <link href="{{ asset('Admin/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('Admin/css/flaticon.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('Admin/css/croppie.css') }}"/>
    <link rel="stylesheet" href="{{ asset('Admin/css/font-awesome.min.css') }}"/>
    <link href="http://netdna.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/star-rating.min.css')}}" media="all" type="text/css" />
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="{{asset('Admin/js/bootstrap-3.3.2.min.js')}}"></script>
</head>
<body class="app">
<div id='loader'>
    <div class="spinner"></div>
</div>

<script>
    window.addEventListener('load', () => {
        const loader = document.getElementById('loader');
        setTimeout(() => {
            loader.classList.add('fadeOut');
        }, 300);
    });
</script>
<div>
    <!-- #Left Sidebar ==================== -->
    @if(auth()->user()->isAdmin())
        @include('Admin.Layout.sidebar')
    @elseif(auth()->user()->isAdvertiser())
        @include('Admin.Layout.sidebar-advertiser')
    @endif

    <!-- #Main ============================ -->
    <div class="page-container">
        <!-- ### $Topbar ### -->
        @include('Admin.Layout.navbar')
