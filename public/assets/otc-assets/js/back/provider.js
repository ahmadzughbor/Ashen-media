var provider_tbl = $("#provider_tbl");
var provider_msf = null;


window.app.defineEvents();


/* Provider DataTable Define */
window.app.definePageDatatable({
    tableElementId: "#provider_tbl",
    options: {
        columns: [{
                data: "DT_RowIndex",
                name: "DT_RowIndex",
                class: "text-center align-top mt-4"
            },
            {
                data: "name",
                name: "name",
                class: " align-top mt-4"
            },
            {
                data: "created_at",
                name: "created_at",
                class: " align-top mt-4"
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



/*  Open Create Provide modal */
$(document).on("click", ".create-Provide-btn", function (e) {
    e.preventDefault();
    $('#create-provider-mdl').remove();
    $('#edit-provider-mdl').remove();
    $(".loading-wrapper").css("display", "block");
    var action = $(this).attr("href");
    $.ajax({
      url: action,
      type: "GET",
      success: function (data) {
        $("#results-modals").html(data);
        // UIkit.modal('#create-provider-mdl').hide();
        $(".loading-wrapper").css("display", "none");
      },
      error: function (xhr) {
        $(".loading-wrapper").css("display", "none");

      },
    });
  });
  

  

// create Provide
$(document).on('click','.submitProvide-btn', function (e) {
    if(!$('.provide-createForm').valid())return ;
    $(this).find('.spinner-loading').css('display', 'block');
    $(this).find('.check-icon').css('display', 'none');
    $(this).find('.submit-text').text('جاري الحفظ...');
    $(this).prop("disabled", true);
  
    let submit = $(".provide-createForm");
    e.preventDefault(); 
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
        // $(".modelTitle").hide();
        $(submit).find('.spinner-loading').css('display', 'none');
        $(submit).find('.check-icon').css('display', 'block');
        $(submit).find('.submit-text').text('حفظ');
        $('.submitProvide-btn').prop("disabled", false);
        UIkit.modal('#create-provider-mdl').hide();
        toastr.success("تم الاضافة بنجاح");
        provider_tbl.dataTable().api().draw()
        if (data.status) {
          submit.each(function () {
            this.reset();
          });
  
        } else {
          if (data.statusCode == 401) {
            location.reload()
          }
          $('.submitProvide-btn').prop("disabled", false);
        }
      },
      error: function (error) {
        $(submit).find('.spinner-loading').css('display', 'none');
        $(submit).find('.check-icon').css('display', 'block');
        $(submit).find('.submit-text').text('حفظ ');
        $('.submitProvide-btn').prop("disabled", false);
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




  /*  Open Edit Provide modal */
$(document).on("click", ".edit-provide-btn", function (e) {
  e.preventDefault();
  $('#create-provider-mdl').remove();
  $('#edit-provider-mdl').remove();
  $(".loading-wrapper").css("display", "block");
  var action = $(this).attr("href");
  var idhash=$(this).attr('data-hashId');
  $.ajax({
    url: action,
    type: "GET",
    success: function (data) {
      $("#results-modals").html(data.DATA);
      UIkit.modal("#edit-provider-mdl").show();
      $(".loading-wrapper").css("display", "none");
    },
    error: function (xhr) {
      $(".loading-wrapper").css("display", "none");
    },
  });
});


// Edit Provide
$(document).on('click','.updateProvide-btn', function (e) {
  e.preventDefault();
  $(this).find('.spinner-loading').css('display', 'block');
  $(this).find('.check-icon').css('display', 'none');
  $(this).find('.submit-text').text('جاري الحفظ...');
  $(this).prop("disabled", true);
// debugger;
  let submit = $(".provide-editForm");
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
     
      $(submit).find('.spinner-loading').css('display', 'none');
      $(submit).find('.check-icon').css('display', 'block');
      $(submit).find('.submit-text').text('تعديل');
      $('.submitProvide-btn').prop("disabled", false);
      
      UIkit.modal('#edit-provider-mdl').hide();
      toastr.success("تم التعديل بنجاح");
      provider_tbl.dataTable().api().draw()

      if (data.STATUS) {
        submit.each(function () {
          this.reset();
        });

      } else {
        if (data.statusCode == 401) {
          location.reload()
        }
        toastr.error('حدث خطا ما');
        console.log(data);
        $('.updateProvide-btn').prop("disabled", false);
      }
    },
    error: function (error) {
      $(submit).find('.spinner-loading').css('display', 'none');
      $(submit).find('.check-icon').css('display', 'block');
      $(submit).find('.submit-text').text('تعديل');
      $('.updateProvide-btn').prop("disabled", false);
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
