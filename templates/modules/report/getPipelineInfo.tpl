{section name=i loop=$ideaCountArr}

	<div class="col-lg-2 col-md-4">
         <div class="panel panel-primary">
             <div class="panel-heading" style="min-height: 70px;background:#4DB5E5 !important;">
                 <div class="row">
                     <div class="padwest1">
                         <div><h5 title="{$ideaCountArr[i]['stages_moved']}">{$ideaCountArr[i]['stages_moved']|truncate:70:"...":true}</h5></div>
                     </div>
                 </div>
             </div>
             <a href="#">
                 <div class="panel-footer">
                    
                     <span style="text-align:center"><h2>{$ideaCountArr[i]['idea_count']}</h2></span>
                     <div class="clearfix"></div>
                 </div>
             </a>
         </div>
    </div>
	
{/section}


	
		
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
							{if $reportMainArr != "" }
							{section name=i loop=$reportMainArr}
								
								<tr >
									<td>{$reportMainArr[i]['pipeline_name']}</td>
									<td>{$reportMainArr[i]['project_name']}</td>
									<td>{$reportMainArr[i]['stage_moved_from']}</td>
									<td class="center">{$reportMainArr[i]['stage_moved_to']}</td>
									<td class="center">{$reportMainArr[i]['updated_on']}</td>
								</tr>
								
							{/section}
							{else}
								<tr >
									<td class="center">-</td>
									<td class="center">-</td>
									<td class="center">-</td>
									<td class="center">-</td>
									<td class="center">-</td>
								</tr>
							{/if}
								


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


{literal}
<script>
	$(document).ready(function() {
	$('#dataTables-example').DataTable({
	responsive: true
	});
	});
</script>
{/literal}