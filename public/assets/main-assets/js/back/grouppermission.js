var grouppermission_tbl = $("#grouppermission_tbl");
var grouppermission_msf = null;


window.app.defineEvents();


/* GroupPermission DataTable Define */
window.app.definePageDatatable({
    tableElementId: "#grouppermission_tbl",
    options: {
        columns: [{
                data: "DT_RowIndex",
                name: "DT_RowIndex",
                class: "text-center align-top mt-4"
            },
            {
                data: "name",
                name: "name",
                class: "align-top mt-4"
            },
            {
                data: "info",
                name: "info",
                class: "align-top mt-4"
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





