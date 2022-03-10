jQuery(document).on("select2:open", () => {
  document.querySelector(".select2-search__field").focus();
});

jQuery(document).on("click", "#cpv-order-sheet-button", function (e) {
  e.preventDefault();
  let guid = jQuery(this).attr("data-sheet-guid");
  jQuery.ajax({
    url: "/wp-content/plugins/conge-parental-vd/utils/order-sheet.php",
    method: "POST",
    data: {
      guid: guid,
    },
    success: (response) => {
      jQuery("#cpv-order-sheet-container").append(
        "<div id='cpv-oder-sheet-success'>Parfait, vous recevrez la feuille par la poste !</div>"
      );
      jQuery("#cpv-order-sheet-button").remove();
    },
  });
});
