var page_tbl = $("#page_tbl");
var page_msf = null;

window.app.defineEvents();

/* Page DataTable Define */
window.app.definePageDatatable({
    tableElementId: "#page_tbl",
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
                class: "text-center align-top mt-4",
            },
            {
                data: "title",
                name: "title",
                class: "text-center align-top mt-4",
            },
            {
                data: "link",
                name: "link",
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
