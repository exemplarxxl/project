<?php
Yii::import('zii.widgets.CMenu');

class PortfolioMenu extends CMenu
{

    protected function isItemActive($item,$route)
    {

        if ( isset($item['url'])) {
            if ($item['url'][0] . $item['url']['id'] == Yii::app()->getRequest()->getUrl())
                return true;
        }

        return parent::isItemActive($item,$route);
    }


}