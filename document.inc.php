<div class="row">
    <div class="col-xs-12">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title">Руководящие документы</h3>
            </div>
            <div class="panel-body">
                <div class="list-group">
                <?php
                    require_once ("view/ViewHelper.php") ;
                    $request = \view\ViewHelper::getRequest();
                    $document_list = $request->getProperty('document_list');

                    if (!is_null($document_list)) {
                        foreach ($document_list as $document) {
                            echo '<a href="download.php?file=' . $document->file_name . '" target="_blank" class="list-group-item">' . $document->name . '</a>';
                        }
                    }
                ?>
                </ul>
            </div>
        </div>
    </div>
</div>