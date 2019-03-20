var projectIdForLog = 0;
var pipeLineIdForLog = 0;
var levelIdForLog = 0;
var editPageDataArr = new Array();
var editLogStatement = "";

function inProcess() {
    alert("work in progress");
    return false;
}

function createProject() {

    if (checkIfEmpty('projectName')) {
        return false;
    }
    var form = $('#addProjectForm')[0]; // You need to use standart javascript object here
    var formData = new FormData(form);
    var url = SITEROOT + "/project/createProject/";

    $.ajax({
        type: "post",
        data: formData,
        url: url,
        processData: false,
        contentType: false,
        beforeSend: function() {
            $("body").faLoading('fa-cog');
        },
        success: function(data) {
//            alert(data);
            if (data == 'success') {
                // following code kept for the purpose that if div is not properly loaded then apply rempve the commented part
                $("<div id='spanId' class'setDelay'>Project created successfully</div>").dialog();

                setTimeout(function() {
                    $(".ui-dialog").hide();
//                   window.location.href = SITEROOT + "/dashboard/dashboard/" + encodedTypeId + "/edit";
                }, 2000);
                dashboardReload('');
                $("body").faLoading(false);
                //              alert("Project created successfully");
//                $("#addProjectModal").modal('hide');

            } else if (data == 'error') {
                alert("please check the data");
                $("body").faLoading(false);
            } else if (data == 'no data') {
                alert("No data inserted");
                $("body").faLoading(false);
            } else if (data == 'error upload') {
                alert("Error in uplaoding attachment");
            }
        },
        error: function(data) {
            alert("Could not submit data");
        }
    });

}

function getPipeInfo(){
	var pipelineId = $("#pipelineId").val();
    $.ajax({
        type: "POST",
        url: SITEROOT + "/modules/report/getPipelineInfo.php",
        data: {
        	pipelineId: pipelineId
        },
        success: function(data) {
        		if(pipelineId === ""){
        			 $("#default").show();
        		}
                jQuery('#pipelineInfo').html(data);
                $("#default").hide();

        }
    });
}

function enableTextArea() {
    $("#notes_text_area").prop("disabled", false);
    $("#edit_notes_btn").css('display', 'none');
    $("#save_notes_btn").css('display', 'block');
}

function saveTextArea(projectId, levelId, pipeId) {
    $("#notes_text_area").prop("disabled", true);
    $("#edit_notes_btn").css('display', 'block');
    $("#save_notes_btn").css('display', 'none');
    var notes = $("#notes_text_area").val();
    var project_id = projectId;
    editLogStatement = "";
    editLogStatement = "Notes Updated."
    insertEditLogActivity(projectId, levelId, function(err, resp) {
        if (err) {
            return false;
        }
        if (project_id != '' || project_id != undefined) {
            $.ajax({
                data: {project_id: project_id, notes: notes},
                url: SITEROOT + '/project/insertNotesData/',
                type: "POST",
                success: function(data) {
                    if (data === "error") {
                        alert("error while updating notes.");
                    } else {
                        viewProjectInfo(projectId, pipeId, levelId);
                    }
                }
            });
        }

    });
}

function storeEditPageData() {
    editPageDataArr['edit_project_name'] = $("#edit_project_name").val();
    editPageDataArr['edit_person_responsible'] = $("#edit_person_responsible").val();
    editPageDataArr['edit_cto_spoc'] = $("#edit_cto_spoc").val();
    editPageDataArr['edit_area'] = $("#edit_area").val();
    editPageDataArr['edit_tam'] = $("#edit_tam").val();
    editPageDataArr['edit_tam_currency'] = $("#edit_tam_currency :selected").text();
    editPageDataArr['edit_sam'] = $("#edit_sam").val();
    editPageDataArr['edit_sam_currency'] = $("#edit_sam_currency").val();
    editPageDataArr['edit_level_id'] = $("#edit_level_id :selected").text();
    editPageDataArr['edit_date_created'] = $("#edit_date_created").val();
    editPageDataArr['edit_visible_to'] = $("#edit_visible_to").val();
    editPageDataArr['ideaAttachment'] = $("#ideaAttachment").val();
    console.log(editPageDataArr['edit_tam_currency']);
}

function getEditPageData(id) {
    return editPageDataArr[id];
}

