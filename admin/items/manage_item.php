<?php
if (isset($_GET['id']) && $_GET['id'] > 0) {
	$qry = $conn->query("SELECT * FROM `item_list` WHERE id = '{$_GET['id']}' ");
	if ($qry->num_rows > 0) {
		foreach ($qry->fetch_assoc() as $k => $v) {
			$$k = $v;
		}
	}
}
?>
<div class="row mt-lg-n4 justify-content-center">
	<div class="col-lg-12">
		<div class="card rounded-0">
			<div class="card-header bg-primary py-0">
				<div class="card-title text-white p-2"><b><?= isset($id) ? "Update Item Details" : "New Item Entry" ?></b></div>
			</div>
			<div class="card-body">
				<div class="container-fluid mt-3">
					<form action="" id="items-form">
						<input type="hidden" name="id" value="<?= $id ?? '' ?>">

						<div class="mb-3">
							<label for="category_id" class="form-label">Category</label>
							<select name="category_id" id="category_id" class="form-select" required>
								<option value="" disabled <?= !isset($category_id) ? "selected" : "" ?>>Select category</option>
								<?php
								$query = $conn->query("SELECT * FROM `category_list` WHERE `status` = 1 ORDER BY `name` ASC");
								while ($row = $query->fetch_assoc()):
								?>
									<option value="<?= $row['id'] ?>" <?= (isset($category_id) && $category_id == $row['id']) ? "selected" : "" ?>>
										<?= htmlspecialchars($row['name']) ?>
									</option>
								<?php endwhile; ?>
							</select>
						</div>

						<div class="mb-3">
							<label for="fullname" class="form-label">Founder Name</label>
							<input type="text" name="fullname" id="fullname" class="form-control form-control-sm rounded-0"
								value="<?= htmlspecialchars($fullname ?? '') ?>" required autofocus>
						</div>

						<div class="mb-3">
							<label for="title" class="form-label">Title</label>
							<input type="text" name="title" id="title" class="form-control form-control-sm rounded-0"
								value="<?= htmlspecialchars($title ?? '') ?>" required>
						</div>

						<div class="mb-3">
							<label for="contact" class="form-label">Contact #</label>
							<input type="text" name="contact" id="contact" class="form-control form-control-sm rounded-0"
								value="<?= htmlspecialchars($contact ?? '') ?>" required>
						</div>

						<div class="mb-3">
							<label for="description" class="form-label">Description</label>
							<textarea rows="5" name="description" id="description" class="form-control form-control-sm rounded-0" required><?= htmlspecialchars($description ?? '') ?></textarea>
						</div>

						<div class="mb-3">
							<label class="form-label">Item Image</label>
							<input type="file" class="form-control" id="customFile" name="image"
								onchange="displayImg(this,$(this))" accept="image/png, image/jpeg">
						</div>

						<div class="mb-3 text-center">
							<img src="<?= validate_image($image_path ?? '') ?>" alt="Preview" id="cimg" class="img-fluid img-thumbnail" style="max-height:200px;">
						</div>

						<div class="mb-3">
							<label for="status" class="form-label">Status</label>
							<select name="status" id="status" class="form-select form-select-sm rounded-0" required>
								<option value="0" <?= isset($status) && $status == 0 ? 'selected' : '' ?>>Pending</option>
								<option value="1" <?= isset($status) && $status == 1 ? 'selected' : '' ?>>Publish</option>
								<option value="2" <?= isset($status) && $status == 2 ? 'selected' : '' ?>>Claimed</option>
							</select>
						</div>
					</form>
				</div>
			</div>
			<div class="card-footer py-2 text-center">
				<button class="btn btn-primary btn-sm bg-gradient-teal btn-flat border-0" form="items-form">
					<i class="fa fa-save"></i> Save
				</button>
				<a class="btn btn-light btn-sm bg-gradient-light border btn-flat" href="./?page=items">
					<i class="fa fa-times"></i> Cancel
				</a>
			</div>
		</div>
	</div>
</div>

<script>
	function displayImg(input, _this) {
		if (input.files && input.files[0]) {
			const reader = new FileReader();
			reader.onload = e => $('#cimg').attr('src', e.target.result);
			reader.readAsDataURL(input.files[0]);
		} else {
			$('#cimg').attr('src', "<?= validate_image($image_path ?? '') ?>");
		}
	}

	$(document).ready(function() {
		$('#category_id').select2({
			placeholder: 'Please Select Here',
			width: '100%'
		});

		$('#items-form').submit(function(e) {
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
						location.replace('./?page=items/view_item&id=' + resp.iid);
					} else if (resp.status === 'failed' && resp.msg) {
						const el = $('<div>').addClass("alert alert-danger err-msg").text(resp.msg);
						_this.prepend(el);
						el.show('slow');
						$("html, body").scrollTop(0);
						end_loader();
					} else {
						alert_toast("An error occurred", 'error');
						console.log(resp);
						end_loader();
					}
				}
			});
		});
	});
</script>