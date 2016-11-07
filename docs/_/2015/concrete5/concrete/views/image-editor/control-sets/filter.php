<?php
use Concrete\Core\ImageEditor\Filter;
$filters = Filter::getList();

foreach ($filters as $filter) {
    ?>
    <div class="filter filter-<?php echo $filter->getHandle() ?>">
        <?php
        $view = new View;
        $view->setInnerContentFile($filter->getViewPath());
        echo $view->renderViewContents(array('filter' => $filter));
        ?>
    </div>
    <?php
}
?>
