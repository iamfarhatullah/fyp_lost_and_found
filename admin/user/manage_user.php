<?php
if (isset($_GET['id'])) {
	$user = $conn->query("SELECT * FROM users WHERE id = '{$_GET['id']}'");
	foreach ($user->fetch_array() as $k => $v) {
		$meta[$k] = $v;
	}
}
?>

<?php if ($_settings->chk_flashdata('success')): ?>
	<script>
		alert_toast("<?= $_settings->flashdata('success') ?>", 'success')
	</script>
<?php endif; ?>

<div class="card border-0 shadow-sm">
	<div class="card-header bg-primary text-white">
		<h5 class="mb-0"><?= isset($meta['id']) ? 'Edit User' : 'Add New User' ?></h5>
	</div>
	<div class="card-body">
		<form id="manage-user">
			<input type="hidden" name="id" value="<?= $meta['id'] ?? '' ?>">

			<div class="mb-3">
				<label for="firstname" class="form-label">First Name</label>
				<input type="text" name="firstname" id="firstname" class="form-control" value="<?= $meta['firstname'] ?? '' ?>" required>
			</div>

			<div class="mb-3">
				<label for="middlename" class="form-label">Middle Name</label>
				<input type="text" name="middlename" id="middlename" class="form-control" value="<?= $meta['middlename'] ?? '' ?>">
			</div>

			<div class="mb-3">
				<label for="lastname" class="form-label">Last Name</label>
				<input type="text" name="lastname" id="lastname" class="form-control" value="<?= $meta['lastname'] ?? '' ?>" required>
			</div>

			<div class="mb-3">
				<label for="username" class="form-label">Username</label>
				<input type="text" name="username" id="username" class="form-control" value="<?= $meta['username'] ?? '' ?>" required autocomplete="off">
			</div>

			<div class="mb-3">
				<label for="password" class="form-label"><?= isset($meta['id']) ? "New " : "" ?>Password</label>
				<input type="password" name="password" id="password" class="form-control" autocomplete="off">
				<?php if (isset($meta['id'])): ?>
					<small class="text-muted fst-italic">Leave blank to keep current password.</small>
				<?php endif; ?>
			</div>

			<div class="mb-3">
				<label for="type" class="form-label">User Role</label>
				<select name="type" id="type" class="form-select" required>
					<option value="1" <?= (isset($meta['type']) && $meta['type'] == 1) ? 'selected' : '' ?>>Administrator</option>
					<option value="2" <?= (isset($meta['type']) && $meta['type'] == 2) ? 'selected' : '' ?>>Staff</option>
				</select>
			</div>

			<div class="mb-3">
				<label for="customFile" class="form-label">Avatar</label>
				<input type="file" name="img" id="customFile" class="form-control" onchange="displayImg(this)" accept="image/*">
			</div>

			<div class="text-center mb-3">
				<img src="<?= validate_image($meta['avatar'] ?? '') ?>" id="cimg" class="rounded-circle border" style="height: 100px; width: 100px; object-fit: cover;">
			</div>

			<div id="msg" class="mb-3"></div>

			<div class="d-flex justify-content-between">
				<button type="submit" class="btn btn-primary">Save User</button>
				<a href="./?page=user/list" class="btn btn-secondary">Cancel</a>
			</div>
		</form>
	</div>
</div>

<script>
	function displayImg(input) {
		if (input.files && input.files[0]) {
			const reader = new FileReader();
			reader.onload = e => {
				document.getElementById('cimg').src = e.target.result;
			};
			reader.readAsDataURL(input.files[0]);
		}
	}

	document.getElementById('manage-user').addEventListener('submit', function(e) {
		e.preventDefault();
		start_loader();
		const form = this;

		$.ajax({
			url: _base_url_ + 'classes/Users.php?f=save',
			method: 'POST',
			data: new FormData(form),
			cache: false,
			contentType: false,
			processData: false,
			success: function(resp) {
				if (resp == 1) {
					location.href = './?page=user/list';
				} else {
					document.getElementById('msg').innerHTML = `<div class="alert alert-danger">Username already exists</div>`;
					end_loader();
				}
			},
			error: function(err) {
				console.error(err);
				end_loader();
			}
		});
	});
</script>