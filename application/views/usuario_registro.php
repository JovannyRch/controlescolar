<div class="row" id="app">
    <div class="col-md-12">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-light">
                    Registro de usuario
                </div>
                <div class="card-body">

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="bmd-label">Tipo de usuario</label><br>
                            <select class="form-control" v-model="selected" required>
                                <option value="" selected disabled>Seleccione un tipo de usuario</option>
                                <option v-for="option in options" v-bind:value="option.value" selected>
                                    {{ option.text }}
                                </option>
                            </select>
                        </div>
                    </div>

                    <form v-on:submit.prevent="registrar" v-if="selected">



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

                        <div class="row" v-if="selected === '4'">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Matricula</label>
                                    <input type="text" v-model="alumno.matricula" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Licenciatura</label>
                                    <select class="form-control" v-model="alumno.id_licenciatura" required>
                                        <option value="" selected disabled>Seleccione licenciatura</option>
                                        <option v-for="l in licenciaturas" :value="l.id">
                                            {{ l.nombre }}
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Plantel</label>
                                    <select class="form-control" v-model="alumno.id_plantel" required>
                                        <option value="" selected disabled>Seleccione plantel</option>
                                        <option v-for="p in planteles" :value="p.id">
                                            {{ p.nombre }}
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Turno</label>
                                    <select class="form-control" v-model="alumno.turno" required>
                                        <option value="" selected disabled>Seleccione turno</option>
                                        <option value="matutino">
                                            Matutino
                                        </option>
                                        <option value="verpertino">
                                            Vespertino
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Periodo de ingreso</label>
                                    <select class="form-control" v-model="alumno.id_periodo_ingreso" required>
                                        <option value="" selected disabled>Seleccione periodo</option>
                                        <option v-for="c in convocatorias" :value="c.id_convocatoria" selected>
                                            {{ c.convocatoria }}
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Último periodo de inscripción</label>
                                    <select class="form-control" v-model="alumno.id_ultimo_periodo" required>
                                        <option value="" selected disabled>Seleccione periodo</option>
                                        <option v-for="c in convocatorias" :value="c.id_convocatoria" selected>
                                            {{ c.convocatoria }}
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Total de mensualidades</label>
                                    <input type="number" v-model="alumno.tot_mensualidades_x_pagar" class="form-control"
                                        required>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Costo por mes</label>
                                    <input type="number" v-model="alumno.costo_mensualidad" class="form-control"
                                        required>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Total a pagar</label>
                                    <input readonly type="number" :value="calCostoFinal" class="form-control" required>
                                </div>
                            </div>


                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Meses restantes por pagar</label>
                                    <input type="number" v-model="alumno.cant_mensualidades_x_pagar"
                                        class="form-control" required>
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
            selected: "",
            options: [{
                text: 'Alumno',
                value: '4'
            },
            {
                text: 'Profesor',
                value: '2'
            },
            {
                text: 'Administrador',
                value: '1'
            },

            ],
            licenciaturas: [],
            planteles: [],
            convocatorias: [],
            alumno: {
                id_licenciatura: '',
                matricula: '',
                id_plantel: '',
                id_ultimo_periodo: '',
                id_periodo_ingreso: '',
                status_pago: '',
                costo_mensualidad: 0,
                costo_final_periodo: 0,
                tot_mensualidades_x_pagar: 4,
                cant_mensualidades_x_pagar: 4,
                turno: ''
            },
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
            },

        },

        computed: {
            calCostoFinal() {
                return this.alumno.tot_mensualidades_x_pagar * this.alumno.costo_mensualidad;
            }
        },
        created: function () {
            this.getLicenciaturas();
            this.getPlanteles();
            this.getConvocatorias();
        },
        methods: {
            post(data) {

                var url = "<?=base_url()?>index.php/usuarios_api/usuarios";

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
                // FIXME MATRICULA UNICA
                let datos_usuario = {
                    id_tipo_usuario: this.usuario.tipo,
                    nombre: this.usuario.nombre,
                    apellido_paterno: this.usuario.paterno,
                    apellido_materno: this.usuario.materno,
                    email: this.usuario.email,
                    telefono: this.usuario.telefono,
                    direccion: this.usuario.direccion,
                    localidad: this.usuario.localidad,
                    pais: this.usuario.pais,
                    fecha_alta: this.usuario.fechaRegistro,
                    fecha_nacimiento: this.usuario.nacimiento
                };

                if (this.selected !== "4") {
                    this.post(datos_usuario);
                }

                else {
                    this.alumno.costo_final_periodo = this.alumno.tot_mensualidades_x_pagar * this.alumno.costo_mensualidad;
                    this.registarAlumno(datos_usuario);
                }

            },
            registarAlumno(datos_usuario) {
                //jovannyrch@gmail.com
                let datos_alumno = Object.assign({}, this.alumno);
                axios.post('<?=base_url()?>/api/usuarios_api/registarAlumno', { datos_usuario, datos_alumno }).then(response => {
                    alert("Alumno registrado");
                    var login = this.generarLogin();
                    this.postLogin(response.data, login, login);
                }).catch(e => {
                    alert("Ocurrió un error en el registro del alumno")
                })

            }
            ,
            generarLogin() {
                var resultado = (currentYear() + "").slice(2, 4) + this.usuario.tipo +
                    this.usuario.nombre.slice(0, 2).toUpperCase() + this
                        .usuario.paterno.slice(0, 2).toUpperCase() + this.usuario.materno.slice(0, 2).toUpperCase();
                resultado.replace("Ñ", "N");
                resultado.replace("Á", "N");
                resultado.replace("É", "N");
                resultado.replace("Í", "N");
                resultado.replace("Ó", "N");
                resultado.replace("Ú", "N");
                resultado.replace("Ä", "N");
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
                        window.location.href = "<?= site_url('usuarios/ver')?>/" + id_usuario;
                    }).catch(error => {
                        console.log("Error en post de login");
                    });
            },

            getLicenciaturas() {
                axios.get('<?=base_url()?>/api/licenciaturas/licenciaturas').then(response => {
                    this.licenciaturas = response.data;

                }).catch(e => {
                    console.log(e);
                })
            },
            getPlanteles() {
                axios.get('<?=base_url()?>/api/planteles/planteles').then(response => {
                    this.planteles = response.data;
                }).catch(e => {
                    console.log(e);
                })
            },
            getConvocatorias() {
                axios.get('<?=base_url()?>/api/convocatorias/convocatorias').then(response => {
                    this.convocatorias = response.data;
                }).catch(e => {
                    console.log(e);
                })
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