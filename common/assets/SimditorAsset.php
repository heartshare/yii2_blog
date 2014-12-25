<?php
/**
 * Simditor富文本编辑器
 */

namespace common\assets;

use yii\web\AssetBundle;

/**
 * @author Fufeng Nie <niefufeng@gmail.com>
 * @since 2.0
 */
class SimditorAsset extends AssetBundle
{
    public $sourcePath = '@common/assetSource';
    public $baseUrl = '@web';
    public $css = [
        'plugins/simditor/styles/font-awesome.css',
        'plugins/simditor/styles/simditor.css'
    ];
    public $js = [
        'plugins/simditor/scripts/module.min.js',
        'plugins/simditor/scripts/uploader.min.js',
        'plugins/simditor/scripts/simditor.min.js',
        'js/simditor-common.js'
    ];
    public $depends = [
        'yii\web\JqueryAsset'
    ];
}
