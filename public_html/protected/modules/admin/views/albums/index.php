<?
$this->pageTitle = 'Альбомы';
$this->breadcrumbs = array(
    $this->pageTitle,
);
Yii::app()->clientScript->registerCssFile('/libs/treetable/jquery.treeTable.css');
Yii::app()->clientScript->registerScriptFile('/libs/treetable/jquery.treeTable.js');
Yii::app()->clientScript->registerScript('treetable', "
$('.table').treeTable({
	expandable: true,
	initialState: 'expanded'
});
");
?>

    <div class="btn-toolbar">
        <?= CHtml::link('Добавить альбом', array('create'), array('class' => 'btn')) ?>
    </div>

<? $this->widget('TbGridViewTree', array(
    'id' => 'album-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'afterAjaxUpdate'=>"js:function() {
$('.table').treeTable({
	expandable: true,
	initialState: 'expanded'
});
}",
    'columns' => array(
        array(
            'name' => 'sort',
            'headerHtmlOptions' => array(
                'width' => 50,
                'style' => 'text-align: center'

            ),
            'htmlOptions' => array('style' => 'text-align: center;'),
        ),
        /*array(
            'name' => 'id',
            'headerHtmlOptions' => array(
                'width' => 50,
                'style' => 'text-align: center'
            ),
        ),*/
        array(
            'name' => 'title',
            //'filter' => Albums::model()->selectList(),
            'headerHtmlOptions' => array(
                'style' => 'text-align: center'
            ),
            'filter' => Albums::getListTitleAlbums(),
            'type'=>'raw',
            'value' => 'Albums::countLinkToChildAlbum($data->id) . " " . CHtml::link("(" . Photos::countAlbumPhotos($data->id) . ")", Yii::app()->createAbsoluteUrl("/admin/photos/index?Photos%5Balbum_id%5D=$data->id"))',
        ),
        array(
            'name' => 'parent_id',
            //'filter' => Albums::model()->selectList(),
            'headerHtmlOptions' => array(
                'style' => 'text-align: center'
            ),
            'filter' => Albums::model()->selectList(),
            'type'=>'raw',
            'value'=>'CHtml::link(Albums::getNameById($data->parent_id), Yii::app()->createAbsoluteUrl("/admin/albums/index?Albums%5Bid%5D=$data->parent_id"))',
        ),
        array(
            'name' => 'image',
            'type' => 'image',
            'filter' => false,
            'headerHtmlOptions' => array(
                'style' => 'text-align: center'
            ),
            'htmlOptions' => array('style' => 'width: 170px;text-align:center;vertical-align:middle'),
            'value' => 'Photos::getLinkPhoto($data->image)'
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
            'template' => '{uploadPhotos}<hr>{up} {down} {update} {delete}',
            'buttons' => array(
                'up' => array(
                    'label' => 'Переместить выше',
                    'imageUrl' => $url = Yii::app()->assetManager->publish(
                            Yii::getPathOfAlias('zii.widgets.assets.gridview').'/up.gif'
                        ),
                    'url'=>'Yii::app()->createUrl("/admin/albums/move", array("id"=>$data->id, "moving" => "up"))',
                    'options' => array('class'=>'arrow_image_up'),
                    'visible' => '$data->sort > Albums::getMinSort($data->level,$data->parent_id)',
                    'click' => "js: function() { ajaxMoveRequest($(this).attr('href'), 'album-grid'); return false;}",
                ),
                'down' => array(
                    'label' => 'Переместить ниже',
                    'imageUrl' => $url = Yii::app()->assetManager->publish(
                            Yii::getPathOfAlias('zii.widgets.assets.gridview').'/down.gif'
                        ),
                    'url'=>'Yii::app()->createUrl("/admin/albums/move", array("id"=>$data->id, "moving" => "down"))',
                    'options' => array('class'=>'arrow_image_down'),
                    'visible' => '$data->sort < Albums::getMaxSort($data->level,$data->parent_id)',
                    'click' => "js: function() { ajaxMoveRequest($(this).attr('href'), 'album-grid'); return false;}",
                ),
                'uploadPhotos' => array(
                    'label' => 'Добавить фотографии',
                    'options' => array('class' => 'grey'),
                    'url' => 'Yii::app()->createAbsoluteUrl("/admin/photos/addPhotos", array("album_id"=>$data->id))',
                ),
            )


        ),
    ),
)) ?>