<?php

declare(strict_types=1);

namespace id161836712\tests\tinymce;

use id161836712\tinymce\TinyMce;
use yii\base\DynamicModel;

final class TinyMceTest extends TestCase
{
    public function testRenderWithoutModel(): void
    {
        TinyMce::$counter = 0;
        $output = TinyMce::widget([
            'id' => 'test',
            'name' => 'name',
            'value' => 'value',
        ]);
        $expected = '<textarea id="test" name="name">value</textarea>';
        $this->assertEqualsWithoutLE($expected, $output);
    }

    public function testRenderWithModel(): void
    {
        $model = new DynamicModel(['text']);
        TinyMce::$counter = 0;
        $output = TinyMce::widget([
            'model' => $model,
            'attribute' => 'text',
        ]);
        $expected = '<textarea id="dynamicmodel-text" name="DynamicModel[text]"></textarea>';
        $this->assertEqualsWithoutLE($expected, $output);
    }
}
