var MinistrysCertification_request_tbl = $("#MinistrysCertification_request_tbl");
var MinistrysCertification_request_msf = null;

window.app.defineEvents();

/* Certification_request DataTable Define */

window.app.definePageDatatable({
    tableElementId: "#MinistrysCertification_request_tbl",
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
                data: "program",
                name: "program",
                class: "text-center align-top mt-4",
            },
            {
                data: "Date_of_convening",
                name: "Date_of_convening",
                class: "text-center align-top mt-4",
            },
            {
                data: "Number_of_hours",
                name: "Number_of_hours",
                class: "text-center align-top mt-4",
            },
            {
                data: "students_count",
                name: "students_count",
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
},"MinistrysDataTable");


