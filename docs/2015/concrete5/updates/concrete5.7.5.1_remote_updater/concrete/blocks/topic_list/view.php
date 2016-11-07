<?php  defined('C5_EXECUTE') or die("Access Denied."); ?>

<div class="ccm-block-topic-list-wrapper">

    <div class="ccm-block-topic-list-header">
        <h5><?php echo h($title)?></h5>
    </div>

    <?php
    if ($mode == 'S' && is_object($tree)):
        $node = $tree->getRootTreeNodeObject();
        $node->populateChildren();
        if (is_object($node)) {
            $walk = function($node) use (&$walk, &$view, $selectedTopicID) {
                print '<ul class="ccm-block-topic-list-list">';
                foreach($node->getChildNodes() as $topic) {
                    if ($topic instanceof \Concrete\Core\Tree\Node\Type\TopicCategory) { ?>
                        <li><?php echo $topic->getTreeNodeDisplayName()?></li>
                    <?php } else { ?>
                        <li><a href="<?php echo $view->controller->getTopicLink($topic)?>"
                                <?php if (isset($selectedTopicID) && $selectedTopicID == $topic->getTreeNodeID()) { ?>
                                    class="ccm-block-topic-list-topic-selected"
                                <?php } ?> ><?php echo $topic->getTreeNodeDisplayName()?></a></li>
                    <?php } ?>
                    <?php $walk($topic); ?>
                <?php }
                print '</ul>';
            };
            $walk($node);
        }

    endif;

    if ($mode == 'P'): ?>

        <?php if (count($topics)) { ?>
            <ul class="ccm-block-topic-list-page-topics">
            <?php foreach($topics as $topic) { ?>
                <li><a href="<?php echo $view->controller->getTopicLink($topic)?>"><?php echo $topic->getTreeNodeDisplayName()?></a></li>
            <?php } ?>
            </ul>
        <?php } else { ?>
            <?php echo t('No topics.')?>
        <?php } ?>

    <?php endif; ?>

</div>

