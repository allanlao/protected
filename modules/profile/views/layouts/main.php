<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

		
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/styles.css" />

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>

	
</head>

<body>



<div class="container" id="page">
	
<div id="mainmenu">
<?php $this->widget('bootstrap.widgets.TbNavbar',array(
	'brandOptions' => array('style'=>'width:auto;margin-left: 0px;'),
	'fixed'=>'top',
	'fluid'=>false,
	'brand'=>'<i class="icon-home"></i> '.Yii::app()->params['company_name'],
	'collapse'=>true,

	
	'htmlOptions' => array('style' => 'position:absolute'),
    'items'=>array(
        array(
            'class'=>'bootstrap.widgets.TbMenu',
            'items'=>array(
               array('label'=>'Home', 'url'=>array('/site/index')),
             array('label'=>'Employee', 'url'=>'#','visible'=>Yii::app()->user->checkAccess('hradmin'),'itemOptions'=>array('class'=>'dropdown','tabindex'=>"-1"),'linkOptions'=>array('class'=>'dropdown-toggle','data-toggle'=>"dropdown"),
            				'items'=>array(
            						array('label'=>'List of All Employees', 'url'=>array('/profile/default/index'),'visible'=>Yii::app()->user->checkAccess('hradmin')),
            						array('label'=>'List of Active Employees', 'url'=>array('/profile/default/active'),'visible'=>Yii::app()->user->checkAccess('hradmin')),
            						array('label'=>'Change Position', 'url'=>array('/profile/employee/changePosition'),'visible'=>Yii::app()->user->checkAccess('hradmin')),
            						array('label'=>'Change Supervisor', 'url'=>array('/profile/employee/changeSuperVisor'),'visible'=>Yii::app()->user->checkAccess('hradmin')),
            						array('label'=>'Deactivate Employee', 'url'=>array('/profile/employee/deactivate'),'visible'=>Yii::app()->user->checkAccess('hradmin')),
            					//	array('label'=>'Summary of Leaves', 'url'=>array('/leave/default/leaveSummary')),
            		
            				)),
            				 
             
               array('label'=>'Add Employee', 'url'=>array('/profile/default/create'),'visible'=>Yii::app()->user->checkAccess('hradmin')),
            		 
            		),
        ),
    array(
    				'class'=>'bootstrap.widgets.TbMenu',
    	        	'htmlOptions'=>array('class'=>'pull-right'),
    				'items'=>array(
    					
						array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
						array('label'=>Yii::app()->user->getState('email').'@'.Yii::app()->params['email_domain'],'icon'=>'briefcase white' ,'visible'=>!Yii::app()->user->isGuest,
						'items'=>array(
								array('label'=>'Log Out','url'=>array('/site/logout')),
								))
				
    				),
    		),
    ),
		
)); ?>
</div>
	
	
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
		<hr>
	<?php endif?>

	
	
	<?php echo $content; ?>

	<div class="clear" style="margin:0px"></div>

	

</div><!-- page -->

</body>
</html>
