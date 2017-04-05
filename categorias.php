<?php
//chama autoloader
include 'bootstrap.php';

use produto\database as database; 
use produto\categoria as categoria; 

$cat = new categoria; 

$categ = $cat->selecionar();
?>

<!DOCTYPE html>
<html lang="pt-br">
 <?php include('includes/head.php'); ?>

  <body>

    <?php include('includes/menu.php');?>

    <div class="container">
    	<h3>Categorias</h3>
	    <table class="table table-striped">
	    	<tr>
	    		<th>Categoria</th>
                <th>Ações</th>
	    	</tr>
            <?php if($categ->rowCount() > 0) :?>
            <?php while ($res = $categ->fetch(PDO::FETCH_OBJ)):?>
	    	<tr>
	    		<td><?php echo $res->categoria; ?></td>
                <td>
                    <a href="./editar_categoria.php?id=<?php echo $res->id_categoria ?>" class="btn btn-primary btn-sm">Editar</a>
                    <a href="javascript:;" data-id="<?php echo $res->id_categoria ?>" class="btn btn-danger btn-sm exclusao">Excluir</button>
                </td>
	    	</tr>
            <?php endwhile;?>
        <?php else:?>
            <tr>
                <td colspan="2" align="center">Nenhuma categoria cadastrada</td>
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
                data: { id: id, tipo:'categoria'},
                success: function (data) {
                    e = JSON.parse(data);

                    if(e.msgok != null && e.msgok != 'undefined' && e.msgok.length > 0) {
                        alert(e.msgok);
                        window.location = "./categorias.php";
                    } else {
                        alert('Erro ao excluir');
                        window.location = "./categorias.php";
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
