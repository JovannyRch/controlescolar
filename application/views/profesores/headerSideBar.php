<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Control Escolar</title>

    <link rel="icon" type="image/png" href="<?=base_url()?>asset/images/logo.png" />
    <link rel="stylesheet" href="<?=base_url()?>vendor/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="<?=base_url()?>vendor/font-awesome/css/fontawesome-all.min.css">
    <link rel="stylesheet" href="<?=base_url()?>css/styles.css">
    <script src="<?=base_url()?>js/axios.js"></script>
    <script src="<?=base_url()?>js/vue.js"></script>
    <script src="<?=base_url()?>js/jquery.min.js"></script>
    <style>
        .body {
            font-size: 30px
        }
    </style>
</head>

<body class="sidebar-hidden header-fixed">
    <div class="page-wrapper">
        <nav class="navbar page-header">
            <a href="#" class="btn btn-link sidebar-mobile-toggle d-md-none mr-auto">
                <i class="fa fa-bars"></i>
            </a>

            <a class="navbar-brand" href="<?= base_url('inicio')?>">
                <img src="<?=base_url()?>imgs/logo.png" width="15%" alt="logo"> <small>EST No. 224 "Moisés Sáenz"</small>
            </a>

            <a href="#" class="btn btn-link sidebar-toggle d-md-down-none">
                <i class="fa fa-bars"></i>
            </a>

            <ul class="navbar-nav ml-auto">

                <li class="nav-item d-md-down-none" id="sistema">
                    <a href="<?= base_url('mensajes')?>">
                        <i class="fa fa-envelope-open"></i>
                        <span class="badge badge-pill badge-danger">{{mensajesSinLeer}}</span>
                    </a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        <img src="<?=base_url()?>imgs/avatar-1.png" class="avatar avatar-sm" alt="logo">
                        <span class="small ml-1 d-md-down-none">
                            <?= $this->session->userdata('nombre');?></span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right">
                        <div class="dropdown-header">Mi cuenta</div>

                        <a href="#" class="dropdown-item">
                            <i class="fa fa-user"></i> Perfil
                        </a>

                        <a href="<?= base_url('mensajes')?>" class="dropdown-item">
                            <i class="fa fa-envelope"></i> Mensajes
                        </a>

                        <div class="dropdown-header">Configuraciones</div>

                        <a href="<?= site_url('login/logout');?>" class="dropdown-item">
                            <i class="fa fa-lock"></i> Cerrar Sesión
                        </a>
                    </div>
                </li>
            </ul>
        </nav>

        <div class="main-container">
            <div class="sidebar text-white">
                <nav class="sidebar-nav">
                    <ul class="nav">
                        <li class="nav-title">Nevegacion</li>

                        <li class="nav-item">
                            <a href="<?= base_url('inicio')?>" class="nav-link">
                                <i class="fa fa-star"></i> Inicio
                            </a>
                        </li>


                        <li class="nav-item">
                            <a href="<?= base_url('profesores/materias')?>" class="nav-link">
                                <i class="fa fa-tasks "></i> Materias
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="<?= base_url('usuarios/ver').'/'.$this->session->userdata('id_usuario')?>" class="nav-link">
                                <i class="fa fa-user"></i> Mis datos personales
                            </a>
                        </li>

                    </ul>
                </nav>
            </div>

            <div class="content">
                <div class="container-fluid">