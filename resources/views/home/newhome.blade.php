@extends('app')
@section('title')
ETEC Social | Compartilhando conhecimentos
@stop

@section('style')
{!! Html::style('https://fonts.googleapis.com/icon?family=Material+Icons') !!}
{!! Html::style('http://materializecss.com/dist/css/materialize.min.css') !!}
{!! Html::style('css/style-new.css') !!}
@stop

@section('jscript')
{!! Html::script('//cdnjs.cloudflare.com/ajax/libs/jquery/1.11.2/jquery.min.js') !!}
{!! Html::script('//cdnjs.cloudflare.com/ajax/libs/materialize/0.97.0/js/materialize.min.js') !!}
{!! Html::script('//cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.11.1/jquery.validate.min.js') !!}
{!! Html::script('js/plugins/tokenize/jquery.tokenize.js') !!}

<script>
    $(document).ready(function () {
        $('.modal-trigger').leanModal();
        $('.button-collapse').sideNav();
        $('select').material_select();
    });

    function turmas() {
        var escola = $('#escola').val();

        if (escola) {
            var url = '/ajax/cadastro/turmas?escola=' + escola;
            $.get(url, function (dataReturn) {
                $('#loadturmas').html(dataReturn);
                $('#loadturmas').material_select();
                $('.caret').hide();
            });
        }
    }
</script>
@stop

@section('content')
<nav class="red darken-1" role="navigation">
    <div class="nav-wrapper container"><a id="logo-container" href="#" class="brand-logo">ETEC Social</a>
        <ul class="right hide-on-med-and-down">
            <li><a href="#">Sobre</a></li>
            <li><a href="#termos" class="modal-trigger">Termos</a></li>
            <li><a href="#privacidade" class="modal-trigger">Privacidade</a></li>
        </ul>

        <ul id="nav-mobile" class="side-nav">
            <li><a href="#entrar" class="modal-trigger">Entrar</a></li>
            <li><a href="#cadastrar" class="modal-trigger">Cadastrar</a></li>
            <li><a href="#sobre" class="modal-trigger">Sobre</a></li>
            <li><a href="#termos" class="modal-trigger">Termos</a></li>
            <li><a href="#privacidade" class="modal-trigger">Privacidade</a></li>
        </ul>
        <a href="#" data-activates="nav-mobile" class="button-collapse"><i class="material-icons">menu</i></a>
    </div>
</nav>

<div id="index">
    <div class="section no-pad-bot">
        <div class="container">
            <br><br>
            <h1 class="header center red-text text-darken-2 hide-on-med-and-down">Entre na rede com seus amigos!</h1>
            <div class="row center">
                <h5 class="header col s12 red-text">Compartilhe conhecimentos juntos e desafie seus amigos!</h5>
            </div>
            <div class="row center">
                <a href="#entrar" id="entrar-button" class="btn-large waves-effect waves-light red lighten-1 modal-trigger">Entrar</a>
                <a href="#cadastrar" id="cadastrar-button" class="btn-large waves-effect waves-light red darken-2 modal-trigger">Cadastrar-se</a>
            </div>
        </div>
    </div>
</div>

<div class="container" id="site-features">
    <div class="section">
        <div class="row">
            <div class="col s12 m4">
                <div class="icon-block">
                    <h2 class="center red-text"><i class="material-icons">flash_on</i></h2>
                    <h5 class="center">Grupos de Estudos</h5>

                    <p class="text-justify">Ao se aproximar da semana de provas, alunos poderão criar grupos de estudo sobre determinada disciplina. Tal grupo terá um local que sugerirá fontes de estudo sobre a matéria, além de ser possível realizar desafios aos membros destes grupos.</p>
                </div>
            </div>

            <div class="col s12 m4">
                <div class="icon-block">
                    <h2 class="center red-text"><i class="material-icons">group</i></h2>
                    <h5 class="center">Agenda de Estudos</h5>

                    <p class="text-justify">A Agenda de estudos será uma ferramenta que possibilitará o agendamento de provas, trabalhos e apresentações tanto pelo professor quanto pelo aluno. O sistema então irá sugerir a criação de grupos de estudos para auxiliar o aluno.</p>
                </div>
            </div>

            <div class="col s12 m4">
                <div class="icon-block">
                    <h2 class="center red-text"><i class="material-icons">settings</i></h2>
                    <h5 class="center">Desafios</h5>

                    <p class="text-justify">Com o sistema de Reputação, alunos poderão desafiar seus colegas afim de adiquirir pontuação. Tais desafios consistirão tanto em questões de vestibular quanto outros tipos, que serão sugeridos pelo sistema.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="section">
        <div class="row">
            <div class="col s12 ">
                <div class="video-container">
                    <iframe width="1280" height="720" src="https://www.youtube.com/embed/pAfiLcMJ7q8?rel=0&amp;showinfo=0" frameborder="0" allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </div>
