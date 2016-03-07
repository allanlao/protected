<?php $this->beginContent('//layouts/main'); ?>
<div class="container-fluid">
    <div class="row-fluid">
        <div class="span3 well">

            <ul class="nav nav-list">
                <li class="nav-header">
                    Departments
                </li>
                <li class="active">
                    <a href="#"><i class='icon-white icon-home'></i>Home</a>
                </li>
                <?php
                foreach ($this->menu as $key=>$item) {
                    echo "<li><a href=index.php?r=profile/". Yii::app()->controller->id."/".Yii::app()->controller->action->id."&id=".$key.">" . $item . " </a></li>";
                }
                ?>
            </ul>

        </div>
        <div class="span8">
            <?php echo $content; ?>
        </div>
    </div>
</div>
<?php $this->endContent(); ?>
