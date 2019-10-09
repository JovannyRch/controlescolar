<div id="app">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-success">
                <center>
                    <h2 class="card-title"><b>Gestión de grupos</b></h2>
                </center>
            </div>
            <div class="card-body">
                <div class="row">
                    <div v-if="classForm" :class="classForm">
                        <div>
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title "><b>{{tituloForm}}</b> </h4>

                                    <div class="form-group">
                                        <label class="bmd-label-floating">Nombre</label>
                                        <input type="text" v-model="grupo.nombre" class="form-control" required>
                                    </div>

                                    <div class="form-group">
                                        <label>Seleccione aula</label>
                                        <select class="form-control" v-model="grupo.id_aula">
                                            <option v-for="a in aulas" :value="a.id_aula">{{a.nombre}}</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Seleccione grado</label>
                                        <select class="form-control" v-model="grupo.id_curso">
                                            <option v-for="a in cursos" :value="a.id_curso">{{a.nombre}}</option>
                                        </select>
                                    </div>



                                    <div class="form-group">
                                        <label class="bmd-label">Descripción</label>
                                        <textarea name="" id="" cols="30" rows="5" class="form-control" v-model="grupo.descripcion"></textarea>
                                    </div>

                                    <button v-if="registro" type="reset" class="btn btn-success" @click="post(grupo.id_aula, grupo.id_curso, grupo.nombre, grupo.descripcion)">Agregar</button>
                                    <button v-else type="reset" class="btn btn-success" @click="put(grupo.id_grupo,grupo.id_aula, grupo.id_curso, grupo.nombre, grupo.descripcion)">Guardar
                                        Cambios</button>
                                    <button class="btn btn-primary" @click="ocultarForm">Cancelar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card" :class="classTable">
                        <div class="card-header">
                            <div class="card-title">
                                <div class="row">
                                    <div class="col-8">
                                        <h4><b>Grupos</b></h4>
                                    </div>
                                    <div class="col-4">
                                        <button class="btn btn-success" @click="activarForm">Agregar grupo</button><br><br>
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
                                            <th>Aula</th>
                                            <th>Grado</th>
                                            <th>Descripción</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="item in grupos">
                                            <td v-text="item.nombre"></td>
                                            <td v-text="getValue(item.id_aula,'id_aula',aulas,['nombre'])"></td>
                                            <td v-text="getValue(item.id_curso,'id_curso',cursos,['nombre'])"></td>
                                            <td v-text="item.descripcion"></td>
                                            <td>
                                                <a :href="'<?= base_url() ?>grupos/reporte/'+item.id_grupo" class="btn btn-success">
                                                    Reporte por alumnos
                                                </a>
                                                <a :href="'<?= base_url() ?>grupos/reporteMaterias/'+item.id_grupo" class="btn btn-success">
                                                    Reporte por materias
                                                </a>
                                                <button @click="editar(item)" class="btn btn-outline-warning">
                                                    <i class="fa fa-edit"></i>
                                                </button>
                                                <button class="btn btn-outline-danger" @click="eliminar(item.id_grupo)">
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
            grupo: {
                id_grupo: '',
                id_aula: '',
                id_curso: '',
                nombre: '',
                descripcion: ''
            },
            grupos: [],
            aulas: [],
            cursos: [],
            tituloForm: 'Registrar grupo',
            baseURL: "<?= site_url('padres/ver')?>/",
            classTable: 'col-md-12',
            classForm: '',
            registro: false
        },
        created: function () {
            this.getData();
            this.getAulas();
            this.getCursos();
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
            ocultarForm() {
                this.classTable = "col-md-12";
                this.classForm = "";
            },
            activarForm() {
                this.grupo = {
                    id_grupo: '',
                    id_aula: '',
                    id_curso: '',
                    nombre: '',
                    descripcion: ''
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
                var url = "<?=base_url()?>index.php/api/grupos/grupos";
                axios.get(url).then(
                    response => {
                        this.grupos = response.data;
                    }
                ).catch(
                    error => {
                        this.grupos = [];
                    }
                );
            },
            post(id_aula, id_curso, nombre, descripcion) {
                var url = "<?=base_url()?>index.php/api/grupos/grupos";
                var data = {
                    id_aula: id_aula,
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
            put(id_grupo, id_aula, id_curso, nombre, descripcion) {
                var url = "<?=base_url()?>index.php/api/grupos/grupos/" + id_grupo;
                var data = {
                    id_aula: id_aula,
                    id_curso: id_curso,
                    nombre: nombre,
                    descripcion: descripcion
                };
                axios.put(url, data)
                    .then(response => {
                        this.getData();
                        this.ocultarForm();
                    }).catch(error => {
                        console.log("Error en put");
                    });
            },
            eliminar(id) {
                var respuesta = confirm("Confirmar eliminación");
               if(respuesta){
                var url = "<?=base_url()?>index.php/api/grupos/grupos/" + id;
                axios.delete(url)
                    .then(response => {
                        this.getData();
                    }).catch(error => {
                        console.log("error en delete");
                    });
               }
            },
            editar(item) {
                this.activarForm();
                this.grupo = Object.assign({}, item);
                this.registro = false;
                this.tituloForm = 'Editar grupo';
            },
            getAulas() {
                var url = "<?=base_url()?>" + "index.php/api/aula/aula";
                axios.get(url).then(
                    response => {
                        this.aulas = response.data;
                    }
                ).catch(
                    error => {
                        alert('Error get convocatorias');
                    }
                );
            }
        }
    });
</script>