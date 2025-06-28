<?php
$user = $conn->query("SELECT * FROM users WHERE id = '" . $_settings->userdata('id') . "'");
foreach ($user->fetch_array() as $k => $v) {
	$meta[$k] = $v;
}
?>
<style>
	img#cimg {
		height: 15vh;
		width: 15vh;
		object-fit: cover;
		border-radius: 50%;
	}
</style>

<section class="section">
	<div class="card card-outline card-navy rounded-0">
		<div class="card-header py-2">
			<h5 class="card-title mb-0">Update Your Profile</h5>
		</div>
		<div class="card-body">
			<div class="container-fluid">
				<div id="msg"></div>
				<form id="manage-user" enctype="multipart/form-data">
					<input type="hidden" name="id" value="<?= $_settings->userdata('id') ?>">

					<div class="row">
						<div class="col-md-6 mb-3">
							<label for="firstname" class="form-label">First Name</label>
							<input type="text" name="firstname" id="firstname" class="form-control" value="<?= $meta['firstname'] ?? '' ?>" required>
						</div>
						<div class="col-md-6 mb-3">
							<label for="middlename" class="form-label">Middle Name</label>
							<input type="text" name="middlename" id="middlename" class="form-control" value="<?= $meta['middlename'] ?? '' ?>">
						</div>
					</div>

					<div class="row">
						<div class="col-md-6 mb-3">
							<label for="lastname" class="form-label">Last Name</label>
							<input type="text" name="lastname" id="lastname" class="form-control" value="<?= $meta['lastname'] ?? '' ?>" required>
						</div>
						<div class="col-md-6 mb-3">
							<label for="username" class="form-label">Username</label>
							<input type="text" name="username" id="username" class="form-control" value="<?= $meta['username'] ?? '' ?>" required autocomplete="off">
						</div>
					</div>

					<div class="mb-3">
						<label for="password" class="form-label">Password</label>
						<input type="password" name="password" id="password" class="form-control" autocomplete="off">
						<small class="text-muted fst-italic">Leave this blank if you do not want to change the password.</small>
					</div>

					<div class="mb-3">
						<label for="customFile" class="form-label">Avatar</label>
						<input type="file" class="form-control" id="customFile" name="img" accept="image/png, image/jpeg" onchange="displayImg(this)">
					</div>

					<div class="mb-3 text-center">
						<img id="cimg" src="<?= validate_image($meta['avatar'] ?? '') ?>" alt="Profile Avatar" class="img-thumbnail">
					</div>

					<div class="text-center">
						<button type="submit" class="btn btn-primary bg-gradient-teal px-4">Update</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>

<script>
	function displayImg(input, _this) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function(e) {
				$('#cimg').attr('src', e.target.result);
			}

			reader.readAsDataURL(input.files[0]);
		} else {
			$('#cimg').attr('src', "<?php echo validate_image(isset($meta['avatar']) ? $meta['avatar'] : '') ?>");
		}
	}
	$('#manage-user').submit(function(e) {
		e.preventDefault();
		start_loader()
		$.ajax({
			url: _base_url_ + 'classes/Users.php?f=save',
			data: new FormData($(this)[0]),
			cache: false,
			contentType: false,
			processData: false,
			method: 'POST',
			type: 'POST',
			success: function(resp) {
				if (resp == 1) {
					location.replace('<?= base_url . 'admin?page=user' ?>')
				} else {
					$('#msg').html('<div class="alert alert-danger">Username already exist</div>')
					end_loader()
				}
			}
		})
	})
</script>