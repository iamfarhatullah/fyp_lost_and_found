<?php require_once('./config.php'); ?>
<!DOCTYPE html>
<html lang="en">
<?php require_once('inc/header.php') ?>

<body class="toggle-sidebar">
  <?php $page = isset($_GET['page']) ? $_GET['page'] : 'home'; ?>
  <?php
  $pageSplit = explode("/", $page);
  if (isset($pageSplit[1]))
    $pageSplit[1] = (strtolower($pageSplit[1]) == 'list') ? $pageSplit[0] . ' List' : $pageSplit[1];
  ?>

  <?php require_once('inc/topBarNav.php') ?>

  <!-- === Main Content === -->
  <main id="main" class="main">
    <?php if (in_array($page, ['home'])): ?>
      <div class="container-fluid p-0">
        <div class="position-relative bg-dark text-white text-left" style="background-image: url('<?= validate_image($_settings->info('cover')) ?>'); background-size: cover; background-position: center; height: 70vh;">
          <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-50"></div>
          <div class="position-relative z-1 d-flex flex-column justify-content-top align-items-left h-100 p-5">
            <h1 class="display-4 fw-bold"><?= $_settings->info('name') ?></h1>
            <p class="lead">A safe place to find and return lost items.</p><br><br>
            <div style="width: 250px;">
              <a href="<?= base_url . '?page=items' ?>" class="btn btn-info btn-lg mt-3">Find all Items</a>
            </div>
          </div>
        </div>
      </div>
    <?php endif; ?>

    <div class="container-fluid py-5">
      <div id="msg-container">
        <?php if ($_settings->chk_flashdata('success')): ?>
          <script>
            alert_toast("<?= $_settings->flashdata('success') ?>", 'success')
          </script>
        <?php endif; ?>
      </div>

      <?php
      if (!file_exists($page . ".php") && !is_dir($page)) {
        include '404.html';
      } else {
        if (is_dir($page))
          include $page . '/index.php';
        else
          include $page . '.php';
      }
      ?>
    </div>
  </main>

  <!-- === Modals === -->
  <div class="modal fade" id="uni_modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-md">
      <div class="modal-content rounded-3">
        <div class="modal-header">
          <h5 class="modal-title"></h5>
        </div>
        <div class="modal-body"></div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" id="submit" onclick="$('#uni_modal form').submit()">Save</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="uni_modal_right" tabindex="-1">
    <div class="modal-dialog modal-dialog-scrollable modal-md">
      <div class="modal-content rounded-3">
        <div class="modal-header">
          <h5 class="modal-title"></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body"></div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="confirm_modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-md">
      <div class="modal-content rounded-3">
        <div class="modal-header">
          <h5 class="modal-title">Confirmation</h5>
        </div>
        <div class="modal-body">
          <div id="delete_content"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" id="confirm">Continue</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="viewer_modal" tabindex="-1">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <button type="button" class="btn-close position-absolute top-0 end-0 m-2" data-bs-dismiss="modal"></button>
        <img src="" class="w-100" alt="Preview">
      </div>
    </div>
  </div>

  <?php require_once('inc/footer.php') ?>
</body>

</html>