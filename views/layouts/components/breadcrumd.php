<?php
$title = $title ?? '';
$items = $items ?? [];
$action_buttons = $action_buttons ?? [];
?>

<?php if ($title || $items || $action_buttons): ?>
  <nav aria-label="breadcrumb">
    <h3 class="h3"><?= $title ?></h3>
    <div class="row">
      <div class="col">
        <ol class="breadcrumb breadcrumb-style">
          <?php foreach ($items as $item): ?>
            <?php if (!empty($item['url'])): ?>
              <li class="breadcrumb-item">
                <a href="<?= $item['url'] ?>"><?= $item['label'] ?></a>
              </li>
            <?php else: ?>
              <li class="breadcrumb-item active">
                <?= $item['label'] ?>
              </li>
            <?php endif; ?>
          <?php endforeach; ?>
        </ol>
      </div>
      <div class="col-auto mb-3">
        <?php foreach ($action_buttons as $button): ?>
          <a href="<?= $button['url'] ?>" class="btn <?= $button['class'] ?>">
            <?= $button['icon'] ?> <?= $button['text'] ?>
          </a>
        <?php endforeach; ?>
      </div>
    </div>
  </nav>
<?php endif; ?>