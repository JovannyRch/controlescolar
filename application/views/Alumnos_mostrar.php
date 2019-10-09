<div class="row" id="app">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-success">
                <h4 class="card-title"> <span >{{usuario.apellido_paterno+" "+usuario.apellido_materno+" "+usuario.nombre}}</span></h4>
            </div> 
            <div class="card-body">
                <div >
                    <a href="#" @click="verDatos = !verDatos"><h3 > <i class="material-icons">add</i> Datos personales</h3></a>
                    <div v-if="verDatos">
                        <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="bmd-label">Teléfono</label><br>
                                <input type="text" v-model="usuario.telefono" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="bmd-label">Correo electrónico</label><br>
                                <input type="email" v-model="usuario.email" class="form-control" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="bmd-label">Código Postal</label><br>
                                <input type="text" v-model="usuario.cod_postal" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="bmd-label">Dirección</label><br>
                                <input type="text" v-model="usuario.direccion" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="bmd-label">Localidad</label><br>
                                <input type="text" v-model="usuario.localidad" class="form-control" readonly>
                            </div> 
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="bmd-label">País</label><br>
                                <input type="text" v-model="usuario.pais" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="bmd-label">Fecha de Nacimiento</label><br>
                                <input type="date" v-model="usuario.fecha_nacimiento" class="form-control" readonly>
                            </div>
                        </div>
                    </div>
                   
                    <div class="clearfix"></div>
                    </div>
                </div>
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
                },
                verDatos: false
            },
            created: function () {
                 this.get()
            },
            methods: {
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