{literal}
    <link rel="stylesheet" href="{/literal}{$sitecss}{literal}/jquery-ui.css">
    <script type="text/javascript">
        $(function() {
            $("#edit_date_created").datepicker({
                changeMonth: true,
                changeYear: true,
            });

        });

        function getAmountFormatTAM() {
            $('#edit_tam').priceFormat();
        }
        function getAmountFormatSAM() {
            $('#edit_sam').priceFormat();
        }

        $("#edit_person_responsible").on('keypress', function() {
            autoSuggestPerson('edit_person_responsible');
        });
        $("#edit_cto_spoc").on('keypress', function() {
            autoSuggestPerson('edit_cto_spoc');
        });
        function setFiledNames(id) {
            var fieldValue = $("#" + id).val();
            var res = fieldValue.split("<");
            $("#" + id).val(res[0]);
            $("#" + id + "_email").val(res[1]);
        }
    </script>
{/literal}
<div class="col-lg-12" style="width:100%;">
    <div class="panel panel-default ">
        <div class="panel-heading skyBlueBg">
            Edit Project details for: {$getProjectDetails['project_name']}
        </div> 
        <div class="panel-body ">
            <form id="editProjectDetails" enctype="multipart/form-data">
                <table id="editProject" class="table table-striped table-bordered">
                    <tbody>
                        <tr>
                            <td><label>Project Name</label></td>
                            <td><input type="text" id="edit_project_name" name="Project Name" onchange="logStatementOnChange('edit_project_name');" class="form-control" value="{$getProjectDetails['project_name']}" /></td>
                            <td><label>Person Responsible</label></td>
                            <td><input type="text" id="edit_person_responsible" name="Person Responsible" class="form-control" onblur="setFiledNames('edit_person_responsible')" value="{$getProjectDetails['person_responsible']}" />
                                <input type="hidden" name="edit_person_responsible_email" id="edit_person_responsible_email" value="{$getProjectDetails['person_responsible_mail']}" /></td>
                        </tr>
                        <tr>
                            <td><label>CTO SPOC</label></td>
                            <td><input type="text" id="edit_cto_spoc" name="CTO SPOC" class="form-control" onblur="setFiledNames('edit_cto_spoc')" value="{$getProjectDetails['cto_spoc']}"/>
                                <input type="hidden" name="edit_cto_spoc_email" id="edit_cto_spoc_email" value="{$getProjectDetails['cto_spoc_mail']}" /></td>
                            <td><label>Area</label></td>
                            <td><input type="text" id="edit_area" name="Area" onchange="logStatementOnChange('edit_area');" class="form-control" value="{$getProjectDetails['area']}" /></td>
                        </tr>
                        <tr>
                            <td><label>TAM</label></td>
                            <td>
                                <div class="row">
                                    <div class="col-sm-7">
                                        <input type="text" id="edit_tam" name="TAM" class="form-control" onblur="logStatementOnChange('edit_tam');" onkeyup="getAmountFormatTAM();" value="{$getProjectDetails['tam']}" />
                                    </div>
                                    <div class="col-sm-5">
                                        <select id="edit_tam_currency" name="edit_tam_currency" class="form-control" onchange="changeCurrency(this.value);">
                                            <option value="INR" {if $getProjectDetails['tam_currency'] =="INR"}selected=""{/if} >INR</option>
                                            <option value="USD" {if $getProjectDetails['tam_currency'] =="USD"}selected=""{/if}>USD</option>
                                        </select> 
                                    </div>
                                </div>
                            </td>
                            <td><label>SAM</label></td>
                            <td>
                                <div class="form-group">
                                    <div class="input-group" >
                                        <input type="text" id="edit_sam" name="SAM" class="form-control" onblur="logStatementOnChange('edit_sam');" onkeyup="getAmountFormatSAM();" value="{$getProjectDetails['sam']}" />
                                        <div class="input-group-addon">
                                            <input type="hidden" id="edit_sam_currency" name="edit_sam_currency" {if  isset({$getProjectDetails['sam_currency']})} value="{$getProjectDetails['sam_currency']}" {else}value="INR"{/if} />
                                            <label id="editSamCurrencyLabel" >{if  isset({$getProjectDetails['sam_currency']}) && ({$getProjectDetails['sam_currency']}!='')} {$getProjectDetails['sam_currency']} {else}INR{/if}</label>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><label>Current Level</label></td>
                            <td>
                                <select id="edit_level_id" name="Current Level" onchange="logStatementOnChange('edit_level_id');" class="form-control">
                                    {foreach $levels as $level}
                                        {if $level!=''}
                                            <option value="{$level.level_id}" {if $level.level_name ==$getProjectDetails['level_name']}selected=""{/if}>{$level.level_name}</option>
                                        {/if}
                                    {/foreach}
                                </select>
                            </td>
                            <td><label>Date Created</label></td>
                            <td><input type="text" id="edit_date_created" name="Date Created" onchange="logStatementOnChange('edit_date_created');" class="form-control" value="{$getProjectDetails['date_created']|date_format:"%m/%d/%Y"}" /></td>
                        </tr>
                        <tr>
                            <td><label>Visible To</label></td>
                            <td>
                                <select id="visibility" name="Visible To" class=" form-control" disabled="">
                                    <option value="You" {if $getProjectDetails['visible_to']=='You'}selected=""{/if}>You</option>
                                    <option value="Followers" {if $getProjectDetails['visible_to'] =='Followers'}selected=""{/if}>Followers</option>
                                    <option value="Everyone" {if $getProjectDetails['visible_to'] =='Everyone'}selected=""{/if}>Everyone</option>
                                </select>
                                <input type="hidden" name="edit_visible_to" id="edit_visible_to" onchange="logStatementOnChange('edit_visible_to');" value="{$getProjectDetails['visible_to']}" />
                            </td>
                            <td><label>Attachment</label></td>
                            <td>
                                <input type="file" class="form-control" name="ideaAttachment" id="ideaAttachment" onchange="logStatementOnChange('ideaAttachment')" />
                            </td>
                        </tr>
                    </tbody>
                </table>
                <input type="hidden" id="edit_project_id" name="edit_project_id" value="{$getProjectDetails['project_id']}" />
                <input type="hidden" id="edit_pipeLineId" name="edit_pipeLineId" value="{$pipeLineId}" />
                <input type="button" class="btn btn-primary" id="submitDetail" name="submitDetail" value="Submit" onclick="updateProjectDetails();"/>
            </form>
        </div>
    </div>
</div>
