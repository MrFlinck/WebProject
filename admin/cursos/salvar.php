

<?php

// capturar o id da URL
//comunicação com class cursos
$id = filter_input(INPUT_GET, 'id');
include_once '../class/Curso.php';
include_once '../class/Area.php';
$cat2 = new Area(); 
$dados2 = $cat2->consultar();
$cat = new Curso();
// iiset seve para verificar se a variavel foi utilizada para editar ou salvar 
if (isset($id)) {
    $cat->setId($id);
    $dados = $cat->consultarPorID();
    foreach ($dados as $mostrar) {
        $nome = $mostrar['nome']; // pode ser $descricao = $mostrar[1];
        $duracao = $mostrar['duracao']; // pode ser $ramal = $mostrar[2];
        $area = $mostrar['id_area']; // mostrar na caixinha na hora de editar
        $imagem = $mostrar['imagem'];
    }
}

// input get singnifica que você está buscando algo 

?>
<h3>
    <?= isset($id) ? 'Editar' : 'Cadastrar' ?> cursos
</h3>
<a class="btn btn-outline-danger float-right" href="?p=cursos/listar">Voltar</a>
<br><br>

<form method="post" enctype="multipart/form-data" name="frmCadastro" id="frmCadastro">



    <div class="form-group">
        <label for="exampleInputText">Nome dos cursos</label>
        <input type="text" class="form-control" id="exampleInputText" name="txtnome"
            value="<?= isset($id) ? $nome : '' ?>">
    </div>

    <div class="form-group">
        <label for="exampleInputText">Duração do cursos</label>
        <input type="text" class="form-control" id="exampleInputText" name="txtduracao"
            value="<?= isset($id) ? $duracao : '' ?>">
    </div>

    <div class="form-group">
        <label for="exampleInputText">Imagem</label>
        <input type="file" class="form-control" id="exampleInputText" name="file_imagem" ?>
    </div>
    
    <div class="form-group">
        <label for="exampleInputText">Área</label>
        <select class="form-control" id="selarea" name="selarea" required>
            <?php
            foreach ($dados2 as $mostrar) {
                echo '<option value="' . $mostrar["id"] . '">'
                    . $mostrar["area"]
                    . '</option>';
            }
            ?>
        </select>
    </div>




    <input type="submit" class="btn btn-<?= isset($id) ? 'success' : 'primary' ?>"
        name="<?= isset($id) ? 'btneditar' : 'btnsalvar' ?>" value="<?= isset($id) ? 'Editar' : 'Cadastrar' ?>">
</form>
<?php
//se eu clicar no botão salvar
if (filter_input(INPUT_POST, 'btnsalvar')) {
    //capturei dados do form HTML para variáveis
    $nome = filter_input(INPUT_POST, 'txtnome', FILTER_SANITIZE_STRING);
    $duracao = filter_input(INPUT_POST, 'txtduracao', FILTER_SANITIZE_STRING);
    $area = filter_input(INPUT_POST, 'selarea', FILTER_SANITIZE_STRING);
    $imagem = $_FILES['file_imagem'];
    
    $extensao = strtolower(pathinfo($imagem['name'], PATHINFO_EXTENSION));
    if (strstr('png', $extensao) || strstr('jpg', $extensao)|| strstr('jpeg', $extensao)) {
        $novoNome = sha1(uniqid(time())) . "." . $extensao;
        $cat->setImagem($novoNome);
        $cat->setTemp_imagem($imagem['tmp_name']);
        $cat->enviarArquivos();
        $cat->setDuracao($duracao);
        $cat->setNome($nome);      
        $cat ->setNome(mb_strtoupper($nome, 'UTF-8'));
        $cat->setId_area($area);
        /*
        $dados = array(
            'nome' => $nome,
            'duracao' => $duracao,
            'Id_area' => $area,
            'imagem' => $imagem['name']
        );
    
        $cat->setDadosJson(json_encode($dados));
    
        $msg = $cat->salvarFirebase() === true ? 'Erro' : 'Salvo';
    
        echo '<div class="alert alert-primary mt-3" role="alert">'
            . $msg
            .  '</div>';    

        if ($cat->salvar()) {
            echo '<div class="alert alert-primary mt-3"
         role="alert">" ';
            echo 'Cadastro efetuado com sucesso';
            echo '</div>';
            echo '<meta http-equiv="refresh" 
         content="0.5"
         URL=?p=cursos/listar">';
        }
        */
        $msg = $cat->salvar('insert') ? 'Salvo no SQL!' : 'Erro';

        echo '<div class="alert alert-primary mt-3" role="alert">'
        . $msg
        . '</div>';
        echo '<meta http-equiv="refresh" content="0.5"
        URL=?p=cursos/listar">';


    }

    //efetivar o cadastro

}


if (filter_input(INPUT_POST, 'btneditar')) {
    //capturei dados do form HTML para variáveis

  
    $nome = filter_input(INPUT_POST, 'txtnome', FILTER_SANITIZE_STRING);
    $duracao = filter_input(INPUT_POST, 'txtduracao', FILTER_SANITIZE_STRING);
    $imagem = $_FILES['file_imagem'];
    $extensao = strtolower(pathinfo($imagem['name'], PATHINFO_EXTENSION));
    $area = filter_input(INPUT_POST, 'selarea', FILTER_SANITIZE_STRING);

    if (strstr('png', $extensao) || strstr('jpg', $extensao) || strstr('jpeg', $extensao)) {
        $novoNome = sha1(uniqid(time())) . "." . $extensao;
        $cat->setImagem($novoNome);
        $cat->setTemp_imagem($imagem['tmp_name']);
        $cat->enviarArquivos();
        $cat->setDuracao($duracao);
        $cat->setNome($nome);
        $cat ->setNome(mb_strtoupper($nome, 'UTF-8'));
        $cat->setId_area($area);
       // a entrada de dados estava errada. Não tinha necessidade de colocar id, porque ele era Null 
       /*

        if ($cat->editar()) {
            echo '<div class="alert alert-primary mt-3"
             role="alert"> ';
            echo 'Edição efetuado com sucesso';
            echo '</div>';
            echo '<meta http-equiv="refresh" content="0.5"
             URL=?p=cursos/listarLike">';
        }
        */
        $msg = $cat->salvar('update') ? 'Editado no SQL ' : 'Erro';
        
        echo '<div class="alert alert-primary mt-3" role="alert">'
        . $msg
        . '</div>';
        echo '<meta http-equiv="refresh" content="0.5"
        URL=?p=cursos/listar">';
    }

}