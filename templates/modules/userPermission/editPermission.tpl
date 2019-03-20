<div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Edit Permission for {$getUserDetail['full_name']}</h4>
        </div>
        <form method="post" action="{$siteroot}/userPermission/editPermission/">
            <div class="modal-body">
                <div class="inputBlock">

                    <label class="col-xs-12 col-sm-4 col-lg-3 northspace1 pnone">Role Status</label>
                    <div class="col-xs-12 col-sm-8 col-lg-9 pnone">
                        <select id="roleId" name="roleId" class="form-control">
                            {foreach $getAllRoles as $roles}
                                <option value="{$roles.id}" {if $getUserDetail['id']== $roles.id}selected=""{/if}>{$roles.role_name}</option>
                            {/foreach}
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" id="submit" name="submit" value="submit" class="btn btn-primary" >Submit</button>
                <input type="hidden" id="userId" name="userId" value="{$getUserDetail['user_id']}" />
            </div>
        </form>
    </div>

</div>