<?php
$id = $_GET['id'];
if (!isset($id) || empty($id))
    header('Location: index.php');


//chama autoloader
include 'bootstrap.php';

use produto\database as database; 
use produto\categoria as categoria; 

$cat = new categoria(); 

$categ = $cat->selecionar($id);

?>

<!DOCTYPE html>
<html lang="pt-br">
  <?php include('includes/head.php'); ?>

  <body>

    <?php include('includes/menu.php');?>

    <div class="container">
        <?php 
            if (isset($_POST['editar'])) {
                $post['categoria'] = filter_var ($_POST['categoria'], FILTER_SANITIZE_STRING);
                $post['id_categoria'] = filter_var ($_POST['id_categoria'], FILTER_SANITIZE_NUMBER_INT);
                if (!empty($post['categoria']) && !empty($post['id_categoria'])) {
                    if (!$cat->selecionar_cat($post['categoria'],$post['id_categoria'])){
                        if ($cat->editar($post)) {
                            echo "<script>alert('Editado com sucesso!');window.location = './editar_categoria.php?id=$id' </script>";
                        } else {
                            echo "<script>alert('Ocorreu um erro ao editar');window.location='./editar_categoria.php?id=$id'</script>";
                        } 
                    } else {
                        echo "<script>alert('Categoria já existe');window.location='./editar_categoria.php?id=$id'</script>";
                    }
                } else {
                        echo '<script>alert("Preencha todos os campos");window.location("./editar_produto.php");</script>';
                }
                    
            }
        ?>
        <?php if($categ->rowCount() > 0) :?>
        <?php $res = $categ->fetch(PDO::FETCH_OBJ);?>
    	<h2>Editar Produto</h3>
        <form method="post">
            <div class="form-group">
                <label for="categoria">Categoria</label>
                <input type="text" name="categoria" value="<?php echo $res->categoria ?>" class="form-control" id="categoria" placeholder="Nome do Produto">
            </div>
            <input type="hidden" name="id_categoria" value="<?php echo $res->id_categoria ?>">
             <button type="submit" class="btn btn-primary" name="editar">Editar</button>
        </form>
    <?php else :?>
        <p>Nenhuma categoria encontrado</p>
    <?php endif; ?>
    </div><!-- /.container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
