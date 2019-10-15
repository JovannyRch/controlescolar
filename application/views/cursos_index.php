<div id="app">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-success">
                <center>
                    <h2 class="card-title ">Gestión de licenciaturas</h2>
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
                                        <input type="text" v-model="curso.nombre" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="bmd-label">Descripción</label>
                                        <textarea name="" id="" cols="30" rows="5" class="form-control" v-model="curso.descripcion"></textarea>
                                    </div>

                                    <button v-if="registro" type="reset" class="btn btn-success" @click="post(curso.nombre,curso.descripcion)">Agregar</button>
                                    <button v-else type="reset" class="btn btn-success" @click="put(curso.id_curso, curso.nombre,curso.descripcion)">Guardar
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
                                    </div>
                                    <div class="col-4">
                                        <button class="btn btn-success" @click="activarForm">Agregar licenciatura</button><br><br>
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
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="curso in cursos">
                                            <td v-text="curso.nombre"></td>
                                            <td v-text="curso.descripcion"></td>
                                            <td>
                                                <button class="btn btn-outline-success">
                                                    <i class="fa fa-eye"></i>
                                                </button>
                                                <button @click="editar(curso)" class="btn btn-outline-warning">
                                                    <i class="fa fa-edit"></i>
                                                </button>
                                                <button class="btn btn-outline-danger" @click="eliminar(curso.id_curso)">
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
            curso: {
                nombre: '',
                descripcion: ''
            },
            cursos: [],
            tituloForm: 'Agregar grado',
            baseURL: "<?= site_url('padres/ver')?>/",
            classTable: 'col-md-12',
            classForm: '',
            registro: false
        },
        created: function () {
            this.getData();
        },
        methods: {
            ocultarForm() {
                this.classTable = "col-md-12";
                this.classForm = "";
            },
            activarForm() {
                this.curso.nombre = '';
                this.curso.descripcion = '';
                this.registro = true;
                this.tituloForm = 'Agregar licenciatura';
                this.classTable = "col-md-8";
                this.classForm = "col-md-4";
            },
            getData() {
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
            post(nombre, descripcion) {
                var url = "<?=base_url()?>index.php/api/curso/curso";
                var data = {
                    nombre: nombre,
                    descripcion: descripcion
                };
                axios.post(url, data)
                    .then(response => {
                        this.getData();
                        this.ocultarForm();
                    }).catch(error => {
                    });
            },
            eliminar(id_curso) {
                var url = "<?=base_url()?>index.php/api/curso/curso/" + id_curso;
                axios.delete(url)
                    .then(response => {
                        this.getData();
                    }).catch(error => {
                        console.log("Error en el delete");
                    });
            },
            editar(curso) {
                this.activarForm();
                this.curso = Object.assign({}, curso);
                this.registro = false;
                this.tituloForm = 'Editar licenciatura';
            },
            put(id_curso, nombre, descripcion) {
                var url = "<?=base_url()?>index.php/api/curso/curso/" + id_curso;
                var data = {
                    nombre: nombre,
                    descripcion: descripcion
                };
                axios.put(url, data)
                    .then(response => {
                        this.getData();
                        this.ocultarForm();
                    }).catch(error => {
                        console.log("Error en put de grado");
                    });
            }
        }
    });
</script>