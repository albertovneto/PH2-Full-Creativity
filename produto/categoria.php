<?php
/**
 * Created by PhpStorm.
 * User: vieira
 * Date: 04/04/2017
 */



namespace produto;
use \PDO;

class categoria
{
    public static function getInstance()
    {
        if (!isset(self::$instance))
            self::$instance = new categoria();

        return self::$instance;
    }

    public function selecionar($id = '')
    {
        try {
            if (!empty($id)) {
                $sql = "SELECT * FROM categoria WHERE id_categoria = ?";
                $stmt = Database::getInstance()->prepare($sql);
                $stmt->bindParam(1, $id,PDO::PARAM_INT); 
            } else {
                $sql = "SELECT * FROM categoria";
                $stmt = Database::getInstance()->prepare($sql);
            }
            
           $stmt->execute();
           return $stmt;
        } catch (Exception $e) {
            echo "Erro:".$e->getMessage();
        }
    }

    public function selecionar_cat($nome,$id = '')
    {
        try {
            if (!empty($id)) {
                $sql = "SELECT * FROM categoria as C WHERE C.id_categoria != ? AND C.categoria = ?";
                $stmt = Database::getInstance()->prepare($sql);
                $stmt->bindParam(1, $id,PDO::PARAM_INT); 
                $stmt->bindParam(2, $nome); 
            } else {
                $sql = "SELECT * FROM categoria as C WHERE C.categoria = ?";
                $stmt = Database::getInstance()->prepare($sql);
                $stmt->bindParam(1, $nome);
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
            $sql = "INSERT INTO categoria (categoria) VALUES (?)";

            $stmt = Database::getInstance()->prepare($sql);

            $stmt->bindParam(1, $dados['categoria']);
            return $stmt->execute();

        } catch (Exception $e) {
            echo "Erro: ".$e->getMessage();
        }
    }

    public function editar($dados)
    {
        
        try {
            $sql = "UPDATE categoria as C SET C.categoria = ? WHERE C.id_categoria = ?";

            $stmt = Database::getInstance()->prepare($sql);

            $stmt->bindParam(1, $dados['categoria']);
            $stmt->bindParam(2, $dados['id_categoria'],PDO::PARAM_INT);
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
            $sql = "DELETE FROM categoria WHERE id_categoria = ?";
            $stmt = Database::getInstance()->prepare($sql);
            $stmt->bindParam(1, $id,PDO::PARAM_INT); 
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                return true;
            } else {
               return false;
            }
        } catch (Exception $e) {
            echo "Erro: ".$e->getMessage();
        }
    }

}