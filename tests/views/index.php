<?php

declare(strict_types=1);

use id161836712\tinymce\TinyMce;
use yii\helpers\Html;

/** @var yii\web\View $this */
?>

<?php $this->beginPage(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?= Html::csrfMetaTags(); ?>
    <title>TinyMCE</title>
    <?php $this->head(); ?>
</head>
<body>
<?php $this->beginBody(); ?>

<?= TinyMce::widget(['name' => 'test']); ?>

<?php $this->endBody(); ?>
</body>
</html>
<?php $this->endPage(); ?>
