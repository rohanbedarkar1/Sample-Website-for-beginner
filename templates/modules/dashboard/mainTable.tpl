{*{$smarty.session|print_r}*}
<div class="showcase" >
    <div class="board content horizontal-images light" >
        <input type="hidden" id="pipeId" name="pipeId" value="{$pipeId}" />
        {if !empty($headerDetails)}
            {foreach from=$headerDetails item=data key=h}
                <section  class="stagesBody">
                    <header>
                        <div class="block-row" >
                            <div class="arrowDrive">
                                <h4 class="head" data-toggle="tooltip" title="{$data.level_name}">{$data.level_name}</h4>
                            </div>
                        </div>    
                    </header>

                    {* <span class="arrow-up1"></span>*}
                    <main class="createStages content customScroll" >

                        {foreach $projectDetails.{$data.level_id} as $projects}
                            {if $projects.project_id !=''}
                                <div class="move-btn">
                                {if $projects.count > 0}
                                	 <div class="col-deal filters" id="{$projects.project_id}" style="background-color: #47d147;">
                                    {elseif $projects.latest_activity > $projects.validity}
                                        <div class="col-deal filters" id="{$projects.project_id}" style="background-color: #eb615b;">
                                        {else}
                                            <div class="col-deal filters" id="{$projects.project_id}" >
                                            {/if}
                                            <div class="pipeDrive" >

                                                <div class="info-details" >
                                                    <h3 class="proName" data-toggle="tooltip" title="{$projects.project_name}" id="projectName{$projects.project_id}">{$projects.project_name}</h3>
                                                    <button class="editform custombutton fa fa-pencil-square-o" onclick="viewProjectInfo('{$projects.project_id}', '{$projects.pipe_id}', '{$data.level_id}');"></button> 
                                                    <span class="val-1" data-toggle="tooltip" title="{$projects.area} {if $projects.area != ''}-{/if} {if $projects.tam !=''}{round($projects.tam/1000000,2)}  (m{$projects.tam_currency}){/if} {if $projects.tam !=''}-{/if} {$projects.person_responsible}">
                                            {$projects.area|truncate:15:"...":true} {if $projects.area != ''}-{/if} {if $projects.tam !=''}{round($projects.tam/1000000,2)}  (m{$projects.tam_currency}){/if} {if $projects.tam !=''}-{/if} {$projects.person_responsible|truncate:10}</span> 
                                    </div>
                                    <div class="btn-status">
                                        <div class="col-xs-8 pnone">
                                            {if $isActive=='1'}
                                                {if $smarty.session.role =='Admin' || $smarty.session.role =='Manager'}
                                                    {foreach from=$projects.value item=status key=k}

                                                        {if $status == 'Complete'}
                                                            <button id="checkIdGroup_{$projects.project_id}_{$projects.check_id.$k}" class=" custombutton square square-active t-button" onmouseover="displayCheckDetails('{$projects.check_id.$k}', '{$projects.project_id}');" onclick="viewAndEditCheckIdOfProject('{$projects.check_id.$k}', '{$projects.project_id}', '{$projects.pipe_id}');"><i class="fa fa-square"></i></button>
                                                            {elseif $status == 'Incomplete'}
                                                            <button id="checkIdGroup_{$projects.project_id}_{$projects.check_id.$k}" class="custombutton square square-pending t-button" onmouseover="displayCheckDetails('{$projects.check_id.$k}', '{$projects.project_id}');" onclick="viewAndEditCheckIdOfProject('{$projects.check_id.$k}', '{$projects.project_id}', '{$projects.pipe_id}');"  ><i class="fa fa-square"></i></button>
                                                            {elseif $projects.check_id.$k != ''}
                                                            <button id="checkIdGroup_{$projects.project_id}_{$projects.check_id.$k}" class=" custombutton square square-default t-button" onmouseover="displayCheckDetails('{$projects.check_id.$k}', '{$projects.project_id}');" onclick="viewAndEditCheckIdOfProject('{$projects.check_id.$k}', '{$projects.project_id}', '{$projects.pipe_id}');" ><i class="fa fa-square"></i></button>
                                                            {/if}

                                                    {/foreach}
                                                {/if}
                                            {/if}
                                        </div>
                                        <div class="pull-right">
                                            {if $deletedDeal == false}
                                                {if $promoteStatus === false}
                                                    {if $projects.hasNextLevel === true} 
                                                        <button type="button" 
                                                                {if $projects.canPromote === true} 
                                                                    class="btn btn-primary btn-xs btn-promt" 
                                                                {else}
                                                                    class="btn btn-primary btn-xs btn-promt btn-promt-disable" disabled="disabled"
                                                                {/if}
                                                                onclick="promoteLevel('{$projects.project_id}', '{$projects.level_id}', '{$projects.pipe_id}', 'projectName{$projects.project_id}', '{$projects.updated_on}', '{$projects.fifteenDaysBefore_updated_on}');">
                                                            Promote
                                                        </button>
                                                    {/if}
                                                {else}
                                                {/if}
                                            {else}
                                                <button type="button" 
                                                        {if $smarty.session.role =='Admin'}
                                                            class="btn btn-primary btn-xs btn-promt"
                                                        {else}
                                                            class="btn btn-primary btn-xs btn-promt btn-promt-disable" disabled="disabled"
                                                        {/if}   
                                                        onclick="restoreProject('{$projects.project_id}', '{$projects.level_id}')">
                                                    Restore
                                                </button>
                                            {/if}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    {/if}   
                {/foreach}
        </main>
    </section>
{/foreach}  
{else}
    <label class="customLabel" >No Stages available currently </label> 
{/if}
</div>
</div>
<input type="hidden" id="dataAvailable" name="dataAvailable" value="{$dataAvailable}" />
<input type="hidden" id="getCheckDetails" name="getCheckDetails" value='{$getCheckDetails}' />
{include $createProjectPopup}
{include $createActionPopUp}
{if $deletedDeal == false}
    {if $smarty.session.role != "Read Only"}
        {literal}
            <script src="{/literal}{$sitejs}{literal}/dragProjects.js"></script>
        {/literal}
    {/if}
{/if}