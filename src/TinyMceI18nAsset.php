<?php

declare(strict_types=1);

namespace id161836712\tinymce;

use yii\web\AssetBundle;

/**
 * @inheritdoc
 */
final class TinyMceI18nAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@vendor/mklkj/tinymce-i18n';

    /**
     * @inheritdoc
     */
    public $js = [];

    /**
     * @inheritdoc
     */
    public $depends = [
        TinyMceAsset::class,
    ];
}
