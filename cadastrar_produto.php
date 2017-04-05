<?php
//chama autoloader
include 'bootstrap.php';

use produto\database as database; 
use produto\produto as produto; 
use produto\categoria as categoria; 

$prod = new produto;
$cat = new categoria;

$selec_cat = $cat->selecionar();
?>

<!DOCTYPE html>
<html lang="pt-br">
  <?php include('includes/head.php'); ?>

  <body>

    <?php include('includes/menu.php');?>

    <div class="container">
        <?php 
            if (isset($_POST['cadastro'])) {
                $post['produto'] = filter_var ($_POST['produto'], FILTER_SANITIZE_STRING);
                $post['descricao'] = filter_var ($_POST['descricao'], FILTER_SANITIZE_STRING);
                $post['preco'] = $prod->moeda_decimal($_POST['preco']);
                $post['id_categoria'] = filter_var ($_POST['id_categoria'], FILTER_SANITIZE_NUMBER_INT);
                if (!empty($post['produto']) && !empty($post['descricao']) && !empty($post['preco']) && $post['id_categoria']) {
                    if (!$prod->selecionar_prod($post['produto'])) {
                        if ($prod->cadastrar($post)) {
                            echo '<script>alert("Cadastrado com sucesso!");window.location = "./cadastrar_produto.php";</script>';
                        } else {
                            echo '<script>alert("Ocorreu um erro ao cadastrar");window.location = "./cadastrar_produto.php";</script>';
                        }
                    } else {
                        echo '<script>alert("Produto já cadastrado");window.location = "./cadastrar_produto.php";</script>';
                    }
                } else {
                    echo '<script>alert("Preencha todos os campos");window.location = "./cadastrar_produto.php";</script>';
                }
                
            }
        ?>
    	<h3>Cadastrar Produtos</h3>
        <form method="post">
            <div class="form-group">
                <label for="produto">Nome do Produto*</label>
                <input type="text" class="form-control" id="produto" name="produto" placeholder="Nome do Produto" required>
            </div>
            <div class="form-group">
                <label for="categoria">Categoria*</label>
                <select class="form-control" name="id_categoria" id="categoria" required>
                    <option value="">Selecione</option>
                    <?php while ($result = $selec_cat->fetch(PDO::FETCH_OBJ)):?>
                        <option value="<?php echo $result->id_categoria ?>"><?php echo $result->categoria; ?></option>
                    <?php endwhile;?>
                </select>
            </div>
            <div class="form-group">
                <label for="preco">Preço*</label>
                <input type="text" class="form-control" name="preco" id="preco" required data-affixes-stay="true" data-prefix="R$ " data-thousands="." data-decimal=","></textarea>
            </div>
            <div class="form-group">
                <label for="desc">Descrição*</label>
                <textarea name="descricao" class="form-control" rows="3" id="desc" required></textarea>
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
    <script src="js/maskMoney.js"></script>
    <script>$('#preco').maskMoney();</script>
  </body>
</html>