</div>

<footer class="page-footer blue">
    <div class="container">
        <div class="row">
            <div class="col l6 s12">
                <h5 class="white-text">ETEC Social</h5>
                <p class="grey-text text-lighten-4">O projeto visa criar um ambiente social na internet entre os alunos da comunidade escolar com objetivo de tornar a comunicação entre os membros internos da instituição mais presente, facilitando para todas as partes.</p>
            </div>
            <div class="col l3 s12">
                <h5 class="white-text">Links</h5>
                <ul>
                    <li><a class="white-text modal-trigger" href="#sobre">Sobre o projeto</a></li>
                    <li><a class="white-text modal-trigger" href="#termos">Termos de uso</a></li>
                    <li><a class="white-text modal-trigger" href="#privacidade">Privacidade</a></li>
                    <li><a class="white-text modal-trigger" href="#contato">Contato</a></li>
                </ul>
            </div>
            <div class="col l3 s12">
                <h5 class="white-text">Contato</h5>
                <ul>
                    <li><a class="white-text" href="https://www.facebook.com/etecsoc/">facebook.com/etecsoc</a></li>
                    <li><a class="white-text" href="https://twitter.com/etecsocial">twitter.com/etecsocial</a></li>
                    <li><a class="white-text" href="mailto:contato@etecsocial.com">contato@etecsocial.com</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="footer-copyright">
        <div class="container">
            Copyright © {{ date('Y') }} ETEC Social | Feito com <3.</a>
        </div>
    </div>
</footer>

