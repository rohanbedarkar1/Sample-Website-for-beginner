<table id="viewActionTable" class="table pretty table-bordered display" cellspacing="0" width="100%">
    <thead>
        <tr style="font-weight: bold;">
            <td style="width: 50px;">#</td>
            <td style="width: 50px;">Tracker</td>
            <td style="width: 100px;">Stage Item Name</td>
            <td style="width: 50px;">Status</td>
            <td style="width: 50px;">Priority</td>
            <td style="width: 200px;">Subject</td>
            <td style="width: 100px;">Assignee</td>
            <td style="width: 100px">Due Date</td>
        </tr>
    </thead>
    <tbody>
        {foreach from=$issueArray key=index item=data}
            {if !empty($issueArray)}
                <tr>
                    <td>{$data.id}</td>
                    <td>{$data.tracker.name}</td>
                    <td>{$data.custom_fields.1.value}</td>
                    <td>{$data.status.name}</td>
                    <td>{$data.priority.name}</td>
                    <td>{$data.subject}</td>
                    <td>{$data.assigned_to.name}</td>
                    <td>{date("d/m/Y",strtotime($data.due_date))}</td>
                </tr>
            {/if}
        {/foreach}
    </tbody>
</table>
<script>
    $(document).ready(function() {
        $('#viewActionTable').DataTable({
            "bAutoWidth": false,
        });
    });
</script>