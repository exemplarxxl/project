<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?= CHtml::encode($this->metaTitle) ?></title>
    <meta name="description" content="<?php CHtml::encode($this->metaDescription) ?>">
    <meta name="keywords" content="<?php CHtml::encode($this->metaKeywords) ?>">
</head>
<body>
<?php $this->widget('bootstrap.widgets.TbNavbar', array(
    //'brand' => 'Админпанель',
    'items' => array(
        array(
            'class' => 'bootstrap.widgets.TbMenu',
            'items' => array(
                array('label' => 'Страницы', 'url' => array('/admin/pages/index'), 'active' => isset($this->module) ? $this->module->id === 'pages' && $this->id === 'admin' : false),
                array('label' => 'Галлерея', 'url' => '#', 'items' => array(
                    array('label' => 'Альбомы', 'url' => array('/admin/albums/index'), 'active' => isset($this->module) ? $this->module->id === 'pages' && $this->id === 'admin' : false),
                    array('label' => 'Фотографии', 'url' => array('/admin/photos/index'), 'active' => isset($this->module) ? $this->module->id === 'pages' && $this->id === 'admin' : false),
                )

                ),
                array('label' => 'Настройки', 'url' => array('/admin/default/settings'), 'active' => isset($this->module) ? $this->module->id === 'pages' && $this->id === 'admin' : false),
            ),
        ),
    ),
)) ?>
<div class="container" style="margin-top: 40px;">
    <div class="row">
        <div class="span12">
            <!--div class="page-header">
                <h3><?= $this->pageTitle ?></h3>
            </div-->
            <?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
                'homeLink'=>CHtml::link('Админпанель', Yii::app()->createAbsoluteUrl('/admin/')),
                'links' => $this->breadcrumbs,
            )) ?>
            <?php $this->widget('bootstrap.widgets.TbAlert', array(
                'block' => true,
                'fade' => true,
                'closeText' => '&times;',
            )) ?>
        </div>

        <?php echo $content ?>
    </div>
    <?php
    Yii::app()->clientScript->registerScriptFile(Yii::app()->request->hostInfo.'/js/admin.js', CClientScript::POS_END);
    ?>

</div>
</body>
</html>