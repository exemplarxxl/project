<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>


<div class="middle">

    <div class="container">
        <main class="content">
            <?php if(Yii::app()->user->hasFlash('success')): ?>
                <div class="flash-success">
                    <?php echo Yii::app()->user->getFlash('success'); ?>
                </div>
            <?php endif; ?>
            <?php echo $content; ?>
        </main><!-- .content -->
    </div><!-- .container-->

    <aside class="left-sidebar">
        <?php
        $this->widget('ext.widgets.portfolio-menu.PortfolioMenu', array(
            'items'=>Albums::getListCategorForMenu(),
            'htmlOptions'=>array('class'=>'portfolio'),
        ));

        ?>

    </aside><!-- .left-sidebar -->

</div><!-- .middle-->
<?php $this->endContent(); ?>

<div id="button-order">Онлайн заявка</div>

<div id="modal_window">
    <span id="close"></span>

    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'order-form',
        'enableClientValidation'=>true,
        'action' => Yii::app()->createAbsoluteUrl('/site/order'),
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
        ),
    )); ?>
    <?php $order = new OrderForm(); ?>
    <h3>Оставить заявку</h3>

    <div class="row">
        <?php echo $form->labelEx($order,'name', ['class'=>'control-label']); ?>
        <div class="controls">
            <?php echo $form->textField($order,'name', ['class'=>'input-form']); ?>
            <?php echo $form->error($order,'name'); ?>
        </div>
    </div>

    <div class="row">
        <?php echo $form->labelEx($order,'phone', ['class'=>'control-label']); ?>
        <div class="controls">
            <?php echo $form->textField($order,'phone', ['class'=>'input-form']); ?>
            <?php echo $form->error($order,'phone'); ?>
        </div>
    </div>

    <div class="row">
        <?php echo $form->labelEx($order,'email', ['class'=>'control-label']); ?>
        <div class="controls">
            <?php echo $form->textField($order,'email', ['class'=>'input-form']); ?>
            <?php echo $form->error($order,'email'); ?>
        </div>
    </div>

    <div class="row">
        <?php echo $form->labelEx($order,'body', ['class'=>'control-label']); ?>
        <div class="controls">
            <?php echo $form->textArea($order,'body', ['class'=>'input-form']); ?>
            <?php echo $form->error($order,'body'); ?>
        </div>
    </div>
    <div class="buttons">
        <?php echo CHtml::submitButton('Отправить', ['class'=>'submit-button']) ?>
    </div>
    <?php $this->endWidget(); ?>
</div>
<div id="background"></div>

<script>
    function open_modal(box) {
        $("#background").show()
        $(box).centered_modal();
        $(box).delay(100).fadeIn(200);
    }
    function close_modal(box) {
        $(box).hide();
        //$("#background").delay(100).hide(1);
    }

    $(document).ready(function() {
        $.fn.centered_modal = function() {
            this.css("position","absolute");
            this.css("top", (($(window).height() - this.outerHeight()) / 2) + $(window).scrollTop() + "px");
            this.css("left", (($(window).width() - this.outerWidth()) / 2) + $(window).scrollLeft() + "px");
            return this;
        }

        $('#close').on('click', function(){
            close_modal('#modal_window');
        })

        $('#button-order').on('click', function(){
            open_modal('#modal_window');
        })
    });
</script>