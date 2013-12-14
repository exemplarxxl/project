<?php
    if ( $this->group == true ) {
        $action = Yii::app()->createAbsoluteUrl('/admin/photos/ajaxUpdateGroupPhotoTitle', array('photo_id'=> $photo->id));
    } else {
        $action = Yii::app()->createAbsoluteUrl('/admin/photos/ajaxUpdatePhotoTitle', array('photo_id'=> $photo->id));
    }
?>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
    'id'=>'update_object_address_type-form',
    'enableAjaxValidation'=>false,
    'action' => $action,
));?>
<div>
    <?php echo CHtml::image(Photos::getLinkPhoto($photo->id)) ?>
</div>
<div>
    <?php echo $form->textFieldRow($photo, 'title', ['class'=>'span4']) ?>
</div>
    <?php if ( $this->group ) : ?>
        <div>
            <?php echo $form->textFieldRow($photo, 'sort_group', ['class'=>'span1']) ?>
        </div>
    <?php else : ?>
        <div>
            <?php echo $form->textFieldRow($photo, 'sort', ['class'=>'span1']) ?>
        </div>
    <?php endif; ?>
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