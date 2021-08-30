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
    data-toggle="modal"
    data-target="#modal-product"
  >
    <i class="fas fa-plus fa-lg fa-button"></i>
    Criar novo produto
  </button>
  <section class="table-responsive table-product">
    <table class="table table-sm table-hover">
      <thead class="table-primary">
        <tr>
          <th>ID</th>
          <th>Descrição</th>
          <th>Tipo do Produto</th>
          <th>Marca</th>
          <th>Preço</th>
          <th>Estoque</th>
          <th>EAN</th>
          <th>Data de Entrada</th>
          <th>Data de Vencimento</th>
          <th>Editar</th>
          <th>Excluir</th>
        </tr>
      <thead>
      <tbody>
        <?php if (count($products) > 0) { ?>
          <?php foreach ($products as $product) { ?>
            <tr>
              <td><?= $product->getId(); ?></td>
              <td><?= $product->getDescription(); ?></td>
              <td><?= $product->getProductType()->getName(); ?></td>
              <td><?= $product->getBrand(); ?></td>
              <td><?= 'R$ ' . str_replace('.', ',', $product->getPrice()); ?></td>
              <td><?= $product->getQuantity(); ?></td>
              <td><?= $product->getEan(); ?></td>
              <td><?= date_format(date_create($product->getEntryDate()), 'd/m/Y'); ?></td>
              <td><?= date_format(date_create($product->getDueDate()), 'd/m/Y'); ?></td>
              <td><i class="fas fa-edit fa-lg"></i></td>
              <td><i class="fas fa-trash-alt fa-lg"></i></td>
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

<?php require_once 'components/product-type/product-modal.php'; ?>

<?php require_once '../shared/component/footer.php'; ?>