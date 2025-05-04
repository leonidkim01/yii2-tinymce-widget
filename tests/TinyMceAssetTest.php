<?php

declare(strict_types=1);

namespace id161836712\tests\tinymce;

use id161836712\tinymce\TinyMce;
use id161836712\tinymce\TinyMceAsset;

final class TinyMceAssetTest extends TestCase
{
    public function testRegister(): void
    {
        TinyMce::$counter = 0;

        $view = $this->getView();
        $this->assertEmpty($view->assetBundles);
        $asset = TinyMceAsset::register($view);
        $this->assertArrayHasKey(TinyMceAsset::class, $view->assetBundles);
        $content = $view->renderFile('@id161836712/tests/tinymce/views/index.php');

        foreach ($asset->js as $js) {
            $this->assertStringContainsString("{$asset->baseUrl}/{$js}\"></script>", $content);
        }
        foreach ($asset->css as $css) {
            $this->assertStringContainsString("{$asset->baseUrl}/{$css}\"></script>", $content);
        }

        $this->assertStringContainsString('tinymce.remove', $content);
        $this->assertStringContainsString('tinymce.init', $content);
    }
}
