@extends('app')

@section('title')
Mensagens | ETEC Social
@stop

@section('style')
{!! Html::style('css/font.css') !!}
{!! Html::style('css/asset.css') !!}
{!! Html::style('css/style.css') !!}
@stop

@section('jscript')
{!! Html::script('js/jquery-1.11.2.min.js') !!}
{!! Html::script('js/plugins/lightbox-plus-jquery.min.js') !!}
{!! Html::script('js/materialize.js') !!}
{!! Html::script('js/firebase.js') !!}
{!! Html::script('js/form.min.js') !!}
{!! Html::script('js/plugins/jquery.nanoscroller.min.js') !!}
{!! Html::script('js/plugins/sparkline/jquery.sparkline.min.js') !!}
{!! Html::script('js/plugins/sparkline/sparkline-script.js') !!}
{!! Html::script('js/plugins/jquery.bxslider.min.js') !!}
{!! Html::script('js/plugins/sliders.js') !!}
{!! Html::script('js/plugins/succinct-master/jQuery.succinct.min.js') !!}
{!! Html::script('js/jquery.tagsinput.min.js') !!}
{!! Html::script('js/script.js') !!}
{!! Html::script('js/plugins.js') !!}
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