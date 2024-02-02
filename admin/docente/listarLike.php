<h3>Lista de  Docente</h3>
<a class="btn btn-outline-primary float-right" href="?p=docente/salvar">Add</a>
<br><br>
<div class="col-sm-12">
    <nav aria-label="..." class="mb-3">
        <ul class="pagination justify-content-center">
            <?php
            foreach (range('A', 'Z') as $mostrar) {
            ?>
                <li class="page-item">
                    <a href="?p=docente/listarLike&letra=<?= $mostrar ?>" class="page-link">
                        <?= $mostrar ?>
                    </a>
                </li>
            <?php
            }
            ?>
        </ul>
    </nav>
</div>

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
       $letra = filter_input(INPUT_GET, 'letra');
       include_once '../class/Docente.php';
       $cat = new Docente();
       $dados = $cat-> consultarLike($letra);
        if ($dados) {
            foreach ($dados as $mostrar) {
                ?>
                <tr>
                    <th scope="row"><?= $mostrar['id'] ?></th>
                    <td><?= $mostrar['nome'] ?></td>
                    <td><?= $mostrar['email'] ?></td>
                    <td><?= $mostrar['formacao'] ?></td>
                 
                    <td>
                        <a href="?p=docente/salvar&id=<?= $mostrar['id'] ?>" class="btn btn-primary">
                            <i class="bi bi-pencil-square"></i>
                        
                        </a>
                        <a href="?p=docente/excluir&id=<?= $mostrar['id'] ?>" class="btn btn-danger"
                         data-confirm="Excluir registro?">
                            <i class="bi bi-trash"></i>
                        </a>
                    </td>
                </tr> 
                <?php
            }
        } else {
            ?> 
        
            <div class="alert alert-primary" role="alert"> 
              Informções não encontrado!

            </div> 
    
            <?php 
        }
        ?>
    </tbody>
</table>
