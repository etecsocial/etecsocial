@section('jscript2')
{!! Minify::javascript(['/js/jquery-1.11.2.min.js', '/materialize-css/js/materialize.min.js'])->withFullUrl() !!}
<script>
    $(document).ready(function () {
        $('.modal-trigger').leanModal();
        $('.button-collapse').sideNav();
        $('select').material_select();

        @if (old('type') == 2)
         $('.aluno').hide();
         $('.professor').show();
       @else 
         $('.aluno').show();
         $('.professor').hide();
       @endif

      $('#register-aluno').click(function(){
         $('.professor').hide();
         $('.aluno').show();
      });

      $('#register-professor').click(function(){
         $('.aluno').hide();
         $('.professor').show();
      });

      var hash = window.location.hash;
        if(hash == '#register'){
          $('#register').openModal();
        } else if(hash == '#login'){
          $('#login').openModal();
        }
    });


    function turmas() {
       var escola = $('#id_escola').val();
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
<nav class="red darken-1" role="navigation">
   <div class="nav-wrapper container">
      <a id="logo-container" href="{{ url('/') }}" class="brand-logo">
         <img src="{{ url('/images/logo-b.png') }}" alt="ETEC Social" class="logo-img">
      </a>
      <ul class="right hide-on-med-and-down">
         <li><a href="#sobre" class="modal-trigger">Sobre</a></li>
         <li><a href="#termos" class="modal-trigger">Termos</a></li>
         <li><a href="#privacidade" class="modal-trigger">Privacidade</a></li>
      </ul>
      <ul id="nav-mobile" class="side-nav">
         <li><a href="#entrar" class="modal-trigger">Entrar</a></li>
         <li><a href="#cadastrar" class="modal-trigger">Cadastrar</a></li>
         <li>
            <div class="divider"></div>
         </li>
         <li><a href="#sobre" class="modal-trigger">Sobre</a></li>
         <li><a href="#termos" class="modal-trigger">Termos</a></li>
         <li><a href="#privacidade" class="modal-trigger">Privacidade</a></li>
      </ul>
      <a href="#" data-activates="nav-mobile" class="button-collapse"><i class="material-icons">menu</i></a>
   </div>
</nav>
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
      <p>A ETEC Social não é responsável pela exatidão, qualidade, segurança, legalidade ou licitude, incluindo o cumprimento das regras respeitantes a direitos de autor e direitos conexos, relativamente aos conteúdos, produtos ou serviços contidos neste website que tenham sido criados ou fornecidos por membros, utilizadores, anunciantes ou parceiros comerciais, bem como por qualquer informação contida em sites de terceiros para os quais este website estabeleça ligações.
      <p>
      <p>O Utilizador declara autorizar, a título gratuito, a divulgação, publicação, utilização e exploração dos conteúdos, textos, dados, imagens ou programas por si enviados para a ETEC Social.
      <p>
      <p>O Utilizador declara igualmente que:<br>
         tem plena legitimidade para autorizar a utilização previamente mencionada e, concretamente, que obteve e dispõe dos necessários direitos e autorizações a título de direitos de autor e assegurou os pagamentos eventualmente devidos a terceiros legítimos titulares de direitos sobre os conteúdos, textos, dados, imagens ou programas por si enviados para a ETEC Social, para efeitos da sua utilização nos termos previstos na presente declaração; sobre o direito de autorizar a utilização dos conteúdos, textos, dados, imagens ou programas por si enviados para a ETEC Social constantes da presente declaração, não existe qualquer reclamação ou processo instaurado ou alguma contestação relativamente à sua titularidade por parte de terceiros; não existe nenhum compromisso nem nenhuma condição decorrente de relações jurídicas eventualmente existentes entre o Utilizador e terceiros que impeça ou condicione, de algum modo, a execução total ou parcial da presente declaração nos termos nela definidos. A ETEC Social exime-se de qualquer responsabilidade resultante da falta de veracidade do anteriormente declarado ou da violação pelo Utilizador de quaisquer direitos ou interesses legitimamente protegidos de terceiros. A ETEC Social reserva-se no direito de livremente (sem obrigatoriedade de invocar qualquer motivo) e em qualquer momento, remover ou não publicar, total ou parcialmente, quaisquer conteúdos, textos, dados, imagens, aplicações ou programas, editados por si ou pelo Utilizador, sem que por tal fato advenha qualquer direito de indenização ou compensação para o Utilizador ou quaisquer terceiros.
      </p>
      <p>Não existe qualquer obrigação da ETEC Social em guardar os conteúdos, textos, dados, imagens ou programas publicados neste website, podendo os mesmos ser destruídos a qualquer momento, sem que por tal fato advenha qualquer direito de indenização para o Utilizador ou quaisquer terceiros.</p>
   </div>
   <div class="modal-footer">
      <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat blue white-text">Entendi</a>
   </div>
</div>
</div>

<div id="privacidade" class="modal modal-fixed-footer">
   <div class="modal-content">
      <h4>Política de Privacidade</h4>
      <p>Todas as informações pessoais recolhidas, serão usadas para ajudar a tornar a sua visita no nosso site o mais produtiva e agradável possível, a garantia da confidencialidade dos dados pessoais dos utilizadores do nosso site é importante para a ETEC Social.</p>
      <p>Todas as informações pessoais relativas a membros, assinantes, clientes ou visitantes que usem a ETEC Social serão tratadas em concordância com a Lei da Proteção de Dados Pessoais de 26 de outubro de 1998 (Lei n.º 67/98). A informação pessoal recolhida pode incluir o seu nome, e-mail, número de telefone e/ou telemóvel, morada, data de nascimento e/ou outros.</p>
      <p>O uso da ETEC Social pressupõe a aceitação deste Acordo de privacidade. A equipe da ETEC Social reserva-se ao direito de alterar este acordo sem aviso prévio. Deste modo, recomendamos que consulte a nossa política de privacidade com regularidade de forma a estar sempre atualizado.</p>
      <p>A ETEC Social como uma rede social possui ligações para outros sites, os quais, podem conter informações/ferramentas úteis para os Utilizadores. A nossa política de privacidade não é aplicada a sites de terceiros, pelo que, caso visite outro site a partir do nosso deverá ler a politica de privacidade do mesmo. Não nos responsabilizamos pela política de privacidade ou conteúdo presente nesses mesmos sites.</p>
   </div>
   <div class="modal-footer">
      <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat blue white-text">Entendi</a>
   </div>
</div>

<div id="sobre" class="modal modal-fixed-footer">
   <div class="modal-content">
      <h4>Sobre o ETEC Social</h4>
     <p>Com o notório aumento do uso de redes sociais em ambientes escolares por discentes, seja ele para fins educativos ou não, notou-se a necessidade de um ambiente socioeducativo para facilitar a comunicação, interação e aprendizagem de alunos não apenas dentro, mas também fora do âmbito escolar.</p>
   <p>Visando criar um ambiente comum de interação entre alunos e professores, o sistema proposto contará com uma série de ferramentas e funcionalidades que auxiliarão o aluno durante todo o período letivo, estimulando-o a aprender dentro e fora da escola, através de recursos cabíveis que despertarão o interesse do aluno pelos estudos.</p>
   <p>Com base neste contexto, conclui-se que o projeto em questão estará difundindo conhecimento e facilitando a vida dos estudantes cada vez mais, sempre com métodos inovadores e interativos. A imagem causticante e tediosa que alguns possuíam sobre os estudos ganha uma nova forma e passa a ser mais divertida e atrativa.</p>
   </div>
   <div class="modal-footer">
      <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat blue white-text">Entendi</a>
   </div>
</div>

<div id="login" class="modal">
   <div class="modal-content center">
         @include('auth.login-form')
   </div>
</div>

<div id="register" class="modal">
   <div class="modal-content center">
      <div class="row margin">
        <a class="waves-effect waves-light btn-large red darken-1" id="register-aluno"><i class="material-icons left">person_pin</i>Aluno</a>
        <a class="waves-effect waves-light btn-large blue darken-1" id="register-professor"><i class="material-icons left">work</i>Professor</a>              
      </div>
      <div class="col s12 center">
         <div class="row">
            @include('auth.register.aluno')
            @include('auth.register.professor')
         </div>
      </div>
   </div>
</div>