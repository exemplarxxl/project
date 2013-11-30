<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Login';
$this->breadcrumbs=array(
	'Login',
);
?>

<h1>Авторизация</h1>


<div class="login-form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'login-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

    <div class="row">
        <?php echo $form->labelEx($model,'username', ['class'=>'control-label']); ?>
        <div class="controls">
            <?php echo $form->textField($model,'username', ['class'=>'input-form']); ?>
            <?php echo $form->error($model,'username'); ?>
        </div>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'password', ['class'=>'control-label']); ?>
        <div class="controls">
            <?php echo $form->passwordField($model,'password', ['class'=>'input-form']); ?>
            <?php echo $form->error($model,'password'); ?>
        </div>
    </div>


    <div class="row">
        <div class="controls">
            <?php echo $form->checkBox($model,'rememberMe'); ?>
            <?php echo $form->label($model,'rememberMe'); ?>
            <?php echo $form->error($model,'rememberMe'); ?>
        </div>
    </div>
    <div class="row buttons">
        <?php echo CHtml::submitButton('Войти', ['class'=>'submit-button']); ?>
    </div>

<?php $this->endWidget(); ?>
</div><!-- form -->
