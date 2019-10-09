<div class="row" id="app">
    <div class="col-md-12">
        <div class="card">

            <div class="card-body">
                <h2> {{usuario.apellido_paterno+" "+usuario.apellido_materno+" "+usuario.nombre}}</h2>
                <br><br>
                <div class="row">
                    <h3 class="card-title col-md-8">Materias</h3>
                    <div class="col-md-4">
                        <button class="btn btn-success btn-rounded" data-toggle="modal" data-target="#modal-asignar-materia">Asignar
                            materia</button>
                    </div>
                </div>
                <table class="table">
                    <thead>
                        <th>Grupo</th>
                        <th>Asignatura</th>
                        <th>Ciclo Escolar</th>
                    </thead>
                    <tbody>
                        <tr v-for="item in materiaGrupoArray">
                            <td>{{item.id_grupo}}</td>
                            <td>{{item.id_asignatura}}</td>
                            <td>{{item.id_convocatoria}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="modal fade" id="modal-asignar-materia" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-dark">
                        <h5 class="modal-title text-white">Asignar materia</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        
                        <div class="form-group">
                            <label>Convocatoria</label>
                            <input type="text" class="form-control" :value="convocatoriaActual.convocatoria" readonly>
                        </div>

                        <div class="form-group">
                            <label>Seleccione curso</label>
                            <select class="form-control" v-model="curso">
                                <option :value="c" v-for="c in cursos" @click="getAsignaturas">{{c.nombre}}</option>
                            </select>
                        </div>
                        <div class="form-group" v-if="curso">
                            <label>Seleccione Asignatura</label>
                            <select class="form-control" v-model="materiaGrupo.id_asignatura">
                                <option v-for="a in asignaturas" :value="a.id_asignatura" @click="getGrupos(curso.id_curso)">{{a.nombre}}</option>
                            </select>
                        </div>

                        <div class="form-group" v-if="materiaGrupo.id_asignatura">
                            <label>Seleccione Grupo</label>
                            <select class="form-control" v-model="materiaGrupo.id_grupo">
                                <option v-for="g in grupos" :value="g.id_grupo">{{g.nombre}}</option>
                            </select>
                        </div>
                    </div>

                    <div class=" modal-footer">
                        <button v-if="materiaGrupo.id_grupo" class="btn btn-success btn-rounded" @click="postProfesores_materias_grupos(materiaGrupo.id_grupo, materiaGrupo.id_asignatura, id,convocatoriaActual.id_convocatoria)"
                            data-dismiss="modal">Asignar</button>
                        <button class="btn btn-primary btn-rounded" data-dismiss="modal">Cancelar</button>
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
            buscador: "",
            usuario: {},
            id: '<?=$id?>',
            materiaGrupo: {
                id: '',
                id_grupo: '',
                id_asignatura: '',
                id_profesor: ''
            },
            convocatoriaActual: {
                convocatoria: ''
            },
            materiaGrupoArray: [],
            cursos: [],
            asignaturas: [],
            curso: null,
            grupos: []
        },
        created: function () {
            this.get();
            this.getConvocatoria();
            this.materiaGrupoFunction();
            this.getCursos();
        },
        methods: {
            get() {
                var url = "<?=base_url()?>index.php/usuarios_api/usuarios/<?=$id?>";
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
            postProfesores_materias_grupos(id_grupo, id_asignatura, id_profesor,id_convocatoria) {
                var url =
                    "<?=base_url()?>index.php/api/profesores_materias_grupos/profesores_materias_grupos";
                var data = {
                    id_grupo: id_grupo,
                    id_asignatura: id_asignatura,
                    id_profesor: id_profesor,
                    id_convocatoria: id_convocatoria
                };
                axios.post(url, data)
                    .then(response => {
                        this.materiaGrupo = {
                            id: '',
                            id_grupo: '',
                            id_asignatura: '',
                            id_profesor: ''
                        };
                        this.materiaGrupoFunction();
                    }).catch(error => {
                        //alert("Error en post de Profesores_materias_grupos");
                    });
            },
            putProfesores_materias_grupos(id, id_grupo, id_asignatura, id_profesor,id_convocatoria) {
                var url =
                    "<?=base_url()?>index.php/api/profesores_materias_grupos/profesores_materias_grupos" +
                    id;
                var data = {
                    id_grupo: id_grupo,
                    id_asignatura: id_asignatura,
                    id_profesor: id_profesor,
                    id_convocatoria: id_convocatoria
                };
                axios.put(url, data)
                    .then(response => {
                        //console.log("Éxito en put de Profesores_materias_grupos");
                    }).catch(error => {
                        //console.log("Error en put de Profesores_materias_grupos");
                    });
            },
            deleteProfesores_materias_grupos(id) {
                var url =
                    "<?=base_url()?>index.php/api/profesores_materias_grupos/profesores_materias_grupos" +
                    id;
                axios.delete(url)
                    .then(response => {
                       // console.log("Éxito en delete de Profesores_materias_grupos");
                    }).catch(error => {
                        //console.log("Éxito en delete de Profesores_materias_grupos");
                    });
            },
            getCursos() {
                var url = "<?=base_url()?>index.php/api/curso/curso";
                axios.get(url).then(
                    response => {
                        this.cursos = response.data;
                    }
                ).catch(
                    error => {
                       // alert('No hay cursos');
                        this.cursos = [];
                    }
                );
            },
            getAsignaturas() {
                var url = "<?=base_url()?>index.php/api/asignatura/asignaturaXcurso/" + this.curso.id_curso;
                axios.get(url).then(
                    response => {
                        this.asignaturas = response.data;

                    }
                ).catch(
                    error => {
                       // alert('Error get asinatura');
                    }
                );
            },
            getGrupos(id_curso) {
                var url = "<?=base_url()?>index.php/api/grupos/gruposXcurso/" + id_curso;
                axios.get(url).then(
                    response => {
                        this.grupos = response.data;
                    }
                ).catch(
                    error => {
                        //alert('No hay grupos para el curso');
                        this.grupos = [];
                    }
                );
            },
            materiaGrupoFunction() {
                var url =
                    "<?=base_url()?>index.php/api/profesores_materias_grupos/profesores_materias_gruposXprofesor/<?=$id?>";
                axios.get(url)
                    .then(response => {
                        this.materiaGrupoArray = response.data;
                    }).catch(error => {
                        //console.log("Error materiaGrupoArray");
                    });
            },
            getConvocatoria() {
                var url = "<?=base_url()?>" + "index.php/api/convocatorias/convocatoriaActual";
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
            getGrupoData(){
                var url = "<?=base_url()?>index.php/api/grupos/grupos";
                axios.get(url).then(
                    response => {
                        this.gruposData = response.data;
                    }
                ).catch(
                    error => {
                        alert('Error get convocatoria');
                    }
                );
            },
            getAsignaturasData(){
                var url = "<?=base_url()?>index.php/api/grupos/grupos";
                axios.get(url).then(
                    response => {
                        this.gruposData = response.data;
                    }
                ).catch(
                    error => {
                        alert('Error get convocatoria');
                    }
                );
            }
        }
    });
</script>