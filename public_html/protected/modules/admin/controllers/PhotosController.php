<?php

class PhotosController extends AdminController
{
    public function actionIndex()
    {
        $photos = new Photos('search');
        //$model->unsetAttributes();

        $photos->setAttributes(array('parent_id'=>0));

        if (isset($_GET['Photos']))
            $photos->attributes = $_GET['Photos'];
        //var_dump($model);die;
        $this->render('index', array(
            'photos' => $photos,
        ));
    }

    public function actionAddPhotos($album_id) {
        $photos = new Photos();
        $album = Albums::model()->findByPk($album_id);

        $this->render('addPhotos', array(
            'photos' => $photos,
            'album' => $album,
        ));
    }

    public function actionAjaxPhotosUpload() {
        if (isset($_POST['album_id'])) {
            $album_id = (int)$_POST['album_id'];
        }
        // Сохраняем изображение. Если сохранение успешно - выводим 1, иначе - выводи ошибку
        if (isset($_FILES['Filedata'])) {

            $photo = new Photos();
            $photo->album_id = $album_id;
            $photo->parent_id = 0;
            $photo->group_id = 0;
            $photo->sort_group = 1;
            $photo->image = CUploadedFile::getInstanceByName("Filedata");

            if ($photo->save(array('image'))) {
                echo 1;
            } else {
                if ($photo->hasErrors('image')) {
                    die($photo->getError('image'));
                }
            }
        }
    }

    public function actionAddGroupPhotos($photo_id, $album_id) {

        $photos = new Photos();
        $album = Albums::model()->findByPk($album_id);
        $photo = Photos::model()->findByPk($photo_id);

        $this->render('addGroupPhotos', array(
            'photos' => $photos,
            'photo' => $photo,
            'album' => $album,
        ));
    }

    public function actionDelete($id)
    {
        if (Yii::app()->request->isPostRequest)
        {
            $this->loadModel($id)->delete();

            if ( ! isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }
        else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function actionAjaxGroupPhotosUpload() {
        if (isset($_POST['album_id'])) {
            $album_id = (int)$_POST['album_id'];
        }
        if (isset($_POST['photo_id'])) {
            $photo_id = (int)$_POST['photo_id'];
        }

        // Сохраняем изображение. Если сохранение успешно - выводим 1, иначе - выводи ошибку
        if (isset($_FILES['Filedata'])) {

            $parentPhoto = Photos::model()->findByPk($photo_id);
            if ( $parentPhoto->group_id != $photo_id ) {
                $parentPhoto->group_id = $photo_id;
                $parentPhoto->save();
            }

            $photo = new Photos();
            $photo->album_id = $album_id;
            $photo->parent_id = $photo_id;
            $photo->group_id = $photo_id;
            $photo->image = CUploadedFile::getInstanceByName("Filedata");

            if ($photo->save(array('image'))) {

                echo 1;
            } else {
                if ($photo->hasErrors('image')) {
                    die($photo->getError('image'));
                }
            }
        }
    }

    public function actionAjaxUpdatePhotoTitle($photo_id) {
        $photo = Photos::model()->findByPk($photo_id);

        Yii::app()->clientScript->scriptMap['jquery.js'] = false;
        Yii::app()->clientScript->scriptMap['jquery-ui.min.js'] = false;
        Yii::app()->clientScript->scriptMap['jquery-ui.css'] = false;
        Yii::app()->clientScript->scriptMap['bootstrap.js'] = false;
        Yii::app()->clientScript->scriptMap['bootstrap-yii.css'] = false;

        if ( isset($_POST['Photos']) ) {
            $photo->attributes = $_POST['Photos'];
            if ( $photo->save() ) {
                Yii::app()->user->setFlash('success', "Успешно сохранено.");
                if ( $photo->group_id > 0 ) {
                    $this->redirect(array('/admin/photos/groupPhoto', 'photo_id'=>$photo->group_id));
                }
                $this->redirect(array('/admin/photos/'));
            }
        }

        $this->renderPartial('_updatePhotoTitle',array(
            'photo'=>$photo,
        ),false,true);
    }

    public function actionGroupPhoto($photo_id) {
        $photo = Photos::model()->findByPk($photo_id);
        $groupPhotos = new Photos('searchGroup');
        $groupPhotos->setAttributes(['group_id'=>$photo_id]);

        if (isset($_GET['Photos']))
            $groupPhotos->attributes = $_GET['Photos'];
        $this->render('groupPhoto', array(
            'photo' => $photo,
            'groupPhotos' => $groupPhotos,
        ));
    }

    public function actionMove($id, $moving) {
        if($moving=='up') {
            $photo = Photos::model()->findByPk($id);
                $nextUp = Photos::model()->findByAttributes(['sort'=>$photo->sort-1,'album_id'=>$photo->album_id]);
                $nextUp->sort = $photo->sort;
                $nextUp->save();
                $photo->sort = $photo->sort-1;
                $photo->save();
        }
        if($moving=='down') {
            $photo = Photos::model()->findByPk($id);
                $nextUp = Photos::model()->findByAttributes(['sort'=>$photo->sort+1,'album_id'=>$photo->album_id]);
                $nextUp->sort = $photo->sort;
                $nextUp->save();
                $photo->sort = $photo->sort+1;
                $photo->save();
        }
    }

    public function actionMoveGroup($id, $moving) {
        if($moving=='up') {
            $photo = Photos::model()->findByPk($id);
                $nextUp = Photos::model()->findByAttributes(['sort_group'=>$photo->sort_group-1,'group_id'=>$photo->group_id]);
                $nextUp->sort_group = $photo->sort_group;
                $nextUp->save();
                $photo->sort_group = $photo->sort_group-1;
                $photo->save();
        }
        if($moving=='down') {
            $photo = Photos::model()->findByPk($id);
                $nextUp = Photos::model()->findByAttributes(['sort_group'=>$photo->sort_group+1,'group_id'=>$photo->group_id]);
                $nextUp->sort_group = $photo->sort_group;
                $nextUp->save();
                $photo->sort_group = $photo->sort_group+1;
                $photo->save();

        }
    }

    public function actionToggle($id, $attribute)
    {
        if (Yii::app()->request->isPostRequest)
        {
            $model = $this->loadModel($id);
            $model->$attribute = ($model->$attribute == 0) ? 1 : 0;
            $model->save(false);

            if ( ! isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }
        else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function loadModel($id)
    {
        $model=Photos::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if(isset($_POST['ajax']) && $_POST['ajax']==='photos-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
