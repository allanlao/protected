<?php

class SiteController extends Controller {

    /**
     * Declares class-based actions.
     */
    public function actions() {
        return array(
// captcha action renders the CAPTCHA image displayed on the contact page
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
// They can be accessed via: index.php?r=site/page&view=FileName
            'page' => array(
                'class' => 'CViewAction',
            ),
        );
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex() {
// renders the view file 'protected/views/site/index.php'
// using the default layout 'protected/views/layouts/main.php'
        $this->render('index');
    }
    
    
    /**
     * This is the action to handle external exceptions.
     */
    public function actionError() {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

    /**
     * Displays the contact page
     */
    public function actionContact() {
        $model = new ContactForm;
        if (isset($_POST['ContactForm'])) {
            $model->attributes = $_POST['ContactForm'];
            if ($model->validate()) {
                $headers = "From: {$model->email}\r\nReply-To: {$model->email}";
                mail(Yii::app()->params['adminEmail'], $model->subject, $model->body, $headers);
                Yii::app()->user->setFlash('contact', 'Thank you for contacting us. We will respond to you as soon as possible.');
                $this->refresh();
            }
        }
        $this->render('contact', array('model' => $model));
    }

    public function actionReset() {
        $model = new ContactForm;

        if (isset($_POST['ContactForm'])) {
          

            $model->attributes = $_POST['ContactForm'];
            
            $username = explode('@',$model->email);
            $user_model = User::model()->findByPk($username[0]);

            if ($user_model) {

                $password = $this->generatePassword(8);

                if (isset(Yii::app()->params['hr_email']))
                    $from = Yii::app()->params['hr_email'];
                else
                    $from = "admin@avc.edu";
				
                $email = $model->email;
                $subject ='HRMIS Password Reset';
                $message = 'Your new password is ' . $password;

                $headers = "From: {$from}\r\nReply-To: {$from}";
              
                if ($res = mail($email, $subject, $message, $headers)) {
                    $user_model->password = md5($password);
                    $user_model->password_repeat = md5($password);
                    $user_model->new_password_repeat = $password;
                    $user_model->new_password = $password;

                    if ($user_model->save()) {

                        Yii::app()->user->setFlash('success', '<strong>Well done!</strong> Your new password has been sent to '.$email);
                        $this->redirect(array('site/login'));
                    } else {
                        $this->redirect(array('site/error'));
                    }
                } else {
                        Yii::app()->user->setFlash('contact', 'F');
                }


                $this->refresh();
            } else {
                Yii::app()->user->setFlash('error', '<strong>Opsss!</strong> Email address do not exist!');
                // $this->redirect(array('site/login'));
            }
        }

        $this->render('reset', array('model' => $model));
    }

    /**
     * Displays the login page
     */
    public function actionLogin() {
        $model = new LoginForm;

// if it is ajax validation request
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

// collect user input data
        if (isset($_POST['LoginForm'])) {
            $model->attributes = $_POST['LoginForm'];
   // validate user input and redirect to the previous page if valid
            if ($model->validate() && $model->login())
                $this->redirect(Yii::app()->user->returnUrl);
        }
// display the login form
        $this->render('login', array('model' => $model));
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout() {

        $assigned_roles = Yii::app()->authManager->getRoles(Yii::app()->user->id); //obtains all assigned roles for this user id
        if (!empty($assigned_roles)) { //checks that there are assigned roles
            $auth = Yii::app()->authManager; //initializes the authManager
            foreach ($assigned_roles as $n => $role) {
                if ($auth->revoke($n, Yii::app()->user->id)) //remove each assigned role for this user
                    Yii::app()->authManager->save(); //again always save the result
            }
        }


        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }

    private function generatePassword($length = 8) {


// start with a blank password
        $password = "";

// define possible characters - any character in this string can be
// picked for use in the password, so if you want to put vowels back in
// or add special characters such as exclamation marks, this is where
// you should do it
        $possible = "2346789bcdfghjkmnpqrtvwxyzBCDFGHJKLMNPQRTVWXYZ";

// we refer to the length of $possible a few times, so let's grab it now
        $maxlength = strlen($possible);

// check for length overflow and truncate if necessary
        if ($length > $maxlength) {
            $length = $maxlength;
        }

// set up a counter for how many characters are in the password so far
        $i = 0;

// add random characters to $password until $length is reached
        while ($i < $length) {

// pick a random character from the possible ones
            $char = substr($possible, mt_rand(0, $maxlength - 1), 1);

// have we already used this character in $password?
            if (!strstr($password, $char)) {
// no, so it's OK to add it onto the end of whatever we've already got...
                $password .= $char;
// ... and increase the counter by one
                $i++;
            }
        }

// done!
        return $password;
    }

}