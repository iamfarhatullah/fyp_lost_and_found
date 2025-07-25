<style>
  .sidebar-nav .nav-content a i {
    font-size: .9rem;
  }
</style>
<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar bg-white">

  <ul class="sidebar-nav" id="sidebar-nav">

    <li class="nav-item">
      <a class="nav-link bg-info  bg-info  <?= $page != 'home' ? 'collapsed' : '' ?>" href="<?= base_url . 'admin' ?>">
        <i class="bi bi-grid"></i>
        <span>Dashboard</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link bg-info <?= !in_array($page, ['categories', 'categories/manage_category', 'categories/view_category']) ? 'collapsed' : '' ?>" data-bs-target="#categories-nav" data-bs-toggle="collapse" href="#" data-bs-collapse="<?= in_array($page, ['categories', 'categories/manage_category', 'categories/view_category']) ? 'true' : 'false' ?>">
        <i class="bi bi-menu-button-wide"></i><span>Categories</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="categories-nav" class="nav-content collapse <?= in_array($page, ['categories', 'categories/manage_category', 'categories/view_category']) ? 'show' : '' ?> " data-bs-parent="#sidebar-nav">

        <li>
          <a href="<?= base_url . 'admin/?page=categories' ?>" class="<?= $page == 'categories' ? 'active' : '' ?>">
            <i class="bi bi-circle"></i><span>Categories List</span>
          </a>
        </li>
        <li>
          <a href="<?= base_url . 'admin/?page=categories/manage_category' ?>" class="<?= $page == 'categories/manage_category' ? 'active' : '' ?>">
            <i class="bi bi-plus-lg" style="font-size:.9rem"></i><span>Add New</span>
          </a>
        </li>
      </ul>
    </li>
    <li class="nav-item">
      <a class="nav-link bg-info <?= !in_array($page, ['items', 'items/manage_item', 'items/view_item']) ? 'collapsed' : '' ?>" data-bs-target="#items-nav" data-bs-toggle="collapse" href="#" data-bs-collapse="<?= in_array($page, ['items', 'items/manage_item', 'items/view_item']) ? 'true' : 'false' ?>">
        <i class="bi bi-question-octagon"></i><span>Items</span>
        <?php
        $pitem = $conn->query("SELECT * FROM `item_list` where `status` = 0")->num_rows;
        ?>
        <?php if ($pitem > 0): ?>
          <span class="badge rounded-pill bg-danger text-light ms-4"><?= format_num($pitem) ?></span>
        <?php endif; ?>

        <i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="items-nav" class="nav-content collapse <?= in_array($page, ['items', 'items/manage_item', 'items/view_item']) ? 'show' : '' ?> " data-bs-parent="#sidebar-nav">
        <li>
          <a href="<?= base_url . 'admin/?page=items' ?>" class="<?= $page == 'items' ? 'active' : '' ?>">
            <i class="bi bi-circle"></i><span>All Items</span>
          </a>
        </li>
        <li>
          <a href="<?= base_url . 'admin/?page=items/manage_item' ?>" class="<?= $page == 'items/manage_item' ? 'active' : '' ?>">
            <i class="bi bi-plus-lg" style="font-size:.9rem"></i><span>Add New</span>
          </a>
        </li>
      </ul>
    </li>
    <li class="nav-item">
      <a class="nav-link bg-info <?= $page != 'inquiries' ? 'collapsed' : '' ?> nav-users" href="<?= base_url . "admin?page=inquiries" ?>">
        <i class="bi bi-inbox"></i>
        <span>Messages</span>
        <?php
        $message = $conn->query("SELECT * FROM `inquiry_list` where `status` = 0")->num_rows;
        ?>
        <?php if ($message > 0): ?>
          <span class="badge rounded-pill bg-danger text-light ms-4"><?= format_num($message) ?></span>
        <?php endif; ?>
      </a>
    </li>
    <?php if ($_settings->userdata('type') == 1): ?>
      <li class="nav-item">
        <a class="nav-link bg-info <?= $page != 'user/list' ? 'collapsed' : '' ?> nav-users" href="<?= base_url . "admin?page=user/list" ?>">
          <i class="bi bi-people"></i>
          <span>Users</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link bg-info <?= $page != 'system_info/contact_information' ? 'collapsed' : '' ?>  nav-system_info" href="<?= base_url . "admin?page=system_info/contact_information" ?>">
          <i class="bi bi-telephone"></i>
          <span>Contacts</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link bg-info <?= $page != 'system_info' ? 'collapsed' : '' ?>  nav-system_info" href="<?= base_url . "admin?page=system_info" ?>">
          <i class="bi bi-gear"></i>
          <span>Settings</span>
        </a>
      </li>
    <?php endif; ?>
  </ul>
</aside>