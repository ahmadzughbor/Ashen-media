var certification_request_tbl = $("#certification_request_tbl");
var certification_request_msf = null;

window.app.defineEvents();

/* Certification_request DataTable Define */
window.app.definePageDatatable({
    tableElementId: "#certification_request_tbl",
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
});

function fillStudentTab() {
   arrayItem = "{{ $INcentreGraduatesRequests}}"
    var allStudent = [];
    var InStudent = $("#Student_id option:selected");
    var outStudent = $(".student-div .outer-student");

    var studentData = null;

    InStudent.each(function (index, item) {
        console.log(item);
        if (item.hasAttribute("value")) {
            studentData = null;
            var id = item.value;
            var name = item.text;
            studentData = {
                id: id,
                name: name,
            };
            if (studentData) {
                allStudent.push(studentData);
            }
        }
    });

    outStudent.each(function (index, item) {
        studentData = null;
        var student_identity = $(item).find("input.student_identityIn").val();
        var name = $(item).find("input.studantNameIn").val();

        // 
        if (student_identity != "" && name != "") {
            studentData = {
                student_identity: student_identity,
                name: name,
            };
            if (studentData) {
                allStudent.push(studentData);
            }
        }
        // 

        if (allStudent.length > 0) {
            drowStudentFiles(allStudent);
        }
    });
}

function drowStudentFiles(arrayItems) {
    // 

    var html = null;

    $.each(arrayItems, function (index, item) {
        html += `
                    <div class="grid sm:grid-cols-3 align-items-baseline sm:gap-6 gap-2 md:mt-4">
                        <label for="" class="font-medium text-black col-span-1">${
                            item.name
                        }<span class="text-red-600">*</span></label>
                        <input type="hidden" name="studentfiles[${
                            item.id ?? item.student_identity
                        }][name]" value="${item.name}" class="id_no"> `;
        if (item.id != null) {
            html += `<input type="hidden" name="studentfiles[${item.id}][type]" value="1" class="id_no"> `;
            html += `<input type="hidden" name="studentfiles[${item.id}][user_id]" value="${item.id}" class="id_no"> `;
        }
        if (item.student_identity != null) {
            html += `<input type="hidden"  name="studentfiles[${item.student_identity}][type]" value="2" class="student_identity"> `;
            html += `<input type="hidden"  name="studentfiles[${item.student_identity}][id_no]" value="${item.student_identity}" class="student_identity"> `;
        }

        html += `<div class="col-span-2">
                            <input type="file" multiple name="studentfiles[${
                                item.id ?? item.student_identity
                            }][files][]" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400">
                        </div>
                    </div>
                    `;
    });

    if (html) {
        $("#getAllStudent").html(html);
    }
}
