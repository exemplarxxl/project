<?php
Yii::import('zii.widgets.CMenu');

class TopMenu extends CMenu
{

    protected function renderMenuItem($item)
    {

        if(isset($item['url']))
        {
            $label=$this->linkLabelWrapper===null ? $item['label'] : CHtml::tag($this->linkLabelWrapper, $this->linkLabelWrapperHtmlOptions, $item['label']);
            return '<div class="nav-left"></div>
                                <div class="nav-center">'.
                                    CHtml::link($label,$item['url'],isset($item['linkOptions']) ? $item['linkOptions'] : array()) .
                                '</div>
                   <div class="nav-right"></div>';

        }
        else
            return CHtml::tag('span',isset($item['linkOptions']) ? $item['linkOptions'] : array(), $item['label']);

    }
    protected function isItemActive($item,$route)
    {
        if ( isset($item['url'])) {
            $pos = strripos(Yii::app()->getRequest()->getUrl(), $item['url'][0]);
            if ($pos === 0) {
                return true;
            }
        }
        return parent::isItemActive($item,$route);
    }

}