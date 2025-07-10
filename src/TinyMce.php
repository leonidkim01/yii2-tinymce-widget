<?php

declare(strict_types=1);

namespace id161836712\tinymce;

use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\InputWidget;

use function file_exists;

/**
 * @inheritdoc
 */
final class TinyMce extends InputWidget
{
    /**
     * @var string the language to use.
     */
    public string $language = 'en';


    /**
     * @var string license key
     */
    public string $licenseKey = 'gpl';

    /**
     * @var array the options for the TinyMCE JS plugin.
     * Please refer to the TinyMCE JS plugin Web page for possible options.
     * @see https://www.tiny.cloud/docs/tinymce/7/
     */
    public array $clientOptions = [];

    /**
     * @inheritdoc
     */
    public function run(): string
    {
        $this->registerClientScript();

        if ($this->hasModel()) {
            return Html::activeTextarea($this->model, $this->attribute, $this->options);
        }

        return Html::textarea($this->name, $this->value, $this->options);
    }

    /**
     * Registers tinyMCE js plugin
     */
    private function registerClientScript(): void
    {
        $view = $this->getView();

        TinyMceAsset::register($view);

        $id = $this->options['id'];

        if ($this->language !== 'en') {
            $langFile = "{$this->language}.js";
            $langAssetBundle = TinyMceI18nAsset::register($view);
            $filePath = $langAssetBundle->sourcePath . DIRECTORY_SEPARATOR . $langFile;

            if (file_exists($filePath)) {
                $langAssetBundle->js[] = $langFile;
                $this->clientOptions['language_url'] = $langAssetBundle->baseUrl . "/{$langFile}";
                $this->clientOptions['language'] = $this->language;
            }
        }

        $this->clientOptions['selector'] = "#$id";
        $this->clientOptions['license_key'] = $this->licenseKey;
        $this->clientOptions['promotion'] ??= false;

        $options = Json::encode($this->clientOptions);

        $view->registerJs(";tinymce.remove('#$id');tinymce.init($options);");
    }
}
