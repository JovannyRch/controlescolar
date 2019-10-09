<div class="row" id="app">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-success">
                <h4 class="card-title">Registrar Profesor</h4>
            </div>
            <div class="card-body">
                <form v-on:submit.prevent="registrar">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="bmd-label-floating">Nombre(s)</label>
                                <input type="text" v-model="usuario.nombre" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="bmd-label-floating">Apellido Paterno</label>
                                <input type="text" v-model="usuario.paterno" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="bmd-label-floating">Apellido Materno</label>
                                <input type="text" v-model="usuario.materno" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="bmd-label-floating">Teléfono</label>
                                <input type="text" v-model="usuario.telefono" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="bmd-label-floating">Correo electrónico</label>
                                <input type="email" v-model="usuario.email" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="bmd-label-floating">Código Postal</label>
                                <input type="text" v-model="usuario.codPostal" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="bmd-label-floating">Dirección</label>
                                <input type="text" v-model="usuario.direccion" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="bmd-label-floating">Localidad</label>
                                <input type="text" v-model="usuario.localidad" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="bmd-label-floating">País</label>
                                <input type="text" v-model="usuario.pais" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="bmd-label">Fecha de Nacimiento</label><br>
                                <input type="date" v-model="usuario.nacimiento" class="form-control">
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success pull-right">Registrar</button>
                    <div class="clearfix"></div>
                </form>
            </div>
        </div>
    </div>

    <script>
        var app = new Vue({
            el: "#app",
            data: {
                saludo: ":)",
                usuarios: [],
                buscador: "",
                usuario: {
                    tipo: 2,
                    nombre: '',
                    paterno: '',
                    materno: '',
                    telefono: '',
                    email: '',
                    codPostal: '',
                    direccion: '',
                    localidad: '',
                    pais: '',
                    nacimiento: '',
                    fechaRegistro: ''
                }
            },
            created: function () {},
            methods: {
                post() {
                    var url = "<?=base_url()?>" + "index.php/usuarios_api/usuarios";
                    var data = {
                        id_tipo_usuario: this.usuario.tipo,
                        nombre:  this.usuario.nombre,
                        apellido_paterno:  this.usuario.paterno,
                        apellido_materno: this.usuario.materno,
                        email: this.usuario.email,
                        telefono: parseInt(this.usuarios.telefono),
                        direccion: this.usuario.direccion,
                        localidad: this.usuario.localidad,
                        pais: this.usuario.pais,
                        fecha_alta: this.usuario.fechaRegistro,
                        fecha_nacimiento: this.usuario.nacimiento
                    };
                    axios.post(url, data).then(
                        response => {
                            alert("Exito");
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
                }
            },
            computed: {
                filtrar: function () {
                    if (this.buscador === '') {
                        return this.usuarios;
                    } else {
                        return this.usuarios.filter((usuario) => {
                            return (usuario.nombre.toString() + usuario.apellido_paterno.toString() +
                                usuario.apellido_materno
                                .toString() + usuario.telefono.toString()).toLowerCase().includes(
                                this.buscador
                                .toLowerCase());
                        });
                    }
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