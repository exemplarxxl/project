<?php

/**
 * This is the model class for table "{{photos}}".
 *
 * The followings are the available columns in table '{{photos}}':
 * @property integer $id
 * @property integer $album_id
 * @property integer $is_published
 * @property integer $sort
 * @property string $image
 * @property string $title
 * @property integer $parent_id
 * @property integer $group_id
 * @property integer $sort_group
 */
class Photos extends CActiveRecord
{

    public $imageSizes = array(
        '166x100' => array(166, 100),
        '390x234' => array(390, 234),
        '936x624' => array(936, 624),
    );

    public $needToDelete = false;
    public static $salt = 'd4fet4ds';
    public $imageQuality = 95;

    public $maxSort;
    public $minSort;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{photos}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('album_id, is_published, sort, parent_id, group_id, sort_group', 'numerical', 'integerOnly'=>true),
			array('image, title', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, album_id, is_published, sort, image, title, parent_id, group_id, sort_group', 'safe', 'on'=>'search'),
            array('id, album_id, is_published, sort, image, title, parent_id, group_id, sort_group', 'safe', 'on'=>'searchGroup'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
            'album' => [self::BELONGS_TO, 'Albums', 'album_id'],
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'album_id' => 'Альбом',
			'is_published' => 'Опубликовано',
			'sort' => '№ п/п',
			'image' => 'Изображение',
			'title' => 'Название',
			'parent_id' => 'Родитель',
            'group_id' => 'Доп.фото',
            'sort_group' => '№ п/п'
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('album_id',$this->album_id, true);
		$criteria->compare('is_published',$this->is_published);
		$criteria->compare('sort',$this->sort, true);
		$criteria->compare('image',$this->image);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('parent_id',$this->parent_id);
        $criteria->compare('group_id',$this->group_id);
        $criteria->compare('sort_group',$this->sort_group);
        $criteria->order = 'sort ASC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function searchGroup()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria=new CDbCriteria;

        $criteria->compare('id',$this->id);
        $criteria->compare('album_id',$this->album_id, true);
        $criteria->compare('is_published',$this->is_published);
        $criteria->compare('sort',$this->sort, true);
        $criteria->compare('image',$this->image);
        $criteria->compare('title',$this->title,true);
        $criteria->compare('parent_id',$this->parent_id);
        $criteria->compare('group_id',$this->group_id);
        $criteria->compare('sort_group',$this->sort_group);
        $criteria->order = 'sort_group ASC';

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Photos the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public static function getMaxSort($album_id){
            $model = new Photos();
            $maxSort = Yii::app()->db->createCommand()
                ->select('MAX(sort) as maxSort')
                ->from($model->tableName())
                ->where('album_id=:album_id',[':album_id'=>$album_id])
                ->queryScalar();
        return $maxSort;
    }

    public static function getMinSort($album_id){

        $model = new Photos();
        $minSort = Yii::app()->db->createCommand()
            ->select('MIN(sort) as maxSort')
            ->from($model->tableName())
            ->where('album_id=:album_id',[':album_id'=>$album_id])
            ->queryScalar();
        $minSort;
        return $minSort;
    }

    public static function getMaxSortGroup($group_id){
        $model = new Photos();
        $maxSort = Yii::app()->db->createCommand()
            ->select('MAX(sort_group) as maxSort')
            ->from($model->tableName())
            ->where('group_id=:group_id',[':group_id'=>$group_id])
            ->queryScalar();
        return $maxSort;
    }

    public static function getMinSortGroup($group_id){

        $model = new Photos();
        $minSort = Yii::app()->db->createCommand()
            ->select('MIN(sort_group) as maxSort')
            ->from($model->tableName())
            ->where('group_id=:group_id',[':group_id'=>$group_id])
            ->queryScalar();
        $minSort;
        return $minSort;
    }

    public function beforeSave()
    {
        if ($this->id) {
            $old = self::model()->findByPk($this->id);
            if (CUploadedFile::getInstance($this, 'image')) {
                $old->imageDelete();
            } else if ($old->image) {
                $this->image = $old->image;
            }
        }

        if($this->isNewRecord){
            $this->is_published = 1;
            if ( $this->group_id > 0 ) {
                $maxSort = Yii::app()->db->createCommand()
                    ->select('MAX(sort_group) as maxSort')
                    ->from('{{photos}}')
                    ->where('album_id=:album_id AND group_id=:group_id',
                            [':album_id'=>$this->album_id, ':group_id'=>$this->group_id])
                    ->queryRow();
                $this->sort_group = $maxSort['maxSort']+1;
            } else {
                $maxSort = Yii::app()->db->createCommand()
                    ->select('MAX(sort) as maxSort')
                    ->from('{{photos}}')
                    ->where('album_id=:album_id',[':album_id'=>$this->album_id])
                    ->queryRow();
                $this->sort = $maxSort['maxSort']+1;
            }

        }
        return parent::beforeSave();
    }

    public static function countAlbumPhotos($album_id, $no_published=false) {
        if ( $no_published == false ) {
            $published = ' AND is_published=1';
        } else {
            $published = '';
        }
        $count = Yii::app()->db->createCommand()
            ->select('count(id) as id')
            ->from('{{photos}}')
            ->where('album_id=:album_id' . $published,
                [':album_id'=>$album_id])
            ->queryScalar();
        $count = ($count != 0) ? $count .' фото' : '0 фото';
        return $count;
    }

    public static function countGroupPhotos($photo_id, $no_published=false) {
        if ( $no_published == false ) {
            $published = ' AND is_published=1';
        } else {
            $published = '';
        }
        $count = Yii::app()->db->createCommand()
            ->select('count(id) as id')
            ->from('{{photos}}')
            ->where('group_id=:group_id' . $published,
                [':group_id'=>$photo_id])
            ->queryScalar();
        $count = ($count != 0) ? $count .' фото' : 'добавить фото';
        return $count;
    }

    public function afterSave()
    {
        if ($this->image && $this->image instanceof CUploadedFile) {
            $fileName = self::hash($this->id).'.'.$this->image->extensionName;

            // Если директории для изображений не существует - создаём её
            $original = Yii::app()->params['photoPath'].'original';
            if (!file_exists($original))
                mkdir($original, 0775, true);
            if (!file_exists($original))
                mkdir($original, 0775, true);

            // Сохраняем изображение
            $result = $this->image->saveAs($original.'/'.$fileName);
            if (!$result) {
                copy($this->image->getTempName(), $original.'/'.$fileName);
            }
            self::model()->updateByPk($this->id, array('image' => $fileName));

            // Сохраняем изображения с разными форматами
            foreach ($this->imageSizes as $path => $size) {
                $resizeImage = Yii::app()->image->load($original.'/'.$fileName);
                $resizeImage->resize($size[0], $size[1])->quality($this->imageQuality);
                if (!file_exists(Yii::app()->params['photoPath'].$path))
                    mkdir(Yii::app()->params['photoPath'].$path, 0775, true);
                if (!file_exists(Yii::app()->params['photoPath'].$path))
                    mkdir(Yii::app()->params['photoPath'].$path, 0775, true);
                $resizeImage->save(Yii::app()->params['photoPath'].$path.'/'.$fileName);
            }
        }

        return parent::afterSave();
    }
/*
    public function afterSave()
    {
        if ($this->image && $this->image instanceof CUploadedFile) {
            $folder = $this->getFolder();
            $fileName = self::hash($this->id).'.'.$this->image->extensionName;

            // Если директории для изображений не существует - создаём её
            $original = Yii::app()->params['photoPath'].'original';
            if (!file_exists($original))
                mkdir($original, 0775, true);
            if (!file_exists($original.'/'.$folder))
                mkdir($original.'/'.$folder, 0775, true);

            // Сохраняем изображение
            $result = $this->image->saveAs($original.'/'.$folder.'/'.$fileName);
            if (!$result) {
                copy($this->image->getTempName(), $original.'/'.$folder.'/'.$fileName);
            }
            self::model()->updateByPk($this->id, array('image' => $fileName));

            // Сохраняем изображения с разными форматами
            foreach ($this->imageSizes as $path => $size) {
                $resizeImage = Yii::app()->image->load($original.'/'.$folder.'/'.$fileName);
                $resizeImage->resize($size[0], $size[1])->quality($this->imageQuality);
                if (!file_exists(Yii::app()->params['photoPath'].$path))
                    mkdir(Yii::app()->params['photoPath'].$path, 0775, true);
                if (!file_exists(Yii::app()->params['photoPath'].$path.'/'.$folder))
                    mkdir(Yii::app()->params['photoPath'].$path.'/'.$folder, 0775, true);
                $resizeImage->save(Yii::app()->params['photoPath'].$path.'/'.$folder.'/'.$fileName);
            }
        }

        return parent::afterSave();
    }

    public function getFolder()
    {
        return self::hash($this->album_id);
    }

    public static function getFolderName($album_id)
    {
        return self::hash($album_id);
    }
    public function image($size = 'original', $prefix = '/')
    {
        return $prefix.Yii::app()->params['photoPath'].((isset($this->imageSizes[$size])) ? $size
            : 'original').'/'.$this->getFolder().'/'.$this->image;
    }
    */
    /**
     * @param string $size
     * @param string $prefix
     * @return string
     */
    public function image($size = 'original', $prefix = '/')
    {
        return $prefix.Yii::app()->params['photoPath'].((isset($this->imageSizes[$size])) ? $size
            : 'original').'/'.$this->image;
    }

    /*
    public function imageImg($size = 'original', $prefix = '/', $htmlOptions = array())
    {
        $insertOptions = '';
        foreach ($htmlOptions as $attr=>$val)
            $insertOptions .= ' '.$attr.'="'.$val.'"';

        return '<img src="'.$this->image($size, $prefix).'"'.$insertOptions.' />';
    }*/

    public static function getLinkPhoto($photo_id, $size='small') {
        if ( $size == 'small' ) {
            $imageSize = '166x100';
        } elseif ( $size == 'medium' ) {
            $imageSize = '390x234';
        } elseif ( $size == 'large' ) {
            $imageSize = '936x624';
        }
        $photo = Photos::model()->findByPk($photo_id);
        if ($photo == null) {
            return Yii::app()->request->hostInfo. '/images/no-image.jpg';
        }
        return Yii::app()->request->hostInfo. '/' .Yii::app()->params['photoPath'].$imageSize . '/' . $photo->image;
        //return Yii::app()->request->hostInfo. '/' .Yii::app()->params['photoPath'].$imageSize . '/' .Photos::getFolderName($photo->album_id) . '/' . $photo->image;
    }
    public static function getLinkPhotoByName($photo_name, $album_id, $size='small',$tagImg=true) {
        if ( $size == 'small' ) {
            $imageSize = '166x100';
        } elseif ( $size == 'medium' ) {
            $imageSize = '390x234';
        } elseif ( $size == 'large' ) {
            $imageSize = '936x624';
        }
        $link = Yii::app()->request->hostInfo. '/' .Yii::app()->params['photoPath'].$imageSize . '/' . $photo_name;
        //$link = Yii::app()->request->hostInfo. '/' .Yii::app()->params['photoPath'].$imageSize . '/' .Photos::getFolderName($album_id) . '/' . $photo_name;
        if ( $tagImg == true ) {
            $link = CHtml::image($link);
        }

        return $link;
    }
    public function imageDelete()
    {
        if ($this->image) {
            if (file_exists($this->image('original', '')))
                unlink($this->image('original', ''));
            foreach ($this->imageSizes as $path => $size) {
                if (file_exists($this->image($path, '')))
                    unlink($this->image($path, ''));
            }
        }
    }

    public function beforeDelete()
    {
        $count = Yii::app()->db->createCommand()
            ->select('count(id) as id')
            ->from('{{photos}}')
            ->where('parent_id=:parent_id',
                [':parent_id'=>$this->id])
            ->queryScalar();
        if ( $count > 0 ) {
            throw new CHttpException(400, 'Нельзя удалить фотографию у которой имеются дочерние фотографии');
        }
        $this->imageDelete();
        return parent::beforeDelete();
    }

    public static function hash($str)
    {
        return md5(md5(self::$salt).$str);
    }
}
