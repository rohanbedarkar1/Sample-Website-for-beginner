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
                <button class="btn btn-info btn-md pull-left"   type="button" data-toggle="modal" data-keyboard="true" data-target="#addNewPipeline"><i class="fa fa-plus"></i> Add New Pipeline</button>
            </div> 
            <div id="settingBody">
                <div id="pipeLineTabs" >
                    {if !empty($getPipelineNames)}
                        {include $pipeLineTabs}
                    {else}
                        <div>
                            No Pipelines currently available
                        </div>
                    {/if}
                </div>
               
                {include $createChecks}
                {include $createNewPipeLine}
                {include $createStage}
            </div>
			 <div id="checkListModal" class="modal" role="dialog"  tabindex='-1'>
                    <!--List of all checks will be displayed here-->
                </div>
        </div>  
    </div> 
</div> 
{literal}
    <script src="{/literal}{$sitejs}{literal}/setting.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $("#success").delay(5000).fadeOut();
            $("#error").delay(5000).fadeOut();
        });
    </script>
{/literal}
{include $footer}