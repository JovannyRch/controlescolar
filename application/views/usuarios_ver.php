<div class="row" id="app">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header text-black" style="background-color: rgb(75, 22, 33,.3)">
                <h4> <span v-text="getTipo(usuario.id_tipo_usuario)"></span> </h4>
                
                <h4 class="card-title"><span>{{usuario.apellido_paterno+" "+usuario.apellido_materno+" "+usuario.nombre}}</span>
                </h4>
                
            </div>
            <div class="card-body">
                <a v-if="usuario.id_tipo_usuario == '4'" class="btn btn-success btn-rounded"
                    href="<?= base_url()?>inscripciones/alumno/<?=$id?>"
                >
                    Inscribir a la convocatoria actual
                </a>
                <br><br>
                <div v-if="tipo_usuario == '4'">
                       Alumno
                </div>
                <div>
                    <a  @click="verDatosLogin = !verDatosLogin">
                        <i class="fa fa-plus" v-if="!verDatosLogin"></i> <i v-else class="fa fa-minus"></i> <span class="text-info">
                            Datos login</span>
                    </a><br><br>
                    <div v-if="verDatosLogin">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="bmd-label">Login</label><br>
                                    <span style="font-size: 150%" v-text="usuarioLogin.logins"></span>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label class="bmd-label">Contraseña</label><br>
                                    <span style="font-size: 150%" v-text="usuarioLogin.password"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a href="#" @click="verDatos = !verDatos">
                        <i class="fa fa-plus" v-if="!verDatos"></i> <i v-else class="fa fa-minus"></i> <span class="text-info">
                            Datos personales</span>
                    </a><br><br>
                    <div v-if="verDatos">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="bmd-label">Teléfono</label><br>
                                    <span style="font-size: 150%" v-text="usuario.telefono"></span>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label class="bmd-label">Correo electrónico</label><br>
                                    <span style="font-size: 150%" v-text="usuario.email"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="bmd-label">Código Postal</label><br>
                                    <span style="font-size: 150%" v-text="usuario.cod_postal"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="bmd-label">Dirección</label><br>
                                    <span style="font-size: 150%" v-text="usuario.direccion"></span>

                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="bmd-label">Localidad</label><br>
                                    <span style="font-size: 150%" v-text="usuario.localidad"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="bmd-label">País</label><br>
                                    <span style="font-size: 150%" v-text="usuario.pais"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="bmd-label">Fecha de Nacimiento</label><br>
                                    <span style="font-size: 150%" v-text="usuario.fecha_nacimiento"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="bmd-label">Fecha de Registro</label><br>
                                    <span style="font-size: 150%" v-text="usuario.fecha_alta"></span>
                                </div>
                            </div>
                        </div>

                        <div class="clearfix"></div>
                    </div>
                </div>
                <a href="<?= base_url()?>usuarios/editar/<?=$id?>" class="btn btn-primary btn-rounded">
                    Editar Datos
                </a>
            </div>
        </div>
    </div>
</div>

<script>

    let id_tipo_usuario = '<?=$id_tipo_usuario?>';

    var app = new Vue({
        el: "#app",
        data: {
            usuario: {},
            verDatos: true,
            verDatosLogin: true,
            usuarioLogin: {},
            tipo_usuario: id_tipo_usuario
        },
        created: function () {
            this.get();
            this.getLoginData();
        },
        methods: {
            getTipo(tipo) {
                if (tipo === "1") return "ADMINISTRADOR";
                if (tipo === "2") return "PROFESOR";
                if (tipo === "3") return "PADRE";
                if (tipo === "4") return "ALUMNO";
            },
            get() {
                var url = "<?=base_url()?>" + "index.php/usuarios_api/usuarios/<?=$id?>";

                axios.get(url).then(
                    response => {
                        this.usuario = response.data;
                    }
                ).catch(
                    error => {
                        //alert('Error');
                    }
                );
            },
            registrar() {
                this.usuario.nacimiento = GetFormattedDate(this.usuario.nacimiento);
                this.usuario.fechaRegistro = currentDate();
                this.post();
            },
            getLoginData() {
                var url = "<?=base_url()?>index.php/api/usuario_acceso/usuario_login/<?=$id?>";
                axios.get(url).then(
                    response => {
                        this.usuarioLogin = response.data
                    }
                ).catch(
                    error => { //alert('Error');
                    }
                );
            }
        }
    });
</script>