<?php defined('C5_EXECUTE') or die("Access Denied.");

$dh = Core::make('helper/date'); /* @var $dh \Concrete\Core\Localization\Service\Date */
?>
<div id="ccm-profile-header">

<div id="ccm-profile-avatar">
<?php print Loader::helper('concrete/avatar')->outputUserAvatar($profile); ?>
</div>

<h1><?php echo $profile->getUserName()?></h1>

<div id="ccm-profile-controls">
	<?php if ($canEdit) { ?>
		<div class="btn-group">
			<a href="<?php echo $view->url('/account/edit_profile')?>" class="btn btn-sm btn-default"><i class="fa fa-cog"></i> <?php echo t('Edit')?></a>
			<a href="<?php echo $view->url('/')?>" class="btn btn-sm btn-default"><i class="fa fa-home"></i> <?php echo t('Home')?></a>
		</div>
	<?php } else { ?>
		<?php if ($profile->getAttribute('profile_private_messages_enabled')) { ?>
			<a href="<?php echo $view->url('/account/messages/inbox', 'write', $profile->getUserID())?>" class="btn btn-sm btn-default"><i class="fa-user fa"></i> <?php echo t('Connect')?></a>
		<?php } ?>
	<?php } ?>
</div>


</div>

<div id="ccm-profile-statistics-bar">
	<div class="ccm-profile-statistics-item">
		<i class="icon-time"></i> <?php echo t(/*i18n: %s is a date */'Joined on %s', $dh->formatDate($profile->getUserDateAdded(), true))?>
	</div>
	<div class="ccm-profile-statistics-item">
		<i class="icon-fire"></i> <?php echo number_format(\Concrete\Core\User\Point\Entry::getTotal($profile))?> <?php echo t('Community Points')?>
	</div>
	<div class="ccm-profile-statistics-item">
		<i class="icon-bookmark"></i> <a href="#badges"><?php echo number_format(count($badges))?> <?php echo t2('Badge', 'Badges', count($badges))?></a>
	</div>
	<div class="clearfix"></div>
</div>


<div id="ccm-profile-wrapper">

	<div id="ccm-profile-detail">


        <?php
        $uaks = UserAttributeKey::getPublicProfileList();
        foreach($uaks as $ua) { ?>
		<div>
			<h4><?php echo $ua->getKeyName()?></h4>
			<?php
			$r = $profile->getAttribute($ua, 'displaySanitized', 'display');
			if ($r) {
				print $r;
			} else {
				print t('None');
			}
			?>
		</div>
        <?php  } ?>

		<h4><?php echo t("Badges")?></h4>
		<?php if (count($badges) > 0) { ?>


		<ul class="thumbnails">

			<?php foreach($badges as $ub) {
				$uf = $ub->getGroupBadgeImageObject();
				if (is_object($uf)) { ?>

			  <li class="span2">

			    <div class="thumbnail launch-tooltip ccm-profile-badge-image" title="<?php echo $ub->getGroupBadgeDescription()?>">
			      <div><img src="<?php echo $uf->getRelativePath()?>" /></div>
			      <div><?php echo t("Awarded %s", $dh->formatDate($ub->getGroupDateTimeEntered($profile)))?></div>
			    </div>

			</li>

			    <?php } ?>

			<?php } ?>

		</ul>

		<?php } else { ?>
			<p><?php echo t("This user hasn't won any badges.")?></p>
		<?php } ?>


		<?php
			$a = new Area('Main');
			//$a->setAttribute('profile', $profile);
			$a->setBlockWrapperStart('<div class="ccm-profile-body-item">');
			$a->setBlockWrapperEnd('</div>');
			$a->display($c);
		?>

	</div>
</div>

<script type="text/javascript">
$(function() {
	$(".launch-tooltip").tooltip({
		placement: 'bottom'
	});
});
</script>
