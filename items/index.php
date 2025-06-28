<?php
if (isset($_GET['cid'])) {
    $category_qry = $conn->query("SELECT * FROM `category_list` WHERE `id` = '{$_GET['cid']}'");
    if ($category_qry->num_rows > 0) {
        foreach ($category_qry->fetch_assoc() as $k => $v) {
            $cat[$k] = $v;
        }
    }
}
?>

<div class="p-1" style="background-color: #046fa3;">
    <h2 class="text-white mt-2">Lost and Found Items</h2>
</div>
<br>
<div class="container-fluid">
    <div class="mb-4">
        <div class="nav nav-pills flex-nowrap overflow-auto gap-2">
            <?php
            $qry = $conn->query("SELECT * FROM `category_list` WHERE `status` = 1 ORDER BY name ASC");
            while ($row = $qry->fetch_assoc()):
            ?>
                <a href="<?= base_url . '?page=items&cid=' . $row['id'] ?>"
                    class="nav-link<?= (isset($_GET['cid']) && $_GET['cid'] == $row['id']) ? ' active' : ' btn-outline-primary' ?>">
                    <?= $row['name'] ?>
                </a>
            <?php endwhile; ?>
        </div>
    </div>
    <?php if (isset($cat['name'])): ?>
        <h5 class="mb-1"><?= $cat['name'] ?></h5>
    <?php endif; ?>
    <?php if (isset($cat['description'])): ?>
        <p class="text-muted"><?= nl2br(htmlspecialchars_decode($cat['description'])) ?></p>
    <?php endif; ?>
    <?php
    $where = isset($cat['id']) ? " AND `category_id` = '{$cat['id']}'" : "";
    $items = $conn->query("SELECT * FROM `item_list` WHERE `status` = 1 {$where} ORDER BY `title` ASC")->fetch_all(MYSQLI_ASSOC);
    ?>
    <?php if (count($items) > 0): ?>
        <div class="list-group">
            <?php foreach ($items as $row): ?>
                <a href="<?= base_url . '?page=items/view&id=' . $row['id'] ?>"
                    class="list-group-item list-group-item-action d-flex gap-3 align-items-start">
                    <img src="<?= validate_image($row['image_path']) ?>" alt="Item Image"
                        class="rounded" style="width: 80px; height: 80px; object-fit: cover;">
                    <div class="flex-grow-1">
                        <h6 class="mb-1"><?= $row['title'] ?></h6>
                        <p class="mb-0 text-muted text-truncate"><?= strip_tags(htmlspecialchars_decode($row['description'])) ?></p>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="text-center text-muted">No items listed yet.</div>
    <?php endif; ?>
</div>