var training_tbl = $("#training_tbl");
var training_msf = null;


window.app.defineEvents();


/* Training DataTable Define */
window.app.definePageDatatable({
    tableElementId: $("#training_tbl"),
    options: {
        columns: [{
                data: "DT_RowIndex",
                name: "DT_RowIndex",
                class: "text-center align-top mt-4"
            },
            {
                data: "action",
                name: "action",
                class: "text-center align-top mt-4"
            },
        ],
        ajax: {
            data: function(filter) {
                (filter.function = 'dataTable');
                (filter.actionName = 'SELECT');
            }
        }
    }
});



// create Training
$(document).on('click','.submitTraining-btn', function (e) {
  $(this).find('.spinner-loading').css('display', 'block');
  $(this).find('.check-icon').css('display', 'none');
  $(this).find('.submit-text').text('جاري الحفظ...');
  $(this).prop("disabled", true);

  let submit = $(".training-createForm");
  e.preventDefault(); // Totally stop stuff happening
  // Create a formdata object and add the files
  var formData = new FormData(submit[0]);
  var method = submit.attr('method');
  var url = submit.attr('action');

  $.ajax({
    url: url,
    type: method,
    data: formData,
    contentType: false,
    processData: false,
    success: function (data) {
      $(".modelTitle").hide();
      $(submit).find('.spinner-loading').css('display', 'none');
      $(submit).find('.check-icon').css('display', 'block');
      $(submit).find('.submit-text').text('حفظ البيانات');
      $('.submitTraining-btn').prop("disabled", false);
      if (data.status) {
        $('.training-createForm').hide();
        $('.create-training-mdl .congratulation-box').css('visibility', 'visible');
        $('.create-training-mdl .congratulation-box .congrats').css('visibility', 'visible');
        $('.create-training-mdl .congratulation-box').show();
        $('.create-training-mdl .congratulation-box').attr('uk-scrollspy', 'cls: uk-animation-slide-bottom; target: .congrats; repeat: true');
         training_tbl.api().ajax.reload();

        submit.each(function () {
          this.reset();
        });

      } else {
        if (data.statusCode == 401) {
          location.reload()
        }
        toastr.error(data.message);
        $('.submitTraining-btn').prop("disabled", false);
      }
    },
    error: function (error) {
      $(submit).find('.spinner-loading').css('display', 'none');
      $(submit).find('.check-icon').css('display', 'block');
      $(submit).find('.submit-text').text('حفظ البيانات');
      $('.submitTraining-btn').prop("disabled", false);
      $.each(error.responseJSON.errors, function (i, v) {
        var errors = '<ul>';
        $.each(v, function (i, v) {
          errors += '<li>' + v + '</li>';
        });
        errors += '</ul>';
        toastr.error(errors);
      });

    }
  });
});



// Edit Training
$(document).on('click','.updateTraining-btn', function (e) {
  $(this).find('.spinner-loading').css('display', 'block');
  $(this).find('.check-icon').css('display', 'none');
  $(this).find('.submit-text').text('جاري الحفظ...');
  $(this).prop("disabled", true);

  let submit = $(".training-editForm");
  e.preventDefault(); // Totally stop stuff happening
  // Create a formdata object and add the files
  var formData = new FormData(submit[0]);
  var method = submit.attr('method');
  var url = submit.attr('action');

  $.ajax({
    url: url,
    type: method,
    data: formData,
    contentType: false,
    processData: false,
    success: function (data) {
      $(".modelTitle").hide();
      $(submit).find('.spinner-loading').css('display', 'none');
      $(submit).find('.check-icon').css('display', 'block');
      $(submit).find('.submit-text').text('حفظ البيانات');
      $('.submitTraining-btn').prop("disabled", false);
      if (data.status) {
        $('.training-editForm').hide();
        $('.edit-training-mdl .congratulation-box').css('visibility', 'visible');
        $('.edit-training-mdl .congratulation-box .congrats').css('visibility', 'visible');
        $('.edit-training-mdl .congratulation-box').show();
        $('.edit-training-mdl .congratulation-box').attr('uk-scrollspy', 'cls: uk-animation-slide-bottom; target: .congrats; repeat: true');
         training_tbl.api().ajax.reload();

        submit.each(function () {
          this.reset();
        });

      } else {
        if (data.statusCode == 401) {
          location.reload()
        }
        toastr.error(data.message);
        $('.updateTraining-btn').prop("disabled", false);
      }
    },
    error: function (error) {
      $(submit).find('.spinner-loading').css('display', 'none');
      $(submit).find('.check-icon').css('display', 'block');
      $(submit).find('.submit-text').text('حفظ البيانات');
      $('.updateTraining-btn').prop("disabled", false);
      $.each(error.responseJSON.errors, function (i, v) {
        var errors = '<ul>';
        $.each(v, function (i, v) {
          errors += '<li>' + v + '</li>';
        });
        errors += '</ul>';
        toastr.error(errors);
      });

    }
  });
});









/*  Delete Training */
$(document).on("click", ".delete-training-btn", function (event) {
event.preventDefault();
  var _this = $(this);
  var action = _this.attr("href");

  /*  Confirm Delete */
  Swal.fire({
    text: "هل انت متاكد من عملية الحذف ؟",
    confirmButtonClass: "btn btn-success btn-sm",
    cancelButtonClass: "btn btn-danger  btn-sm",
    confirmButtonText: "حذف",
    cancelButtonText: " إلغاء",
    buttonsStyling: false,
    showCancelButton: true,
  }).then(function (result) {
    if (result.value) {
      $.ajax({
        type: "DELETE",
        url: action,
        contentType: "application/json",
        success: function (data) {
          if (data.status) {
            training_tbl.api().ajax.reload();
            toastr.success(data.message);
          } else toastr.error(data.message);
        },
        error: function (data) {
          toastr.error(data.message);
        },
      });
    }
  });
});
