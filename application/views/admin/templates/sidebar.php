<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Logical Expert's Dashboard</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        <link href="<?php echo URL; ?>assets/admin/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo URL; ?>assets/admin/css/bootstrap.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo URL; ?>assets/admin/css/custom.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo URL; ?>assets/admin/css/responsive.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo URL; ?>assets/admin/css/jquery-ui.css" rel="stylesheet" type="text/css" />
        <script src="<?php echo URL; ?>assets/admin/js/jquery-2.0.2.js"></script>
        <script src="<?php echo URL; ?>assets/admin/js/jquery-ui.js"></script>
        <script src="<?php echo URL; ?>assets/admin/js/bootstrap.min.js"></script>
        <?php echo (isset($js) && $js != '' ) ? $js : ''; ?>
        <script src="<?php echo URL; ?>assets/admin/js/function.js"></script>
        <script type="text/javascript">//<![CDATA[ 
            var $jas = jQuery.noConflict();
            $jas(window).load(function() {

                $jas("#myButton").click(function() {
                    // Set the effect type
                    var effect = 'slide';
                    // Set the options for the effect type chosen
                    var options = {direction: 'left'};
                    // Set the duration (default: 400 milliseconds)
                    var duration = 600;
                    $jas('#myDiv').toggle(effect, options, duration);
                    $jas(".right-cnt-main").toggleClass('highlight');
                });
                $jas('#myButton').trigger('click');
            });//]]>  

        </script>
    </head>

    <body>
        <div class="loader" style="display: none"><img src="<?php echo URL ?>assets/admin/images/loader.gif"></img></div>
        <!-- fullbody starts -->
        <input type="hidden" id="site-url" value="<?php echo ADMIN_URL; ?>" >
            <div class="fullbody">
                <!-- left-content starts -->
                <div class="left-cnt-main">
                    <!-- dashboard starts -->
                    <div class="dashboard-area" id="myDiv">
                        <div class="dash-header">
                            <div class="logo-dash">
                                <a href="#"><img src="<?php echo URL; ?>assets/admin/images/logo.jpg" alt="logo" /></a>
                            </div>
                            <div class="right-nav">
                                <ul>
                                    <li><a href="<?php echo URL; ?>"><img src="<?php echo URL; ?>assets/admin/images/home.png" alt="home" /></a></li>
                                    <li class="mail-chk"><a href="#"><img src="<?php echo URL; ?>assets/admin/images/mail.png" /> <span>3</span></a></li>
                                </ul>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="dashbrd-list">
                            <ul>
                                <li id="accordion"><img src="<?php echo URL; ?>assets/admin/images/dashbrd-sign.png" /><a href="<?php echo ADMIN_URL; ?>"> Dashboard</a></li>
                                <li><img src="<?php echo URL; ?>assets/admin/images/posts.png" /><a class="collapsable" data-toggle="collapse" data-parent="#accordion" href="#collapsetwo">Users <img class="add_sidebar_admin" src="<?php echo URL; ?>assets/admin/images/add.png" /><img class="open_sidebar_admin" src="<?php echo URL; ?>assets/admin/images/opened_img.png" /></a>
                                    <ul class="sub-menu panel-collapse collapse" id="collapsetwo">
                                        <?php if ($this->session->userdata('logged_in')[0]['userType'] == 'superadmin'): ?><li><a href="<?php echo ADMIN_URL . 'adminUsers'; ?>">Admin users</a></li><?php endif; ?>
                                        <li><a href="<?php echo ADMIN_URL . 'registerUsers'; ?>">Register Users</a></li>
                                    </ul>
                                </li>
                                <li id="accordion"><img src="<?php echo URL; ?>assets/admin/images/dashbrd-sign.png" /><a href="<?php echo ADMIN_URL . 'categories'; ?>"> Categories</a></li>
                                <li id="accordion"><img src="<?php echo URL; ?>assets/admin/images/media.png" /><a class="collapsable" data-toggle="collapse" data-parent="#accordion" href="#collapsethree">Classes <img class="add_sidebar_admin" src="<?php echo URL; ?>assets/admin/images/add.png" /><img class="open_sidebar_admin" src="<?php echo URL; ?>assets/admin/images/opened_img.png" /></a>
                                    <ul class="sub-menu panel-collapse collapse" id="collapsethree">
                                        <li><a href="<?php echo ADMIN_URL . 'courses'; ?>">Courses</a></li>
                                    </ul>
                                </li>
                                <li><img src="<?php echo URL; ?>assets/admin/images/links.png" /><a href="<?php echo ADMIN_URL . 'orders'; ?>">Order List</a></li>
                                <li><img src="<?php echo URL; ?>assets/admin/images/pages.png" /><a href="<?php echo ADMIN_URL . 'pages'; ?>">Pages</a></li>
                                <li><img src="<?php echo URL; ?>assets/admin/images/links.png" /><a href="<?php echo ADMIN_URL . 'navigations'; ?>">Navigations</a></li>
                                <li><img src="<?php echo URL; ?>assets/admin/images/listings.png" /><a href="<?php echo ADMIN_URL . 'settings'; ?>">Settings</a></li>
                            </ul>
                        </div>
                    </div>
                    <!-- dashboard ends -->
                </div>
                <!-- left-content ends -->
