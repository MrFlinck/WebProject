<h3>Lista de Categorias</h3>
<a class="btn btn-outline-primary float-right" href="?p=categoria/salvar">Add</a>
<br><br>
<table class="table">
    <thead class="thead-dark">
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Descrição</th>
            <th scope="col">ramal</th>
            <th scope="col">imagem</th>
            <th scope="col">Área</th>
            <th>Opções</th>
        </tr>
    </thead>
    <tbody>
        <?php
        include_once '../class/Categoria.php';
        $cat = new Categoria();
        /*
        $dados = $cat->listarFirebase();*/
        $dados = $cat->consultar();
        


        /*
        if (!empty($dados)) {
            foreach ($dados as $id => $mostrar) {
                ?>
                <tr>
                    <th scope="row">
                        <?= $id ?>
                    </th>
                    <td>
                        <?= $mostrar['descricao'] ?>
                    </td>
                    <td>
                        <?= $mostrar['ramal'] ?>
                    </td>
                    <td><img src="../img/categoria/<?= $mostrar['imagem'] ?>" alt="imagem"></td>

                    <td>
                        <?= $mostrar['area'] ?>
                    </td>

                    <td>
                        <a href="?p=categoria/salvar&id=<?= $id ?>" class="btn btn-primary">
                            <i class="bi bi-pencil-square"></i>

                        </a>
                        <a href="?p=categoria/excluir&id=<?= $id ?>" class="btn btn-danger" data-confirm="Excluir registro?">
                            <i class="bi bi-trash"></i>
                        </a>
                        <a href="?p=categoria/imagem&id=<?= $id ?>&arquivo=<?= $mostrar['imagem'] ?>&descricao=<?= $mostrar['descricao'] ?>" class="btn btn-success" title="trocar imagem">
                            <i class="bi bi-image"></i>
                        </a>
                    </td>
                </tr>
                <?php
            }
        }
        */
        if (!empty($dados)) {
            foreach ($dados as $mostrar ) {
                ?>
                <tr>
                    <th scope="row"><?= $mostrar['id'] ?></th>
                    <td><?= $mostrar['descricao'] ?></td>
                    <td><?= $mostrar['ramal'] ?></td>
                
                    <td><img src="../img/categoria/<?= $mostrar['imagem'] ?>" alt="imagem" ></td>
                    <td><?= $mostrar['area'] ?></td>
                    <td>
                        <a href="?p=categoria/salvar&id=<?= $mostrar['id'] ?>" class="btn btn-primary" title="editar registro">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                        <a href="?p=categoria/excluir&id=<?= $mostrar['id'] ?>&arquivo=<?= $mostrar['imagem'] ?>&descricao=<?= $mostrar['descricao'] ?>" class="btn btn-danger" data-confirm="Excluir registro?" title="excluir registro">
                            <i class="bi bi-trash"></i>
                        </a>
                        <a href="?p=categoria/imagem&id=<?= $mostrar['id'] ?>&arquivo=<?= $mostrar['imagem'] ?>&descricao=<?= $mostrar['descricao'] ?>" class="btn btn-success" title="trocar imagem">
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