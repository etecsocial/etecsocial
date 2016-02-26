@extends('app')

@section('title')
ETEC Social
@stop

@section('style')
<link href="css/asset.css" type="text/css" rel="stylesheet" media="screen,projection">
<link href="css/style.css" type="text/css" rel="stylesheet" media="screen,projection">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
@stop

@section('jscript')
<script type="text/javascript" src="js/jquery-1.11.2.min.js"></script>
<script type="text/javascript" src="js/plugins/lightbox-plus-jquery.min.js"></script>
<script type="text/javascript" src="js/materialize.js"></script>
<script type="text/javascript" src='js/firebase.js'></script>
<script type="text/javascript" src="js/form.min.js"></script>
<script type="text/javascript" src="js/plugins/jquery.nanoscroller.min.js"></script>
<script type="text/javascript" src="js/plugins/sparkline/jquery.sparkline.min.js"></script>
<script type="text/javascript" src="js/plugins/sparkline/sparkline-script.js"></script>
<script type="text/javascript" src="js/plugins/jquery.bxslider.min.js"></script>
<script type="text/javascript" src="js/plugins/sliders.js"></script>
<script type="text/javascript" src="js/plugins/succinct-master/jQuery.succinct.min.js"></script>
<script type="text/javascript" src="js/jquery.tagsinput.min.js"></script>
<script type="text/javascript" src='js/script.js'></script>
<script type="text/javascript" src="js/plugins.js"></script>
<script>
   
</script>
@stop

@section('content')

@include('nav')
                <section id="content">

                    <!--start container-->
                    <div class="container">

                        <div id="mail-app" class="section">
                            <div class="row">
                                <div class="col s12">
                                    <div id="email-list" class="col s10 m4 l4 card-panel z-depth-1">
                                        <ul class="collection">
                                          
                                        </ul>
                                    </div>
                                    <div id="email-details" class="col s12 m7 l7 card-panel" style="padding-right: 0">
                                        <div id="msgs" class="email-content-wrap">
                                            <p>Recurso não disponível.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        
                        </div>

                    </div>
                    <!--end container-->

                </section>
                <!-- END CONTENT -->

             @stop