<!DOCTYPE html>
<html lang="{{ \Lang::getLocale() }}">
   <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="description" content="A ETEC Social é a rede social da ETEC, nela será possivel compartilhar e adquirir conhecimento e se entreter junto a comunidade etequiana." /> 
      <meta name="keywords" content="ETEC Social, ETEC, Escola Técnica, Rede Social, São Paulo, Centro Paula Souza, CPS, Conhecimento, Compartilhar, Amigos, Escola ETEC" />
      <meta property="og:site_name" content="ETEC Social">
      <meta property="og:title" content="ETEC Social - Entre, conheça ou cadastre-se.">

      <title>@yield('title')</title>

      {!! MaterializeCSS::include_css() !!}
      @yield('style')
   </head>
   <body>
    @yield('content')
    <script src="//code.jquery.com/jquery-2.1.1.min.js"></script>
    {!! MaterializeCSS::include_js() !!}
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    @yield('jscript2')
    @yield('jscript')
 </body>
</html>