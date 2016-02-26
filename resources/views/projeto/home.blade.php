@extends('app')

@section('title')
O Projeto | ETEC Social
@stop

@section('style')
<link href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.1.1/css/bootstrap.min.css" rel="stylesheet">
<link href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
<link href="{{ env('ASSETS_URL') }}/custom/1.5/css/ihover.min.css" rel="stylesheet">
<link href="{{ env('ASSETS_URL') }}/custom/1.5/css/animate.min.css" rel="stylesheet">
<link href="{{ env('ASSETS_URL') }}/custom/1.5/css/projeto.min.css" rel="stylesheet">
<link href='//fonts.googleapis.com/css?family=Open+Sans:400,300,400italic,700,800' rel="stylesheet">
@stop

@section('jscript')
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.11.1/jquery.validate.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/wow/1.0.2/wow.min.js"></script>
<script src="{{ env('ASSETS_URL') }}/custom/1.5/js/jquery.singlePageNav.min.js"></script>
<script src="{{ env('ASSETS_URL') }}/custom/1.5/js/projeto.min.js"></script>
@stop

@section('content')
<!-- start preloader -->
<div class="preloader">
    <div class="sk-spinner sk-spinner-rotating-plane"></div>
</div>
<!-- end preloader -->
<!-- start navigation -->
<nav class="navbar navbar-default navbar-fixed-top templatemo-nav" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="icon icon-bar"></span>
                <span class="icon icon-bar"></span>
                <span class="icon icon-bar"></span>
            </button>
            <a href="#" class="navbar-brand">O Projeto</a>
        </div>
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav navbar-right text-uppercase">
                <li><a href="#home">INÍCIO</a></li>
                <li><a href="#conheca">CONHEÇA</a></li>
                <li><a href="#team">DESENVOLVEDORES</a></li>
                <li><a href="#contact">CONTATO</a></li>
            </ul>
        </div>
    </div>
</nav>
<!-- end navigation -->
<!-- start home -->
<section id="home">
    <div class="overlay">
        <div class="container">
            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-10 wow fadeIn" data-wow-delay="0.3s">
                    <h1 class="text-upper animated wow fadeInDown clearfix">Aprender nunca foi tão divertido!</h1>
                    <p class="tm-white">
                        Com a ETEC Social, você poderá se conectar com seus amigos
                        e compartilhar conhecimentos, afim de obter um maior rendimento escolar
                        de uma forma divertida e interativa. Crie grupos de estudos, avalie suas
                        habilidades e se prepare para o vestibular!
                    </p>
                    <img src="{{ env('ASSETS_URL') }}/custom/1.5/imagens/projeto/software.png" class="img-responsive" alt="home img">
                </div>
                <div class="col-md-1"></div>
            </div>
        </div>
    </div>
</section>
<!-- end home -->
<!-- start divider -->
<section id="divider">
    <div class="container">
        <div class="row">
            <div class="col-md-4 wow fadeInUp templatemo-box" data-wow-delay="0.3s">
                <img src="{{ env('ASSETS_URL') }}/custom/1.5/imagens/projeto/icon1.png" width="105px">
                <h3 class="text-uppercase">GRUPOS DE ESTUDO</h3>
                <p class="text-justify">
                    Ao se aproximar da semana de provas, alunos poderão criar grupos de estudo
                    sobre determinada disciplina. Tal grupo terá um local que sugerirá fontes de estudo
                    sobre a matéria, além de ser possível realizar desafios aos membros destes grupos.
                </p>
            </div>
            <div class="col-md-4 wow fadeInUp templatemo-box" data-wow-delay="0.3s">
                <img src="{{ env('ASSETS_URL') }}/custom/1.5/imagens/projeto/icon2.png" width="105px">
                <h3 class="text-uppercase">AGENDA DE ESTUDOS</h3>
                <p class="text-justify">
                    A Agenda de estudos será uma ferramenta que possibilitará o agendamento de
                    provas, trabalhos e apresentações tanto pelo professor quanto pelo aluno.
                    O sistema então irá sugerir a criação de grupos de estudos 
                    para auxiliar o aluno.
                </p>
            </div>
            <div class="col-md-4 wow fadeInUp templatemo-box" data-wow-delay="0.3s">
                <img src="{{ env('ASSETS_URL') }}/custom/1.5/imagens/projeto/icon3.png" width="105px">
                <h3 class="text-uppercase">DESAFIOS</h3>
                <p class="text-justify">
                    Com o sistema de Reputação, alunos poderão desafiar seus colegas afim de 
                    adiquirir pontuação. Tais desafios consistirão tanto em questões de vestibular
                    quanto outros tipos, que serão sugeridos pelo sistema.
                </p>
            </div>
        </div>
    </div>
