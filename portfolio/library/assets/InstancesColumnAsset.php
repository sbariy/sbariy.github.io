<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 04.05.2016
 * Time: 12:07
 */

namespace app\assets;


class InstancesColumnAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@app/assets/instances-column';
    public $css = ['style.css'];
    public $js = ['script.js'];
    public $depends = [
        'yii\bootstrap\BootstrapPluginAsset'
    ];
}