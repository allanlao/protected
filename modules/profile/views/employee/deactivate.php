<?php
$this->breadcrumbs = array(
    'Users' => array('index'),
    'Activate/DeActivate',
);

$this->menu = CHtml::listData($departments, 'id', 'shortname');
?>



<h2>Activate/DeActivate Employee</h2>

 <?php $this->widget('bootstrap.widgets.TbAlert'); ?>

<?php
$isActive = array("Y" => "Active", "N" => "Inactive");

$dataArray = $dataProvider->getData();
$ctr = 0;
?>

<table class="table table-striped">
    <thead>
        <tr>
            <th>No.</th>
            <th>Employee Name</th>
            <th>Active/Inactive</th>
          
    </thead>
    <tbody>

        <?php
        foreach ($dataArray as $key => $value) {
            ?>

            <tr>
                <td><?php echo++$ctr; ?></td>
                <td><?php echo $value->fullname; ?></td>
               
                <td>
                    <?php
                    /*$stat=$value->isActive=='Y'?true:false;
                    echo CHtml::activeCheckBox($value,'isActive,array('check'=>'Y','uncheckValue'=>'N'), array('class'=>$value->emp_number,
                        'ajax' => array(
                            'type' => 'POST', //request type
                            'url' => CController::createUrl('employee/updateIsActive'), //url to call.
                             'data'=> 'js:"isActive=" + $(this).val() + "&id=" +   $(this).attr(\'class\').trim()',
                            'success'=>'function(data){
                                alert(data);
                      }')));*/
					  
					  echo CHtml::dropDownList('isActive', $value->isActive, $isActive, array('class'=>$value->emp_number,
                        'ajax' => array(
                            'type' => 'POST', //request type
                            'url' => CController::createUrl('employee/updateIsActive'), //url to call.
                            'data'=> 'js:"isActive=" + $(this).val() + "&id=" +   $(this).attr(\'class\').trim()',
                            'success'=>'function(data){
                                          
                                        }'
                            ))
                    );

                    ?>
                    
                    
                </td>

            </tr>

            <?php
        }
        ?>

    </tbody>
</table>

