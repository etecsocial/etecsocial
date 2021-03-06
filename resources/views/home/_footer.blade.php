<style>
.patrocinadores {
  width: 90%;
  margin-top: -50px !important;
}
.patrocinadores > .row .col.l3 {
  width: 20%;
}
</style>
<div class="container patrocinadores">
    <div class="row center-align">
        <h4>Apoio</h4>

        <div class="col l3 s12">
            <a href="http://www.buffetsantacruz.com.br/">
                <img src="{{ asset('images/buffet.jpg')}}" alt="Buffet Santa Cruz" width="200">
            </a>
        </div>

        <div class="col l3 s12">
            <a href="https://www.facebook.com/njespaconatural/">
                <img src="{{ asset('images/nj.png')}}" alt="NJ Espaço Natural logo" width="200">
            </a>
        </div>
        <div class="col l3 s12">
            <a href="https://www.facebook.com/profile.php?id=100002244722410">
                <img src="{{ asset('images/tiago_silva.jpg')}}" alt="Tiago Silva logo" width="200">
            </a>
        </div>
        <div class="col l3 s12">
            <a href="https://www.facebook.com/sarajgraficadigital/">
                <img src="{{ asset('images/sara_julia.png')}}" alt="Sara Digital Gráfica logo" width="180">
            </a>
        </div>
        <div class="col l3 s12">
            <a href="https://www.facebook.com/damasereis.eventos/">
                <img src="{{ asset('images/damasereis.png')}}" alt="Damas e Reis Iluminação Profissional" width="160">
            </a>
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
                </ul>
            </div>
            <div class="col l3 s12">
                <h5 class="white-text">Contato</h5>
                <ul>
                    <li><a class="white-text" href="https://www.facebook.com/EtecSocialOficial/">facebook.com/EtecSocialOficial/</a></li>
                    <li><a class="white-text" href="https://twitter.com/etecsocial">twitter.com/etecsocial</a></li>
                    <li><a class="white-text" href="mailto:contato@etecsocial.com">contato@etecsocial.com.br</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="footer-copyright">
        <div class="container">
            Copyright © {{ date('Y') }} ETEC Social | Compartilhando conhecimentos.</a>
        </div>
    </div>
</footer>
