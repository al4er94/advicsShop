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
    
    public function updateOrAddProduct($product){
    	$queryOfProduct = $this->db->query("SELECT `product_id` FROM `". DB_PREFIX ."product` WHERE `model` = '".$product['article_code']."'");
    	$productFromBd = $queryOfProduct->row;
		$quantity = 0;
		$price = 0;
		$depositionArray = [211, 67]; //211 - Спб, 67 - Мск
		foreach($product['deposit_storages'] as $storage){
			if(in_array($storage['id'], $depositionArray)){
				$quantity += $storage['deposit'];
			}
			if($storage['price'] > $price){
				$price = $storage['price'];
			}
		} 
		$price = round (($price+$price*0.14), -1);
		//Подготовка основного описания
		$description = $product['header'].' '.$product['article_code'];
		if(isset($product['variation_code']) && !empty($product['variation_code'])){
			$forCar = explode(',', $product['variation_code']);
			if(is_array($forCar)){
				$description .='<p>Подходят для ватомобилей:</br>';
				foreach($forCar as $car ){
					$description .= $car.'</br>';
				}
				$description .='</p>';
			}
		}
		$sizeArray = explode('/', $product['size']);
		// Описание товара в массив
		$desc = [	'name' => $product['header'].' '.$product['article_code'],
					'description' => $description,
					'meta_description' => $description,
					'meta_title' => $product['header'].' '.$product['article_code']
					];
		// Сохраняем описанеи в большой массив		
		$productDescription = [1 =>$desc, 2=>$desc];
		//Изображение
		$i=0;
		$j=0;
		$imgUrlInBD = '';
		foreach($product['images'] as $img){
			foreach($img as $imgKey => $imgTmp){
			    if($imgKey == 'big'){
			    //	if(!is_dir(DIR_IMAGE.'catalog/'.strtolower($product['brand']).'/'.$product['code'])){
			    //		mkdir(DIR_IMAGE.'catalog/'.strtolower($product['brand']).'/'.$product['code'], 755);
			    //	}
			    	$imgUrlInBD = 'catalog/'.strtolower($product['brand']).'/'.$product['article_code'].'_'.$j.'_'.$i.'.jpg';
			    	$urlImg= 'https://static.uniqom.ru'.$imgTmp;
					$ch = curl_init($urlImg);
					$fp = fopen(DIR_IMAGE.$imgUrlInBD, 'wb');
				    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
				    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
				    curl_setopt($ch, CURLOPT_FILE, $fp);
				    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
				    curl_setopt($ch, CURLOPT_HEADER, 0);
				    curl_exec($ch);
				    curl_close($ch);
				    fclose($fp);
				    $i++;
			    }
			}
			$j++;
		}
		
		// Категория товара по названию
		$productCategory = array();
		if(strpos($product['header'], 'тормозные колодки') !== false){
			$query = $this->db->query("SELECT `category_id` FROM `". DB_PREFIX ."category_description` WHERE `name` LIKE 'тормозные колодки'");
			$productCategory[] = ($query->row)['category_id'];
		}else if(strpos($product['header'], 'Диск тормозной') !== false){
			$query = $this->db->query("SELECT `category_id` FROM `". DB_PREFIX ."category_description` WHERE `name` LIKE 'тормозные диски'");
			$productCategory[] = ($query->row)['category_id'];
		}
		//Производитель 
		$query = $this->db->query("SELECT `manufacturer_id` FROM `". DB_PREFIX ."manufacturer` WHERE `name` LIKE '".$product['brand']."'");
		$manufacturer_id = ($query->row)['manufacturer_id'];
		
		$data = [
				'model' => $product['article_code'],
				'sku' => $product['article_code'],
				'quantity' => $quantity,
				'product_description' => $productDescription,
				'price' => $price,
				'manufacturer_id' => $manufacturer_id,
				'weight' => $product['weight'],
				'weight_class_id' => 1,
				'length' => $sizeArray[0],
				'width' => $sizeArray[1],
				'height' => $sizeArray[2],
				'product_category' => $productCategory,
				'image' => $imgUrlInBD,
				'product_store' => [0],
				'status' => 1,
				'keyword' =>$product['article_code']
				
			];
		
		if(empty($productFromBd)){
			$this->model_catalog_product->addProduct($data);
		}else{
			$this->model_catalog_product->editProduct($productFromBd['product_id'], $data);
		}
    			
	 //$this->model_catalog_product->addProduct
    	//$this->model_catalog_product->get
    	//var_dump($product['id']);
    }
    
}
?>