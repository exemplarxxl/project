<?php
/* @var $this DefaultController */

$this->breadcrumbs=array(
    $this->module->id,
);
?>

    <div class="page-header">
        <h1><img src="<?php echo Yii::app()->request->hostInfo ?>/css/gallery-gray.png" class="gallery-gray"><?php echo $album->title ?></h1>
    </div>

<?php echo $album->description ?>

    <div class="gallery">
        <?php $row = 0; ?>
        <?php foreach ( $albums as $album ) : ?>
            <?php if ( $row == 0 ) : ?>
                <div class="gallery-row">
            <?php endif; ?>
            <?php $row++ ?>
            <div class="gallery-photo">
                <?php
                echo '<span class="album-title">' . $album->title . '</span>';

                echo CHtml::link(
                    CHtml::image(Photos::getLinkPhoto($album->image, 'medium')),
                    Yii::app()->createAbsoluteUrl('/gallery/album', ['id'=>$album->id]),
                    array()); ?>
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