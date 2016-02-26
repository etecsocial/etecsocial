@extends('app')
@section('title')
ETEC Social - Entre, conheça ou cadastre-se.
@stop

@section('style')
<link href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.1.1/css/bootstrap.min.css" rel="stylesheet">
<link href="{{ env('ASSETS_URL') }}/custom/1.5/css/home.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="js/plugins/tokenize/jquery.tokenize.css" />
@stop

@section('jscript')
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/materialize/0.97.0/js/materialize.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.11.1/jquery.validate.min.js"></script>
<script type="text/javascript" src="js/plugins/tokenize/jquery.tokenize.js"></script>



@if(isset($user->id))
<script>
    $('#not_reg').hide();
    $('#voltar-form').fadeIn(1500);
    $('#voltar-cont').addClass("ativo");
    $('#form-cadastro').fadeIn(1500);

    window.history.pushState(null, null, "/");

    $("#myModalTitle").html("Quase lá!");
    $("#modal-body-cad").html('<div class="alert alert-success">Você está quase lá, termine de preencher seus dados para finalizar seu cadastro.</div>');
    $('#myModalCad').modal('show');
</script>
@elseif($user == NULL)
<script>
    $('.box-entre').fadeIn(1500);
    $('.conheca').fadeIn(1500);
    $('#not_reg').fadeIn(1500);

    window.history.pushState(null, null, "/");

    $("#myModalTitle").html("Erro!");
    $("#modal-body-cad").html('<div class="alert alert-danger">Esse código de confirmação não existe! Lamentamos.</div>');
    $('#myModalCad').modal('show');
</script>
@elseif($cadastro)
<script>
$('#not_reg').hide();
    $('#voltar-form').fadeIn(1500);
    $('#voltar-cont').addClass("ativo");
    $('#form-cadastro').fadeIn(1500);

    window.history.pushState(null, null, "/");
</script>
@elseif($user == 'false')
<script>
    $('.box-entre').fadeIn(1500);
    $('.conheca').fadeIn(1500);
    $('#not_reg').fadeIn(1500);
</script>
@endif

<script type="text/javascript">
    function turmas(){
      var escola = $('#escola').val();
      
      if(escola){
        var url = '/ajax/cadastro/turmas?escola='+ escola;
        $.get(url, function(dataReturn) {
          $('#loadturmas').html(dataReturn);
        });
      }
    }
</script>

<script src="{{ env('ASSETS_URL') }}/custom/1.5/js/home.min.js"></script>
@stop

@section('content')
<div class="conteudo" id="conteudo">
    <header>
        <div class="logo"></div>
        <nav>
            <div class="botoes">
                <a href="https://projeto.etecsocial.com.br/"><button type="button" class="btn btn-sup">O Projeto</button></a>
                <button type="button" class="btn btn-sup" data-toggle="modal" data-target="#myModalPolitica">Privacidade</button>
                <button type="button" class="btn btn-sup" data-toggle="modal" data-target="#myModalTermos">Termos</button>
            </div>
        </nav>
        <div class="subt">
            <h2>Compartilhando conhecimentos.</h2>
        </div>
        <div class="box-entre" style="display:none">
            <aside class="entre">
                <h2><strong>Entre</strong></h2>
                {!! Form::open([ 'id' => 'logar' ]) !!}
                <div class="form-group">
                    {!! Form::text('email', null, [
                    'class' => 'form-control',
                    'placeholder' => 'E-mail',
                    'autocomplete' => 'off'
                    ]) !!}
                </div>
                <div class="form-group">
                    {!! Form::password('password', [
                    'class' => 'form-control',
                    'placeholder' => 'Senha'
                    ]) !!}
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="remember"><p class="conn">Manter conectado(a) |  <b data-toggle="modal" data-target="#myModalReset">Perdeu sua senha?</b></p> 
                    </label>
                </div>
                <div id="botao-entrar">
                    {!! Form::submit('Entrar', [
                    'class' => 'btn btn-submit', 
                    'id' => 'botao',
                    'data-loading-text' => 'Entrando...'
                    ]) !!}
                </div>
                {!! Form::close() !!}
            </aside>
        </div>
        <aside class="conheca" style="display:none">
            <h2><strong>Conheça</strong></h2>
            <div class="quadrado" style="background-color: transparent !important">
