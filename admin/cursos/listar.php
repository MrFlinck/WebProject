
<h3>Lista de Cursos</h3>
<a class="btn btn-outline-primary float-right" href="?p=cursos/salvar">Add</a>
<br><br>
<table class="table">
    <thead class="thead-dark">
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Nome</th>
            <th scope="col">Duração</th>
            <th scope="col">imagem</th>
            <th scope="col">Area</th>
            <th>Opções</th>
        </tr>
    </thead>
    <tbody>
        <?php
   
        include_once '../class/Curso.php'; 
        $cat = new Curso();
        $dados = $cat->consultar();

        if (!empty($dados)) { // se $dados não tiver vazio, então para cada $dados como $mostrar 
            foreach ($dados as $mostrar) {
                ?>
                <tr>
                    <th scope="row">
                        <?= $mostrar['id'] ?>
                    </th>
                    <td>
                        <?= $mostrar['nome'] ?>
                    </td>
                    <td>
                       <?= $mostrar['duracao'] ?>
                    </td> 
                    <td><img src="../img/cursos/<?= $mostrar['imagem'] ?>" alt="imagem" ></td>
                    <td>
                       <?= $mostrar['id_area'] ?>
                    </td> 
                    <td>
                        <a href="?p=cursos/salvar&id=<?= $mostrar['id'] ?>" class="btn btn-primary">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                        <a href="?p=cursos/excluir&id=<?= $mostrar['id'] ?>&arquivo=<?= $mostrar['imagem'] ?>&nome=<?= $mostrar['nome'] ?>" class="btn btn-danger" data-confirm="Excluir registro?" title="excluir registro">
                            <i class="bi bi-trash"></i>
                        </a>
                        <a href="?p=cursos/imagem&id=<?= $mostrar['id'] ?>&arquivo=<?= $mostrar['imagem'] ?>&nome=<?= $mostrar['nome'] ?>" class="btn btn-success" title="trocar imagem">
                            <i class="bi bi-image"></i>
                        </a>

                    </td>
                </tr>
                <?php
            }   
        } 
        ?>
    </tbody>
</table>