<?php
    $request = \view\ViewHelper::getRequest();
    $user = $request->getProperty('user');
?>
<!-- Main Header -->
<header class="main-header">
    <!-- Header Navbar -->
        <nav class="navbar navbar-static-top" role="navigation">
            <!-- Logo -->
            <a href="/" class="logo">Информационно-справочная система СЗГТ</a></h2>
            <!-- Navbar Right Menu -->
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                <!-- User Account Menu -->
                    <li class="dropdown user user-menu">
                        <!-- Menu Toggle Button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <!-- The user image in the navbar-->
                            <?php 
                                $path_face = $_SERVER['DOCUMENT_ROOT'] . '/upload/face/' . $user->id . "_thumb." . $user->img_ext;
                            ?>
                            <img src=<?php print $path_face ?> class="user-image" alt="User Image">
                              <!-- hidden-xs hides the username on small devices so only the image appears. -->
                            <span class="hidden-xs"><?php print $user->title ?></span>
                        </a>
                        <ul class="dropdown-menu">
                        <!-- The user image in the menu -->
                            <li class="user-header">
                                <img src=<?php print $path_face ?> class="img-circle" alt="User Image">
                                <p>
                                    <?php print $user->title ?>
                                    <small><?php print $user->role ?></small>
                                </p>
                            </li>
                            <li class="user-footer">
                                <!--<div class="pull-left">
                                  <a href="#" class="btn btn-default btn-flat">Profile</a>
                                </div>-->
                                <div class="pull-right">
                                    <a href="/lib/logout.php" class="btn btn-default btn-flat">Выход</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
</header>