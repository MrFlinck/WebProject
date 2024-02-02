<?php
$id = filter_input(INPUT_GET, 'id');
$arquivo = filter_input(INPUT_GET, 'arquivo');
$descricao = filter_input(INPUT_GET, 'descricao');

include_once '../class/Categoria.php';
$cat = new Categoria();
$cat->setId($id);
$cat->setImagem($arquivo);
$cat->setDescricao($descricao);
//$cat->setId($id);

if ($cat->excluir($id) && $cat->excluirFirebase($id) === 'null') {
    $cat -> excluirArquivos()
    ?>
    <div class="alert alert-primary" role="alert">
        Excluído com sucesso
    </div>
    <?php
} else {
    ?>
    <div class="alert alert-danger" role="alert">
        Erro ao excluir.
    </div>
    <?php
}
?>
<meta http-equiv="refresh" content="1;URL=?p=categoria/listar">