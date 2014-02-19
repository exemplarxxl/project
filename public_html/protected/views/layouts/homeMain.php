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
    <script>

        jQuery(document).ready(function($) {

            var bodyH = $(window).height() / 2;
            $("body").after('<div id="system-load" style="position:fixed;'
                + 'top:0px; left:0px; background: #333333; width:100%; height:100%;'
                + 'z-index:99999999; color:#fff; padding-top:' + bodyH + 'px;"'
                + 'align="center">'
                + '<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/ajax-loader.gif"'
                + ' alt="Пожалуйста, подождите..." /></div>');
            $(window).bind('load', function() {
                $('#system-load').fadeOut('slow').remove();
                $("#home_logo").hide();
                $("#menu").hide();
                $("#home_logo").fadeIn(3000);
                $("#menu").fadeIn(3000);
            });

        });
        $(document).ready(function(){
            $("nav a").click(function(){
                var link = $(this).attr('href');
                //var content = $(this).attr("id");
                $(this).attr('href', '#!');
                $("#home_logo").animate({
                    marginTop: "0px"
                }, 500, function() {
                    location.href = link;
                });
            });
        });
    </script>

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
<div id="wrapper">
    <header>
        <?php if ( Yii::app()->params['christmas']['handler'] ) :?>
            <div id="home_logo"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/logo_new_year.png" /></div>
        <?php else :?>
        <div id="home_logo"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/logo.png" /></div>
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
    <section>
        <div id="sidebar"></div>
    </section>
    <!--footer>
        <div class="footer_navigation">
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
        </address>
    </footer-->
    <!-- Yandex.Metrika counter -->
    <script type="text/javascript">
        (function (d, w, c) {
            (w[c] = w[c] || []).push(function() {
                try {
                    w.yaCounter24042646 = new Ya.Metrika({id:24042646,
                        webvisor:true,
                        clickmap:true,
                        trackLinks:true,
                        accurateTrackBounce:true});
                } catch(e) { }
            });

            var n = d.getElementsByTagName("script")[0],
                s = d.createElement("script"),
                f = function () { n.parentNode.insertBefore(s, n); };
            s.type = "text/javascript";
            s.async = true;
            s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js";

            if (w.opera == "[object Opera]") {
                d.addEventListener("DOMContentLoaded", f, false);
            } else { f(); }
        })(document, window, "yandex_metrika_callbacks");
    </script>
    <noscript><div><img src="//mc.yandex.ru/watch/24042646" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
    <!-- /Yandex.Metrika counter -->

    <!--LiveInternet counter--><script type="text/javascript"><!--
        document.write("<a href='http://www.liveinternet.ru/click' "+
            "target=_blank><img src='//counter.yadro.ru/hit?t50.4;r"+
            escape(document.referrer)+((typeof(screen)=="undefined")?"":
            ";s"+screen.width+"*"+screen.height+"*"+(screen.colorDepth?
                screen.colorDepth:screen.pixelDepth))+";u"+escape(document.URL)+
            ";"+Math.random()+
            "' alt='' title='LiveInternet' "+
            "border='0' width='0' height='0'><\/a>")
        //--></script><!--/LiveInternet-->
</div>
<script>

</script>
</body>
</html>

