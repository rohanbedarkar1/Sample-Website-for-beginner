<div style="height: 470px; overflow-y:scroll;">
    <div id="accordin" style="margin-top: 8px;margin-bottom: 8px;">
        <div class="panel-heading skyBlueBg" id="collapse-header">
            <h4 class="panel-title">
                <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false">
                    <span class="glyphicon glyphicon-plus icons-col accIcon"></span>
                    <span>Create Action Item</span>
                </a>
            </h4>
        </div>
        {if $smarty.session.role != "Read Only"}
            <div id="collapseOne" class="panel-collapse collapse">
                <div class="panel-body">
                    <div class="col-lg-12 col-md-12 col-sm-12 collapseTbl">
                        <form id="addActionForm" >
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td>
                                            <label >Subject</label>
                                            <textarea class="form-control" id="popup_subject"></textarea>
                                        </td>
                                        <td>
                                            <label >Description</label>
                                            <textarea class="form-control" id="popup_description" style="width: 655px;"></textarea>
                                        </td>
                                        <td>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label >Assignee</label>
                                            <select class="form-control" id="popup_assignee" name="action_assignee">
                                                {foreach from=$redmine_assignee key=index item=data}
                                                    <option value="{$data.user.id}">{$data.user.name}</option>
                                                {/foreach}
                                            </select>

                                            <label >Priority</label>
                                            <select class="form-control" id="popup_priority">
                                                <option value="1">Low</option>
                                                <option value="2">Normal</option>
                                                <option value="3">High</option>
                                                <option value="4">Urgent</option>
                                                <option value="5">Immediate</option>
                                            </select>
                                        </td>
                                        <td>
                                            <label >Start Date</label>
                                            <input type="text" class="form-control" id="actionTabStartDate"  value="{$smarty.now|date_format:"%m/%d/%Y"}"/>
                                            <label >Due Date</label>
                                            <input type="text" style="margin-left: 3px;"class="form-control" id="actionTabDueDate"/>
                                        </td>
                                        <td>
                                            <label >Comments</label>
                                            <textarea id="actionItemComments" cols="50" rows="4"></textarea>
                                        </td>
                                    </tr>

                                    {*<tr>
                                    <td><input type="button" class="btn btn-primary fr" style="margin-top: 35px;" value="Create Action Item"/></td>
                                    </tr>*}
                                </tbody>
                            </table>
                            <input type="button" value="Create Action Item" class="btn btn-primary center" onclick="submitActionItem();" style="margin-bottom: 3px;margin-left: 8px;"/>
                            <input type="hidden" value="{$getProjectDetailsAction['project_id']}" id="stage_id"/>
                            <input type="hidden" value="{$getProjectDetailsAction['project_name']}" id="stage_name"/>
                            <input type="hidden" value="{$getProjectDetailsAction['type_id']}" id="pipeLineId"/>
                            <input type="hidden" value="{$getProjectDetailsAction['level_id']}" id="levelId"/>
                        </form>
                    </div>
                </div>
            </div>
        {/if}
    </div>
    <div>
        {include $viewActionPopupTable}
    </div>
</div>
{*<script src="{$sitejs}/jquery.accordion-live-filter.js"></script>*}
<script>


                            $('.collapse').on('shown.bs.collapse', function() {

                                $(this).parent().find(".glyphicon-plus").removeClass("glyphicon-plus").addClass("glyphicon-minus");
                            }).on('hidden.bs.collapse', function() {
                                $(this).parent().find(".glyphicon-minus").removeClass("glyphicon-minus").addClass("glyphicon-plus");
                            });

                            $(function() {
                                $("#actionTabStartDate").datepicker({
                                    changeMonth: true,
                                    changeYear: true,
                                });
                                $("#actionTabDueDate").datepicker({
                                    changeMonth: true,
                                    changeYear: true,
                                });

                            });
</script>