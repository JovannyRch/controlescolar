<div class="container-fluid" id="app">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Alumnos en grupos</h4>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="grupo">Grupo</label>
                        <select @change="getalumnos()" v-model="grupoSelected" class="form-control" name="grupo"
                            id="grupo">
                            <option value="" selected disabled>Selecciona un grupo</option>
                            <option :value=" g.id_grupo" v-for=" g in grupos">{{g.nombre}}</option>
                        </select>

                        <div v-if="grupoSelected">
                            <table class="table" v-if="alumnosGrupo.length">
                                <thead>
                                    <th><small>#</small></th>
                                    <th><small>Matricula</small></th>
                                    <th><small>Nombre</small></th>
                                    <th><small>Licenciatura</small></th>
                                    <th><small>
                                            <span class="fa fa-times"></span>
                                        </small></th>
                                </thead>
                                <tbody>
                                    <tr v-for="(a,index) in alumnosGrupo">
                                        <td>
                                            <small>{{index+1}}</small>
                                        </td>
                                        <td>
                                            <small>{{a.matricula}}</small>
                                        </td>
                                        <td>
                                            <small>{{a.nombre}} {{a.apellido_paterno}} {{a.apellido_materno}}</small>
                                        </td>
                                        <td>
                                            <small>{{a.licenciatura}}</small>
                                        </td>
                                        <td>
                                            <button @click="quitarAlumno(a)" class="btn btn-danger">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div v-else class="text-center pt-5">
                                No hay alumnos registrados
                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-md-8">
                    <h3 class="text-center">Agregar alumno</h3>
                    <div class="col-sm-12 col-md-12" v-if="!alumnoSeleccionado.id_usuario">
                        <h2 class="text-center">Busqueda de alumno</h2>

                        <div class="row">
                            <form @submit.prevent="buscarAlumno" class="col-12">

                                <div class="row">
                                    <div class="col-12 col-md-4">
                                        <div class="form-group">
                                            <label for="busquedaPOr">Buscar por</label>
                                            <select v-model="por" class="form-control" name="busquedaPOr"
                                                id="busquedaPOr">
                                                <option selected value="matricula">Matricula</option>
                                                <option value="nombre">Nombre</option>
                                            </select>
                                        </div>

                                    </div>
                                    <div class="col-12 col-md-8">
                                        <div class="form-group">
                                            <label for="valorInput">Valor de la busqueda</label>
                                            <input v-model="valor" type="text" class="form-control" name="valorInput"
                                                id="valorInput" aria-describedby="helpId"
                                                placeholder="Ingrese valor a buscar">
                                        </div>


                                    </div>

                                    <div class="col-12 text-center mb-5">
                                        <button type="submit" class="btn btn-success">Buscar</button>
                                    </div>
                                </div>

                            </form>



                        </div>

                        <div class="col-sm-12" v-if="busquedaActual">
                            <span>{{alumnos.length}} resultados para '{{busquedaActual}}' </span>
                            <table class="table mt-2" v-if="alumnos.length">
                                <thead>
                                    <th><small>Matricula</small></th>
                                    <th><small>Nombre completo</small></th>
                                    <th><small>Licenciatura</small></th>
                                    <th><small>Plantel</small></th>
                                    <th><small>Agregar</small></th>
                                </thead>
                                <tbody>
                                    <tr v-for="a in alumnos">
                                        <td>{{a.matricula}}</td>
                                        <td>{{a.nombre}} {{a.apellido_paterno}} {{a.apellido_materno}}</td>
                                        <td>{{a.licenciatura}}</td>
                                        <td>{{a.plantel}}</td>
                                        <td>
                                            <button class="btn btn-success" @click="agregarAlumno(a)">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div v-else class="text-center">
                                No se encontraron resultados por '{{por}}' de '{{valor}}', intente de nuevo
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
            por: 'matricula',
            valor: '',
            alumnosGrupo: [],
            alumnos: [],
            grupos: [],
            grupoSelected: '',
            alumnoSeleccionado: {
                matricula: '',
                id_usuario: '',
                nombre: '',
            },
            busquedaActual: ''

        },
        created: function () {
            this.getgrupos();
        },
        methods: {
            getalumnos() {
                //jovannyrch@gmail.com
                axios.get(`<?=base_url()?>/api/alumnos_grupos/alumnos/${this.grupoSelected}`).then(response => {
                    this.alumnosGrupo = response.data;
                }).catch(e => {
                    this.alumnosGrupo = [];
                })
            },
            getgrupos() {
                //jovannyrch@gmail.com
                axios.get(`<?=base_url()?>api/grupos/grupos`).then(response => {
                    this.grupos = response.data;
                }).catch(e => {
                    console.log(e);
                })
            },
            buscarAlumno() {
                //jovannyrch@gmail.com
                if (this.valor && this.por) {
                    this.busquedaActual = this.valor;
                    axios.get(`<?=base_url()?>/api/alumnos/busqueda/${this.por}/${this.valor}`).then(response => {
                        this.alumnos = response.data;

                    }).catch(e => {
                        console.log(e);
                    })
                } else {
                    alert("Campo de valor vacío")
                }
            },
            seleccionarAlumno(alumno) {
                this.alumnoSeleccionado = Object.assign({}, alumno);
                this.cargarPagos();

            },
            agregarAlumno(a) {
                //jovannyrch@gmail.com
                if (!this.grupoSelected) {
                    alert("Seleccione grupo");
                    return;
                }
                let alumno = {
                    id_alumno: a.id_usuario,
                    id_grupo: this.grupoSelected
                };
                axios.post(`<?=base_url()?>/api/alumnos_grupos/alumnos_grupos`, alumno).then(response => {
                    console.log('Registro exitoso');
                    this.getalumnos();
                }).catch(e => {
                    console.log(e);
                })
            },
            quitarAlumno(alumno) {
                //jovannyrch@gmail.com
                let = {}
                axios.delete(`<?=base_url()?>/api/alumnos_grupos/alumnos_grupos/${alumno.id_ag}`).then(response => {
                    console.log('eliminiación correcta');
                    this.getalumnos();
                }).catch(e => {
                    alert("Ocurrió un error al eliminar")
                })
            }
        }
    })

</script>