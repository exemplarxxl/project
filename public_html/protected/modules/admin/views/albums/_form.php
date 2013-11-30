<? $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'page-form',
    'inlineErrors' => false,
    'type' => 'horizontal',
)) ?>

<?= $form->errorSummary($model) ?>

<? $this->widget('bootstrap.widgets.TbTabs', array(
    'type' => 'tabs',
    'tabs' => array(
        array(
            'label' => 'Альбом',
            'content' => $this->renderPartial('_album', array('form' => $form, 'model' => $model), true),
            'active' => true
        ),
        array(
            'label' => 'SEO',
            'content' => $this->renderPartial('_seo', array('form' => $form, 'model' => $model), true),
        ),
    ),
)) ?>

<div class="form-actions">
    <? $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'type' => 'primary',
        'label' => $model->isNewRecord ? 'Добавить' : 'Сохранить',
    )) ?>
</div>

<? $this->endWidget() ?>
