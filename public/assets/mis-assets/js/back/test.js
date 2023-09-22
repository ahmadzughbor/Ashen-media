var test_tbl = $("#test_tbl");
var test_msf = null;


/* Test DataTable */

if ($("#test_tbl").length) {
  test_tbl
    .on("preXhr.dt", function (e, settings, data) {
      if (data.search.value !== "") {
        $(".loading-wrapper").show();
      }
    })
    .dataTable({
      ordering: false,
      processing: true,
      serverSide: true,
      ajax: {
        url: data_url,
        dataSrc: function (json) {
          //Make your callback here.
          if (json.status != undefined && !json.status) {
            $("#test_tbl_processing").hide();
            location.reload();
          } else {
            if ($(".loading-wrapper").is(":visible")) {
              $(".loading-wrapper").hide();
            }
            return json.data;
          }
        },
      },
      columns: [
        { data: "DT_RowIndex", name: "DT_RowIndex", class: "text-center" },

        { data: "action", name: "action", class: "text-center" },
      ],

      processing: false,
      bStateSave: !0,
      lengthMenu: [
        [5, 10, 15, 20, -1],
        [5, 10, 15, 20, "All"],
      ],
      pageLength: 10,
      columnDefs: [
        { orderable: !1, targets: [0] },
        { searchable: !1, targets: [0] },
        { className: "dt-right" },
      ],
    });
}


/*  Open Create Test modal */
$(document).on("click", ".create-Test-btn", function (e) {
  e.preventDefault();
  $(".loading-wrapper").css("display", "block");
  deleteModals();
  var action = $(this).attr("href");
  $.ajax({
    url: action,
    type: "GET",
    success: function (data) {
      $("#results-modals").html(data);
      UIkit.modal(".create-test-mdl").toggle();


      $(".loading-wrapper").css("display", "none");
    },
    error: function (xhr) {},
  });
});



/*  Open Edit Test modal */
$(document).on("click", ".edit-test-btn", function (e) {
  e.preventDefault();
  $(".loading-wrapper").css("display", "block");
  deleteModals();
  var action = $(this).attr("href");
  $.ajax({
    url: action,
    type: "GET",
    success: function (data) {
      $("#results-modals").html(data);
      UIkit.modal(".edit-test-mdl").toggle();
      $(".loading-wrapper").css("display", "none");


    },
    error: function (xhr) {
      $(".loading-wrapper").css("display", "none");
    },
  });
});





// create Test
$(document).on('click','.submitTest-btn', function (e) {
  $(this).find('.spinner-loading').css('display', 'block');
  $(this).find('.check-icon').css('display', 'none');
  $(this).find('.submit-text').text('جاري الحفظ...');
  $(this).prop("disabled", true);

  let submit = $(".test-createForm");
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
      $('.submitTest-btn').prop("disabled", false);
      if (data.status) {
        $('.test-createForm').hide();
        $('.create-test-mdl .congratulation-box').css('visibility', 'visible');
        $('.create-test-mdl .congratulation-box .congrats').css('visibility', 'visible');
        $('.create-test-mdl .congratulation-box').show();
        $('.create-test-mdl .congratulation-box').attr('uk-scrollspy', 'cls: uk-animation-slide-bottom; target: .congrats; repeat: true');
         test_tbl.api().ajax.reload();

        submit.each(function () {
          this.reset();
        });

      } else {
        if (data.statusCode == 401) {
          location.reload()
        }
        toastr.error(data.message);
        $('.submitTest-btn').prop("disabled", false);
      }
    },
    error: function (error) {
      $(submit).find('.spinner-loading').css('display', 'none');
      $(submit).find('.check-icon').css('display', 'block');
      $(submit).find('.submit-text').text('حفظ البيانات');
      $('.submitTest-btn').prop("disabled", false);
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



// Edit Test
$(document).on('click','.updateTest-btn', function (e) {
  $(this).find('.spinner-loading').css('display', 'block');
  $(this).find('.check-icon').css('display', 'none');
  $(this).find('.submit-text').text('جاري الحفظ...');
  $(this).prop("disabled", true);

  let submit = $(".test-editForm");
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
      $('.submitTest-btn').prop("disabled", false);
      if (data.status) {
        $('.test-editForm').hide();
        $('.edit-test-mdl .congratulation-box').css('visibility', 'visible');
        $('.edit-test-mdl .congratulation-box .congrats').css('visibility', 'visible');
        $('.edit-test-mdl .congratulation-box').show();
        $('.edit-test-mdl .congratulation-box').attr('uk-scrollspy', 'cls: uk-animation-slide-bottom; target: .congrats; repeat: true');
         test_tbl.api().ajax.reload();

        submit.each(function () {
          this.reset();
        });

      } else {
        if (data.statusCode == 401) {
          location.reload()
        }
        toastr.error(data.message);
        $('.updateTest-btn').prop("disabled", false);
      }
    },
    error: function (error) {
      $(submit).find('.spinner-loading').css('display', 'none');
      $(submit).find('.check-icon').css('display', 'block');
      $(submit).find('.submit-text').text('حفظ البيانات');
      $('.updateTest-btn').prop("disabled", false);
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









/*  Delete Test */
$(document).on("click", ".delete-test-btn", function (event) {
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
            test_tbl.api().ajax.reload();
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
