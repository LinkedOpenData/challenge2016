<?php defined('C5_EXECUTE') or die("Access Denied."); ?>

<div class="row">
<div class="span10 offset1">

<div class="page-header"><h1><?php echo t('Members')?></div>

<div class="navbar">
<div class="navbar-inner">

<form method="get" action="<?php echo $view->action('search_members')?>" class="navbar-form">
	<input name="keywords" type="text" value="<?php echo $keywords?>" size="20" class="" placeholder="<?php echo t('Search')?>" />
	<input name="submit" type="button" value="<?php echo t('Search')?>" class="btn" />
</form>

</div>
</div>

<?php if ($total == 0) { ?>

		<div><?php echo t('No users found.')?></div>

	<?php } else { ?>

		<table class="table table-striped" id="ccm-members-directory">


		<?php
		$av = Loader::helper('concrete/avatar');
		$u = new User();

		foreach($users as $user) { 	?>

		<tr>
			<td class="ccm-members-directory-avatar"><a href="<?php echo $view->url('/members/profile','view', $user->getUserID())?>"><?php echo $av->outputUserAvatar($user)?></a></td>
			<td class="ccm-members-directory-name"><a href="<?php echo $view->url('/members/profile','view', $user->getUserID())?>"><?php echo ucfirst($user->getUserName())?></a></td>
			<?php
			foreach($attribs as $ak) { ?>
				<td>
					<?php echo $user->getAttribute($ak, 'displaySanitized', 'display'); ?>
				</td>
			<?php } ?>
		</tr>

		<?php } ?>

		</table>

        <?php if ($pagination->haveToPaginate()) { ?>

            <?php echo $pagination->renderDefaultView();?>

        <?php } ?>

	<?php

	} ?>


</div>
</div>
