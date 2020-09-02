<?php

class ModelModuleAdvicsSearch extends Model {

    public function createTable() {
        $query = $this->db->query(
                "CREATE TABLE IF NOT EXISTS `advics_shop`.`" . DB_PREFIX . "advics_maker` ( `id` INT NOT NULL AUTO_INCREMENT , `maker` TEXT NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;"
        );
        
         $query = $this->db->query(
                "CREATE TABLE IF NOT EXISTS `advics_shop`.`" . DB_PREFIX . "advics_model` ( `id` INT NOT NULL AUTO_INCREMENT , `maker_id` INT NOT NULL , `model` TEXT NOT NULL, PRIMARY KEY (`id`)) ENGINE = InnoDB;"
        );
         
        $query = $this->db->query(
                "CREATE TABLE IF NOT EXISTS `advics_shop`.`" . DB_PREFIX . "advics_chassis` ( `id` INT NOT NULL AUTO_INCREMENT , `model_id` INT NOT NULL , `chassis` TEXT NOT NULL, PRIMARY KEY (`id`)) ENGINE = InnoDB;"
        );
        
        $query = $this->db->query(
                "CREATE TABLE IF NOT EXISTS `advics_shop`.`" . DB_PREFIX . "advics_price_list` (  `id` INT NOT NULL AUTO_INCREMENT , `maker_id` INT NOT NULL , `model_id` INT NOT NULL , `chassis_id` INT NOT NULL , `year` TEXT NOT NULL , `engine` VARCHAR(50) NOT NULL , `front_pads` VARCHAR(50) NOT NULL DEFAULT ' ' , `front_disk` VARCHAR(50) NOT NULL DEFAULT ' ' , `rear_pads` VARCHAR(50) NOT NULL DEFAULT ' ' , `rear_disk` VARCHAR(50) NOT NULL DEFAULT ' ' , `front_kit` VARCHAR(50) NOT NULL DEFAULT ' ' , `rear_kit` VARCHAR(50) NOT NULL DEFAULT ' ' , PRIMARY KEY (`id`)) ENGINE = InnoDB;"
        );
    }
    
    public function getInfoByType($id, $type){
        switch ($type){
            case 'model';
                $query = $this->db->query("SELECT `id`, `model` FROM `advics_shop`.`" . DB_PREFIX . "advics_model` WHERE `maker_id` = ".(int)$id);
                break;
            case 'chassis';
                $query = $this->db->query("SELECT `id`, `chassis` FROM `advics_shop`.`" . DB_PREFIX . "advics_chassis` WHERE `model_id` = ".(int)$id);
                break;
        }
        $modelArray = array();
        foreach ($query->rows as $product) {
            $modelArray[] = $product;
        }
        return $modelArray;
    }
    
    public function getPrice($maker, $model, $chassis){
        $query = $this->db->query("SELECT o.maker, p.model, q.chassis, i.year, i.engine, i.front_pads,
                    i.front_disk, i.rear_pads, i.rear_disk FROM advics_shop." . DB_PREFIX . "advics_price_list as i
                    LEFT JOIN advics_shop." . DB_PREFIX . "advics_maker as o
                    ON i.maker_id = o.id
                    LEFT JOIN advics_shop." . DB_PREFIX . "advics_model as p
                    ON i.model_id = p.id
                    LEFT JOIN advics_shop." . DB_PREFIX . "advics_chassis as q
                    ON i.chassis_id = q.id
                    WHERE i.maker_id = ".(int)$maker." AND i.model_id = ".(int)$model." AND i.chassis_id = ".(int)$chassis.";");
        $prcieArray = array();
        foreach ($query->rows as $priceList) {
            $prcieArray[] = $priceList;
        }
        return $prcieArray;
    }

}