</section>
<!-- end divider -->
<section id="conheca">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12 text-justify wow fadeInLeft" data-wow-delay="0.6s">
                <h2>O que é?</h2>
                <br>
                <p style="font-size:15px">A ETEC Social é um Projeto de Conclusão de Curso idealizado por alguns dos alunos do 3º Ano do Ensino Médio Integrado a Informática para Internet/Turma 2015 da instituição de ensino ETEC Pedro Ferreira Alves de Mogi Mirim/SP. O projeto visa criar um ambiente social na internet entre os alunos da comunidade escolar com objetivo de tornar a comunicação entre os membros internos da instituição mais presente, facilitando para todas as partes.</p>
            </div>    
	</div>
      </div>
</section>
<!-- start feature -->
<section id="conheca">
    <div class="container">
        <div class="row">
            <div class="col-md-6 wow fadeInLeft" data-wow-delay="0.6s">
                <h2 class="text-uppercase">Interface amigável</h2>
                <p>
                    Com uma interface simples e interativa, pretendemos proporcionar a todos uma
                    experiência única e inspiradora, afim de incentivar o interesse do aluno pelos estudos.
                </p>
                <p><span><i class="fa fa-pencil"></i></span>
                    Deixe seus amigos por dentro do que você está fazendo!
                    <br>Atualize seu status em 3 passos, é simples!
                </p>
                <p><i class="fa fa-search"></i>
                    Encontre tudo e quem precisar a qualquer momento.
                </p>
            </div>
            <div class="col-md-6 wow fadeInRight" data-wow-delay="0.6s">
                <img src="{{ env('ASSETS_URL') }}/custom/1.5/imagens/projeto/perfil.png" class="img-responsive" alt="feature img">
            </div>
        </div>
    </div>
</section>
<!-- end feature -->
<!-- start feature1 -->
<section id="conheca">
    <div class="container">
        <div class="row">
            <div class="col-md-6 wow fadeInLeft" data-wow-delay="0.6s">
                <img src="{{ env('ASSETS_URL') }}/custom/1.5/imagens/projeto/mobile.png" class="img-responsive" alt="feature img">
            </div>
            <div class="col-md-6 wow fadeInUp" data-wow-delay="0.6s">
                <h2 class="text-uppercase">Acesse de onde estiver</h2>
                <p>
                    Com uma interface Mobile Friendly, a ETEC Social poderá ser acessada através de qualquer
                    ispositivo, seja ele Desktop, Notebook, Tablet ou Smartphone!
                </p>
                <p><span><i class="fa fa-mobile"></i></span>
                    O usuário terá uma experiência nova em cada dispositivo.</p>
                <p><i class="fa fa-book"></i>Discuta, aprenda e tire dúvidas onde estiverem.</p>
            </div>
        </div>
    </div>
