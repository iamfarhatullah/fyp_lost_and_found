<?php if ($_settings->chk_flashdata('success')): ?>
	<script>
		alert_toast("<?= $_settings->flashdata('success') ?>", 'success');
	</script>
<?php endif; ?>

<style>
	table#categoryTable td:nth-child(4) {
		text-align: right !important;
	}

	table#categoryTable td:nth-child(5),
	table#categoryTable td:nth-child(6) {
		text-align: center !important;
	}
</style>

<section class="card card-outline card-navy rounded-0 shadow-sm">
	<header class="card-header d-flex justify-content-between align-items-center">
		<h3 class="card-title mb-0">Category List</h3>
		<a href="<?= base_url ?>admin?page=categories/manage_category" class="btn btn-sm btn-success rounded-pill">
			<i class="fas fa-plus me-1"></i> New Category
		</a>
	</header>

	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-hover table-striped table-sm" id="categoryTable">
				<colgroup>
					<col width="5%">
					<col width="22%">
					<col width="30%">
					<col width="10%">
					<col width="18%">
					<col width="15%">
				</colgroup>
				<thead class="table-dark text-center">
					<tr>
						<th>#</th>
						<th>Name</th>
						<th>Description</th>
						<th>Status</th>
						<th>Created At</th>
						<th>Options</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$count = 1;
					$categories = $conn->query("SELECT * FROM `category_list` ORDER BY `name` ASC");
					while ($cat = $categories->fetch_assoc()):
					?>
						<tr>
							<td class="text-center"><?= $count++ ?></td>

							<td><?= htmlspecialchars($cat['name']) ?></td>
							<td class="text-end">
								<p class="text-truncate" style="max-width: 200px;">
									<?= strip_tags(htmlspecialchars_decode($cat['description'])) ?>
								</p>
							</td>
							<td>
								<span class="badge rounded-pill px-3 <?= $cat['status'] == 1 ? 'bg-success' : 'bg-danger' ?>">
									<?= $cat['status'] == 1 ? 'Active' : 'Inactive' ?>
								</span>
							</td>
							<td><?= date("Y-m-d h:i A", strtotime($cat['created_at'])) ?></td>
							<td>
								<div class="dropdown text-center">
									<button class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
										Actions
									</button>
									<div class="dropdown-menu">
										<a class="dropdown-item" href="./?page=categories/view_category&id=<?= $cat['id'] ?>">
											<i class="bi bi-eye text-info"></i> View
										</a>
										<a class="dropdown-item" href="./?page=categories/manage_category&id=<?= $cat['id'] ?>">
											<i class="bi bi-pencil text-primary"></i> Edit
										</a>
										<a class="dropdown-item text-danger delete-category" href="javascript:void(0)" data-id="<?= $cat['id'] ?>">
											<i class="bi bi-trash"></i> Delete
										</a>
									</div>
								</div>
							</td>
						</tr>
					<?php endwhile; ?>
				</tbody>
			</table>
		</div>
	</div>
</section>

<script>
	$(function() {
		const table = new simpleDatatables.DataTable('#categoryTable');

		$('.delete-category').on('click', function() {
			const categoryId = $(this).data('id');
			_conf("Do you really want to delete this category?", "deleteCategory", [categoryId]);
		});
	});

	function deleteCategory(id) {
		start_loader();
		$.ajax({
			url: _base_url_ + "classes/Master.php?f=delete_category",
			method: "POST",
			data: {
				id
			},
			dataType: "json",
			success: function(response) {
				if (response?.status === 'success') {
					location.reload();
				} else {
					alert_toast("Failed to delete category.", 'error');
					end_loader();
				}
			},
			error: function(err) {
				console.error(err);
				alert_toast("An error occurred.", 'error');
				end_loader();
			}
		});
	}
</script>