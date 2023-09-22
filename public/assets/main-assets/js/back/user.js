var user_tbl = $("#user_tbl");
var user_msf = null;


window.app.defineEvents();


/* User DataTable Define */
window.app.definePageDatatable({
    tableElementId: "#user_tbl",
    options: {
        columns: [{
                data: "DT_RowIndex",
                name: "DT_RowIndex",
                class: "text-center align-top mt-4"
            },
            {
                data: "name",
                name: "name",
                class: "text-center align-top mt-4"
            },
            {
                data: "email",
                name: "email",
                class: "text-center align-top mt-4"
            },
            {
                data: "governorate",
                name: "governorate",
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
                
            }
        }
    }
});





