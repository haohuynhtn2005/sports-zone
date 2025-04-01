<?php if (isset($breadcrumbs) && is_array($breadcrumbs) && !empty($breadcrumbs)): ?>
    <ol class="breadcrumb">
        <?php
        $end_breadcrumbs = count($breadcrumbs);
        $start_breadcrumbs = 0;
        foreach ($breadcrumbs as $breadcrumb) {
            $class_active = '';
            $start_breadcrumbs++;
            $name = strtolower($breadcrumb['name']);
            if ($start_breadcrumbs === $end_breadcrumbs) {
                echo  "<li class='breadcrumb-item white c-default'>" . ucfirst($name) . "</li>";
            } else {
                echo "<li class='breadcrumb-item white-hover gray3 slow'><a href='" . $breadcrumb['url'] . "'>" . ucfirst($name) . "</a></li>";
            }
        }
        ?>
    </ol>
<?php endif; ?>