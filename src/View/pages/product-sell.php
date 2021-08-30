<?php

use SoftExpert\Market\Domain\Service\ProductService;
use SoftExpert\Market\Infrastructure\Persistence\PostgreConnectionCreator;
use SoftExpert\Market\Infrastructure\Repository\ProductRepository;

require_once '../../../vendor/autoload.php';

$connection = PostgreConnectionCreator::createConnection();
$productRepository = new ProductRepository($connection);
$productService = new ProductService($productRepository);
$products = $productService->allProducts();

?>

<?php require_once '../shared/component/head.php'; ?>

<main>
  <button
    type="button"
    class="btn btn-primary"
    onclick="registerSale();"
  >
    <i class="far fa-money-bill-alt fa-lg fa-button"></i>
    Cadastrar venda
  </button>
  <section class="table-responsive table-product">
    <table class="table table-sm table-hover">
      <thead class="table-primary">
        <tr>
          <th>ID</th>
          <th>Descrição</th>
          <th>Preço</th>
          <th>Estoque</th>
          <th>Quantidade vendida</th>
          <th>Total</th>
        </tr>
      <thead>
      <tbody>
        <?php if (count($products) > 0) { ?>
          <?php foreach ($products as $product) { ?>
            <tr>
              <td><?= $product->getId(); ?></td>
              <td><?= $product->getDescription(); ?></td>
              <td><?= 'R$ ' . str_replace('.', ',', $product->getPrice()); ?></td>
              <td><?= $product->getQuantity(); ?></td>
              <td><input type="number" class="sold-amount" value="0"></td>
              <td></td>
            </tr>
          <?php } ?>
        <?php } else  { ?>
          <tr>
            <td colspan="9">Nenhum dado foi encontrado</td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </section>
</main>

<script src="../js/product-sell.js"></script>

<?php require_once '../shared/component/footer.php'; ?>