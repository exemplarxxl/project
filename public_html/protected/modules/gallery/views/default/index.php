<?php
/* @var $this DefaultController */
$this->pageTitle = 'Примеры наших работ';
$this->metaTitle = 'Примеры наших работ';
$this->metaDescription = 'Примеры работ выполнненых компанией Exemplar XXL';
$this->metaKeywords = 'Пример объемных фигур';
$this->breadcrumbs=array(
	$this->module->id,
);/*
$this->menu=array(
    array('label'=>'Сказочные персонажи','url'=>array('')),
    array('label'=>'Киногерои','url'=>array('')),
    array('label'=>'Крупногабаридные деревья','url'=>array('')),
    array('label'=>'Автомобили','url'=>array('')),
    array('label'=>'Эксклюзивные автомобили','url'=>array('')),
    array('label'=>'Животные','url'=>array('')),
    array('label'=>'Прочее...','url'=>array('')),
);*/
?>
<div class="page-header">
    <h1><img src="<?php echo Yii::app()->request->hostInfo ?>/css/gallery-gray.png" class="gallery-gray">Примеры наших работ</h1>
</div>
<?php foreach ( $albums as $album ) :?>
    <h2><?php echo $album->title; ?></h2>
    <div class="gallery">
        <?php $row = 0; ?>
        <?php foreach ( Albums::getChildAlbums($album->id) as $childAlbum ) : ?>
            <?php if ( $row == 0 ) : ?>
                <div class="gallery-row">
            <?php endif; ?>
            <?php $row++ ?>
            <div class="gallery-photo">
                <?php
                echo CHtml::link(
                    CHtml::image(Photos::getLinkPhoto($childAlbum->image, 'medium')),
                    Yii::app()->createAbsoluteUrl('/gallery/album', ['id'=>$childAlbum->id]),
                    array());
                echo '<div class="album-title">' . $childAlbum->title . '</div>';?>
            </div>
            <?php if ( $row == 2 ) : ?>
                </div>
                <?php $row = 0 ?>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
<?php endforeach; ?>