function openEditProjectPanel(projectId, pipeLineId) {         //createModal(project_id)
    editLogStatement = "";
    $('#editBlock').modal('hide');
    var project_id = projectId;
    var action = "edit";
    if (project_id != '' || project_id != undefined) {
        $.ajax({
            data: {project_id: project_id, pipeLineId: pipeLineId, action: action},
            url: SITEROOT + '/project/getProjectDetails/',
            type: "POST",
            beforeSend: function() {
                $("body").faLoading('fa-cog');
            },
            success: function(data) {
//                console.log(data);
                if (data != '') {
                    $("body").faLoading(false);
                    jQuery.facebox(data);
                    storeEditPageData();
                } else {
                    jQuery.facebox("No data found for this project");
                }
            }
        });
    }
}

function logStatementOnChange(id) {

    var editPageNewData_sam_curr = "";
    var editPageOldData_sam_curr = "";
    var editPageNewData_tam_curr = "";
    var editPageOldData_tam_curr = "";
    var editPageOldData = getEditPageData(id);
    var editPageNewdata = $('#' + id).val();
    var fieldName = $('#' + id).attr('name');

    var tempLogStatement = "";

    if (fieldName === "SAM" || fieldName === "TAM") {

        if (editPageOldData !== editPageNewdata) {
            editPageOldData_sam_curr = getEditPageData("edit_sam_currency");
            editPageNewData_sam_curr = $('#edit_sam_currency').val();
            editPageOldData_tam_curr = getEditPageData("edit_tam_currency");
            editPageNewData_tam_curr = $('#edit_tam_currency :selected').text();

            if (fieldName === "SAM") {
                if (editPageOldData === '') {
                    tempLogStatement = fieldName + " value " + editPageNewdata + editPageNewData_sam_curr + " is added.";
                } else {
                    tempLogStatement = fieldName + " value changed from " + editPageOldData + editPageOldData_sam_curr + " to " + editPageNewdata + editPageNewData_sam_curr;
                }
            } else {
                if (editPageOldData === '') {
                    tempLogStatement = fieldName + " value " + editPageNewdata + editPageNewData_tam_curr + " is added.";
                } else {
                    tempLogStatement = fieldName + " value changed from " + editPageOldData + editPageOldData_tam_curr + " to " + editPageNewdata + editPageNewData_tam_curr;
                }
            }
        }
    } else if (fieldName === "Current Level") {
        editPageNewdata = $("#" + id + " :selected").text();
        if (editPageOldData === '') {
            tempLogStatement = fieldName + " " + editPageNewdata + " is added .";
        } else {
            tempLogStatement = fieldName + " is changed from " + editPageOldData + " to " + editPageNewdata;
        }
    } else if (fieldName === "ideaAttachment") {

        tempLogStatement = "File attached.";

    } else {
        if (editPageOldData === '') {
            tempLogStatement = fieldName + " " + editPageNewdata + " is added .";
        } else {
            tempLogStatement = fieldName + " is changed from " + editPageOldData + " to " + editPageNewdata;
        }
    }
    if (editLogStatement === "") {
        editLogStatement = tempLogStatement;
    } else {
        editLogStatement = editLogStatement + '\n' + tempLogStatement;
    }

}

function insertEditLogActivity(projectID, levelID, cb) {

    if (editLogStatement !== "") {
        var project_id = projectID;
        var level_id = levelID;
        $.ajax({
            type: 'POST',
            url: SITEROOT + '/project/insertLogActivityEdit',
            data: {project_id: project_id, level_id: level_id, editLogStatement: editLogStatement},
            success: function(data) {
                if (data === "success") {
                    editLogStatement = "";
                    cb(false, true);//Parameters (error,response)

                } else {
                    alert("Error In Inserting Log Data.");
                    cb(true, false);//Parameters (error,response)
                }
            }
        });
    }

}

function openLogActivityPrompt(projectId, pipeLineId, levelId) {
    $('#facebox .popup').width('300px');
    jQuery.facebox(' <div class="">\n\
                        <table class="table">\n\
                                <tbody>\n\
                                    <tr><div class="panel-heading">Log Activity:</tr>\n\
                            <tr><textarea class="northspace2" rows="3" id="logActivityTextArea"></textarea></tr>\n\
                            <tr><input type="button" class="btn btn-primary northspace3 fr" onclick="saveLogActivity();" value="Submit"></tr></tbody></table>\n\
                            </div></div>');
    projectIdForLog = projectId;
    pipeLineIdForLog = pipeLineId;
    levelIdForLog = levelId;
}

