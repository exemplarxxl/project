<?php

class AlbumsController extends AdminController
{

	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Albums('create');

        $this->performAjaxValidation($model);

        if (isset($_POST['Albums']))
        {
            $model->attributes = $_POST['Albums'];



            if ($model->parent_id)
            {
                $parent = Albums::model()->findByPk($model->parent_id);
                if ($parent !== null) {
                    $model->appendTo($parent);
                }

                $maxSort = Yii::app()->db->createCommand()
                    ->select('MAX(sort) as maxSort')
                    ->from('{{albums}}')
                    ->where('parent_id=:parent_id',
                        [':parent_id'=>$model->parent_id])
                    ->queryRow();
                $model->sort = $maxSort['maxSort']+1;

            } else {
                $maxSort = Yii::app()->db->createCommand()
                    ->select('MAX(sort) as maxSort')
                    ->from('{{albums}}')
                    ->where('level=1')
                    ->queryRow();
                $model->sort = $maxSort['maxSort']+1;
            }

            if ($model->saveNode())
            {

                Yii::app()->user->setFlash('success', "Альбом «{$model->title}» успешно создан.");
                $this->redirect(array('cover', 'album_id' => $model->id));
            }
        }

		$this->render('create',array(
			'model'=>$model,
		));
	}

    public function actionCover($album_id) {


        $this->render('cover',array(
            'album_id'=>$album_id,
        ));
    }

    public function actionAjaxCoverUpload() {

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

                $album = Albums::model()->findByPk($album_id);
                $album->image = $photo->id;
                if ( $album->saveNode() ) {
                    echo 1;
                } else {
                    die("При сохранении произошла ошибка");
                }
            } else {
                if ($photo->hasErrors('image')) {
                    die($photo->getError('image'));
                }
            }
        }
    }

    public function actionAjaxSelectCover() {
        $photos = Photos::model()->findAll();
        //$photos = Photos::model()->findAllByAttributes(['album_id'=>$_POST['album_id']]);

        Yii::app()->clientScript->scriptMap['jquery.js'] = false;
        Yii::app()->clientScript->scriptMap['jquery-ui.min.js'] = false;
        Yii::app()->clientScript->scriptMap['jquery-ui.css'] = false;
        Yii::app()->clientScript->scriptMap['bootstrap.js'] = false;
        Yii::app()->clientScript->scriptMap['bootstrap-yii.css'] = false;

        $this->renderPartial('_selectCover',array(
            'photos'=>$photos,
        ),false,true);
    }

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
        $model = $this->loadModel($id);

        $this->performAjaxValidation($model);

        if (isset($_POST['Albums']))
        {

            $model->attributes = $_POST['Albums'];

            if ((int) $model->parent_id !== (int) $model->_parent_id)
            {
                if (empty($model->parent_id))
                    $result = $model->moveAsRoot();
                else
                {
                    $parent = Albums::model()->findByPk($model->parent_id);
                    if ($parent !== null)
                        $result = $model->moveAsFirst($parent);
                }
            }
            if ( isset($_POST['cover']) ) {
                $model->image = $_POST['cover'];
            }
            if ($model->saveNode())
            {
                Yii::app()->user->setFlash('success', "Альбом «{$model->title}» успешно изменен.");
                $this->redirect(array('index'));
            }
        }

        $this->render('update', array(
            'model' => $model,
        ));
	}

    public function actionToggle($id, $attribute)
    {
        if (Yii::app()->request->isPostRequest)
        {
            $model = $this->loadModel($id);
            $model->$attribute = ($model->$attribute == 0) ? 1 : 0;
            $model->saveNode(false);

            if ( ! isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }
        else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
        if (Yii::app()->request->isPostRequest)
        {
            $this->loadModel($id)->deleteNode();

            if ( ! isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }
        else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
        $model = new Albums('search');
        //$model->unsetAttributes();
        $model->setAttributes(array('level'=>1));

        if (isset($_GET['Albums'])) {
            if ( isset($_GET['Albums']['id']) ) {
                $album = Albums::model()->findByPk($_GET['Albums']['id']);
                $model->unsetAttributes();
                $model->setAttributes(array('parent_id'=>$album->parent_id,'level'=>$album->level));
            }
            $model->attributes = $_GET['Albums'];
        }

        //var_dump($model);die;
        $this->render('index', array(
            'model' => $model,
        ));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Albums('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Albums']))
			$model->attributes=$_GET['Albums'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Albums::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='albums-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

    public $modelName = 'Albums';

    public function actionUpload() {
        Yii::import("ext.EAjaxUpload.qqFileUploader");

        $gallery = new $this->modelName;
        // folder for uploaded files
        $folder = $gallery->uploadPath;
        //array("jpg","jpeg","gif","exe","mov" and etc...
        $allowedExtensions = array("jpg","jpeg","gif","png");
        // maximum file size in bytes
        //$sizeLimit = 2 * 1024 * 1024;
        $fileMaxSize['postSize'] = toBytes(ini_get('post_max_size'));
        $fileMaxSize['uploadSize'] = toBytes(ini_get('upload_max_filesize'));

        $sizeLimit = min($fileMaxSize);

        ///

        $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
        $result = $uploader->handleUpload($folder);

        $fileSize=filesize($folder.$result['filename']);
        $fileName=$result['filename'];

        // save info to  DB
        $gallery->img = $fileName;
        $gallery->save(false);
        $id = $gallery->id;

        // resize file
        $image = new Image($folder.'/'.$fileName);
        $image->resize(param('maxWidthBigThumb', 800), param('maxHeightBigThumb', 600));
        $image->save($gallery->uploadBigThumbPath.'/'.$fileName);

        // create thumb
        $image->resize(param('maxWidthMediumThumb', 400), param('maxHeightMediumThumb', 300));
        $image->save($gallery->uploadMediumThumbPath.'/'.$fileName);

        $image->resize(param('maxWidthSmallThumb', 100), param('maxHeightSmallThumb', 75));
        $image->save($gallery->uploadSmallThumbPath.'/'.$fileName);

        // result echo
        $result['thumbPath'] = Yii::app()->baseUrl.'/'.$gallery->galleryUploadSmallThumbPath.'/'.$fileName;
        $result['thumbWidth'] = param('maxWidthSmallThumb', 100);
        $result['id_photo'] = $id;

        $return = htmlspecialchars(json_encode($result), ENT_NOQUOTES);

        // return array
        echo $return;
    }

    public function actionMove($id, $moving) {
        if($moving=='up') {
            $album = Albums::model()->findByPk($id);
                $nextUp = Albums::model()->findByAttributes(['parent_id'=>$album->parent_id,'level'=>$album->level,'sort'=>$album->sort-1]);
                $nextUp->sort = $album->sort;
                $nextUp->saveNode();
                $album->sort = $album->sort-1;
                $album->saveNode();
        }
        if($moving=='down') {
            $album = Albums::model()->findByPk($id);
            $nextUp = Albums::model()->findByAttributes(['parent_id'=>$album->parent_id,'level'=>$album->level,'sort'=>$album->sort+1]);
            $nextUp->sort = $album->sort;
            $nextUp->saveNode();
            $album->sort = $album->sort+1;
            $album->saveNode();
        }
    }
}
