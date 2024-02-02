<h3>Lista de alunos </h3>
<a class="btn btn-outline-primary float-right" href="?p=aluno/salvar">adicionar</a>
<br><br>
<table class="table">
    <thead class="thead-dark">
        <tr>
            <th scope="col">id</th>
            <th scope="col">nome</th>
            <th scope="col">email</th>
            <th scope="col">telefone</th>


            <th>opções</th>


        </tr>
    </thead>
    <tbody>
        <?php
        include_once '../class/Aluno.php';
        $cat = new Aluno();
        $dados = $cat->listarFirebase();



        if (!empty($dados)) {
            foreach ($dados as $id => $mostrar) {
                ?>
                <tr>
                    <th scope="row">
                        <?= $id ?>
                    </th>
                    <td>
                        <?= $mostrar['nome'] ?>
                    </td>
                    <td>
                        <?= $mostrar['email'] ?>
                    </td>
                    <td>
                        <?= $mostrar['telefone'] ?>
                    </td>
                    <td>
                        <a href="?p=aluno/salvar&id=<?= $id ?> " class="btn btn-primary">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                        <a href="?p=aluno/excluir&id=<?= $id ?> " class="btn btn-danger"
                            data-confirm="deseja excluir registro ?">
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