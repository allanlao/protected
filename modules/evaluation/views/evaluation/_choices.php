<?php
$c1 = ""; $c2=""; $c3=""; $c4=""; $c5="";
if(isset($answer[$x][$y])){
	$a = "c".$answer[$x][$y]; //$x is c3
	$$a = "checked";
}
?>
<div><input <?php echo $c5; ?> name="q[<?php echo $x.']['.$y;?>]" value="5" type="radio" />5</div>
<div><input <?php echo $c4; ?> name="q[<?php echo $x.']['.$y;?>]" value="4" type="radio" />4</div>
<div><input <?php echo $c3; ?> name="q[<?php echo $x.']['.$y;?>]" value="3" type="radio" />3</div>
<div><input <?php echo $c2; ?> name="q[<?php echo $x.']['.$y;?>]" value="2" type="radio" />2</div>
<div><input <?php echo $c1; ?> name="q[<?php echo $x.']['.$y;?>]" value="1" type="radio" />1</div>
