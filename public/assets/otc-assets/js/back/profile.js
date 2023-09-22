

window.app.defineEvents();





$(document).ready(function () {
    $('.selectpicker').selectpicker();
    getQualificationsList(routes.qualifications_list_url);
    getExperiencesList(routes.experiences_list_url);
    getSkillsList(routes.skills_list_url);
    getPreviousCources(routes.previous_courses_list_url);
  
})
 

function getQualificationsList(_qualificationsListUrl) {

    $.ajax({
        url: _qualificationsListUrl  ,
        success: function(response) {
     
            $("#qualifications_div").html(response);
        },
     
    });

}
function getExperiencesList(_experiencesListUrl) {

    $.ajax({
        url: _experiencesListUrl  ,
        success: function(response) {
            $("#experiences_div").html(response);
        },
     
    });

}
function getSkillsList(_skillsListUrl) {

    $.ajax({
        url: _skillsListUrl  ,
        success: function(response) {
            $("#skills_div").html(response);
        },
     
    });

}
function getPreviousCources(_previousCoursesUrl) {
    $.ajax({
        url: _previousCoursesUrl  ,
        success: function(response) {
            $("#previous-courses-div").html(response);
        },
     
    });
}
function refreshQualificationsTbl(object, response) {
    
        $("#qualifications_div").html(response.DATA);
        UIkit.dropdown('.qualifications-dropdown', {

            container: '.parentQualifications',
        });
}
function refreshExperiencesTbl(object, response) {
    
        $("#experiences_div").html(response.DATA);
        UIkit.dropdown('.experiences-dropdown', {
            container: '#experiences_div',
        });

}
function refreshSkillsTbl(object, response) {
    
        $("#skills_div").html(response.DATA);
        UIkit.dropdown('.skills-dropdown');

}
function refreshPreviousCoursesDiv(object, response) {
    
        $("#previous-courses-div").html(response.DATA);


}
$(document).on('submit', '#requiredInformation', function (e) {
    e.preventDefault();
    if (!$('#requiredInformation').valid()) return;



  
});









$(document).on('keydown', '.check-is-number', function (e) {
    if (e.keyCode === 110) {
        var x = $(this).val();
        if (x.indexOf(".") >= 0) {
            e.preventDefault();
        }
    }
    if (e.shiftKey)
        e.preventDefault();
    else {
        var nKeyCode = e.keyCode;
        var ctrlDown = false,
            ctrlKey = 17,
            cmdKey = 91,
            vKey = 86,
            cKey = 67,
            xKey = 88;
        if (nKeyCode == ctrlKey || nKeyCode == vKey || nKeyCode == cKey || nKeyCode == xKey || nKeyCode ==
            13) return true;

        //Ignore Backspace and Tab keys
        if (nKeyCode == 8 || nKeyCode == 9 || nKeyCode == 110 || nKeyCode == 190) return;
        if (nKeyCode < 95) {
            if (nKeyCode < 48 || nKeyCode > 57) e.preventDefault();
        } else {
            if (nKeyCode < 96 || nKeyCode > 105) e.preventDefault();
        }

    }
});

$(document).on('keydown', '.check-is-mobile', function (e) {
    let number = $(this).val();
    $this = $(this);
    if (number.length > 9) {
        let mobile = check_mobile_number(number)
        if (mobile == false) {
            $this.val('')
            let id = $this.attr('id')
            $('#' + id + '_error').show();
        } else {
            let id = $this.attr('id')
            $('#' + id + '_error').hide();
        }
    }
});
$(document).on('change', '.check-is-mobile', function (e) {
    let number = $(this).val();
    $this = $(this);
    let mobile = check_mobile_number(number)
    if (mobile == false) {
        $this.val('')
        let id = $this.attr('id')
        $('#' + id + '_error').show();
    } else {
        let id = $this.attr('id')
        $('#' + id + '_error').hide();
    }
});

function check_mobile_number(number) {
    if (number.length > 9) {
        if (!/^\d{10}$/.test(number)) {
            return false;
        } else {
            var phoneno = /(05)[6|9][0-9]{7}$/
            if (!number.match(phoneno)) {
                //   NotMessage("يجب ادخال رقم جوال صحيح", 'danger');
                return false;
            }
            return true;
        }
        return true;
    } else {
        //NotMessage("يجب ادخال رقم جوال صحيح", 'danger');
        return false;
    }
}


$(document).on('change', '.check-is-id-no', function (e) {
    let number = $(this).val();
    $this = $(this);
    let mobile = CheckID(number)
    if (mobile == false) {
        $this.val('')
        let id = $this.attr('id')
        $('#' + id + '_error').show();
    } else {
        let id = $this.attr('id')
        $('#' + id + '_error').hide();
    }
});

