<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>


<div class="row">
    <div class="span3">
       <h1>side</h1>
    </div>
    
    <div class="span9">
	    <div id="content">
			<?php echo $content; ?>
		</div><!-- content -->
    </div>

</div>



<?php $this->endContent(); ?>