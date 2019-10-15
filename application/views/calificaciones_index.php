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


                            <div class="col-sm-12 col-md-4">
                                    <div class="form-group">
                                      <label for="grupo">Parcial</label>
                                      <select class="custom-select" name="grupo" id="grupo">
                                        <option selected disabled>Seleccione parcial</option>
                                        <option value="1">Parcial 1</option>
                                        <option value="2">Parcial 2</option>
                                      </select>
                                    </div>
                                  </div>
                                  <div class="col-sm-12 col-md-4">
                                    <div class="form-group">
                                      <label for="grupo">Criterio</label>
                                      <select class="custom-select" name="grupo" id="grupo">
                                        <option selected disabled>Seleccione criterio</option>
                                        <option value="1">Participación</option>
                                        <option value="2">Investigación</option>
                                      </select>
                                    </div>
                                  </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="profe">Profesor</label>
                                <select class="form-control" name="profe" id="profe" v-model="profesorId" @change ="getMateriasProf">
                                    <option disabled selected value="">Seleccione un profesor</option>
                                    <option v-for="p in profesores" :value="p.id_usuario">{{p.nombre}} {{p.apellido_paterno}}
                                        {{p.apellido_materno}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group" v-if="profesorId">
                                <label for="profe">Materia</label>
                                <select class="form-control" name="profe" id="profe" v-model="materiaIndex">
                                    <option disabled selected value="">Seleccione una materia</option>
                                    <option v-for="(a,index) in infoProfe.asignaturas" :value="index+1">{{a.asignatura}} </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group" v-if="materiaIndex > 0">
                              <label for="grupoS">Grupo</label>
                              <select class="form-control" v-model="grupoId" name="grupoS" id="grupoS">
                                <option disabled value selected>Seleccione un grupo</option>
                                <option :value="g.id_grupo"  v-for="g in infoProfe.asignaturas[materiaIndex-1].grupos">{{g.grupo}}</option>
                              </select>
                            </div>
                        </div>
                        <div class="col-s4"></div>
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
              {id: '166170',p:'BALBUENA',m:'MENDOZA',n:'JOSE JUAN',actividad:'10'},
              {id: '1663244',p:'BERNACHO',m:'CONTRERAS',n:'FATIMA  ',actividad:'10'},
              {id: '166170',p:'BALBUENA',m:'MENDOZA',n:'JOSE JUAN',actividad:'10'},
              {id: '166170',p:'BALBUENA',m:'MENDOZA',n:'JOSE JUAN',actividad:'10'},
              {id: '166170',p:'BALBUENA',m:'MENDOZA',n:'JOSE JUAN',actividad:'10'},
              {id: '166170',p:'BALBUENA',m:'MENDOZA',n:'JOSE JUAN',actividad:'10'},
              {id: '166170',p:'BALBUENA',m:'MENDOZA',n:'JOSE JUAN',actividad:'10'},
              {id: '166170',p:'BALBUENA',m:'MENDOZA',n:'JOSE JUAN',actividad:'10'},
              {id: '166170',p:'BALBUENA',m:'MENDOZA',n:'JOSE JUAN',actividad:'10'},
              {id: '166170',p:'BALBUENA',m:'MENDOZA',n:'JOSE JUAN',actividad:'10'},
              {id: '166170',p:'BALBUENA',m:'MENDOZA',n:'JOSE JUAN',actividad:'10'},
            ]
            
        },
        created: function () {
            this.getProfesores();
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
            getMateriasProf(){
                if(this.profesorId){
                    var url = "<?=base_url()?>index.php/api/asignatura/materiasProfesor/"+this.profesorId;
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
            }
        }
    });
</script>