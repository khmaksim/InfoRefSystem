<?php
    function showDocument($section = "") {
        global $dbconn;

        $sql = "SELECT * FROM document WHERE section LIKE '%" . $section . "%' ORDER BY name";
        foreach ($dbconn->query($sql) as $row) {
            echo '
                <tr>
                    <td>№</td>
                    <td>' . $row['name'] . '</td>
                    <td>' . $row['section'] . '</td>
                    <td class="col-xs-1 text-center"><a href="/documents_edit.php?act=edit&id=' . $row['id'] . '" class="button btn-success btn-sm"><span class="glyphicon glyphicon-pencil"></span></a></td>
                    <td class="col-xs-1 text-center"><a href="javascript:void(0);" onclick="ConfirmDelete(' . $row['id'] . ');" class="button btn-danger btn-sm"><span class="glyphicon glyphicon-remove"></span></a></td>
                </tr>'
                ;
        }
    }