function saveLogActivity() {
    var logTextArea = $('#logActivityTextArea').val();
    var project_id = projectIdForLog;
    var pipeLineId = pipeLineIdForLog;
    var levelId = levelIdForLog;
    var action = "log";
    if (project_id != '' || project_id != undefined) {
        $.ajax({
            data: {project_id: project_id, pipeLineId: pipeLineId, levelId: levelId, logTextArea: logTextArea, action: action},
            url: SITEROOT + '/project/getProjectDetails/',
            type: "POST",
            beforeSend: function() {
                $("body").faLoading('fa-cog');
            },
            success: function(data) {
                console.log(data);
                if (data != '') {
                    $('#facebox .popup').width('100%');
                    jQuery.facebox(data);
                    $("body").faLoading(false);
                } else {
                    jQuery.facebox("No data found for this project");
                    $("body").faLoading(false);
                }
            }
        });
    }

}

function viewProjectInfo(id, pipeLineId, levelId) {

    $('#facebox .popup').width('100%');
    var action = "info"
    if (id != '' || id != undefined) {
        var project_id = id;
        $.ajax({
            async: false,
            data: {project_id: project_id, pipeLineId: pipeLineId, levelId: levelId, action: action},
            url: SITEROOT + '/project/getProjectDetails/',
            type: "POST",
            beforeSend: function() {
                $("body").faLoading('fa-cog');
            },
            success: function(data) {
                if (data != '') {
                    $("body").faLoading(false);
                    jQuery.facebox(data);
                } else {
                    $("body").faLoading(false);
                    jQuery.facebox("No data found for this project");
                }
            },
            error: function(data) {
                $("body").faLoading(false);
                alert("Could not submit data");
            }
        });
    } else {
        alert("Something went wrong, please refresh ");
    }

}

function updateProjectDetails() {

    //give an ajax call to updatProject after that dashbpardReleod and then alert message

    var level_id = $("#edit_level_id").val();
    var project_id = $("#edit_project_id").val();
    var tam_curr = $("#edit_tam_currency").val();
    var tam_old = getEditPageData('edit_tam_currency');

    if (tam_curr === tam_old) {
        if (editLogStatement === "") {
            jQuery(document).trigger('close.facebox');
            return false;
        }
    }
    if (tam_curr !== tam_old) {
        editLogStatement = "Tam currency is changed from " + tam_old + " to " + tam_curr;
    }
    insertEditLogActivity(project_id, level_id, function(err, resp) {
        if (err) {
            return false;
        }
        var form = $('#editProjectDetails')[0]; // You need to use standart javascript object here
        var formData = new FormData(form);
        console.log(formData);

        var url = SITEROOT + "/project/updateProject/";
        $.ajax({
            type: "post",
            data: formData,
            url: url,
            processData: false,
            contentType: false,
            beforeSend: function() {
                $("body").faLoading('fa-cog');
            },
            success: function(data) {
                var result = data.split("::");
                data = result[0];
                if (data == 'success') {
                    jQuery(document).trigger('close.facebox');
                    dashboardReload('');
                    $("<div id='spanId' class='setDelay'>Project details updated successfully</div>").dialog();

                    setTimeout(function() {
                        $(".ui-dialog").hide();
                    }, 3000);
                    $("body").faLoading(false);

                } else if (data == 'error') {
                    $("body").faLoading(false);
                    alert("please check the data");
                } else if (data == 'no data') {
                    $("body").faLoading(false);
                    alert("No data inserted");
                } else if (data == 'error upload') {
                    alert("Error in uplaoding attachment");
                }
            },
            error: function(data) {
                alert("Could not submit data");
            }
        });
    });
}

function viewAndEditCheckIdOfProject(check_id, project_id, pipe_id) {

    if (check_id != '' || check_id != undefined) {
        var check_id = check_id;
        $.ajax({
            data: {check_id: check_id, project_id: project_id, pipe_id: pipe_id},
            url: SITEROOT + '/checks/viewAndEditCheckIdOfProject/',
            type: "POST",
            beforeSend: function() {
                $("body").faLoading('fa-cog');
            },
            success: function(data) {
                if (data != '') {
//                    jQuery.facebox(data);
                    $("#editCheckIdOfProject").html(data);
                    $("#editCheckIdOfProject").modal();
                    $("body").faLoading(false);
                } else {
                    $("body").faLoading(false);
                    jQuery.facebox("No data found for this project");
                }
            },
            error: function(data) {
                $("body").faLoading(false);
                alert("Could not submit data");
            }
        });
    } else {
        alert("Something went wrong, please refresh ");
    }
}

