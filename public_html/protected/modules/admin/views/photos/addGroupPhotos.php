<?
$this->pageTitle = 'Добавить фотографии';
$this->breadcrumbs=array(
    'Фотографии'=>array('index'),
    'Альбом "' . $album->title . '"',
);
?>

<?php echo Photos::getLinkPhotoByName($photo->image, $photo->album_id) ?>
<div class="btn-toolbar">
<?php
$this->widget(
    'ext.widgets.uploadify_html5.EUploadifyHtml5Widget',
    array(
        // Название 'Filedata' не работает. В JavaScript скрипте строго прописано имя поля "Filedata"
        'name' => 'Filedata',
        'sessionParam' => 'PHP_SESSION_ID',
        'options' => array(
            'fileExt' => '*.jpg;*.png;*.gif',
            'uploadScript' => $this->createAbsoluteUrl('/admin/photos/ajaxGroupPhotosUpload'),
            'formData' => "js:{'album_id': '" . $album->id . "', 'photo_id': '" . $photo->id ."'}",
            'auto' => true,
            'multi' => true,
            'removeCompleted' => true,
            'buttonClass' => 'btn btn-success',
            'buttonText' => 'Загрузить фотографии',
            'height' => 24,
            'width' => 150,
            'onUploadComplete' => "js:function(file, data) { location.href= '" . Yii::app()->createAbsoluteUrl('/admin/photos/groupPhoto', ['photo_id'=>$photo->id]) ."' }",
        ),
    )
); ?>
</div>
    <br />
<?php echo CHtml::link('Загрузить позже', Yii::app()->createAbsoluteUrl('/admin/photos/'), ['class'=>'btn btn-primary']); ?>