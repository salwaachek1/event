$(document).ready(function () {
  modal();
  document.getElementById("date").value = Date();
  window.setTimeout(function () {
    $(".alert")
      .fadeTo(8000, 0)
      .slideUp(1000, function () {
        $(this).remove();
      });
  }, 2000);
});

function modal() {
  $("#modal").fadeIn("slow");
  $("#msg").fadeIn("slow");
}
/* AJAX Request to send json file  */
function sendData() {
  var file_data = $("#importfile").prop("files")[0];
  var form_data = new FormData();
  form_data.append("file", file_data);
  $.ajax({
    type: "POST",
    url: document.location.href + "/convert.php",
    cache: false,
    contentType: false,
    processData: false,
    data: form_data,
    success: function (response) {
      $("#modal").fadeOut("slow");
      document.getElementById("filters").style.visibility = "visible";
      $("#msg").text("Data has been added to Database ! ");
      document.getElementById("msg").style.visibility = "visible";
    },
  });

  return false;
}
