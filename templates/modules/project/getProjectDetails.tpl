<div id="tabs" class="tabsDisplay northspace2" style="height:520px;margin-top: -12px;">
    <ul class="nav nav-tabs" role="tablist">
        <li class="active" role="presentation" ><a href="#tab-1" role="tab" data-toggle="tab"><b>Details</b></a></li>
        <li id="actionItemTab" role="presentation" ><a href="#tab-2" role="tab" data-toggle="tab" onclick="getActionItemDetails('{$getProjectDetails['project_id']}');"><b>Action Item</b></a></li>
        <li id="attachmentsTab" role="presentation" ><a href="#tab-3" role="tab" data-toggle="tab"><b>Attachments</b></a></li>
    </ul>
    <div class="tab-content" id="tabContent">
        <div class="tab-pane active" id="tab-1" style="margin-top: 8px;">
            <div class="col-lg-12 pnone" style="width: 65%;float: left;">

                <div class="panel panel-default InfoPopupDetails">
                    <div class="panel-heading">Project details
                        {if $smarty.session.role != "Read Only"}
                            <input class="btn btn-primary editBtn" type="button" id="edit" onclick="openEditProjectPanel('{$getProjectDetails['project_id']}', '{$pipeLineId}');" value="Edit"/>
                            <input class="btn btn-primary eastspace2 editBtn" type="button" id="log_activity" onclick="openLogActivityPrompt('{$getProjectDetails['project_id']}', '{$pipeLineId}', '{$levelIDForLog}');" value="Log Activity"/>
                        {/if}
                    </div>
                    <div class="panel-body " style="font-size: 11px;">
                        <div style="height: 175px;overflow-y:scroll;margin-bottom: 4px;">
                            <table id="editProject" class="table table-striped table-bordered">
                                <tbody>
                                    <tr>
                                        <td style="word-wrap: break-word;"><label>Name</label></td>
                                        <td style="word-wrap: break-word;">{$getProjectDetails['project_name']}</td>
                                        <td style="word-wrap: break-word;"><label>Person Responsible</label></td>
                                        <td style="word-wrap: break-word;">{$getProjectDetails['person_responsible']} </td>
                                        <td style="word-wrap: break-word;"><label>CTO SPOC</label></td>
                                        <td style="word-wrap: break-word;">{$getProjectDetails['cto_spoc']}</td>
                                    </tr>

                                    <tr>
                                        <td style="word-wrap: break-word;"><label>Area</label></td>
                                        <td style="word-wrap: break-word;">{$getProjectDetails['area']}</td>
                                        <td style="word-wrap: break-word;"><label>TAM</label></td>
                                        <td style="word-wrap: break-word;">{if $getProjectDetails['tam']!=''}{round($getProjectDetails['tam']/1000000,2)}{if $getProjectDetails['tam_currency']!='' ||$getProjectDetails['tam_currency']!=0}(m{$getProjectDetails['tam_currency']}){/if}{/if}</td>
                                        <td style="word-wrap: break-word;"><label>SAM</label></td>
                                        <td style="word-wrap: break-word;">{if $getProjectDetails['tam']!=''}{round($getProjectDetails['sam']/1000000,2)}{if $getProjectDetails['sam_currency']!='' ||$getProjectDetails['sam_currency']!=0}(m{$getProjectDetails['sam_currency']}){/if}{/if}</td>
                                    </tr>
                                    <tr>
                                        <td style="word-wrap: break-word;"><label>Current Level</label></td>
                                        <td style="word-wrap: break-word;">{$getProjectDetails['level_name']}
                                        </td>
                                        <td style="word-wrap: break-word;"><label>Date Created</label></td>
                                        <td style="word-wrap: break-word;">{$getProjectDetails['date_created']|date_format:"%m/%d/%Y"}</td>
                                        <td style="word-wrap: break-word;"><label>Visible To</label></td>
                                        <td style="word-wrap: break-word;">{$getProjectDetails['visible_to']}</td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>


                        {*<h5 class="subHead"> Gate Criteria:  business Relevance:</h5>*}
                        <div class="panel-heading"style="height: 27px;font-size: 11px;"> Gate Criteria:  business Relevance:</div>
                        <div style="height: 70px; overflow-y: scroll;">
                            {if !empty($getAssignedChecks)}
                                <ul class="gateInfo">
                                    {foreach $getAssignedChecks as $check}
                                        <li style="font-size: 11px;margin-top: 5px;">
                                            {$check.description}
                                        </li>
                                    {/foreach}
                                </ul>
                            {else}
                                &nbsp;&nbsp;No Checks Assigned currently
                            {/if}
                        </div>
                        <div class="panel-heading"style="height: 27px;font-size: 11px;">Activity Log</div>
                        <div style="height: 90px; overflow-y:scroll;" id="logActivityDiv">
                            <table class="table  table-striped">
                                <tbody>
                                    {foreach from=$comments item=log}
                                        <tr>
                                            <td id="userImageId" style="font-size: 11px; width: 35px;"><img src="{$siteimg}/user_image.png" style="width: 20px;height: 20px;"></td>
                                            <td>   Updated by <b>{$log.by_user}</b> at {$log.updated_on}: </br><b>{$log.comments}</b></td>
                                        </tr>
                                    {/foreach}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div style="width: 34%;float: right;">
                <div class="panel panel-default InfoPopupDetails">
                    <div class="panel-heading">Notes
                        <input class="btn btn-primary editBtn fr" style="display: none;" type="button" id="save_notes_btn" onclick="saveTextArea('{$getProjectDetails['project_id']}', '{$levelIDForLog}', '{$pipeLineId}');" value="Save"/>
                        {if $smarty.session.role != "Read Only"}
                            <input class="btn btn-primary editBtn fr" type="button" id="edit_notes_btn" onclick="enableTextArea();" value="Edit"/>
                        {/if}
                        <textarea style="width: 100%;font-size: 10px;"  rows="27" id="notes_text_area">{$getProjectDetails['notes']}
                        </textarea>
                    </div>

                </div>
            </div>
        </div>
        <div class="tab-pane" id="tab-2">
            {*{include $actionItemDetails}*}
        </div>
        <div class="tab-pane" id="tab-3">
            <table class="table table-bordered pretty">
                <thead>
                    <tr>
                        <td><b>Attachment Name</b></td>
                        <td><b>Download Link</b></td>
                    </tr>
                </thead>
                <tbody>
                    {foreach $getProjectDetails['upload_file_name'] as $filename}
                        {if $filename != ""}
                            <tr>
                                <td>{substr($filename,14)}</td>
                                <td><span class="fa fa-download eastspace2"></span><a href="{$siteroot}/uploads/{$filename}" download>download</a></td>
                            </tr>
                        {/if}
                    {/foreach}
                </tbody>
            </table>
        </div>
    </div>
</div>
{literal}
    <link rel="stylesheet" href="{/literal}{$sitecss}{literal}/jquery-ui.css">
    <script type="text/javascript">
                                $(function() {
                                    $("#date_created").datepicker({
                                        changeMonth: true,
                                        changeYear: true,
                                    });

                                });
                                $(document).ready(function() {
                                    $("#notes_text_area").prop("disabled", true);
                                });

    </script>
{/literal}
