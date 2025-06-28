<!-- ======= Header ======= -->
<header id="header" class="header fixed-top shadow-sm border-bottom py-2">
  <div class="container-lg d-flex justify-content-between align-items-center px-4">

    <!-- Logo and Branding -->
    <a href="<?= base_url ?>" class="logo d-flex align-items-center text-decoration-none">
      <img src="<?= validate_image($_settings->info('logo')) ?>" alt="System Logo" style="height: 40px;" class="me-2">
      <!-- <span class="fw-bold fs-5 text-white"><?= $_settings->info('short_name') ?></span> -->
    </a>

    <!-- Navigation Menu -->
    <nav class="header-nav me-auto">
      <ul class="nav gap-2">
        <li class="nav-item">
          <a href="<?= base_url ?>" class="nav-link text-white fw-semibold px-3 py-1 rounded hover-bg">Home</a>
        </li>
        <li class="nav-item">
          <a href="<?= base_url . '?page=items' ?>" class="nav-link text-white fw-semibold px-3 py-1 rounded hover-bg">Lost and Found</a>
        </li>
        <li class="nav-item">
          <a href="<?= base_url . '?page=found' ?>" class="nav-link text-white fw-semibold px-3 py-1 rounded hover-bg">Post an Item</a>
        </li>
        <li class="nav-item">
          <a href="<?= base_url . "?page=about" ?>" class="nav-link text-white fw-semibold px-3 py-1 rounded hover-bg">About</a>
        </li>
        <li class="nav-item">
          <a href="<?= base_url . '?page=contact' ?>" class="nav-link text-white fw-semibold px-3 py-1 rounded hover-bg">Contact Us</a>
        </li>
      </ul>
    </nav>

    <!-- Login Button -->
    <div>
      <a href="<?= base_url . 'admin' ?>" class="btn btn-success rounded-pill px-4 fw-semibold">
        Login
      </a>
    </div>

  </div>
</header>