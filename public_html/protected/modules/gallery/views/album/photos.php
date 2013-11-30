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

<?php echo $album->description ?>
<div class="gallery">
    <?php $row = 0; ?>
    <?php foreach ( $photos as $photo ) : ?>
        <?php if ( $row == 0 ) : ?>
            <div class="gallery-row">
        <?php endif; ?>
            <?php $row++ ?>
        <div class="gallery-photo">

            <?php
            $criteria = new CDbCriteria();
            $criteria->condition = 'group_id=:group_id AND is_published=1';
            $criteria->params = [':group_id'=>$photo->id];
            $criteria->order = 'sort_group ASC';
            $groupPhotos = Photos::model()->findAll($criteria);

            if ( $groupPhotos != null ) {
                 $count = 0;
                 foreach ( $groupPhotos as $groupPhoto ) {

                    if ( $count == 0 ) {
                        echo CHtml::link(
                            CHtml::image(Photos::getLinkPhotoByName($photo->image, $photo->album_id, 'medium', false)),
                            Photos::getLinkPhotoByName($groupPhoto->image, $groupPhoto->album_id, 'large', false),
                            array('rel'=>'group','class'=>'zoom', 'title'=>$groupPhoto->title));

                        $count++;
                        continue;
                    }
                    echo CHtml::link('',
                        Photos::getLinkPhotoByName($groupPhoto->image, $groupPhoto->album_id, 'large', false),
                    array('rel'=>'group','class'=>'zoom', 'title'=>$groupPhoto->title));
                     $count++;
                 }
            } else {
                $count = 1;
                echo CHtml::link(
                    CHtml::image(Photos::getLinkPhotoByName($photo->image, $photo->album_id, 'medium', false)),
                    Photos::getLinkPhotoByName($photo->image, $photo->album_id, 'large', false),
                    array('rel'=>'group','class'=>'zoom', 'title'=>$photo->title));
            }
            echo '<span class="gallery-title">' . $photo->title . ' <i>' . $count .' фото</i></span>';
            ?>
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