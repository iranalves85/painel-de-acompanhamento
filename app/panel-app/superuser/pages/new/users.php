<label for="spreadsheet">
    Planilha de Usuários
</label>
<input class="form-control btn-file" type="file" name="file" id="" ng-model="file">
<p><small>Arquivo com dados de usuários do projeto</small></p>

<div class="col-md-12">
    <input class="btn btn-success float-right" type="submit" value="Cadastrar">
    <input type="hidden" name="company" value="<?php $_POST['company']; ?>" /> 
</div>