<?
$this->pageTitle = 'Настройки';
$this->breadcrumbs = array(
    $this->pageTitle,
);
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'page-form',
    'inlineErrors' => false,
    'type' => 'horizontal',
)) ?>

<?php echo $form->errorSummary($settings) ?>
<?php echo $form->errorSummary($admin) ?>
<? $this->widget('bootstrap.widgets.TbTabs', array(
    'type' => 'tabs',
    'tabs' => array(
        array(
            'label' => 'Контактная информация',
            'content' => $this->renderPartial('_contacts', array('form' => $form, 'settings' => $settings), true),
            'active' => true
        ),
        array(
            'label' => 'SEO',
            'content' => $this->renderPartial('_seo', array('form' => $form, 'settings' => $settings), true),
        ),
        array(
            'label' => 'Администратор',
            'content' => $this->renderPartial('_admin', array('form' => $form, 'admin' => $admin), true),
        ),
        array(
            'label' => 'Пользователи',
            'content' => $this->renderPartial('_users', array('form' => $form, 'users' => $users), true),
        ),
    ),
)) ?>

<div class="form-actions">
    <? $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'type' => 'primary',
        'label' => 'Сохранить',
    )) ?>
</div>

<? $this->endWidget() ?>
<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'myModal')); ?>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
    'id'=>'password-form',
    'enableAjaxValidation'=>true,
    'type' => 'horizontal',
)); ?>
<div class="modal-header">
    <a class="close" data-dismiss="modal">&times;</a>
    <h4>Изменение пароля</h4>
</div>

<div class="modal-body">
    <div id="message" style="display:none;color:red;margin-bottom: 10px"></div>

    <div class="control-group ">
        <?php echo CHtml::label('Новый пароль', 'new_password', ['class'=>'control-label']) ?>
        <div class="controls">
            <?php echo CHtml::textField('new_password','', array('id'=>'new_password','class'=>'span3','maxlength'=>255)) ?>
        </div>
    </div>
</div>

<div class="modal-footer">
    <?php echo CHtml::ajaxSubmitButton('Изменить', $this->createAbsoluteUrl('/admin/default/ajaxUpdatePassword'),
        array(
            'type'=>'POST',
            'dataType'=>'json',
            'success'=>'function(data) {
                                                if(data.status == "success") {
                                                        $("#myModal").modal("hide");
                                                         $("#new_password").val("");

                                                }
                                                if (data.status == "no_save") {
                                                    $("#myModal").modal("hide");
                                                    $("#new_password").val("");
                                                }
                                                if (data.status == "error") {
                                                    $("#message").html(data.data).fadeIn(200);
                                                    $("#new_password").val("");
                                                }

                                            }'),
        array('type' => 'submit', 'class'=>'btn btn-success'));
    ?><?php $this->widget('bootstrap.widgets.TbButton', array(
        'label'=>'Отмена',
        'url'=>'#',
        'htmlOptions'=>array('data-dismiss'=>'modal'),
    )); ?>

</div>
<?php $this->endWidget(); ?>

<?php $this->endWidget(); ?>

