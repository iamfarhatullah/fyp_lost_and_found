<section class="section dashboard">
  <div class="row">

    <!-- Left side columns -->
    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
      <div class="row">

        <div class="col-xxl-6 col-xl-6 col-lg-4 col-md-4 col-sm-12 col-12">
          <div class="card info-card">
            <div class="card-body">
              <h5 class="card-title">Categories <span>| Active</span></h5>

              <div class="d-flex align-items-center justify-content-between">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-success bg-opacity-25 text-success">
                  <i class="bi bi-menu-button-wide"></i>
                </div>
                <div class="ps-3">
                  <?php
                  $categories = $conn->query("SELECT * FROM `category_list` where `status` = 1")->num_rows;
                  ?>
                  <h6><?= format_num($categories) ?></h6>
                  <!-- <span class="text-success small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">increase</span> -->

                </div>
              </div>
            </div>

          </div>
        </div>
        <div class="col-xxl-6 col-xl-6 col-lg-4 col-md-4 col-sm-12 col-12">
          <div class="card info-card">
            <div class="card-body">
              <h5 class="card-title">Item Entry <span>| Pending</span></h5>
              <div class="d-flex align-items-center justify-content-between">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-dark bg-opacity-25 text-dark">
                  <i class="bi bi-question-octagon"></i>
                </div>
                <div class="ps-3">
                  <?php
                  $Items = $conn->query("SELECT * FROM `item_list` where `status` = 0")->num_rows;
                  ?>
                  <h6><?= format_num($Items) ?></h6>
                  <!-- <span class="text-success small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">increase</span> -->

                </div>
              </div>
            </div>

          </div>
        </div>
        <div class="col-xxl-6 col-xl-6 col-lg-4 col-md-4 col-sm-12 col-12">
          <div class="card info-card">
            <div class="card-body">
              <h5 class="card-title">Item Entry <span>| Published</span></h5>
              <div class="d-flex align-items-center justify-content-between">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-primary bg-opacity-25 text-primary">
                  <i class="bi bi-question-octagon"></i>
                </div>
                <div class="ps-3">
                  <?php
                  $items = $conn->query("SELECT * FROM `item_list` where `status` = 1")->num_rows;
                  ?>
                  <h6><?= format_num($items) ?></h6>
                  <!-- <span class="text-success small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">increase</span> -->

                </div>
              </div>
            </div>

          </div>
        </div>
      </div><!-- End Left side columns -->

    </div>
</section>