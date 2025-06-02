<?php 
    require "../src/config/session.php";
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
                        <a href="/" class="nav-link text-white" aria-current="page">
                            Produtos 
                        </a>
                    </li>
                    <li>
                        <a href="/create_product.php" class="nav-link text-white">
                            Cadastro de Produtos
                        </a>
                    </li>
                    <li>
                        <a href="#" class="nav-link active">
                            Carrinho
                        </a>
                    </li>
                </ul>
            </div>
        </aside>
        <main class="wrapper-content">
            <div class="wrapper-content-title text-white p-2">
                <h1>
                    Carrinho
                </h1>
            </div>
            <div class="wrapper-form">
                <?php if(isset($_SESSION['cart'])){ ?>
                <div class="row">
                    <div class="col-md-5 col-lg-4 order-md-last">
                        <h4 class="d-flex justify-content-between align-items-center mb-3">
                            <span class="text-primary">Carrinho</span>
                            <span class="badge bg-primary rounded-pill"><?= totalProductsSelected(); ?></span>
                        </h4>
                        
                        <ul class="list-group mb-3">
                            <?php 
                                foreach ($_SESSION['cart'] as $productKey => $product) {
                            ?>
                            <li class="list-group-item d-flex justify-content-between lh-sm">
                                <div>
                                    <h6 class="my-0"><?= $product['product_name']; ?></h6>
                                    <small class="text-body-secondary"><?= $product['product_variation']; ?></small>
                                </div>
                                <span class="text-body-secondary">R$ <?= number_format($product['product_price'], 2, ',', '.'); ?></span>
                            </li>
                            <?php    
                                }
                            ?>
                            <li class="list-group-item d-flex justify-content-between bg-body-tertiary">
                                <div>
                                    <h6 class="my-0">Frete</h6>
                                </div>
                                <span class="text-success"><?= number_format(setDeliveryPrice(), 2, ',', '.'); ?></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Total (BRL)</span>
                                <strong>R$ <?= number_format(finalPrice(), 2, ',', '.'); ?></strong>
                            </li>
                        </ul>
                        
                        <form class="card p-2">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Promo code">
                                <button type="submit" class="btn btn-success">Ativar</button>
                            </div>
                        </form>

                        <form class="card p-2 mt-3 mb-3">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Informe seu CEP">
                                <button type="submit" class="btn btn-primary">Buscar</button>
                            </div>
                        </form>

                        <a class="btn btn-success mt-2" href="http://">Finalizar Compra</a>
                    </div>
                </div>
                <?php }else{ ?>
                <div class="row">
                    <div class="col-md-5 col-lg-4 order-md-last">
                        <h4 class="d-flex justify-content-between align-items-center mb-3">
                            <span class="text-primary">Carrinho</span>
                            <span class="badge bg-primary rounded-pill">0</span>
                        </h4>
                        
                        <ul class="list-group mb-3">
                            <li class="list-group-item d-flex justify-content-between lh-sm">
                                <div>
                                    <h6 class="my-0">Carrinho Vazio</h6>
                                </div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Total (BRL)</span>
                                <strong>R$ <?= finalPrice(); ?></strong>
                            </li>
                        </ul>
                    </div>
                </div>
                <?php } ?>
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