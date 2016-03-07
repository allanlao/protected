<?php
$this->breadcrumbs = array(
    'Users' => array('index'),
    'New',
);

$this->menu = CHtml::listData($departments, 'id', 'shortname');
?>



<h2>Change Supervisor</h2>

 <?php $this->widget('bootstrap.widgets.TbAlert'); ?>

<?php


$dataArray = $dataProvider->getData();
$ctr = 0;
?>

<table class="table table-striped">
    <thead>
        <tr>
            <th>No.</th>
            <th>Employee Name</th>
            <th>Supervisor</th>
       
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
                   
                    echo CHtml::dropDownList('supervisor', $value->emp_supervisor, Employee::model()->getEmployeeHeads(), array('class'=>$value->emp_number,
                        'ajax' => array(
                            'type' => 'POST', //request type
                            'url' => CController::createUrl('employee/updateSupervisor'), //url to call.
                            'data'=> 'js:"supervisor=" + $(this).val() + "&id=" +   $(this).attr(\'class\').trim()',
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

