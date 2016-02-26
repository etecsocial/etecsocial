@extends('app')

@section('title')
ETEC Social
@stop

@section('style')
<link href="js/plugins/fullcalendar/css/fullcalendar.min.css" type="text/css" rel="stylesheet" media="screen,projection">
<link href="css/asset.css" type="text/css" rel="stylesheet" media="screen,projection">
<link href="css/style.css" type="text/css" rel="stylesheet" media="screen,projection">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
@stop

@section('jscript')
<script type="text/javascript" src="js/jquery-1.11.2.min.js"></script>
<script type="text/javascript" src="js/plugins/lightbox-plus-jquery.min.js"></script>
<script type="text/javascript" src="js/materialize.js"></script>
<script type="text/javascript" src="js/form.min.js"></script>
  
<script type="text/javascript" src="js/plugins/jquery.nanoscroller.min.js"></script>
<script type="text/javascript" src="js/plugins/sparkline/jquery.sparkline.min.js"></script>
<script type="text/javascript" src="js/plugins/sparkline/sparkline-script.js"></script>
<script type="text/javascript" src="js/plugins/jquery.bxslider.min.js"></script>
<script type="text/javascript" src="js/plugins/sliders.js"></script>
<script type="text/javascript" src="js/plugins/succinct-master/jQuery.succinct.min.js"></script>
<script type="text/javascript" src="js/jquery.tagsinput.min.js"></script>
 <!-- Calendar Script -->
        <script type="text/javascript" src="js/plugins/fullcalendar/lib/jquery-ui.custom.min.js"></script>
        <script type="text/javascript" src="js/plugins/fullcalendar/lib/moment.min.js"></script>
        <script type="text/javascript" src="js/plugins/fullcalendar/js/fullcalendar.min.js"></script>
        <script type="text/javascript" src="js/plugins/fullcalendar/fullcalendar-script.js"></script>
<script type="text/javascript" src='js/script.js'></script>
<script type="text/javascript" src="js/plugins.js"></script>
<script>


$('#excluir').ajaxForm({
        type: "DELETE",
        dataType: 'JSON',
        success: function (data) {
            if (data.status) {
                  $('#calendar').fullCalendar( 'refetchEvents' );
            } else {
                Materialize.toast('<span>Você não pode excluir esse evento</span>', 3000);
            }
        }
    });
    </script>

@stop

@section('content')

@include('nav')
                <section id="content">

                    <!--breadcrumbs start-->
                    <div id="breadcrumbs-wrapper" class=" grey lighten-3">
                        <!-- Search for small screen -->
                        <div class="header-search-wrapper grey hide-on-large-only">
                            <i class="mdi-action-search active"></i>
                            <input type="text" name="Search" class="header-search-input z-depth-2" placeholder="Explore Materialize">
                        </div>
                        <div class="container">
                            <div class="row">
                                <div class="col s12 m12 l12">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--breadcrumbs end-->


                    <!--start container-->
                    <div class="container">
                        <div class="section">
                            <p class="caption">Agenda de estudos</p>
                         Crie eventos para datas de provas, trabalhos, apresentações, seminários e etc.
                       {{ Auth::User()->tipo == 1 ? 'Caso queira, crie eventos compartilhados com sua turma!' : 'Professor, lembre-se que você pode adicionar eventos para as turmas as quais você leciona!' }}</p>
                            <div class="divider"></div>
                            
                            
                            <div style="margin-top:10px">
                                                        <a href="#novoevento" class="wino btn waves-effect waves-light cyan darken-2">Adicionar evento</a>
                                                        <div>               
                            
                           <div id="full-calendar">              
              
                <div class="col s12 m6 l9">
                  <div id="calendar"></div>
                  
                </div>
              </div>
            </div>
                            </div>
                        </div>

                       
                    </div>
                    <!--end container-->
                </div>
                </section>
<div id="evento" class="modal" data-target="evento">
    <form action="" id="excluir" method="DELETE">
        <input type="hidden" id="iduser" value="{{ Auth::user()->id }}">
        
        <div class="modal-content">
            <h4 id="agenda-title"></h4>
            <i id="opcoes" style="display:none">
                <i id="data-opcoes"></i>
                <form action="" id="excluir" method="DELETE">
                      
                    <button type="submit" style="margin-left:-45px" class="modal-action modal-close btn-flat">&nbsp;&nbsp;&nbsp; (Excluir)</button>
                  </form>
            </i>
            <i id="user" style="display:none"></i>
            <p id="agenda-content"></p>
        </div>
        <div class="modal-footer">
               
                    <a class="modal-action modal-close waves-effect waves-red btn-flat ">Fechar</a>
            
        </div>
    </form>
</div>


            @include('footer')
@stop