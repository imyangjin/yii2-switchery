switchery for yii2
==================
switchery for yii2
![images](https://github.com/pcyanglei/yii2-switchery/blob/master/1a5b3a90-d304-40fc-ac54-afdcfd3bfdae.png)
Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist yh/yii2-switchery "dev-master"
```

or add

```
"yh/yii2-switchery": "dev-master"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by  :

view:
```php
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'tableOptions' => ['class' => 'table table-striped'],
    'columns' => [
        'id',
        'username',
        'email:email',
        'status',
        [
            'class'       => 'yh\switchery\Switchery',
            'attribute'   => 'status',
            'action'      => 'user/status',//发送ajax的地址
            'callBack'    => 'function(data){console.log(data)}',
            'statusOpen'  =>10,//default 10
            'statusClose' =>0//default 0
        ],
        'created_at:datetime',
        'updated_at:datetime',
    ],
]); ?>
```
controller:
```php
public function actionStatus($key,$status)
{
    \Yii::$app->getResponse()->format = 'json';
    $model = User::findOne($key);
    $model->status = $status;
    $model->save(false);
    return ['code' => 0,'message' => 'ok'];
}
```