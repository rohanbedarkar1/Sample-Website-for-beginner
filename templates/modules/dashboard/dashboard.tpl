{include $header1}
{include $header2}
{literal}
    <link rel="stylesheet" href="{/literal}{$sitecss}{literal}/facebox.css" type="text/css"/>
    <script src="{/literal}{$sitejs}{literal}/facebox.js"></script>
{/literal}
{if isset($smarty.session.successMsg)}
    <script>
        $("body").faLoading(false);
        $("<div id='spanId' class'setDelay'>Action Item created successfully</div>").dialog();
        setTimeout(function() {
            $(".ui-dialog").hide();
        }, 2000);
    </script>
{/if}
<div class="container-fluid padnorth4" id="">
    <div class="row" >

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 sessionMsg">
            {if !empty($getPipeLine) && $smarty.session.role != "Read Only"}
                <button type="button" class="btn btn-info pull-left" name="modal_button" data-toggle="modal" data-target="#addProjectModal" id="createProjectButton" onclick="setPipelineId();">Add an Idea</button>
            {/if}

            <form class="form-horizontal" role="form">
                <div class="view-category">
                    <select id="filterPipe" name="filterPipe" class=" show-menu-arrow form-control" onchange="filterPipeline();">
                        {include $resp_person} 
                    </select>
                </div>
            </form>
            <form class="form-horizontal" role="form">
                <select class="form-control view-category" id ="typeDropDown"onchange="dashboardReload('')">
                    {if !empty($getPipeLine)}
                        {foreach from=$getPipeLine item=pipe}
                            <option value="{$pipe.pipeId}"{if $pipeId==$pipe.pipeId}selected=""{/if}>{$pipe.name}</option>
                        {/foreach}
                    {else}
                        <option value="NoPipeline">No Pipelines</option>
                    {/if}   
                </select>
            </form>

            <div class="view-category">
                <a type="button" class="btn btn-info" href="{$siteroot}/redmine/viewActionItem/" target="_blank">View Action Items</a>
            </div>

            {if $smarty.session.role != "Read Only"}
                <div class="view-category">
                    <button type="button" class="btn btn-info" name="modal_button" data-toggle="modal" data-target="#addActionModal">Create Action Item</button>
                </div>
            {/if}
            <div class="pull-left westspace2">
                <button type="button" href="javascript:void(0);" class="btn btn-info" onclick="exportPipeXls()">Export To Excel</button>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 testCol">
            {* <div id="content-8" class="content">*}
            <div id="levelTable">
                {include $mainTable}
            </div>
            <!-- Modal editBlock -->
        </div>
    </div>
</div>
<div id="dealActions" class="">
    <div class="deleteCards droppable" id="removeCard">
        <i class="fa fa-times deleteCard"></i>
        <span class="captionRemove">Remove Card</span>
    </div>
    <div class="deleteCards" id="changePipeline">
        <i class="fa fa-cogs changePipeline"></i>
        <span class="captionRemove">Change Pipeline</span>
    </div>
</div>

<div id="editCheckIdOfProject" class="modal fade" role="dialog" tabindex='-1'></div>
<input type="hidden" value="" id="noProjectAlert" name="noProjectAlert" />
<input type="hidden" {if isset($smarty.session.successMsg)}value="{$smarty.session.successMsg}"{/if} id="successMessage" name="successMessage" />
<input type="hidden" {if isset($smarty.session.errorMsg)}value="{$smarty.session.errorMsg}"{/if}  id="errorMessage" name="errorMessage"/>
{literal}
    <script type="text/javascript">
        $(document).ready(function() {
            var successMsg = $("#successMessage").val();
            var errorMessage = $("#errorMessage").val();

            if (successMsg != '') {
                //  alert("success");
                // unset the session message 

            } else if (errorMessage != '') {
                //  alert("failed");
            }
            /// $("#success").delay(5000).fadeOut();
            // $("#error").delay(5000).fadeOut();
        });
    </script>
{/literal}

{include $footer}  
<!-- change pipeline view -->
{*  <div class="popupChange" id="">sdssssddsdssdsd</div>*}
{include $changePipeline}
{*{if $smarty.session.role != "Read Only"}
    {literal}
        <script src="{/literal}{$sitejs}{literal}/dragProjects.js"></script>
    {/literal}
{/if}*}

