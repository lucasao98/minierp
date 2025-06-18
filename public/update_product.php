<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atualização de Produtos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="./assets/css/styles.css">
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
                    Atualização de Produtos
                </h1>
            </div>
            <div class="wrapper-form">
                <div class="row">
                    <div class="col-md-7 col-lg-7">
                        <form method="POST" action="/product?method=edit" class="needs-validation" novalidate>
                            <div class="row">
                                <div class="col-sm-12">
                                    <label class="form-label">Nome do Produto</label>
                                    <?php if(isset($_GET['id_product'])) { ?>
                                        <input type="text" class="form-control" id="productName" name="productName" placeholder="Ex: Notebook" required value="<?= $_GET['product_name']; ?>">
                                        <input type="number" name="productId" value="<?= $_GET["id_product"] ?>" hidden>
                                    <?php }else{ ?>
                                        <input type="text" class="form-control" id="productName" name="productName" placeholder="Ex: Notebook" required>
                                    <?php } ?>
                                    <div class="invalid-feedback">
                                        Nome do produto Obrigatório.
                                    </div>
                                </div>

                                <div class="col-sm-12 mt-2">
                                    <label class="form-label">Variações de Produto</label>
                                    <?php if(isset($_GET['product_variation'])) { ?>
                                        <input type="text" class="form-control" id="variationProduct" name="productVariation" placeholder="Ex: Camisa Branca Tamanho G" required value="<?= $_GET['product_variation']; ?>">
                                    <?php }else{ ?>
                                        <input type="text" class="form-control" id="variationProduct" name="productVariation" placeholder="Ex: Camisa Branca Tamanho G" required>
                                    <?php } ?>
                                    <div class="invalid-feedback">
                                        Por favor insira um total inteiro e válido de produtos
                                    </div>
                                </div>

                                <div class="col-6">
                                    <label for="lastName" class="form-label">Preço do Produto</label>
                                    <?php if(isset($_GET['product_price'])) { ?>
                                        <input type="text" class="form-control" id="priceProduct" name="productPrice" placeholder="Ex: 40.89" required value="<?= $_GET['product_price']; ?>">
                                    <?php }else{ ?>
                                        <input type="text" class="form-control" id="priceProduct" name="productPrice" placeholder="Ex: 40.89" required>
                                    <?php } ?>
                                    <div class="invalid-feedback">
                                        Total de Produto Obrigatório
                                    </div>
                                </div>

                                <div class="col-6 mt-2">
                                    <label class="form-label">Total de Produtos Disponíveis
                                        <?php if(isset($_GET['total_product'])) { ?>
                                            <input type="number" class="form-control w-100" id="totalProduct" name="totalProduct" placeholder="100" required value="<?= $_GET['total_product']; ?>">
                                        <?php }else{ ?>
                                            <input type="number" class="form-control w-100" id="totalProduct" name="totalProduct" placeholder="100" required>
                                        <?php } ?>
                                        <div class="invalid-feedback">
                                            Por favor insira um total inteiro e válido de produtos
                                        </div>
                                </div>
                            </div>
                            <div class="mt-3 d-flex gap-2 p-2">
                                <a class="btn btn-warning" href="http://localhost:8001/">Voltar</a>
                                <button class="w-25 btn btn-success" type="submit">Atualizar Produto</button>
                            </div>
                        </form>
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