<?php
    require_once '../models/Product.php';
    require_once '../models/Stock.php';

    if($_GET['method'] === 'create'){
        if(!empty($_POST['productName']) && !empty($_POST['productPrice']) && !empty($_POST['productVariation']) && !empty($_POST['totalProduct'])){
            $product = new Product();
            $product->setName($_POST['productName']);
            $product->setPrice($_POST['productPrice']);
            $product->setVariation($_POST['productVariation']);
            
            $last_product_id = $product->store();
            
            if($last_product_id === -1){
                header('Location: http://localhost:8001?exists');
                return;    
            }
    
            $stock = new Stock();
            $stock->setTotalProduct($_POST['totalProduct']);
            $stock->setLastUpdate(date("Y-m-d H:i:s"));
            $stock->setProductId($last_product_id);

            $stock->store();
            
            header('Location: http://localhost:8001?success');
            return;
        }
        
        header('Location: http://localhost:8001/create_product.php');
        return;
    }else if($_GET['method'] === 'edit'){
        if(!empty($_POST['productId']) && !empty($_POST['productName']) && !empty($_POST['productPrice']) && !empty($_POST['productVariation']) && !empty($_POST['totalProduct'])){
            $product = new Product();
            $stock = new Stock();
            
            $exist_product = $product->getProduct($_POST['productId']);
            
            if(!empty($exist_product)){
                $update_product = [
                    'id' => $_POST['productId'],
                    'name' => $_POST['productName'],
                    'price' => $_POST['productPrice'],
                    'variation' => $_POST['productVariation'],
                    'total_product' => $_POST['totalProduct']
                ];
                
                $updated_product = $product->update($update_product);

                $stock->getStockByProductId(strval($_POST['productId']));
                
                $update_stock = [
                    'id' => $stock->getStockId(),
                    'total_product' => $_POST['totalProduct'],
                    'last_update' => date("Y-m-d H:i:s")
                ];

                $updated_stock = $stock->update($update_stock);

                if($updated_product && $updated_stock){
                    header('Location: http://localhost:8001/');
                    return;
                }
            }
            
            header('Location: http://localhost:8001/update_product.php');
            return;
        }
    }
?>