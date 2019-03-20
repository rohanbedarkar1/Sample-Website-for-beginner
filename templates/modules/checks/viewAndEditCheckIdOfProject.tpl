<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Edit Check Id for: {if isset($chkData['project_name'])}{$chkData['project_name']}{else}No project found{/if}</h4>
        </div>
        <div class="modal-body">
            <div class="form-group southspace1">
                <form id="editCheckIdOfProject" class="form-inline  pull-right text-left" method="post" action="{$siteroot}/project/updateCheckId/">
                    <table class="table table-bordered edirCheckBlock">
                        <tbody>
                            <tr>
                                <td>
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pnone">
                                        <b>{$chkData['name']}</b>
                                        <b>[</b> {$chkData['description']} <b>]</b>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="pull-left">
                                        <label class="northspace1">Check : </label>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                        <select class="form-control popoverSelect" id="chkIdValue" name="chkIdValue" required=""> 
                                            <option value="" >--Select--</option>
                                            <option value="Complete" {if $chkData['value'] =='Complete'}selected=""{/if}>Complete</option> 
                                            <option value="Incomplete" {if $chkData['value'] =='Incomplete'}selected=""{/if}>Incomplete</option>
                                        </select>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <input type="hidden" value="{$pipeId}" id="pipeId" name="pipeId" />
                    <input type="hidden" value="{$chkData['proj_id']}" id="proj_id" name="proj_id" />
                    <input type="hidden" value="{$chkData['name']}" id="check_name" name="check_name" />
                    <input type="hidden" value="{$chkData['level_id']}" id="level_id" name="level_id" />
                    <input type="hidden" value="{$chkData['check_id']}" id="check_id" name="check_id" />
                    <input type="hidden" value="{$chkData['project_name']}" id="project_name" name="project_name" />
                    <button type="button" class="btn btn-primary pull-right northspace1" id="chgCkIdBtn" name="chgCkIdBtn" onclick="updateCheckIdofProject();">Submit</button>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal content-->
</div>