function updateCheckIdofProject() {
    var chkIdValue = $("#chkIdValue").val();
    var pipeId = $("#pipeId").val();
    var proj_id = $("#proj_id").val();
    var level_id = $("#level_id").val();
    var check_id = $("#check_id").val();
    var project_name = $("#project_name").val();
    var check_name = $('#check_name').val();
    editLogStatement = "";
    editLogStatement = check_name + " value changed to " + chkIdValue + ".";
    insertEditLogActivity(proj_id, level_id, function(err, resp) {
        if (err) {
            return false;
        }
        var url = SITEROOT + "/checks/updateCheckId/";
        $.ajax({
            type: "post",
            data: {
                chkIdValue: chkIdValue,
                pipeId: pipeId,
                proj_id: proj_id,
                check_id: check_id,
                project_name: project_name
            },
            url: url,
            beforeSend: function() {
                $("body").faLoading('fa-cog');
            },
            success: function(data) {

                if (data === 'success') {
                    $('#editCheckIdOfProject').modal('hide');
                    dashboardReload('');
                    $("body").faLoading(false);
                } else if (data === 'error') {
                    $('#editCheckIdOfProject').modal('hide');
                    $("<div id='spanId' class'setDelay'>Error while updating check status</div>").dialog();
                    setTimeout(function() {
                        $(".ui-dialog").hide();
                        $("body").faLoading(false);
                    }, 3000);
                } else if (data === 'no data') {
                    $('#editCheckIdOfProject').modal('hide');
                    $("body").faLoading(false);
                    alert("No data posted");
                }
            },
            error: function(data) {
                $("body").faLoading(false);
                alert("Could not submit data");
            }
        });
    });
}

function viewStages() {
    $.ajax({
        type: "POST",
        url: SITEROOT + '/settings/ajax/stages/',
        success: function(data) {
            jQuery.facebox(data);
        }
    });
}

function getCheckList(levelId, pipelineId) {
    $.ajax({
        data: {levelId: levelId, pipelineId: pipelineId},
        type: "POST",
        url: SITEROOT + '/checks/getCheckList/',
        success: function(data) {
//            alert("hi");
//            jQuery.facebox(data);
            $("#checkListModal").html(data);
            $("#checkListModal").modal('show');

        }
    });


}

function setPipeLineName(pipeName, pipelineId, activeTabId) {
    console.log(activeTabId);
    $("#pipelineName").val(pipeName);
    $("#pipelineId").val(pipelineId);
    $("#activeTabId").val(activeTabId);
}

function promoteLevel(projectId, levelId, typeId, data, updated_on, fifteenDaysBefore_updated_on) {
    //get the project id and then promote
    var projectName = $('#' + data).text();
    editLogStatement = "";
    var encodedTypeId = window.btoa(typeId); // encode a string
    $.ajax({
        async: false,
        type: "POST",
        data: {'projectId': projectId, levelId: levelId, typeId: typeId, updated_on: updated_on, fifteenDaysBefore_updated_on: fifteenDaysBefore_updated_on},
        url: SITEROOT + "/dashboard/ajax/promoteLevel",
        beforeSend: function() {
            $("body").faLoading('fa-cog');
        },
        success: function(data) {
//           alert(data);
            var result = data.split("::");
            console.log(result);
            data = result[0];
            if (data === "success") {
                editLogStatement = "User promoted " + projectName + " to stage " + result[2] + " from " + result[1];
                insertEditLogActivity(projectId, levelId, function(err, resp) {
                    if (err) {
                        return false;
                    }
                    $("<div id='spanId' class'setDelay'>Project Promoted to next level successfully</div>").dialog();
                    setTimeout(function() {
                        $(".ui-dialog").hide();
                        $("body").faLoading(false);
                    }, 3000);
                    window.location.href = SITEROOT + "/dashboard/dashboard/" + encodedTypeId + "/edit";
                });
            } else if (data === "no next level") {
                $("body").faLoading(false);
                alert("No Level to promote");
            }
            else {
                $("body").faLoading(false);
                alert("Project cannot move to next level");
            }
        }, error: function(data) {
            $("body").faLoading(false);
            alert("Error while promoting")

        }
    });
}

