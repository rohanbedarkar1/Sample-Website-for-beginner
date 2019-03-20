
<div class="modal-dialog TEST1" tabindex='-1'>

    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Available Checks</h4>
        </div>
        <form id="addProjectForm" method="post" action="{$siteroot}/checks/updateCheckListOfProject/">
            <div class="modal-body modal-body-2">
                {if !empty($getcheckList)}

                    <table class="table  table-bordered table-hover" id="createProject">
                        <tr>
                            <th class="col-sm-2 col-md-1">#</th>
                            <th class="col-sm-4 col-md-2">Check Name</th>
                            <th class="col-sm-6 col-md-7">Check Description</th>
                        </tr>
                        <tbody>
                            {foreach from=$getcheckList item=check}
                                <tr>
                                    <td class="col-sm-2 col-md-1">
                                        <div class="checkbox">
                                            <label><input type="checkbox" name="check[]" id="check" value="{$check.id}" {if $check.checked =='Yes'}checked=""{/if}></label>
                                        </div>
                                    </td>
                                    <td class="col-sm-4 col-md-2">
                                        {$check.name}
                                    </td>
                                    <td class="col-sm-6 col-md-7">
                                        {$check.description}
                                    </td>
                                </tr>
                            {/foreach}
                        </tbody>
                    </table>

                {elseif empty($getcheckList)&& empty($freeCheckList)}
                    <p>No checks available</p>
                {else}
                    <p>No checks available</p>
                {/if}
            </div>
            <div class="modal-footer">
                <input type="submit" class="btn btn-success" value="Save" id="submit" name="submit" />
                <input type="hidden" id="pipelineId" name="pipelineId" value="{$pipelineId}"/> 
                <input type="hidden" id="levelId" name="levelId" value="{$levelId}"/> 
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary pull-left" onclick="createChecklist('{$levelId}' ,'{$pipelineId}');"data-dismiss="modal">Create Check</button>
                <button type="button" class="btn btn-primary pull-left" onclick="deleteChecklist();">Delete Check</button>
            </div>
        </form>
    </div>
</div>
