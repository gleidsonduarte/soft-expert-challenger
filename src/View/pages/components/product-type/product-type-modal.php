<div
  id="modal-product-type"
  class="modal fade"
  tabindex="-1"
  role="dialog"
  aria-labelledby="modal-product-type-label"
  aria-hidden="true"
  data-backdrop="static"
  data-keyboard="false"
>
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-product-type-label">Criar novo tipo de produto</h5>
      </div>
      <div class="modal-body">
        <form>
          <input type="hidden" id="product-type-id">
          <div class="form-group">
            <label for="product-type-name" class="col-form-label">Nome:</label>
            <input type="text" class="form-control" id="product-type-name">
          </div>
          <div class="form-group">
            <label for="product-type-tax-percentage" class="col-form-label">Imposto:</label>
            <input type="number" class="form-control" id="product-type-tax-percentage"></input>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <span id="message" class="bg-warning"></span>
        <button
          type="button"
          class="btn btn-secondary"
          data-dismiss="modal"
          onclick="clearModalProductType();"
        >
          <i class="fas fa-sign-out-alt fa-lg fa-button"></i>
          Sair
        </button>
        <button
          type="button"
          class="btn btn-success"
          onclick="saveProductType();"
        >
          <i class="fas fa-save fa-lg fa-button"></i>
          Salvar
        </button>
      </div>
    </div>
  </div>
</div>

<script src="../js/product-type-modal.js"></script>
