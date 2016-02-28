<option value="">Selecione a turma</option>
@foreach(App\Turma::get() as $turma)
<option value="{{ $turma->id }}">{{ $turma->sigla }}</option>
@endforeach