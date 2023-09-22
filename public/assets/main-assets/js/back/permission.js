var permission_tbl = $("#permission_tbl");
var permission_msf = null;


window.app.defineEvents();


/* Permission DataTable Define */
window.app.definePageDatatable({
    tableElementId: "#permission_tbl",
    options: {
        columns: [
            {
                data: "DT_RowIndex",
                name: "DT_RowIndex",
                class: "text-center align-top mt-4"
            },
            {
                data: "title",
                name: "title",
                class: "text-center align-top mt-4"
            },
            {
                data: "name",
                name: "name",
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



