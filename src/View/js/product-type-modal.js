function clearModalProductType() {
  $('#product-type-id').val(null);
  $('#product-type-name').val(null);
  $('#product-type-tax-percentage').val(null);
}

function saveProductType() {
  let id = $('#product-type-id').val();
  let name = $('#product-type-name').val().toUpperCase();
  let taxPercentage = $('#product-type-tax-percentage').val();

  if (!name || !taxPercentage) {
    let message = '<p class="alert-message">Por favor, preencha todos os campos corretamente antes de salvar!</p>';
    $('#message').append(message);
    $('p.alert-message').fadeOut(4500);
    return;
  }

  $.ajax({
    url:"../../Infrastructure/ResolveResource/ProductTypeResolveResource.php",
    type: "POST",
    dataType: 'json',
    data: {
      function: "saveProductType",
      productType: {
        id: id,
        name: name,
        taxPercentage: taxPercentage
      }
    },
    complete: function(xhr) {
      if (xhr.responseText) {
        alert(`Um erro ocorreu, por favor tente novamente mais tarde ou entre em contato com o nosso suporte!\n ${xhr.responseText}`);
      }

      if (!xhr.responseText) {
        location.reload();
      }
    }
  });
}

$('.fa-edit').on('click', function() {
  let rowTable = $(this).parent().parent()
  let childrenRowTable = rowTable.children();
  let id = childrenRowTable[0].innerText;
  let name = childrenRowTable[1].innerText;
  let taxPercentage = childrenRowTable[2].innerText
    .replace(",", ".")
    .replace("%", "");

  $('#product-type-id').val(id);
  $('#product-type-name').val(name);
  $('#product-type-tax-percentage').val(taxPercentage);

  $('#modal-product-type').modal('show');
});

$('.fa-trash-alt').on('click', function() {
  let rowTable = $(this).parent().parent()
  let childrenRowTable = rowTable.children();
  let id = childrenRowTable[0].innerText;
  let name = childrenRowTable[1].innerText;
  let taxPercentage = childrenRowTable[2].innerText
    .replace(",", ".")
    .replace("%", "");

  $.ajax({
    url:"../../Infrastructure/ResolveResource/ProductTypeResolveResource.php",
    type: "POST",
    dataType: 'json',
    data: {
      function: "deleteProductType",
      productType: {
        id: id,
        name: name,
        taxPercentage: taxPercentage
      }
    },
    complete: function(xhr) {
      if (xhr.responseText) {
        alert(`Um erro ocorreu, por favor tente novamente mais tarde ou entre em contato com o nosso suporte!\n ${xhr.responseText}`);
      }

      if (!xhr.responseText) {
        location.reload();
      }
    }
  });
});
