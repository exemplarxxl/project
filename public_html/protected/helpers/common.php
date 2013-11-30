<?php
/**********************************************************************************************
*                            CMS Open Business Card
*                              -----------------
*	version				:	1.2.0
*	copyright			:	(c) 2013 Monoray
*	website				:	http://www.monoray.ru/
*	contact us			:	http://www.monoray.ru/contact
*
* This file is part of CMS Open Business Card
*
* Open Business Card is free software. This work is licensed under a GNU GPL.
* http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
*
* Open Business Card is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
* Without even the implied warranty of  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
***********************************************************************************************/



function param($name, $default = null) {
	if (isset(Yii::app()->params[$name]))
		return Yii::app()->params[$name];
	else
		return $default;
}

function throw404(){
	throw new CHttpException(404, 'Запрашиваемая страница не найдена.');
}

function rrmdir($dir) {
	if (is_dir($dir)) {
		$objects = scandir($dir);
		if($objects){
			foreach ($objects as $object) {
				if ($object != "." && $object != "..") {
					if (filetype($dir . "/" . $object) == "dir")
						rrmdir($dir . "/" . $object);
					else
						unlink($dir . "/" . $object);
				}
			}
		}
		reset($objects);
		rmdir($dir);
	}
}

function issetModule($module) {
    if (is_array($module)) {
        foreach ($module as $module_name) {
            if (!isset(Yii::app()->modules[$module_name])) {
                return false;
            }
        }
        return true;
    }
    return isset(Yii::app()->modules[$module]);
}

function showMessage($messageTitle, $messageText , $breadcrumb = '', $isEnd = true) {
	 Yii::app()->controller->render('message', array('breadcrumb' => $breadcrumb,
					'messageTitle' => $messageTitle,
					'messageText'  => $messageText));

	 if ($isEnd) {
		Yii::app()->end();
	 }
}

function isActive($string){
    $menu_active = Yii::app()->user->getState('menu_active');
    if( $menu_active == $string ){
        return true;
    } elseif( !$menu_active ){
        if(isset(Yii::app()->controller->module->id) && Yii::app()->controller->module->id == $string){
            return true;
        }
    }
    return false;
}

function toBytes($str) {
	$val = trim($str);
	$last = strtolower($str[strlen($str) - 1]);
	switch ($last) {
		case 'g': $val *= 1024;
		case 'm': $val *= 1024;
		case 'k': $val *= 1024;
	}
	return $val;
}