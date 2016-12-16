<?php
    $depNumber = 0;

    function showDepartmentsTree($id, $padding = 1) {
        global $dbconn;
        global $depNumber;
        global $arAccessRight;
        
        $sql = "SELECT * FROM tdepartments WHERE parent = '" . $id . "' ORDER BY id, parent";
        foreach ($dbconn->query($sql) as $row) {
            if ($arAccessRight['omu'] > 3) {
            echo '
                        <tr>
                            <td>' . ++$depNumber . '</td>
                            <td style="padding-left: ' . (8 * $padding) . 'px;">' . $row['fullname'] . '</td>
                            <!--<td>' . getDepartmentsById($row['parent'])['fullname']. '</td>-->';
                            if ($row['editable'] == true and !in_array($arAccessRight['omu'], array(0, 4))) {
                                if (in_array($arAccessRight['omu'], array(2, 3, 6, 7))) {
                                    echo '
                                        <td class="col-xs-1 text-center"><a href="/departments_edit.php?act=edit&id=' . $row['id'] . '" class="button btn-success btn-sm"><span class="glyphicon glyphicon-pencil"></span></a></td>';
                                } else {
                                    echo '<td class="col-xs-1 text-center"><a class="button btn-default btn-sm"><span class="glyphicon glyphicon-pencil"></span></a></td>';
                                }
                                if (in_array($arAccessRight['omu'], array(1, 3, 5, 7))) {
                                    if (haveChilde($row['id'])) {
                                        echo '
                                            <td class="col-xs-1 text-center"><a class="button btn-default btn-sm"><span class="glyphicon glyphicon-remove"></span></a></td>';
                                    } else {
                                        echo '
                                        <td class="col-xs-1 text-center"><a href="javascript:void(0);" onclick="ConfirmDelete(' . $row['id'] . ');" class="button btn-danger btn-sm"><span class="glyphicon glyphicon-remove"></span></a></td>';
                                    }
                                } else {
                                    echo '<td class="col-xs-1 text-center"><a class="button btn-default btn-sm"><span class="glyphicon glyphicon-remove"></span></a></td>';
                                }
                            } else {
                                echo '<td class="col-xs-1 text-center"><a class="button btn-default btn-sm"><span class="glyphicon glyphicon-pencil"></span></a></td>
                                <td class="col-xs-1 text-center"><a class="button btn-default btn-sm"><span class="glyphicon glyphicon-remove"></span></a></td>
                                ';
                            }
            echo '
                        </tr>
            ';
        }
            showDepartmentsTree($row['id'], $padding + 2);
        }
    }