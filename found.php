<div class="row justify-content-center">
    <div class="col-lg-12">
        <div class="card shadow-sm">
            <div class="card-body py-4">
                <div class="p-1" style="background-color: #046fa3;">
                    <h2 class="text-white mt-2">Post Item</h2>
                </div>
                <p class="mb-4 text-default mt-3">Please fill all the required field. Once submitted the admin will approve/disapprove your request</p>
                <form action="" id="item-form" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?= isset($id) ? $id : '' ?>">
                    <input type="hidden" name="founder">

                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="mt-3">
                                <label for="category_id" class="form-label">Category</label>
                                <select name="category_id" id="category_id" class="form-select" required>
                                    <option value="" disabled <?= !isset($category_id) ? "selected" : "" ?>></option>
                                    <?php
                                    $query = $conn->query("SELECT * FROM `category_list` WHERE `status` = 1 ORDER BY `name` ASC");
                                    while ($row = $query->fetch_assoc()):
                                    ?>
                                        <option value="<?= $row['id'] ?>" <?= isset($category_id) && $category_id == $row['id'] ? "selected" : "" ?>>
                                            <?= $row['name'] ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <div>
                                <label for="fullname" class="form-label">Founder Name</label>
                                <input type="text" name="fullname" id="fullname" class="form-control" value="<?= isset($fullname) ? $fullname : '' ?>" required autofocus>
                            </div>
                            <div>
                                <label for="title" class="form-label">Title</label>
                                <input type="text" name="title" id="title" class="form-control" value="<?= isset($title) ? $title : '' ?>" required>
                            </div>
                            <div>
                                <label for="contact" class="form-label">Contact #</label>
                                <input type="text" name="contact" id="contact" class="form-control" value="<?= isset($contact) ? $contact : '' ?>" required>
                            </div>
                            <div>
                                <label for="description" class="form-label">Description</label>
                                <textarea name="description" id="description" rows="8" class="form-control" required><?= isset($description) ? $description : '' ?></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mt-3">
                                <label for="customFile" class="form-label">Item Image</label>
                                <input type="file" class="form-control" id="customFile" name="image" onchange="displayImg(this,$(this))" accept="image/png, image/jpeg">
                            </div>
                            <div class="text-center mt-3">
                                <img src="<?= validate_image(isset($image_path) ? $image_path : '') ?>" alt="Item Image" id="cimg" class="img-fluid img-thumbnail" style="max-height: 250px;">
                            </div>
                        </div>
                    </div>
                    <br><br>
                    <div class="d-grid col-md-4 mt-4" style="float: right;">
                        <button type="submit" class="btn btn-success"><i class="bi bi-send"></i> Submit</button>
                    </div>
                    <br>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function displayImg(input, _this) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#cimg').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            $('#cimg').attr('src', "<?= validate_image(isset($image_path) ? $image_path : '') ?>");
        }
    }

    $(document).ready(function() {
        $('#category_id').select2({
            placeholder: 'Please Select Here',
            width: '100%'
        });

        $('#item-form').submit(function(e) {
            e.preventDefault();
            const _this = $(this);
            $('.err-msg').remove();

            start_loader();
            $.ajax({
                url: _base_url_ + "classes/Master.php?f=save_item",
                data: new FormData(this),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                dataType: 'json',
                error: err => {
                    console.error(err);
                    alert_toast("An error occurred", 'error');
                    end_loader();
                },
                success: function(resp) {
                    if (resp?.status === 'success') {
                        location.replace('./?page=found');
                    } else if (resp.status === 'failed' && resp.msg) {
                        const el = $('<div>').addClass("alert alert-danger err-msg").text(resp.msg);
                        _this.prepend(el);
                        $("html, body").scrollTop(0);
                        end_loader();
                    } else {
                        alert_toast("An error occurred", 'error');
                        end_loader();
                    }
                }
            });
        });
    });
</script>