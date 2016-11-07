
<?php 
//Used on both page and file attributes
$c = Page::getCurrentPage();

$sets = array();
if (is_object($category) && $category->allowAttributeSets()) {
	$sets = $category->getAttributeSets();
}
?>


<div class="ccm-dashboard-header-buttons">
	<?php if (count($sets) > 0) { ?>
		<button type="button" class="btn btn-default" data-toggle="dropdown">
		<?php echo t('View')?> <span class="caret"></span>
		</button>
		<ul class="dropdown-menu" role="menu">
		<li><a href="<?php echo Loader::helper('navigation')->getLinkToCollection($c)?>?asGroupAttributes=1"><?php echo t('Grouped by Set')?></a></li>
		<li><a href="<?php echo Loader::helper('navigation')->getLinkToCollection($c)?>?asGroupAttributes=0"><?php echo t('In One List')?></a></li>
		</ul>
	<?php } ?>
	<a href="<?php echo URL::to('/dashboard/system/attributes/sets', 'category', $category->getAttributeKeyCategoryID())?>" class="btn btn-default"><?php echo t('Manage Sets')?></a>
</div>

<?php
if (count($attribs) > 0) { ?>


	<?php
	$ih = Loader::helper('concrete/ui');

	
	if (count($sets) > 0 && ($_REQUEST['asGroupAttributes'] !== '0')) {

        foreach($sets as $as) { ?>

		<fieldset>
			<legend><?php echo $as->getAttributeSetDisplayName()?></legend>
	
		<?php
		
		$setattribs = $as->getAttributeKeys();
		if (count($setattribs) == 0) { ?>
		
			<div class="ccm-attribute-list-wrapper"><?php echo t('No attributes defined.')?></div>
		
		<?php } else { ?>
            <ul class="item-select-list ccm-sortable-attribute-set-list-wrapper" attribute-set-id="<?php echo $as->getAttributeSetID()?>" id="asID_<?php echo $as->getAttributeSetID()?>">
			<?php
			foreach($setattribs as $ak) { ?>
                <li class="ccm-attribute" id="akID_<?php echo $ak->getAttributeKeyID()?>">
                    <a href="<?php echo URL::to($editURL, 'edit', $ak->getAttributeKeyID())?>" title="<?php echo t('Handle')?>: <?php echo $ak->getAttributeKeyHandle(); ?>">
                        <img class="ccm-attribute-icon" src="<?php echo $ak->getAttributeKeyIconSRC()?>" width="16" height="16" />
                        <?php echo $ak->getAttributeKeyDisplayName()?>
                    </a>
                    <i class="ccm-item-select-list-sort"></i>
                </li>
			<?php } ?>
			</ul>
			
		<?php } ?>
			
		</fieldset>

		<?php } 
		
		$unsetattribs = $category->getUnassignedAttributeKeys();
		if (count($unsetattribs) > 0) { ?>
		
			<fieldset>
				<legend><?php echo t('Other')?></legend>
				<ul class="ccm-attribute-list-wrapper item-select-list">
				<?php
				foreach($unsetattribs as $ak) { ?>
                    <li class="ccm-attribute">
                        <a href="<?php echo URL::to($editURL, 'edit', $ak->getAttributeKeyID())?>" title="<?php echo t('Handle')?>: <?php echo $ak->getAttributeKeyHandle(); ?>">
                            <img class="ccm-attribute-icon" src="<?php echo $ak->getAttributeKeyIconSRC()?>" width="16" height="16" />
                            <?php echo $ak->getAttributeKeyDisplayName()?>
                        </a>
                    </li>
	            <?php } ?>
                </ul>
			</fieldset>
		
		<?php
		
		}
	
	} else { ?>
		<ul class="item-select-list <?php echo ($sortable?'ccm-sortable-attribute-list-wrapper':'ccm-attribute-list-wrapper');?>">
		<?php
        foreach($attribs as $ak) { ?>
            <li class="ccm-attribute" id="akID_<?php echo $ak->getAttributeKeyID()?>">
			    <a href="<?php echo URL::to($editURL, 'edit', $ak->getAttributeKeyID())?>" title="<?php echo t('Handle')?>: <?php echo $ak->getAttributeKeyHandle(); ?>"><img class="ccm-attribute-icon" src="<?php echo $ak->getAttributeKeyIconSRC()?>" width="16" height="16" /> <?php echo $ak->getAttributeKeyDisplayName()?></a>
                <?php if($sortable) { ?><i class="ccm-item-select-list-sort"></i><?php } ?>
		    </li>
		
		<?php } ?>
		</ul>
	
	<?php } ?>
	
<?php } else { ?>
	
	<p>
		<?php
	 echo t('No attributes defined.');
		?>
	</p>
	
<?php } ?>

<script type="text/javascript">
$(function() {
    $("ul.ccm-sortable-attribute-set-list-wrapper").sortable({
		handle: 'i.ccm-item-select-list-sort',
		cursor: 'move',
		opacity: 0.5,
		stop: function() {
			var ualist = $(this).sortable('serialize');
			ualist += '&cID=<?php echo $c->getCollectionID()?>';
			ualist += '&asID=' + $(this).attr('attribute-set-id');
            ualist += '&ccm_token=' + '<?php echo Loader::helper('validation/token')->generate('attribute_sort')?>';
			$.post('<?php echo URL::to('/ccm/system/attribute/attribute_sort/set')?>', ualist, function(r) {});
		}
	});
});
</script>


<?php $form = Loader::helper('form'); ?>
<?php if (isset($types) && is_array($types) && count($types) > 0) { ?>
<form method="get" action="<?php echo $view->action('select_type')?>" id="ccm-attribute-type-form">
	<label for="atID"><?php echo t('Add Attribute')?></label>
	<div class="form-inline">
	<div class="form-group">
		<?php echo $form->select('atID', $types)?>
	</div>
	<button type="submit" class="btn btn-default"><?php echo t('Go')?></button>
	</div>
</form>
<?php } ?>
