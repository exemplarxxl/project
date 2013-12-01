<?php

class SiteController extends Controller
{

	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
                'testLimit'=>2, //сколько раз капча не меняется
                'transparent'=>false,
                'foreColor'=>0x333333, //цвет символов
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}


	public function actionIndex()
	{
        $criteria = new CDbCriteria();
        $criteria->select = 'default_meta_title, default_meta_description, default_meta_keywords';

        $seo = Settings::model()->find($criteria);
        $this->layout ='//layouts/homeColumn1';
		$this->render('index', ['seo'=>$seo]);
	}

	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}


	public function actionContact()
	{
		$model=new ContactForm;
        $settings = Settings::model()->find();

		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-Type: text/plain; charset=UTF-8";

                //$email = Yii::app()->params['adminEmail'];
                $admin = User::model()->findByPk(1);
                $email = $admin->email;

				mail($email,$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Благодарим Вас за обращение к нам. В ближайшее время мы свяжемся с Вами.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model, 'settings'=>$settings));
	}


    public function actionAbout()
    {
        $this->render('about');
    }

	public function actionLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

    public function actionLogout()
    {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }

    public function actionOrder()
    {
        $model=new OrderForm;
        $settings = Settings::model()->find();

        if(isset($_POST['OrderForm']))
        {
            $model->attributes=$_POST['OrderForm'];
            if($model->validate())
            {
                $name='=?UTF-8?B?'.base64_encode($model->name).'?=';
                $subject='=?UTF-8?B?Онлайн заявка?=';
                $headers="From: $name <{$model->email}>\r\n".
                    "Reply-To: {$model->email}\r\n".
                    "MIME-Version: 1.0\r\n".
                    "Content-Type: text/plain; charset=UTF-8";

                //$email = Yii::app()->params['adminEmail'];
                $admin = User::model()->findByPk(1);
                $email = $admin->email;
                $message = $model->name . '\r\n' . $model->phone . '\r\n' . $model->email . '\r\n' . $model->body;

                mail($email,$subject,$model->body,$headers);
                Yii::app()->user->setFlash('success',$model->name .' благодарим Вас за обращение к нам. В ближайшее время мы свяжемся с Вами.');
                $this->redirect(Yii::app()->request->getUrlReferrer());
            }
        }

    }
}