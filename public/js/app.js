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

function resizeTextarea(textarea) {
  textarea.each(function () {
    jQuery(this).css("height", "auto");
    jQuery(this).css("height", $(this)[0].scrollHeight + "px");
  });
}

jQuery(window).on("load", function () {
  resizeTextarea(jQuery("textarea#sharemsg"));
});

jQuery(document).on("input", "textarea", function () {
  resizeTextarea(jQuery(this));
});

jQuery(document).on("click", ".boettens .boetten", function (e) {
  e.preventDefault();
  var type = jQuery(this).attr("id");
  var url = window.location.hostname;
  var text = jQuery(this).parents().eq(1).find("#sharemsg").val();
  if (type == "whatsapp") {
    window.open(
      `https://api.whatsapp.com/send/?text=${encodeURIComponent(
        text
      )}%0A${encodeURIComponent(url)}`
    );
  } else if (type == "telegram") {
    window.open(
      `https://t.me/share/url?url=${encodeURIComponent(
        url
      )}&text=${encodeURIComponent(text)}`
    );
  } else if (type == "facebook") {
    window.open(
      `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}`
    );
  } else if (type == "twitter") {
    window.open(
      `https://twitter.com/intent/tweet?text=${encodeURIComponent(
        text
      )}%0A${encodeURIComponent(url)}`
    );
  } else if (type == "email") {
    window.open(
      `mailto:?body=${encodeURIComponent(text)}%0A${encodeURIComponent(url)}`
    );
  } else if (type == "threema") {
    window.open(
      `https://threema.id/compose?text=${encodeURIComponent(
        text
      )}%0A${encodeURIComponent(url)}`
    );
  }
});
