<div id="app">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <center>
                    <h2 class="card-title"><b>Gestión de asignaturas</b></h2>
                </center>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                <div class="row">
                                    <div class="col-8">
                                        <a href="<?=base_url();?>/reportes/materias" class="btn btn-primary btn-rounded">Reporte
                                            general de asignaturas</a>
                                    </div>
                                    <div class="col-4">
                                        <button class="btn btn-success btn-rounded" data-toggle="modal" @click="activarForm"
                                            data-target="#form">Agregar
                                            asignatura</button><br><br>
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
                                                Nombre
                                            </th>
                                            <th>Descripción</th>
                                            <th>Curso</th>
                                            <th>Reportes</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="a in asignaturas">
                                            <td v-text="a.nombre"></td>
                                            <td v-text="a.descripcion"></td>
                                            <td v-text="getNombreCurso(a.id_curso)"></td>
                                            <td>
                                                <a class="btn btn-outline-primary btn-rounded" :href="'<?= base_url('asignaturas/gestion')?>/'+a.id_asignatura">
                                                    Gestionar
                                                </a>
                                                <button @click="editar(a)" data-target="#form" data-toggle="modal"
                                                    class="btn btn-outline-warning btn-rounded">
                                                    <i class="fa fa-edit"></i>
                                                </button>
                                                <button class="btn btn-outline-danger btn-rounded" @click="eliminar(a.id_asignatura)">
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

    <!-- Modal Form -->
    <div class="modal fade" id="form" tabindex="-1" role="dialog" aria-labelledby="form" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="form"><b>{{tituloForm}}</b></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="bmd-label-floating">Nombre</label>
                        <input type="text" v-model="asignatura.nombre" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="bmd-label">Descripción</label>
                        <textarea name="" id="" cols="30" rows="5" class="form-control" v-model="asignatura.descripcion"></textarea>
                    </div>

                    <div class="form-group">
                        <label>Curso</label>
                        <select class="form-control" v-model="asignatura.id_curso">
                            <option :value="c.id_curso" v-for="c in cursos">{{c.nombre}}</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button v-if="registro" type="button" class="btn btn-primary" data-dismiss="modal" @click="post(asignatura.id_curso,asignatura.nombre,asignatura.descripcion)">Agregar
                        asignatura</button>
                    <button v-else type="button" class="btn btn-primary" data-dismiss="modal" @click="put(asignatura.id_asignatura,asignatura.id_curso,asignatura.nombre,asignatura.descripcion)">Guardar
                        cambios</button>
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
            asignatura: {
                id_curso: '',
                nombre: '',
                descripcion: ''
            },
            cursos: [],
            asignaturas: [],
            tituloForm: 'Agregar asignatura',
            baseURL: "<?= site_url('padres/ver')?>/",
            classTable: 'col-md-12',
            classForm: '',
            registro: true,
            profesorID: -1
        },
        created: function () {
            this.getData();
            this.getCursos();
        },
        methods: {
            getNombreCurso(id) {
                for (let i in this.cursos) {
                    let p = this.cursos[i];
                    if (p.id_curso == id) return p.nombre
                }
                return "";
            },
            getNombreUsuario(id) {
                for (let i in this.profesores) {
                    let p = this.profesores[i];
                    if (p.id_usuario == id) return p.nombre
                }
                return "";
            },
            ocultarForm() {
                this.classTable = "col-md-12";
                this.classForm = "";
            },
            activarForm() {
                this.asignatura.nombre = '';
                this.asignatura.descripcion = '';
                this.asignatura.id_curso = '';
                this.tituloForm = 'Agregar asignatura';
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
                var url = "<?=base_url()?>index.php/api/asignatura/asignatura";
                axios.get(url).then(
                    response => {
                        this.asignaturas = response.data;
                    }
                ).catch(
                    error => {
                        //alert('Error');
                        this.asignaturas = [];
                    }
                );
            },
            post(id_curso, nombre, descripcion) {
                var url = "<?=base_url()?>index.php/api/asignatura/asignatura";
                var data = {
                    id_curso: id_curso,
                    nombre: nombre,
                    descripcion: descripcion
                };
                axios.post(url, data)
                    .then(response => {
                        this.getData();
                        this.ocultarForm();
                    }).catch(error => {
                        console.log("Error en post de Aula");
                    });
            },
            eliminar(id) {
                var respuesta = confirm("Confirmar eliminación");
                if (respuesta) {
                    var url = "<?=base_url()?>index.php/api/asignatura/asignatura/" + id;
                    axios.delete(url)
                        .then(response => {
                            this.getData();
                        }).catch(error => {
                            console.log("Éxito en delete de Aula");
                        });
                }

            },
            editar(asignatura) {
                this.activarForm();
                this.asignatura = Object.assign({}, asignatura);
                this.registro = false;
                this.tituloForm = 'Editar asignatura';
            },
            put(id_asignatura, id_curso, nombre, descripcion) {
                var url = "<?=base_url()?>index.php/api/asignatura/asignatura/" + id_asignatura;
                var data = {
                    id_curso: id_curso,
                    nombre: nombre,
                    descripcion: descripcion
                };
                axios.put(url, data)
                    .then(response => {
                        this.getData();
                        this.ocultarForm();
                    }).catch(error => {
                        console.log("Error en put de asignatura");
                    });
            }
        }
    });
</script>