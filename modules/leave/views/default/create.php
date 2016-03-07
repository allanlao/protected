
<?php
  $syList = "";
    $year = date('Y');
        if (date('m') < '05') {
            //if May
            $sy = $year - 1 . '-' . $year;
            $syList = array($sy => $sy);
        } else if ((date('m') >= '05') && (date('m') <= '05')) {
            $sy1 = $year - 1 . '-' . $year;
            $sy2 = $year . '-' . ($year + 1);
            $syList = array($sy1 => $sy1, $sy2 => $sy2);
        } else {
            $sy1 = $year . '-' . ($year + 1);
            $syList = array($sy1 => $sy1);
        }

?>

<div id="new-form">
    <h1> Generate Leave Credits </h1>
    <h3>Note: Existing Leave Credits will NOT be overwritten</h3>
   

    <?php echo CHtml::beginForm(); ?>
    <div class="row">
        <?php echo CHtml::label('Choose School Year', 'id'); ?>
        <?php echo CHtml::dropDownList('leave_sy', 'id', $syList); ?>

    </div>
    <div class="info">
        <?php echo Yii::app()->user->getFlash('duplicate'); ?>
    </div>

    <?php echo CHtml::submitButton('Generate', array('name' => 'btnGenerate')); ?>
    <?php
    $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'payroll-grid',
        'dataProvider' => $dataProvider,
        'selectableRows' => 2,
        'columns' => array(
            array('header' => 'No.', 'value' => '$row + 1'),
            'name',
            array(
                'class' => 'CCheckBoxColumn',
                'id' => 'selectedItems'
            )
        ),
    ));
    ?>

    <div class="row">
        <?php echo CHtml::submitButton('Generate', array('name' => 'btnGenerate')); ?>
    </div>

    <?php echo CHtml::endForm(); ?>
</div>