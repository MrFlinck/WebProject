<!--admin/categoria/salvar.php-->


<?php

// capturar o id da URL
//comunicação com class Categoria
$id = filter_input(INPUT_GET, 'id');
include_once '../class/Categoria.php';
include_once '../class/Area.php';
$cat2 = new Area();
$dados2 = $cat2->consultar();
$cat = new Categoria();
// iiset seve para verificar se a variavel foi utilizada para editar ou salvar 

if (isset($id)) {
    $cat->setId($id);
    $dados = $cat->consultarPorID();
    foreach ($dados as $mostrar) {
        $id = $mostrar['id'];
        $descricao = $mostrar['descricao']; // pode ser $descricao = $mostrar[1];
        $ramal = $mostrar['ramal']; // pode ser $ramal = $mostrar[2];
        $area = $mostrar['area'];
    }
}
/*
if (isset($id)) {
    $dados = $cat->consultarPorIDFirebase($id);
    if ($dados !== null) {

        $descricao = $dados['descricao'];
        $ramal = $dados['ramal'];
        $area = $dados['area'];
        $imagem = $dados['imagem'];
    } else {
        echo "Registro não existe";
    }
}*/

// input get singnifica que você está buscando algo 
// mudar uma coisa como nome, e outros variáveis para colocar no firebase. 

?>
<h3>
    <?= isset($id) ? 'Editar' : 'Cadastrar' ?> Categoria
</h3>
<a class="btn btn-outline-danger float-right" href="?p=categoria/listar">Voltar</a>
<br><br>

<form method="post" enctype="multipart/form-data" name="frmCadastro" id="frmCadastro">

    <div class="form-group">
        <label for="exampleInputText">Descrição</label>
        <input type="text" class="form-control" id="exampleInputText" placeholder="Informe a descrição da categoria"
            name="txtdescricao" value="<?= isset($id) ? $descricao : '' ?>">
    </div>

    <div class="form-group">
        <label for="exampleInputText">Ramal</label>
        <input type="number" class="form-control" id="exampleInputText" name="txtramal"
            value="<?= isset($id) ? $ramal : '' ?>">
    </div>
    <div class="form-group">
        <label for="exampleInputText">Imagem</label>
        <input type="file" class="form-control" id="exampleInputText" name="file_imagem">
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
if (filter_input(INPUT_POST, 'btnsalvar')) { // o escopo tá no lugar errado 
    //capturei dados do form HTML para variáveis

    $descricao = filter_input(INPUT_POST, 'txtdescricao', FILTER_SANITIZE_STRING);
    $ramal = filter_input(INPUT_POST, 'txtramal');
    $area = filter_input(INPUT_POST, 'selarea');
    $imagem = $_FILES['file_imagem'];
    /*
    $dados = array(

        'descricao' => $descricao,
        'ramal' => $ramal,
        'area' => $area,
        'imagem' => $imagem['name']
    );
    $cat->setDadosJson(json_encode($dados));
    */



    $extensao = strtolower(pathinfo($imagem['name'], PATHINFO_EXTENSION));
    if (strstr('png', $extensao) || strstr('jpeg', $extensao) || strstr('jpg', $extensao)) {
        $novoNome = sha1(uniqid(time())) . "." . $extensao;
        $cat->setImagem($novoNome);
        $cat->setTemp_imagem($imagem['tmp_name']);
        $cat->enviarArquivos();
        $cat->setDescricao($descricao);
        $cat->setArea($area);
        $cat->setRamal($ramal);

        //efetivar o cadastro



    }
    /*
    $cat->setDadosJson(json_encode($dados));
    $msg = $cat->salvarFirebase() === true ? 'Erro' : 'Salvo com sucesso';
    if ($msg == 'Salvo com sucesso') {
        echo '<div class="alert alert-primary mt-3"
            role="alert"> ';
        echo 'Edição efetuado com sucesso';
        echo '</div>';
        echo '<meta http-equiv="refresh" content="0.5"
            URL=?p=categoria/listar">';
    }
    */
    $msg = $cat->salvar('insert') ? 'Salvo no SQL!' : 'Erro';

        echo '<div class="alert alert-primary mt-3" role="alert">'
        . $msg
        . '</div>';
        echo '<meta http-equiv="refresh" content="0.5"
        URL=?p=categoria/listar">';
  /*      
    ?>
    
   
    <div class="alert alert-primary" role="alert">
        <?= $msg ?>
        
        


    </div>
    <?php  
   */
}


if (filter_input(INPUT_POST, 'btneditar')) {
    //capturei dados do form HTML para variáveis

    $descricao = filter_input(INPUT_POST, 'txtdescricao');
    $ramal = filter_input(INPUT_POST, 'txtramal');
    $imagem = $_FILES['file_imagem'];
    $extensao = strtolower(pathinfo($imagem['name'], PATHINFO_EXTENSION));

    if (strstr('png', $extensao) || strstr('jpg', $extensao)|| strstr('jpeg', $extensao)) {
        $novoNome = sha1(uniqid(time())) . "." . $extensao;
        $cat->setImagem($novoNome);
        $cat->setTemp_imagem($imagem['tmp_name']);
        $cat->enviarArquivos();
        $cat->setDescricao($descricao);
        $cat->setRamal($ramal);
        $cat->setArea($area);
        /*
      
        $dados = array(
            'descricao' => $descricao,
            'ramal' => $ramal,
            'area' => $area,
            'imagem' => $imagem['name']
        );
        $cat->setDadosJson(json_encode($dados));
        $msg = $cat->editarFirebase($id) === true ? 'Erro' : 'Edição efetuado com sucesso';
        ?>
        <div class="alert alert-primary" role="alert">
            <?= $msg ?>
        </div>
        <?php
        */
        $msg = $cat->salvar('update') ? 'Editado no SQL ' : 'Erro';
        
        echo '<div class="alert alert-primary mt-3" role="alert">'
        . $msg
        . '</div>';
        echo '<meta http-equiv="refresh" content="0.5"
        URL=?p=categoria/listar">';


        //enviar dados que capturei do form para class Categoria

        //efetivar o cadastro
        /*
        if ($cat->editarFirebase($id)) {
            echo '<div class="alert alert-primary mt-3"
            role="alert"> ';
            echo 'Edição efetuado com sucesso';
            echo '</div>';
            echo '<meta http-equiv="refresh" content="0.5"
            URL=?p=categoria/listar">';
        }
        */





    }


}