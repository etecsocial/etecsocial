@if($modulos > 0)
@while($modulos > 0)
<option value="{{ $modulos }}">{{ $modulos }}</option>
{{ $modulos-- }}
@endwhile
<option disabled selected>Selecione o módulo</option>
@else
<option disabled selected>Sua escola ainda não foi cadastrada</option>
@endif