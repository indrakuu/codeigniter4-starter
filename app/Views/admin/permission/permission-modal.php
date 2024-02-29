<div class="modal fade" id="openModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="buttonModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="saveForm" action="<?= route_to('permission.store') ?>" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="buttonModalLabel">Create Permission</h5>
                    <button type="button" id="close" class="btn-close" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="id" name="id"/>
                    <div class="mb-3">
                        <label for="name" class="col-form-label">Permission Name</label>
                        <input type="text" class="form-control" id="name" name="name" required/>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="col-form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="close" class="btn btn-secondary" >Close</button>
                    <button type="submit" id="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i> Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>