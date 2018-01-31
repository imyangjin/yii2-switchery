<?php

namespace yh\switchery;

use yii\base\InvalidConfigException;
use yii\grid\DataColumn;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\JsExpression;

/**
 * @package yh\switchery
 * @author  Hu Yang <127802495@qq.com>
 */
class Switchery extends DataColumn
{
    /**
     * @var string 操作名
     */
    public $action;

    public $callBack = 'function(data){console.log(data)}';

    /**
     * @var int 按钮开启状态值
     */
    public $statusOpen = 10;

    /**
     * @var int 按钮关闭状态值
     */
    public $statusClose = 0;

    public $inputClassName = 'js-switch';

    /**
     * @var array 用户设置
     */
    public $clientOptions = [];

    /**
     * @var array 默认设置
     */
    public $defaultOptions = [
        'color' => '#1AB394',
        'size'  => 'small'
    ];

    /**
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        if ($this->action === null) {
            throw new InvalidConfigException('Switchery::action must be set');
        }
        $this->registerAssetBundle();
        $this->registerClientScript();
    }

    /**
     * @param $model
     * @param $key
     * @param $index
     *
     * @return string
     */
    protected function renderDataCellContent($model, $key, $index)
    {
        $this->registerScript();

        return Html::input('checkbox', null, null, [
            'class'   => $this->inputClassName,
            'checked' => (bool)$model[$this->attribute] == $this->statusOpen,
            'id'      => $this->attribute,
            'data-key' => $key,
        ]);
    }

    /**
     * Register js
     */
    protected function registerScript()
    {
        $url       = Url::toRoute($this->action);
        $callBack  = $this->callBack instanceof JsExpression ? $this->callBack : new JsExpression($this->callBack);
        $attribute = $this->attribute;

        $js = <<<JS
 $(document).on('change','#$attribute',function(){
    var status = $(this).prop('checked') === false ? $this->statusClose : $this->statusOpen;
    $.get('$url',{key:$(this).data('key'),status:status},$callBack,'json');
});
JS;
        $this->grid->getView()->registerJs($js);
    }

    /**
     * Register assetBundle
     */
    protected function registerAssetBundle()
    {
        SwitcheryAsset::register($this->grid->getView());
    }

    /**
     * Registers the needed JavaScript.
     *
     * @since 2.0.8
     */
    public function registerClientScript()
    {
        $clientOptions = Json::encode(ArrayHelper::merge($this->defaultOptions, $this->clientOptions));
        $this->grid->getView()
            ->registerJs("Array.prototype.slice.call(document.querySelectorAll('.$this->inputClassName')).forEach(function(html) {new Switchery(html,$clientOptions);});");
    }
}
