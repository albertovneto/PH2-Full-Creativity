<?php
//chama autoloader
include 'bootstrap.php';

use produto\database as database; 
use produto\categoria as categoria; 

$cat = new categoria;
?>

<!DOCTYPE html>
<html lang="pt-br">
  <?php include('includes/head.php'); ?>

  <body>

    <?php include('includes/menu.php');?>

    <div class="container">
        <?php 
            if (isset($_POST['cadastro'])) {
                $post['categoria'] = filter_var ($_POST['categoria'], FILTER_SANITIZE_STRING);
                if (!empty($post['categoria'])) {
                    if (!$cat->selecionar_cat($nome)){
                        if ($cat->cadastrar($post)) {
                            echo '<script>alert("Cadastrado com sucesso!");window.location = "./cadastrar_categoria.php";</script>';
                        } else {
                            echo '<script>alert("Ocorreu um erro ao cadastrar");window.location = "./cadastrar_categoria.php";</script>';
                        }
                    } else {
                        echo '<script>alert("Categoria já existe");window.location = "./cadastrar_categoria.php";</script>';
                    }
                } else {
                    echo '<script>alert("Preencha todos os campos");window.location = "./cadastrar_categoria.php";</script>';
                }
            }
        ?>
    	<h3>Cadastrar Categoria</h3>
        <form method="post">
            <div class="form-group">
                <label for="categoria">Categoria</label>
                <input type="text" class="form-control" id="categoria" name="categoria" required placeholder="Nome da Categoria">
            </div>
             <button type="submit" class="btn btn-primary" name="cadastro">Cadastrar</button>
        </form>

    </div><!-- /.container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
