function formatStringData(data) {
  let day = data.split("/")[0];
  let month = data.split("/")[1];
  let year = data.split("/")[2];

  return `${year}-${("0" + month).slice(-2)}-${("0" + day).slice(-2)}`;
}

function clearModalProduct() {
  $('#product-id').val(null);
  $('#product-description').val(null);
  $('#product-type').val(null);
  $('#product-brand').val(null);
  $('#product-price').val(null);
  $('#product-quantity').val(null);
  $('#product-ean').val(null);
  $('#product-entry-date').val(null);
  $('#product-due-date').val(null);
}

function saveProduct() {
  let id = $('#product-id').val();
  let description = $('#product-description').val();
  let type = $('#product-type option:selected').text();
  let brand = $('#product-brand').val().toUpperCase();
  let price = $('#product-price').val();
  let quantity = $('#product-quantity').val();
  let ean = $('#product-ean').val().toUpperCase();
  let entryDate = $('#product-entry-date').val();
  let dueDate = $('#product-due-date').val();

  if (!description || !type || !brand || !price || !quantity || !ean || !entryDate || !dueDate) {
    let message = '<p class="alert-message">Por favor, preencha todos os campos corretamente antes de salvar!</p>';
    $('#message').append(message);
    $('p.alert-message').fadeOut(4500);
    return;
  }

  $.ajax({
    url:"../../Infrastructure/ResolveResource/ProductResolveResource.php",
    type: "POST",
    dataType: 'json',
    data: {
      function: "saveProduct",
      product: {
        id: id,
        description: description,
        type: type,
        brand: brand,
        price: price,
        quantity: quantity,
        ean: ean,
        entryDate: entryDate,
        dueDate: dueDate
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
  let description = childrenRowTable[1].innerText;
  let type = childrenRowTable[2].innerText;
  let brand = childrenRowTable[3].innerText;
  let price = childrenRowTable[4].innerText
    .replace("R$ ", "")
    .replace(",", ".");
  let quantity = childrenRowTable[5].innerText;
  let ean = childrenRowTable[6].innerText;
  let entryDate = formatStringData(childrenRowTable[7].innerText);
  let dueDate = formatStringData(childrenRowTable[8].innerText);

  $('#product-id').val(id);
  $('#product-description').val(description);
  $('#product-type').val(type);
  $('#product-brand').val(brand);
  $('#product-price').val(price);
  $('#product-quantity').val(quantity);
  $('#product-ean').val(ean);
  $('#product-entry-date').val(entryDate);
  $('#product-due-date').val(dueDate);

  $('#modal-product').modal('show');
});

$('.fa-trash-alt').on('click', function() {
  let rowTable = $(this).parent().parent()
  let childrenRowTable = rowTable.children();
  let id = childrenRowTable[0].innerText;
  let description = childrenRowTable[1].innerText;
  let type = childrenRowTable[2].innerText;
  let brand = childrenRowTable[3].innerText;
  let price = childrenRowTable[4].innerText
    .replace("R$ ", "")
    .replace(",", ".");
  let quantity = childrenRowTable[5].innerText;
  let ean = childrenRowTable[6].innerText;
  let entryDate = formatStringData(childrenRowTable[7].innerText);
  let dueDate = formatStringData(childrenRowTable[8].innerText);

  $.ajax({
    url:"../../Infrastructure/ResolveResource/ProductResolveResource.php",
    type: "POST",
    dataType: 'json',
    data: {
      function: "deleteProduct",
      product: {
        id: id,
        description: description,
        type: type,
        brand: brand,
        price: price,
        quantity: quantity,
        ean: ean,
        entryDate: entryDate,
        dueDate: dueDate
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
