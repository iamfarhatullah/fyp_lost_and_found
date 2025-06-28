<section class="section py-4">
  <div class="container">
    <div class="row g-4">

      <!-- Active Categories -->
      <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="card border-0 shadow-sm">
          <div class="card-body pt-4 d-flex align-items-center gap-3">
            <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
              <i class="bi bi-menu-button-wide fs-4"></i>
            </div>
            <div>
              <h6 class="mb-1">Active Categories</h6>
              <?php $categories = $conn->query("SELECT * FROM `category_list` WHERE `status` = 1")->num_rows; ?>
              <h4 class="mb-0"><?= format_num($categories) ?></h4>
            </div>
          </div>
        </div>
      </div>

      <!-- Pending Items -->
      <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="card border-0 shadow-sm">
          <div class="card-body pt-4 d-flex align-items-center gap-3">
            <div class="bg-warning bg-opacity-10 text-warning rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
              <i class="bi bi-hourglass-split fs-4"></i>
            </div>
            <div>
              <h6 class="mb-1">Pending Items</h6>
              <?php $items_pending = $conn->query("SELECT * FROM `item_list` WHERE `status` = 0")->num_rows; ?>
              <h4 class="mb-0"><?= format_num($items_pending) ?></h4>
            </div>
          </div>
        </div>
      </div>

      <!-- Published Items -->
      <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="card border-0 shadow-sm">
          <div class="card-body pt-4 d-flex align-items-center gap-3">
            <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
              <i class="bi bi-check-circle fs-4"></i>
            </div>
            <div>
              <h6 class="mb-1">Published Items</h6>
              <?php $items_published = $conn->query("SELECT * FROM `item_list` WHERE `status` = 1")->num_rows; ?>
              <h4 class="mb-0"><?= format_num($items_published) ?></h4>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>