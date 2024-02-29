<div class="modal fade" id="modal-update" tabindex="-1" role="dialog" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Menu Edit</h5>
                <button type="button" data-bs-dismiss="modal" class="btn-close" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form-edit" class="form-horizontal">
                    <input type="hidden" id="menu_id">
                    <div class="form-group row">
                        <label for="active" class="col-sm-2 col-form-label">Active</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="active" name="active" style="width: 100%;">
                                <option value="1">Active</option>
                                <option value="0">Non Active</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Icon</label>
                        <div class="col-sm-10">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                <span class="input-group-text h-100"><i class="fab fa-font-awesome-flag"></i></span>
                                </div>
                                <input type="text" name="icon" class="icon-picker form-control" placeholder="Icon from fontawesome" autocomplete="off">
                            </div>
                            <span class="help-block">
                                <i class="fa fa-info-circle text-info me-2"></i>For more icons, please see <a href="http://fontawesome.io/icons" target="_blank">http://fontawesome.io/icons</a>
                            </span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="name" class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text h-100"><i class="fas fa-pencil-alt"></i></span>
                                </div>
                                <input type="text" name="title" class="form-control" placeholder="Name" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputName2" class="col-sm-2 col-form-label">Route</label>
                        <div class="col-sm-10">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text h-100"><i class="fas fa-link"></i></span>
                                </div>
                                <input type="text" name="route" class="form-control" placeholder="Route" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputSkills" class="col-sm-2 col-form-label">Role</label>
                        <div class="col-sm-10">
                            <select class="form-control select2" name="groups_menu[]" id="groups_menu" multiple="multiple" style="width: 100%;">
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" data-bs-dismiss="modal" class="btn btn-secondary btn-sm">Close</button>
                <button type="submit" class="btn btn-primary btn-sm" id="btn-update">Save Changes</button>
            </div>
        </div>
    </div>
</div>
