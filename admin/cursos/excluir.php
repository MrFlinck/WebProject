<?php
$id = filter_input(INPUT_GET, 'id');
$arquivo = filter_input(INPUT_GET, 'arquivo');
$nome = filter_input(INPUT_GET, 'nome');

include_once '../class/Curso.php';
$cat = new Curso();
$cat->setId($id);
$cat->setImagem($arquivo);
$cat->setNome($nome);
//$cat->setId($id);

if ($cat->excluir($id) /*&& $cat->excluirFirebase($id) === 'null'*/) {
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
<meta http-equiv="refresh" content="1;URL=?p=cursos/listar">
