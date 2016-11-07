<?php
defined('C5_EXECUTE') or die("Access Denied.");
$form = Loader::helper('form');
$node = \Concrete\Core\Tree\Node\Node::getByID(Loader::helper('security')->sanitizeInt($_REQUEST['treeNodeID']));
$np = new Permissions($node);
$tree = $node->getTreeObject();
$canEdit = (is_object($node) && $node->getTreeNodeTypeHandle() == 'topic_category' && $np->canEditTreeNode());
$url = View::url('/dashboard/system/attributes/topics', 'update_category_node');
$al = Loader::helper("concrete/asset_library");
if ($canEdit) { ?>

	<div class="ccm-ui">
		<form method="post" data-topic-form="update-category-node" class="form-horizontal" action="<?php echo $url?>">
			<?php echo Loader::helper('validation/token')->output('update_category_node')?>
			<input type="hidden" name="treeNodeID" value="<?php echo $node->getTreeNodeID()?>" />
			<div class="form-group">
				<?php echo $form->label('treeNodeCategoryName', t('Category Name'))?>
				<?php echo $form->text('treeNodeCategoryName', $node->getTreeNodeName(), array('class' => 'span4'))?>
			</div>
			<div class="dialog-buttons">
				<button class="btn btn-default" onclick="jQuery.fn.dialog.closeTop()"><?php echo t('Cancel')?></button>
				<button class="btn btn-primary pull-right" type="submit"><?php echo t('Update')?></button>
			</div>
		</form>
	</div>


<?php
}

