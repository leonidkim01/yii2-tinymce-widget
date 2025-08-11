<?php

declare(strict_types=1);

namespace id161836712\tinymce;

use Yii;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\InputWidget;

use function array_key_exists;
use function file_exists;
use function is_int;

/**
 * @inheritdoc
 */
final class TinyMce extends InputWidget
{
    private const DEFAULT_VERSION = 8;

    /**
     * @var ?int the TinyMCE library version
     */
    public ?int $version = null;

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
     * @see https://www.tiny.cloud/docs/tinymce/5/
     * @see https://www.tiny.cloud/docs/tinymce/6/
     * @see https://www.tiny.cloud/docs/tinymce/7/
     * @see https://www.tiny.cloud/docs/tinymce/8/
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
            $version = $this->getVersion();
            $langFile = "/langs{$version}/{$this->language}.js";
            $langAssetBundle = TinyMceI18nAsset::register($view);
            $filePath = "{$langAssetBundle->sourcePath}{$langFile}";

            if (file_exists($filePath)) {
                $langAssetBundle->js[] = $langFile;
                $this->clientOptions['language_url'] = "{$langAssetBundle->baseUrl}{$langFile}";
                $this->clientOptions['language'] = $this->language;
            }
        }

        $this->clientOptions['selector'] = "#$id";
        $this->clientOptions['license_key'] = $this->licenseKey;
        $this->clientOptions['promotion'] ??= false;

        $options = Json::encode($this->clientOptions);

        $view->registerJs(";tinymce.remove('#$id');tinymce.init($options);");
    }

    private function getVersion(): int
    {
        if ($this->version) {
            return $this->version;
        }

        if (array_key_exists('tinyMceVersion', Yii::$app->params) && is_int(Yii::$app->params['tinyMceVersion'])) {
            return Yii::$app->params['tinyMceVersion'];
        }

        return self::DEFAULT_VERSION;
    }
}
