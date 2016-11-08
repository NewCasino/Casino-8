<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<?php echo $template->meta; ?>
<?php echo $template->header; ?>
<?php echo $template->layer; ?>
<?php echo $template->profile; ?>

<div class="center">
    <div class="head">
    
	    <?php echo $template->logo; ?>
	    <?php echo $template->top; ?>
	    <?php echo $template->logout; ?>
	    <?php echo $template->atack; ?>
	    
	</div>
	
    <div class="block">
        <div class="block-l">
            <div class="block-r">
            
                <?php echo $template->panel; ?>
                <?php echo $template->quick; ?>
                
            </div>
        </div>
    </div>
    
    <?php echo $template->switch; ?>
    
    <div class="wrapper">
        <div class="wrapper-t">
            <div class="wrapper-b-l">
                <div class="wrapper-b-r">
                    <div class="container">
                        <div class="content">
                            <div class="main">
                            
                                <?php echo $template->breadcrumps; ?>
                                <?php echo $template->form; ?>
                                <?php echo $template->list; ?>
                                
                            </div>
                        </div>
                        
                        <?php echo $template->left; ?>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <?php echo $template->foot; ?>
    
</div>

<?php echo $template->footer; ?>