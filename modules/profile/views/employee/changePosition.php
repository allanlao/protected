<?php
$this->breadcrumbs = array(
    'Users' => array('index'),
    'Position',
);

$this->menu = CHtml::listData($departments, 'id', 'shortname');
?>



<h2>Change Position</h2>

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
            <th>Position</th>
       
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
                   
                    echo CHtml::dropDownList('emo_position_code', $value->emp_position_code, CHtml::listData(Position::model()->findAll(array('order'=>'position_desc')),'position_code','position_desc'), array('class'=>$value->emp_number,
                        'ajax' => array(
                            'type' => 'POST', //request type
                            'url' => CController::createUrl('employee/updatePosition'), //url to call.
                            'data'=> 'js:"position=" + $(this).val() + "&id=" +   $(this).attr(\'class\').trim()',
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

