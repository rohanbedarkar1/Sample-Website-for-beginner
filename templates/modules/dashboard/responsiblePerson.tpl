{if count($person_responsible) > 0}
    <option value="">--Select--</option>
    <option value="D:allDeals" >All Deals</option>
    {*<option value="You" disabled="disabled" style="background-color: gray !important">You</option>
    <option value="All Company" disabled="disabled" style="background-color: gray !important">All Company</option>*}
    <option value="D:deletedDeals">All Deleted deals</option>
    <option value="All Company" disabled="disabled">--------------------</option>
    {else}
        <option>No Deals</option>
{/if}
{section name=i loop=$person_responsible}
    <option value="U:{$person_responsible[i]}">{$person_responsible[i]}</option>
{/section}