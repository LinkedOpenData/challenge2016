<?php
defined('C5_EXECUTE') or die("Access Denied.");
// basically a stub that includes some other files
$u = new User();
$uID = $u->getUserID();
$c = Page::getCurrentPage();

//available chart colors are duplicated in content/surveys.php
$availableChartColors = array(
    '00CCdd',
    'cc3333',
    '330099',
    'FF6600',
    '9966FF',
    'dd7700',
    '66DD00',
    '6699FF',
    'FFFF33',
    'FFCC33',
    '00CCdd',
    'cc3333',
    '330099',
    'FF6600',
    '9966FF',
    'dd7700',
    '66DD00',
    '6699FF',
    'FFFF33',
    'FFCC33');
$options = $controller->getPollOptions();
$optionNames = array();
$optionResults = array();
$graphColors = array();
$i = 1;
$totalVotes = 0;
foreach ($options as $opt) {
    $optionNamesAbbrev[] = $i;
    $optionResults[] = $opt->getResults();
    $i++;
    $graphColors[] = array_pop($availableChartColors);
    $totalVotes += intval($opt->getResults());
}
foreach ($optionResults as &$value) {
    if ($totalVotes) {
        $value = round($value / $totalVotes * 100, 0);
    }
}
$show_graph = (count($optionNamesAbbrev) && !$_GET['dontGraphPoll'] && $totalVotes > 0);
?>

<div class="poll">
    <?php
    if ($controller->hasVoted()) {
        ?>
        <h3><?php echo t("You've voted on this survey.") ?></h3>

        <div class="row">
            <div<?php echo $show_graph ? ' class="col-sm-9"' : '' ?>>
                <div id="surveyQuestion">
                    <strong><?php echo t("Question") ?>:</strong> <span><?php echo $controller->getQuestion() ?></span>
                </div>

                <div id="surveyResults">
                    <table class="table">
                        <?php
                        $i = 1;
                        foreach ($options as $opt) {
                            ?>
                            <tr>

                                <td class="col-sm-2" style="white-space: nowrap">
                                    <div class="surveySwatch" style="background:#<?php echo $graphColors[$i - 1] ?>"></div>
                                    &nbsp;<?php echo ($totalVotes > 0) ? round($opt->getResults() / $totalVotes * 100) : 0 ?>%
                                </td>
                                <td>
                                    <strong>
                                        <?php echo $opt->getOptionName() ?>
                                    </strong>
                                </td>
                            </tr>
                            <?php
                            $i++;
                            ?>
                        <?php
                        }
                        ?>
                    </table>
                    <div class="help-block">
                        <?php echo t2('%d Vote', '%d Votes', intval($totalVotes), intval($totalVotes)) ?>
                    </div>
                </div>
            </div>
            <?php
            if ($show_graph) {
                ?>
                <div class="col-sm-3">
                    <img
                        border=""
                        src="//chart.apis.google.com/chart?chf=bg,s,FFFFFF00&cht=p&chd=t:<?php echo join(
                            ',',
                            $optionResults) ?>&chs=180x180&chco=<?php echo join(
                            ',',
                            $graphColors) ?>"
                        alt="<?php echo t('survey results');
                        ?>"/>
                </div>
            <?php
            }
            ?>
        </div>
        <div class="spacer">&nbsp;</div>

        <?php
        if ($_GET['dontGraphPoll']) {
            ?>
            <div class="small right" style="margin-top:8px">
                <a class="arrow" href="<?php echo DIR_REL ?>/?cID=<?php echo $b->getBlockCollectionID() ?>">
                    <?php echo t('View Full Results') ?>
                </a>
            </div>
        <?php
        }
        ?>

        <div class="spacer">&nbsp;</div>

    <?php
    } else {
        ?>

        <div id="surveyQuestion" class="form-group">
            <?php echo $controller->getQuestion() ?>
        </div>

        <?php
        if (!$controller->requiresRegistration() || intval($uID) > 0) {
            ?>
            <form method="post" action="<?php echo $view->action('form_save_vote') ?>">
                <input type="hidden" name="rcID" value="<?php echo $c->getCollectionID() ?>"/>
        <?php
        }
        $options = $controller->getPollOptions();
        foreach ($options as $opt) {
            ?>
            <div class="radio">
                <label>
                    <input type="radio" name="optionID" value="<?php echo $opt->getOptionID() ?>"/>
                    <?php echo $opt->getOptionName() ?>
                </label>
            </div>
        <?php
        }
        if (!$controller->requiresRegistration() || intval($uID) > 0) {
            ?>
            <div class="form-group">
                <button class="btn btn-primary">
                    <?php echo t('Vote') ?>
                </button>
            </div>
        <?php
        } else {
            ?>
            <span class="help-block">
                <?php echo t('Please Login to Vote') ?>
            </span>
        <?php
        }
        ?>

        <?php
        if (!$controller->requiresRegistration() || intval($uID) > 0) {
            ?>
            </form>
        <?php
        }
        ?>

    <?php
    }
    ?>

</div>
