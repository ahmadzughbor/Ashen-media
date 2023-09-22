window.app.defineEvents();
var page=1;
var this_js_script = $('script[src*=course-show]');
// var course_id=this_js_script.attr('course_id');
loadTrainers(page,course_id);
loadstudents(page,course_id);


var newUnitDiv = `<div class="flex items-center mb-2 relative overflow-hidden uk-transition-toggle cursor-pointer">
<input type="text" name="unit[]" class="keyword-input with-border" placeholder="" />
<div style="display: flex;"
  class="inline-flex items-center rounded-md space-x-2 sm:absolute top-1 left-2 uk-transition-slide-right-small overflow-hidden">
  <a href="javascript:;" class="trash-unit-input"  data-event_on="click"
  data-event_handler="removeUnit">
      <ion-icon name="trash-outline"
          class="text-xl rounded-md p-1.5 bg-red-100 text-red-500 md hydrated"></ion-icon>
  </a>
  <a href="javascript:;" class="add-unit-input" data-event_on="click"
  data-event_handler="addUnit">
      <ion-icon name="add-outline"
          class="text-xl rounded-md p-1.5 bg-green-100 text-green-500 md hydrated "></ion-icon>
  </a>
</div>
</div>`;

function addUnit(element, event) {
    var parent = $("#unit-div");
    element = $(element);
    var inputField = element.parent().siblings(".keyword-input");
    var inputValue = inputField.val().trim();
    var lengthInputs = inputField.length;

    if (inputValue == "") {
        return;
    }

    if (lengthInputs == 1) {
        element.closest(".flex.items-center").find(".trash-unit-input").hide();
    } else {
        element.closest(".flex.items-center").find(".trash-unit-input").show();
    }

    $(".unit-div").append(newUnitDiv);

    $(".unit-div .add-unit-input").hide();
    $(".unit-div .add-unit-input:last").show();

    if ($(".unit-div").find("input").length > 1) {
        $(".unit-div .trash-unit-input").show();
    } else {
        $(".unit-div .add-unit-input:last").show();
    }
}

function removeUnit(element, event) {
    element = $(element);
    var divToRemove = element.parent().parent();
    var inputValue = divToRemove.find(".keyword-input").val().trim();
    var unitDiv = $(".unit-div");
    var addUnitInput = unitDiv.find(".add-unit-input");
    var trashUnitInput = unitDiv.find(".trash-unit-input");

    addUnitInput.hide();

    // Show the add button only in the last div
    addUnitInput.last().show();

    if (unitDiv.find("input").length === 1) {
        divToRemove.find(".trash-unit-input").hide();
        addUnitInput.last().show();
        return;
    } else {
        divToRemove.find(".trash-unit-input").show();
        trashUnitInput.show();
    }

    divToRemove.remove();

    var removedIndex = addUnitInput.index(divToRemove);
    addUnitInput.splice(removedIndex, 1);
    addUnitInput.last().show();

    if (unitDiv.find("input").length > 1) {
        divToRemove.find(".trash-unit-input").hide();
        addUnitInput.not(".add-unit-input:last").hide();
    } else {
        addUnitInput.not(".add-unit-input:last").show();
    }
}

function refContentComp() {
    Livewire.find($("#course_curriculum").attr("wire:id")).call(
        "refreshTrainingContent"
    );
}

function appendUnit(object, resp) {
    selectedUnit = object._event_object
        .closest("[data-unit-id]")
        .data("unit-id");
    $(object.target_modal).find('[name="unit_hash_id"]').val(selectedUnit);
}

function meetingTypeChangeOuter(element, event) {
    var selectedOption = $(element).val();

    if (selectedOption == 1) {
        $("#interactiveTypeDiv").removeClass("hidden");
        $('#meetingLocation').addClass('hidden');
    } else if (selectedOption == 2) {
        $("#interactiveTypeDiv").addClass("hidden");
        $("#external_link_div").addClass("hidden");
        $('#meetingLocation').removeClass('hidden');
    }
}

function interactiveTypeChangeOuter(element, event) {
    var selectedOption = $(element).val();
    if (selectedOption == 1) {
        $("#external_link_div").addClass("hidden");
    } else if (selectedOption == 2) {
        $("#external_link_div").removeClass("hidden");
    }
}

const container = document.querySelector("#list_assigments");
const simplebar = new SimpleBar(container);
function updateSimpleBar() {
    simplebar.recalculate();
}
updateSimpleBar();
var assignments_page = 2;
function loaaAssignments() {
    $("#more-assignments").css("display", "block");
    loadAssignments(assignments_page);
    assignments_page++;
}
function loadAssignments(assignments_page) {
    $.ajax({
        url: url_load + "&page=" + assignments_page,
        beforeSend: function () {},
        success: function (response) {
            if (response == 0) {
                $("#assignments_more").hide();
            } else {
                $("#list").append(response);
            }
        },
    }).done(function (data) {
        $("#more-assignments").css("display", "none");
    });
}
$(document).ready(function () {
    loadAssignments(1);
});
function load_assignments() {
    // debugger;
    $("#list").empty();
    loadAssignments(1);
}

$(document).on("click", ".showStudentSubmit", function (e) {
    $(".loading-wrapper").css("display", "block");
    let page = 1;
    var id = $(this).attr("data-id");
    var url = $(this).attr("data-url");
    loadStudentSubmits(url, page);
});

function loadStudentSubmits(url, page) {
    $.ajax({
        url: url + "/?page=" + page,
        beforeSend: function () {},
        success: function (response) {
            $("#showStudentSubmit").html(response);
            $(".loading-wrapper").css("display", "none");
        },
        complete: function () {},
    });
}

function ChangeSeemoreText(elementjq, event)
{
    setTimeout(function() {
        // debugger;
        if(elementjq.prev().hasClass('line-clamp-2')){
            $('#seeless').fadeOut(50,function(){
                $('#seemore').fadeIn(50);
            });

        }else{
            $('#seemore').fadeOut(50,function (){
                $('#seeless').fadeIn(50);
            });
        }
      }, 200);
}


function assignmentSubmit(element, event) {
    // debugger;
}

function loadTrainersAfterSuccess(element, event) {
    loadTrainers(1,course_id);
    


}
function loadstudentAfterSuccess(element, event) {

    loadstudents(1,course_id);

}

function loadTrainers(page =1, course_id = course_id) {
    var url=url_course;
    $.ajax({
      url: url +'/'+'getTrainers' +'/'+ course_id +"/?page=" + page,
      success: function (response) {
          $("#showTrainers").html(response.DATA);
      }
    });
  }
function loadstudents(page,course_id) {
    var url=url_course;
    $.ajax({
      url: url +'/'+'getstudents' +'/'+ course_id +"/?page=" + page,
      success: function (response) {
          $("#showstudents").html(response.DATA);
      }
    });
  }


  $(document).on("click", "#div-paginator a", function (e) {
    e.preventDefault();
    var page = $(this).attr("data-page-id");
    loadTrainers(page,course_id);
  });
