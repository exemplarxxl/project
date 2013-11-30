<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
    'id'=>'update_object_address_type-form',
    'enableAjaxValidation'=>false,
    'action' => Yii::app()->createAbsoluteUrl('/admin/photos/ajaxUpdatePhotoTitle', array('photo_id'=> $photo->id)),
));?>
<div>
    <?php echo CHtml::image(Photos::getLinkPhoto($photo->id)) ?>
</div>
<div>
    <?php echo $form->textFieldRow($photo, 'title', ['class'=>'span4']) ?>
</div>
    <div class="modal-footer">
        <?php $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType' => 'submit',
            'type'=>'success',
            'label'=>'Сохранить',
            'url'=>'#',
            'htmlOptions'=>array('name'=>'save'),
        )); ?>
        <?php $this->widget('bootstrap.widgets.TbButton', array(
            'label'=>'Отмена',
            'url'=>'#',
            'htmlOptions'=>array('data-dismiss'=>'modal'),
        )); ?>
    </div>

<?php $this->endWidget(); ?>