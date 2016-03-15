<?php 
   if (Yii::app()->user->checkAccess('hradmin'))
      $this->beginContent('/layouts/main'); 
   else
      $this->beginContent('//layouts/main');
?>

<?php
$emp_number = Yii::app()->session['profile_no'];

$image = Employee::model()->findByPk($emp_number);

if (is_null($image->picture))
    $pic = "0.jpg";
else
    $pic = $image->picture;
?>
<div class="container">
    <div class="span3 well">
 
         
            <img style="margin:auto; width: 200px; height: 200px" alt="banner" src="<?php echo Yii::app()->request->baseUrl . '/profile_pics/' .$pic; ?>" ></img>
           


        <ul class="nav nav-list">
            <li class="nav-header">
                Profile
            </li>
            <li class="active"><a href="#"><i class='icon-white icon-ok-sign'></i>Personal Information</a></li>
            <li><a href="index.php?r=profile/default/updatePersonal&id=<?php echo $emp_number;?>">Personal Details</a></li>
            <li><a href="index.php?r=profile/default/updateContacts">Contact Details</a></li>
            <li><a href="index.php?r=profile/empEmergencyContacts/create">Emergency Contacts</a></li>
            <li><a href="index.php?r=profile/empDependents/create">Dependents</a></li>
            <li><a href="#">Change Profile Picture</a></li>
  
            <li class="active"><a href="#"><i class='icon-white icon-ok-sign'></i>Employment</a></li>
            <li><a href="index.php?r=profile/default/updateJob">Job Details</a></li>
            <li><a href="index.php?r=profile/default/updateTermination">Termination Details</a></li>

            <li class="active"><a href="#"><i class='icon-white icon-ok-sign'></i>Qualification</a></li>
            <li><a href="index.php?r=profile/empWorkExperience/create">Work Experience</a></li>
            <li><a href="index.php?r=profile/empEducation/create">Education</a></li>
            <li><a href="index.php?r=profile/empLicenses/create">Licenses</a></li>
            <li><a href="index.php?r=profile/empTrainings/create">Seminars</a></li>

            <li class="active"><a href="#"><i class='icon-white icon-ok-sign'></i>Account</a></li>
            <li><a href="index.php?r=profile/user/update">Change Password</a></li>

            <li class="active"><a href="#"><i class='icon-white icon-ok-sign'></i>Other</a></li>
            <li><a href="index.php?r=profile/empAffiliation/create">Professional Organization</a></li>
            <li><a href="index.php?r=profile/empCivic/create">Civic Organizations</a></li>
            <li><a href="index.php?r=profile/empAward/create">Awards</a></li>
            
        </ul>

    </div>


    <div class="span8">
        <?php echo $content; ?>   
    </div>


</div>
<?php $this->endContent(); ?>