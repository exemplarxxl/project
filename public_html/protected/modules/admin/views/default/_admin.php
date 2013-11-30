<?php echo $form->textFieldRow($admin, 'name', array('class' => 'span8', 'maxlength' => 255)) ?>
<?php echo $form->textFieldRow($admin, 'login', array('class' => 'span8', 'maxlength' => 255)) ?>
<?php echo $form->textFieldRow($admin, 'phone', array('class' => 'span8', 'maxlength' => 255)) ?>
<?php echo $form->textFieldRow($admin, 'email', array('class' => 'span8', 'maxlength' => 255)) ?>
<div style="margin-left: 180px">
    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'label'=>'Изменить пароль',
        'type'=>'action',
        'htmlOptions'=>array(
            'data-toggle'=>'modal',
            'data-target'=>'#myModal',
        ),
    )); ?>
</div>


