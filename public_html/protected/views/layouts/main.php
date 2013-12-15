<!doctype html>
<html lang="ru">
    <head>
        <meta charset="UTF-8">
        <base href="<?php echo Yii::app()->getRequest()->getHostInfo() ?>" />
        <title><?php echo CHtml::encode($this->metaTitle) ?></title>
        <meta name="description" content="<?php echo CHtml::encode($this->metaDescription) ?>">
        <meta name="keywords" content="<?php echo CHtml::encode($this->metaKeywords) ?>">

        <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/style.css" rel="stylesheet"/>
        <?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
        <!-- IE6-8 support of HTML5 elements --> <!--[if lt IE 9]>
        <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        <?php
        Yii::app()->clientScript->registerScriptFile(Yii::app()->request->hostInfo.'/js/scrolltopcontrol.js', CClientScript::POS_END);
        ?>


        <?php if ( Yii::app()->params['christmas']['handler'] ) :?>
        <script src='<?php echo Yii::app()->request->baseUrl; ?>/js/snow/snowfall.jquery.js'></script>
        <style type="text/css">
            #garland {position:absolute;top:0;left:0;background-image:url('<?php echo Yii::app()->request->baseUrl; ?>/images/christmas-lights.png');height:36px;width:100%;overflow:hidden;z-index:99}
            #nums_1 {padding:100px}
            .garland_1 {background-position: 0 0}
            .garland_2 {background-position: 0 -36px}
            .garland_3 {background-position: 0 -72px}
            .garland_4 {background-position: 0 -108px}
        </style>

        <div id="garland" class="garland_4"><div id="nums_1">1</div></div>

        <script type="text/javascript">
            function garland() {
                nums = document.getElementById('nums_1').innerHTML
                if(nums == 1) {document.getElementById('garland').className='garland_1';document.getElementById('nums_1').innerHTML='2'}
                if(nums == 2) {document.getElementById('garland').className='garland_2';document.getElementById('nums_1').innerHTML='3'}
                if(nums == 3) {document.getElementById('garland').className='garland_3';document.getElementById('nums_1').innerHTML='4'}
                if(nums == 4) {document.getElementById('garland').className='garland_4';document.getElementById('nums_1').innerHTML='1'}
            }

            setInterval(function(){garland()}, 600)
        </script>
        <?php endif; ?>
    </head>
    <body>
    <?php if ( Yii::app()->params['christmas']['handler'] ) :?>
        <script type='text/javascript'>
            $(document).snowfall();
        </script>
    <?php endif; ?>
    <div class="share42init" data-top1="110" data-top2="110" data-margin="0" data-image="<?php echo Yii::app()->getRequest()->getHostInfo() ?>/images/logo-mini.png"></div>
    <script type="text/javascript" src="<?php echo Yii::app()->getRequest()->getHostInfo() ?>/share42/share42.js"></script>

    <div id="wrapper">

        <header>
            <?php if ( Yii::app()->params['christmas']['handler'] ) :?>
                <div id="logo"><a href="<?php echo Yii::app()->createAbsoluteUrl('/') ?>" ><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/logo_new_year.png" /></a></div>
            <?php else :?>
                <div id="logo"><a href="<?php echo Yii::app()->createAbsoluteUrl('/') ?>" ><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/logo.png" /></a></div>
            <?php endif; ?>
            <nav>
                <div  id="menu">
                    <!--img src="<?php echo Yii::app()->request->baseUrl; ?>/images/menu.png" /-->

                    <?php
                    $this->widget('ext.widgets.top-menu.TopMenu', array(
                        'items'=> [
                            ['label'=> 'О НАС','url'=>['/about'],'linkOptions'=>['id'=>'about']],
                            ['label'=> 'ПОРТФОЛИО','url'=>['/gallery/'],'linkOptions'=>['id'=>'gallery']],
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
            <div class="footer-logo">
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/footer_logo.png" alt="<?php echo Yii::app()->name ?>" >
            </div>

            <div class="footer-center">
                <div class="navigation">
                    <?php
                    $this->widget('zii.widgets.CMenu', array(
                        'items'=> [
                            ['label'=> 'О НАС','url'=>['/about'],'linkOptions'=>[]],
                            ['label'=> 'ПОРТФОЛИО','url'=>['/gallery/'],'linkOptions'=>[]],
                            ['label'=> 'ДОСТАВКА','url'=>['/shipping'],'linkOptions'=>[]],
                            ['label'=> 'КОНТАКТЫ','url'=>['/contacts'],'linkOptions'=>[]],
                        ],
                    ));
                    ?>
                </div>
                <div class="copyright">
                    &copy; 2013 <?php echo (date('Y') > 2013) ? '- '. date('Y') : '' ?> «<?php echo Yii::app()->name ?>». Все права защищены
                </div>

            </div>

            <?php $settings = Settings::model()->find(); ?>
            <div class="footer-contact-info">
                <?php echo ($settings->phone != null ) ? '<div class="contact-info-item">Тел.: <span>' . $settings->phone . '</span></div>' : ''; ?>
                <?php echo ($settings->mobile != null ) ? '<div class="contact-info-item">Моб.: <span>' . $settings->mobile . '</span></div>' : ''; ?>
                <?php echo ($settings->email != null ) ? '<div class="contact-info-item">Email: <span>' . $settings->email . '</span></div>' : ''; ?>
                <?php echo ($settings->address != null ) ? '<div class="contact-info-item">Адрес: <span>' . $settings->address . '</span></div>' : ''; ?>

                <div class="counter">

                    <a href="http://rangeweb.ru" title="Разработка сайта"><img src="http://rangeweb.ru/shared/logo/logo130x21.png" alt="Разработка сайта" /></a>
                    &nbsp;&nbsp;&nbsp;
                    <!--LiveInternet counter--><script type="text/javascript"><!--
                        document.write("<a href='http://www.liveinternet.ru/click' "+
                            "target=_blank><img src='//counter.yadro.ru/hit?t50.4;r"+
                            escape(document.referrer)+((typeof(screen)=="undefined")?"":
                            ";s"+screen.width+"*"+screen.height+"*"+(screen.colorDepth?
                                screen.colorDepth:screen.pixelDepth))+";u"+escape(document.URL)+
                            ";"+Math.random()+
                            "' alt='' title='LiveInternet' "+
                            "border='0' width='31' height='31'><\/a>")
                        //--></script><!--/LiveInternet-->

                </div>
            </div>


        </footer>
        </div>
    <script>

    </script>
    </body>
</html>

