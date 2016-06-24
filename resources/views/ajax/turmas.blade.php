<option disabled selected>Selecione a turma</option>
@forelse($turmas as $turma)
<option value="{{ $turma->id }}" class='tooltipped' data-tooltip='{{ $turma->nome }}' data-delay='800' data-position='left'>{{ $turma->sigla }}</option>

@empty
@if(!old('turma_id'))
<option disabled selected>Não há turmas.</option>
@endif
@endforelse