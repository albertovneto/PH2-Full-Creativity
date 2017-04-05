<?php
//chama autoloader
include 'bootstrap.php';

use produto\database as database; 
use produto\produto as produto; 
use produto\categoria as categoria;


if (isset($_POST['id']) && $_POST['tipo']=='produto') {
	$prod = new produto;
	if ($prod->excluir($_POST['id'])) {
		echo json_encode(array('msgok' => 'Excluído com sucesso'));
	} else {
		echo json_encode(array('msgerro' => 'Erro ao excluir'));
	}
} else if (isset($_POST['id']) && $_POST['tipo']=='categoria') {
	$cat = new categoria;
	if ($cat->excluir($_POST['id'])) {
		echo json_encode(array('msgok' => 'Excluído com sucesso'));
	} else {
		echo json_encode(array('msgerro' => 'Erro ao excluir'));
	}
}
