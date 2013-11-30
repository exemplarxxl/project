<?php

class EUploadifyHtml5Widget extends CInputWidget
{
	/**
	 * @var array the uploadify package.
	 * Defaults to array(
	 *     'basePath'=>dirname(__FILE__).'/vendors/jquery.uploadify-v2.1.4',
	 *     'js'=>array('jquery.uploadify'.(YII_DEBUG?'':'.min').'.js','swfobject.js'),
	 *     'css'=>array('uploadify.css'),
	 *     'depends'=>array('jquery'),
	 * )
	 * @see CClientScript::$packages
	 * @since 1.7
	 */
	public $package=array();
	/**
	 * @var string|null the name of the POST parameter where save session id.
	 * Or null to disable sending session id. Use {@link EForgerySessionFilter} to load session by id from POST.
	 * Defaults to null.
	 * @see EForgerySessionFilter
	 */
	public $sessionParam;
	/**
	 * @var array extension options. For more info read {@link http://www.uploadify.com/documentation/ documentation}
	 */
	public $options=array();

	/**
	 * Init widget.
	 */
	public function init()
	{
		list($this->name,$this->id)=$this->resolveNameId();

		// Set defaults package.
		if($this->package==array())
		{
			$this->package=array(
				'basePath'=>dirname(__FILE__).'/vendors/jquery.uploadify-html5',
				'js'=>array(
					'jquery.uploadifive.js',
				),
				'css'=>array(
					'uploadifive.css',
				),
				'depends'=>array(
					'jquery',
				),
			);
		}

		// Publish package assets. Force copy assets in debug mode.
		if (!isset($this->package['baseUrl']))
		{
			$this->package['baseUrl']=Yii::app()->getAssetManager()->publish($this->package['basePath'],false,-1,YII_DEBUG);
		}

		$baseUrl=$this->package['baseUrl'];

		if (!isset($this->options['cancelImg']))
		{
			$this->options['cancelImg']=$baseUrl.'/cancel.png';
		}

		if (!isset($this->options['expressInstall']))
		{
			$this->options['expressInstall']=$baseUrl.'/expressInstall.swf';
		}

		if (!isset($this->options['uploadScript']))
		{
			$this->options['uploadScript']=$baseUrl.'/uploadifive.php';
		}

		// Send session id with via POST.
		if (isset($this->sessionParam) && isset($this->options['formData']))
		{
			//$this->options['formData'] .= '&sid=' . Yii::app()->getSession()->getSessionId();
		}

		// fileDesc is required if fileExt set.
		if (!empty($this->options['fileExt']) && empty($this->options['fileDesc']))
		{
			$this->options['fileDesc']=Yii::t('yiiext','Supported files ({fileExt})',array('{fileExt}'=>$this->options['fileExt']));
		}

		// Generate fileDataName for linked with model attribute.
		$this->options['fileDataName'] = $this->name;

		$this->registerClientScript();
	}
	/**
	 * Run widget.
	 */
	public function run()
	{
		if($this->hasModel())
		{
			echo CHtml::activeFileField($this->model,$this->attribute,$this->htmlOptions);
		}
		else
		{
			echo CHtml::fileField($this->name,$this->value,$this->htmlOptions);
		}
	}

	/**
	 * @return void
	 * Register CSS and Script.
	 */
	protected function registerClientScript()
	{
		$cs=Yii::app()->getClientScript();
		$cs->packages['uploadifive']=$this->package;
		$cs->registerPackage('uploadifive');
		$cs->registerScript(__CLASS__.'#'.$this->id,'jQuery("#'.$this->id.'").uploadifive('.CJavaScript::encode($this->options).');',CClientScript::POS_READY);
	}
}
