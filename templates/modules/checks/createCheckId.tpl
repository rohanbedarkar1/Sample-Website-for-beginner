<div id="createCheckListModal" class="modal" role="dialog"  tabindex='-1'>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Create New Check</h4>
            </div>
            <div class="modal-body">
                <div class="inputBlock">
                    <label>Check Name</label>
                    <input type="text" class="form-control" id="checkName" name="checkName" placeholder="Add Check Name"/>
                </div>
                <div class="inputBlock">
                    <label>Description</label>
                    <textarea class="form-control" placeholder="Description" id="checkDescription" name="checkDescription"></textarea>
                    <span id="checkPointDesc" style="display: none; color: red">The field cannot be blank!</span>
                </div>
                
            </div>
            <div class="modal-footer">
                <input type="button" id="submit" class="btn btn-success success" name="submit" value="Submit" onclick="addCheckID();"  />
            </div>
            <div id="otherElements">
                <input type="hidden" id="requestPipeLineId" name="requestPipeLineId" value="" />
                <input type="hidden" id="requestLevelId" name="requestLevelId" value="" />
            </div>
        </div>
    </div>
</div>