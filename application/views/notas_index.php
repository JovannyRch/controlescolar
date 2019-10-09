<div id="app">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-success">
                <center>
                    <h2 class="card-title"><b>Gestión de calificaciones</b></h2>
                </center>
            </div>
            <div class="card-body">
                <form v-on:submit.prevent="saveData">
                    <div class="row">
                        <div v-if="classForm" :class="classForm">
                            <div>
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title "><b>{{tituloForm}}</b> </h4>
                                        <div class="form-group">
                                            <label>Convocatoria</label>
                                            <input type="text" class="form-control" :value="convocatoriaActual.convocatoria"
                                                readonly>
                                        </div>

                                        <div class="form-group">
                                            <label>Seleccione curso</label>
                                            <select class="form-control" v-model="curso" required>
                                                <option :value="c" v-for="c in cursos">{{c.nombre}}</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label>Seleccione alumno</label>
                                            <select class="form-control" v-model="nota.id_usuario" required>
                                                <option :value="a.id_usuario" v-for="a in alumnos">{{a.nombre}}</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label>Seleccione asignatura</label>
                                            <select class="form-control" v-model="nota.id_asignatura" required>
                                                <option v-for="a in asignaturas" :value="a.id_asignatura">{{a.nombre}}</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label>Calificación</label><br>
                                            <input id="slider1" type="range" min="0" max="10" value="5" step=".1"
                                                v-model="nota.calificacion" />
                                            <b>{{nota.calificacion}}</b>
                                        </div>

                                        <div class="form-group">
                                            <label class="bmd-label">Descripción</label>
                                            <textarea name="" id="" cols="30" rows="5" class="form-control" v-model="nota.descripcion"></textarea>
                                        </div>

                                        <button v-if="registro" type="submit" class="btn btn-success" @click="post(nota.id_asignatura, convocatoriaActual.id_convocatoria, nota.calificacion, nota.descripcion, nota.id_usuario)">Agregar</button>
                                        <button v-else type="submit" class="btn btn-success" @click="put(nota.id_nota, nota.id_asignatura, convocatoriaActual.id_convocatoria, nota.calificacion, nota.descripcion, nota.id_usuario)">Guardar
                                            Cambios</button>
                                        <button class="btn btn-primary" @click="ocultarForm">Cancelar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                </form>
                <div class="card" :class="classTable">
                    <div class="card-header">
                        <div class="card-title">
                            <div class="row">
                                <div class="col-8">
                                    <h4><b>Calificaciones</b></h4>
                                </div>
                                <div class="col-4">
                                    <button class="btn btn-success" @click="activarForm">Registrar calificación</button><br><br>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>
                                            Alumno
                                        </th>
                                        <th>Asignatura</th>
                                        <th>Calificación</th>
                                        <th>Descripción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="n in notas">
                                        <td v-text="getValue(n.id_usuario,'id_usuario',alumnos,['nombre','apellido_paterno','apellido_materno'])"></td>
                                        <td v-text="getValue(n.id_asignatura,'id_asignatura',asignaturas,['nombre'])"></td>
                                        <td v-text="n.calificacion"></td>
                                        <td v-text="n.descripcion"></td>
                                        <td>
                                            <button class="btn btn-outline-success">
                                                <i class="fa fa-eye"></i>
                                            </button>
                                            <button @click="editar(n)" class="btn btn-outline-warning">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                            <button class="btn btn-outline-danger" @click="eliminar(n.id_nota)">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
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
            nota: {
                id_nota: '',
                id_asignatura: '',
                id_convocatoria: '',
                calificacion: 10,
                descripcion: '',
                id_usuario: ''
            },
            notas: [],
            cursos: [],
            curso: null,
            alumnos: [],
            asignaturas: [],
            calificaciones: [],
            convocatoriaActual: {
                convocatoria: ''
            },
            tituloForm: 'Registrar calificación',
            baseURL: "<?= site_url('padres/ver')?>/",
            classTable: 'col-md-12',
            classForm: '',
            registro: false
        },
        created: function () {
            this.getCursos();
            this.getData();
            this.getAlumnos();
            this.getCursos();
            this.getCalificaciones();
            this.getAsignaturas();
            this.getConvocatoria();
        },
        methods: {
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
            getNombreCurso(id) {
                for (let i in this.cursos) {
                    let p = this.cursos[i];
                    if (p.id_curso == id) return p.nombre
                }
                return "";
            },
            getNombreUsuario(id) {
                for (let i in this.alumnos) {
                    let p = this.alumnos[i];
                    if (p.id_usuario == id) return p.nombre
                }
                return "";
            },
            ocultarForm() {
                this.classTable = "col-md-12";
                this.classForm = "";
            },
            activarForm() {
                this.nota = {
                    id_nota: '',
                    id_asignatura: '',
                    id_convocatoria: '',
                    calificacion: 10,
                    descripcion: '',
                    id_usuario: ''
                };
                this.classTable = "col-md-8";
                this.classForm = "col-md-4";
                this.registro = true;
            },
            getCursos() {
                var url = "<?=base_url()?>index.php/api/curso/curso";
                axios.get(url).then(
                    response => {
                        this.cursos = response.data;
                    }
                ).catch(
                    error => {
                        //alert('Error');
                        this.cursos = [];
                    }
                );
            },
            getData() {
                var url = "<?=base_url()?>index.php/api/notas/notas";
                axios.get(url).then(
                    response => {
                        this.notas = response.data;
                    }
                ).catch(
                    error => {
                        //alert('Error');
                        this.notas = [];
                    }
                );
            },
            //(nota.id_asignatura, nota.id_convocatoria, nota.id_calificacion, nota.descripcion, nota.id_usuario)
            post(id_asignatura, id_convocatoria, calificacion, descripcion, id_usuario) {
                if (id_asignatura && id_convocatoria && calificacion && id_usuario && descripcion) {
                    var url = "<?=base_url()?>index.php/api/notas/notas";
                    var data = {
                        id_asignatura: id_asignatura,
                        id_convocatoria: id_convocatoria,
                        calificacion: calificacion,
                        descripcion: descripcion,
                        id_usuario: id_usuario
                    };
                    axios.post(url, data)
                        .then(response => {
                            this.getData();
                            this.ocultarForm();
                        }).catch(error => {
                            console.log("Error en post de Aula");
                        });
                }else{
                    alert("Hay campos vacios");
                }
            },
            eliminar(id) {
                var url = "<?=base_url()?>index.php/api/notas/notas/" + id;
                axios.delete(url)
                    .then(response => {
                        this.getData();
                    }).catch(error => {
                        console.log("error en delete de notas");
                    });
            },
            editar(nota) {
                this.activarForm();
                this.nota = Object.assign({}, nota);
                this.registro = false;
                this.tituloForm = 'Editar calificación';
            },
            put(id_nota, id_asignatura, id_convocatoria, calificacion, descripcion, id_usuario) {
                var url = "<?=base_url()?>index.php/api/notas/notas/" + id_nota;
                var data = {
                    id_nota: id_nota,
                    id_asignatura: id_asignatura,
                    id_convocatoria: id_convocatoria,
                    calificacion: calificacion,
                    descripcion: descripcion,
                    id_usuario: id_usuario
                };
                axios.put(url, data)
                    .then(response => {
                        this.getData();
                        this.ocultarForm();
                    }).catch(error => {
                        console.log("Error en put de notas");
                    });
            },
            getAlumnos() {
                var url = "<?=base_url()?>" + "index.php/usuarios_api/alumnos";
                axios.get(url).then(
                    response => {
                        this.alumnos = response.data;
                    }
                ).catch(
                    error => {
                        alert('Error get alumnos');
                    }
                );
            },
            getCalificaciones() {
                var url = "<?=base_url()?>" + "index.php/api/calificaciones/calificaciones";
                axios.get(url).then(
                    response => {
                        this.calificaciones = response.data;
                    }
                ).catch(
                    error => {
                        alert('Error get alumnos');
                    }
                );
            },
            getAsignaturas() {
                var url = "<?=base_url()?>" + "index.php/api/asignatura/asignatura";
                axios.get(url).then(
                    response => {
                        this.asignaturas = response.data;
                    }
                ).catch(
                    error => {
                        alert('Error get asinatura');
                    }
                );
            },
            getConvocatoria() {
                var url = "<?=base_url()?>index.php/api/convocatorias/convocatoriaActual";
                axios.get(url).then(
                    response => {
                        this.convocatoriaActual = response.data;
                    }
                ).catch(
                    error => {
                        alert('Error get convocatoria');
                    }
                );
            },
            getCursos() {
                var url = "<?=base_url()?>index.php/api/curso/curso";
                axios.get(url).then(
                    response => {
                        this.cursos = response.data;
                    }
                ).catch(
                    error => {
                        alert('No hay cursos');
                        this.cursos = [];
                    }
                );
            }
        }
    });
</script>