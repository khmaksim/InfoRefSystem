<!-- Main Header -->
<header class="main-header">
    <!-- Header Navbar -->
        <nav class="navbar navbar-static-top" role="navigation">
            <!-- Logo -->
            <a href="/" class="logo">Информационно-справочная система СЗГТ</a>
            <!-- Navbar Right Menu -->
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                <!-- User Account Menu -->
                    <li class="dropdown user user-menu">
                        <!-- Menu Toggle Button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <!-- The user image in the navbar-->
                            <img src="/face/<?= $_SESSION['user_id']; ?>_thumb.<?= $arUser['img_ext']; ?>" class="user-image" alt="User Image">
                              <!-- hidden-xs hides the username on small devices so only the image appears. -->
                            <span class="hidden-xs"><!-- <?= getUserTitleById($_SESSION['user_id']); ?> --></span>
                        </a>
                        <ul class="dropdown-menu">
                        <!-- The user image in the menu -->
                            <li class="user-header">
                                <img src="/face/<?= $_SESSION['user_id']; ?>_thumb.<?= $arUser['img_ext']; ?>" class="img-circle" alt="User Image">
                                <p>
                                  <?= getUserTitleById($_SESSION['user_id']); ?>
                                  <small><?= getRoleTitleById(getUserRoleById($_SESSION['user_id'])); ?></small>
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