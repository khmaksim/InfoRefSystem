<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/head.inc.php';
    $page = 'index';
?>
    <body>
        <?php
            include_once $_SERVER['DOCUMENT_ROOT'] . '/navbar.inc.php';
        ?>
        <div class="jumbotron">
            <div class="container">
                <h1 class="text-center">Таблица тестовых данных</h1>
                <p class="text-center">На данной странице будут выводятся тестовые данные хранимые в Информационной системе. Данные автоматически обновляются с определенным интервалом.</p>
            </div>
        </div>
        <div class="container">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th class="col-md-1">Номер</th>
                            <th>Наименование</th>
                            <th>Дата</th>
                            <th>Да/Нет</th>
                            <th>Фото</th>
                            <th class="col-md-1">Редактировать</th>
                            <th class="col-md-1">Удалить</th>
                        </tr>
                    </thead>
                    <tbody id="items">


                    </tbody>
                </table>
            </div>
        </div> <!-- /container -->
        <div class="container">
            <!-- Provides extra visual weight and identifies the primary action in a set of buttons -->
            <p class="text-right"><a href="/info_edit.php?act=add" type="button" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Добавить</a></p>

        </div> <!-- /container -->
        <!-- Bootstrap core JavaScript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="/js/jquery.min.js"></script>
        <script src="/js/bootstrap.min.js"></script>
        <script language="JavaScript" type="text/javascript">
        /*<![CDATA[*/
            $(document).ready(function(){
      		    $("#items").load("/info.func.php");
                setInterval(function() {$("#items").load("/info.func.php");}, 5000);
            });
        /*]]>*/
        </script>
    </body>
</html>