<?php
if (!empty($_GET['id']) && is_numeric($_GET['id'])) {
	$qry = $conn->query("SELECT * FROM `inquiry_list` WHERE id = '{$_GET['id']}'");
	if ($qry->num_rows > 0) {
		foreach ($qry->fetch_assoc() as $k => $v) {
			$$k = $v;
		}
		// Mark as read
		$conn->query("UPDATE `inquiry_list` SET `status` = 1 WHERE id = '{$id}'");
	} else {
		echo '<script>alert("Invalid inquiry ID."); location.replace("./?page=inquiries")</script>';
	}
} else {
	echo '<script>alert("Inquiry ID is required."); location.replace("./?page=inquiries")</script>';
}
?>

<div class="row justify-content-center mt-n4">
	<div class="col-lg-12 col-md-12">
		<div class="card border-0 shadow-sm rounded-0">
			<div class="card-header bg-primary text-white">
				<h5 class="mb-0"><i class="bi bi-envelope-open me-2"></i>Inquiry Details</h5>
			</div>
			<div class="card-body">
				<div class="container-fluid">
					<br>
					<h4 class="fw-bold mb-3">From: <?= htmlspecialchars($fullname ?? '') ?></h4>
					<dl class="row mb-1">
						<dt class="col-sm-3 text-muted">Email:</dt>
						<dd class="col-sm-9"><a href="mailto:<?= $email ?? 'noreply@example.com' ?>"><?= htmlspecialchars($email ?? 'N/A') ?></a></dd>

						<dt class="col-sm-3 text-muted">Contact No:</dt>
						<dd class="col-sm-9"><?= htmlspecialchars($contact ?? '-') ?></dd>
					</dl>
					<hr>
					<div class="inquiry-message mb-2" style="white-space: pre-line;">
						<?= nl2br(htmlspecialchars($message ?? '')) ?>
					</div>
				</div>
			</div>
			<div class="card-footer text-right bg-light">

				<a href="./?page=inquiries" class="btn btn-secondary btn-sm rounded">
					<i class="bi bi-arrow-left"></i> Back to List
				</a>
				<button class="btn btn-danger btn-sm rounded me-2" id="delete_data">
					<i class="bi bi-trash"></i> Delete
				</button>
			</div>
		</div>
	</div>
</div>

<script>
	document.addEventListener("DOMContentLoaded", () => {
		const deleteBtn = document.getElementById('delete_data');
		deleteBtn.addEventListener('click', () => {
			_conf("Are you sure you want to permanently delete this inquiry?", "delete_inquiry", ["<?= $id ?? '' ?>"]);
		});
	});

	function delete_inquiry(id) {
		start_loader();
		$.ajax({
			url: _base_url_ + "classes/Master.php?f=delete_inquiry",
			method: "POST",
			data: {
				id
			},
			dataType: "json",
			error: err => {
				console.error(err);
				alert_toast("An error occurred while deleting.", "error");
				end_loader();
			},
			success: resp => {
				if (resp?.status === "success") {
					location.replace("./?page=inquiries");
				} else {
					alert_toast("Deletion failed.", "error");
					end_loader();
				}
			}
		});
	}
</script>