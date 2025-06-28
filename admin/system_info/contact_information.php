<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card border-0 shadow-sm rounded">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Contact Information</h5>
                </div>
                <div class="card-body">
                    <form id="system-frm">
                        <div id="msg" class="mb-3"></div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="text" class="form-control" name="phone" id="phone" value="<?= $_settings->info('phone') ?>">
                            </div>
                            <div class="col-md-6">
                                <label for="mobile" class="form-label">Mobile</label>
                                <input type="text" class="form-control" name="mobile" id="mobile" value="<?= $_settings->info('mobile') ?>">
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" id="email" value="<?= $_settings->info('email') ?>">
                            </div>
                            <div class="col-md-6">
                                <label for="address" class="form-label">Location</label>
                                <textarea class="form-control" rows="3" name="address" id="address"><?= $_settings->info('address') ?></textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-end">
                    <button class="btn btn-success px-4" form="system-frm">Save Changes</button>
                </div>
            </div>
        </div>
    </div>
</div>