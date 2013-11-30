<?php

class AlbumController extends GalleryController
{


    public function actionIndex($id=null,$level=null)
    {
        if ( $level == 1 ) {
            $album = Albums::model()->findByPk($id);

            $criteria = new CDbCriteria();
            $criteria->condition = 'parent_id=:parent_id AND is_published=1';
            $criteria->params = [':parent_id'=>$id];
            $criteria->order = 'sort ASC';
            $albums = Albums::model()->findAll($criteria);

            $this->render('albums', [
                'album' => $album,
                'albums' => $albums,
            ]);

        } else {
            $album = Albums::model()->findByPk($id);

            $criteria = new CDbCriteria();
            $criteria->condition = 'album_id=:album_id AND is_published=1 AND parent_id=0';
            $criteria->params = [':album_id'=>$album->id];
            $criteria->order = 'sort ASC';

            $photos = Photos::model()->findAll($criteria);

            $this->render('photos', [
                'album' => $album,
                'photos' => $photos,
            ]);
        }

    }

}