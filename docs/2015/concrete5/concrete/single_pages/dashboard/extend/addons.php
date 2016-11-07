<?php
defined('C5_EXECUTE') or die("Access Denied.");
if ($controller->getTask() == 'view_detail') { ?>

    <div class="ccm-marketplace-detail-add-on-details-wrapper">

    <div class="ccm-marketplace-detail-add-on-gallery">
        <?php
        $detailShots = $item->getScreenshots();
        ?>
        <ul data-gallery="marketplace-addon">
            <?php foreach($detailShots as $i => $image) { ?>
                <li><a href="<?php echo $image->src?>"><?php echo t('Launch')?></a></li>
            <?php } ?>
        </ul>
    </div>

    <div class="ccm-marketplace-detail-add-on-details">
        <div class="ccm-marketplace-list-item-add-on-thumbnail"><?php
            $thumb = $item->getRemoteIconURL();
            printf('<img src="%s">', $thumb);
            ?>
        </div>
        <h2><?php echo $item->getName()?></h2>
        <div><i class="<?php echo $item->getSkillLevelClassName()?>"></i> <?php echo $item->getSkillLevelDisplayName()?></div>
    </div>

    <div class="ccm-marketplace-detail-add-on-nav">
        <div class="ccm-marketplace-detail-add-on-buy">
            <div class="btn-group">
                <button onclick="ConcreteMarketplace.purchaseOrDownload({mpID: <?php echo $item->getMarketplaceItemID()?>})" class="btn btn-price" style="background-color: #1888d3"><?php echo $item->getDisplayPrice()?></button>
                <button onclick="ConcreteMarketplace.purchaseOrDownload({mpID: <?php echo $item->getMarketplaceItemID()?>})" class="btn btn-description"><?php if ($item->purchaseRequired()) { ?><?php echo t('Purchase')?><?php } else { ?><?php echo t('Download')?><?php } ?></button>
            </div>
        </div>
        <nav>
            <li><a href="#" data-launch="marketplace-gallery"><i class="fa fa-image"></i> <?php echo t('Screenshots')?></a></li>
        </nav>
    </div>

    </div>

    <div class="ccm-marketplace-detail-columns">
        <div class="row">
            <div class="col-md-4">
                <ul class="list-group">
                    <li class="list-group-item"><?php echo Loader::helper('rating')->outputDisplay($item->getAverageRating())?>
                    <?php if ($item->getTotalRatings() > 0) { ?>
                        <a href="<?php echo $item->getRemoteReviewsURL()?>" target="_blank" class="ccm-marketplace-detail-reviews-link">
                    <?php } ?>
                    <?php echo t2('%d review', '%d reviews', $item->getTotalRatings(), $item->getTotalRatings())?>
                    <?php if ($item->getTotalRatings() > 0) { ?>
                        </a>
                    <?php } ?>
                    </li>
                    <?php if ($item->getExampleURL()) { ?>
                        <li class="list-group-item"><a href="<?php echo $item->getExampleURL()?>" target="_blank"><?php echo t('Live Example')?></a></li>
                    <?php } ?>
                    <li class="list-group-item"><a href="<?php echo $item->getRemoteHelpURL()?>" target="_blank"><i class="fa fa-comment"></i> <?php echo t('Get Help')?></a></li>
                </ul>
            </div>
            <div class="col-md-7 col-md-offset-1">
                <?php echo $item->getBody()?>
            </div>
        </div>
    </div>


    <script type="text/javascript">
    $(function () {
        $('a[data-launch=marketplace-gallery]').on('click', function(e) {
            e.preventDefault();
            $('ul[data-gallery=marketplace-addon] li:first-child a').trigger('click');
        });

        $('ul[data-gallery=marketplace-addon]').magnificPopup({
          delegate: 'a',
          type: 'image',
          closeOnContentClick: false,
          closeBtnInside: false,
          mainClass: 'mfp-zoom-in mfp-img-mobile',
          image: {
            verticalFit: true
          },
          gallery: {
            enabled: true
          },
          callbacks: {
              open: function() {
                $('.mfp-content').addClass('ccm-ui');
              }
          },
          zoom: {
            enabled: true,
            duration: 300,
            opener: function(element) {
              return element.find('img');
            }
          }

        });
    });
    </script>
<?php } else if (count($items)) { ?>

    <?php foreach($items as $mi) { ?>

        <div class="ccm-marketplace-list-item">
            <div class="ccm-marketplace-list-item-add-on-thumbnail"><a href="<?php echo $mi->getLocalURL()?>"><?php
                $thumb = $mi->getRemoteIconURL();
                printf('<img src="%s">', $thumb);
                ?></a></div>
            <div class="ccm-marketplace-list-item-add-on-description">
                <h2><a href="<?php echo $mi->getLocalURL()?>"><?php echo $mi->getName()?></a></h2>
                    <p><?php echo $mi->getDescription()?></p>
            </div>
            <div class="ccm-marketplace-list-item-add-on-price">
                    <?php echo $mi->getDisplayPrice()?>
            </div>
        </div>

    <?php } ?>

    <?php echo $list->displayPagingV2()?>

<?php } else { ?>
   <div class="ccm-marketplace-list-item">
   <div class="ccm-marketplace-list-item-add-on-description">
    <p><?php echo t('No add-ons found.')?></p>
    </div>
    </div>
<?php } ?>