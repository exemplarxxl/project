<!doctype html>
<html lang="ru">
    <head>
        <meta charset="UTF-8">
        <title><?php echo CHtml::encode($this->metaTitle) ?></title>
        <meta name="description" content="<?php echo CHtml::encode($this->metaDescription) ?>">
        <meta name="keywords" content="<?php echo CHtml::encode($this->metaKeywords) ?>">

        <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/style.css" rel="stylesheet"/>
        <?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
        <!-- IE6-8 support of HTML5 elements --> <!--[if lt IE 9]>
        <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

    </head>
    <body>


    <div id="wrapper">
        <header>
            <hgroup>
                <div id="logo"><a href="<?php echo Yii::app()->createAbsoluteUrl('/') ?>" ><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/logo3.png" /></a></div>
            </hgroup>
            <nav>
                <div  id="menu">
                    <!--img src="<?php echo Yii::app()->request->baseUrl; ?>/images/menu.png" /-->

                    <?php
                    $this->widget('ext.widgets.top-menu.TopMenu', array(
                        'items'=> [
                            ['label'=> 'О НАС','url'=>['/about'],'linkOptions'=>['id'=>'about']],
                            ['label'=> 'ПОРТФОЛИО','url'=>['/gallery'],'linkOptions'=>['id'=>'gallery']],
                            ['label'=> 'ДОСТАВКА','url'=>['/shipping'],'linkOptions'=>['id'=>'shipping']],
                            ['label'=> 'КОНТАКТЫ','url'=>['/contacts'],'linkOptions'=>['id'=>'contacts']],
                        ],
                    ));

                    ?>
                </div>
            </nav>
        </header>
        <?php echo $content; ?>
        <footer>
            <!--div class="footer_navigation">
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="#">About HTML5</a></li>
                </ul>
            </div>
            <hgroup>
                <h3>By Pavel Mikuta</h3>
                <h4>from Moscow, Russia</h4>
            </hgroup>
            <address>
                <a href="mailto:mikuta.pavel@gmail.com">Email Me</a>
            </address-->
        </footer>
        </div>
    <script>

    </script>
    </body>
</html>