</section>
<!-- end feature1 -->
<!-- start pricing -->
<section id="team" class="text-center">
    <div class="container">
        <h2 class="text-uppercase text-left">DESENVOLVEDORES</h2><hr class="divider">
        <div class="row">
	     <div class="col-md-4 wow fadeInUp templatemo-box" data-wow-delay="0.3s">
                <div class="mg-image">
                    <img class="img-circle" width="130px" height="125px" src="{{ env('ASSETS_URL') }}/custom/1.5/imagens/equipe/marcio.jpg">
                </div>
                <h3 class="text-uppercase">Marcio Simões</h3>
                <h4 class="text-muted">Programador</h4>
                <p>
                    "Exatas é uma área fascinante, meu gosto pela matemática desencadeou uma maior facilidade pela programação, 
                    que nos dias atuais é o que me move"
                </p>
                <div class="social-icon">
                    <a href="https://www.facebook.com/marcinhosimoes" target="_blank"><i class="icon-facebook"></i></a>
                    <a href="https://twitter.com/eamarcio" target="_blank"><i class="icon-twitter"></i></a>
                    <a href="https://www.google.com/+MarcioSimoesJr"><i class="icon-googleplus"></i></a>
                    <a href="mailto:marcio@etecsocial.com.br"><i class="icon-mail"></i></a>
                </div>
		<hr class="divider">
            </div>
	    <div class="col-md-4 wow fadeInUp templatemo-box" data-wow-delay="0.3s">
                <div class="mg-image">
                    <img class="img-circle" width="130px" height="125px" src="{{ env('ASSETS_URL') }}/custom/1.5/imagens/equipe/jhow.jpg">
                </div>
                <h3 class="text-uppercase">Jhonatan Lopes</h3>
                <h4 class="text-muted">Web Designer/Programador</h4>
                <p>
                    "Ser desenvolvedor é uma viagem onde a próxima parada é a solução de um problema, que na verdade não passa de um desafio não descoberto."
                </p>
                <div class="social-icon">
                    <a href="https://www.facebook.com/jhow98" target="_blank"><i class="icon-facebook"></i></a>
                    <a href="https://twitter.com/jhonatanlopes98" target="_blank"><i class="icon-twitter"></i></a>
                    <a href="https://plus.google.com/u/0/110334746808157248708"><i class="icon-googleplus"></i></a>
                    <a href="mailto:jhonatan@etecsocial.com.br"><i class="icon-mail"></i></a>
                </div>
		<hr class="divider">
            </div>
            <div class="col-md-4 wow fadeInUp templatemo-box" data-wow-delay="0.3s">
                <div class="mg-image">
                    <img class="img-circle" width="130px" height="125px" src="{{ env('ASSETS_URL') }}/custom/1.5/imagens/equipe/juninho.jpg">
                </div>
                <h3 class="text-uppercase">Antonio Zavarize</h3>
                <h4 class="text-muted">Web Designer</h4>
                <p>
                    "Para mim desenvolver para web é algo fascinante: No começo, tudo não passa de uma tela, no final,
                    torna-se algo interativo e útil para muitas pessoas..."
                </p>
                <div class="social-icon">
                    <a href="https://www.facebook.com/juninho.zavarise" target="_blank"><i class="icon-facebook"></i></a>
                    <a href="https://twitter.com/juuninhoz" target="_blank"><i class="icon-twitter"></i></a>
                    <a href="ttps://plus.google.com/u/0/117333523205680298691"><i class="icon-googleplus"></i></a>
                    <a href="mailto:junior@etecsocial.com.br"><i class="icon-mail"></i></a>
                </div>
                <hr class="divider">
            </div>
         </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-4 wow fadeInUp templatemo-box" data-wow-delay="0.3s">
                <div class="mg-image">
                    <img class="img-circle" width="130px" height="125px" src="{{ env('ASSETS_URL') }}/custom/1.5/imagens/equipe/gomide.jpg">
                </div>
                <h3 class="text-uppercase">Matheus Gomide</h3>
                <h4 class="text-muted">Produtor/Designer Gráfico</h4>
                <p>
                    "Você é o produtor do própio filme da sua vida, se fará um bom filme, ou um mal filme tudo depende simplesmente de você. "
                </p><br>
                <div class="social-icon">
                    <a href="https://www.facebook.com/matheeusgoomide" target="_blank"><i class="icon-facebook"></i></a>
                    <a href="#" target="_blank"><i class="icon-twitter"></i></a>
                    <a href="#"><i class="icon-googleplus"></i></a>
                    <a href="mailto:gomide@etecsocial.com.br"><i class="icon-mail"></i></a>
                </div>
		<hr class="divider">
            </div>
            <div class="col-md-4 wow fadeInUp templatemo-box" data-wow-delay="0.3s">
                <div class="mg-image">
                    <img class="img-circle" width="130px" height="125px" src="{{ env('ASSETS_URL') }}/custom/1.5/imagens/equipe/beatriz.jpg">
                </div>
                <h3 class="text-uppercase">Beatriz Volpone</h3>
                <h4 class="text-muted">Escritora</h4>
                <p>
                    "Bucarei produzir um trabalho com escrita excepcional, sempre expondo os recursos e funcionalidades do sistema desenvolvido à
                    qualquer um que o venha ler"
                </p>
                <div class="social-icon">
                    <a href="https://www.facebook.com/beatriz.volpone" target="_blank"><i class="icon-facebook"></i></a>
                    <a href="#" target="_blank"><i class="icon-twitter"></i></a>
                    <a href="#"><i class="icon-googleplus"></i></a>
                    <a href="mailto:beatriz@etecsocial.com.br"><i class="icon-mail"></i></a>
                </div>
                <hr class="divider">
            </div>
            <div class="col-md-4 wow fadeInUp templatemo-box" data-wow-delay="0.3s">
                <div class="mg-image">
                    <img class="img-circle" width="130px" height="125px" src="{{ env('ASSETS_URL') }}/custom/1.5/imagens/equipe/gustavo.jpg">
                </div>
                <h3 class="text-uppercase">Gustavo Salles</h3>
                <h4 class="text-muted">Escritor</h4>
                <p>
                    "Vai ser um grande desafio, fazer a escrita de um trabalho tão complexo e abrangente, mas são os desafios que me movem,
                    este é meu lema!"
                </p>
                <div class="social-icon">
                    <a href="https://www.facebook.com/GustavoSallesz" target="_blank"><i class="icon-facebook"></i></a>
                    <a href="https://twitter.com/Guu_Salles" target="_blank"><i class="icon-twitter"></i></a>
                    <a href="https://plus.google.com/u/0/110097447648481053055"><i class="icon-googleplus"></i></a>
                    <a href="mailto:gustavo@etecsocial.com.br"><i class="icon-mail"></i></a>
                </div>
                <hr class="divider">
            </div>
	</div>
    </div>
