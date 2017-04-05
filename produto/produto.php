<?php
/**
 * Created by PhpStorm.
 * User: vieira
 * Date: 04/04/2017
 */



namespace produto;
use \PDO;

class produto
{
    public static function getInstance()
    {
        if (!isset(self::$instance))
            self::$instance = new produto();

        return self::$instance;
    }

    public function selecionar($id = '')
    {
        try {
            if (!empty($id)) {
                $sql = "SELECT * FROM produto as P LEFT JOIN categoria as C ON P.id_categoria = C.id_categoria WHERE P.id = ?";
                $stmt = Database::getInstance()->prepare($sql);
                $stmt->bindParam(1, $id,PDO::PARAM_INT); 
            } else {
                $sql = "SELECT * FROM produto as P LEFT JOIN categoria as C ON P.id_categoria = C.id_categoria";
                $stmt = Database::getInstance()->prepare($sql);
            }
            $stmt->execute();
           return $stmt;
        } catch (Exception $e) {
            echo "Erro:".$e->getMessage();
        }
    }

    public function selecionar_prod($nome,$id='')
    {
        try {
            if (empty($id)) {
                $sql = "SELECT * FROM produto as P LEFT JOIN categoria as C ON P.id_categoria = C.id_categoria WHERE P.produto = ?";
                $stmt = Database::getInstance()->prepare($sql);
                $stmt->bindParam(1, $nome);
            } else {
                $sql = "SELECT * FROM produto as P LEFT JOIN categoria as C ON P.id_categoria = C.id_categoria WHERE P.id != ? AND P.produto = ?";
                $stmt = Database::getInstance()->prepare($sql);
                $stmt->bindParam(1, $id,PDO::PARAM_INT);
                $stmt->bindParam(2, $nome);
            }
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                return true;
            } else {
               return false;
            }
        } catch (Exception $e) {
            echo "Erro:".$e->getMessage();
        }
    }

    public function cadastrar($dados)
    {

        try {
            $sql = "INSERT INTO produto (produto,descricao,preco,id_categoria) VALUES (?,?,?,?)";

            $stmt = Database::getInstance()->prepare($sql);

            $stmt->bindParam(1, $dados['produto']);
            $stmt->bindParam(2, $dados['descricao']);
            $stmt->bindParam(3, $dados['preco']);
            $stmt->bindParam(4, $dados['id_categoria']);
            return $stmt->execute();

        } catch (Exception $e) {
            echo "Erro:".$e->getMessage();
        }
    }

    public function editar($dados)
    {
        try {
            $sql = "UPDATE produto SET produto = ?, descricao = ?, preco = ?, id_categoria = ?  WHERE id = ?";

            $stmt = Database::getInstance()->prepare($sql);

            $stmt->bindParam(1, $dados['produto']);
            $stmt->bindParam(2, $dados['descricao']);
            $stmt->bindParam(3, $dados['preco']);
            $stmt->bindParam(4, $dados['id_categoria']);
            $stmt->bindParam(5, $dados['id'],PDO::PARAM_INT);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                return true;
            } else {
               return false;
            }

        } catch (Exception $e) {
            echo "Erro:".$e->getMessage();
        }
    }

    public function excluir($id)
    {
        try {
            $sql = "DELETE FROM produto WHERE id = ?";
            $stmt = Database::getInstance()->prepare($sql);
            $stmt->bindParam(1, $id,PDO::PARAM_INT); 
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                return true;
            } else {
               return false;
            }
        } catch (Exception $e) {
            echo "Erro:".$e->getMessage();
        }
    }

    public function moeda($valor=NULL)
    {
    
        if($valor != NULL) {
            $moeda=number_format($valor,2,",",".");
            return $moeda;
        }
        return NULL;
    }

    public function moeda_decimal($valor){
        $moeda=str_replace('.', '', $valor);
        $moeda=str_replace('R$ ','', $moeda);
        $moeda=str_replace(',','.', $moeda);

        return $moeda;
    }


}