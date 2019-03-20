<div class="navbar-default sidebar sidebar-nav navbar-collapse pnone" role="navigation" id="sidebar_display">
    <ul class="nav" id="side-menu">
        <!-- /.navbar-static-side -->
        <li>
            <a href="{$siteroot}/settings/setting/"> Pipelines</a>
        </li>
        {if $smarty.session.role == "Admin"}
            <li>
                <a href="{$siteroot}/userPermission/userPermissions/">Users & permissions</a>
            </li>
        {/if}
        {*
        <li>
        <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Accounts<span class="fa arrow"></span></a>
        <ul class="nav nav-second-level">
           
        <li>
        <a href="" >test</a>
        </li>

        </ul>
        </li>*}

    </ul>

    <!-- /.sidebar-collapse -->
</div>