</section>
<!-- end pricing -->
<!-- start download -->
<section id="news">
    <div class="container">
        <div class="row">
            <div class="col-md-6 wow fadeInLeft" data-wow-delay="0.6s">
                <h2 class="text-uppercase">Gostou do projeto?</h2>
                <p>Assine nossa Newsletter e fique por dentro do andamento do projeto!</p>
                <p>Fique tranquilo, também não gostamos de SPAM, vamos lhe enviar somente o 
                    que lhe será útil.</p>
                <form action="//etecsocial.us11.list-manage.com/subscribe/post?u=07af9785cad39d26d013956cd&amp;id=829c1c06ce" method="POST">
                    <input type="email" name="EMAIL" class="form-control" placeholder="Digite seu melhor E-mail" required><br>
                    <button type="submit" class="btn btn-danger text-uppercase"> EU GOSTEI!</button>
                </form>
            </div>
            <div class="col-md-6 wow fadeInRight" data-wow-delay="1s">
                <img src="{{ env('ASSETS_URL') }}/custom/1.5/imagens/projeto/newsletter.png">
            </div>
        </div>
    </div>
</section>
<!-- end download -->
<!-- start contact -->
<section id="contact">
    <div class="overlay">
        <div class="container">
            <div class="row">
                <div class="col-md-6 wow fadeInUp" data-wow-delay="0.6s">
                    <h2 class="text-uppercase">ENTRE EM CONTATO</h2>
                    <p>Dúvidas, sugestões e etc? Entre em contato com a gente: </p>
                    <address>
                        <p><i class="fa fa-facebook"></i><a href="https://facebook.com/etecsoc" target="_blank"><font style="color: #fff">facebook.com/etecsoc</font></a></p>
                        <p><i class="fa fa-twitter"></i> <a href="https://twitter.com/etecsocial" target="_blank"><font style="color: #fff">twitter.com/etecsocial</font></a></p>
                        <p><i class="fa fa-envelope-o"></i> <a href="mailto:contato@etecsocial.com"><font style="color: #fff">contato@etecsocial.com</font></a></p>
                    </address>
                </div>
                <div class="col-md-6 wow fadeInUp" data-wow-delay="0.6s">
                    <div class="contact-form">
                        <form  role="form" id="enviar" method="POST">
                            <input name="_token" type="hidden" value="{{ csrf_token() }}">
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="nome" placeholder="Nome">
                            </div>
                            <div class="col-md-6">
                                <input type="email" class="form-control" name="email" placeholder="Email">
                            </div>
                            <div class="col-md-12">
                                <textarea class="form-control" placeholder="Mensagem" style="resize:none" name="msg" rows="4"></textarea>
                            </div>
                            <div class="col-md-8">
                                <input type="submit" class="form-control text-uppercase" id="botao-submit" data-loading-text="Enviando..." value="Enviar">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- end contact -->
<!-- start footer -->
<footer>
    <div class="container">
        <div class="row">
            <p>Copyright © 2015 ETEC Social</p>
        </div>
    </div>
</footer>
<!-- end footer -->
<div class="modal fade bs-example-modal-sm" id="myModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel"></h4>
            </div>
            <div class="modal-body" id="modal-body"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-submit" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>
@stop