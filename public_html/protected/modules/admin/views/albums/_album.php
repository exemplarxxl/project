<?
Yii::app()->clientScript->registerScriptFile('/libs/redactorjs/ru.js');
Yii::app()->clientScript->registerScriptFile('/libs/django-urlify/urlify.js');
Yii::app()->clientScript->registerScript('translit', "
$('#translit-btn').click(function() {
	$('#Albums_translit_title').val(URLify($('#Albums_title').val()));
});
");
?>

<?php echo $form->dropDownListRow($model, 'parent_id', $model->selectList(), array('class' => 'span6', 'empty' => '')) ?>

<?php echo $form->textFieldRow($model, 'title', array('class' => 'span6', 'maxlength' => 255)) ?>

<div class="control-group">
	<?php echo $form->labelEx($model, 'translit_title', array('class' => 'control-label', 'label' => 'Псевдоним')) ?>
	<div class="controls">
		<div class="input-append">
			<?php echo $form->textField($model, 'translit_title', array('class' => 'span5', 'maxlength' => 127)) ?><button class="btn" type="button" id="translit-btn">Транслит</button>
		</div>
	</div>
</div>

<?php echo $form->checkBoxRow($model, 'is_published') ?>
<?php if ( !$model->isNewRecord ) : ?>
    <div class="control-group">
        <div class="controls">
            <?php echo CHtml::image(Photos::getLinkPhoto($model->image, 'medium')) ?><br />
            <?php echo CHtml::link('Изменить обложку', '#',
                        ['onclick'=>'
                                var info = "";
                                    $.ajax({
                                        url: "' . Yii::app()->createAbsoluteUrl('/admin/albums/ajaxSelectCover') . '",
                                        cache: false,
                                        type: "POST",
                                        data: {album_id: ' . $model->id . '},
                                        success: function(html){
                                            $("#selectCover").html(html);
                                        }
                                    });
                                return false;

                        ',
                        'data-toggle'=>'modal','data-target'=>'#myModal'
                        ]); ?>
        </div>
    </div>
<?php endif; ?>

<?php /* $form->dropDownListRow($model, 'layout', array(
	'column1' => 'Одна колонка',
	'column2' => 'Две колонки',
), array('empty' => 'По умолчанию', 'class' => 'span3')) */?>

<div class="control-group">
	<?= $form->labelEx($model, 'description', array('class' => 'control-label')) ?>
	<div class="controls">
        <?php echo $this->widget('application.extensions.ckeditor.CKEditor', array(
            'model' => $model,
            'attribute' => 'description',
            'language' => '' . Yii::app()->language . '',
            'editorTemplate' => 'advanced', /* full, basic */
            'skin' => 'kama',
            'toolbar' => array(
                array('Source', '-', 'Bold', 'Italic', 'Underline', 'Strike'),
                array('Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo'),
                array('NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv'-'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'),
                array('Styles', 'Format', 'Font', 'FontSize', 'TextColor', 'BGColor'),
                array('Image', 'Link', 'Unlink', 'SpecialChar'),
            ),
            //'options' => $options,
            //'htmlOptions' => array('id' => $fieldId)
        ), true); ?>
		<? /*$this->widget('ext.imperavi-redactor.ImperaviRedactorWidget', array(
			'model' => $model,
			'attribute' => 'description',
			'options' => array(
				'lang' => 'ru',
			),
		)) */?>
	</div>
</div>

<?php $this->beginWidget('bootstrap.widgets.TbModal', array(
    'htmlOptions' => array(
        'id'=>'myModal',
        'style' => 'width: 880px; margin-left: -440px'
    )
    )); ?>

    <div class="modal-header">
        <a class="close" data-dismiss="modal">&times;</a>
        <h4>Изменить обложку</h4>

        <?php  ?>

        <?php $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType' => 'submit',
            'type'=>'active',
            'label'=>'Готово',
            //'url'=>Yii::app()->createAbsoluteUrl('/admin/albums/'),
            'htmlOptions'=>array('id'=>'btnSuccessSelectCover','name'=>'save','disabled'=>'disabled'),
        )); ?>

        <?php $this->widget('bootstrap.widgets.TbButton', array(
            'label'=>'Отмена',
            'url'=>'#',
            'htmlOptions'=>array('data-dismiss'=>'modal'),
        )); ?>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

        <?php echo CHtml::link('Загрузить фото', Yii::app()->createAbsoluteUrl('/admin/albums/cover', ['album_id'=>$model->id]), ['class'=>'btn btm-primary']) ?>

    </div>

    <div id="selectCover" class="modal-body">

    </div>
<?php $this->endWidget(); ?>
