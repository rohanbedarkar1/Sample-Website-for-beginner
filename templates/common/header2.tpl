<!-- Navigation -->
<nav class="navbar navbar-default navbar-fixed-top header" role="navigation" style="margin-bottom: 0;">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="{$siteroot}"><img src="{$siteimg}/logo.png" alt="logo" style="margin-top: -6px; "/></a>
    </div>
    <!-- /.navbar-header -->

    {if isset($smarty.session.username)}
        <ul class="nav navbar-top-links navbar-right">
            <li class="dropdown">Welcome {if isset($smarty.session.first_name)}{$smarty.session.first_name} {else} {$smarty.session.username} {/if}</li>
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);">
                    <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                </a>
                <ul class="dropdown-menu dropdown-user">
                    
                    {if $smarty.session.role =='Admin'} 
                        <li>
                            <a href="{$siteroot}/settings/setting/"><i class="fa fa-cog fa-fw"></i> Settings</a>
                        </li>
                    {/if}
                    <li>
                        <a href="{$siteroot}/report/report/"><i class="fa fa-bar-chart-o"></i>&nbsp; Report</a>
                    </li>
                    <li>
                        <a href="{$siteroot}/login/logout/"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                    </li>
                </ul>
                <!-- /.dropdown-user -->
            </li>
            <!-- /.dropdown -->
        </ul>


    {/if}      
    <div class="fr northspace2  strong" style="font-size: 18px">STAGES &nbsp;</div>


</nav>
