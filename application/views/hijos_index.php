<div id="app">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-success">
                <center>
                    <h2 class="card-title ">Relación Padre-Hijo</h2>
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
                                        <label>Seleccione alumno</label>
                                        <select class="form-control" v-model="relacion.id_hijo">
                                            <option :value="a.id_usuario" v-for="a in alumnos">{{a.nombre}}</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Seleccione padre</label>
                                        <select class="form-control" v-model="relacion.id_padre">
                                            <option :value="a.id_usuario" v-for="a in padres">{{a.nombre}}</option>
                                        </select>
                                    </div>

                                    <button v-if="registro" type="reset" class="btn btn-success" @click="post(relacion.id_padre,relacion.id_hijo)">Agregar</button>
                                    <button v-else type="reset" class="btn btn-success" @click="put(relacion.id_hijos,relacion.id_padre,relacion.id_hijo)">Guardar
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
                                        <h4><b>Cursos</b></h4>
                                    </div>
                                    <div class="col-4">
                                        <button class="btn btn-success" @click="activarForm">Agregar curso</button><br><br>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Padre</th>
                                            <th>Hijo</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="h in hijos">
                                            <td v-text="getValue(h.id_hijo,'id_usuario',alumnos,['nombre','apellido_paterno','apellido_materno'])"></td>
                                            <td v-text="getValue(h.id_padre,'id_usuario',padres,['nombre','apellido_paterno','apellido_materno'])"></td>
                                            
                                            <td>
                                                <button class="btn btn-outline-success">
                                                    <i class="fa fa-eye"></i>
                                                </button>
                                                <button @click="editar(h)" class="btn btn-outline-warning">
                                                    <i class="fa fa-edit"></i>
                                                </button>
                                                <button class="btn btn-outline-danger" @click="eliminar(h.id_hijos)">
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
            relacion: {
                id_padre: '',
                id_hijo: ''
            },
            alumnos: [],
            padres: [],
            hijos: [],
            tituloForm: 'Registrar relación hijo-padre',
            baseURL: "<?= site_url('padres/ver')?>/",
            classTable: 'col-md-12',
            classForm: '',
            registro: false
        },
        created: function () {
            this.getData();
            this.getAlumnos();
            this.getPadres();
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
                this.relacion.id_padre = '';
                this.relacion.id_hijo = '';
                this.registro = true;
                this.tituloForm = 'Agregar curso';
                this.classTable = "col-md-8";
                this.classForm = "col-md-4";
            },
            getData() {
                var url = "<?=base_url()?>index.php/api/hijos/hijos";
                axios.get(url).then(
                    response => {
                        this.hijos = response.data;
                    }
                ).catch(
                    error => {
                        //alert('Error');
                        this.hijos = [];
                    }
                );
            },
            post(id_padre, id_hijo) {
                var url = "<?=base_url()?>index.php/api/hijos/hijos";
                var data = {
                    id_padre: id_padre,
                    id_hijo: id_hijo
                };
                axios.post(url, data)
                    .then(response => {
                        this.getData();
                        this.ocultarForm();
                    }).catch(error => {
                        console.log("Error en post de Aula");
                    });
            },
            eliminar(id_hijos) {
                var url = "<?=base_url()?>index.php/api/hijos/hijos/" + id_hijos;
                axios.delete(url)
                    .then(response => {
                        this.getData();
                    }).catch(error => {
                        console.log("Éxito en delete de Aula");
                    });
            },
            editar(hijo) {
                this.activarForm();
                this.relacion = Object.assign({}, hijo);
                this.registro = false;
                this.tituloForm = 'Editar relacion hijo-padre';
            },
            put(id_hijos, id_padre, id_hijo) {
                var url = "<?=base_url()?>index.php/api/hijos/hijos/" + id_hijos;
                var data = {
                    id_padre: id_padre,
                    id_hijo: id_hijo
                };
                axios.put(url, data)
                    .then(response => {
                        this.getData();
                        this.ocultarForm();
                    }).catch(error => {
                        console.log("Error en put de curso");
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
            getPadres() {
                var url = "<?=base_url()?>" + "index.php/usuarios_api/padres";
                axios.get(url).then(
                    response => {
                        this.padres = response.data;
                    }
                ).catch(
                    error => {
                        alert('Error get alumnos');
                    }
                );
            }
        }
    });
</script>