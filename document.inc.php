<div class="row">
    <div class="col-xs-12">
        <div class="panel panel-info">
            <div class="panel-heading">Руководящие документы</div>
            <div class="list-group">
                <?php
                    require_once ("view/ViewHelper.php") ;
                    $request = \view\ViewHelper::getRequest();
                    $document_list = $request->getProperty('document_list');

                    if (!is_null($document_list)) {
                        foreach ($document_list as $document) {
                            if (file_exists($document->file_name))
                                echo '<a href="/?cmd=Download&file=' . $document->file_name . '" target="_blank" class="list-group-item">' . $document->name . '</a>';
                            else
                                echo '<a href="#" class="list-group-item">' . $document->name . '</a>';
                        }
                    }
                ?>
            </div>
        </div>
    </div>
</div>