<div id="termos" class="modal modal-fixed-footer">
    <div class="modal-content">
        <h4>Termos de Uso</h4>
        <p>Ao utilizar e participar de forma ativa na ETEC Social, de qualquer das formas que o website permite, o Utilizador declara ter lido e aceitar cumprir os presentes Termos e Condições. A ETEC Social reserva-se o direito – mas não a obrigação – de, perante o não cumprimento destes Termos e Condições, eliminar todo e qualquer conteúdo que os infrinja, bem como restringir e/ou bloquear o acesso do Utilizador infrator à participação no website, sem qualquer aviso prévio.</p>
        <p>Na utilização que fizer deste website (incluindo na submissão, envio ou publicação de conteúdos que fizer para a ETEC Social), o Utilizador está obrigado e declara aceitar e cumprir a legislação aplicável, e concretamente o Código do Direito de Autor e dos Direitos Conexos, o Código da Propriedade Industrial e a Lei da Criminalidade Informática.</p>
        <p>O Utilizador está também obrigado a declarar agir de boa-fé e a fazer uma utilização da ETEC Social que não ofenda quaisquer direitos de terceiros. Particularmente, compromete-se a não submeter qualquer conteúdo ou fazer uma participação que constitua qualquer ataque em função da raça, nacionalidade, origem étnica, religião, convicção política ou sexo; que constitua difamação, incitação ao furto, fraude, violência, terrorismo, sadismo, prostituição, pedofilia, bem como que empregue conteúdos de carácter obsceno, indecoroso ou pornográfico.</p>
        <p>O Utilizador apenas está autorizado a fazer uso dos conteúdos presentes na ETEC Social para fins estritamente pessoais, sendo-lhe expressamente proibido publicar, reproduzir, difundir, distribuir ou, por qualquer outra forma, tornar os conteúdos acessíveis a terceiros, para fins de comunicação pública ou de comercialização, como por exemplo colocando-os disponíveis noutro site, serviço on-line ou em cópias de papel. Está igualmente vedada qualquer transformação dos conteúdos.</p>
        <p>É também expressamente proibido ao Utilizador criar ou introduzir na ETEC Social tipos de vírus ou programas que o danifiquem, direta ou indiretamente.</p>
        <p>A ETEC Social, e o respectivo conteúdo, tem finalidade exclusivamente lúdica, pelo que nada neste website constitui um conselho, não dispensando o conselho profissional, nem estabelece qualquer relação contratual.</p>
        <p>O Utilizador é o único responsável pelos prejuízos, diretos ou indiretos, causados a si próprio, a ETEC Social ou a terceiros, relacionados com a utilização que fizer da ETEC Social, comprometendo-se a proceder às indenizações necessárias, em virtude de qualquer ação, reclamação ou condenação a que essa utilização dê origem.</p>
        <p>A ETEC Social não garante que os serviços prestados por este website funcionem de forma contínua ou que se encontrem livres de erros, vírus ou outros elementos prejudiciais.</p>
        <p>A ETEC Social não é responsável pela exatidão, qualidade, segurança, legalidade ou licitude, incluindo o cumprimento das regras respeitantes a direitos de autor e direitos conexos, relativamente aos conteúdos, produtos ou serviços contidos neste website que tenham sido criados ou fornecidos por membros, utilizadores, anunciantes ou parceiros comerciais, bem como por qualquer informação contida em sites de terceiros para os quais este website estabeleça ligações.<p>
        <p>O Utilizador declara autorizar, a título gratuito, a divulgação, publicação, utilização e exploração dos conteúdos, textos, dados, imagens ou programas por si enviados para a ETEC Social.<p>
        <p>O Utilizador declara igualmente que:<br>
            tem plena legitimidade para autorizar a utilização previamente mencionada e, concretamente, que obteve e dispõe dos necessários direitos e autorizações a título de direitos de autor e assegurou os pagamentos eventualmente devidos a terceiros legítimos titulares de direitos sobre os conteúdos, textos, dados, imagens ou programas por si enviados para a ETEC Social, para efeitos da sua utilização nos termos previstos na presente declaração; sobre o direito de autorizar a utilização dos conteúdos, textos, dados, imagens ou programas por si enviados para a ETEC Social constantes da presente declaração, não existe qualquer reclamação ou processo instaurado ou alguma contestação relativamente à sua titularidade por parte de terceiros; não existe nenhum compromisso nem nenhuma condição decorrente de relações jurídicas eventualmente existentes entre o Utilizador e terceiros que impeça ou condicione, de algum modo, a execução total ou parcial da presente declaração nos termos nela definidos. A ETEC Social exime-se de qualquer responsabilidade resultante da falta de veracidade do anteriormente declarado ou da violação pelo Utilizador de quaisquer direitos ou interesses legitimamente protegidos de terceiros. A ETEC Social reserva-se no direito de livremente (sem obrigatoriedade de invocar qualquer motivo) e em qualquer momento, remover ou não publicar, total ou parcialmente, quaisquer conteúdos, textos, dados, imagens, aplicações ou programas, editados por si ou pelo Utilizador, sem que por tal fato advenha qualquer direito de indenização ou compensação para o Utilizador ou quaisquer terceiros.</p>
        <p>Não existe qualquer obrigação da ETEC Social em guardar os conteúdos, textos, dados, imagens ou programas publicados neste website, podendo os mesmos ser destruídos a qualquer momento, sem que por tal fato advenha qualquer direito de indenização para o Utilizador ou quaisquer terceiros.</p>
    </div>
    <div class="modal-footer">
        <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat blue white-text">OK :)</a>
    </div>
</div>

