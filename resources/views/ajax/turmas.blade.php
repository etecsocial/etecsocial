<option disabled>Selecione a turma</option>
@forelse($turmas as $turma)
<option value="{{ $turma->id }}" class='tooltipped' data-tooltip='{{ $turma->nome }}' data-delay='800' data-position='left'>{{ $turma->sigla }}</option>

@empty
@if(!old('id_turma'))
<option disabled selected>Não há turmas.</option>
@endif
@endforelse