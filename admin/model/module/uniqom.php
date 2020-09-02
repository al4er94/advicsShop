<?php 
class ModelModuleUniqom extends Model {

    public function createTable(){
        $query = $this->db->query(
                "CREATE TABLE IF NOT EXISTS `advics_shop`.`". DB_PREFIX ."uniqom` ( `id` INT NOT NULL AUTO_INCREMENT , `produc` TEXT NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;"
                );
    }
    
    public function createOrUpdateProduct($prodArr){
        $this->db->query("TRUNCATE TABLE `". DB_PREFIX ."uniqom`");
        $this->db->query("START TRANSACTION");
        $transactionArray = array();
        foreach ($prodArr as $prod){
            $res = $this->db->query("INSERT INTO `". DB_PREFIX ."uniqom` (`id`, `produc`) VALUES (NULL, '". (int)$prod ."');");
            $transactionArray[] = $res;
        }
        $rollback = false;
        foreach ($transactionArray as $transactionRes){
            if(!$transactionRes){
                $rollback = true;
                break;
            }
        }
        if($rollback){
            $this->db->query("ROLLBACK");
        }else{
            $this->db->query("COMMIT");
        }
    }
    
    public function getAllProduct(){
        $query = $this->db->query("SELECT * FROM `". DB_PREFIX ."uniqom`");
        $productArray = array();
        foreach ($query->rows as $product) {
            $productArray[] = $product;
        }
        return $productArray;
    }
    
}
?>