
var this_js_script = $('script[src*=survey]');
var get_all_surveys_link=this_js_script.attr('get_all_surveys');
window.addEventListener('myCustomEvent', function(event) {
    getTrainingsSurveysList();

    // replaceComponent();
    toastr.success(event.detail.message);
    // var html_survey_form_block=$('#survey_html_form');
    // html_survey_form_block.toggle();
});
function getTrainingsSurveysList(){

    $.ajax({
        type: 'get',
        url: get_all_surveys_link,
        // contentType: 'application/json; charset=utf-8',
        dataType: 'html', //**** REMOVE THIS LINE ****//
        cache: false,
        success: (response)=>{
            $('#surveys_list').html(response);

        },
        // error: AjaxFailed
    });
}
$(document).on("click", ".delete-survey", function (event) {
    event.preventDefault();
    var _this = $(this);
    var action = _this.attr("url");

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
                type: "delete",
                url:  action,
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
                contentType: "application/json",
                success: function (data) {
                    $(".loading-wrapper").css("display", "block");
                    if (data.status) {
                        getTrainingsSurveysList();
                        $(".loading-wrapper").css("display", "none");
                        messageNotify(data.message, "success");
                    } else {
                        $(".loading-wrapper").css("display", "none");
                        messageNotify(data.message, "danger");
                    }
                },
                error: function (data) {
                    messageNotify(data.message, "danger");
                },
            });
        }
    });
});
$(document).on("click", ".accept-reject-survey", function (event) {
    event.preventDefault();
    var _this = $(this);
    var action = _this.attr("url");
    var question=_this.attr("question");
    var action_btn=_this.attr("action-btn");
    Swal.fire({
        text: question,
        confirmButtonClass: "btn btn-success btn-sm",
        cancelButtonClass: "btn btn-danger  btn-sm",
        confirmButtonText: action_btn,
        cancelButtonText: " إلغاء الامر",
        buttonsStyling: false,
        showCancelButton: true,
    }).then(function (result) {
        if (result.value) {
            $.ajax({
                type: "Put",
                url:  action,
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
                contentType: "application/json",
                success: function (data) {
                    $(".loading-wrapper").css("display", "block");
                    if (data.status) {
                        getTrainingsSurveysList();
                        $(".loading-wrapper").css("display", "none");
                        messageNotify(data.message, "success");
                    } else {
                        $(".loading-wrapper").css("display", "none");
                        messageNotify(data.message, "danger");
                    }
                },
                error: function (data) {
                    messageNotify(data.message, "danger");
                },
            });
        }
    });
});
