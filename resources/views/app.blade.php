<!DOCTYPE html>
<html lang="pt-br" dir="ltr">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="description" content="A ETEC Social é a rede social da ETEC, nela será possivel compartilhar e adquirir conhecimento e se entreter junto a comunidade etequiana." /> 
<meta name="author" content="Antonio Carlos, Beatriz Volpone, Gustavo Salles, Jhonatan Lopes, Marcio Simões, Matheus Gomide" />
<meta name="keywords" content="ETEC Social, ETEC, Escola Técnica, Rede Social, São Paulo, Centro Paula Souza, CPS, Conhecimento, Compartilhar, Amigos, Escola ETEC" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta property="og:site_name" content="ETEC Social">
<meta property="og:title" content="ETEC Social - Entre, conheça ou cadastre-se.">
@yield('style')
<title>@yield('title')</title>
<!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>
<body>
@yield('content')
@yield('jscript')
<script>$.ajaxSetup({headers:{"X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr("content")}});</script>
<!--<script>$(document).ajaxError(function(e,xhr,settings,exception){if(xhr.status==401){ window.location.assign("/auth/logout");}});</script>-->
</body>
</html>