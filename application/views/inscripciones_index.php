<div id="app">
    <div class="col-md-12">
        <div class="card">

            <div class="card-body">
                <div class="row">
                    <div :class="classForm" v-if="aceptada">
                        <div>
                            <div class="card">
                                <div class="card-body">
                                    <h2><b>Incripción del alumno: {{alumno.apellido_paterno+" "+alumno.apellido_materno+", "+alumno.nombre}}</b> </h2>

                                    <div class="form-group">
                                        <label>Convocatoria</label>
                                        <input type="text" class="form-control" :value="convocatoriaActual.convocatoria"
                                            readonly>
                                    </div>


                                    <div class="form-group">
                                        <label>Seleccione curso</label>
                                        <select class="form-control" v-model="inscipricion.id_curso">
                                            <option v-for="c in cursos" :value="c.id_curso" @click="getGrupos(c.id_curso)">{{c.nombre}}</option>
                                        </select>
                                    </div>

                                    <div v-if="inscipricion.id_curso" class="form-group">
                                        <label>Seleccione grupo</label>
                                        <select class="form-control" v-model="inscipricion.id_grupo">
                                            <option v-for="g in grupos" :value="g.id_grupo">{{g.nombre}}</option>
                                        </select>
                                    </div>
                                    <button v-if="inscipricion.id_grupo" type="reset" class="btn btn-success" @click="post(idAlumno,inscipricion.id_curso,convocatoriaActual.id_convocatoria ,inscipricion.id_grupo)">Inscribir</button>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-else class="row" style="margin-left: 35%">
                            <div class="alert alert-danger text center col-md-12">El alumno ya está inscrito en la convocatoria actual</div>
                                             
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
            idAlumno: <?= $id?>,
            inscipricion: {
                id_curso: '',
                id_grupo: ''
            },
            convocatoriaActual: {
                convocatoria: ''
            },
            alumno: {
                nombre: '',
                apellido_materno: '',
                apellido_paterno: ''
            },
            cursos: [],
            tituloForm: 'Incripción',
            classForm: 'col-md-12',
            registro: true,
            grupos: [],
            aceptada: -1
        },
        created: function () {
            this.getConvocatoria();
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
            getNombreCurso(id) {
                for (let i in this.cursos) {
                    let p = this.cursos[i];
                    if (p.id_curso == id) return p.nombre
                }
                return "";
            },
            ocultarForm() {
                this.classTable = "col-md-12";
                this.classForm = "";
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
                var url = "<?=base_url()?>index.php/usuarios_api/usuarios/" + this.idAlumno;
                axios.get(url).then(
                    response => {
                        this.alumno = response.data;
                    }
                ).catch(
                    error => {
                        //alert('Error');
                        this.alumno = null;
                    }
                );
            },
            //(nota.id_asignatura, nota.id_convocatoria, nota.id_calificacion, nota.descripcion, nota.id_usuario)
            post(id_alumno, id_curso, id_convocatoria, id_grupo) {
                var url = "<?=base_url()?>index.php/api/inscripciones/inscripciones";
                var data = {
                    id_alumno: id_alumno,
                    id_curso: id_curso,
                    id_convocatoria: id_convocatoria,
                    id_grupo: id_grupo
                };
                axios.post(url, data)
                    .then(response => {

                        alert("Inscrito con éxito");
                        
                    }).catch(error => {
                        console.log("Error en post de de alumno");
                    });
            },
            eliminar(id) {
                var url = "<?=base_url()?>index.php/api/notas/notas/" + id;
                axios.delete(url)
                    .then(response => {
                        this.getData();
                    }).catch(error => {
                        console.log("error en delete de notas");
                    });
            },
            put(id_nota, id_asignatura, id_convocatoria, id_calificacion, descripcion, id_usuario) {
                var url = "<?=base_url()?>index.php/api/notas/notas/" + id_nota;
                var data = {
                    id_nota: id_nota,
                    id_asignatura: id_asignatura,
                    id_convocatoria: id_convocatoria,
                    id_calificacion: id_calificacion,
                    descripcion: descripcion,
                    id_usuario: id_usuario
                };
                axios.put(url, data)
                    .then(response => {
                        this.getData();
                        this.ocultarForm();
                    }).catch(error => {
                        console.log("Error en put de notas");
                    });
            },
            getConvocatoria() {
                var url = "<?=base_url()?>" + "index.php/api/convocatorias/convocatoriaActual";
                axios.get(url).then(
                    response => {
                        this.convocatoriaActual = response.data;
                        this.validarInscripcion();
                    }
                ).catch(
                    error => {
                        alert('Error get convocatoria');
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
                        alert('No hay grupos para el curso');
                        this.grupos = [];
                        this.inscipricion.id_grupo = '';
                    }
                );
            },
            validarInscripcion() {

                var url = "<?=base_url()?>index.php/api/inscripciones/validarInscripcion/" +this.convocatoriaActual.id_convocatoria+"/"+this.idAlumno;
                console.log(url);
                axios.get(url).then(
                    response => {
                        this.getData();
                        this.getCursos();
                        this.aceptada = true;
                    }
                ).catch(
                    error => {
                        this.aceptada = true;
                        this.aceptada = false;
                    }
                );
            }
        }
    });
</script>