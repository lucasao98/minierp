<?php 
    require_once "../src/config/connection.php";
    require "../src/models/Stock.php";
    require "../src/config/session.php";
    
    $stock = new Stock();
        
    $allStocks = $stock->getStocks();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MiniERP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="./assets/css/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>

<body>
  <div class="container-fluid wrapper-full-page">
        <aside id="wrapper-menu">
            <div class="d-flex flex-column p-3" style="width: 280px;"> 
                <span class="fs-4 text-white">Menu</span>
                <hr>
                <ul class="nav nav-pills flex-column mb-auto">
                    <li class="nav-item">
                        <a href="/" class="nav-link active" aria-current="page">
                            Produtos 
                        </a>
                    </li>
                    <li>
                        <a href="/create_product.php" class="nav-link text-white">
                            Cadastro de Produtos
                        </a>
                    </li>
                    <li>
                        <a href="/cart.php" class="nav-link text-white">
                            Carrinho
                        </a>
                    </li>
                </ul>
            </div>
        </aside>
        <main class="wrapper-content">
            <div class="wrapper-content-title text-white p-2">
                <h1>
                    Produtos
                </h1>
            </div>
            <div class="wrapper-form">
                <div class="row">
                    <div class="col-md-7 col-lg-7">
                        <?php if(!empty($allStocks)) {
                        ?>
                        <table class="table table-striped">
                        <thead>
                            <tr>
                            <th scope="col">Nome Do Produto</th>
                            <th scope="col">Preço do Produto</th>
                            <th scope="col">Variação do Produto</th>
                            <th scope="col">Total em Estoque (unidade)</th>
                            <th scope="col"></th>
                            <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                foreach ($allStocks as $keyStock => $stock) {
                            ?>
                            <tr>
                            <th scope="row"><?php echo($stock->product()->product_name); ?></th>
                            <td>R$ <?php echo number_format(($stock->product()->product_price), 2, ',', '.'); ?></td>
                            <td><?php echo($stock->product()->product_variation); ?></td>
                            <td><?php echo($stock->getTotalProduct()); ?></td>
                            <td>
                                <a href="<?php echo "/update_product.php?id_product=". $stock->getProductId() .
                                "&product_name=" . $stock->product()->product_name .
                                "&product_price=" . $stock->product()->product_price .
                                "&product_variation=" . $stock->product()->product_variation .
                                "&total_product=" . $stock->getTotalProduct(); ?>"
                                class="btn btn-primary">Editar</a>
                            </td>
                            <td>
                                <?php 
                                    if(!inCart($stock->product()->id_product)){
                                ?>
                                <a 
                                    data-id="<?= $stock->product()->id_product;?>"
                                    data-name="<?= $stock->product()->product_name; ?>"
                                    data-price="<?= $stock->product()->product_price ?>"
                                    data-variation="<?= $stock->product()->product_variation ?>"
                                    class="btn btn-success add_product_cart">
                                    <i class="bi bi-cart-plus"></i>
                                </a>
                                <a 
                                    data-id="<?= $stock->product()->id_product;?>"
                                    class="btn btn-warning remove_product_cart d-none">
                                    <i class="bi bi-cart-dash"></i>
                                </a>
                                <?php }else{ ?>
                                <a 
                                    data-id="<?= $stock->product()->id_product;?>"
                                    class="btn btn-warning remove_product_cart">
                                    <i class="bi bi-cart-dash"></i>
                                </a>
                                <a 
                                    data-id="<?= $stock->product()->id_product;?>"
                                    data-name="<?= $stock->product()->product_name; ?>"
                                    data-price="<?= $stock->product()->product_price ?>"
                                    data-variation="<?= $stock->product()->product_variation ?>"
                                    class="btn btn-success add_product_cart d-none">
                                    <i class="bi bi-cart-plus"></i>
                                </a>
                                <?php } ?>
                            </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                        </table>
                        <?php } ?>
                    </div>
                </div>
            </div>
            
        </main>
        <footer class="wrapper-footer">
            Criado por Luca Sacramento de Oliveira
        </footer>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
    crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
    crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.slim.js" integrity="sha256-UgvvN8vBkgO0luPSUl2s8TIlOSYRoGFAX4jlCIm9Adc=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="./assets/js/products.js"></script>
</html>