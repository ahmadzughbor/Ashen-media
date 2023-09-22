var sponsor_tbl = $("#sponsor_tbl");
var sponsor_msf = null;


window.app.defineEvents();


/* Sponsor DataTable Define */
window.app.definePageDatatable({
    tableElementId: "#sponsor_tbl",
    options: {
        columns: [{
                data: "DT_RowIndex",
                name: "DT_RowIndex",
                class: "text-center align-top mt-4"
            },
            {
                data: "name_ar",
                name: "name_ar",
                class: "text-right align-top mt-4"
            },
            {
                data: "created_at",
                name: "created_at",
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





