<div class="row">
    <div class="col-xs-12">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title">Руководящие документы</h3>
            </div>
            <div class="panel-body">
                <div class="list-group">
                <?php
                    $res = getDocuments($section);
                    if ($res) {
                        foreach ($res as $row) {
                            echo '<a href="download.php?file=' . $row['file_name'] . '" target="_blank" class="list-group-item">' . $row['name'] . '</a>';
                        }
                    }
                ?>
                </ul>
            </div>
        </div>
    </div>
</div>