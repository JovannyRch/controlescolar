<div id="app" class="card">
    <div class="card-title">
        <h1 class="text-center p-3">{{nombre}}</h1>
        <h2 class="text-center">{{curso}}</h2>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-9"></div>
            <div class="col-3  p-3">
                <button class="btn btn-outline-success btn-rounded" data-toggle="modal" data-target="#agregarProfesor"
                    @click="getProfesoresDisponibles">Añadir
                    profesor</button>
            </div>
        </div>
        <div v-if="profesores.length != 0">
            <ul class="list-group">
                <li v-for="p in profesores" class="list-group-item">
                    <div class="row">
                        <div class="col-md-10 list-group-item-heading">
                            <b>{{p.apellido_paterno}} {{p.apellido_materno}}, {{p.nombre}}</b>
                        </div>
                        <div class="col-md-2">

                            <button @click="getGruposDisponibles(p.id_profesores_materias)" class="btn btn-outline-primary btn-rounded"
                                data-toggle="modal" data-target="#agregarGrupo">
                                <i class="fa fa-plus"></i> Grupo
                            </button>

                            <button @click="borrar(p.id_profesores_materias)" class="btn btn-outline-danger btn-rounded">
                                <i class="fa fa-trash"></i>
                            </button>
                        </div>
                        <div class="col-md-1"></div>
                        <div v-if="p.grupos.length == 0" class="alert alert-warning col-md-6" role="alert">
                            No hay grupos asignados
                        </div>
                        <div v-else class="col-md-6">
                            <table class="table">
                                <thead>
                                    <th>Grupo</th>
                                    <th>Quitar</th>
                                </thead>
                                <tbody>
                                    <tr v-for="g in p.grupos">
                                        <td>{{g.nombre}}</td>
                                        <td>
                                            <button class="btn btn-outline-danger btn-rounded" @click="deleteGrupo(g.id_profesores_materias_grupos)">
                                                <i class="fa fa-minus"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>

                            </table>
                        </div>
                    </div>

                </li>
            </ul>
        </div>
        <div v-else class="alert alert-warning" role="alert">
            No se encontraron profesores para al materia
        </div>
    </div>

    <!-- Form profesor  -->
    <div class="modal fade" id="agregarProfesor" tabindex="-1" role="dialog" aria-labelledby="agregarProfesor"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="agregarProfesor">Profesores disponibles para la materia</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <thead>
                            <th>Nombre</th>
                            <th>Paterno</th>
                            <th>Materno</th>
                            <th>Agregar</th>
                        </thead>
                        <tbody>
                            <tr v-for="p in profesoresDisponibles">
                                <td>{{p.nombre}}</td>
                                <td>{{p.apellido_paterno}}</td>
                                <td>{{p.apellido_materno}}</td>
                                <td>
                                    <button data-dismiss="modal" class="btn btn-outline-primary btn-rounded" @click="postProfesor(p.id_usuario)">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

    <!-- Form grupo  -->
    <div class="modal fade" id="agregarGrupo" tabindex="-1" role="dialog" aria-labelledby="agregarGrupo" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="agregarGrupo">Grupos disponibles</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div v-if="gruposDisponibles.length == 0">
                        No hay grupos disponibles
                    </div>
                    <table class="table table-striped" v-else>
                        <thead>
                            <th>Grupo</th>
                            <th>Agregar</th>
                        </thead>
                        <tbody>
                            <tr v-for="g in gruposDisponibles">
                                <td>{{g.nombre}}</td>
                                <td>
                                    <button class="btn btn-outline-primary btn-rounded" data-dismiss="modal" @click="agregarGrupo(g.id_grupo)">
                                        <i class="fa fa-plus"></i>
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



<script>
    let profesores = JSON.parse('<?= json_encode($profesores) ?>');
    let id_materia = '<?= $id_asignatura ?>';
    var app = new Vue({
        el: '#app',
        data: {
            nombre: '<?= $nombre ?>',
            profesores: profesores,
            profesoresDisponibles: [],
            gruposDisponibles: [],
            id_profesores_materias: -1,
            curso: '<?= $curso ?>'
        },
        methods: {
            getProfesores() {
                var url = '<?=base_url()?>api/asignatura/profesoresActivos/<?= $id_asignatura ?>';
                axios.get(url).then(
                    response => {
                        this.profesores = response.data;
                        console.log("Actualizado con éxito");
                    }
                ).catch(
                    error => {
                        this.profesores = [];
                    }
                );
            },
            getProfesoresDisponibles() {
                var url = '<?=base_url()?>api/asignatura/profesoresDisp/<?= $id_asignatura ?>';
                axios.get(url).then(
                    response => {
                        this.profesoresDisponibles = response.data;
                        console.log('Profesores disponibles actualizado con éxito');
                    }
                ).catch(
                    error => {
                        //alert('Error');
                        this.profesoresDisponibles = [];
                    }
                );
            },
            postProfesor(id_profesor) {
                var url = '<?=base_url()?>api/profesores_materias/post';
                var data = {
                    id_profesor: id_profesor,
                    id_asignatura: id_materia
                };
                axios.post(url, data)
                    .then(
                        response => {
                            this.getProfesoresDisponibles();
                            this.getProfesores();
                        }
                    ).catch(
                        error => {
                            console.log("Error al hacer el post de profesores_materia");
                        }
                    );
            },
            borrar(id_profesores_materias) {
                var url = '<?=base_url()?>api/profesores_materias/delete/' + id_profesores_materias;
                axios.delete(url)
                    .then(
                        response => {
                            this.getProfesoresDisponibles();
                            this.getProfesores();
                        }
                    ).catch(
                        error => {}
                    );
            },
            getGruposDisponibles(id_profesores_materias) {
                this.id_profesores_materias = id_profesores_materias;
                var url = '<?=base_url()?>api/asignatura/gruposAsignatura/' + id_profesores_materias;
                axios.get(url).then(
                    response => {
                        this.gruposDisponibles = response.data;
                    }
                ).catch(
                    error => {
                        //alert('Error');
                        this.gruposDisponibles = [];
                    }
                );
            },
            agregarGrupo(id_grupo) {
                var url = '<?=base_url()?>api/profesores_materias_grupos/post';
                var data = {
                    id_grupo: id_grupo,
                    id_profesores_materias: this.id_profesores_materias
                };
                axios.post(url, data)
                    .then(
                        response => {
                            this.getProfesores();
                        }
                    ).catch(
                        error => {
                            console.log("Error al hacer el post de profesores_materia");
                        }
                    );
            },
            deleteGrupo(id_profesores_materias_grupos){
                
                var url = '<?=base_url()?>api/profesores_materias_grupos/delete/' + id_profesores_materias_grupos;
                axios.delete(url)
                    .then(
                        response => {
                            this.getProfesores();
                        }
                    ).catch(
                        error => {
                            alert("ERROR");
                        }
                    );
            }
        }
    })
</script>