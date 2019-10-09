<div id="app">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-success">
                <center>
                    <h2 class="card-title"><b>Gestión de Convocatorias</b></h2>
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
                                        <input type="text" v-model="convocatoria.convocatoria" class="form-control" required>
                                    </div>
                                    <button v-if="registro" type="reset" class="btn btn-success" @click="post(convocatoria.convocatoria)">Agregar</button>
                                    <button v-else type="reset" class="btn btn-success" @click="put(convocatoria.id_convocatoria,convocatoria.convocatoria)">Guardar
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
                                        <h4><b>Ciclos escolares</b></h4>
                                    </div>
                                    <div class="col-4">
                                        <button class="btn btn-success" @click="activarForm">Agregar convocatoria</button><br><br>
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
                                                Convocatoria
                                            </th>
                                           
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="c in convocatorias">
                                            <td v-text="c.convocatoria"></td>
                                            <td>
                                                <button class="btn btn-outline-success">
                                                    <i class="fa fa-eye"></i>
                                                </button>
                                                <button @click="editar(c)" class="btn btn-outline-warning">
                                                    <i class="fa fa-edit"></i>
                                                </button>
                                                <button class="btn btn-outline-danger" @click="eliminar(c.id_convocatoria)">
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
            convocatoria: {
                id_convocatoria: '',
                convocatoria: ''
            },
            convocatorias: [],
            tituloForm: 'Agregar convocatoria',
            baseURL: "<?= site_url('padres/ver')?>/",
            classTable: 'col-md-12',
            classForm: '',
            registro: true,
            profesorID: -1
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
                this.convocatoria.id_convocatoria = '';
                this.convocatoria.convocatoria = '';
                this.tituloForm = 'Agregar convocatoria';
                this.classTable = "col-md-8";
                this.classForm = "col-md-4";
                this.registro = true;
            },
            getCursos() {
                var url = "<?=base_url()?>index.php/api/convocatorias/convocatorias";
                axios.get(url).then(
                    response => {
                        this.convocatorias = response.data;
                    }
                ).catch(
                    error => {
                        //alert('Error');
                        this.convocatorias = [];
                    }
                );
            },
            getData() {
                var url = "<?=base_url()?>index.php/api/convocatorias/convocatorias";
                axios.get(url).then(
                    response => {
                        this.convocatorias = response.data;
                    }
                ).catch(
                    error => {
                        //alert('Error');
                        this.convocatorias = [];
                    }
                );
            },
            post(convocatoria) {
                var url = "<?=base_url()?>index.php/api/convocatorias/convocatorias";
                var data = {
                    convocatoria: convocatoria
                };
                axios.post(url, data)
                    .then(response => {
                        this.getData();
                        this.ocultarForm();
                    }).catch(error => {
                        console.log("Error en post de convocatoria");
                    });
            },
            eliminar(id) {
                var url = "<?=base_url()?>index.php/api/convocatorias/convocatorias/" + id;
                axios.delete(url)
                    .then(response => {
                        this.getData();
                    }).catch(error => {
                        console.log("Éxito en delete de convocatorias");
                    });
            },
            editar(convocatoria) {
                this.activarForm();
                this.convocatoria = Object.assign({}, convocatoria);
                this.registro = false;
                this.tituloForm = 'Editar convocatoria';
            },
            put(id_convocatoria, convocatoria) {
                var url = "<?=base_url()?>index.php/api/convocatorias/convocatorias/" + id_convocatoria;
                var data = {
                    id_convocatoria: id_convocatoria,
                    convocatoria: convocatoria
                };
                axios.put(url, data)
                    .then(response => {
                        this.getData();
                        this.ocultarForm();
                    }).catch(error => {
                        console.log("Error en put de convocatoria");
                    });
            }
        }
    });
</script>