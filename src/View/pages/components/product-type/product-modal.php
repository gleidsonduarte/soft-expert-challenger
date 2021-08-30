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

<div
  id="modal-product"
  class="modal fade"
  tabindex="-1"
  role="dialog"
  aria-labelledby="modal-product-label"
  aria-hidden="true"
  data-backdrop="static"
  data-keyboard="false"
>
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-product-label">Criar novo tipo de produto</h5>
      </div>
      <div class="modal-body">
        <form class="col-12">
          <input type="hidden" id="product-id">
          <div class="form-group">
            <label for="product-description" class="col-form-label">Descrição:</label>
            <input type="text" class="form-control" id="product-description">
          </div>
          <div class="row form-group">
            <div class="col-6">
              <label for="" class="col-form-label">Tipo de produto:</label>
              <select id="product-type" class="form-control">
                <?php foreach ($productsType as $productType) { ?>
                  <option value="<?= $productType->getName() ?>"><?= $productType->getName(); ?></option>
                <?php } ?>
              </select>
            </div>
            <div class="col-6">
              <label for="product-brand" class="col-form-label">Marca:</label>
              <input type="text" class="form-control" id="product-brand"></input>
            </div>
          </div>
          <div class="row form-group">
            <div class="col-6">
              <label for="product-price" class="col-form-label">Preço:</label>
              <input type="number" class="form-control" id="product-price"></input>
            </div>
            <div class="col-6">
              <label for="product-quantity" class="col-form-label">Quantidade:</label>
              <input type="number" class="form-control" id="product-quantity"></input>
            </div>
          </div>
          <div class="row form-group">
            <div class="col-12">
              <label for="product-ean" class="col-form-label">Código EAN:</label>
              <input type="text" class="form-control" id="product-ean"></input>
            </div>
          </div>
          <div class="row form-group">
            <div class="col-6">
              <label for="product-entry-date" class="col-form-label">Data de entrada:</label>
              <input type="date" id="product-entry-date" class="form-control"></input>
            </div>
            <div class="col-6">
              <label for="product-due-date" class="col-form-label">Data de vencimento:</label>
              <input type="date" class="form-control" id="product-due-date"></input>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <span id="message" class="bg-warning"></span>
        <button
          type="button"
          class="btn btn-secondary"
          data-dismiss="modal"
          onclick="clearModalProduct();"
        >
          <i class="fas fa-sign-out-alt fa-lg fa-button"></i>
          Sair
        </button>
        <button
          type="button"
          class="btn btn-success"
          onclick="saveProduct();"
        >
          <i class="fas fa-save fa-lg fa-button"></i>
          Salvar
        </button>
      </div>
    </div>
  </div>
</div>

<script src="../js/product-modal.js"></script>