<iframe width="381" height="213" src="https://www.youtube.com/embed/pAfiLcMJ7q8?autoplay=0&controls=2&fs=0&modestbranding=1&rel=0&showinfo=0" frameborder="0"></iframe>
        </div>
        </aside>
        <div id="form-cadastro" style="display:none">
            <ul id="progress">
                <li class="ativo" id="voltar-cont">Informações básicas</li>
                <li>Informações acadêmicas</li>
                <li>Personalização</li>
            </ul>
            @if(empty($user->id)) 
            {!! Form::open([ 'id' => 'cadastrar-1' ]) !!}
            <div id="form-errors"></div> 
            <fieldset id="voltar-form">
                <h2>Informações Básicas</h2>
                <input type="email" name="email" placeholder="Email">
                <input type="text" name="cod_prof" id="cod" placeholder="Código de acesso do professor" style="display:none">
                <select class="margin-left" id="tipo" name="tipo" style="padding:10px">
                    <option value="1">Aluno</option>
                    <option value="2">Professor</option>
                </select>
                <input type="password" name="senha" placeholder="Digite uma senha">
                <input type="password" name="senha_confirmation"  placeholder="Digite a senha novamente">
                <button type="button" name="prev" id="botao_voltar" class="btn btn-sm prev acao left">Voltar</button>
                <button type="submit" name="next" id="pre-envio" data-loading-text="Aguarde..." class="btn btn-sm acao right">Proximo</button>                
            </fieldset> 
            {!! Form::close() !!} 
        </div>
        <div align="center" class="center-align" id="not_reg" style="display:none">
            <button type="button" id="botao_cad" class="btn btn-ainda">Ainda não possui uma conta?</button>
        </div>
        @else
        {!! Form::open([ 'id' => 'cadastrar-2']) !!}
        <fieldset id="voltar-form">
            <h2>Informações Básicas</h2>
            <input type="email" placeholder="Email institucional" value="{{ $user->email }}" disabled>
            <input type="text" id="cod" placeholder="Código de acesso do professor" style="display:none">
            <select class="margin-left" id="tipo" name="tipo" style="padding:10px" disabled>
                @if($user->tipo == 1)
                <option value="1" selected>Aluno</option>
                <option value="2">Professor</option>
                @else
                <option value="1">Aluno</option>
                <option value="2" selected>Professor</option>
                @endif
            </select>
            <input type="password" placeholder="Digite uma senha" value="minhasenha" disabled>
            <input type="password" placeholder="Digite a senha novamente" value="minhasenha" disabled>
            <button type="button" name="prev" id="botao_voltar" class="btn btn-sm prev acao left">Voltar</button>
            <button type="button" name="next" id="prev-1" class="btn btn-sm next acao right" >Próximo</button>
        </fieldset>
        <fieldset>
            <h2>Informações Acadêmicas</h2>
            <input type="hidden" id="email" name="email" value="{{ $user->email }}">
            @if($user->tipo == 1)
            <select class="margin-left" name="instituicao" id="escola" style="padding:10px;margin-right:8px" onchange="turmas()">
                <option value="">Selecione a ETEC</option>
                @foreach(App\Escola::get() as $escola)
                <option value="{{ $escola->id_etec }}">{{ $escola->nome }}</option>
                @endforeach
            </select>
            <select class="margin-left" name="turma" id="loadturmas" style="padding:10px">
                <option value="">Selecione a ETEC antes...</option>
            </select>
            <select class="margin-left" name="modulo" style="padding:10px;margin-right:8px">
                <option value="">Selecione o ano/modulo</option>
                @foreach(App\Modulo::get() as $modulo)
                <option value="{{ $modulo->id }}">{{ $modulo->modulo }}º</option>
                @endforeach
            </select>
            <input type="text" name="conclusao" placeholder="Conclusão. Ex: 2017">
            @elseif($user->tipo == 2)
            <input type="text" name="atuacao" placeholder="Atuação. Ex: Professor de História">
            <input type="text" name="ano_entrada" placeholder="Ano de entrada">
            <input type="text" name="formacao" placeholder="Formação. Ex: Licenciatura em História">
            <input type="text" name="universidade" placeholder="Universidade. Ex: UNICAMP">
            @endif
            <button type="button" name="prev" class="btn btn-sm prev acao left">Voltar</button>
            <button type="button" name="next" class="btn btn-sm next acao right">Próximo</button>
        </fieldset>
        <fieldset>
            <h2>Personalização</h2>
            <input type="text" name="nome" placeholder="Nome">
            <input type="text" name="sobrenome" placeholder="Sobrenome">
            <input type="text" name="username" placeholder="Nome de Usuário. Ex: mario75">
            <input type="email" name="email_alternativo" placeholder="Email alternativo">
            <button type="button" name="prev" class="btn btn-sm prev acao left">Voltar</button>
            <button type="submit" name="next" id="envio" data-loading-text="Aguarde..." class="btn btn-sm acao right">Enviar</button>
        </fieldset>
