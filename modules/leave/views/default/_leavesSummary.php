<div class="portlet">
<table class="table table-condensed">
    <tr >
        <td>VL Remaining</td>
        <td><?php echo EmpLeaveCredits::model()->getVlCredits( $emp_number,$sy); ?></td>
    </tr>
    <tr >
        <td>SL Remaining</td>
        <td><?php echo EmpLeaveCredits::model()->getSlCredits( $emp_number,$sy); ?></td>
    </tr>
    <tr >
        <td>VL for Approval</td>
        <td><?php echo EmpLeaves::model()->getVlCommitted( $emp_number,$sy); ?></td>
    </tr>
    <tr >
        <td>SL for Approval</td>
        <td><?php echo EmpLeaves::model()->getSlCommitted( $emp_number,$sy); ?></td>
    </tr>
    <tr >
        <td>Other Leaves Used</td>
          <td><?php echo EmpLeaves::model()->getOtherCommitted( $emp_number,$sy); ?></td>
    </tr>
</table>
    </div>