var deletedData = "";
function getDeleteStatement(data) {
    $('#facebox .popup').width('300px');
    jQuery.facebox(' <div  class="" id="deleteCommentBox">\n\
                        <table>\n\
                            <tbody><tr><div class="panel-heading">Comment:</tr>\n\
                            <tr><textarea class="northspace2" rows="3" id="deleteStatement"></textarea></tr>\n\
                            <tr><input type="button" class="btn btn-primary northspace3 fr" onclick="saveDeleteLog();" value="Submit"></tr></tbody></table>\n\
                            </div></div>');
    deletedData = data;
}

function saveDeleteLog() {
    $("body").faLoading('fa-cog');
    jQuery(document).trigger('close.facebox');
    var oldPipe = $("#typeDropDown").val();
    var deleteLogStatement = $('#deleteStatement').val();
    var result = deletedData.split("::");
    deletedData = result[0];
    editLogStatement = "Idea " + result[2] + " is deleted with following comments \n " + deleteLogStatement;
    insertEditLogActivity(result[3], result[1], function(err, resp) {
        if (err) {
            return false;
        }
        if (deletedData == "success") {
            dashboardReload(oldPipe);
            $("<div id='spanId' class'setDelay'>Project Deleted successfully</div>").dialog();
            setTimeout(function() {
                $(".ui-dialog").hide();
                $("body").faLoading(false);
            }, 3000);
//            location.reload(true);
        } else {
            $("body").faLoading(false);
            alert("Project failed to delete");
        }
    });
}

function removeProject(project_id) {

    editLogStatement = "";
    var is_active = 0;
    if (project_id != undefined || project_id != '') {
        $.ajax({
            type: "POST",
            data: {edit_project_id: project_id, is_active: is_active},
            url: SITEROOT + "/project/updateProject",
            beforeSend: function() {
                $("body").faLoading('fa-cog');
            },
            success: function(data) {
                $("body").faLoading(false);
                getDeleteStatement(data + "::" + project_id);
            }
        });
    }
}

function filterPipeline() {
    var filterValue = $("#filterPipe option:selected").val();
    var pipeId = $('#typeDropDown').val();
//    alert(pipeId);
    if (pipeId !== '' && pipeId !== 'NoPipeline') {
        //if (filterValue == 'allDeals' || filterValue == 'deletedDeals') {
        $.ajax({
            async: false,
            type: "POST",
            data: {filterValue: filterValue, pipeId: pipeId},
            url: SITEROOT + "/dashboard/dashboard",
            success: function(data) {
                jQuery("#levelTable").html(data);
                //$("#filterPipe").val($("#filterPipe option:first").val());
            }
        });
        //}

    }
    else {
        alert("No pipeline available to filter ");
    }
}

function changePipeLine(levelToBeUpdated, typeId) {

    //dragId is global variable for dragged project's id //checkdragProject.js for this var initialization
    var oldPipe = $("#typeDropDown").val();

    console.log(dragId);
    console.log(levelToBeUpdated);
    if (dragId != undefined || dragId != '') {
        $.ajax({
            // async: false,
            type: "POST",
            data: {dragId: dragId, levelToBeUpdated: levelToBeUpdated, typeId: typeId, oldPipe: oldPipe},
            url: SITEROOT + "/dashboard/ajax/UpdatePipeline",
            beforeSend: function() {
                $("body").faLoading('fa-cog');
            },
            success: function(data) {
                var result = data.split("::");
                data = result[0];
                if (data === 'success') {
                    editLogStatement = "Idea changed to pipeline " + result[1] + " from " + result[2];
                    insertEditLogActivity(dragId, levelToBeUpdated, function(err, resp) {
                        if (err) {
                            return false;
                        }
                        $("<div id='spanId' class'setDelay'>Pipeline changed successfully</div>").dialog();
                        setTimeout(function() {
                            $(".ui-dialog").hide();
                        }, 2000);
                        $('#fullViewModal').css({'display': 'none'});
                        dashboardReload(oldPipe);
                        $("body").faLoading(false);
                    });
                } else {
                    $("body").faLoading(false);
                    alert("Something went wrong,Please refresh");
                }
            }
        });
    } else {
        $("body").faLoading(false);
        alert("Something went wrong,no project selected");
    }
}

function setPipelineId() {
    var pipeLineId = $("#pipeId").val();
    $("#pipelineId").val(pipeLineId);

}

