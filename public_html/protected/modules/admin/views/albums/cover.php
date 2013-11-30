<?
$this->pageTitle = 'Альбомы';
$this->breadcrumbs = array(
    $this->pageTitle,
);
?>

<?php
$this->widget(
    'ext.widgets.uploadify_html5.EUploadifyHtml5Widget',
    array(
        // Название 'Filedata' не работает. В JavaScript скрипте строго прописано имя поля "Filedata"
        'name' => 'Filedata',
        'sessionParam' => 'PHP_SESSION_ID',
        'options' => array(
            'fileExt' => '*.jpg;*.png;*.gif',
            'uploadScript' => $this->createAbsoluteUrl('/admin/albums/ajaxCoverUpload'),
            'formData' => "js:{'album_id': '" . $album_id ."'}",
            'auto' => true,
            'multi' => false,
            'removeCompleted' => true,
            'buttonClass' => 'btn btn-success',
            'buttonText' => 'Загрузить обложку',
            'height' => 24,
            'width' => 150,
            'onUploadComplete' => "js:function(file, data) { location.href= '" . Yii::app()->createAbsoluteUrl('/admin/albums') ."' }",
        ),
    )
); ?>
<br />
<?php echo CHtml::link('Загрузить позже', Yii::app()->createAbsoluteUrl('/admin/albums/'), ['class'=>'btn btn-primary']); ?>