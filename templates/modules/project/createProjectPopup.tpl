
<div class="modal fade" id="addProjectModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <script>
                    function getType(val) {
                        var pipeType = val;
                        document.getElementById('myModalLabel').innerHTML = "Create New " + pipeType + " Idea";

                    }
                </script>
                <h4 class="modal-title" id="myModalLabel"></h4>
            </div>
            <div id="viewBody">
                <div class="modal-body">
                    <div class="dataTable_wrapper">
                        <form id="addProjectForm" enctype="multipart/form-data">
                            <table class="table table-striped table-bordered table-hover" id="createProject">
                                <tbody>
                                    <tr>
                                        <td>
                                            <label> Project Name</label>
                                        </td>
                                        <td><input type="text" class="form-control" id="projectName" name="projectName"/></td>
                                    </tr>
                                    <tr>
                                        <td><label> Person Responsible</label> </td>
                                        <td>
                                            <input type="text" class="form-control" id="personResponsible" name="personResponsible" onblur="setFiledNames('personResponsible');" onkeypress="autoSuggestPerson('personResponsible');" />
                                            <input type="hidden" name="personResponsible_email" id="personResponsible_email"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label>CTO SPOC</label></td>
                                        <td><input type="text" class="form-control" id="ctoSpoc" name="ctoSpoc" onblur="setFiledNames('ctoSpoc')" onkeypress="autoSuggestPerson('ctoSpoc');"/>
                                            <input type="hidden" name="ctoSpoc_email" id="ctoSpoc_email"/>
                                        </td>

                                    </tr>
                                    <tr>
                                        <td><label>Area</label></td>
                                        <td><input type="text" class="form-control" id="area" name="area" /></td>
                                    </tr>
                                    <tr>
                                        <td><label>TAM </label></td>
                                        <td>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control" id="tam" onkeyup="getAmountFormatTAM();" name="tam" />
                                                </div>
                                                <div class="col-sm-6">
                                                    <select id="tamCurrency" name="tamCurrency" class="form-control" onchange="updateSAMCurrency();">
                                                        <option value="INR">INR</option>
                                                        <option value="USD">USD</option>
                                                    </select>   
                                                </div>
                                            </div>      
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label>SAM </label></td>
                                        <td>
                                            <div class="form-group">

                                                <div class="input-group" >
                                                    <input type="text" class="form-control" id="sam" onkeyup="getAmountFormatSAM();" name="sam" />
                                                    <div class="input-group-addon">
                                                        <input type="hidden" id="samCurrency" name="samCurrency" value="INR" />
                                                        <label id="samCurrencyLabel" >INR</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label>Current level</label></td>
                                        <td>
                                            <select id="levelId" name="levelId" class="form-control" {if $promoteStatus === false}disabled=""{/if}>

                                                {foreach $getPipeLine as $pipe}
                                                    {if $pipe.pipeId == $pipeId}
                                                        {if $promoteStatus === false}
                                                            <option value="{$pipe.firstLevelId}">{$pipe.firstLevel}</option>
                                                            <input type="hidden" name="levelId" id="levelId" value="{$pipe.firstLevelId}" />
                                                        {else}
                                                            {foreach $pipe.level_id as $index => $data }
                                                            <option value="{$data}">{$pipe.levels[$index]}</option>
                                                            {/foreach}
                                                        {/if}
                                                    {/if}
                                                {/foreach}
                                            </select>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label>Visible To</label></td>
                                        <td>
                                            <select id="visibleTo" name="visibleTo" class=" form-control" disabled="">
                                                <option value="Everyone">Everyone</option>
                                                <option value="You">You</option>
                                                <option value="Followers">Followers</option>
                                            </select>
                                            <input type="hidden" name="visibleTo" id="visibleTo" value="Everyone" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label>Attachment</label></td>
                                        <td>
                                            <input type="file" class="form-control" name="ideaAttachment" id="ideaAttachment" />
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <input type="hidden" id="pipelineId" name="pipelineId" value="" />
                        </form>
                    </div>
                    <div class="modal-footer pnone northspace1 padnorth1">
                        <button type="submit" class="btn btn-primary" data-dismiss="modal" id="modal-close-submit" onclick="createProject();">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{literal}
    <script type="text/javascript">
                    $("#dateCreated").datepicker({
                    });
                    function getAmountFormatTAM() {
                        $('#tam').priceFormat();
                    }
                    function getAmountFormatSAM() {
                        $('#sam').priceFormat();
                    }
                    function setFiledNames(id) {
                        var fieldValue = $("#" + id).val();
                        var res = fieldValue.split("<");
                        $("#" + id).val(res[0]);
                        $("#" + id + "_email").val(res[1]);
                    }
    </script>
{/literal}