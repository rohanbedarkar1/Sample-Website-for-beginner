{include $header1}
{include $header2}
{literal}
    <link rel="stylesheet" href="{/literal}{$sitecss}{literal}/facebox.css" type="text/css"/>
    <script src="{/literal}{$sitejs}{literal}/facebox.js"></script>
{/literal}

{include $sidepanel}

<div id="page-wrapper">
    {if isset($smarty.session.errMsg)}
        <div class="alert alert-danger alert-dismissable northspace2 col-xs-12 col-sm-12 col-md-12 col-lg-12" id="error">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
            {$smarty.session.errMsg}
        </div>
    {/if}

    {if isset($smarty.session.successMsg)}
        <div class="alert alert-success alert-dismissable  northspace2 col-xs-12 col-sm-12 col-md-12 col-lg-12" id="success">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
            {$smarty.session.successMsg}
        </div>
    {/if}
    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pnone northspace1">
                <h3 class="h3-head">Users & permissions</h3>
            </div> 
            <div id="tabs" class="tabsDisplay northspace2">
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#tab1" role="tab" data-toggle="tab">Users</a></li>
                    <li role="presentation"><a href="#tab2" role="tab" data-toggle="tab">Permissions</a></li>
                </ul>
                <div class="tab-content" id="tabContent">
                    <div  class="tab-pane active" id="tab1">
                        <section class="item-container">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pnone">
                                {*<h3 class="h3-head">Users & permissions</h3>*}
                                <div class="btn-group pull-left groupBtn northspace1" role="group">
                                    <button type="button" class="btn btn-default btn-xs">Activated</button>
                                    <button type="button" class="btn btn-default btn-xs">Deactivated</button>
                                </div>
                                <div class="btn-group pull-right groupBtn" role="group">
                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-keyboard="true" data-target="#addNewUser"><i class="fa fa-plus"></i>Add Users</button>
                                </div>
                            </div>
                            <div class="userblock">
                                {include $userDisplayTable}
                            </div>
                        </section>
                    </div>
                    <div  class="tab-pane" id="tab2">
                        <section class="item-container card-content">
                            <article class="gridRow">
                                <div class="col-xs-12 col-sm-6">
                                    <p class="mainTitle">The default visibility for all deals added to the system is</p>
                                </div>
                                <div class="col-xs-12 col-sm-6">
                                    <div class="btn-group pull-right groupBtn northspace1" role="group">
                                        <button type="button" class="btn btn-default btn-sm">Owner & followers</button>
                                        <button type="button" class="btn btn-default btn-sm">Entire company</button>
                                    </div>
                                </div>
                            </article>
                            <article class="gridRow">
                                <div class="col-xs-12 col-sm-6">
                                    <p class="mainTitle">Regular users can edit deals won/lost date </p>
                                </div>
                                <div class="col-xs-12 col-sm-6">
                                    <div class="btn-group pull-right groupBtn northspace1" role="group">
                                        <button type="button" class="btn btn-default btn-sm">Owner & followers</button>
                                        <button type="button" class="btn btn-default btn-sm">Entire company</button>
                                    </div>
                                </div>
                            </article>
                            <article class="gridRow">
                                <div class="col-xs-12 col-sm-6">
                                    <p class="mainTitle">The default visibility for all organizations added to the system is</p>
                                </div>
                                <div class="col-xs-12 col-sm-6">
                                    <div class="btn-group pull-right groupBtn northspace1" role="group">
                                        <button type="button" class="btn btn-default btn-sm">Owner & followers</button>
                                        <button type="button" class="btn btn-default btn-sm">Entire company</button>
                                    </div>
                                </div>
                            </article>
                            <article class="gridRow">
                                <div class="col-xs-12 col-sm-6">
                                    <p class="mainTitle">Regular users can delete deals </p>
                                </div>
                                <div class="col-xs-12 col-sm-6">
                                    <div class="btn-group pull-right groupBtn northspace1" role="group">
                                        <button type="button" class="btn btn-default btn-sm BtnyesNo">Yes</button>
                                        <button type="button" class="btn btn-default btn-sm BtnyesNo">No</button>
                                    </div>
                                </div>
                            </article>
                        </section>
                    </div>
                </div> 
            </div>

            <!-- Modal -->
            <div id="addNewUser" tabindex='-1' class="modal" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <form method="post" name="addnewuserForm" id="addnewuserForm">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Add New User<i class="fa fa-user fa-fw"></i></h4>
                            </div>
                            <div class="modal-body">
                                <div class="inputBlock">
                                    <label class="col-xs-12 col-sm-4 col-lg-3 northspace1 pnone">User Id</label>
                                    <div class="col-xs-12 col-sm-8 col-lg-9 pnone">
                                        <input type="text" class="form-control" id="userId" name="userId" placeholder="User Id" autofocus=""/>
                                    </div>
                                </div>
                                {*<div class="inputBlock">
                                <label class="col-xs-12 col-sm-4 col-lg-3 northspace1 pnone">Username</label>
                                <div class="col-xs-12 col-sm-8 col-lg-9 pnone">
                                <input type="text" class="form-control" id="userName" name="userName" placeholder="Username"/>
                                </div>
                                </div>*}
                                {*<div class="inputBlock">
                                <label class="col-xs-12 col-sm-4 col-lg-3 northspace1 pnone">Full Name</label>
                                <div class="col-xs-12 col-sm-8 col-lg-9 pnone">
                                <input type="text" class="form-control" id="firstName" name="fullName" placeholder="Full Name"/>
                                </div> 
                                </div>*}

                                <div class="inputBlock" >
                                    <label class="col-xs-12 col-sm-4 col-lg-3 northspace1 pnone">User Group</label>
                                    <div class="col-xs-12 col-sm-4 col-lg-3 northspace1 pnone">
                                        <select id="roleId" name="roleId" class="form-control">
                                            {foreach $getAllRoles as $roles}
                                                <option value="{$roles.id}">{$roles.role_name}</option>
                                            {/foreach}
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary" id="submit" name="submit" value="submit">Save</button>

                            </div>
                        </form>
                    </div>
                </div>
            </div>


            <!-- Modal Edit User -->
            <div id="editUser" tabindex='-1' class="modal" role="dialog">

            </div>

        </div>  
    </div> 


</div>             
{literal}
    <script type="text/javascript">
        $(document).ready(function() {
            $("#success").delay(5000).fadeOut();
            $("#error").delay(5000).fadeOut();

            $("#addnewuserForm").validate({
                errorElement: 'div',
                rules: {
                    userId: {
                        required: true
                    },
                    roleId: {
                        required: true
                    }
                },
                messages: {
                    userId: {
                        required: "Please enter user id (KPID)"
                    },
                    roleId: {
                        required: "Please select role"
                    }
                }
            });
        });




    </script>
{/literal}
{include $footer}