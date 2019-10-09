<div id="app">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-success">
                <center>
                    <h2 class="card-title">
                        <th>Mensajes</th>
                    </h2>
                </center>
            </div>
            <div class="card-body">
                <button @click="resetModal" class="btn btn-primary" data-toggle="modal" data-target="#modal-nuevo-mensaje">
                    <i class="fa fa-envelope"></i> Nuevo Mensaje
                </button>
                <br> <br>
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#home3" role="tab" aria-controls="home"
                            aria-expanded="true"><i class="fa fa-arrow-down"></i> Bandeja de entrada</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#profile3" role="tab" aria-controls="profile"
                            aria-expanded="false"><i class="fa fa-arrow-up"></i> Mensajes enviados</a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane active" id="home3" role="tabpanel" aria-expanded="true">
                        <table class="table table-striped">
                            <thead>
                                <th>Prioridad</th>
                                <th>Asunto</th>
                                <th>Remitente</th>
                                <th>Fecha</th>
                                <th>Leer</th>
                            </thead>
                            <tbody>
                                <tr v-for="m in mensajesEntrada" :style="getStyle(m.leido)">
                                    <td>
                                        <span class="fa fa-circle" :class="getStylePriodidad(m.id_prioridad)"> </span>
                                    </td>
                                    <td>{{m.asunto}}</td>
                                    <td v-text="getUsuario(m.id_remitente)"></td>
                                    <td>{{m.fecha_hora}}</td>


                                    <td>
                                        <button class="btn btn-outline-primary btn-rounded" @click="verMensaje(m,true)" class="btn btn-primary"
                                            data-toggle="modal" data-target="#modal-ver-mensaje">
                                            Leer
                                        </button>
                                        
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="tab-pane" id="profile3" role="tabpanel" aria-expanded="false">
                        <table class="table table-striped">
                            <thead>
                                <th>Prioridad</th>
                                <th>Asunto</th>
                                <th>Destinatario</th>
                                <th>Fecha</th>
                                <th>Leer</th>
                                <th>Leido</th>
                            </thead>
                            <tbody>
                                <tr v-for="m in mensajesSalida">
                                    <td>
                                        <span class="fa fa-circle" :class="getStylePriodidad(m.id_prioridad)"> </span>
                                    </td>
                                    <td>{{m.asunto}}</td>
                                    <td v-text="getUsuario(m.id_destinatario)"></td>
                                    <td>{{m.fecha_hora}}</td>

                                    <td>
                                        <button class="btn btn-info btn-rounded" @click="verMensaje(m,false)" class="btn btn-primary"
                                            data-toggle="modal" data-target="#modal-ver-mensaje">
                                            Leer
                                        </button>
                                    </td>
                                    <td>
                                        <button v-if="m.leido == 0" class="btn btn-danger btn-rounded">
                                            <i class="fa fa-eye-slash"></i>
                                        </button>
                                        <button v-else class="btn btn-success btn-rounded">
                                            <i class="fa fa-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="tab-pane" id="messages3" role="tabpanel">

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-nuevo-mensaje" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header text-white">
                    <h5 class="modal-title">{{tituloForm}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label>De: </label>
                        <span type="text" v-text="getUsuario(mensaje.id_remitente)" class="form-control">
                        </span>
                    </div>
                    <div class="form-group">
                        <label>Para: </label>
                        <select class="form-control" v-model="mensaje.id_destinatario">
                            <option v-for="a in usuarios" :value="a.id_usuario">{{formatName(a)}}</option>
                        </select>
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
                    <button class="btn btn-primary btn-rounded" @click="ocultarForm" data-dismiss="modal">Cancelar</button>
                    <button type="reset" @click="post(mensaje.id_remitente, mensaje.id_destinatario, mensaje.asunto, mensaje.texto, mensaje.fecha_hora, mensaje.id_prioridad, mensaje.leido)" class="btn btn-success btn-rounded" data-dismiss="modal">Enviar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-ver-mensaje" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title" >Asunto: {{mensaje.asunto}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>De: </label>
                        <span type="text" v-text="getUsuario(mensaje.id_remitente)" class="form-control">
                        </span>
                    </div>

                    <div class="form-group">
                        <label>Para: </label>
                        <span type="text" v-text="getUsuario(mensaje.id_destinatario)" class="form-control">
                        </span>
                    </div>

                    <div class="form-group">
                        <label class="bmd-label">Mensaje</label>
                        <p class="form-control" v-text="mensaje.texto"></p>
                    </div>

                    <div class="form-group">
                        <label>Prioridad: </label>
                        <select class="form-control" v-model="mensaje.id_prioridad" disabled>
                            <option v-for="p in prioridades" :value="p.id_prioridad">{{p.nombre}}</option>
                        </select>
                    </div>

                </div>

                <div class="modal-footer" >
                    <button class="btn btn-primary" @click="ocultarForm" @click="ocultarForm" data-dismiss="modal">Regresar</button>
                    <button v-if="modalMensajeVer.responder" type="reset" class="btn btn-success" data-dismiss="modal"
                        data-toggle="modal" data-target="#modal-nuevo-mensaje" @click="responderFunction">Responder</button>
                </div>
            </div>
        </div>
    </div>

    

</div>


<script>
    var app = new Vue({
        el: "#app",
        data: {
            idUsuario: parseInt("<?=$this->session->userdata('id_usuario');?>"),
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
            page: 'bandeja',
            mainPage: 'index',
            mensajesEntrada: [],
            mensajesSalida: [],
            usuarios: [],
            prioridades: [],
            tituloForm: 'Nuevo mensaje',
            baseURL: "<?= site_url('padres/ver')?>/",
            classTable: 'col-md-12',
            classForm: '',
            modalMensajeVer: {
                responder: false
            }
        },
        created: function () {
            this.getEntrada();
            this.getSalida();
            this.getUsuarios();
            this.getPrioridades();
        },
        methods: {
            responderFunction() {
                this.mensaje.asunto = "RE: " + this.mensaje.asunto;
                var temp = this.mensaje.id_remitente;        
                this.mensaje.id_remitente = "<?=$this->session->userdata('id_usuario');?>";
                this.mensaje.id_destinatario = temp;
                this.mensaje.texto = "";
                this.mensaje.id_prioridad = "";
        
            },
            resetModal() {
                this.mensaje = {
                    id_mensaje: '',
                    id_destinatario: '',
                    id_remitente: "<?=$this->session->userdata('id_usuario');?>",
                    asunto: '',
                    texto: '',
                    fecha_hora: '',
                    id_prioridad: '',
                    leido: false
                };
            },
            getStyle(leido) {
                if (parseInt(leido) == 0) return "background-color: rgb(218, 105, 101,0.3);";
                else return "";
            },
            getStylePriodidad(prioridad) {
                prioridad = parseInt(prioridad);
                if (prioridad == 1) return "text-dark";
                if (prioridad == 2) return "text-primary";
                if (prioridad == 3) return "text-warning";
                if (prioridad == 4) return "text-danger";
            },
            verMensaje(m, bandera) {
                this.modalMensajeVer.responder = bandera;
                this.resetModal();
                this.mensaje = Object.assign({}, m);
                if (this.mensaje.leido == 0 && this.mensaje.id_destinatario == this.idUsuario) {
                    this.putMensajeLeido(this.mensaje.id_mensaje);
                }
            },
            formatName(a) {
                return a.apellido_paterno + " " + a.apellido_materno + ", " + a.nombre;
            },
            getData() {
                this.getEntrada();
                this.getSalida();
            },
            getValue(item, key, array, values) {
                for (let i in array) {
                    if (array[i][key] === item) {
                        resultado = '';
                        for (let j in values) resultado += array[i][values[j]] + " ";
                        return resultado;
                    }
                }
                return "";
            },
            getUsuario(id) {
                for (let i in this.usuarios) {
                    if (this.usuarios[i].id_usuario === id) {
                        return this.formatName(this.usuarios[i]);
                    }
                }
                return "";
            },
            ocultarForm() {
                this.classTable = "col-md-12";
                this.classForm = "";
                this.mainPage = 'index';
            },
            activarForm() {
                this.mensaje = {
                    id_mensaje: '',
                    id_destinatario: '',
                    id_remitente: "<?=$this->session->userdata('id_usuario');?>",
                    asunto: '',
                    texto: '',
                    fecha_hora: '',
                    id_prioridad: '',
                    leido: false
                };
                this.classTable = "col-md-12";
                this.classForm = "col-md-12";
                this.mainPage = 'form';
            },
            getEntrada() {
                var url =
                    "<?=base_url()?>index.php/api/mensajes/mensajes_entrada/<?=$this->session->userdata('id_usuario');?>";
                axios.get(url).then(
                    response => {
                        this.mensajesEntrada = response.data;
                    }
                ).catch(
                    error => {
                        this.mensajesEntrada = [];
                    }
                );
            },
            getSalida() {
                var url =
                    "<?=base_url()?>index.php/api/mensajes/mensajes_salida/<?=$this->session->userdata('id_usuario');?>";
                axios.get(url).then(
                    response => {
                        this.mensajesSalida = response.data;
                    }
                ).catch(
                    error => {
                        this.mensajesSalida = [];
                    }
                );
            },
            post(id_remitente, id_destinatario, asunto, texto, fecha_hora, id_prioridad, leido) {
                var url = "<?=base_url()?>index.php/api/mensajes/mensajes";
                var data = {
                    id_remitente: id_remitente,
                    id_destinatario: id_destinatario,
                    asunto: asunto,
                    texto: texto,
                    fecha_hora: currentDate(),
                    id_prioridad: id_prioridad,
                    leido: false
                };
                axios.post(url, data)
                    .then(response => {
                        this.getData();
                        this.ocultarForm();
                        sistema.getMensajesSinLeer();
                    }).catch(error => {
                        console.log("Error en post de Aula");
                    });
            },
            putMensajeLeido(id_mensaje) {
                var url = "<?=base_url()?>index.php/api/mensajes/mensajeLeido/" + id_mensaje;

                axios.put(url, {})
                    .then(response => {
                        this.getData();
                    }).catch(error => {
                        console.log("Error al actualizar mensaje");
                    });
            },
            eliminar(id) {
                var url = "<?=base_url()?>index.php/api/mensajes/mensajes/" + id;
                axios.delete(url)
                    .then(response => {
                        this.getData();
                    }).catch(error => {
                        console.log("error en delete");
                    });
            },
            getUsuarios() {
                var url = "<?=base_url()?>index.php/usuarios_api/usuarios";
                axios.get(url).then(
                    response => {
                        this.usuarios = response.data;
                    }
                ).catch(
                    error => {
                        alert('Error get usuarios');
                    }
                );
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