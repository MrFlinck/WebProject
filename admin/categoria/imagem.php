<?php
$id = filter_input(INPUT_GET, 'id');
$arquivo = filter_input(INPUT_GET, 'arquivo');
$descricao = filter_input(INPUT_GET, 'descricao');
?>
<h3>
    Trocar Imagem da Categoria <?= $descricao ?>
</h3>
<a class="btn btn-outline-danger float-right" href="?p=categoria/listar">Voltar</a>
<br><br>

<form method="post" enctype="multipart/form-data" name="frmCadastro" id="frmCadastro">
    <div class="form-group">
        <input type="file" class="form-control" id="exampleInputText" name="file_imagem">
    </div>
    <input type="submit" 
           class="btn btn-primary" 
           name="btneditar"
           value="Escolher nova imagem">
</form>
<?php
if (filter_input(INPUT_POST, 'btneditar')) {
    include_once '../class/Categoria.php';
    $cat = new Categoria();
    $cat->setId($id);
    $cat->setImagem($arquivo);
    $cat->setDescricao($descricao);
    $cat->excluirArquivos();
    $imagem = $_FILES['file_imagem'];
    $extensao = strtolower(pathinfo($imagem['name'], PATHINFO_EXTENSION));

    if (strstr('png', $extensao) || strstr('jpg', $extensao)|| strstr('jpeg', $extensao)) {
        $novoNome = sha1(uniqid(time())) . "." . $extensao;
        $cat->setImagem($novoNome);
        $cat->setTemp_imagem($imagem['tmp_name']);
        $cat->enviarArquivos();

        $msg = $cat->editarImagem() ? 'Imagem alterada' : 'Erro';

        echo '<div class="alert alert-primary mt-3" role="alert">'
        . $msg
        . '</div>';

        echo '<meta http-equiv="refresh" content="0.5;URL=?p=categoria/listar">';
    }
}
?>


