<style>
	#inquiryTable td:nth-child(4),
	#inquiryTable td:nth-child(5) {
		text-align: center !important;
	}
</style>

<div class="card border-0 shadow-sm rounded-0">
	<div class="card-header bg-primary text-white">
		<h6 class="mb-0">Inquiry Records</h6>
	</div>
	<div class="">
		<div class="table-responsive">
			<table class="table table-hover table-striped table-sm mb-0" id="inquiryTable">
				<thead class="table-light">
					<tr>
						<th>#</th>
						<th>Full Name</th>
						<th>Status</th>
						<th>Date Created</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$i = 1;
					$qry = $conn->query("SELECT * FROM `inquiry_list` ORDER BY `status` ASC, abs(unix_timestamp(`created_at`)) DESC");
					while ($row = $qry->fetch_assoc()):
					?>
						<tr>
							<td class="text-center align-middle"><?= $i++ ?></td>
							<td class="align-middle"><?= htmlspecialchars($row['fullname']) ?></td>
							<td class="align-middle text-center">
								<span class="badge rounded-pill bg-<?= $row['status'] == 1 ? 'success' : 'secondary' ?>">
									<?= $row['status'] == 1 ? 'Read' : 'Unread' ?>
								</span>
							</td>
							<td class=""><?= date("Y-m-d g:i A", strtotime($row['created_at'])) ?></td>
							<td class="text-center align-middle">
								<div class="dropdown">
									<button class="btn btn-sm btn-light border dropdown-toggle" data-bs-toggle="dropdown">
										Actions
									</button>
									<ul class="dropdown-menu">
										<li>
											<a class="dropdown-item" href="./?page=inquiries/view_inquiry&id=<?= $row['id'] ?>">
												<i class="bi bi-card-text text-primary me-2"></i> View
											</a>
										</li>
										<li>
											<hr class="dropdown-divider">
										</li>
										<li>
											<a class="dropdown-item text-danger delete_data" href="javascript:void(0)" data-id="<?= $row['id'] ?>">
												<i class="bi bi-trash me-2"></i> Delete
											</a>
										</li>
									</ul>
								</div>
							</td>
						</tr>
					<?php endwhile; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<script>
	document.addEventListener("DOMContentLoaded", function() {
		// Initialize table
		const table = new simpleDatatables.DataTable("#inquiryTable");

		// Delete action
		document.querySelectorAll(".delete_data").forEach(button => {
			button.addEventListener("click", function() {
				const id = this.dataset.id;
				_conf("Are you sure you want to delete this inquiry permanently?", "delete_inquiry", [id]);
			});
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
			error: function(err) {
				console.error(err);
				alert_toast("An error occurred.", "error");
				end_loader();
			},
			success: function(resp) {
				if (resp?.status === "success") {
					location.reload();
				} else {
					alert_toast("An error occurred.", "error");
					end_loader();
				}
			}
		});
	}
</script>