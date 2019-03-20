{include $header1}
{include $header2}
{literal}
    <script type="text/javascript">
        $(document).ready(function() {
            $("#login").validate({
                errorElement: 'div',
                rules: {
                    username: {
                        required: true
                    },
                    password: {
                        required: true
                    }
                },
                messages: {
                    username: {
                        required: "Please enter username"
                    },
                    password: {
                        required: "Please enter password"
                    }
                }
            });
        });
    </script>
{/literal}

<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="login-panel panel panel-default">
                <div class="panel-heading bgBlue">
                    <h3 class="panel-title">Please Log In</h3>
                </div>
                <div class="panel-body">
                    {if isset($smarty.session.errMsg)}
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            {$smarty.session.errMsg}
                        </div>
                    {/if}
                    <form role="form" name="login" id="login" action="{$siteroot}/login/loginproc" method="post">
                        <fieldset>
                            <div class="form-group">
                                <input class="form-control" placeholder="User Name" name="username" type="text" autofocus>
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Password" name="password" type="password" value="">
                            </div>
                            <input type="hidden" value="{$dbName}" name="dbName">
                            <input type="hidden" value="{$app}" name="app">
                            <input type="hidden" value="{$redmine_project_id}" name="redmine_project_id">
                            <!--
                            <div class="checkbox">
                                <label>
                                    <input name="remember" type="checkbox" value="Remember Me">Remember Me
                                </label>
                            </div> -->
                            <!-- Change this to a button or input when using this as a form -->
                            <input type="submit" class="btn btn-lg  btn-block bgGray" value="Login">
                        </fieldset>
                    </form>
{*                    <div class="centerAll red smlTxt">*Refresh your browser before login (Press Ctrl+F5)</div>*}
                </div>
            </div>
        </div>
    </div>
</div>
{include $footer}


