<?php defined('C5_EXECUTE') or die("Access Denied.");  
$form = Loader::helper('form');
$c = Page::getCurrentPage();

if(!$ak instanceof CollectionAttributeKey) {?>
	<div class="ccm-error"><?php echo t('Error: The required page attribute with the handle of: "%s" doesn\'t exist',$controller->attributeHandle)?><br/><br/></div>
<?php } else { ?>
<input type="hidden" name="attributeHandle" value="<?php echo $controller->attributeHandle?>" />

    <?php echo $form->label('title', t('Title'))?>
	<div class="form-group">
		<?php echo $form->text('title',$title);?>
	</div>

	<label><?php echo t('Display a List of Tags From')?></label>
    <div class="form-group">
        <div class="radio">
            <label>
                <?php echo $form->radio('displayMode','page',$displayMode)?><?php echo t('The Current Page.')?>
            </label>
        </div>
        <div class="radio">
            <label>
                <?php echo $form->radio('displayMode','cloud',$displayMode)?><?php echo t('The Entire Site.')?>
            </label>
        </div>
    </div>

	<?php if (!$inStackDashboardPage) { ?>
	<div id="ccm-tags-display-page" class="form-group">
	<label><?php echo $ak->getAttributeKeyDisplayName();?></label>
        <div class="input">
            <?php
                $av = $c->getAttributeValueObject($ak);
                $ak->render('form',$av);
            ?>
        </div>
	</div>
	<?php } ?>

	<div id="ccm-tags-display-cloud" class="form-group">
     <?php echo $form->label('cloudCount', t('Number to Display'))?>
	<div class="input">
		<?php echo $form->text('cloudCount',$cloudCount,array('size'=>4))?>
	</div>
	</div>


	<div class="clearfix">
	<label style="margin-bottom: 0px;"><?php echo t('Link Tag to Search Page')?></label>
	<div class="input">
		<?php
		$form_selector = Loader::helper('form/page_selector');
		print $form_selector->selectPage('targetCID', $targetCID);
		?>
	</div>
	</div>

<?php } ?>
<script>
    $(function(){ tags.init(); });
</script>
