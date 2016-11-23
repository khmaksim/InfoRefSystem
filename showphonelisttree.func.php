<?php
    function showPhonelistTree($id, $padding = 1) {
        global $dbconn;

        $sql = "SELECT * FROM tdepartments WHERE parent = '" . $id . "' ORDER BY id, parent";
        foreach ($dbconn->query($sql) as $row) {

            echo '
                        <tr>
                            <td class="text-center"><input type="checkbox" name="active[]" value="' . $row['id'] . '" /></td>
                            <td style="padding-left: ' . (8 * $padding) . 'px;">' . $row['fullname'] . '</td>
                        </tr>
            ';

            showPhonelistTree($row['id'], $padding + 2);
        }
    }