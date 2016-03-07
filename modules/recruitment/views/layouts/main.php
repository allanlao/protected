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
               array('label'=>'Post job', 'url'=>array('/recruitment/default/create')),  
               array('label'=>'View', 'url'=>'#','visible'=>Yii::app()->user->checkAccess('hrAdmin'),'itemOptions'=>array('class'=>'dropdown','tabindex'=>"-1"),'linkOptions'=>array('class'=>'dropdown-toggle','data-toggle'=>"dropdown"),
            				'items'=>array(
            						array('label'=>'Department', 'url'=>array('department/create')),
            						array('label'=>'Position', 'url'=>array('position/create')),
            					
            		
            				)),    
         
            		),
        ),
    array(
    				'class'=>'bootstrap.widgets.TbMenu',
    	        	'htmlOptions'=>array('class'=>'pull-right'),
    				'items'=>array(
    					
						array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
						array('label'=>Yii::app()->user->getState('email').'@gmail.com','icon'=>'briefcase white' ,'visible'=>!Yii::app()->user->isGuest,
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
