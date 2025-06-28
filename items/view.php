<?php
if (isset($_GET['id']) && $_GET['id'] > 0) {
	$qry = $conn->query("SELECT *, COALESCE((SELECT `name` FROM `category_list` WHERE `category_list`.`id` = `item_list`.`category_id`), 'N/A') AS `category` FROM `item_list` WHERE id = '{$_GET['id']}' ");
	if ($qry->num_rows > 0) {
		foreach ($qry->fetch_assoc() as $k => $v) {
			$$k = $v;
		}
	} else {
		echo '<script>alert("Item ID is not valid."); location.replace("./?page=items")</script>';
	}
} else {
	echo '<script>alert("Item ID is Required."); location.replace("./?page=items")</script>';
}
?>

<div class="container-fluid">
	<div class="row justify-content-center">
		<div class="col-lg-12 col-md-12">
			<div class="card shadow-sm border-0">
				<div class="card-body p-4">
					<div class="bg-info">
						<h3 class="p-3 bg-default"><?= $title ?? "" ?>
							<span class="badge bg-secondary ms-2"><?= $category ?? "" ?></span>
						</h3>
					</div>
					<div class="mb-4">
						<img src="<?= validate_image($image_path ?? "") ?>" alt="<?= $title ?? "" ?>" class="img-fluid rounded" style="max-height: 300px; object-fit: contain;">
					</div>
					<dl class="row">
						<dt class="col-sm-3 text-muted">Founder Name</dt>
						<dd class="col-sm-9"><?= $fullname ?? "" ?></dd>

						<dt class="col-sm-3 text-muted">Contact No.</dt>
						<dd class="col-sm-9"><?= $contact ?? "" ?></dd>

						<dt class="col-sm-3 text-muted">Description</dt>
						<dd class="col-sm-9"><?= isset($description) ? nl2br($description) : "" ?></dd>
					</dl>
				</div>
			</div>
		</div>
	</div>
</div>