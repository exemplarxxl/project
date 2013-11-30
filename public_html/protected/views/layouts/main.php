<!doctype html>
<html lang="ru">
    <head>
        <meta charset="UTF-8">

        <title><?php CHtml::encode($this->metaTitle) ?></title>
        <meta name="description" content="<?php CHtml::encode($this->metaDescription) ?>">
        <meta name="keywords" content="<?php CHtml::encode($this->metaKeywords) ?>">

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
                    <ul>
                        <li>
                            <?php echo CHtml::link('О НАС', Yii::app()->createAbsoluteUrl('/about'), ['id'=>'about']) ?>
                        </li>
                        <li>
                            <?php echo CHtml::link('ПОРТФОЛИО', Yii::app()->createAbsoluteUrl('/gallery'), ['id'=>'gallery']) ?>
                        </li>
                        <li>
                            <?php echo CHtml::link('ДОСТАВКА', Yii::app()->createAbsoluteUrl('/shipping'), ['id'=>'shipping']) ?>
                        </li>
                        <li>
                            <?php echo CHtml::link('КОНТАКТЫ', Yii::app()->createAbsoluteUrl('/contacts'), ['id'=>'contacts']) ?>
                        </li>
                    </ul>
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

