<?php
$id = filter_input(INPUT_GET, 'id');
$arquivo = filter_input(INPUT_GET, 'arquivo');
$nome = filter_input(INPUT_GET, 'nome');
?>
<h3>
    Trocar Imagem do curso <?= $nome ?>
</h3>
<a class="btn btn-outline-danger float-right" href="?p=cursos/listar">Voltar</a>
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
    include_once '../class/Curso.php';
    $cat = new Curso();
    $cat->setId($id);
    $cat->setImagem($arquivo);
    $cat->setNome($nome);
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

        echo '<meta http-equiv="refresh" content="0.5;URL=?p=cursos/listar">';
    }
}
?>


