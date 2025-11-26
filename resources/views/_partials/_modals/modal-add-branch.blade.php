<!-- Add Branch Modal -->
<div class="modal fade" id="addBranchModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-simple">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
        <div class="text-center mb-6">
          <h4 class="branch-title mb-2">Add New Branch</h4>
          <p>Branches you may use and assign to your users.</p>
        </div>
        <form id="addBranchForm" class="row" onsubmit="return false"> 
          <div class="col-12 form-control-validation mb-4">
            <label class="form-label" for="modalBranchName">Branch Name</label>
            <input type="text" id="modalBranchName" name="name" class="form-control"
              placeholder="Branch Name" autofocus />
          </div>
          <div class="col-12 form-control-validation mb-4">
            <label class="form-label" for="modalBranchLocation">Location</label>
            <input type="text" id="modalBranchLocation" name="location" class="form-control"
              placeholder="Branch Location" />
          </div>
          <div class="col-12 text-center demo-vertical-spacing">
            <button type="submit" class="btn btn-primary me-sm-4 me-1">Submit</button>
            <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal"
              aria-label="Close">Discard</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!--/ Add Branch Modal -->
