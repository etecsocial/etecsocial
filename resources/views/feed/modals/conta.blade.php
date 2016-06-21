<div id="modalConta" class="modal modal-fixed-footer" style="background-color: #f4f4f4">
    <form id="conta" method="POST" action="{{ url('/ajax/config') }}">
        <div class="modal-content">
            <h6>Configurações da Conta</h6>
            <li class="divider"></li>
            <div class="row">
                <div class="col s12">
                    <ul class="tabs" style="background: transparent">
                        <li class="tab col s6"><a href="#infos-pessoais" class="active black-text">Básico</a></li>
                        <li class="tab col s6"><a href="#infos-seguranca" class="black-text">Segurança</a></li>
                    </ul>
                </div>
                <div id="infos-pessoais" class="col s12">
                    <div class="row">
                        <div class="input-field col s6">
                            <div class="file-field input-field">
                                <div class="btn color-sec">
                                    <span>Foto</span>
                                    <input name="foto" type="file">
                                </div>
                                <div class="file-path-wrapper">
                                    <input class="file-path validate" type="text">
                                </div>
                            </div>
                        </div>
                        <div class="input-field col s12 l6">
                            <input value="{{auth()->user()->name }}" name="name" placeholder="Nome completo" class="validate" type="text" name="nome" id="nome">
                            <label for="name" class="active">Nome e sobrenome</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 l6">
                            <input type="text" name="username" value="{{auth()->user()->username }}" placeholder="Nome de usuario" class="validate" id="username">
                            <label for="username" class="active">Nome de usuário</label>
                        </div>
                        <div class="input-field col s12 l6">
                            <input type="date" class="datepicker" name="birthday" value="{{auth()->user()->birthday ? auth()->user()->birthday : " " }}" placeholder="Data de Nascimento">
                            <label for="birthday" class="active">Data de nascimento</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 l6">
                            <input type="text" value="{{ $infoAcad->escola }}" placeholder="Instituicao" class="validate" disabled>
                        </div>
                    </div>
                    @if(auth()->user()->type == 1)
                    <div class="row">
                        <div class="input-field col s12 l6">
                            <input type="text" name="curso" value="" placeholder="Curso" class="validate" disabled>
                            <label for="curso" class="active">Curso</label>
                        </div>
                    </div>
                    @endif
                </div>
                <div id="infos-seguranca" class="col s12">
                    <div class="row">
                        <div class="input-field col s6">
                            <input type="text" name="email" value="{{auth()->user()->email }}" placeholder="@etec.sp.gov.br" class="validate" disabled>
                            <label for="email" class="active">E-mail institucional</label>
                        </div>
                        <div class="input-field col s6">
                            <input type="text" name="email_alternativo" value="{{auth()->user()->email_alternativo }}" placeholder="E-mail" class="validate">
                            <label for="email_alternativo" class="active">E-mail alternativo</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s4">
                            <input type="password" name="senha_atual" placeholder="Senha atual" class="validate">
                            <label for="senha" class="active">Senha atual</label>
                        </div>
                        <div class="input-field col s4">
                            <input type="password" name="senha" placeholder="Nova senha" class="validate">
                            <label for="senha" class="active">Nova senha</label>
                        </div>
                        <div class="input-field col s4">
                            <input type="password" name="senha_confimation" placeholder="Repita a nova senha" class="validate">
                            <label for="senha" class="active">Confirmar nova senha</label>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer color-sec-darken">
            <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat white-text">Cancelar</a>
            <button type="submit" class="modal-action waves-effect waves-green btn-flat white-text">Salvar</button>
        </div>
    </form>
</div>
