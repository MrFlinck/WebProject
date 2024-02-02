<h3>Lista de produtos</h3>
<a class="btn btn-outline-primary float-right" href="?p=produto/salvar">Add</a>
<br><br>
<table class="table">
    <thead class="thead-dark">
        <tr>
            <th scope="col">#</th>
            <th scope="col">nome</th>
            <th scope="col">nome da categoria</th>
            <th>Opções</th>
        </tr>
    </thead>
    <tbody>
        <?php
        include_once '../class/Produto.php';
        $cat = new Produto();
        $dados = $cat->consultar();

        if (!empty($dados)) {
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
                        <?= $mostrar['descricao'] ?>
                    </td>
                    <td>
                        <a href="?p=produto/salvar&id=<?= $mostrar['id'] ?>" class="btn btn-primary">
                            <i class="bi bi-pencil-square"></i>

                        </a>
                        <a href="?p=produto/excluir&id=<?= $mostrar['id'] ?>" class="btn btn-danger"
                            data-confirm="Excluir registro?">
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