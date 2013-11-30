<?php
/* @var $this SiteController */
/* @var $model ContactForm */
/* @var $form CActiveForm */

$this->pageTitle=Yii::app()->name . ' - Contact Us';
$this->breadcrumbs=array(
	'Contact',
);
?>
<div class="page-header">
    <h1><img src="<?php echo Yii::app()->request->hostInfo ?>/css/contacts-gray.png" class="contacts-gray">Контактная информация</h1>
</div>
<div class="contact-info">
    <?php echo ($settings->phone != null ) ? '<div class="contact-info-item">Тел.: <span>' . $settings->phone . '</span></div>' : ''; ?>
    <?php echo ($settings->mobile != null ) ? '<div class="contact-info-item">Моб.: <span>' . $settings->mobile . '</span></div>' : ''; ?>
    <?php echo ($settings->email != null ) ? '<div class="contact-info-item">Email: <span>' . $settings->email . '</span></div>' : ''; ?>
    <?php echo ($settings->address != null ) ? '<div class="contact-info-item">Адрес: <span>' . $settings->address . '</span></div>' : ''; ?>
</div>


<?php if(Yii::app()->user->hasFlash('contact')): ?>
<div class="flash-success">
	<?php echo Yii::app()->user->getFlash('contact'); ?>
</div>

<?php else: ?>
    <div class="page-header">
        <h1><img src="<?php echo Yii::app()->request->hostInfo ?>/css/email-gray.png" class="email-gray">Написать нам</h1>
    </div>
<div class="contact-form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'contact-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>


	<?php // echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name', ['class'=>'control-label']); ?>
        <div class="controls">
            <?php echo $form->textField($model,'name', ['class'=>'input-form']); ?>
            <?php echo $form->error($model,'name'); ?>
        </div>
	</div>


    <div class="row">
        <?php echo $form->labelEx($model,'email', ['class'=>'control-label']); ?>
        <div class="controls">
            <?php echo $form->textField($model,'email', ['class'=>'input-form']); ?>
            <?php echo $form->error($model,'email'); ?>
        </div>
    </div>


    <div class="row">
        <?php echo $form->labelEx($model,'subject', ['class'=>'control-label']); ?>
        <div class="controls">
            <?php echo $form->textField($model,'subject', ['class'=>'input-form']); ?>
            <?php echo $form->error($model,'subject'); ?>
        </div>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'body', ['class'=>'control-label']); ?>
        <div class="controls">
            <?php echo $form->textArea($model,'body', ['class'=>'contact-form-text']); ?>
            <?php echo $form->error($model,'body'); ?>
        </div>
    </div>


	<?php if(CCaptcha::checkRequirements()): ?>
        <div class="row">
            <?php echo $form->labelEx($model,'verifyCode', ['class'=>'control-label']); ?>
            <div class="controls">
                <?php $this->widget('CCaptcha', array('clickableImage'=>true, 'showRefreshButton'=>true, 'buttonLabel' => CHtml::image(Yii::app()->baseUrl
                        . '/images/refresh.png'),'imageOptions'=>array('style'=>'/*display:block;*/border:none;', /*'height'=>'40px',*/ 'alt'=>'Картинка с кодом валидации', 'title'=>'Чтобы обновить картинку, нажмите по ней'))); ?>
                <br /><?php echo $form->textField($model,'verifyCode', ['class'=>'contact-form-captcha']); ?>
                <?php echo $form->error($model,'verifyCode'); ?>
            </div>
        </div>
	<?php endif; ?>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Отправить', ['class'=>'submit-button']); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<?php endif; ?>