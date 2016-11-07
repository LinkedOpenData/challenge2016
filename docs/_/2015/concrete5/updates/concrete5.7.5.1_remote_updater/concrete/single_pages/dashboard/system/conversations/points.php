<?php defined('C5_EXECUTE') or die("Access Denied.");
$form = Loader::helper('form');
?>
<h4><?php echo t('Installed Rating Types')?></h4>
<?php if (count($ratingTypes) > 0) { ?>
    <form action="<?php echo $view->action('save')?>" method="post">
        <table class="table">
            <thead>
            <tr>
                <th><?php echo t('Name')?></th>
                <th><?php echo t('Point Value')?></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($ratingTypes as $ratingType) { ?>
                <tr>
                    <td><?php echo $ratingType->getConversationRatingTypeDisplayName();?></td>
                    <td><?php echo $form->number('rtPoints_' . $ratingType->getConversationRatingTypeID(), $ratingType->cnvRatingTypeCommunityPoints, array('style' => 'width: 100px'))?></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
        <div class="ccm-dashboard-form-actions-wrapper">
            <div class="ccm-dashboard-form-actions">
                <?php echo $form->submit('save', t('Save'), array(), 'btn-primary pull-right')?>
            </div>
        </div>
    </form>
<?php } else { ?>
    <p><?php echo t('There are no Community Points Rating Types installed.')?></p>
<?php } ?>
