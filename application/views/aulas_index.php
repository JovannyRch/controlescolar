<div id="app">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-success">
                <center>
                    <h2 class="card-title" id="titulo">Gestión de aulas</h2>

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
                                        <input type="text" v-model="aula.nombre" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="bmd-label">Descripción</label>
                                        <textarea name="" id="" cols="30" rows="5" class="form-control" v-model="aula.descripcion"></textarea>
                                    </div>
                                    <button v-if="registro" type="reset" class="btn btn-success" @click="postAula(aula.nombre,aula.descripcion)">Agregar</button>
                                    <button v-else type="reset" class="btn btn-success" @click="putAula(aula.id_aula, aula.nombre, aula.descripcion)">Guardar
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
                                        <h4><b>Aulas</b></h4>
                                    </div>
                                    <div class="col-4">
                                        <button class="btn btn-success" @click="activarForm">Agregar aula</button><br><br>
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
                                            <th>
                                                Descripción
                                            </th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="aula in aulas">
                                            <td v-text="aula.nombre"></td>
                                            <td v-text="aula.descripcion"></td>
                                            <td>
                                                <button class="btn btn-outline-success">
                                                    <i class="fa fa-eye"></i>
                                                </button>
                                                <button @click="editarAula(aula)" class="btn btn-outline-warning">
                                                    <i class="fa fa-edit"></i>
                                                </button>
                                                <button class="btn btn-outline-danger" @click="eliminar(aula.id_aula)">
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

<script>


    var app = new Vue({
        el: "#app",

        data: {
            aula: {
                nombre: '',
                descripcion: ''
            },
            aulas: [],
            tituloForm: 'Agregar aula',
            baseURL: "<?= site_url('padres/ver')?>/",
            classTable: 'col-md-10',
            classForm: '',
            registro: false
        },
        created: function () {
            this.getData();
        },
        methods: {
            ocultarForm() {
                this.classTable = "col-md-10";
                this.classForm = "";
            },
            activarForm() {
                this.aula.nombre = '';
                this.aula.descripcion = '';
                this.registro = true;
                this.tituloForm = 'Agregar aula';
                this.classTable = "col-md-6";
                this.classForm = "col-md-4";
            },
            getData() {
                var url = "<?=base_url()?>index.php/api/aula/aula";
                axios.get(url).then(
                    response => {
                        this.aulas = response.data;
                    }
                ).catch(
                    error => {
                        //alert('Error');
                        this.aulas = [];
                    }
                );
            },
            postAula(nombre, descripcion) {
                var url = "<?=base_url()?>index.php/api/aula/aula";
                var data = {
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
            eliminar(id_aula) {
                var url = "<?=base_url()?>index.php/api/aula/aula/" + id_aula;
                axios.delete(url)
                    .then(response => {
                        this.getData();
                    }).catch(error => {
                        console.log("Éxito en delete de Aula");
                    });
            },
            editarAula(aula) {
                this.activarForm();
                this.aula = Object.assign({}, aula);
                this.registro = false;
                this.tituloForm = 'Editar aula';
            },
            putAula(id_aula, nombre, descripcion) {
                var url = "<?=base_url()?>index.php/api/aula/aula/" + id_aula;
                var data = {
                    nombre: nombre,
                    descripcion: descripcion
                };
                axios.put(url, data)
                    .then(response => {
                        this.getData();
                        this.ocultarForm();
                    }).catch(error => {
                        console.log("Error en put de Aula");
                    });
            }
        }
    });
</script>