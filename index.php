<?php
//chama autoloader
include 'bootstrap.php';

use produto\database as database; 
use produto\produto as produto; 

$prod = new produto; 

$selec = $prod->selecionar();
?>

<!DOCTYPE html>
<html lang="pt-br">
 <?php include('includes/head.php'); ?>

  <body>

    <?php include('includes/menu.php');?>

    <div class="container">
    	<h3>Produtos</h3>
	    <table class="table table-striped">
	    	<tr>
	    		<th>Produto</th>
	    		<th>Categoria</th>
	    		<th>Descrição</th>
	    		<th>Preço</th>
                <th>Ações</th>
	    	</tr>
            <?php if($selec->rowCount() > 0) : ?>
            <?php while ($res = $selec->fetch(\PDO::FETCH_OBJ)):?>
	    	<tr>
	    		<td><?php echo $res->produto; ?></td>
	    		<td><?php echo $res->categoria; ?></td>
                <td><?php echo $res->descricao; ?></td>
	    		<td><?php echo 'R$ '.$prod->moeda($res->preco); ?></td>
                <td>
                    <a href="editar_produto.php?id=<?php echo $res->id?>" class="btn btn-primary btn-sm">Editar</a>
                    <a href="javascript:;" data-id="<?php echo $res->id?>" class="btn btn-danger btn-sm exclusao">Excluir</a>
                </td>
	    	</tr>
            <?php endwhile;?>
        <?php else:?>
            <tr>
                <td colspan="5" align="center">Nenhum produto cadastrado</td>
            </tr>
        <?php endif;?>
		</table>

    </div><!-- /.container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="js/bootstrap.min.js"></script>
    <script>
    $('.exclusao').click(function(){
        if(confirm("Deseja realmente excluir esse registro?\nEsta operação não poderá ser desfeita!")) {
           var id = $(this).data('id');
           $.ajax({
                type: "POST",
                url: "./excluir.php",
                data: { id: id,tipo:'produto'},
                success: function (data) {
                    e = JSON.parse(data);

                    if(e.msgok != null && e.msgok != 'undefined' && e.msgok.length > 0) {
                        alert(e.msgok);
                        window.location = "./";
                    } else {
                        alert('Erro ao excluir');
                        window.location = "./";
                    }
                }
            }); 
       } else {
            return false;
       }
            
    });
        
    </script>
  </body>
       }
</html>
