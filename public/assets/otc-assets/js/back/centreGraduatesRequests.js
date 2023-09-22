var centreGraduatesRequests_tbl = $("#centreGraduatesRequests_tbl");
var centreGraduatesRequests_tbl_msf = null;

window.app.defineEvents();
/* Certification_request DataTable Define */

window.app.definePageDatatable({
    tableElementId: "#centreGraduatesRequests_tbl",
    options: {
        columns: [
            {
                data: "DT_RowIndex",
                name: "DT_RowIndex",
                class: "text-center align-top mt-4",
            },
            {
                data: "course",
                name: "course",
                class: "text-center align-top mt-4",
            },
            {
                data: "name",
                name: "name",
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
            data: function (filter) {
                (filter.hash_id = null);
                
            },
        },
    },
},"centreGraduatesRequestsTable/"+ hash_id);


