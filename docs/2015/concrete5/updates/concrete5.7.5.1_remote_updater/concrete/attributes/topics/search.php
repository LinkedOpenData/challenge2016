<?php if (is_object($tree)) { ?>

    <script type="text/javascript">
        $(function() {
            $('.tree-view-template-<?php echo $attributeKey->getAttributeKeyID()?>').ccmtopicstree({  // run first time around to get default tree if new.
                'treeID': <?php echo $tree->getTreeID(); ?>,
                'chooseNodeInForm': true,
                'noDrag' : true,
                <?php if($selectedNode) { ?>
                 'selectNodesByKey': [<?php echo $selectedNode ?>],
                 <?php } ?>
                'onSelect' : function(select, node) {
                     if (select) {
                        $('input[data-topic-search-field=<?php echo $attributeKey->getAttributeKeyID()?>]').val(node.data.key);
                     } else {
                         $('input[data-topic-search-field=<?php echo $attributeKey->getAttributeKeyID()?>]').val('');
                     }
                 }
            });
        });
    </script>
    <div class="tree-view-container">
        <div class="tree-view-template-<?php echo $attributeKey->getAttributeKeyID()?>">
        </div>
    </div>
    <input type="hidden" data-topic-search-field="<?php echo $attributeKey->getAttributeKeyID()?>"
           name="<?php echo $view->field('treeNodeID')?>" value="">

<?php } ?>