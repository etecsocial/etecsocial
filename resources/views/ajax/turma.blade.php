<option value="">Selecione a turma</option>
@foreach($turmas as $turma)
<option value="{{ $turma->id }}">{{ $turma->sigla }}</option>
@endforeach