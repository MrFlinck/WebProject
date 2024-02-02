<?php
$id = filter_input(INPUT_GET, 'id');
include_once '../class/Area.php';
$cat = new Area();
// iiset seve para verificar se a variavel foi utilizada para editar ou salvar 
if (isset($id)) {
    $cat->setId($id);
    $dados = $cat->consultarPorID();
    foreach ($dados as $mostrar) {
        $area = $mostrar['area']; // pode ser $descricao = $mostrar[1];

    }
}
?>

<h3>
    <?= isset($id) ? 'Editar' : 'Cadastrar' ?> Area
</h3>
<a class="btn btn-outline-danger float-right" href="?p=area/listar">Voltar</a>
<br><br>

<form method="post" enctype="multipart/form-data" name="frmCadastro" id="frmCadastro">

    <div class="form-group">
        <label for="exampleInputText">Nome</label>
        <input type="text" class="form-control" id="exampleInputText" placeholder="Informe o nome da área"
            name="txtarea" value="<?= isset($id) ? $area : '' ?>">
    </div>


    <input type="submit" class="btn btn-<?= isset($id) ? 'success' : 'primary' ?>"
        name="<?= isset($id) ? 'btneditar' : 'btnsalvar' ?>" value="<?= isset($id) ? 'Editar' : 'Cadastrar' ?>">

</form>
<?php
//se eu clicar no botão salvar
if (filter_input(INPUT_POST, 'btnsalvar')) {
    $area= filter_input(INPUT_POST, 'txtarea');
    $cat->setNome($area);
 

    //efetivar o cadastro
    if($cat->salvar()){
        echo '<div class="alert alert-primary mt-3"
         role="alert"> ';
         echo 'Cadastro efetuado com sucesso';
         echo '</div>';
         echo '<meta http-equiv="refresh" content="0.5"
         URL=?p=area/listar">';

    }
}
if (filter_input(INPUT_POST, 'btneditar')) { /// se o botão editar for clicado.. 
 
    $nome = filter_input(INPUT_POST, 'txtnome');
    $cat->setNome($nome);


    if ($cat->editar()) {
        echo '<div class="alert alert-primary mt-3" role="alert">';
        echo 'edição efetuado com sucesso!';
        echo '</div>';
        echo '<meta http-equiv="refresh" content="1;URL=?p=area/listar"> ';
    }

}