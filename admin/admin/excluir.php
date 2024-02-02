<?php
$id = filter_input(INPUT_GET, 'id');


include_once '../class/Admin.php';
$cat = new Admin(); #criar uma nova classe Categoria
$cat->setId($id); #chamar uma função da classe com um parametro id

if ($cat->excluir()) { 
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
<meta http-equiv="refresh" content="1;URL=?p=Admin/listar">


