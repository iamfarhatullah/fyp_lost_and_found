<?php
if (!empty($_GET['id'])) {
	$qry = $conn->query("SELECT * FROM `category_list` WHERE id = '{$_GET['id']}' ");
	if ($qry->num_rows > 0) {
		foreach ($qry->fetch_assoc() as $key => $val) {
			$$key = $val;
		}
	}
}
?>
<section class="row justify-content-center mt-n3">
	<div class="col-lg-12 col-md-10 col-sm-12">
		<div class="card border shadow-sm">
			<div class="card-header bg-light py-2">
				<h5 class="mb-0"><?= isset($id) ? "Edit Category" : "Add New Category" ?></h5>
			</div>
			<div class="card-body">
				<form id="categoryForm">
					<input type="hidden" name="id" value="<?= $id ?? '' ?>">

					<div class="mb-3">
						<label for="name" class="form-label">Category Name</label>
						<input type="text" name="name" id="name" class="form-control form-control-sm" value="<?= $name ?? '' ?>" required>
					</div>
					<div class="mb-3">
						<label for="status" class="form-label">Status</label>
						<select name="status" id="status" class="form-select form-select-sm" required>
							<option value="1" <?= (isset($status) && $status == 1) ? 'selected' : '' ?>>Active</option>
							<option value="0" <?= (isset($status) && $status == 0) ? 'selected' : '' ?>>Inactive</option>
						</select>
					</div>
					<div class="mb-3">
						<label for="description" class="form-label">Description</label>
						<textarea name="description" id="description" rows="2" class="form-control form-control-sm tinymce-editor" required><?= $description ?? '' ?></textarea>
					</div>


				</form>
			</div>
			<div class="card-footer text-center py-2">
				<button type="submit" form="categoryForm" class="btn btn-success btn-sm px-4">
					<i class="fa fa-save me-1"></i> Save
				</button>
				<a href="./?page=categories" class="btn btn-secondary btn-sm px-4">
					<i class="fa fa-times me-1"></i> Cancel
				</a>
			</div>
		</div>
	</div>
</section>

<script>
	$(function() {
		$('#categoryForm').on('submit', function(e) {
			e.preventDefault();
			const form = $(this);
			$('.err-msg').remove();

			start_loader();

			$.ajax({
				url: _base_url_ + "classes/Master.php?f=save_category",
				method: "POST",
				data: new FormData(this),
				cache: false,
				contentType: false,
				processData: false,
				dataType: "json",
				error: function(err) {
					console.error(err);
					alert_toast("An unexpected error occurred.", 'error');
					end_loader();
				},
				success: function(resp) {
					if (resp?.status === 'success') {
						location.href = `./?page=categories/view_category&id=${resp.sid}`;
					} else if (resp?.status === 'failed' && resp.msg) {
						const errorEl = $('<div class="alert alert-danger err-msg"></div>').text(resp.msg);
						form.prepend(errorEl);
						$('html, body').animate({
							scrollTop: 0
						}, 'fast');
					} else {
						alert_toast("Operation failed.", 'error');
						console.log(resp);
					}
					end_loader();
				}
			});
		});
	});
</script>