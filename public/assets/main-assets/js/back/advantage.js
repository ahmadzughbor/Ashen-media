    var advantage_tbl = $("#advantage_tbl");
var advantage_msf = null;

window.app.defineEvents();

/* Advantage DataTable Define */
window.app.definePageDatatable({
    tableElementId: "#advantage_tbl",
    options: {
        columns: [
            {
                data: "DT_RowIndex",
                name: "DT_RowIndex",
                class: "text-center align-top mt-4",
            },
            {
                data: "image",
                name: "image",
                class: "text-right align-top mt-4 bg-stone-100",
            },
            {
                data: "title",
                name: "title",
                class: "text-center align-top mt-4",
            },
            {
                data: "description",
                name: "description",
                class: "text-center align-top mt-4",
            },
            {
                data: "status",
                name: "status",
                class: "text-center align-top mt-4",
            },
            {
                data: "action",
                name: "action",
                class: "text-center align-top mt-4",
            },
        ],
        ajax: {
            data: function (filter) {},
        },
    },
});

function hiddenComponent(id_show, id_hide) {
    $(id_show).show();
    $(id_hide).hide();
}
$(document).on("submit", "#ContentSubmit", function (event) {
    event.preventDefault();
    if(!$('#ContentSubmit').valid())return;
    $(this).find(".spinner-loading").css("display", "block");
    $(this).find(".check-icon").css("display", "none");
    var formData = new FormData($(this)[0]);
    var action = $(this).attr("action");
    var method = $(this).attr("method");
    let submit = $("#ContentSubmit");
    $.ajax({
        url: action,
        type: method,
        data: formData,
        contentType: false,
        processData: false,
        success: function (data) {
            $(submit).find(".spinner-loading").css("display", "none");
            $(submit).find(".check-icon").css("display", "block");
            toastr.success(data.MESSAGE);
        },
        error: function (error) {
            $(submit).find(".spinner-loading").css("display", "none");
            $(submit).find(".check-icon").css("display", "block");
        },
    });
});