function addNewStage() {

    var validity = $("#validity").val();
    var stageName = $("#stage_name").val();
    var description = $("#description").val();
    var pipelineName = $("#pipelineName").val();
    var pipelineId = $("#pipelineId").val();
    var activeTabId = $("#activeTabId").val();
    var submit = "submit";

    if (checkIfEmpty('stage_name')) {
        return false;
    } else if (checkIfEmpty('validity')) {
        return false;
    } else if (checkIfEmpty('description')) {
        return false;
    }

    $.ajax({
        async: false,
        type: "POST",
        data: {
            validity: validity,
            stage_name: stageName,
            description: description,
            pipelineName: pipelineName,
            pipelineId: pipelineId,
            activeTabId: activeTabId,
            submit: submit
        },
        url: SITEROOT + "/stage/createStage/",
        beforeSend: function() {
            $("body").faLoading('fa-cog');
        },
        success: function(data) {
            if (data == "success") {
                $('#addNewStage').modal('hide');
                reloadSettingPage(activeTabId);
                $("body").faLoading(false);
                $("<div id='spanId' class'setDelay'>Stage created successfully</div>").dialog();
                setTimeout(function() {
                    $(".ui-dialog").hide();
                }, 3000);
//                    location.reload();
            } else {
                //alert(data);
                $('#addNewStage').modal('hide');
                $("body").faLoading(false);
                $("<div id='spanId' class'setDelay'>Stage failed to add</div>").dialog();
                setTimeout(function() {
                    $(".ui-dialog").hide();
                }, 3000);
            }
            // code kept purposefully for showing active tabs
//             $("#tab1").addClass("tab-pane active");
//            location.reload();
//            alert(data);
//            $("#"+data).removeClass("active");  // this deactivates the home tab
//            $("#profile").addClass("active");
//                jQuery("#levelTable").html(data);
            // $("#filterPipe")
            //$("#filterPipe").val($("#filterPipe option:first").val());
        },
        error: function(data) {
            alert("their is error");
        }
    });
}

function editPermission(roleId, userId) {

    $.ajax({
        type: "POST",
        url: SITEROOT + "/userPermission/editPermission/",
        data: {roleId: roleId, userId: userId},
        success: function(data) {
            $("#editUser").html(data);
            $("#editUser").modal();
        }
    });
}

function deletePermission(roleId, userId) {
    $.ajax({
        type: "POST",
        url: SITEROOT + "/userPermission/userPermissions/",
        data: {roleId: roleId, userId: userId, deleteFlag: 'true'},
        success: function(data) {
            $("#addProjectForm").html(data);
        }
    });
}

function createChecklist(levelId, pipeLineId) {
    $('#requestPipeLineId').val(pipeLineId);
    $('#requestLevelId').val(levelId);
    $('#createCheckListModal').modal();

}

function deleteChecklist(levelId, pipeLineId) {
    var checkedValues = new Array();
    var i = 0;
    var pipeLineId = $("#pipelineId").val();
    var levelId = $("#levelId").val();
    $('input:checkbox:checked').each(function() {
        checkedValues[i++] = $(this).val();
    });
    var url = SITEROOT + "/checks/getCheckList/";
    $.ajax({
        type: "POST",
        url: url,
        data: {checkedValues: checkedValues, pipeLineId: pipeLineId, levelId: levelId},
        success: function(data) {
            $("#checkListModal").html(data);

        }
    });
}

function detectBrowser() {
    var isChrome = !!window.chrome && !!window.chrome.webstore;
    if (isChrome) {
        alert("yes")
    } else {
        alert("no");
    }
}

var checkHoverData = new Array();
function displayCheckDetails(id, divId) {
    //var $('#getCheckDetails').val();
    var i = 0;
    checkHoverData = JSON.parse($('#getCheckDetails').val());

    for (i = 0; i < checkHoverData.length; i++) {
        if (checkHoverData[i].id === id) {
            var hoverData = checkHoverData[i].onhover;
            var find = 'SINGLE_CHAR_CONSTANT';
            var re = new RegExp(find, 'g');
            hoverData = hoverData.replace(re, "'");
            document.getElementById("checkIdGroup_" + divId + '_' + checkHoverData[i].id).setAttribute('title', hoverData);
        }
    }
}

