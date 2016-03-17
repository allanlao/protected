<?php
Yii::app()->clientScript->registerScript('addOption', '
function  DoAdd()
{ 

  var weekday=new Array(7);
      weekday[1]="Monday";
	  weekday[2]="Tuesday";
	  weekday[3]="Wednesday";
	  weekday[4]="Thursday";
	  weekday[5]="Friday";
	  weekday[6]="Saturday";
      weekday[0]="Sunday";
 
  var ampm = document.getElementById("ampm").value;
  var strText = document.getElementById("dpDate").value;
  var selectbox = document.getElementById("datesList");
  var sy = document.getElementById("EmpLeaves_leave_sy").value;
  var found = false;
 
   sy = sy.slice(5);
  
  var dateLimit = new Date(sy,04,31,12,00,00) + 11;
if (strText != "")
{
     var leaveDate = new Date(strText);

     if (leaveDate > dateLimit ){
         alert("Date is beyond the selected SY");
         found = true;
     }
  for(i=selectbox.options.length-1;i>=0;i--)
    {
       var str = selectbox.options[i].value;
       str = str.slice(0,10);
      if (str == strText)
      {
        found = true;
      }
    }
          if (!found)
          {
	
            strText = strText + " " + ampm + " " + weekday[leaveDate.getDay()];
            addOption(document.getElementById("datesList"), strText, strText);
            DoCompute();
          }
    }
}


		
		
function  DoAddRange()
{ 

  var weekday=new Array(7);
      weekday[1]="Monday";
	  weekday[2]="Tuesday";
	  weekday[3]="Wednesday";
	  weekday[4]="Thursday";
	  weekday[5]="Friday";
	  weekday[6]="Saturday";
      weekday[0]="Sunday";
 
  
  var startText = document.getElementById("dpDateFrom").value;
  var endText = document.getElementById("dpDateTo").value;
  var selectbox = document.getElementById("datesList");
  var sy = document.getElementById("EmpLeaves_leave_sy").value;
  var found = false;

  sy = sy.slice(5);
  
  var dateLimit = new Date(sy,04,31,12,00,00) + 11;
  var ampm = "wd";
  var start = new Date(startText);
  var end = new Date(endText);

  if (start > end){
     alert("Date range is invalid!");
     return;
  }

    while(start <= end){
 
		
if (start != "")
{
	var curr_date = start.getDate();
    var curr_month = start.getMonth() + 1; //Months are zero based
    var curr_year = start.getFullYear();	

		if (curr_date < 10){
            curr_date = "0" + curr_date;
         }
		if (curr_month < 10){
            curr_month = "0" + curr_month;
         }
     var strText = 	curr_year + "-"+curr_month+"-"+curr_date;
     var leaveDate = new Date(strText);

     if (leaveDate > dateLimit ){
         alert("Date is beyond the selected SY");
         found = true;
     }
  for(i=selectbox.options.length-1;i>=0;i--)
    {
       var str = selectbox.options[i].value;
       str = str.slice(0,10);
      if (str == strText)
      {
        found = true;
      }
    }
          if (!found)
          {
		  
            strText = strText + " " + ampm + " " + weekday[leaveDate.getDay()];
            addOption(document.getElementById("datesList"), strText, strText);
            DoCompute();
          }
    }
		
	var newDate = start.setDate(start.getDate() + 1);
	
    start = new Date(newDate);
		
  }	//while
		
}		

function DoRemove()
{
  var strId = document.getElementById("dpDate").value;
  removeOptions(document.getElementById("datesList"), strId);
  DoCompute();
}
		


function DoCompute()
{
 var total = 0;
 var selectbox = document.getElementById("datesList");
    for(i=selectbox.options.length-1;i>=0;i--)
    {
       var str = selectbox.options[i].value;
   
       if (str.slice(11,13) == "wd")
              total = total + 1;
          else
              total = total + 0.5;
       
    }
    document.getElementById("EmpLeaves_leave_days").value = total;
}

function Validate()
{
   DoSelectAll();

}

function DoSelectAll()
{
    var selectbox = document.getElementById("datesList");
    for(i=selectbox.options.length-1;i>=0;i--)
    {
       selectbox.options[i].selected = true;
    }
}


function clearList()
{
document.getElementById("datesList").options.length=0;
}

function addOption(selectbox,text,value )
{
var optn = document.createElement("OPTION");
optn.text = text;
optn.value = value;
selectbox.options.add(optn);
}

function removeOptions(selectbox)
{
var i;
for(i=selectbox.options.length-1;i>=0;i--)
{
if(selectbox.options[i].selected)
selectbox.remove(i);
}
}


function GetItemIndex(objListBox, strId)
{
  for (var i = 0; i < objListBox.children.length; i++)
  {
    var strCurrentValueId = objListBox.children[i].id;
    if (strId == strCurrentValueId)
    {
      return i;
    }
  }
  return -1;
}', CClientScript::POS_HEAD);
?>



<?php
$readOnly = false;



//

?>
<div>
    <br>

    <?php $this->widget('bootstrap.widgets.TbAlert'); ?>



    <?php
    $typeList = array('vlp' => 'Vacation Leave with Pay', 
                      'slp' => 'Sick Leave with Pay', 
                      'elp' => 'Emergency Leave with Pay',
                       'bl' => 'Birthday Leave', 
                       'pl' => 'Paternity Leave', 
                       'ml' => 'Maternity Leave - Normal',
					   'mlc' => 'Maternity Leave - Caesarian',
                       'vl' => 'Vacation Leave without Pay', 
                       'sl' => 'Sick Leave without Pay', 
                       'el' => 'Emergency Leave without Pay',
                       'cl' => 'Christmas Leave',
                    
                     
                    );

//build the SY list to include current year and next SY if month is already May 
//SY range from june - to may
    $year = date('Y');
    if (date('m') < '05') {
        //if May
        $sy = $year - 1 . '-' . $year;
        $syList = array($sy => $sy);
    } else if ((date('m') >= '05') && (date('m') <= '07')) {
        $sy1 = $year - 1 . '-' . $year;
        $sy2 = $year . '-' . ($year + 1);
      //  $syList = array($sy1 => $sy1, $sy2 => $sy2);
         $syList = array($sy2 => $sy2);

    } else {
        $sy1 = $year . '-' . ($year + 1);
        $syList = array($sy1 => $sy1);
    }




    $rooms = new Room;
    $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id' => 'emp-leaves-form',
        'enableAjaxValidation' => false,
        'type' => 'horizontal',
            //'htmlOptions' => array('class' => 'well'),
            'htmlOptions' => array('class' => 'form-horizontal'),
        ));
