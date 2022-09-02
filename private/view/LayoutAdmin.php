<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- BOOTSTRAP LINK CDN -->
    <!-- css -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!-- BOOTSTRAP js -->
   
    <!-- font awesome js -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
     <!-- Alertify JS -->
     <link rel="icon" 
     type="image/png" 
     href="../../public/assest/img/icon.png">
    <link rel="stylesheet" href="<?= getenv('BASE_URL') ?>style.css">
    <title>
        <?= isset($data['title']) ? $data['title'] : 'Document' ?>
    </title>
    <style>
        .ajs-close{
            position: relative;
            float: right;
            top: 19px;
            }
    </style>
</head>

<body onload="preloader()" style="font-size: initial;">
    <!--Page loader-->
    <div class="loader-wrapper">
        <div class="loader-circle">
            <div class="loader-wave"></div>
        </div>
    </div>

    <div class="container-fluid ">
        <header class="row header-admin shadow-sm">
            <div class="col-lg-3 col-md-4 header__app_name ">
                <h2 class="text-center pt-2 mb-0"><a href="<?= getenv('BASE_URL') ?>" class="app__name-link">
                        <i class="fa-solid fa-compass fs-2"></i>
                        KIWI</a></h2>
            </div>
            <div class="col-lg-9 col-md-8 header-left">
                <nav class="navbar navbar-light ">
                    <div class="container-fluid ps-0">
                        <!-- <input type="checkbox" hidden id="sidebartrans"> -->
                        <a class="menu__icon p-2 fs-4 text-dark" hre><i class="fa-solid fa-bars"
                                id="check__show-sidebar"></i></a>
                        <div class="header__nav-left d-flex justify-content-between align-items-center">
                            <form class="d-flex">
                                <input class="header__nav-search form-control me-2 rounded-pill " type="search"
                                    placeholder="Search" aria-label="Search">
                            </form>
                            <div class="profile">
                                <input type="checkbox" class="d-none" id="inputProfile">
                                <label for="inputProfile" href="#" class="profile_dropdown  fs-4 text-dark"><i
                                        class="fa-solid fa-user"></i></label>
                                <label for="inputProfile" class="overlay"></label>
                                <div class="dropdown dropdown-left hideProfile bg-white shadow border">
                                    <a class="dropdown-item" href="<?= getenv('BASE_URL') ?>logout">
                                        <i class="fa-solid fa-power-off"></i>
                                        Logout</a>
                                    <!-- <div class="dropdown-divider"></div> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
        </header>

        <div class="row main-content">
            <div class="col-lg-3 col-md-4 col-sm-1 col-1 body_taskbar sidebar pl-0">
                <div class="inner-sidebar">
                    <div class="sidebar-menu-container">
                        <ul class="sidebar-menu my-4 px-0">
                            <li class="sidebar__item py-3">
                                <a href="<?= getenv('BASE_URL') ?>dashboard" 
                                    class="sidebar__item-link"><i class="fa fa-dashboard mx-2"> </i>
                                    <span class="sidebar__text">Dashboard <i
                                            class="fa fa-angle-right float-right"></i></span>
                                </a>
                            </li>
                            <li class="sidebar__item py-3">
                                <a href="<?= getenv('BASE_URL') ?>dashboard/listAccount" 
                                    class="sidebar__item-link"><i class="fa-solid fa-users mx-2"></i>
                                    <span class="sidebar__text">Account <i
                                            class="fa fa-angle-right float-right"></i></span>
                                </a>
                            </li>
                            <li class="sidebar__item py-3">
                                <a href="<?= getenv('BASE_URL') ?>dashboard/listtransactions" 
                                    class="sidebar__item-link"><i class="fa-solid fa-money-bill mx-2"></i>
                                    <span class="sidebar__text">Transaction Confirm<i
                                            class="fa fa-angle-right float-right"></i></span>
                                </a>
                            </li>
                            <li class="sidebar__item py-3">
                                <a href="<?= getenv('BASE_URL') ?>dashboard/listAllTransaction" 
                                    class="sidebar__item-link"><i class="fa-solid fa-money-bill-1-wave mx-2"></i>
                                    <span class="sidebar__text">All Transactions
                                        <i class="fa fa-angle-right float-right"></i></span>
                                </a>
                            </li>
                            <li class="sidebar__item py-3 menu__icon">
                                <span  
                                    class="sidebar__item-link"><i class="fa-solid fa-arrow-left  mx-2"></i></i>
                                    <span class="sidebar__text"> Hide
                                    
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-9 col-md-8 col-sm-11 col-12 main__content">
                <?php
                    isset($data['page']) ?
                        include('./private/view/pages/adminPages/' . $data['page'] . '.php') : null
                ?>
            </div>

        </div>

    </div>
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <!-- JavaScript -->
        <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
        
        <!-- CSS -->
        <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
        <!-- Default theme -->
        <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css"/>
        <!-- Semantic UI theme -->
        <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/semantic.min.css"/>
        <!-- Bootstrap theme -->
        <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/bootstrap.min.css"/>
        
        <!-- 
            RTL version
        -->
        <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.rtl.min.css"/>
        <!-- Default theme -->
        <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.rtl.min.css"/>
        <!-- Semantic UI theme -->
        <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/semantic.rtl.min.css"/>
        <!-- Bootstrap theme -->
        <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/bootstrap.rtl.min.css"/>
        
        <script src="<?= getenv('BASE_URL') ?>main.js"></script>
       
</body>

</html>