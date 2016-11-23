<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/head.inc.php';
    $page = 'info';
?>
    <body>
        <?php
            include_once $_SERVER['DOCUMENT_ROOT'] . '/navbar.inc.php';
        ?>
        <div class="jumbotron">
            <div class="container">
                <h1 class="text-center"></h1>
                <p class="text-center">Редактирование данных.<br />
                <?= ($_GET['act'] == 'add') ? 'Добавление.' : 'Редактирование.'; ?>
                </p>
            </div>
        </div>
        <?php
            if ($_GET['act'] == 'edit') {
                $arInfo = getInfoById($_GET['id']);
            }
        ?>
        <div class="container">
            <form name="info" role="form" action="/save.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="act" value="<?= $_GET['act']; ?>Info" />
                <input type="hidden" name="id" value="<?= (isset($_GET['id'])) ? $_GET['id'] : ''; ?>" />
                <div class="form-group">
                    <label for="exampleInputEmail1">Наименование</label>
                    <input type="text" name="title" class="form-control" id="exampleInputEmail1" placeholder="Наименование"<?= ($_GET['act'] == 'edit') ? ' value="' . $arInfo['title'] . '"' : ''; ?>>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Дата</label>
                    <div class="input-group date">
                        <input type="text" name="idate" placeholder="Дата (формат 1979-01-01)" class="form-control"<?= ($_GET['act'] == 'edit') ? ' value="' . mb_substr($arInfo['idate'], 0, 10) . '"' : ''; ?>>
                        <span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="exampleInputFile">Активен</label><br />
                    <input type="checkbox" name="active" value="1"<?= ($_GET['act'] == 'edit' && $arInfo['active'] != 'true') ? '' : ' checked="checked"'; ?>>
                </div>
                <div class="form-group">
                    <?= ($_GET['act'] == 'edit' && $arInfo['img_ext'] != '') ? '<img src="/info/' . $arInfo['id'] . '_thumb.' . $arInfo['img_ext'] . '" border="0" alt="" class="img-thumbnail" /><br />' : ''; ?>
                    <label for="exampleInputFile">Фото</label>
                    <input type="file" name="info" id="exampleInputFile">
                    <p class="help-block">Размер файла не более 2 Мб.</p>
                </div>
                <?php
                    if ($_GET['act'] == 'edit') {
                        $infoblock = getInfoBlockById($_GET['id']);
                        $block = (is_array($infoblock) && $infoblock['user_id'] != $_SESSION['user_id']) ? true : false;
                        if ($block) {
                ?>
                <p>Данные открыты в режиме просмотра!</p>
                <a href="/" type="submit" class="btn btn-default">Закрыть</a>
                <?php
                        } else {
                            $sql = "INSERT INTO public.infoblock(info_id, user_id, blockdate) VALUES('" . $_GET['id'] . "', '" . $_SESSION['user_id'] . "', '" . date('Y-m-d H:i:s') . " Europe/Moscow')";
                            $dbconn->query($sql);

                ?>
                <a href="/close.php?info_id=<?= $_GET['id']; ?>" type="submit" class="btn btn-default">Отмена</a> <a onclick="checkForm();" type="submit" class="btn btn-primary">Сохранить</a>
                <?php
                        }
                    } else {
                ?>
                <a href="/" type="submit" class="btn btn-default">Отмена</a> <a onclick="checkForm();" type="submit" class="btn btn-primary">Добавить</a>
                <?php
                    }
                ?>
            </form>
        </div> <!-- /container -->
        <!-- Bootstrap core JavaScript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="/js/jquery.min.js"></script>
        <script src="/js/bootstrap.min.js"></script>
        <script src="/js/bootstrap-datepicker.min.js"></script>
        <script src="/js/locales/bootstrap-datepicker.ru.min.js" charset="UTF-8"></script>
        <script language="JavaScript" type="text/javascript">
        /*<![CDATA[*/
            $(document).ready(function(){
                $('.input-group.date').datepicker({
                    format: "yyyy-mm-dd",
                    todayBtn: "linked",
                    language: "ru",
                    autoclose: true,
                    todayHighlight: true
                });
            });

            function checkForm()
            {
                if (document.info.title.value != '') {
                    document.info.submit();
                } else {
                    alert('Укажите наименование данных!');
                }
            }



        /*]]>*/
        </script>
    </body>
</html>