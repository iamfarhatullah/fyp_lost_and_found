<?php
if (!empty($_GET['id']) && is_numeric($_GET['id'])) {
	$qry = $conn->query("SELECT * FROM `category_list` WHERE id = '{$_GET['id']}' ");
	if ($qry->num_rows > 0) {
		foreach ($qry->fetch_assoc() as $key => $value) {
			$$key = $value;
		}
	} else {
		echo '<script>alert("Invalid Category ID."); location.href="./?page=categories";</script>';
		exit;
	}
} else {
	echo '<script>alert("Category ID is required."); location.href="./?page=categories";</script>';
	exit;
}
?>

<section class="row justify-content-center mt-n3">
	<div class="col-lg-12 col-md-12 col-sm-12">
		<div class="card shadow-sm rounded-0">
			<div class="card-body py-4">
				<div class="container-fluid">
					<h3 class="mb-3 fw-bold"><?= $name ?? 'Untitled Category' ?></h3>

					<div class="mb-3">
						<label class="form-label fw-semibold text-muted">Description:</label>
						<div class="ps-2">
							<?= !empty($description) ? htmlspecialchars_decode($description) : '<em>No description provided.</em>' ?>
						</div>
					</div>

					<div class="mb-4">
						<label class="form-label fw-semibold text-muted">Status:</label>
						<div class="ps-2">
							<?php if (isset($status) && $status == 1): ?>
								<span class="badge bg-success px-3 rounded-pill">Active</span>
							<?php else: ?>
								<span class="badge bg-danger px-3 rounded-pill">Inactive</span>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
			<div class="card-footer py-2">
				<a href="./?page=categories" class="btn btn-sm btn-light bg-gradient-light border rounded-0">
					<i class="fa fa-arrow-left me-1"></i> Back
				</a>
				<button type="button" class="btn btn-sm btn-danger bg-gradient-danger rounded-0" id="deleteBtn">
					<i class="fa fa-trash me-1"></i> Delete
				</button>
				<a href="./?page=categories/manage_category&id=<?= $id ?>" class="btn btn-sm btn-primary bg-gradient-primary rounded-0">
					<i class="fa fa-edit me-1"></i> Edit
				</a>

			</div>
		</div>
	</div>
</section>

<script>
	$(function() {
		$('#deleteBtn').on('click', function() {
			_conf("Are you sure you want to permanently delete this category?", "delete_category", ["<?= $id ?>"]);
		});
	});

	function delete_category(id) {
		start_loader();
		$.ajax({
			url: _base_url_ + "classes/Master.php?f=delete_category",
			method: "POST",
			data: {
				id
			},
			dataType: "json",
			error: function(err) {
				console.error(err);
				alert_toast("An error occurred.", 'error');
				end_loader();
			},
			success: function(resp) {
				if (resp?.status === 'success') {
					location.href = "./?page=categories";
				} else {
					alert_toast("An error occurred.", 'error');
					end_loader();
				}
			}
		});
	}
</script>