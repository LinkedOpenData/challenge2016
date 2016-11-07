<?php defined('C5_EXECUTE') or die("Access Denied."); ?>

<?php if ($this->controller->getTask() == 'inspect' || $this->controller->getTask() == 'refresh') { ?>


<h3><img src="<?php echo $ci->getBlockTypeIconURL($bt)?>" /> <?php echo t($bt->getBlockTypeName())?></h3>

<h5><?php echo t('Description')?></h5>
<p><?php echo t($bt->getBlockTypeDescription())?></p>

<h5><?php echo t('Usage Count')?></h5>
<p><?php echo $num?></p>

<h5><?php echo t('Usage Count on Active Pages')?></h5>
<p><?php echo $numActive?></p>

<?php if ($bt->isBlockTypeInternal()) { ?>
<h5><?php echo t('Internal')?></h5>
<p><?php echo t('This is an internal block type.')?></p>
<?php } ?>

<hr/>

<a href="<?php echo $view->url('/dashboard/blocks/types')?>" class="btn btn-default pull-left"><?php echo t('Back to Block Types')?></a>
    <?php
    $u = new User();
    if ($u->isSuperUser()) { ?>

    <div class="btn-group pull-right">
       <a href="<?php echo URL::to('/dashboard/blocks/types', 'refresh', $bt->getBlockTypeID())?>" class="btn btn-default"><?php echo t('Refresh')?></a>
       <a href="javascript:void(0)" class="btn btn-danger" onclick="removeBlockType()"><?php echo t('Remove')?></a>
    </div>

    <script type="text/javascript">
        removeBlockType = function() {
            if (confirm('<?php echo t('This will remove all instances of the %s block type. This cannot be undone. Are you sure?', $bt->getBlockTypeHandle())?>')) {
                location.href = "<?php echo $view->url('/dashboard/blocks/types', 'uninstall', $bt->getBlockTypeID(), $token->generate('uninstall'))?>";
            }
        }
    </script>

    <?php } else { ?>
        <a href="<?php echo URL::to('/dashboard/blocks/types', 'refresh', $bt->getBlockTypeID())?>" class="btn btn-default"><?php echo t('Refresh')?></a>
    <?php } ?>
</div>

<?php } else { ?>

	<h3><?php echo t('Awaiting Installation')?></h3>
	<?php if (count($availableBlockTypes) > 0) { ?>

        <ul class="item-select-list">
            <?php	foreach ($availableBlockTypes as $bt) {
                $btIcon = $ci->getBlockTypeIconURL($bt);
                ?>
                <li><span><img src="<?php echo $btIcon?>" /> <?php echo t($bt->getBlockTypeName())?>
                    <a href="<?php echo URL::to('/dashboard/blocks/types','install', $bt->getBlockTypeHandle())?>" class="btn pull-right btn-sm btn-default"><?php echo t('Install')?></a>
                    </span>
                </li>
            <?php } ?>
        </ul>

	<?php } else { ?>
		<p><?php echo t('No custom block types are awaiting installation.')?></p>
	<?php } ?>

    <?php if (Config::get('concrete.marketplace.enabled') == true) { ?>
    <div class="alert alert-info">
        <a class="btn btn-success btn-xs pull-right" href="<?php echo $view->url('/dashboard/extend/add-ons')?>"><?php echo t("More Add-ons")?></a>
        <p><?php echo t('Browse our marketplace of add-ons to extend your site!')?></p>
    </div>
    <?php } ?>

    <hr/>

	<h3><?php echo t('Installed Block Types')?></h3>
	<ul id="ccm-block-type-list-installed" class="item-select-list ccm-block-type-sortable-list">
		<?php foreach($normalBlockTypes as $bt) {
			$btIcon = $ci->getBlockTypeIconURL($bt);
			$btID = $bt->getBlockTypeID();
			?>
			<li id="btID_<?php echo $btID?>" data-btid="<?php echo $btID?>">
                <a href="<?php echo $view->action('inspect', $bt->getBlockTypeID())?>"><img src="<?php echo $btIcon?>" /> <?php echo t($bt->getBlockTypeName())?></a>
			</li>
		<?php } ?>
	</ul>

	<h3><?php echo t('Internal Block Types')?></h3>
    <ul class="item-select-list">
		<?php foreach($internalBlockTypes as $bt) {
			$btIcon = $ci->getBlockTypeIconURL($bt);
			?>
			<li>
                <a href="<?php echo $view->action('inspect', $bt->getBlockTypeID())?>"><img src="<?php echo $btIcon?>" /> <?php echo t($bt->getBlockTypeName())?></a>
			</li>
		<?php } ?>
	</ul>



</div>

<?php } ?>
