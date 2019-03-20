<form id="addProjectForm">
    <table class="table table-bordered table-hover userPermitTble" id="createProject">
        <thead>
        <th>Name</th>
        <th>Role</th>
        <th>Last Action</th>
        </thead>
        <tbody>
            {foreach $getUsers as $user}
                <tr class="overUserBlock">
                    <td class="col-sm-2 col-md-1">
                        <i class="fa fa-user fa-fw"></i>{$user.full_name}
                    </td>
                    <td class="col-sm-4 col-md-4">
                        {$user.role_name}
                    </td>
                    <td class="col-sm-6 col-md-7">
                        6 hours ago
                        <div class="btn-group groupBtn overbtn " role="group">
                            <button type="button" class="btn btn-default btn-xs" onclick="editPermission('{$user.id}', '{$user.user_id}');"><i class="fa fa-pencil"></i>Edit</button>
                            <button type="button" class="btn btn-default btn-xs" onclick="deletePermission('{$user.id}', '{$user.user_id}');"><i class="fa fa-close"></i>Delete</button>
                        </div>
                    </td>
                </tr>
            {/foreach}
        </tbody>
    </table>
</form>