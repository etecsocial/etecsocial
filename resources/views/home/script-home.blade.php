   
<script>
    $(document).ready(function () {

    $(".lala").click(function (event) {
    event.preventDefault();
    var idElemento = $(this).attr("href");
    var deslocamento = $(idElemento).offset().top;
    $('html, body').animate({ scrollTop: deslocamento }, 'slow');
    });
    $('.modal-trigger').leanModal();
    $('.button-collapse').sideNav();
    $('select').material_select();
    $('ul.tabs').tabs();
    var type = {{ old('type') ? old('type') : 1 }};
    $('ul.tabs').tabs('select_tab', type);
    $('#singup').leanModal();
    @if (old('type')) $('.singup').openModal(); @endif

    });
    function getTurmas() {
    var escola = $('#id_escola').val();
    if (escola) {
    var url = '/ajax/cadastro/getTurmas?id_escola=' + escola;
    $.get(url, function (dataReturn) {
    $('#loadturmas').html(dataReturn).material_select();
    $('#loadmodulos').html('');
    $('.caret').hide();
    });
    }
    }
    function getModulos() {
    var id_turma = $('#loadturmas').val();
    var url = '/ajax/cadastro/getModulos?id_turma=' + id_turma;
    $.get(url, function (dataReturn) {
    $('#loadmodulos').html(dataReturn).material_select();
    $('.caret').hide();
    });
    }

</script>