?>
    
    <fieldset>
      
        <?php echo $form->errorSummary($model); ?>



        <div class="control-group">
            <?php echo $form->labelEx($model, 'leave_sy', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'leave_sy', $syList, array('onchange' => 'clearList()')); ?>
            </div>
        </div>

        <div class="control-group">
            <?php echo $form->labelEx($model, 'leave_type', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'leave_type', $typeList); ?>
            </div>
        </div>

       
           <div class="control-group">
            <div class="control-label">
                <?php echo CHtml::label('From', 'dpDateRange'); ?>
            </div>
            <div class="controls">
                <?php
                $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'name' => 'dpDateFrom',
                    // additional javascript options for the date picker plugin
                    'options' => array(
                        'showAnim' => 'fold',
                        'dateFormat' => 'yy-mm-dd',
                        'minDate' => '-30',
                        'onSelect' => 'js:function( selectedDate ) {
                               // #end_date is the ID of end_date input text field
                          var lp = document.getElementById("EmpLeaves_leave_type").value;
                        
                          var start_date = new Date(selectedDate);
                        
                          var end_date = new Date(selectedDate);
                        
                      

                        if (lp =="pl"){
                           end_date.setDate(start_date.getDate() + 7);
                        }else if(lp=="ml"){
                           end_date.setDate(start_date.getDate() + 60);
                        }else if (lp=="mlc"){
                          end_date.setDate(start_date.getDate() + 72);
                        }else{
                            end_date.setDate(start_date.getDate() + 1);
                        }

  
                          var dd = end_date.getDate();
                          var mm = end_date.getMonth() + 1;
                          var y = end_date.getFullYear();

                           selectedDate = y + "-" + mm + "-"+ dd;
                        


                      $("#dpDateTo").datepicker("setDate", selectedDate );
                      

                       }',
 
                    ),
                    'htmlOptions' => array(
                       'style' => 'height:20px; width:100px',
                    ),
                ));
                ?>
                
                to
                      <?php
                $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'name' => 'dpDateTo',
                    // additional javascript options for the date picker plugin
                    'options' => array(
                        'showAnim' => 'fold',
                        'dateFormat' => 'yy-mm-dd',
						            'size'=>5,
                        'minDate' => '-15',
                       
                    ),
                    'htmlOptions' => array(
                        'style' => 'height:20px; width:100px',
                       
                    ),
                ));
                ?>
              
                <?php echo CHtml::button('add', array('class' => 'btn btn-primary', 'onclick' => 'DoAddRange()')); ?>
                <?php echo $form->error($model, 'leave_details_date'); ?>
            </div>
        </div>
       
        <div class="control-group">
            <div class="control-label">
                <?php echo CHtml::label('Select Date(s)', 'dpDate'); ?>
            </div>
            <div class="controls">
                <?php
                $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'name' => 'dpDate',
                    // additional javascript options for the date picker plugin
                    'options' => array(
                        'showAnim' => 'fold',
                        'dateFormat' => 'yy-mm-dd',
                        'minDate' => '-15',
                        'maxDate' => '+30',
                    ),
                    'htmlOptions' => array(
                        'style' => 'height:20px;',

                    ),
                ));
                ?>
                <?php echo CHtml::dropDownList('ampm', 'v', array('wd' => 'Whole Day', 'am' => 'A.M.', 'pm' => 'P.M.'), array('class' => 'span2')); ?>
                <?php echo CHtml::button('add', array('class' => 'btn btn-primary', 'onclick' => 'DoAdd()')); ?>
                <?php echo "(for 1 day or half day) ";?>
                <?php echo $form->error($model, 'leave_details_date'); ?>
            </div>
        </div>
        <div class="control-group">
            <div class="control-label">
                <?php echo CHtml::label('Leave Days', 'datesList'); ?>
            </div>
            <div class="controls">
                <?php echo CHtml::listBox('datesList', 'selected',array(), array('multiple' => 'true','size'=>10)); ?>
            </div>
        </div>

        <div class="control-group">
            <div class="control-label">
                <?php echo CHtml::label('Select date to remove', 'btnRemove'); ?>
            </div>
            <div class="controls">
                <?php echo CHtml::button('Remove Item', array('id' => 'btnRemove', 'class' => 'btn btn-danger', 'onclick' => 'DoRemove()')); ?>
                <?php echo CHtml::button('Clear', array('id' => 'btnClear', 'class' => 'btn btn-danger', 'onclick' => 'clearList()')); ?>
            </div>
        </div>

        <div class="control-group">
            <?php echo $form->labelEx($model, 'leave_days', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'leave_days', array('value' => '0', 'readonly' => 'true')) ?>
            </div>
        </div>

        <div class="control-group">
            <?php echo $form->labelEx($model, 'leave_reason', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textArea($model, 'leave_reason', array('class' => 'span5', 'rows' => '5')) ?>
            </div>
        </div>

        <?php echo $form->hiddenField($model, 'leave_id', array('value' => uniqid())); ?>
    </fieldset>
    
    <div class="form-actions">
        <?php echo CHtml::htmlButton('<i class="icon-ok icon-white"></i> Submit', array('class' => 'btn btn-primary', 'type' => 'submit', 'onclick' => 'Validate()')); ?>
        <?php echo CHtml::htmlButton('<i class="icon-repeat"></i> Reset', array('class' => 'btn btn-warning', 'type' => 'reset')); ?>
    </div>

    <?php $this->endWidget(); ?>


</div>

