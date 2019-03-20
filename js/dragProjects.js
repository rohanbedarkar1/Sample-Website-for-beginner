var dragId;
$("#date_created").datepicker({
});
$(".customScroll").mCustomScrollbar();
$("#content-5").mCustomScrollbar({
    axis: "x",
    theme: "dark-thin",
    autoExpandScrollbar: true,
    advanced: {autoExpandHorizontalScroll: true}
});
$(function()
{
    // $('#mainTable').css({'height': (($(document).height()) - 100) + 'px'});


    $(window).resize(function() {
        $('#mainTable').css({'height': (($(document).height()) - 102)});
        //$('.autoscroll').css({'height': (($(document).height())-55)});
        $('.autoscroll').css("window", $(window).height());
        // alert('resize');
        //  $('#levelTable').css({'height': (($(document).height()) - 100)});
    });
    //   $height = $("#mainTable").height();


});

$(document).ready(function() {
    //$('[data-toggle="tooltip"]').tooltip(); 
    $('#mainTable').css({'height': (($(document).height()) - 102)});
    $('.autoscroll').css({'height': (($(document).height()) - 55)});
    // $('body').css({'overflow-y': 'hidden'});
    //   $('#levelTable').css({'height': (($(document).height()) - 100)});
    // $('#mainTable').css({'background': 'red'});
    var table = $('#dragTable11455541').DataTable({
        scrollY: '450px',
        scrollX: true,
        paging: false,
        searching: false,
        ordering: false
    });
    $('#createProjectButton').click(function() {
        if ($("#noProjectAlert").val() != 'No Project') {
            getType($('#typeDropDown option:selected').text());
        } else {
            alert("No Stages to add Project");
        }
    });
    $("#date_created").datepicker({
    });
    var dataAvailable = $('#dataAvailable').val();
    if (dataAvailable === 'No Data') {
        jQuery("#levelTable").html(" <label class=customLabel>No Stages available currently </label> ");
        $("#createProjectButton").hide();
        $("#noProjectAlert").val("No Project");
    } else if (dataAvailable === 'Data') {
        $("#createProjectButton").show();
    }
});
$(function() {
    $(".move-btn").sortable({
        // connectWith: ".tdPayment",
        remove: function(e, ui) {
            // alert('drag');
            $(".backImg").removeClass("showBottomWrap");
            $(".move-btn").addClass("dropClass");

            var $this = $(this);
            var childs = $this.find('div');


            if (childs.length === 0) {
                //$this.text("Nothing");
            }




        },
        receive: function(e, ui) {
            // alert('1');
            $(".backImg").removeClass("showBottomWrap");
            $(this).contents().filter(function() {

                return this.nodeType == 3; //Node.TEXT_NODE
            }).remove();
        },
    }).disableSelection();


});



//****************************************************
$(function() {
    $(".move-btn").draggable({
        //  appendTo: "body",
        // helper: "clone",
        cursor: "move",
        revert: "invalid",
    });

    initDroppable($("#removeCard"));
    function initDroppable($elements) {
        $elements.droppable({
            activeClass: "",
            hoverClass: "dragOverRemove",
            //   accept: ":not(.ui-sortable-helper)",
            over: function(e, ui) {
                var $this = $(this);
//                console.log(draggableId + "--" + droppableId);
                //    console.log($this);
            },
            drop: function(e, ui) {
                // console.log(e);
                var $this = $(this);

                var draggableId = ui.draggable.attr("id");
                var droppableId = $(this).attr("id");
                ui.draggable.remove();
                console.log(draggableId + "--" + droppableId);
                removeProject(draggableId);
                //   ui.draggable.remove();
                // $("<li></li>").text(ui.draggable.text()).appendTo(this);
            }
        });
    }

    initDroppable2($("#changePipeline"));
    function initDroppable2($elements) {
        $elements.droppable({
            activeClass: "",
            hoverClass: "changePipelineCard",
            //   accept: ":not(.ui-sortable-helper)",
            over: function(e, ui) {
                var $this = $(this);
                //console.log(draggableId + "--" + droppableId);
            },
            drop: function(e, ui) {
                // console.log(e);

                $('#fullViewModal').css({'display': 'block'});
                var $this = $(this);
                var draggableId = ui.draggable.attr("id");
                var droppableId = $(this).attr("id");
                dragId = draggableId;
//                var draggedValue = $("#"+draggableId).text();
//                alert(draggableId.text);
                $("#dragProjectName").html("");
                $("#dragProjectName").html($("#" + "projectName" + draggableId).text());
                console.log(draggableId + "--" + droppableId);
                // ui.draggable.remove();
                // $("<li></li>").text(ui.draggable.text()).appendTo(this);
            }
        });
    }

});
//------------------------------------------------------------------------------------------------
// surya created function
function drop(ev) {

    ev.preventDefault();
    var data = ev.dataTransfer.getData("text");
    var projectName = $('#' + data).find('h3').text();

    $.ajax({
        async: false,
        type: "POST",
        data: {'project_name': projectName},
        url: SITEROOT + "/dashboard/ajax/getProjectStatus",
        success: function(data) {
            if (data == 'allow') {
                var node = document.createElement("li");
                var data = ev.dataTransfer.getData("text");
                node.appendChild(document.getElementById(data));
                console.log(ev.target);
                $('#' + ev.target.id).append(
                        $('<ul>').append(
                        $('<li>').append(node)
                        ));
            }
            else {
                alert("Project cannot move to next level");
            }
        }
    });

}

function dashboardReload(chngPipe) {
    //alert($('#typeDropDown').val());
    if (chngPipe != '') {
        var pipeId = chngPipe;
    } else {
        var pipeId = $('#typeDropDown').val();
    }

//    $('#createProjectButton').text("Create " + $('#typeDropDown option:selected').text());
    getResponsiblePerson(pipeId);
    $.ajax({
        async: false,
        type: "POST",
        data: {'pipeId': pipeId},
        url: SITEROOT + "/dashboard/dashboard",
        success: function(data) {
//            alert(data);
            if (data == 'No data') {
                jQuery("#levelTable").html(" <label class=customLabel>No Stages available currently </label> ");
                $("#createProjectButton").hide();
                $("#noProjectAlert").val("No Project");
            } else {
                $("#createProjectButton").show();
                jQuery("#levelTable").html(data);

            }
            $("#filterPipe ").val($("#filterPipe option:first").val());
            $('#addProjectModal').modal('hide');
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();

        }
    });

}
$(function() {
    $("#date_created").datepicker({
    });
});
//close  change pipeline view
function closePipeline() {
    location.reload(true);
}


(function($) {
    $(window).load(function() {

        $("#content-5").mCustomScrollbar({
            axis: "x",
            theme: "dark-thin",
            autoExpandScrollbar: true,
            advanced: {autoExpandHorizontalScroll: true}
        });


        $("#content-8").mCustomScrollbar({
            axis: "yx",
            scrollButtons: {enable: true},
            theme: "3d",
            scrollbarPosition: "outside"
        });



    });
})(jQuery);