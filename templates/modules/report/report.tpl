
{include $header1}
{include $header2}
{literal}
<link rel="stylesheet" href="{/literal}{$sitecss}{literal}/facebox.css"
	type="text/css" />
<script src="{/literal}{$sitejs}{literal}/facebox.js"></script>

<script>
	$(document).ready(function() {
	$('#dataTables-example').DataTable({
	responsive: true
	});
	});
</script>
{/literal}




<!-- <div id="page-wrapper"> -->
{if isset($smarty.session.errMsg)}
<div
	class="alert alert-danger alert-dismissable northspace2 col-xs-12 col-sm-12 col-md-12 col-lg-12"
	id="error">
	<button type="button" class="close" data-dismiss="alert"
		aria-hidden="true">x</button>
	{$smarty.session.errMsg}
</div>
{/if}

{if isset($smarty.session.successMsg)}
<div
	class="alert alert-success alert-dismissable  northspace2 col-xs-12 col-sm-12 col-md-12 col-lg-12"
	id="success">
	<button type="button" class="close" data-dismiss="alert"
		aria-hidden="true">x</button>
	{$smarty.session.successMsg}
</div>
{/if}
<div class="container-fluid">
	<div class="row" style="margin-top:100px;">
		
		
				
				<div class="col-lg-4" >
				<form class="form-horizontal" role="form">
	                <select class="form-control " id ="pipelineId" onchange="getPipeInfo()">
	                <option value="">--Select Pipeline--</option>
	                    {if !empty($pipelineArr)}
	                        {foreach from=$pipelineArr item=pipe}
	                            <option value="{$pipe.id}"{if $pipeId==$pipe.id}selected=""{/if}>{$pipe.name}</option>
	                        {/foreach}
	                    {/if}   
	                </select>
	            </form>
	            </div>
	   
	</div>
	<br>
	<div class="row">
		<div id="pipelineInfo">
		
		</div>
	</div>
	<br>
	<div class="row" id="default">	
		
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					Report
				</div>
				<!-- /.panel-heading -->
				<div class="panel-body">
					<div class="dataTable_wrapper">
						<table class="table table-striped table-bordered table-hover"
							id="dataTables-example">
							<thead>
								<tr>
									<th>Pipeline</th>
									<th>Idea</th>
									<th>Moved From</th>
									<th>Moved To</th>
									<th>Date</th>
								</tr>
							</thead>
							<tbody>
							{section name=i loop=$reportMainArr}
							{if $reportMainArr[i]['other_details'] != "" }
								{section name=j loop=$reportMainArr[i]['other_details']}
								<tr >
									<td>{$reportMainArr[i]['pipeline_name']}</td>
									<td>{$reportMainArr[i]['project_name']}</td>
									<td>{$reportMainArr[i]['other_details'][j]['stage_moved_from']}</td>
									<td class="center">{$reportMainArr[i]['other_details'][j]['stage_moved_to']}</td>
									<td class="center">{$reportMainArr[i]['other_details'][j]['updated_on']}</td>
								</tr>
								{/section}
							{/if}
							{/section}
								


							</tbody>
						</table>
					</div>
					<!-- /.table-responsive -->

				</div>
				<!-- /.panel-body -->
			</div>
			<!-- /.panel -->
		</div>
		<!-- /.col-lg-12 -->
	</div>
</div>
<!-- </div> -->
{literal}
<script src="{/literal}{$sitejs}{literal}/setting.js"></script>

{/literal}
{include $footer}