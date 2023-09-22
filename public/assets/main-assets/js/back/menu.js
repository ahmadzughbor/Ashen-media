var menu_tbl = $("#menu_tbl");
var menu_msf = null;

window.app.defineEvents();

/* Menu DataTable Define */
window.app.definePageDatatable({
    tableElementId: "#menu_tbl",
    options: {
        columns: [
            {
                data: "DT_RowIndex",
                name: "DT_RowIndex",
                class: "text-center align-top mt-4",
            },
            {
                data: "name",
                name: "name",
                class: "text-center align-top mt-4",
            },
            {
                data: "category",
                name: "category",
                class: "text-center align-top mt-4",
            },
            {
                data: "parent",
                name: "parent",
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
