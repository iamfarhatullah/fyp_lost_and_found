<?php if ($_settings->chk_flashdata('success')): ?>
	<script>
		alert_toast("<?= $_settings->flashdata('success') ?>", 'success');
	</script>
<?php endif; ?>

<style>
	#list td:nth-child(5),
	#list td:nth-child(6) {
		text-align: center !important;
	}
</style>

<div class="card card-outline rounded-0 border-primary">
	<div class="card-header bg-primary d-flex justify-content-end align-items-center">
		<a href="<?= base_url ?>admin?page=items/manage_item" id="create_new" class="btn btn-md btn-primary	rounded shadow-sm">
			<i class="fas fa-plus"></i> Add Item
		</a>
	</div>
	<div class="">
		<div class="container-fluid">
			<div class="table-responsive">
				<table class="table table-striped table-hover table-sm" id="list">
					<colgroup>
						<col width="5%">
						<col width="15%">
						<col width="35%">
						<col width="15%">
						<col width="20%">
						<col width="10%">
					</colgroup>
					<thead>
						<tr>
							<th>#</th>
							<th>Posted By</th>
							<th>Title</th>
							<th>Status</th>
							<th>Date Created</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$i = 1;
						$qry = $conn->query("SELECT *, COALESCE((SELECT name FROM category_list WHERE category_list.id = item_list.category_id), 'N/A') as category FROM item_list ORDER BY abs(unix_timestamp(created_at)) DESC");
						while ($row = $qry->fetch_assoc()):
						?>
							<tr>
								<td class="text-center"><?= $i++ ?></td>

								<td><?= htmlspecialchars($row['fullname']) ?></td>
								<td>
									<div class="text-truncate" style="max-width:250px">
										<?= htmlspecialchars($row['title']) ?>
									</div>
								</td>
								<td>
									<?php
									$status_badge = [
										0 => '<span class="badge bg-secondary px-3 rounded-pill">Pending</span>',
										1 => '<span class="badge bg-primary px-3 rounded-pill">Published</span>',
										2 => '<span class="badge bg-success px-3 rounded-pill">Claimed</span>'
									];
									echo $status_badge[$row['status']] ?? '<span class="badge bg-light text-dark px-3">Unknown</span>';
									?>
								</td>
								<td><?= date("Y-m-d g:i A", strtotime($row['created_at'])) ?></td>
								<td class="text-center">
									<div class="dropdown">
										<button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
											Action
										</button>
										<ul class="dropdown-menu dropdown-menu-end">
											<li><a class="dropdown-item" href="./?page=items/view_item&id=<?= $row['id'] ?>"><i class="bi bi-card-text text-dark me-1"></i> View</a></li>
											<li><a class="dropdown-item" href="./?page=items/manage_item&id=<?= $row['id'] ?>"><i class="bi bi-pencil-square text-primary me-1"></i> Edit</a></li>
											<li>
												<hr class="dropdown-divider">
											</li>
											<li><a class="dropdown-item text-danger delete_data" href="javascript:void(0)" data-id="<?= $row['id'] ?>"><i class="bi bi-trash me-1"></i> Delete</a></li>
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
</div>

<script>
	$(function() {
		const table = new simpleDatatables.DataTable("#list");

		$('.delete_data').on('click', function() {
			const id = $(this).data('id');
			_conf("Are you sure you want to delete this item permanently?", "delete_item", [id]);
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
					location.reload();
				} else {
					alert_toast("Deletion failed.", "error");
					end_loader();
				}
			}
		});
	}
</script>