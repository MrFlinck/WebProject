<h3>Lista de Cursos</h3>
<a class="btn btn-outline-primary float-right" href="?p=cursos/salvar">Add</a>
<br><br>
<div class="col-sm-12">
    <nav aria-label="..." class="mb-3">
        <ul class="pagination justify-content-center">
            <?php
            foreach (range('A', 'Z') as $mostrar) {
            ?>
                <li class="page-item">
                    <a href="?p=cursos/listarLike&letra=<?= $mostrar ?>" class="page-link">
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
            <th scope="col">Duração</th>
            <th scope="col">Area</th>


            <th>Opções</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $letra = filter_input(INPUT_GET, 'letra');
        include_once '../class/Curso.php'; 
        $cat = new Curso();
        $dados = $cat->consultarLike($letra);

        if ($dados) { // se $dados não tiver vazio, então para cada $dados como $mostrar 
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
                    <td>
                       <?= $mostrar['id_area'] ?>
                    </td> 
                    <td>
                        <a href="?p=cursos/salvar&id=<?= $mostrar['id'] ?>" class="btn btn-primary">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                        <a href="?p=cursos/excluir&id=<?= $mostrar['id'] ?>" class="btn btn-danger"
                            data-confirm="Excluir registro?">
                            <i class="bi bi-trash"></i>
                        </a>
                    </td>
                </tr>
                <?php
            }   
        } else {
            ?> 
        
          
           <tr>
             <td colspan="3"> 
             <div class="alert alert-danger" role="alert"> 
              Informções não encontrado!                                        

            </div> 
           </td>


           </tr>
    
            <?php 
        }
        ?>
    </tbody>
</table>