function addCheckID(pipeLineId, stageId) {
    var checkId = $("#checkId").val();
    var checkName = $("#checkName").val();
    var description = $("#checkDescription").val();
    if (checkIfEmpty('checkName')) {
        return false;
    }
    if (description.length < 1) {
        $('#checkPointDesc').show().delay(3000).fadeOut();
        document.getElementById('checkDescription').placeholder = "The field cannot be blank!";
        return false;
    }
    var pipeLine = $("#requestPipeLineId").val();
    var levelId = $("#requestLevelId").val();
    var url = SITEROOT + "/checks/createCheckId/";

    $.ajax({
        type: "POST",
        url: url,
        data: {checkId: checkId, checkName: checkName, description: description, levelId: levelId, pipelineId: pipeLine},
        success: function(data) {
            $("#createCheckListModal").modal('hide');
            $("#checkListModal").html(data);
            $("#checkListModal").modal();
            $("#checkName").val('');
            $("#checkDescription").val('');
        }
    });
}

function updateSAMCurrency(value) {

    var currencyValue = $("#tamCurrency option:selected").val();
    $("#samCurrency").val(currencyValue);
    $("#samCurrencyLabel").text(currencyValue);
}

function changeCurrency(value) {

    $("#sam_currency").val(value);
    $("#editSamCurrency").val(value);
    $("#edit_sam_currency").val(value);
    $("#editSamCurrencyLabel").text(value);
}

function reloadSettingPage(activeTab) {
    if (activeTab != '') {
        var activeTabId = activeTab;
    } else {
        var activeTabId = '';
    }
    var submit = 'submit';
    var reload = 'yes';
    $.ajax({
        data: {submit: submit, reload: reload, activeTabId: activeTabId},
        url: SITEROOT + "/settings/setting/",
        type: "POST",
        success: function(data) {
//            alert(data);
            $('#settingBody').html(data);
            $('.nav-tabs a[href="#tab' + activeTab + '"]').tab('show')
        }, error: function(data) {
            alert(data);
        }
    });
}

function createNewPipeLine() {
    var pipeline_title = $("#pipeline_title").val();
    var check_required = 0;
    var notifi_required = 0;
    if ($('#check_required').is(":checked")) {
        check_required = 1;
    }
    if($('#notifi_required').is(":checked")){
        notifi_required = 1;
    }
    if (checkIfEmpty('pipeline_title')) {
        return false;
    }
    $.ajax({
        data: {pipeline_title: pipeline_title, check_required: check_required,notifi_required:notifi_required},
        url: SITEROOT + "/pipeline/addPipeline/",
        type: "POST",
        beforeSend: function() {
            $("body").faLoading('fa-cog');
        },
        success: function(data) {
            if (data === "success") {
                $('#addNewPipeline').modal('hide');
                reloadSettingPage();
                $("body").faLoading(false);
                $("<div id='spanId' class'setDelay'>PipeLine created successfully</div>").dialog();
                setTimeout(function() {
                    $(".ui-dialog").hide();
                }, 3000);
            } else if (data === "error") {
                $("body").faLoading(false);
                alert("Something went wrong , please try again");
            }
        }, error: function(data) {
            $("body").faLoading(false);
            alert("could not post data");
        }
    });
}

function deletePipeLine(id) {
    var confirmData = confirm(" Are you sure you want to delete Pipeline ?");
    if (confirmData) {
        $.ajax({
            type: 'POST',
            url: SITEROOT + "/pipeline/deletePipeLine/",
            data: {id: id},
            success: function(data) {
                location.reload(true);
            }
        });
    } else {
        return false;
    }
}

