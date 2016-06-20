@if($modulos > 0)
@while($modulos > 0)
<option value="{{ $modulos }}" @if(old('modulo')== $modulos ) selected @endif>{{ $modulos }}</option>
{{ $modulos-- }}
@endwhile
@if(!old('modulo'))
<option disabled selected>Selecione o módulo</option>
@endif
@else
<option disabled selected>Não há módulos cadastrados para esta turma.</option>
@endif