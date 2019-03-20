$(function() {
    $("#success").delay(5000).fadeOut();
    $("#error").delay(5000).fadeOut();
    $("#drag1, #drag2, #drag3, #drag4, #drag5").sortable({
        connectWith: ".tdPayment",
        remove: function(e, ui) {
            // alert('drag');
            $(".backImg").removeClass("showBottomWrap");
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




$(function() {
    $(".customize-block").sortable();
    $(".customize-block").disableSelection();
    initDroppable($(".customize-block"));
});

function initDroppable($elements) {
    var postStr = [];
    $elements.droppable({
        activeClass: "",
        // hoverClass: "dragOverRemove",
//           accept: ":not(.ui-sortable-helper)",
        over: function(e, ui) {
            var $this = $(this);
//                console.log($this);
        },
        drop: function(e, ui) {

        }

    });
}

function setOrder(pipelineId) {

    var postStr = [];
    var tempCnt = 1;
    var tabId = $("#tabs .tab-content .active").attr("id");
    var divId = "#sortable_" + tabId;

    $(divId + " a div").each(function(idq) {
        postStr.push($(this)[0].id + ":" + tempCnt++);
    });

    var orderLength = postStr.length;

    if (orderLength != 0) {
        $.ajax({
            data: {postStr: postStr, pipelineId: pipelineId},
            url: SITEROOT + '/stage/updateOrderOfStages/',
            type: "POST",
            beforeSend: function() {
                $("body").faLoading('fa-cog');
            },
            success: function(data) {
//           alert(data);
                if (data === "success") {
                    $("body").faLoading(false);
//                    alert("Pipeline Ordered Successfully");
                    $("<div id='spanId' class'setDelay'>Pipeline Ordered Successfully</div>").dialog();
                    setTimeout(function() {
                        $(".ui-dialog").hide();
                    }, 3000);
                } else {
                    $("body").faLoading(false);
//                    alert("Pipeline reordering failed");
                    $("<div id='spanId' class'setDelay'>Pipeline reordering failed</div>").dialog();
                    setTimeout(function() {
                        $(".ui-dialog").hide();
                    }, 3000);
                }
            }
        });
    } else {
        alert("No stages for  re-ordering");
    }

    console.log(postStr);
}

// $( "" ).each(function( i ) {
//    if ( this.style.color !== "blue" ) {
//      this.style.color = "blue";
//    } else {
//      this.style.color = "";
//    }
//  });


//$('#sortable').children('input').each(function() {
//    console.log($(this));
//    alert(this.value); // "this" is the current element in the loop
//});
// $(".sidebar li a").click(function() {
//alert('1');
//   $(".sidebar li a").removeClass('active');
//   $(this).addClass('active');
//    return false;
//  });
//$('#checkListModal').modal({keyboard: true});


