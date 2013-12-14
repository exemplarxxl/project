<?php

class DefaultController extends GalleryController
{


	public function actionIndex()
	{
        $albums = Albums::model()->findAll(['condition'=>'level = 1 AND is_published = 1']);



        $this->render('index', [
            'albums' => $albums,
        ]);
	}

}