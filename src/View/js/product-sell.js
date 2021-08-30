function registerSale() {
  let tableData = $('table tr');
  let table = tableData.splice(1, tableData.length);

  let productsSold = [];
  table.forEach(row => {
    let soldAmount = row.children[4].getElementsByClassName('sold-amount')[0].value;
    let quantity = row.children[3].innerText;

    if (soldAmount === '0') {
      return;
    }

    let id = row.children[0].innerText;
    let price = row.children[2].innerText.replace('R$ ', '').replace(',', '.');

    productsSold.push({
        'productId' : id,
        'quantity': quantity,
        'soldAmount': soldAmount,
        'price': price
    });
  });

  $.ajax({
    url:"../../Infrastructure/ResolveResource/ProductResolveResource.php",
    type: "POST",
    dataType: 'json',
    data: {
      function: "productSell",
      productsSold
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

$('.sold-amount').on('blur', function() {
  let rowTable = $(this).parent().parent()
  let childrenRowTable = rowTable.children();
  let quantity = parseInt(childrenRowTable[3].innerText);
  let soldAmount = childrenRowTable[4].getElementsByClassName('sold-amount')[0].value;

  if (quantity == '0' && soldAmount == '0') {
    return;
  }
  
  if (soldAmount <= 0 || soldAmount > quantity) {
    alert(`Você precisa digitar um valor maior que 0 ou digitar um valor menor ou igual a ${quantity}!`);
    childrenRowTable[4].getElementsByClassName('sold-amount')[0].value = 0;
    childrenRowTable[5].innerText = ''
    return;
  }

  let price = parseFloat(
    childrenRowTable[2]
    .innerText
    .replace('R$ ', '')
    .replace(',', '.')
  );

  let total = `R$ ${(soldAmount * price).toFixed(2)}`.replace('.', ',');
  childrenRowTable[5].innerText = total;
});
