<!-- MODAL ADD EVENTO -->
@include('feed.modal._addEvento')
<!-- MODAL ADD EVENTO -->

<!-- MODAL VER POST -->
<div id="verpost" class="modal modal-fixed-footer">
    <div class="modal-content" id="modalpost"></div>
    <div class="modal-footer color-sec">
        <a style="cursor:pointer" class="modal-action modal-close waves-effect waves-green btn-flat white-text">Fechar</a>
    </div>
</div>

@if(auth()->user()->first_login)
  @include('feed.modal._firstLogin')
@endif

@include('feed.modal._conta')
