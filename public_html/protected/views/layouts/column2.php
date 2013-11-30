<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>


<div class="middle">

    <div class="container">
        <main class="content">
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