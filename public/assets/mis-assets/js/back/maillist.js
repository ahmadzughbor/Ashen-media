var maillist_tbl = $("#maillist_tbl");
var maillist_msf = null;


window.app.defineEvents();


/* MailList DataTable Define */
window.app.definePageDatatable({
    tableElementId: "#maillist_tbl",
    options: {
        columns: [{
                data: "DT_RowIndex",
                name: "DT_RowIndex",
                class: "text-center align-top mt-4"
            },
            {data: "email", name: "email",  class: "text-right align-top mt-4"},
            {data: "created_at", name: "created_at",  class: "text-center align-top mt-4"},
            {
                data: "action",
                name: "action",
                class: "text-center align-top mt-4"
            },
        ],
        ajax: {
            data: function(filter) {
                
            }
        }
    }
});





