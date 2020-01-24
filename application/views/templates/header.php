<?php
    // Load texts by language
    $this->lang->load('user', $this->config->item('language'));
    $this->lang->load('mschool', $this->config->item('language'));
?>

<!doctype html>

<html lang="en">
    <head>
        <meta charset="utf-8">

        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title><?php echo $this->lang->line('texts_site_title') . ' | ' . $pageTitle ?></title>

        <link rel="icon" href="<?=base_url()?>favicon.ico" type="image/x-icon">
        <link rel="stylesheet" type="text/css" href="https://bootswatch.com/4/cerulean/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.5.1/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin=""/>
        <link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet">
    </head>

    <body class="Site">
        <div class="container-fluid p-0" id="banner">
            <a href="<?php echo base_url() ?>" class="no-decoration"><h3 class="p-2" id="banner-title">Annuaire des écoles de musique agréées du Bas-Rhin</h3></a>
        </div>
        
        <!-- Responsive navbar -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <span class="ml-2 mr-auto text-white d-block d-lg-none">Menu</span>

            <div class="collapse navbar-collapse" id="navbarColor01">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url() ?>"><i class="fa fa-home" aria-hidden="true"></i> <?php echo $this->lang->line('texts_home') ?><span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url() ?>mschool"><i class="fa fa-map-marker" aria-hidden="true"></i> <?php echo $this->lang->line('mschool_locate') ?><span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-search" aria-hidden="true"></i> <?php echo $this->lang->line('mschool_search') ?></a>
                        <div class="dropdown-menu">
                            <?php if($this->session->userdata('id')){
                                if($this->session->userdata('lat') && $this->session->userdata('lon') && $this->session->userdata('address')){
                                    echo '<a class="dropdown-item" href="' . base_url() . 'mschool/findClosest"><i class="fa fa-map-marker" aria-hidden="true"></i> ' . $this->lang->line('texts_closest') . '<span class="sr-only">(current)</span></a>'; 
                                }
                            }
                            else{
                                if(isset($_SESSION['lat']) && isset($_SESSION['lon'])){ 
                                    echo '<a class="dropdown-item" href="' . base_url() . 'mschool/findClosest"><i class="fa fa-map-marker" aria-hidden="true"></i> ' . $this->lang->line('texts_closest') . '<span class="sr-only">(current)</span></a>';
                                }
                            } 
                            ?>
                            <a class="dropdown-item" href="<?php echo base_url() ?>mschool/showAlpha/3"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> <?php echo $this->lang->line('mschool_order_alpha') ?><span class="sr-only">(current)</span></a>
                            <a class="dropdown-item" href="<?php echo base_url() ?>mschool/initPostcodeSearch"><i class="fa fa-building-o" aria-hidden="true"></i> <?php echo $this->lang->line('mschool_bypostcode') ?><span class="sr-only">(current)</span></a>
                        </div>
                    </li>
                    <!-- Contact form link -->
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url() ?>mschool/contact"><i class="fa fa-envelope" aria-hidden="true"></i> <?php echo $this->lang->line('mschool_contact') ?><span class="sr-only">(current)</span></a>
                    </li>
                </ul>

                <div class="dropdown-divider d-block d-lg-none"></div>
                
                <?php if($this->session->userdata('id')){ 
                    echo '<ul class="navbar-nav">';
                        echo '<li class="nav-item dropdown">';
                            echo '<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user"></i> ' . $this->lang->line('texts_myaccount') . '</a>';
                            echo '<div class="dropdown-menu dropdown-menu-right"  id="account-dropdown">';
                                echo '<a class="dropdown-item" href="' . base_url() . 'user/myPosition"><i class="fa fa-map-marker" aria-hidden="true"></i> ' . $this->lang->line('mschool_mylocation') . '</a>';
                                echo '<a class="dropdown-item" href="' . base_url() . 'user/mySchoolsList/1"><i class="fa fa-list" aria-hidden="true"></i> ' . $this->lang->line('mschool_list') . '</a>';
                                echo '<div class="dropdown-divider"></div>';
                                echo '<a class="dropdown-item" href="' . base_url() . 'user/showChangePass"><i class="fa fa-key" aria-hidden="true"></i> ' . $this->lang->line('texts_change_pass') . '</a>';
                                echo '<a class="dropdown-item" href="' . base_url() . 'user/showDelAccount"><i class="fa fa-trash" aria-hidden="true"></i> ' . $this->lang->line('texts_del_acc') . '</a>';
                                echo '<div class="dropdown-divider"></div>';
                                echo '<a class="dropdown-item" href="' . base_url() . 'user/logout"><i class="fa fa-sign-out" aria-hidden="true"></i> ' . $this->lang->line('texts_logout') . '</a>';
                            echo '</div>';
                        echo '</li>';
                    echo '</ul>';
                }
                else{
                    echo '<ul class="navbar-nav ml-auto">';
                        echo '<li class="nav-item">';
                            echo '<a class="nav-link" href="' . base_url() . 'registration"><i class="fa fa-user-plus" aria-hidden="true"></i> ' . $this->lang->line('texts_register') . '<span class="sr-only">(current)</span></a>';
                        echo '</li>';
                        echo '<li class="nav-item">';
                            echo '<a class="nav-link" href="' . base_url() . 'registration/showLogin"><i class="fa fa-sign-in" aria-hidden="true"></i> ' . $this->lang->line('texts_login') . '<span class="sr-only">(current)</span></a>';
                        echo '</li>';
                    echo '</ul>';
                } ?>
            </div>
        </nav>

        <!-- Cookies consent alert -->
        <?php if(!isset($_COOKIE['cookies_consent'])){ ?>
            <div class="alert alert-dismissible text-center text-light bg-info fixed-bottom mb-0" role="alert">
                <?php echo $this->lang->line('texts_cookiesalert') ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close" id="dismiss-cookies">
                    <span aria-hidden="true">&times;</span>
                </button>
                <p>
                    <a href="<?php echo base_url() ?>mschool/setCookiesConsent" class="btn btn-primary m-2" id="cookies-consent"><?php echo $this->lang->line('texts_cookiesyes') ?></a>
                    <a href="<?php echo base_url() ?>mschool/cookiesInfo" class="btn btn-primary m-2"><?php echo $this->lang->line('texts_cookiesmore') ?></a>
                </p>
            </div>
        <?php } ?>

        <main class="Site-content" >
            <div class="container p-2">
                <?php if(isset($headerIcon)){ 
                    echo '<h2 class="mt-4 mb-4"><i class="' . $headerIcon . '" aria-hidden="true"></i> ' . $pageTitle . '</h2>';
                } 
                ?>
                <?php 

                    if(validation_errors()){ 
                        echo '<div class="alert alert-dismissible alert-danger text-center">';
                            echo validation_errors(); 
                            echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
                                echo '<span aria-hidden="true">&times;</span>';
                            echo '</button>';
                        echo '</div>';
                    }

                    if($this->session->flashdata('problem_message')){
                        echo '<div class="alert alert-dismissible alert-danger text-center">';
                            echo $this->session->flashdata('problem_message'); 
                            echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
                                echo '<span aria-hidden="true">&times;</span>';
                            echo '</button>';
                        echo '</div>';
                    }

                    if($this->session->flashdata('message')){
                        echo '<div class="alert alert-dismissible alert-success text-center">';
                            echo $this->session->flashdata('message'); 
                            echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
                                echo '<span aria-hidden="true">&times;</span>';
                            echo '</button>';
                        echo '</div>';
                    }	
                ?>
        