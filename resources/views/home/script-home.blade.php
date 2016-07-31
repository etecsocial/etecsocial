<script>
$( document ).ready(function() {

    scaleVideoContainer();

    initBannerVideoSize('.video-container .poster img');
    initBannerVideoSize('.video-container .filter');
    initBannerVideoSize('.video-container video');

    $(window).on('resize', function() {
        scaleVideoContainer();
        scaleBannerVideoSize('.video-container .poster img');
        scaleBannerVideoSize('.video-container .filter');
        scaleBannerVideoSize('.video-container video');
    });

});

function scaleVideoContainer() {

    var height = $(window).height() + 5;
    var unitHeight = parseInt(height) + 'px';
    $('.homepage-hero-module').css('height',unitHeight);

}

function initBannerVideoSize(element){

    $(element).each(function(){
        $(this).data('height', $(this).height());
        $(this).data('width', $(this).width());
    });

    scaleBannerVideoSize(element);

}

function scaleBannerVideoSize(element){

    var windowWidth = $(window).width(),
    windowHeight = $(window).height() + 5,
    videoWidth,
    videoHeight;

    $(element).each(function(){
        var videoAspectRatio = $(this).data('height')/$(this).data('width');

        $(this).width(windowWidth);

        if(windowWidth < 1000){
            videoHeight = windowHeight;
            videoWidth = videoHeight / videoAspectRatio;
            $(this).css({'margin-top' : 0, 'margin-left' : -(videoWidth - windowWidth) / 2 + 'px'});

            $(this).width(videoWidth).height(videoHeight);
        }

        $('.homepage-hero-module .video-container video').addClass('fadeIn animated');

    });
}


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
        var escola = $('#escola_id').val();
        if (escola) {
            $.ajax({
             url: '/ajax/cadastro/getTurmas?escola_id=' + escola,
             dataType: "html",
             success: function(data){
                 $('#loadturmas').html(data).material_select();
                 $('#loadmodulos').html('');
                 $('.caret').hide();
             }
          });
        }
    }

    function getModulos() {
        var turma_id = $('#loadturmas').val();
        if (turma_id) {
            $.ajax({
             url: '/ajax/cadastro/getModulos?turma_id=' + turma_id,
             dataType: "html",
             success: function(data){
                 $('#loadmodulos').html(data).material_select();
                 $('.caret').hide();
             }
          });
        }
    }
</script>
