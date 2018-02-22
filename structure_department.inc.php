<?php
        // $arActive = getActiveArray(isset($_GET['id']) ? $_GET['id'] : 0);
    if (!is_null($request)) {
        $department_tree = $request->getProperty('department_tree');

        $id = null;
        $id_parent = null;
        $end_html = "";
        
        foreach ($department_tree as $department) {
            if (!is_null($id_parent) && $id != $department->parent) {
                if ($id_parent != $department->parent)
                    echo $end_html;
                else
                    echo '</ul></li>';
            }
            else if (!is_null($id))
                $end_html = '</ul></li>' . $end_html;

            echo '<li class="tree"><a href="/unit.php?id=' . $department->id . '"><i class="fa fa-angle-right text-yellow"></i> <span>' . $department->fullname . '</span> </a>
                <ul class="treeview-menu">
                <li><a href="/?cmd=Unit&id_department=' . $department->id . '"><i class="fa fa-circle-o text-red"></i> <span>Штатное расписание</span></a></li>
                <li><a href="/?cmd=Person&id_department=' . $department->id . '"><i class="fa fa-circle-o text-red"></i> <span>Личный состав</span></a></li>
                <li><a href="/?cmd=Technique&id_department=' . $department->id . '"><i class="fa fa-circle-o text-red"></i> <span>Техника</span></a></li>';
                
            if ($id_parent != $department->parent)
                $id_parent = $department->parent;

            $id = $department->id;
        }
        echo '</ul></li';
    }
?>
