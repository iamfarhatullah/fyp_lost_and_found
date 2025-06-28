<?php
if (isset($_GET['id']) && $_GET['id'] > 0) {
	$qry = $conn->query("SELECT *, COALESCE((SELECT name FROM category_list WHERE category_list.id = item_list.category_id), 'N/A') AS category FROM item_list WHERE id = '{$_GET['id']}' ");
	if ($qry->num_rows > 0) {
		foreach ($qry->fetch_assoc() as $k => $v) {
			$$k = $v;
		}
	} else {
		echo '<script>alert("Item ID is not valid."); location.replace("./?page=items")</script>';
	}
} else {
	echo '<script>alert("Item ID is required."); location.replace("./?page=items")</script>';
}
?>

<style>
	.lf-image {
		width: 100%;
		max-width: 500px;
		height: 300px;
		margin: 1em auto;
		background: #000;
		box-shadow: 1px 1px 10px #00000069;
	}

	.lf-image img {
		width: 100%;
		height: 100%;
		object-fit: scale-down;
		object-position: center;
	}
</style>

<div class="row mt-lg-n4 mt-md-n4 justify-content-center">
	<div class="col-lg-12 col-md-12">
		<div class="card rounded">
			<div class="card-body">
				<div class="container-fluid mt-4">
					<h2 class="mb-3">
						<?= htmlspecialchars($title ?? '') ?>
						<small class="text-muted">| <?= htmlspecialchars($category ?? '') ?></small>
					</h2>
					<div class="lf-image">
						<img src="<?= validate_image($image_path ?? '') ?>" alt="<?= htmlspecialchars($title ?? '') ?>">
					</div>

					<dl class="row">
						<dt class="col-sm-3 text-muted">Founder Name</dt>
						<dd class="col-sm-9"><?= htmlspecialchars($fullname ?? '') ?></dd>

						<dt class="col-sm-3 text-muted">Contact No.</dt>
						<dd class="col-sm-9"><?= htmlspecialchars($contact ?? '') ?></dd>

						<dt class="col-sm-3 text-muted">Description</dt>
						<dd class="col-sm-9"><?= isset($description) ? nl2br(htmlspecialchars($description)) : '' ?></dd>

						<dt class="col-sm-3 text-muted">Status</dt>
						<dd class="col-sm-9">
							<?php
							echo match ((int)$status) {
								1 => '<span class="badge bg-primary px-3 rounded-pill">Published</span>',
								2 => '<span class="badge bg-success px-3 rounded-pill">Claimed</span>',
								default => '<span class="badge bg-secondary px-3 rounded-pill">Pending</span>',
							};
							?>
						</dd>
					</dl>
				</div>
			</div>
			<div class="card-footer py-2 text-right">
				<a href="./?page=items" class="btn btn-light btn-sm bg-gradient-light border rounded">
					<i class="fa fa-angle-left"></i> Back to List
				</a>
				<button type="button" class="btn btn-danger btn-sm bg-gradient-danger rounded" id="delete_data">
					<i class="fa fa-trash"></i> Delete
				</button>
				<a href="./?page=items/manage_item&id=<?= $id ?? '' ?>" class="btn btn-primary btn-sm bg-gradient-teal rounded">
					<i class="fa fa-edit"></i> Edit
				</a>

			</div>
		</div>
	</div>
</div>

<script>
	$(function() {
		$('#delete_data').on('click', function() {
			_conf("Are you sure to delete this item permanently?", "delete_item", ["<?= $id ?? '' ?>"]);
		});
	});

	function delete_item(id) {
		start_loader();
		$.ajax({
			url: _base_url_ + "classes/Master.php?f=delete_item",
			method: "POST",
			data: {
				id
			},
			dataType: "json",
			error: err => {
				console.error(err);
				alert_toast("An error occurred.", "error");
				end_loader();
			},
			success: function(resp) {
				if (resp?.status === 'success') {
					location.replace("./?page=items");
				} else {
					alert_toast("An error occurred.", "error");
					end_loader();
				}
			}
		});
	}
</script>