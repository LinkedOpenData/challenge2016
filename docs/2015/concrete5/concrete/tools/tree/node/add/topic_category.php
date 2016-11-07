<?php
defined('C5_EXECUTE') or die("Access Denied.");
$form = Loader::helper('form');
$parent = \Concrete\Core\Tree\Node\Node::getByID(Loader::helper('security')->sanitizeInt($_REQUEST['treeNodeParentID']));
$np = new Permissions($parent);
$tree = $parent->getTreeObject();
if ($tree->getTreeTypeHandle() != 'topic') {
	die;
}

$url = View::url('/dashboard/system/attributes/topics', 'add_category_node', $parent->getTreeNodeID());
$al = Loader::helper("concrete/asset_library");
if (is_object($parent) && $np->canAddTopicCategoryTreeNode()) { ?>

	<div class="ccm-ui">
		<form method="post" data-topic-form="add-category-node" class="form-horizontal" action="<?php echo $url?>">
			<?php echo Loader::helper('validation/token')->output('add_category_node')?>
			<div class="form-group">
				<?php echo $form->label('treeNodeCategoryName', t('Category Name'))?>
				<?php echo $form->text('treeNodeCategoryName', '', array('class' => 'span4'))?>
			</div>

			<div class="dialog-buttons">
				<button class="btn btn-default" onclick="jQuery.fn.dialog.closeTop()"><?php echo t('Cancel')?></button>
				<button class="btn btn-primary pull-right" type="submit"><?php echo t('Add')?></button>
			</div>
		</form>
	</div>


<?php
}

