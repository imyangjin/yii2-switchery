<?php
namespace yh\switchery;

use yii\web\AssetBundle;
/**
 * @package yh\switchery
 * @author Hu Yang <127802495@qq.com>
 */
class SwitcheryAsset extends AssetBundle
{
    public $sourcePath = '@bower/switchery/dist';
    public $js = [
        'switchery.js',
    ];
    public $css = [
        'switchery.css'
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}