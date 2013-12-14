<?php

/**
 * This is the model class for table "{{albums}}".
 *
 * The followings are the available columns in table '{{albums}}':
 * @property integer $id
 * @property integer $root
 * @property integer $lft
 * @property integer $rgt
 * @property integer $level
 * @property integer $parent_id
 * @property integer $is_published
 * @property string $title
 * @property string $description
 * @property string $translit_title
 * @property string $image
 * @property string $meta_title
 * @property string $meta_description
 * @property string $meta_keywords
 * @property integer $sort
 * @property integer $menu
 */
class Albums extends CActiveRecord
{

    public $_parent_id;
    public $_translit_title;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{albums}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
            array('translit_title, title, meta_title', 'required', 'on'=>'create'),
            array('description, meta_description, meta_keywords, parent_id, image, sort, menu', 'safe'),
            array('parent_id', 'compare', 'operator' => '!=', 'compareAttribute' => 'id', 'allowEmpty' => true, 'message' => 'Узел не может быть сам себе родителем.'),
            array('translit_title', 'match', 'pattern' => '/^[\w][\w\-]*+$/', 'message' => 'Разрешённые символы: строчные буквы латинского алфавита, цифры, дефис.'),
            array('title', 'match', 'pattern' => '/^\d+$/', 'not' => true, 'message' => 'Заголовок страницы не может состоять из одного числа.'), // иначе будут проблемы при генерации хлебных крошек
            //array('layout', 'default', 'setOnEmpty' => true, 'value' => null),
            array('is_published', 'boolean'),
            array('id, translit_title, title, is_published, sort, level', 'safe', 'on' => 'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'root' => 'Root',
            'lft'              => 'Левый ключ',
            'rgt'              => 'Правый ключ',
            'level'            => 'Уровень',
            'parent_id'        => 'Родитель',
			'is_published' => 'Опубликовано',
			'title' => 'Название',
			'description' => 'Описание',
			'translit_title' => 'Псевдоним',
            'meta_title'       => 'Мета-заголовок',
            'meta_description' => 'Описание страницы',
            'meta_keywords'    => 'Ключевые слова',
			'sort' => '№ п/п',
            'image' => 'Изображение',
            'menu' => 'Показывать в меню'
		);
	}

    public function defaultScope()
    {
        return array(
            'order' => 'root, lft',
        );
    }

    public function scopes()
    {
        return array(
            'published' => array(
                'condition' => 'is_published = 1',
            ),
        );
    }

    public function behaviors()
    {
        return array(
            'nestedSetBehavior' => array(
                'class' => 'ext.nested-set.NestedSetBehavior',
                'leftAttribute' => 'lft',
                'rightAttribute' => 'rgt',
                'levelAttribute' => 'level',
                'rootAttribute' => 'root',
                'hasManyRoots' => true,
            ),
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
		$criteria->compare('root',$this->root);
		$criteria->compare('lft',$this->lft);
		$criteria->compare('rgt',$this->rgt);
		$criteria->compare('level',$this->level,true);
		$criteria->compare('parent_id',$this->parent_id);
		$criteria->compare('is_published',$this->is_published);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('translit_title',$this->translit_title,true);
		$criteria->compare('meta_title',$this->meta_title,true);
		$criteria->compare('meta_description',$this->meta_description,true);
		$criteria->compare('meta_keywords',$this->meta_keywords,true);
		$criteria->compare('sort',$this->sort);
        $criteria->compare('image',$this->image);
        $criteria->order = 'sort ASC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}



    public static function getMaxSort($level, $parent_id){
        $model = new Albums();
        if ( $parent_id == null ) {
            $maxSort = Yii::app()->db->createCommand()
                ->select('MAX(sort) as maxSort')
                ->from($model->tableName())
                //->where('level=:level',[':level'=>$level])
                ->queryScalar();
        } else {
            $maxSort = Yii::app()->db->createCommand()
                ->select('MAX(sort) as maxSort')
                ->from($model->tableName())
                ->where('level=:level AND parent_id=:parent_id',[':level'=>$level, ':parent_id'=>$parent_id])
                ->queryScalar();
        }

        return $maxSort;
    }

    public static function getMinSort($level, $parent_id){

        $model = new Albums();
        if ( $parent_id == null ) {
            $maxSort = Yii::app()->db->createCommand()
                ->select('MIN(sort) as maxSort')
                ->from($model->tableName())
                //->where('level=:level',[':level'=>$level])
                ->queryScalar();
        } else {
            $maxSort = Yii::app()->db->createCommand()
                ->select('MIN(sort) as maxSort')
                ->from($model->tableName())
                ->where('level=:level AND parent_id=:parent_id',[':level'=>$level, ':parent_id'=>$parent_id])
                ->queryScalar();
        }

        return $maxSort;
    }

    protected function afterFind()
    {
        parent::afterFind();

        $this->_parent_id = $this->parent_id;
        $this->_translit_title = $this->translit_title;
    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Albums the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function selectList()
    {
        $output = array();
        $nodes = $this->findAll();
        foreach ($nodes as $node)
            $output[$node->id] = str_repeat('  ', $node->level - 1) . $node->title;
        return $output;
    }

    public static function getListCategorForMenu() {
        $criteria = new CDbCriteria();
        $criteria->condition = 'level = 1 AND is_published = 1 AND menu = 1';
        $criteria->order = 'sort ASC';
        $albums = Albums::model()->findAll($criteria);

        $menu = [];
        foreach ( $albums as  $album) {

            $criteria = new CDbCriteria();
            $criteria->condition = 'parent_id=:parent_id AND is_published = 1 AND menu = 1';
            $criteria->params = [':parent_id'=>$album->id];
            $criteria->order = 'sort ASC';

            $childAlbums = Albums::model()->findAll($criteria);

            $childMenu = [];
            foreach ( $childAlbums as $child ) {
                $childMenu[] = [
                    'label'=> $child->title,
                    'url'=>['/gallery/album/', 'id'=>$child->id],
                ];
            }
            $menu[] = [
                'label'=> $album->title,
                'url'=>['/gallery/album/', 'id'=>$album->id,'level'=>1],
                'items'=> $childMenu
            ];

        }
        return $menu;
    }

    public static function getNameById($album_id) {
        $album = Albums::model()->findByPk($album_id);
        return $album->title;
    }

    public static function getListTitleAlbums() {
        $albums = Albums::model()->findAll();
        $list = [];
        foreach ( $albums as $album ) {
            $list[$album->title] = $album->title;
        }
        return $list;
    }

    public static function countLinkToChildAlbum($album_id) {

        $album = Albums::model()->findByPk($album_id);
        $childLevel = $album->level + 1;
        $count = Yii::app()->db->createCommand()
            ->select('count(id) as id')
            ->from('{{albums}}')
            ->where('level=:level AND parent_id=:parent_id',
                ['parent_id'=>$album_id, ':level'=>$childLevel])
            ->queryScalar();


        if ($count > 0) {
            $link = CHtml::link($album->title . ' (' . $count . ')', Yii::app()->createAbsoluteUrl("/admin/albums/index?Albums%5Bparent_id%5D=$album->id&Albums%5Blevel%5D=$childLevel"));
        } else {
            $link = $album->title;
        }

        return $link;
    }

    public static function getChildAlbums($id) {
        $criteria = new CDbCriteria();
        $criteria->condition = 'parent_id=:parent_id AND is_published=1';
        $criteria->params = [':parent_id'=>$id];
        $criteria->order = 'sort ASC';
        $albums = Albums::model()->findAll($criteria);

        return $albums;
    }
}
