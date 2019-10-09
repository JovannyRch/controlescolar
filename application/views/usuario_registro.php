<div class="row" id="app">
    <div class="col-md-12">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-light">
                    Registro de usuario
                </div>
                <div class="card-body">
                    <form v-on:submit.prevent="registrar">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Nombre(s)</label>
                                    <input type="text" v-model="usuario.nombre" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Apellido Paterno</label>
                                    <input type="text" v-model="usuario.paterno" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Apellido Materno</label>
                                    <input type="text" v-model="usuario.materno" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="bmd-label">Tipo de usuario</label><br>
                                    <select class="form-control" v-model="selected" required >
                                        <option v-for="option in options" v-bind:value="option.value" selected> 
                                            {{ option.text }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Teléfono</label>
                                    <input type="number" v-model="usuario.telefono" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Correo electrónico</label>
                                    <input type="email" v-model="usuario.email" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Código Postal</label>
                                    <input type="number" v-model="usuario.codPostal" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Dirección</label>
                                    <input type="text" v-model="usuario.direccion" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Localidad</label>
                                    <input type="text" v-model="usuario.localidad" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="bmd-label-floating">País</label>
                                    <input type="text" v-model="usuario.pais" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="bmd-label">Fecha de Nacimiento</label><br>
                                    <input type="date" v-model="usuario.nacimiento" class="form-control" required>
                                </div>
                            </div>
                            
                        </div>
                        <center>
                            <button type="submit" class="btn btn-success ">Registrar</button>
                        </center>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var app = new Vue({
        el: "#app",
        data: {
            selected: "Seleccione tipo de usuario",
            options: [{
                    text: 'Alumno',
                    value: '4'
                },
                {
                    text: 'Profesor',
                    value: '2'
                },
                {
                    text: 'Padre',
                    value: '3'
                },
                {
                    text: 'Administrador',
                    value: '1'
                }
            ],
            usuario: {
                tipo: 1,
                nombre: '',
                paterno: '',
                materno: '',
                telefono: '7121234567',
                email: 'correo@ejemplo.com',
                codPostal: '5012341',
                direccion: 'direccion ejemplo',
                localidad: 'localidad ejemplo',
                pais: 'México',
                nacimiento: '2000-01-01',
                fechaRegistro: ""
            }
        },
        methods: {
            post() {
                var url = "<?=base_url()?>index.php/usuarios_api/usuarios";
                var data = {
                    id_tipo_usuario: this.usuario.tipo,
                    nombre: this.usuario.nombre,
                    apellido_paterno: this.usuario.paterno,
                    apellido_materno: this.usuario.materno,
                    email: this.usuario.email,
                    telefono: this.usuario.telefono,
                    direccion: this.usuario.direccion,
                    localidad: this.usuario.localidad,
                    cod_postal: this.usuario.codPostal,
                    pais: this.usuario.pais,
                    fecha_alta: this.usuario.fechaRegistro,
                    fecha_nacimiento: this.usuario.nacimiento
                };
                axios.post(url, data).then(
                    response => {
                        var login = this.generarLogin();
                        this.postLogin(response.data, login, login);
                    }
                ).catch(
                    error => {
                        alert('Error');
                    }
                );
                
            },
            registrar() {
                this.usuario.nacimiento = GetFormattedDate(this.usuario.nacimiento);
                this.usuario.fechaRegistro = currentDate();
                this.usuario.tipo = this.selected;
                this.post();
                
            },
            generarLogin() {
                var resultado =  (currentYear()+"").slice(2,4)+this.usuario.tipo+ 
                    this.usuario.nombre.slice(0, 2).toUpperCase() + this
                    .usuario.paterno.slice(0, 2).toUpperCase() + this.usuario.materno.slice(0, 2).toUpperCase();
                    resultado.replace("Ñ","N");
                    resultado.replace("Á","N");
                    resultado.replace("É","N");
                    resultado.replace("Í","N");
                    resultado.replace("Ó","N");
                    resultado.replace("Ú","N");
                    resultado.replace("Ä","N");
                    return resultado;
            },
            postLogin(id_usuario, login, password) {
                var url = "<?=base_url()?>index.php/api/usuario_acceso/usuario_acceso";
                var data = {
                    id_usuario: id_usuario,
                    login: login,
                    password: password
                };
                axios.post(url, data)
                    .then(response => {
                        console.log("Éxito en post de login");
                        window.location.href="<?= site_url('usuarios/ver')?>/"+id_usuario;
                    }).catch(error => {
                        console.log("Error en post de login");
                    });
            }
        }
    });

    function GetFormattedDate(date) {
        date = date.split('-');
        var month = date[1];

        var day = date[2];

        var year = date[0];

        return year + "-" + month + "-" + day;

    }

    function currentDate() {
        var todayTime = new Date();
        var month = todayTime.getMonth() + 1;
        var day = todayTime.getDate();
        var year = todayTime.getFullYear();
        return year + "-" + month + "-" + day;
    }

    function currentYear() {
        var todayTime = new Date();
        var year = todayTime.getFullYear();
        return year;
    }
</script>