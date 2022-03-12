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
      console.log(response);
    },
  });
});

function resizeTextarea(textarea) {
  textarea.each(function () {
    jQuery(this).css("height", "auto");
    jQuery(this).css("height", $(this)[0].scrollHeight + "px");
  });
}

jQuery(document).ready(function () {
  resizeTextarea(jQuery("textarea#sharemsg"));
});

jQuery(document).on("input", "textarea", function () {
  resizeTextarea(jQuery(this));
});
