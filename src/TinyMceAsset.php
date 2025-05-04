<?php

declare(strict_types=1);

namespace id161836712\tinymce;

use yii\web\AssetBundle;

final class TinyMceAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@vendor/tinymce/tinymce';

    /**
     * @inheritdoc
     */
    public $js = [
        YII_ENV_DEV ? 'tinymce.js' : 'tinymce.min.js',
    ];
}
