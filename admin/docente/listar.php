<h3>Lista de Docente</h3>
<a class="btn btn-outline-primary float-right" href="?p=docente/salvar">Add</a>
<br><br>
<table class="table">
    <thead class="thead-dark">
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Nome</th>
            <th scope="col">Email</th>
            <th scope="col">Formação</th>
            <th>Opções</th>
        </tr>
    </thead>
    <tbody>
        <?php
        include_once '../class/Docente.php';
        $cat = new Docente();
        $dados = $cat->listarFirebase();
        
        
        if (!empty($dados)) {
            foreach ($dados as $id => $mostrar) {
                ?>
                <tr>
                    <th scope="row"><?= $id ?></th>
                    <td><?= $mostrar['nome'] ?></td>
                    <td><?= $mostrar['email'] ?></td>
                    <td><?= $mostrar['formacao'] ?></td>

                    
                    <td>
                        <a href="?p=docente/salvar&id=<?= $id ?>" class="btn btn-primary">
                            <i class="bi bi-pencil-square"></i>
                        
                        </a>
                        <a href="?p=docente/excluir&id=<?= $id ?>" class="btn btn-danger" data-confirm="Excluir registro?">
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
