<?php

class DefaultController extends AdminController
{
	public function actionIndex()
	{
		$this->render('index');
	}

    public function actionSettings() {

        $settings = Settings::model()->find();
        $admin = User::model()->findByPk(Yii::app()->user->id);

        if ( isset($_POST['Settings']) && isset($_POST['User']) ) {
            $settings->attributes = $_POST['Settings'];
            $admin->attributes = $_POST['User'];

            if ( $settings->save() && $admin->save() ) {
                Yii::app()->user->setFlash('success', "Настройки успешно сохранены.");
            }
        }

        $this->render('settings', [
            'settings' => $settings,
            'admin' => $admin,
            'users' => '',
        ]);
    }

    public function actionAjaxUpdatePassword() {
        $user = User::model()->findByPk(Yii::app()->user->id);

        if ( !empty($_POST['new_password']) ) {
            if ( strlen($_POST['new_password']) >= 6 ) {
                $user->password=$_POST['new_password'];

                if($user->save()) {
                    echo CJSON::encode(
                        array(
                            'data' => 'Пароль успешно сохранен!',
                            'status'=>'success'
                        ));
                } else {
                    echo CJSON::encode(
                        array(
                            'data' => 'Пароль не сохранен',
                            'status'=>'no_save'
                        ));
                }

            } else {
                echo CJSON::encode(
                    array(
                        'data' => 'Пароль должен содержать не менее 6 символов',
                        'status'=>'error'
                    ));
            }
        } else {
            echo CJSON::encode(
                array(
                    'data' => 'Введите новый пароль',
                    'status'=>'error'
                ));
        }

    }
}