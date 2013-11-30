<?
$this->pageTitle = $page->page_title;
$this->metaTitle = $page->meta_title;
$this->metaDescription = $page->meta_description;
$this->metaKeywords = $page->meta_keywords;
$this->breadcrumbs = $page->breadcrumbs;
$this->layout = '//layouts/' . ($page->layout ? $page->layout : 'column1');
?>
    <div class="page-header">

            <?php if ( $page->id == 1 ) {
                $icon = '<img src="'.Yii::app()->request->hostInfo . '/css/about-gray.png" class="about-gray">';
            } elseif ( $page->id == 2 ) {
                $icon = '<img src="'. Yii::app()->request->hostInfo . '/css/air-gray.png" class="shipping-gray">';
            } ?>
        <h1><?php echo $icon . $page->page_title ?></h1>
    </div>
<?= $page->content ?>