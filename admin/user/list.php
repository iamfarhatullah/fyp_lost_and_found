<style>
	.user-avatar {
		width: 2.8rem;
		height: 2.8rem;
		object-fit: cover;
		border-radius: 50%;
		border: 2px solid #ccc;
	}

	#list td,
	#list th {
		vertical-align: middle;
		text-align: center;
	}
</style>

<div class="card shadow-sm border-0">
	<div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
		<h5 class="mb-0">User Management</h5>
		<a href="<?= base_url ?>admin/?page=user/manage_user" class="btn btn-light text-primary fw-bold">
			<i class="bi bi-plus-circle me-1"></i> Add User
		</a>
	</div>
	<div class="">
		<div class="table-responsive">
			<table class="table table-striped table-hover" id="list">
				<thead class="table-light">
					<tr>
						<th>#</th>
						<th>Avatar</th>
						<th>Name</th>
						<th>Username</th>
						<th>User Type</th>
						<th>Updated</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$i = 1;
					$qry = $conn->query("SELECT *, CONCAT(firstname,' ', COALESCE(CONCAT(middlename,' '), ''), lastname) as name FROM `users` WHERE id != '{$_settings->userdata('id')}' ORDER BY name ASC");
					while ($row = $qry->fetch_assoc()):
					?>
						<tr>
							<td><?= $i++ ?></td>
							<td><img src="<?= validate_image($row['avatar']) ?>" class="user-avatar" alt="Avatar"></td>
							<td class="text-start"><?= $row['name'] ?></td>
							<td><?= $row['username'] ?></td>
							<td>
								<?php
								echo match ($row['type']) {
									1 => '<span class="badge bg-success">Administrator</span>',
									2 => '<span class="badge bg-info text-dark">Staff</span>',
									default => '<span class="badge bg-secondary">N/A</span>',
								};
								?>
							</td>
							<td><?= date("Y-m-d H:i", strtotime($row['date_updated'])) ?></td>
							<td>
								<div class="dropdown">
									<button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
										Actions
									</button>
									<ul class="dropdown-menu dropdown-menu-end">
										<li><a class="dropdown-item" href="./?page=user/manage_user&id=<?= $row['id'] ?>"><i class="bi bi-pencil-square me-1"></i>Edit</a></li>
										<li>
											<hr class="dropdown-divider">
										</li>
										<li><a class="dropdown-item text-danger delete_data" href="javascript:void(0)" data-id="<?= $row['id'] ?>"><i class="bi bi-trash me-1"></i>Delete</a></li>
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
	$(document).ready(function() {
		$('.delete_data').click(function() {
			_conf("Are you sure you want to delete this user permanently?", "delete_user", [$(this).data('id')]);
		});

		$('#list').DataTable({
			columnDefs: [{
				targets: 6,
				orderable: false
			}],
			order: [
				[0, 'asc']
			],
			language: {
				searchPlaceholder: "Search users..."
			}
		});
	});

	function delete_user(id) {
		start_loader();
		$.ajax({
			url: _base_url_ + "classes/Users.php?f=delete",
			method: "POST",
			data: {
				id
			},
			error: err => {
				console.error(err);
				alert_toast("An error occurred.", 'error');
				end_loader();
			},
			success: function(resp) {
				if (resp == 1) {
					location.reload();
				} else {
					alert_toast("An error occurred.", 'error');
					end_loader();
				}
			}
		});
	}
</script>