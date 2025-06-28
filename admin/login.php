<?php require_once('../config.php') ?>
<!DOCTYPE html>
<html lang="en">
<?php require_once('inc/header.php') ?>

<body class="bg-light d-flex align-items-center" style="min-height: 100vh; background-image: url('<?= validate_image($_settings->info('cover')) ?>'); background-size: cover; background-position: center;">

  <main class="container">
    <div class="row justify-content-center">
      <div class="col-md-6 col-lg-4">
        <!-- Login Card -->
        <div class="card shadow">
          <div class="card-body p-5">
            <div class="text-center">
              <img src="<?= validate_image($_settings->info('logo')) ?>" alt="Logo" class="img-fluid mb-2" style="max-height: 60px;">
            </div>
            <h3 class="text-center mb-1 mt-3">Account Login</h3>
            <p class="text-center text-muted small">Enter your username and password</p>
            <form id="login-frm" class="needs-validation" novalidate>
              <div class="mb-3">
                <label for="yourUsername" class="form-label">Username</label>
                <div class="input-group">
                  <input type="text" name="username" class="form-control" id="yourUsername" placeholder="Enter username" required>
                  <div class="invalid-feedback">Please enter your username.</div>
                </div>
              </div>

              <div class="mb-3">
                <label for="yourPassword" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" id="yourPassword" placeholder="Enter password" required>
                <div class="invalid-feedback">Please enter your password.</div>
              </div>
              <br>
              <div class="d-grid">
                <button class="btn btn-success" type="submit">Login</button>
              </div>
              <br>
            </form>
          </div>
        </div>

      </div>
    </div>
  </main>

  <!-- Scripts -->
  <script src="<?= base_url ?>assets/js/jquery-3.6.4.min.js"></script>
  <script src="<?= base_url ?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="<?= base_url ?>assets/js/main.js"></script>
  <script>
    $(document).ready(function() {
      end_loader();
    });
  </script>
</body>

</html>