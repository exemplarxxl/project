<?
$this->pageTitle = 'Добавить фотографии';
$this->breadcrumbs=array(
    'Фотографии'=>array('index'),
    'Добавить',
);
?>
<h3>Альбом "<?php echo $album->title ?>"</h3>
<?php
$this->widget(
    'ext.widgets.uploadify_html5.EUploadifyHtml5Widget',
    array(
        // Название 'Filedata' не работает. В JavaScript скрипте строго прописано имя поля "Filedata"
        'name' => 'Filedata',
        'sessionParam' => 'PHP_SESSION_ID',
        'options' => array(
            'fileExt' => '*.jpg;*.png;*.gif',
            //'fileSizeLimit' => 10000,
            'uploadScript' => $this->createAbsoluteUrl('/admin/photos/ajaxPhotosUpload'),
            'formData' => "js:{'album_id': '" . $album->id ."'}",
            'auto' => true,
            'multi' => true,
            'removeCompleted' => true,
            'buttonClass' => 'btn btn-success',
            'buttonText' => 'Загрузить фотографии',
            'height' => 24,
            'width' => 150,
            'onUploadComplete' => "js:function(file, data) { location.href= '" . Yii::app()->createAbsoluteUrl('/admin/photos') ."' }",
        ),
    )
); ?>
    <br />
<?php echo CHtml::link('Загрузить позже', Yii::app()->createAbsoluteUrl('/admin/albums/'), ['class'=>'btn btn-primary']); ?>