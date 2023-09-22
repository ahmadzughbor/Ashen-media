var lessonassignment_tbl = $("#lessonassignment_tbl");
var lessonassignment_msf = null;

window.app.defineEvents();

/* LessonAssignment DataTable Define */
window.app.definePageDatatable({
    tableElementId: "#lessonassignment_tbl",
    options: {
        columns: [
            {
                data: "DT_RowIndex",
                name: "DT_RowIndex",
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