</div>
{!! Form::close() !!}   
<div align="center" id="not_reg" style="display:none">
    <button type="button" id="botao_cad" class="btn btn-ainda">Continuar cadastrando</button>
</div>
@endif
</header>
</div>
<div class="modal fade bs-example-modal-sm" id="myModalMsg" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Opss!</h4>
            </div>
            <div class="modal-body" id="modal-body-msg"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-submit" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="myModalCad" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalTitle"></h4>
            </div>
            <div class="modal-body" id="modal-body-cad"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-submit" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="myModalReset" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        {!! Form::open([ 'id' => 'recuperar' ]) !!}
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">Recuperar senha</h4>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="recipient-name" class="control-label">Email:</label>
                        <div id="modal-body-reset"></div>
                        <div id="msg" class="alert-info"></div>
                        <input type="text" class="form-control" name="email">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                <button type="submit" class="btn btn-primary">Recuperar</button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>
<div class="modal fade" id="myModalTermos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Termos de Uso</h4>
            </div>
            <div class="modal-body text-justify" style="max-height: 400px; overflow-y: auto">
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
                <button type="button" class="btn btn-default" data-dismiss="modal">Voltar</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="myModalPolitica" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Política de Privacidade</h4>
            </div>
            <div class="modal-body text-justify">
                <p>Todas as informações pessoais recolhidas, serão usadas para ajudar a tornar a sua visita no nosso site o mais produtiva e agradável possível, a garantia da confidencialidade dos dados pessoais dos utilizadores do nosso site é importante para a ETEC Social.<p>
                <p>Todas as informações pessoais relativas a membros, assinantes, clientes ou visitantes que usem a ETEC Social serão tratadas em concordância com a Lei da Proteção de Dados Pessoais de 26 de outubro de 1998 (Lei n.º 67/98). A informação pessoal recolhida pode incluir o seu nome, e-mail, número de telefone e/ou telemóvel, morada, data de nascimento e/ou outros.<p>
                <p>O uso da ETEC Social pressupõe a aceitação deste Acordo de privacidade. A equipe da ETEC Social reserva-se ao direito de alterar este acordo sem aviso prévio. Deste modo, recomendamos que consulte a nossa política de privacidade com regularidade de forma a estar sempre atualizado.<p>
                <p>A ETEC Social como uma rede social possui ligações para outros sites, os quais, podem conter informações/ferramentas úteis para os Utilizadores. A nossa política de privacidade não é aplicada a sites de terceiros, pelo que, caso visite outro site a partir do nosso deverá ler a politica de privacidade do mesmo. Não nos responsabilizamos pela política de privacidade ou conteúdo presente nesses mesmos sites.<p></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Voltar</button>
            </div>
        </div>
    </div>
</div>
@stop