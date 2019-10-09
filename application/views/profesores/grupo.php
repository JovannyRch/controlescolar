<div id="app" class="card">
    <div class="card-head p-3">
        <div class="row">

            <div class="col-md-6"><b>Asignatura: </b>
                <h5>{{datos.asignatura}}</h5>
            </div>
            <div class="col-md-6"> <b>Curso: </b>
                <h5>{{datos.curso}}</h5>
            </div>
            <div class="col-md-6"><b>Grupo:</b>
                <h5> {{datos.grupo}}</h5>
            </div>
            <div class="col-md-6"><b>Convocatoria: </b>
                <h5>{{datos.convocatoria}}</h5>
            </div>
            <div class="col-md-6"><b>Total de alumnos: </b>
                <h5>{{datos.alumnos.length}}</h5>
            </div>
        </div>
    </div>
    <div class="card-body" v-if=" pagina === 'inicio'">

        <div class="row p-3">
            <button class="btn btn-success btn-rounded" data-toggle="modal" data-target="#modalEvaluacion" v-if="datos.evaluacionesDisponibles.length <= 3">
                <i class="fa fa-check"></i>
                Calificar
            </button>
            <button class="btn btn-success btn-rounded" style="margin-left: 2%" @click="pagina ='verCalificaciones'">
                Ver calificaciones
            </button>
            <button class="btn btn-primary btn-rounded" style="margin-left: 2%" data-toggle="modal" data-target="#modal-nuevo-mensaje">
                <i class="fa fa-envelope"></i>
                Enviar mensaje a todos
            </button>
        </div>

        <div v-if="datos.alumnos.length != 0">

            <table class="table table-bordered">
                <thead>
                    <th style="width: 2%;">#</th>
                    <th style="width: 85%">Alumno</th>
                    <th>Opciones</th>
                </thead>
                <tbody>
                    <tr v-for="(a,index) in datos.alumnos">
                        <td style="width: 2%;">{{index+1}}</td>
                        <td>{{a.nombre}}</td>
                        <td>
                            <button data-toggle="modal" data-target="#modal-nuevo-mensaje2" class="btn btn-primary btn-rounded"
                                @click="mensajePersonalF(a)">
                                <i class="fa fa-envelope"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div v-if="pagina === 'calificar'">
        <div class="col-12 col-md-6 p-3">

            <div class="p-3">
                <button class="btn btn-info btn-rounded " @click="pagina = 'inicio'">
                    <i class="fa fa-arrow-left "></i> Regresar
                </button>
                <span class="p-2">Evaluación:</span> <b>{{evaluacion.nombre}}</b>
            </div>
            <table class="table table-bordered table-hover">
                <thead>
                    <th style="width: 85%">Alumno</th>
                    <th>Calificación</th>
                </thead>
                <tbody>
                    <tr v-for="a in datos.alumnos">
                        <td>{{a.nombre}}</td>
                        <td>
                            <input type="number" min="0" max="10" v-model="a.evaluaciones[evaluacion.id_evaluacion].calificacion">
                        </td>
                    </tr>
                </tbody>
            </table>
            <button v-if="captcha.resultado == captcha.entradaUsuario" class="btn btn-success" @click="guardarCalificaciones">
                Guardar calificaciones
            </button>
            <div v-else>
                Demuestra que no eres un robot. <br>
                Resuelve la siguiente suma
                <b>{{captcha.n1}}</b> + <b>{{captcha.n2}}</b> =
                <input type="number" v-model="captcha.entradaUsuario" class="form-control col-md-5">
            </div>
        </div>
    </div>

    <div v-if="pagina === 'verCalificaciones'">
        <div class="col-12 col-md-12 p-3">
            <div class="p-3">
                <button class="btn btn-info btn-rounded" @click="pagina = 'inicio'">
                    <i class="fa fa-arrow-left "></i> Regresar
                </button>
            </div>
            <table class="table table-bordered table-hover">
                <thead>
                    <th>
                        #
                    </th>
                    <th style="width: 20%">Alumno</th>
                    <th style="width: 10%" v-for="(e, index) in datos.evaluacionesDisponibles">{{e.nombre}}</th>
                </thead>
                <tbody>
                    <tr v-for="(a,index) in datos.alumnos">
                        <td style="width: 2%">{{index +1 }}</td>
                        <td style="width: 10%">{{a.nombre}}</td>
                        <td style="width: 10%" v-if="a.evaluaciones[e.id_evaluacion].calificacion" v-for="e in datos.evaluacionesDisponibles"
                            :style="colorCalificacion(a.evaluaciones[e.id_evaluacion].calificacion)">
                            {{a.evaluaciones[e.id_evaluacion].calificacion}}
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="width: 12%">
                            <b>Promedio</b>
                        </td>
                        <td style="width: 10%" v-for="e in datos.evaluacionesDisponibles" :style="colorCalificacion(e.promedio)"
                            v-if="e.promedio">
                            <b>{{e.promedio}}</b>
                        </td>
                    </tr>
                </tbody>
            </table>


        </div>

    </div>

    <!-- Modal  -->
    <div class="modal fade" id="modalEvaluacion" tabindex="-1" role="dialog" aria-labelledby="modalEvaluacion"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEvaluacion">Seleccione evaluación</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-hover">
                        <tbody>
                            <tr v-for="e in datos.evaluacionesDisponibles">
                                <th>{{e.nombre}}</th>
                                <td>
                                    <button class="btn btn-success btn-rounded" data-dismiss="modal" @click="seleccionEvaluacion(e)">
                                        <i class="fa fa-check"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalCalificacion" tabindex="-1" role="dialog" aria-labelledby="modalCalificacion"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCalificacion">Calificar</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-nuevo-mensaje" tabindex="-1" role="dialog" aria-labelledby="Nuevo Mensaje"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header text-white">
                    <h5 class="modal-title">Mensaje para todos</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label>Asunto</label>
                        <input type="text" v-model="mensaje.asunto" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label class="bmd-label">Mensaje</label>
                        <textarea name="" id="" cols="30" rows="5" class="form-control" v-model="mensaje.texto"></textarea>
                    </div>

                    <div class="form-group">
                        <label>Prioridad: </label>
                        <select class="form-control" v-model="mensaje.id_prioridad">
                            <option v-for="p in prioridades" :value="p.id_prioridad">{{p.nombre}}</option>
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary btn-rounded" data-dismiss="modal">Cancelar</button>
                    <button type="reset" @click="post()" class="btn btn-success btn-rounded" data-dismiss="modal">Enviar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-nuevo-mensaje2" tabindex="-1" role="dialog" aria-labelledby="Nuevo Mensaje"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header text-white">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <div class="form-group">
                        <label>Destinatario</label>
                        <input type="text" v-model="destinatario.nombre" class="form-control" required readonly>
                    </div>

                    <div class="form-group">
                        <label>Asunto</label>
                        <input type="text" v-model="mensaje.asunto" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label class="bmd-label">Mensaje</label>
                        <textarea name="" id="" cols="30" rows="5" class="form-control" v-model="mensaje.texto"></textarea>
                    </div>

                    <div class="form-group">
                        <label>Prioridad: </label>
                        <select class="form-control" v-model="mensaje.id_prioridad">
                            <option v-for="p in prioridades" :value="p.id_prioridad">{{p.nombre}}</option>
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary btn-rounded" data-dismiss="modal">Cancelar</button>
                    <button type="reset" @click="post2()" class="btn btn-success btn-rounded" data-dismiss="modal">Enviar</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    let app = new Vue({
        el: '#app',
        data: {
            datos: {
                alumnos: []
            },
            id_profesor: '<?=$id_profesor?>',
            id_grupo: '<?=$id_grupo?>',
            id_asignatura: '<?=$id_asignatura?>',
            evaluacion: {},
            pagina: 'inicio',
            mensaje: {
                id_mensaje: '',
                id_destinatario: '',
                id_remitente: "<?=$this->session->userdata('id_usuario');?>",
                asunto: '',
                texto: '',
                fecha_hora: '',
                id_prioridad: '',
                leido: false
            },
            destinatario: {
                nombre: '',
                id_usuario: ''
            },
            mensajePersonal: false,
            captcha: {
                n1: 0,
                n2: 0,
                resultado: 0,
                entradaUsuario: 0
            },
            prioridades: []
        },
        created: function () {
            this.getData();
            this.getPrioridades();
            this.captcha.n1 = parseInt(Math.floor((Math.random() * 10) + 1));
            this.captcha.n2 = parseInt(Math.floor((Math.random() * 10) + 1));
            this.captcha.resultado = this.captcha.n1 + this.captcha.n2;
        },
        methods: {
            getData() {
                let url =
                    "<?=base_url()?>api/asignatura/alumnos/<?=$id_grupo?>/<?= $id_asignatura?>/<?=$id_profesor?>";
                axios.get(url).then(
                    response => {
                        this.datos = response.data
                    }
                ).catch(
                    error => {
                        alert("error");
                    }
                );
            },
            seleccionEvaluacion(evaluacion) {
                this.evaluacion = Object.assign({}, evaluacion);
                this.pagina = 'calificar';
            },
            getPrioridades() {
                var url = "<?=base_url()?>" + "index.php/api/prioridad/prioridad";
                axios.get(url).then(
                    response => {
                        this.prioridades = response.data;
                    }
                ).catch(
                    error => {
                        alert('Error get usuarios');
                    }
                );
            },
            mensajePersonalF(destinatario) {
                this.destinatario = Object.assign({}, destinatario);
                this.resetMensaje();
                this.mensajePersonal = true;
            },
            resetMensaje() {
                this.mensajePersonal = false;
                this.mensaje = {
                    id_destinatario: '',
                    id_remitente: "<?=$this->session->userdata('id_usuario');?>",
                    asunto: '',
                    texto: '',
                    fecha_hora: '',
                    id_prioridad: '',
                    leido: false
                }
            },
            quitarUltimaEvaluacion(evaluaciones) {
                let resultado = [];
                for (let i = 0; i++; i < evaluaciones.length - 1) {
                    resultado[i] = evaluaciones[i];
                }
                return resultado;
            },
            guardarCalificaciones() {

                let datos = {
                    id_asignatura: this.id_asignatura,
                    id_convocatoria: this.datos.id_convocatoria,
                    id_grupo: this.id_grupo,
                    id_profesor: this.id_profesor,
                    id_evaluacion: this.evaluacion.id_evaluacion,
                    id_curso: this.datos.id_curso,
                    alumnos: this.datos.alumnos
                }
                let url =
                    "<?=base_url()?>api/calificaciones/post";
                axios.post(url, datos).then(
                    response => {
                        this.pagina = "verCalificaciones"
                        this.getData();
                        this.captcha.n1 = parseInt(Math.floor((Math.random() * 10) + 1));
                        this.captcha.n2 = parseInt(Math.floor((Math.random() * 10) + 1));
                        this.captcha.resultado = this.captcha.n1 + this.captcha.n2;
                        this.captcha.entradaUsuario = 0;
                    }
                ).catch(
                    error => {
                        alert("error");
                    }
                );

            },
            validarCalificaciones() {
                bandera = false;
                for (var i in this.datos.alumnos) {
                    let calificacion = this.datos.alumnos[this.evaluacion.id_evaluacion];
                    if (calificacion) {
                        console.log(calificacion);
                    } else {
                        console.log("No existe");
                        console.log(calificacion);
                    }
                }
            },
            colorCalificacion(calificacion) {
                let propiedad = "background-color: "
                let c = parseFloat(calificacion);
                if (c >= 9.0 && c <= 10.0) return propiedad + 'rgb(169, 235, 160)';
                if (c <= 8.9 && c >= 7.0) return propiedad + 'rgb(186, 226, 238)';
                if (c >= 6.0 && c <= 6.9) return propiedad + 'rgb(238, 226, 123)';
                if (c < 6.0) return propiedad + 'rgb(247, 175, 157)';
            },
            post() {
                var url = "<?=base_url()?>index.php/api/mensajes/destinatarios";
                var data = {
                    id_remitente: this.mensaje.id_remitente,
                    destinatarios: this.datos.alumnos,
                    asunto: this.mensaje.asunto,
                    texto: this.mensaje.texto,
                    fecha_hora: currentDate(),
                    id_prioridad: this.mensaje.id_prioridad,
                    leido: false
                };
                axios.post(url, data)
                    .then(response => {
                        alert("Mensaje enviado correctamente");
                    }).catch(error => {
                        alert("Error al enviar mensaje");
                    });
            },
            post2() {
                var url = "<?=base_url()?>index.php/api/mensajes/destinatarios";
                var data = {
                    id_remitente: this.mensaje.id_remitente,
                    destinatarios: [this.destinatario],
                    asunto: this.mensaje.asunto,
                    texto: this.mensaje.texto,
                    fecha_hora: currentDate(),
                    id_prioridad: this.mensaje.id_prioridad,
                    leido: false
                };
                axios.post(url, data)
                    .then(response => {
                        alert("Mensaje enviado correctamente");
                    }).catch(error => {
                        alert("Error al enviar mensaje");
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
        //'2018-12-10 20:20',
        var todayTime = new Date();
        var month = todayTime.getMonth() + 1;
        var day = todayTime.getDate();
        var year = todayTime.getFullYear();
        var hours = todayTime.getHours();
        var minutes = todayTime.getMinutes();
        var seconds = todayTime.getSeconds();
        return year + "-" + month + "-" + day + " " + hours + ":" + minutes + ':' + seconds;
    }
</script>