var interactivepost_tbl = $("#interactivepost_tbl");
var interactivepost_msf = null;


window.app.defineEvents();


/* InteractivePost DataTable Define */
window.app.definePageDatatable({
    tableElementId: "#interactivepost_tbl",
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
                
            }
        }
    }
});