function CheckID(id) {
    if (id == "" || id == null) {
        return false;
    }
    if (!/^\d{9}$/.test(id)) {
        return false;
    }
    var lastDigit = id.substr(8);
    var rest = id.substr(0, 8);
    var sum = 0;
    var i = 1;
    for (var j = 0; j < 8; j++) {
        if (rest[j] != 9) {
            m = (j % 2) + 1;
            sum = sum + ((rest[j] * m) % 9);
        } else {
            sum = sum + 9;
        }
        i++;
    }

    var check = (10 - (sum % 10)) % 10;
    if (check == lastDigit) {
        return true;
    } else {
        return false;
    }

}


$('.update-image').click(function () {
    $('#userImage').trigger('click');
});

$('#userImage').change(function () {
    var file = this.files[0];
    var reader = new FileReader();
    reader.onload = function (e) {
        $('.user-image-preview').attr('src', e.target.result);
    }
    reader.readAsDataURL(file);
});





$(document).ready(function () {
    $('#job_position_id').on('change', function () {
        var id = $(this).val();

        // Send AJAX request
        $.ajax({
            url: routes.getJobPositionOptions,
            type: "POST", // Use POST or GET depending on your needs
            data: {
                id: id
            },
            success: function (response) {
                if (response.status == true) {
                    $('#job_type').text(response.items.job_type);
                    $('#job_category').text(response.items.job_category);
                    $('#job_degree').text(response.items.job_degree);
                    $('#job_details').removeClass('hidden');
                }

            },
            error: function (xhr, status, error) {
            }
        });
    });
});



$('.selectpicker').on('hide.bs.select', function () {
    $(this).valid();
});

  

    






// window.app.definePageDatatable({
//     tableElementId: $("#qualifications_tbl"),
//     options: {
//         serverSide: true,
//         searching: true,
//         columns: [
           
//             {
//                 data: "qualification_type",
//                 name: "qualification_type",
//                 class: "text-right align-top mt-4"
//             },
//             {
//                 data: "academic_study",
//                 name: "academic_study",
//                 class: "text-right align-top mt-4"
//             },
//             {
//                 data: "education_institution",
//                 name: "education_institution",
//                 class: "text-right align-top mt-4"
//             },
//             {
//                 data: "graduation_country",
//                 name: "graduation_country",
//                 class: "text-center align-top mt-4"
//             },
//             {
//                 data: "graduation_date",
//                 name: "graduation_date",
//                 class: "text-center align-top mt-4"
//             },
//             {
//                 data: "academic_average",
//                 name: "academic_average",
                
//                 class: "text-center align-top mt-4"
//             },
//             {
//                 data: "action",
//                 name: "action",
//                 class: "text-center align-top mt-4"
//             },
//         ],
//         ajax: {
//             data: function(filter) {
//                 (filter.function = 'qualificationsDataTable');
//                 (filter.actionName = 'SELECT');
//             }
//         }
//     }
// });
// window.app.definePageDatatable({
//     tableElementId: $("#experiences_tbl"),
//     options: {
//         serverSide: true,
//         searching: true,
//         columns: [
           
//             {
//                 data: "title",
//                 name: "title",
//                 class: "text-right align-top mt-4"
//             },
//             {
//                 data: "title",
//                 name: "title",
//                 class: "text-right align-top mt-4"
//             },
//             {
//                 data: "title",
//                 name: "title",
//                 class: "text-right align-top mt-4"
//             },
//             {
//                 data: "title_en",
//                 name: "title_en",
//                 class: "text-center align-top mt-4"
//             },
//             {
//                 data: "type_name",
//                 name: "type_name",
//                 class: "text-center align-top mt-4"
//             },
//             {
//                 data: "created_at",
//                 name: "created_at",
                
//                 class: "text-center align-top mt-4"
//             },
//             {
//                 data: "action",
//                 name: "action",
//                 class: "text-center align-top mt-4"
//             },
//         ],
//         ajax: {
//             data: function(filter) {
//                 (filter.function = 'dataTable');
//                 (filter.actionName = 'SELECT');
//             }
//         }
//     }
// });
// window.app.definePageDatatable({
//     tableElementId: $("#skills_tbl"),
//     options: {
//         serverSide: true,
//         searching: true,
//         columns: [
           
//             {
//                 data: "title",
//                 name: "title",
//                 class: "text-right align-top mt-4"
//             },
//             {
//                 data: "action",
//                 name: "action",
//                 class: "text-center align-top mt-4"
//             },
//         ],
//         ajax: {
//             data: function(filter) {
//                 (filter.function = 'dataTable');
//                 (filter.actionName = 'SELECT');
//             }
//         }
//     }
// });


