<?php

class DefaultController extends GalleryController
{


	public function actionIndex()
	{
		$this->render('index');
	}

}