<?
$this->pageTitle = 'Альбом "' . $photo->album->title . '"';
$this->breadcrumbs = array(
    'Фотографии'=>array('index'),
    'Дополнительные фотографии',
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
                'formData' => "js:{'album_id': '" . $photo->album_id . "', 'photo_id': '" . $photo->id ."'}",
                'auto' => true,
                'multi' => true,
                'removeCompleted' => true,
                'buttonClass' => 'btn btn-success',
                'buttonText' => 'Добавить фотографии',
                'height' => 24,
                'width' => 150,
                'onUploadComplete' => "js:function(file, data) { location.href= '" . Yii::app()->createAbsoluteUrl('/admin/photos/groupPhoto', ['photo_id'=>$photo->id]) ."' }",
            ),
        )
    ); ?>
</div>


<? $this->widget('TbGridViewTree', array(
    'id' => 'photos-grid',
    'dataProvider' => $groupPhotos->searchGroup(),
    'filter' => $groupPhotos,
    'afterAjaxUpdate'=>"js:function() {
$('.table').treeTable({
	expandable: true,
	initialState: 'expanded'
});
}",
    'columns' => array(
        array(
            'name' => 'sort_group',
            'headerHtmlOptions' => array(
                'width' => 50,
                'style' => 'text-align: center'

            ),
            'htmlOptions' => array('style' => 'text-align: center;'),
        ),
        array(
            'name' => 'image',
            'type' => 'image',
            'headerHtmlOptions' => array(
                'style' => 'text-align: center'
            ),
            'htmlOptions' => array('style' => 'width: 170px;text-align:center;vertical-align:middle'),
            'value' => 'Photos::getLinkPhoto($data->id)'
        ),
        array(
            'name' => 'title',
        ),
        array(
            'name' => 'album_id',
            'filter' => Albums::model()->selectList(),
            'type'=>'raw',
            'value'=>'CHtml::link(Albums::getNameById($data->album_id), Yii::app()->createAbsoluteUrl("/admin/albums/index?Albums%5Bid%5D=$data->album_id"))',
        ),
        array(
            'class' => 'ext.jtogglecolumn.JToggleColumn',
            'name' => 'is_published',
            'filter' => array('0' => 'Нет', '1' => 'Да'),
            'checkedButtonLabel' => 'Снять с публикации',
            'uncheckedButtonLabel' => 'Опубликовать',
            'headerHtmlOptions' => array('width' => 100, 'text-align' => 'center'),
            'htmlOptions' => array('style' => 'text-align: center;'),
        ),

        array(
            'class'=>'bootstrap.widgets.TbButtonColumn',
            'template' => '{up} {down}<br />{update} {delete}',
            'buttons' => array(

                'up' => array(
                    'label' => 'Переместить выше',
                    'imageUrl' => $url = Yii::app()->assetManager->publish(
                            Yii::getPathOfAlias('zii.widgets.assets.gridview').'/up.gif'
                        ),
                    'url'=>'Yii::app()->createUrl("/admin/photos/moveGroup", array("id"=>$data->id, "moving" => "up"))',
                    'options' => array('class'=>'arrow_image_up'),
                    'visible' => '$data->sort_group > Photos::getMinSortGroup($data->group_id)',
                    'click' => "js: function() { ajaxMoveRequest($(this).attr('href'), 'photos-grid'); return false;}",
                ),
                'down' => array(
                    'label' => 'Переместить ниже',
                    'imageUrl' => $url = Yii::app()->assetManager->publish(
                            Yii::getPathOfAlias('zii.widgets.assets.gridview').'/down.gif'
                        ),
                    'url'=>'Yii::app()->createUrl("/admin/photos/moveGroup", array("id"=>$data->id, "moving" => "down"))',
                    'options' => array('class'=>'arrow_image_down'),
                    'visible' => '$data->sort_group < Photos::getMaxSortGroup($data->group_id)',
                    'click' => "js: function() { ajaxMoveRequest($(this).attr('href'), 'photos-grid'); return false;}",
                ),
                'update' => array(
                    'label' => 'Редактировать',
                    'options' => array('live' => false,'data-toggle'=>'modal','data-target'=>'#myModal',),
                    'url' => 'Yii::app()->createAbsoluteUrl("/admin/photos/ajaxUpdateGroupPhotoTitle", array("photo_id"=>$data->id))',
                    'click' => 'function(){
                                var link = $(this).attr("href");
                                $(this).attr("href", "#");
                                var info = "";
                                    $.ajax({
                                        url: link,
                                        cache: false,
                                        data: info,
                                        success: function(html){
                                            $("#updatePhotoTitle").html(html);
                                        }
                                    });
                                $(this).attr("href", link);
                                return false;
                                }',
                    'visible' => '1',
                )
            )
        ),
    ),
)) ?>

<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'myModal')); ?>

<div class="modal-header">
    <a class="close" data-dismiss="modal">&times;</a>
    <h4>Редактирование фото</h4>
</div>

<div id="updatePhotoTitle" class="modal-body">

</div>
<?php $this->endWidget(); ?>
<script>
    function ajaxMoveRequest(url, tableId){
        $.ajax({
            url: url,
            data: {ajax:1},
            method: "get",
            success: function(){
                $("#"+tableId).yiiGridView.update(tableId);
            }
        });
    }
</script>