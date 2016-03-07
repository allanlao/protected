<?php

class DefaultController extends Controller
{
	public $layout = '/layouts/column1';
	public function actionIndex()
	{
         $model = new User('search');  
		//$dataProvider = new CActiveDataProvider('User');
         $model->unsetAttributes();  // clear any default values
         if (isset($_GET['User']))
         	$model->attributes = $_GET['User'];
		$this->render('index',array('model'=>$model));
	}
	
	public function actionCreate() {
		$model = new User;
	
		if (isset($_POST['User'])) {
			$model->attributes = $_POST['User'];
			$model->password = md5("123456");
	
			if ($model->save()) {
				Yii::app()->user->setFlash('success', '<strong>Well done!</strong> You have create a new user');
			}
		}
	
		$this->render('create', array('model' => $model));
	}

	


}

?>