<?php defined('C5_EXECUTE') or die('Access Denied.');

$json = Loader::helper('json');
?>
<style>
    .table.authentication-types i.handle {
        cursor:move;
    }
    .table.authentication-types tbody tr {
        cursor:pointer;
    }
    .table.authentication-types .ccm-concrete-authentication-type-svg > svg {
        width:20px;
        display:inline-block;
    }
</style>
<?php

if ($editmode) {
    $pageTitle = t('Edit %s Authentication Type', $at->getAuthenticationTypeName());
    ?><form class="form-stacked" method="post" action="<?php echo $view->action('save', $at->getAuthenticationTypeID())?>"><?php
}
if (!$editmode) {
    ?>
    <fieldset>
        <table class="table authentication-types">
            <thead>
                <tr>
                    <th></th>
                    <th><?php echo t('ID')?></th>
                    <th><?php echo t('Handle')?></th>
                    <th><?php echo t('Display Name')?></th>
                    <th></th>
                </tr>
            </thead>
            <tbody><?php
                foreach($ats as $at) {
                    ?><tr
                        data-authID="<?php echo $at->getAuthenticationTypeID()?>"
                        data-editURL="<?php echo h($view->action('edit', $at->getAuthenticationTypeID()))?>"
                        class="<?php echo $at->isEnabled() ? 'success' : 'error'?>">
                        <td style="overflow:hidden; text-align: center; width: 50px">
                            <div style='height:15px'>
                                <?php echo $at->getAuthenticationTypeIconHTML()?>
                            </div>
                        </td>
                        <td style="width: 100px"><?php echo $at->getAuthenticationTypeID()?></td>
                        <td><?php echo $at->getAuthenticationTypeHandle()?></td>
                        <td><?php echo $at->getAuthenticationTypeName()?></td>
                        <td style="text-align:right"><i style="cursor: move" class="fa fa-arrows"></i></td>
                    </tr><?php
                }
            ?></tbody>
        </table>
    </fieldset>
    <script type="text/javascript">
    (function($,location){
        'use strict';
        $(function(){
            var sortableTable = $('table.table tbody');
            sortableTable.sortable({
               handle: 'i.fa-arrows',
               helper: function(e, ui) {
                   ui.children().each(function() {
                       var me = $(this);
                       me.width(me.width());
                   });
                   return ui;
               },
               cursor: 'move',
               stop: function(e, ui) {
                   var order = [];
                   sortableTable.children().each(function() {
                       var me = $(this);
                       order.push(me.attr('data-authID'));
                   });
                   $.post('<?php echo $view->action('reorder')?>', {order: order});
               }
            });
            $('tbody tr').click(function() {
                location.href = $(this).attr('data-editURL');
            });
        });
    })(jQuery, window.location);
    </script>
    <?php
} else {
    ?>
    <?php echo $at->renderTypeForm()?>
    <?php
}

if ($editmode) {
    ?>
    <div class="ccm-dashboard-form-actions-wrapper">
        <div class="ccm-dashboard-form-actions">
            <a href="<?php echo $view->action('')?>" class="btn btn-default pull-left"><?php echo t('Cancel')?></a>
            <span class="pull-right">
                <a href="<?php echo $view->action($at->isEnabled() ? 'disable' : 'enable', $at->getAuthenticationTypeID())?>" class="btn btn-<?php echo $at->isEnabled() ? 'danger' : 'success'?>">
                    <?php echo $at->isEnabled() ? t('Disable') : t('Enable')?>
                </a>
                <button class='btn btn-primary'><?php echo t('Save')?></button>
            </span>
           </div>
        </div>
    </form>
    <?php
}
