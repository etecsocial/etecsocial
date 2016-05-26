<option disabled>Selecione a turma</option>
@forelse($turmas as $turma)
<option value="{{ $turma->id }}">{{ $turma->sigla }}</option>
@empty
<option disabled selected>Sua escola ainda não foi cadastrada</option>
@endforelse