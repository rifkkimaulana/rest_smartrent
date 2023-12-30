function fetch_data() {
  const urlParams = new URLSearchParams(window.location.search);
  const searchTerm = urlParams.get("search");

  $.ajax({
    type: "GET",
    url: "http://localhost:8080/api/produk?search=" + searchTerm,
    headers: {
      "X-API-Key": "asdasd",
    },
    dataType: "JSON",
    success: function (response) {
      $("#card_data").html("");

      if (response.status) {
        $.each(response.data, function (i, product) {
          let card_data = `
              <div class="product-card">
                <p class="product-name">${product.nama_produk}</p>
                <p class="product-price">Rp. ${numFormat(product.harga)}</p>
                <button class="product-button" onclick="dialog('${product.id}')">Detail</button>
              </div>
            `;
          $("#card_data").append(card_data);
        });
      } else {
        $("#card_data").html(
          '<div class="col-12 text-center"><h4 class="text-danger">Oops, barang yang anda cari tidak di temukan</h4></div>'
        );
      }
    },
    error: function () {
      console.error("Gagal mendapatkan data dari API");
    },
  });
}

$(document).ready(function () {
  console.log("Mengambil data...");
  fetch_data();
});

// Fungsi dialog
function dialog(id) {
  // Implementasi logika dialog sesuai kebutuhan
  console.log("Dialog ID:", id);
}

// Fungsi untuk format angka
function numFormat(number) {
  // Implementasi logika format angka sesuai kebutuhan
  return number;
}
