<h3>Lista de funcionarios </h3> 
<a class="btn btn-outline-primary float-right" href="?p=funcionario/salvar">adicionar</a>
<br><br> 
<table class ="table"> 
    <thead class="thead-dark">
        <tr>
            <th scope="col">id</th>
            <th scope="col">nome</th>
            <th scope="col">salário</th>
            <th scope="col">Departamento</th> 
            <th scope="col">Imagem</th> 
            <th>opções</th>
            
            
        </tr>
    </thead>
    <tbody>
        <?php 
        include_once '../class/Funcionario.php';
        $cat = new Funcionario(); 
        $dados = $cat->listarFirebase();
     


        if (!empty($dados)){
            foreach ($dados as $id => $mostrar){
                ?> <tr> 
                    <th scope="row"><?= $id?></th>
                    <td> <?= $mostrar['nome']?> </td>
                    <td> <?= $mostrar['salario']?></td>
                    <td> <?= $mostrar['depto']?> </td>
                    <td><img src="../img/funcionario/<?= $mostrar['imagem'] ?>" alt="imagem" ></td>
                    <td> 
                        <a href="?p=funcionario/salvar&id=<?= $id?> " class="btn btn-primary">
                        <i class="bi bi-pencil-square"></i>
            </a> 
            <a href="?p=funcionario/excluir&id=<?= $id ?> " class="btn btn-danger" data-confirm="deseja excluir registro ?">
            <i class="bi bi-trash"></i> 
            </a> 
                    </td>
                </tr>
                <?php 
            }
        }
        ?>
    </tbody>
</table>