function submitActionItem() {


    var project_id = $("#stage_id").val();
    var pipeLineId = $("#pipeLineId").val();
    var levelId = $("#levelId").val();
    var project_name = $("#stage_name").val();
    var action_subject = $("#popup_subject").val();
    var action_description = $("#popup_description").val();
    var action_assignee = $("#popup_assignee").val();
    var action_priority = $("#popup_priority").val();
    var actionStartDate = $("#actionTabStartDate").val();
    var actionDueDate = $("#actionTabDueDate").val();
    var actionItemComments = $("#actionItemComments").val();

    if (checkIfEmpty('popup_subject')) {
        return false;
    } else if (checkIfEmpty('actionTabStartDate')) {
        return false;
    } else if (checkIfEmpty('actionTabDueDate')) {
        return false;
    } else {
        $.ajax({
            type: "POST",
            url: SITEROOT + "/redmine/createActionItem/",
            data: {project_id: project_id, project_name: project_name, action_subject: action_subject,
                action_description: action_description, action_assignee: action_assignee, action_priority: action_priority,
                actionStartDate: actionStartDate, actionDueDate: actionDueDate, actionItemComments: actionItemComments, popup: 'popup'},
            beforeSend: function() {
                $("body").faLoading('fa-cog');
            },
            success: function(data) {
//                console.log(data);
                if (data === '201') {
                    editLogStatement = "Action Item created. \n" + "Subject : " + action_subject;
                    insertEditLogActivity(project_id, levelId, function(err, resp) {
                        if (err) {
                            return false;
                        }
                        $("#collapseOne").removeClass('in');
                        $("#collapseOne").parent().find(".glyphicon-minus").removeClass("glyphicon-minus").addClass("glyphicon-plus");
                        viewProjectInfo(project_id, pipeLineId, levelId);
                        $('.nav-tabs a[href="#tab-2"]').tab('show');
                        getActionItemDetails(project_id);
                        $("body").faLoading(false);
                    });
                } else {
                    alert("Error while creating Action Item");
                }
            }
        });
    }

}

function checkForDateValidation() {

    if (checkIfEmpty('action_subject')) {
        return false;
    } else if (checkIfEmpty('actionStartDate')) {
        return false;
    } else if (checkIfEmpty('actionDueDate')) {
        return false;
    } else {
        return true;
    }
}

function getResponsiblePerson(pipeId) {
    $.ajax({
        type: 'POST',
        url: SITEROOT + "/dashboard/responsiblePerson",
        data: {pipeId: pipeId, ajax_call: 'yes'},
        success: function(data) {
            $("#filterPipe").html(data);
        }
    });
}

function exportPipeXls() {
    var pipeId = $("#typeDropDown").val();
    var filterPipe = $("#filterPipe").val();

    var url = SITEROOT + "/exportPipeXls/";

    if (pipeId == '') {
        alert("Something went wrong, contact admin for more details");
        return false;
    }

    var appndFilter = (filterPipe != '') ? filterPipe : "nofilter";

    url += pipeId + "/" + appndFilter + "/export";

    window.location = url;



}

function autoSuggestPerson(id) {
    $('#' + id).autocomplete({
        source: function(request, response) {
            $.ajax({
                type: "POST",
                url: SITEROOT + '/common/autoCompleteSuggestPerson',
                data: {
                    searchParam: request.term
                },
                success: function(data) {
                    var data1 = eval($.parseJSON(data));
                    //console.log(data1);
                    response(jQuery.map(data1, function(item) {
//                    	$("#"+id+"_email").val(item['mail']);
                        return {
                            label: item['name'],
                            value: item['name'].concat("<", item['mail'])
                        }
                    }));
                }
            });
        },
        select: function(a, b) {

            logStatementOnChange(id);

        },
        autoFocus: false,
        minLength: 1
    });
}
function getActionItemDetails(project_id) {
//    alert("open Tab");
    $.ajax({
        type: 'POST',
        url: SITEROOT + '/project/getActionItemDetails',
        data: {project_id: project_id},
        beforeSend: function() {
            $("body").faLoading('fa-cog');
        },
        success: function(data) {
            $("#tab-2").html(data);
            $("body").faLoading(false);
        }
    });
}
function checkIfEmpty(id) {
    var fieldValue = $('#' + id).val();
    if (fieldValue === "") {
        setTimeout(function() {
            document.getElementById(id).style.borderColor = "";
        }, 2000);
        document.getElementById(id).style.borderColor = "red";
        return true;
    } else {
        return false;
    }
}
function restoreProject(projectId, levelId) {
    $.ajax({
        type: "POST",
        url: SITEROOT + '/dashboard/ajax/restoreProject',
        data: {projectId: projectId},
        beforeSend: function() {
            $("body").faLoading('fa-cog');
        },
        success: function(data) {
            if (data == "success") {
                editLogStatement = "Idea restored.";
                insertEditLogActivity(projectId, levelId, function(err, resp) {
                    if (err) {
                        return false;
                    }
                    $("<div id='spanId' class'setDelay'>Idea restored successfully</div>").dialog();
                    setTimeout(function() {
                        $(".ui-dialog").hide();
                    }, 3000);
                    dashboardReload('');
                    $("body").faLoading(false);
                });
            } else if (data == "failed") {
                alert("Error while restoring Idea");
            }
        },
    });
}