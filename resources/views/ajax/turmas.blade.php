<option disabled>Selecione a turma</option>
@forelse($turmas as $turma)
<option value="{{ $turma->id }}">{{ $turma->sigla }}</option>

@empty
@if(!old('id_turma'))
<option disabled selected>Ainda não há turmas cadastradas para esta escola</option>
@endif
@endforelse