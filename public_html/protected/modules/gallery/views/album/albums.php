<?php
/* @var $this DefaultController */
$this->pageTitle = $album->title;
$this->metaTitle = $album->meta_title;
$this->metaDescription = $album->meta_description;
$this->metaKeywords = $album->meta_keywords;
$this->breadcrumbs=array(
    $this->module->id,
);

?>

    <div class="page-header">
        <h1><img src="<?php echo Yii::app()->request->hostInfo ?>/css/gallery-gray.png" class="gallery-gray"><?php echo $album->title ?></h1>
    </div>
    <?php if ( $album->description != null && $album->description != '' ) : ?>
        <div class="album-description">
            <?php echo $album->description ?>
        </div>
    <?php endif; ?>
    <div class="gallery">
        <?php $row = 0; ?>
        <?php foreach ( $albums as $album ) : ?>
            <?php if ( $row == 0 ) : ?>
                <div class="gallery-row">
            <?php endif; ?>
            <?php $row++ ?>
            <div class="gallery-photo">
                <?php


                echo CHtml::link(
                    CHtml::image(Photos::getLinkPhoto($album->image, 'medium')),
                    Yii::app()->createAbsoluteUrl('/gallery/album', ['id'=>$album->id]),
                    array());
                echo '<div class="album-title">' . $album->title . '</div>';?>
            </div>
            <?php if ( $row == 2 ) : ?>
                </div>
                <?php $row = 0 ?>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
<?php
$this->widget('ext.widgets.fancybox2.EFancyBox', array(
    'target'=>'.zoom',
    'config'=>array(
        'maxWidth'    => 800,
        'maxHeight'   => 600,
        'fitToView'   => true,
        //'helpersEnabled' => true,
        'loop'=>false,
        'width'       => '70%',
        'height'      => '70%',
        'autoSize'   => false,
        'closeClick'  => true,
        'openEffect'  => 'elastic',
        'closeEffect' => 'none'
    ),
));?>
<?php/* $this->widget('ext.widgets.fancybox.EFancyboxWidget', array(
// Список изображений с возможностью использования масок
'selector'=>'.zoom',
// Можно ли использовать колесико мышки для перемотки изображений в этой группе изображений
// (группа перечисляется в списке изображений выше). По умолчанию — нельзя.
//'enableMouseWheel'=>true,
// Свойства fancybox
'options' => array( // 'padding'=>10,
// 'margin'=>20,
 'enableEscapeButton'=>true,
),
)); */?>