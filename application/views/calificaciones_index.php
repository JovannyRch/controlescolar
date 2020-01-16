<div id="app">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-success">
                <center>
                    <h2 class="card-title" id="titulo">Asignación de calificaciones</h2>

                </center>
            </div>

            <div class="card-body">

                <div class="container">

                    <div class="row">


                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label for="grupo">Grupo</label>
                                <select @change="getalumnos" v-model="grupoSelected" class="custom-select" name="grupo"
                                    id="grupo">
                                    <option selected disabled value="">Seleccione grupo</option>
                                    <option :value="g.id_grupo" v-for="g in grupos">{{g.nombre}}</option>
                                </select>
                            </div>

                            <div v-if="grupoSelected">
                                <table class="table" v-if="alumnosGrupo.length">
                                    <thead>
                                        <th><small>#</small></th>
                                        <th><small>Matricula</small></th>
                                        <th><small>Nombre</small></th>
                                        <th><small>Licenciatura</small></th>
                                        <th><small>
                                                <span class="fa fa-eye"></span>
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
                                                <small>{{a.nombre}} {{a.apellido_paterno}}
                                                    {{a.apellido_materno}}</small>
                                            </td>
                                            <td>
                                                <small>{{a.licenciatura}}</small>
                                            </td>
                                            <td>
                                                <button @click="seleccionarAlumno(a)" class="btn btn-primary">
                                                    <i class="fa fa-eye"></i>
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
                        <div class="col-sm-12 col-md-6">

                            <table class="table">
                                <thead>
                                    <th>#</th>
                                    <th>Materia</th>
                                    <th>Calificar</th>
                                </thead>
                                <tbody>
                                    <tr v-for="(m,index) in materias">
                                        <td>
                                            {{index+1}}
                                        </td>
                                        <td>
                                            {{m}}
                                        </td>
                                        <td>
                                            <button class="bnt btn-outline-success">
                                                <i class="fa fa-check"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>


                            </table>
                        </div>


                    </div>

                </div>

            </div>

            <div class="pt-4" v-if="grupoId">


                <table class="table">
                    <thead class="thead-light">
                        <th>Matricula</th>
                        <th>A. Paterno</th>
                        <th>A. Materno</th>
                        <th>Nombre</th>
                        <th>Actividad</th>
                    </thead>
                    <tbody>
                        <tr v-for="a in alumnos">
                            <td>{{a.id}}</td>
                            <td>{{a.p}}</td>
                            <td>{{a.m}}</td>
                            <td>{{a.n}}</td>
                            <td>{{a.actividad}}</td>
                        </tr>
                    </tbody>



                </table>

            </div>

        </div>

    </div>

</div>
</div>

<script>


    var app = new Vue({
        el: "#app",

        data: {
            grupoSelected: '',
            aula: {
                nombre: '',
                descripcion: ''
            },
            profesores: [],
            tituloForm: 'Agregar aula',
            registro: false,
            profesorId: '',
            materiaIndex: null,
            grupoId: '',
            infoProfe: {},
            materias: [],
            alumnos: [
                { id: '166170', p: 'BALBUENA', m: 'MENDOZA', n: 'JOSE JUAN', actividad: '10' },
                { id: '1663244', p: 'BERNACHO', m: 'CONTRERAS', n: 'FATIMA  ', actividad: '10' },
                { id: '166170', p: 'BALBUENA', m: 'MENDOZA', n: 'JOSE JUAN', actividad: '10' },
                { id: '166170', p: 'BALBUENA', m: 'MENDOZA', n: 'JOSE JUAN', actividad: '10' },
                { id: '166170', p: 'BALBUENA', m: 'MENDOZA', n: 'JOSE JUAN', actividad: '10' },
                { id: '166170', p: 'BALBUENA', m: 'MENDOZA', n: 'JOSE JUAN', actividad: '10' },
                { id: '166170', p: 'BALBUENA', m: 'MENDOZA', n: 'JOSE JUAN', actividad: '10' },
                { id: '166170', p: 'BALBUENA', m: 'MENDOZA', n: 'JOSE JUAN', actividad: '10' },
                { id: '166170', p: 'BALBUENA', m: 'MENDOZA', n: 'JOSE JUAN', actividad: '10' },
                { id: '166170', p: 'BALBUENA', m: 'MENDOZA', n: 'JOSE JUAN', actividad: '10' },
                { id: '166170', p: 'BALBUENA', m: 'MENDOZA', n: 'JOSE JUAN', actividad: '10' },
            ],
            grupos: [],
            alumnosGrupo: [],
            alumnoSeleccionado: {
                matricula: '',
                id_usuario: ''
            }

        },
        created: function () {
            this.getgrupos();
        },
        methods: {

            getProfesores() {
                var url = "<?=base_url()?>index.php/usuarios_api/profesores";
                axios.get(url).then(
                    response => {
                        this.profesores = response.data;
                    }
                ).catch(
                    error => {
                        //alert('Error');
                        this.profesores = [];
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
            getMateriasProf() {
                if (this.profesorId) {
                    var url = "<?=base_url()?>index.php/api/asignatura/materiasProfesor/" + this.profesorId;
                    axios.get(url).then(
                        response => {
                            this.infoProfe = response.data;
                        }
                    ).catch(
                        e => {
                            this.infoProfe = [];
                        }
                    )
                }
            },
            getgrupos() {
                //jovannyrch@gmail.com
                axios.get(`<?=base_url()?>/api/grupos/grupos`).then(response => {
                    this.grupos = response.data;
                }).catch(e => {
                    console.log(e);
                })
            },
            getalumnos() {
                //jovannyrch@gmail.com
                axios.get(`<?=base_url()?>/api/alumnos_grupos/alumnos/${this.grupoSelected}`).then(response => {
                    this.alumnosGrupo = response.data;
                }).catch(e => {
                    this.alumnosGrupo = [];
                })
            },
            seleccionarAlumno(alumno) {
                this.alumnoSeleccionado = Object.assign({}, alumno);
                this.getMateriasAlumno();
            },
            getMateriasAlumno() {
                //jovannyrch@gmail.com
                axios.get(`<?=base_url()?>/api/asignatura/asignaturaXcurso/${this.alumnoSeleccionado.id_licenciatura}`).then(response => {
                    this.materias = response.data;
                }).catch(e => {
                    console.log(e);
                })
            }

        }
    });
</script>