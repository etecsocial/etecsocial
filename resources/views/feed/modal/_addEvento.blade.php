<div id="novoevento" class="modal">
    <form method="POST" id="addevento" action="{{ url('ajax/agenda') }}">
        <div class="modal-content">
            <h4>Adicionar Evento</h4>
            <div class="row">
                <div class="input-field col s12 l6">
                    <input name="title" type="text" required>
                    <label for="title">Título</label>
                </div>
                <div class="input-field col s12 l6">
                    <input name="description" type="text">
                    <label for="title">Descrição (opcional)</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s6">
                    <input name="start" type="date" class="datepicker" placeholder="Data">
                    <label for="inicio" class="active" id="inicio">Data</label>
                </div>
                <div id="fim" class="input-field col s6" style="display:none">
                    <input name="end" type="date" class="datepicker" placeholder="Data">
                    <label for="fim" class="active">Fim</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12 l6">
                    <input name="tipo" value="0" id="test11" type="radio" checked>
                    <label for="test11">Um dia</label>
                    <input name="tipo" value="1" id="test21" type="radio">
                    <label for="test21">Mais de um dia</label>
                </div>
                <div class="input-field col s12 l6">
                    <input name="publico" value="0" id="test12" type="radio" checked>
                    <label for="test12">Pessoal</label>
                    <input name="publico" value="1" id="test22" type="radio">
                    <label for="test22">Compartilhado</label>
                </div>
            </div>
            <div class="row">
                @if(auth()->user()->type == 2)
                <div class="addturma input-field col s6" style="display:none">
                    <select name="turma" id="turma" type="text">
                        @foreach(auth()->user()->turmas() as $turma)
                        <option value="{{ $turma->id }}">{{ $turma->sigla }}</option>
                        @endforeach
                    </select>
                </div>
                @else
                <div class="addturma input-field col s12" style="display:none">
                    <p>Você irá compartilhar esse evento com a sua sala.</p>
                </div>
                @endif
            </div>
        </div>
        <div class="modal-footer color-sec">
            <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat white-text">Cancelar</a>
            <button type="submit" class="modal-action modal-close waves-effect waves-green btn-flat white-text">Add</button>
        </div>
    </form>
</div>