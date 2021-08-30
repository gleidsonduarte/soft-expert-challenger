<?php

use SoftExpert\Market\Domain\Service\ProductTypeService;
use SoftExpert\Market\Infrastructure\Persistence\PostgreConnectionCreator;
use SoftExpert\Market\Infrastructure\Repository\ProductTypeRepository;

require_once '../../../vendor/autoload.php';

$connection = PostgreConnectionCreator::createConnection();
$productTypeRepository = new ProductTypeRepository($connection);
$productTypeService = new ProductTypeService($productTypeRepository);

$productsType = $productTypeService->allProductsType();

?>

<?php require_once '../shared/component/head.php'; ?>

<main>
  <button
    type="button"
    class="btn btn-primary"
    data-toggle="modal"
    data-target="#modal-product-type"
  >
    <i class="fas fa-plus fa-lg fa-button"></i>
    Criar novo tipo de produto
  </button>
  <section class="table-responsive table-product-type">
    <table class="table table-sm table-hover">
      <thead class="table-primary">
        <tr>
          <th>ID</th>
          <th>Nome</th>
          <th>Imposto</th>
          <th>Editar</th>
          <th>Excluir</th>
        </tr>
      <thead>
      <tbody>
        <?php if (count($productsType) > 0) { ?>
          <?php foreach ($productsType as $productType) { ?>
            <tr>
              <td><?= $productType->getId(); ?></td>
              <td><?= $productType->getName(); ?></td>
              <td><?= str_replace('.', ',', $productType->getProductTaxPercentage()) . '%'; ?></td>
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

<?php require_once 'components/product-type/product-type-modal.php'; ?>

<?php require_once '../shared/component/footer.php'; ?>
