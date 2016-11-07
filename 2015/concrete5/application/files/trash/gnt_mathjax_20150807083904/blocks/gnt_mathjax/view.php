<?php  defined('C5_EXECUTE') or die('Access Denied.');
/**
 *-----------------------------------------------------------------------------*
 * License: Concrete5 marketplace :                                            *
 * http://www.concrete5.org/help/legal/commercial_add-on_license/              *
 *                                                                             *
 * @author (Florian Delizy)                                                    *
 *                                                                             *
 * Copyright(C) 2013 Florian Delizy <florian.delizy@gmail.com>                 *
 *-----------------------------------------------------------------------------*
 */

use Page;
use Concrete\Package\GntMathjax\Src\MathjaxAsset;

$c = Page::getCurrentPage();
if ($c->isEditMode())
{

    $useCustom = !MathjaxAsset::isCommonConf( $configName );

    ?>
    <div class="ccm-edit-mode-disabled-item" style="text-align:left" >
        <?php echo t("Load MathJax Module (invisible outside edit mode) :")?>
        <ul>
            <li><?php echo $useGlobalConf ? t("Using global configuration") : t("Using block configuration") ?></li>

            <?php  if ( !$useGlobalConf ) { ?>
                <li><?php echo t("Using CDN :") . ( $useCDN ? t("yes, version : %s", $CDNversion ) : t("no") )?></li>
                <li><?php echo t("Using configuration :" ) . ( $useCustom ? t( "CUSTOM CONFIG" ) : $configName )?></li>
            <?php  } ?>
        </ul>
    </div>
    <?php 
}
