<?php

declare(strict_types=1);

namespace id161836712\tests\tinymce;

use id161836712\tinymce\TinyMce;
use id161836712\tinymce\TinyMceAsset;
use id161836712\tinymce\TinyMceI18nAsset;

final class TinyMceI18NAssetTest extends TestCase
{
    public function testRegister(): void
    {
        TinyMce::$counter = 0;

        $view = $this->getView();
        $this->assertEmpty($view->assetBundles);
        $asset = TinyMceI18nAsset::register($view);
        $asset->js[] = 'fi.js';
        $this->assertArrayHasKey(TinyMceAsset::class, $view->assetBundles);
        $this->assertArrayHasKey(TinyMceI18nAsset::class, $view->assetBundles);
        $content = $view->render('@id161836712/tests/tinymce/views/index');

        foreach ($asset->js as $js) {
            $this->assertStringContainsString("{$asset->baseUrl}/{$js}\"></script>", $content);
        }
        foreach ($asset->css as $css) {
            $this->assertStringContainsString("{$asset->baseUrl}/{$css}\"></script>", $content);
        }
    }
}
