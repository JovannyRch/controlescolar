<div class="row" id="app">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header text-black" style="background-color: rgba(0, 133, 62, 1); color:white   ">
                <h3>Editar usuario</h3>
            </div>
            <div class="card-body">
                <div>
                    <h3><b>Datos personales</b></h3>
                    <form v-on:submit.prevent="guardarDatosPer">
                        <div class="row">

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Nombre</label>
                                    <input type="text" class="form-control" v-model="usuario.nombre" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Apellido Paterno</label>
                                    <input type="text" class="form-control" v-model="usuario.apellido_paterno" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Apellido Materno</label>
                                    <input type="text" class="form-control" v-model="usuario.apellido_materno" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="bmd-label">Teléfono</label><br>
                                    <input type="text" v-model="usuario.telefono" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="bmd-label">Correo electrónico</label><br>
                                    <input type="email" v-model="usuario.email" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="bmd-label">Fecha de Registro</label><br>
                                    <input type="date" v-model="usuario.fecha_alta" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="bmd-label">Tipo de usuario</label><br>
                                    <select class="form-control" v-model="usuario.id_tipo_usuario" required>
                                        <option v-for="option in options" v-bind:value="option.value">
                                            {{ option.text }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4"></div>
                            <button type="submit" class="btn btn-success btn-rounded col-md-4" style="height: 10%; margin: auto auto;">Actualizar
                                cambios en datos personales</button>
                        </div>
                        <h3><b>Datos de Login</b></h3>
                        
                    </form>
                    <div class="row">
                           
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="bmd-label">Login</label><br>
                                    <input type="text" v-model="usuarioLogin.logins" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="bmd-label">Password</label><br>
                                    <input type="text" v-model="usuarioLogin.password" class="form-control"
                                        required>
                                </div>
                            </div>
                            <div class="col-md-8"></div>

                            <button @click="actualizarDatosLogin" type="submit" class="btn btn-success  btn-rounded col-md-4">Actualizar
                                cambios en login</button>
                        
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>

<script>
    var app = new Vue({
        el: "#app",
        data: {
            usuario: {},
            usuarioLogin: {},
            selected: "Seleccione tipo de usuario",
            options: [{
                    text: 'Alumno',
                    value: '4'
                },
                {
                    text: 'Maestro',
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
            ]
        },
        created: function () {
            this.get();
            this.getLoginData();
        },
        methods: {
            guardarDatosPer() {
                var url = "<?=base_url()?>index.php/usuarios_api/usuarios/<?=$id?>";
                var data = {
                    id_tipo_usuario: this.usuario.id_tipo_usuario,
                    nombre: this.usuario.nombre,
                    apellido_paterno: this.usuario.apellido_paterno,
                    apellido_materno: this.usuario.apellido_materno,
                    email: this.usuario.email,
                    telefono: this.usuario.telefono,
                    direccion: this.usuario.direccion,
                    localidad: this.usuario.localidad,
                    pais: this.usuario.pais,
                    cod_postal: this.usuario.cod_postal,
                    fecha_alta: this.usuario.fecha_alta,
                    fecha_nacimiento: this.usuario.fecha_nacimiento
                };
                axios.put(url, data).then(
                    response => {
                        alert("Actualizado con éxito");
                    }
                ).catch(
                    error => {
                        alert("Error al actualizar los datos");
                    }
                );
            },
            actualizarDatosLogin() {
                var url = "<?=base_url()?>index.php/api/usuario_acceso/usuario_acceso/" + this.usuarioLogin.id_usuario_acceso;
                var data = {
                    id_usuario: this.usuarioLogin.id_usuario,
                    login: this.usuarioLogin.logins,
                    password: this.usuarioLogin.password
                };
                axios.put(url, data).then(
                    response => {
                       alert("Se han actualizado los datos login con éxito");
                    }
                ).catch(
                    error => {
                        alert("Error al actualizar datos del login");
                    }
                );
            },
            get() {
                var url = "<?=base_url()?>index.php/usuarios_api/usuarios/<?=$id?>";
                axios.get(url).then(
                    response => {
                        this.usuario = response.data
                    }
                ).catch(
                    error => { //alert('Error');
                    }
                );
            },
            getLoginData() {
                var url = "<?=base_url()?>index.php/api/usuario_acceso/usuario_login/<?=$id?>";
                axios.get(url).then(
                    response => {
                        this.usuarioLogin = response.data;
                        console.log("->");
                        console.log(this.usuarioLogin.id_usuario_accesso);
                    }
                ).catch(
                    error => { //alert('Error');
                    }
                );
            },
            registrar() {
                this.usuario.nacimiento = GetFormattedDate(this.usuario.nacimiento);
                this.usuario.fechaRegistro = currentDate();
                this.post();
            },
            putLoginData() {
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
</script>