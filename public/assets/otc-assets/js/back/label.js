var label_tbl = $("#label_tbl");
var label_msf = null;


window.app.defineEvents();


/* Label DataTable Define */
window.app.definePageDatatable({
    tableElementId: $("#label_tbl"),
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



// create Label
$(document).on('click','.submitLabel-btn', function (e) {
  $(this).find('.spinner-loading').css('display', 'block');
  $(this).find('.check-icon').css('display', 'none');
  $(this).find('.submit-text').text('جاري الحفظ...');
  $(this).prop("disabled", true);

  let submit = $(".label-createForm");
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
      $('.submitLabel-btn').prop("disabled", false);
      if (data.status) {
        $('.label-createForm').hide();
        $('.create-label-mdl .congratulation-box').css('visibility', 'visible');
        $('.create-label-mdl .congratulation-box .congrats').css('visibility', 'visible');
        $('.create-label-mdl .congratulation-box').show();
        $('.create-label-mdl .congratulation-box').attr('uk-scrollspy', 'cls: uk-animation-slide-bottom; target: .congrats; repeat: true');
         label_tbl.api().ajax.reload();

        submit.each(function () {
          this.reset();
        });

      } else {
        if (data.statusCode == 401) {
          location.reload()
        }
        toastr.error(data.message);
        $('.submitLabel-btn').prop("disabled", false);
      }
    },
    error: function (error) {
      $(submit).find('.spinner-loading').css('display', 'none');
      $(submit).find('.check-icon').css('display', 'block');
      $(submit).find('.submit-text').text('حفظ البيانات');
      $('.submitLabel-btn').prop("disabled", false);
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



// Edit Label
$(document).on('click','.updateLabel-btn', function (e) {
  $(this).find('.spinner-loading').css('display', 'block');
  $(this).find('.check-icon').css('display', 'none');
  $(this).find('.submit-text').text('جاري الحفظ...');
  $(this).prop("disabled", true);

  let submit = $(".label-editForm");
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
      $('.submitLabel-btn').prop("disabled", false);
      if (data.status) {
        $('.label-editForm').hide();
        $('.edit-label-mdl .congratulation-box').css('visibility', 'visible');
        $('.edit-label-mdl .congratulation-box .congrats').css('visibility', 'visible');
        $('.edit-label-mdl .congratulation-box').show();
        $('.edit-label-mdl .congratulation-box').attr('uk-scrollspy', 'cls: uk-animation-slide-bottom; target: .congrats; repeat: true');
         label_tbl.api().ajax.reload();

        submit.each(function () {
          this.reset();
        });

      } else {
        if (data.statusCode == 401) {
          location.reload()
        }
        toastr.error(data.message);
        $('.updateLabel-btn').prop("disabled", false);
      }
    },
    error: function (error) {
      $(submit).find('.spinner-loading').css('display', 'none');
      $(submit).find('.check-icon').css('display', 'block');
      $(submit).find('.submit-text').text('حفظ البيانات');
      $('.updateLabel-btn').prop("disabled", false);
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











function attachChangeEvent() {
  $(document).on("change", ".labelFromSubmit #screen_key", function (e) {
      e.preventDefault();
      var action = labelURL  + '/' + $(".labelFromSubmit #screen_key").val(); 
   
      $.ajax({
          url: action,
          type: "GET",
          beforeSend: function () {
              $(".loading-wrapper").css("display", "block");
              $('.label_list').html('');
              $('.labelFromSubmit [type="submit"]').hide();
          },
          success: function (data) {
              $('.label_list').html(data);
              $('.labelFromSubmit [type="submit"]').show();
          },
          error: function (xhr) {
              $('.label_list').html('');
              $('.labelFromSubmit [type="submit"]').hide();
          },
      }).done(function (response) {
          $(".loading-wrapper").css("display", "none");
      });
  });
}

attachChangeEvent();


        
