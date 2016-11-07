<?php
defined('C5_EXECUTE') or die("Access Denied.");
$ag = \Concrete\Core\Http\ResponseAssetGroup::get();
$ag->requireAsset('core/lightbox');
?>
<div id="ccm-dialog-help" class="ccm-ui">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-8">
                <h2><?php echo t('Learn the basics.')?></h2>
                <div class="spacer-row-4"></div>
                <div class="container-fluid">
                    <div class="row">
                    <div class="col-xs-offset-1 col-xs-11">
                        <div class="ccm-dialog-help-item">
                            <h4><?php echo t('Use the toolbar')?></h4>
                            <ol class="breadcrumb">
                                <li><a data-lightbox="iframe" href="https://www.youtube.com/watch?v=VB-R71zk06U"><?php echo t('Watch Video')?></a></li>
                                <li class="hidden-xs"><a href="#" data-launch-guide="toolbar"><?php echo t('Run Guide')?></a></li>
                            </ol>
                        </div>
                        <div class="ccm-dialog-help-item">
                            <h4><?php echo t('Change content')?></h4>
                            <ol class="breadcrumb">
                                <li><a href="https://www.youtube.com/watch?v=Y1VmBVffLM0" data-lightbox="iframe"><?php echo t('Watch Video')?></a></li>
                                <li class="hidden-xs"><a href="#" data-launch-guide="change-content"><?php echo t('Run Guide')?></a></li>
                            </ol>
                        </div>
                        <div class="ccm-dialog-help-item">
                            <h4><?php echo t('Add a page')?></h4>
                            <ol class="breadcrumb">
                                <li><a href="https://www.youtube.com/watch?v=mWTNga4_O_Q" data-lightbox="iframe"><?php echo t('Watch Video')?></a></li>
                                <li class="hidden-xs"><a href="#" data-launch-guide="add-page"><?php echo t('Run Guide')?></a></li>
                            </ol>
                        </div>
                        <div class="ccm-dialog-help-item">
                            <h4><?php echo t('Personalize your site')?></h4>
                            <ol class="breadcrumb">
                                <li><a href="https://www.youtube.com/watch?v=xI8dUNAc6fU" data-lightbox="iframe"><?php echo t('Watch Video')?></a></li>
                                <li class="hidden-xs"><a href="#" data-launch-guide="personalize"><?php echo t('Run Guide')?></a></li>
                            </ol>
                        </div>
                        <div class="ccm-dialog-help-item">
                            <h4><?php echo t('Cleanup and organize your site')?></h4>
                            <ol class="breadcrumb">
                                <li><a href="https://www.youtube.com/watch?v=_NhlWLU_L6E" data-lightbox="iframe"><?php echo t('Watch Video')?></a></li>
                                <li class="hidden-xs"><a href="#" data-launch-guide="dashboard"><?php echo t('Run Guide')?></a></li>
                            </ol>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-4 col-accented">
                <h2><?php echo t('More help.')?></h2>
                <div class="spacer-row-4"></div>

                <div class="ccm-dialog-help-item">
                <ol class="ccm-dialog-help-item-icon-row">
                    <li><i class="fa fa-cog"></i></li>
                    <li><i class="fa fa-question-circle"></i></li>
                    <li><i class="fa fa-file-text"></i></li>
                </ol>
                <p><?php echo t('Read the <a href="%s" target="_blank">User Documentation</a> to learn editing and site management with concrete5.',
                    Config::get('concrete.urls.help.user'))?></p>
                </div>
                <div class="ccm-dialog-help-item">
                <ol class="ccm-dialog-help-item-icon-row">
                    <li><i class="fa fa-wrench"></i></li>
                    <li><i class="fa fa-code"></i></li>
                    <li><i class="fa fa-flash"></i></li>
                </ol>
                <p><?php echo t('The <a href="%s" target="_blank">Developer Documentation</a> covers theming, building add-ons and custom concrete5 development.',
                    Config::get('concrete.urls.help.developer'))?></p>
                </div>
                <div class="ccm-dialog-help-item">
                <ol class="ccm-dialog-help-item-icon-row">
                    <li><i class="fa fa-smile-o"></i></li>
                    <li><i class="fa fa-comment"></i></li>
                    <li><i class="fa fa-external-link"></i></li>
                </ol>
                <p><?php echo t('Finally, <a href="%s" target="_blank">the forum</a> is full of helpful community members that make concrete5 so great.',
                    Config::get('concrete.urls.help.forum'))?></p>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
$(function() {
    $('a[data-lightbox=iframe]').magnificPopup({
        disableOn: 700,
        type: 'iframe',
        mainClass: 'mfp-fade',
        removalDelay: 160,
        preloader: false,
        fixedContentPos: false
    });

    $('#ccm-dialog-help a[data-launch-guide]').on('click', function(e) {
        e.preventDefault();
        var tour = ConcreteHelpGuideManager.getGuide($(this).attr('data-launch-guide'));
        tour.start();

    });
});
</script>