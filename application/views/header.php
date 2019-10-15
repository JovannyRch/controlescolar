<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Control Escolar</title>
    <link rel="stylesheet" href="<?=base_url()?>vendor/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="<?=base_url()?>vendor/font-awesome/css/fontawesome-all.min.css">
    <link rel="stylesheet" href="<?=base_url()?>css/styles.css">
    <script src="<?=base_url()?>js/axios.js"></script>
    <script src="<?=base_url()?>js/vue.js"></script>
    <script src="<?=base_url()?>js/jquery.min.js"></script>
</head>

<body class="sidebar-fixed header-fixed">
    <div class="page-wrapper ">
        <nav class="navbar page-header " style="background-color: rgba(0, 133, 62, 1); color:white">
            <a href="#" class="btn btn-link sidebar-mobile-toggle d-md-none mr-auto">
                <i class="fa fa-bars"></i>
            </a>

            <a class="navbar-brand" href="<?= base_url('inicio')?>" style="color: white">
                <img src="<?=base_url()?>assets/img/uem_white.png" width="15%" alt="logo"> <small>UEM | Almoloya de
                    Juárez</small>
            </a>

            <a href="#" class="btn btn-link sidebar-toggle d-md-down-none" style="color: white">
                <i class="fa fa-bars"></i>
            </a>

            <ul class="navbar-nav ml-auto">

                <li class="nav-item d-md-down-none" id="sistema">
                    <a href="<?= base_url('mensajes')?>" style="color: white">
                        <i class="fa fa-envelope-open"></i>
                        <span class="badge badge-pill badge-danger">{{mensajesSinLeer}}</span>
                    </a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <img src="<?=base_url()?>imgs/avatar-1.png" class="avatar avatar-sm" alt="logo">
                        <span class="small ml-1 d-md-down-none" style="color: white">
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

                        <a href="#" class="dropdown-item">
                            <i class="fa fa-bell"></i> Notificaciones
                        </a>

                        <a href="#" class="dropdown-item">
                            <i class="fa fa-wrench"></i> Configuracion
                        </a>

                        <a href="<?= site_url('login/logout');?>" class="dropdown-item">
                            <i class="fa fa-lock"></i> Logout
                        </a>
                    </div>
                </li>
            </ul>
        </nav>

        <div class="main-container">
            <div class="sidebar text-white " style="color: white">
                <nav class="sidebar-nav">
                    <ul class="nav">
                        <li class="nav-title">Nevegacion</li>

                        <li class="nav-item">
                            <a href="<?= base_url('inicio')?>" class="nav-link">
                                <i class="fa fa-star"></i> Inicio
                            </a>
                        </li>

                        <li class="nav-item nav-dropdown">
                            <a href="#" class="nav-link nav-dropdown-toggle">
                                <i class="fa fa-users"></i> Usuarios <i class="fa fa-caret-left"></i>
                            </a>

                            <ul class="nav-dropdown-items">
                                <li class="nav-item">
                                    <a href="<?= base_url('usuarios')?>" class="nav-link">
                                        <i class="fa fa-users"></i> Ver todos los usuarios
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?= base_url('alumnos')?>" class="nav-link">
                                        <i class="fa fa-graduation-cap"></i> Ver alumnos
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?= base_url('profesores')?>" class="nav-link">
                                        <i class="fa fa-users"></i> Ver profesores
                                    </a>
                                </li>
                            



                            </ul>
                        </li>

                     

                        <li class="nav-item">
                            <a href="<?= base_url('asignaturas')?>" class="nav-link">
                                <i class="fa fa-book"></i> Materias
                            </a>
                        </li>



                        <li class="nav-item">
                            <a href="<?= base_url('licenciaturas')?>" class="nav-link">
                                <i class="fa fa-graduation-cap"></i> Licenciaturas
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="<?= base_url('grupos')?>" class="nav-link">
                                <i class="fa fa-users"></i> Grupos
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="<?= base_url('aulas')?>" class="nav-link">
                                <i class="fa fa-home"></i> Aulas
                            </a>
                        </li>


                        <li class="nav-item">
                            <a href="<?= base_url('convocatorias')?>" class="nav-link">
                                <i class="fa fa-archive"></i> Convocatorias
                            </a>
                        </li>



                        <li class="nav-title">Mas</li>

                        <li class="nav-item">
                            <a href="<?= base_url('calificaciones')?>" class="nav-link">
                                <i class="fa fa-check"></i> Asignar calificaciones
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="<?= base_url('pagos')?>" class="nav-link">
                                <b><span style="margin-right: 9%">&#36;</span></b> Pagos
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="<?= base_url('aulas')?>" class="nav-link">
                                <i class="fa fa-user-secret"></i> Recuperar constraseña
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>

            <div class="content">
                <div class="container-fluid">