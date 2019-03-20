{literal}
    <link rel="stylesheet" href="{/literal}{$sitecss}{literal}/jquery-ui.css">
    <script type="text/javascript">
        $(function() {
            $("#actionStartDate").datepicker({
                changeMonth: true,
                changeYear: true,
            });
            $("#actionDueDate").datepicker({
                changeMonth: true,
                changeYear: true,
            });

        });
    </script>
{/literal}
<div class="modal fade" id="addActionModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Create Action Item</h4>
            </div>
            <div id="viewBody">
                <div class="modal-body">
                    <form id="addActionForm" method="POST" action="{$siteroot}/redmine/createActionItem" onSubmit="return checkForDateValidation();">
                        <table class="table">
                            <tbody>
                                <tr><label >Subject</label></tr>
                            <tr><textarea class="form-control" id="action_subject" name="action_subject" style="width: 100%"></textarea></tr>
                            <tr><label >Description</label></tr>
                            <tr><textarea class="form-control" id="action_description" name="action_description" style="width: 100%"></textarea></tr>
                            <tr><label >Assignee</label></tr>
                            <tr>
                            <select class="form-control" id="action_assignee" name="action_assignee">
                                {foreach from=$redmine_assignee key=index item=data}
                                    <option value="{$data.user.id}">{$data.user.name}</option>
                                {/foreach}
                            </select>
                            <tr><label >Priority</label></tr>
                            <tr>
                            <select class="form-control" id="action_priority" name="action_priority">
                                <option value="1">Low</option>
                                <option value="2">Normal</option>
                                <option value="3">High</option>
                                <option value="4">Urgent</option>
                                <option value="5">Immediate</option>
                            </select>
                            </tr>
                            <tr>
                                <td>
                                    <label >Start Date</label>
                                    <input type="text" class="form-control" id="actionStartDate" name="actionStartDate" value="{$smarty.now|date_format:"%m/%d/%Y"}"/>
                                </td>
                                <td>
                                    <label >Due Date</label>
                                    <input type="text" style="margin-left: 3px;"class="form-control" id="actionDueDate" name="actionDueDate"/>
                                </td></tr>
                            <tr><td><label >Comments</label></td></tr>
                            <tr>
                                <td><textarea id="actionItemComments" name="actionItemComments" cols="63" rows="3"></textarea></td>
                                <td><input type="submit" class="btn btn-primary fr" style="margin-top: 35px;" value="Create Action Item"/></td>
                            </tr>
                            </tbody>
                        </table>
                            <input type="hidden" value="0" name="project_id" />
                            <input type="hidden" value="Global" name="project_name" />
                    </form>
                </div>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