<div id="privacidade" class="modal">
    <div class="modal-content">
        <h4>Política de Privacidade</h4>
        <p>Todas as informações pessoais recolhidas, serão usadas para ajudar a tornar a sua visita no nosso site o mais produtiva e agradável possível, a garantia da confidencialidade dos dados pessoais dos utilizadores do nosso site é importante para a ETEC Social.<p>
        <p>Todas as informações pessoais relativas a membros, assinantes, clientes ou visitantes que usem a ETEC Social serão tratadas em concordância com a Lei da Proteção de Dados Pessoais de 26 de outubro de 1998 (Lei n.º 67/98). A informação pessoal recolhida pode incluir o seu nome, e-mail, número de telefone e/ou telemóvel, morada, data de nascimento e/ou outros.<p>
        <p>O uso da ETEC Social pressupõe a aceitação deste Acordo de privacidade. A equipe da ETEC Social reserva-se ao direito de alterar este acordo sem aviso prévio. Deste modo, recomendamos que consulte a nossa política de privacidade com regularidade de forma a estar sempre atualizado.<p>
        <p>A ETEC Social como uma rede social possui ligações para outros sites, os quais, podem conter informações/ferramentas úteis para os Utilizadores. A nossa política de privacidade não é aplicada a sites de terceiros, pelo que, caso visite outro site a partir do nosso deverá ler a politica de privacidade do mesmo. Não nos responsabilizamos pela política de privacidade ou conteúdo presente nesses mesmos sites.<p></div>
</div>
</div>

{!! Form::open() !!}
<input type="hidden" name="type" value="login">
<div id="entrar" class="modal">
    <div class="modal-content">
        <div class="row">

            <div class="input-field col s12">
                <i class="material-icons prefix">account_circle</i>
                <input id="email" name="email" type="email" class="validate" required>
                <label for="email">Email</label>
            </div>
            <div class="input-field col s12">
                <i class="material-icons prefix">vpn_key</i>
                <input id="senha" name="senha" type="password" class="validate" required>
                <label for="senha">Senha</label>
            </div>

            <div class="col s12">
                <input type="checkbox" id="remember" class="filled-in" name="remember" checked><label for="remember">Manter conectado(a)</label>
                |  <a data-toggle="modal" href="#!">Perdi minha senha</a>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <input type="submit" class="btn-flat red white-text" value="Entrar">
        <a href="#!" class="waves-effect waves-green btn-flat blue white-text">Entrar com facebook</a>
    </div>
</div>
{!! Form::close() !!}

{!! Form::open() !!}
<input type="hidden" name="type" value="cadastro">
<div id="cadastrar" class="modal modal-fixed-footer">
    <div class="modal-content">
        <h4>Cadastrar Aluno</h4>
        <div class="row">
            <div class="input-field col l6 s12">
                <input id="nome" name="nome" type="text" class="validate" required>
                <label for="nome">Nome Completo</label>
            </div>
            <div class="input-field col l6 s12">
                <input id="email" name="email" type="email" class="validate" required>
                <label for="email">Email</label>
            </div>

            <div class="input-field col l6 s12">
                <input id="senha" name="senha" type="password" class="validate" required>
                <label for="senha">Senha</label>
            </div>



            <div class="input-field col l6 s12">
                <select name="escola" id="escola" onchange="turmas()" required>
                    <option value="" disabled selected>Selecione sua ETEC</option>
                    @foreach(App\Escola::get() as $escola)
                    <option value="{{ $escola->id_etec }}">{{ $escola->nome }}</option>
                    @endforeach
                </select>
                <label>Escola</label>
            </div>

            <div class="input-field col l6 s12">
                <select name="turma" id="loadturmas" required>
                    <option value="" disabled selected>Selecione sua ETEC primeiro</option>
                </select>
                <label>Turma</label>
            </div>

            <div class="input-field col l6 s12">
                <select name="modulo" required>
                    <option value="" disabled selected>Selecione o ano/modulo</option>
                    @foreach(App\Modulo::get() as $modulo)
                    <option value="{{ $modulo->id }}">{{ $modulo->modulo }}º</option>
                    @endforeach
                </select>
                <label>Ano/módulo</label>
            </div>

        </div>
    </div>
    <div class="modal-footer">
        <input type="submit" class="waves-effect waves-green btn-flat red white-text" value="Cadastrar">
    </div>
</div>

{!! Form::close() !!}
@stop