<style>
	.preview-img {
		height: 120px;
		width: 120px;
		object-fit: cover;
		border-radius: 50%;
	}

	.cover-preview {
		height: 250px;
		width: 100%;
		object-fit: contain;
		border-radius: 0.5rem;
	}
</style>

<div class="container-fluid">
	<div class="card shadow-sm border-0">
		<div class="card-body pt-4">
			<form id="system-frm">
				<div id="msg" class="form-group"></div>

				<div class="row g-3">
					<div class="col-md-6">
						<label class="form-label">Name</label>
						<input type="text" name="name" class="form-control" value="<?= $_settings->info('name') ?>">
					</div>
					<div class="col-md-6">
						<label class="form-label">Short name</label>
						<input type="text" name="short_name" class="form-control" value="<?= $_settings->info('short_name') ?>">
					</div>

					<div class="col-md-6">
						<label class="form-label">Logo</label>
						<input type="file" class="form-control" name="img" onchange="displayImg(this, '#logoPreview')">
						<div class="mt-2 text-center">
							<img src="<?= validate_image($_settings->info('logo')) ?>" id="logoPreview" class="preview-img img-thumbnail">
						</div>
					</div>

					<div class="col-md-6">
						<label class="form-label">Cover Photo</label>
						<input type="file" class="form-control" name="cover" onchange="displayImg(this, '#coverPreview')">
						<div class="mt-2 text-center">
							<img src="<?= validate_image($_settings->info('cover')) ?>" id="coverPreview" class="cover-preview img-thumbnail">
						</div>
					</div>

					<div class="col-6">
						<label class="form-label">Banner Images</label>
						<input type="file" class="form-control" name="banners[]" multiple accept=".jpg,.jpeg,.png" onchange="displayBannerNames(this)">
						<small class="text-muted">Select new banner images to upload</small>
					</div>

					<div class="col-6">
						<label class="form-label">Current Banners</label>
						<div class="row g-2">
							<?php
							$upload_path = "uploads/banner";
							if (is_dir(base_app . $upload_path)):
								foreach (scandir(base_app . $upload_path) as $img):
									if (in_array($img, ['.', '..'])) continue;
							?>
									<div class="col-md-3 col-6">
										<div class="position-relative">
											<img src="<?= base_url . $upload_path . '/' . $img . '?v=' . time() ?>" class="img-thumbnail w-100" style="height: 120px; object-fit: cover;">
											<button class="btn btn-sm btn-danger position-absolute top-0 end-0 m-1 rem_img" type="button" data-path="<?= base_app . $upload_path . '/' . $img ?>"><i class="bi bi-x"></i></button>
										</div>
									</div>
							<?php endforeach;
							endif; ?>
						</div>
					</div>
				</div>
			</form>
		</div>

		<div class="card-footer text-end">
			<button type="submit" class="btn btn-success" form="system-frm">Update Settings</button>
		</div>
	</div>
</div>

<script>
	function displayImg(input, selector) {
		if (input.files && input.files[0]) {
			const reader = new FileReader();
			reader.onload = e => document.querySelector(selector).src = e.target.result;
			reader.readAsDataURL(input.files[0]);
		}
	}

	function displayBannerNames(input) {
		let names = Array.from(input.files).map(f => f.name).join(', ');
		input.nextElementSibling.innerText = names;
	}

	function delete_img(path) {
		start_loader();
		$.ajax({
			url: _base_url_ + 'classes/Master.php?f=delete_img',
			data: {
				path
			},
			method: 'POST',
			dataType: "json",
			success: function(resp) {
				if (resp.status === 'success') {
					$('[data-path="' + path + '"]').closest('.col-md-3').fadeOut(300, function() {
						$(this).remove();
					});
					alert_toast("Image Deleted", "success");
				} else {
					alert_toast("Failed to delete", "error");
				}
				end_loader();
			},
			error: function() {
				alert_toast("Error deleting image", "error");
				end_loader();
			}
		});
	}

	$(document).ready(function() {
		$('.rem_img').click(function() {
			const path = $(this).data('path');
			_conf("Are you sure you want to delete this image?", 'delete_img', ["'" + path + "'"]);
		});
	});
</script>