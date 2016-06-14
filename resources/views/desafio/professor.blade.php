<div class="container">
    <p class="caption">Com o sistema de Reputação, alunos poderão desafiar seus colegas afim de adiquirir pontuação. Tais desafios consistirão tanto em questões de vestibular quanto outros tipos, que serão sugeridos pelo sistema.</p>
    <div class="divider"></div>
    <h4>Novo Desafio</h4>
    <div class="row">
    <form class="form-form" role="form" method="POST" action="{{ url('/register') }}">
        {!! csrf_field() !!}
        <div class="input-field col s12 m12 l12">
          <input type="text" name="title">
          <label>Título</label>
        </div>

        <div class="input-field col s12 m12 l12">
          <textarea name="description" class="materialize-textarea"></textarea>
          <label for="description">Descrição</label>
        </div>

        <div class="input-field col s12 m12 l6">
          <input type="text" name="subject" placeholder="Matemática">
          <label>Matéria</label>
        </div>

        <div class="input-field col l2">
          <input type="number" name="reward_points" placeholder="100">
          <label>Pontos ganhos</label>
        </div>

        <div class="input-field col l4">
          <div class="file-field input-field">
              <input class="file-path validate" type="text">
              <div class="btn red darken-1">
                  <span>+</span>
                  <input type="file" name="file">
              </div>
          </div>
        </div>

        <div class="input-field col l15">
          <select name="turmas[]" multiple>
            <option>1 EMIA</option>
          </select>
        </div>


        <div class="input-field col s12">
            <button type="submit" class="waves-effect waves-light btn-large red darken-1">Cadastrar</button>
        </div>
    </form>
  </div>
</div>
