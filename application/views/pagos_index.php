<div class="card" id="app">
    <div class="card-body">
        <h1 class="card-title ">Registro de pagos</h1>
        <div class="row">
            <div class="col-sm-12 col-md-12" v-if="!alumnoSeleccionado.id_usuario">
            <h2 class="text-center">Busqueda de alumno</h2>

                <div class="row">
                   <form @submit.prevent="bucarAlumno" class="col-12" >

                       <div class="row">
                            <div class="col-12 col-md-4">
                                    <div class="form-group">
                                        <label for="busquedaPOr">Buscar por</label>
                                        <select v-model="por" class="form-control" name="busquedaPOr" id="busquedaPOr">
                                            <option selected value="matricula">Matricula</option>
                                            <option value="nombre">Nombre</option>
                                        </select>
                                    </div>
            
                                </div>
                                <div class="col-12 col-md-8">
                                    <div class="form-group">
                                        <label for="valorInput">Valor de la busqueda</label>
                                        <input v-model="valor" type="text" class="form-control" name="valorInput" id="valorInput"
                                            aria-describedby="helpId" placeholder="Ingrese valor a buscar">
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
                            <th>Matricula</th>
                            <th>Nombre completo</th>
                            <th>Licenciatura</th>
                            <th>Plantel</th>
                            <th>Seleccionar</th>
                        </thead>
                        <tbody>
                            <tr v-for="a in alumnos">
                                <td>{{a.matricula}}</td>
                                <td>{{a.nombre}} {{a.apellido_paterno}} {{a.apellido_materno}}</td>
                                <td>{{a.licenciatura}}</td>
                                <td>{{a.plantel}}</td>
                                <td>
                                    <button class="btn btn-primary" @click="seleccionarAlumno(a)">
                                        <i class="fa fa-check"></i>
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

            <div class="col-sm-12 col-md-12" v-if="alumnoSeleccionado.id_usuario">

                <button class="btn btn-primary pull.right" @click="alumnoSeleccionado.id_usuario = ''">
                        <i class="fa fa-arrow-left fa-2x"></i> Regresar a busqueda
                </button>

                <div class="row">
                    <div class="col-md-12 col-12">
                        <h2 class="text-center">Datos del alumno</h2>
                        <table class="table">
                            <thead class="thead-dark">
                                <th>Matricula</th>
                                <th>Nombre</th>
                                <th>Licenciatura</th>
                                <th>Plantel</th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        {{alumnoSeleccionado.matricula}}
                                    </td>
                                    <td>
                                        {{alumnoSeleccionado.nombre}} {{alumnoSeleccionado.apellido_paterno}}
                                        {{alumnoSeleccionado.apellido_materno}}
                                    </td>
                                    <td>
                                        {{alumnoSeleccionado.licenciatura}}
                                    </td>
                                    <td>
                                        {{alumnoSeleccionado.plantel}}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="col-md-12 col-12">

                        <table class="table">
                            <thead class="thead-dark">
                                <th>Total a pagar</th>
                                <th>Mensualidades a pagar</th>
                                <th>Monto por mes</th>
                                <th>Meses por pagar</th>
                                <th>Monto restante</th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{alumnoSeleccionado.costo_final_periodo}}</td>
                                    <td>{{alumnoSeleccionado.tot_mensualidades_x_pagar}}</td>
                                    <td>{{alumnoSeleccionado.costo_mensualidad}}</td>
                                    <td>{{alumnoSeleccionado.cant_mensualidades_x_pagar}}</td>
                                    <td>
                                        <div v-if="montoRestante == -1">
                                            <div class="loader"></div>
                                        </div>
                                        <div v-else>
                                            {{montoRestante}}
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>


                    </div>


                    <div class="col-md-6 col-12">
                        <h4 class="text-center">Pagos</h4>
                        <div v-if="!cargandoPagos">
                            <table class="table table-striped" v-if="pagos.length">
                                <thead>
                                    <th>#</th>
                                    <th>Monto</th>
                                    <th>Fecha</th>
                                    <th>Periodo</th>
                                </thead>
                                <tbody>
                                    <tr v-for="(p,index) in pagos">
                                        <td>{{index+1}}</td>
                                        <td>{{p.monto}}</td>
                                        <td>{{p.fecha}}</td>
                                        <td>{{p.convocatoria}}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <div v-else class="text-center">
                                No se encontraron registros de pagos
                            </div>
                        </div>
                        <div v-else class="text-center">
                            <div class="loader"></div>
                        </div>


                    </div>

                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label for="" style="font-size: 1.4rem">Introduzca monto de pago</label>
                            <input v-model="monto" type="number" class="form-control col-12 col-md-6" name="" id=""
                                aria-describedby="helpId" placeholder="Escriba aquí el monto">
                        </div>

                        <button @click="registarPago" class="btn btn-success">Registrar pago</button>


                    </div>
                </div>

            </div>




        </div>
    </div>
</div>

<script>
    //TODO Busquedad de alumno en JS
    var app = new Vue({
        el: "#app",
        data: {
            por: 'matricula',
            valor: '',
            alumnos: [],
            alumnoSeleccionado: {
                matricula: '',
                id_usuario: '',
                nombre: '',
            },
            pagos: [],
            montoRestante: -1,
            cargandoPagos: false,
            suma: 0,
            monto: 0,
            busquedaActual: ''
            // FIXME Error de nombre en la columna cant_mensualidades_x_pagar
        },
        created: function () {
        },
        methods: {
            bucarAlumno() {
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
            registarPago() {
                if(this.monto <= 0 ){
                    alert("Monto inválido");
                    return;
                }
                // TODO Validación de pagos
                if (this.monto <= this.montoRestante) {
                    //jovannyrch@gmail.com
                    let registro_pago = {
                        id_alumno: this.alumnoSeleccionado.id_usuario,
                        monto: this.monto
                    }
                    axios.post(`<?=base_url()?>/api/pagos/pagos`, registro_pago).then(response => {
                        this.cargarPagos();
                        this.monto = 0;
                        alert("Pago registrado");

                    }).catch(e => {
                        console.log(e);
                    })

                } else {
                    alert("El monto a pagar es mayor, que lo que resta por pagar");
                }

            },
            cargarPagos() {
                this.cargandoPagos = true;
                //jovannyrch@gmail.com
                axios.get(`<?=base_url()?>/api/pagos/pagos_alumno/${this.alumnoSeleccionado.id_usuario}`).then(response => {
                    this.pagos = response.data.pagos;
                    this.suma = response.data.suma;
                    this.montoRestante = parseFloat(this.alumnoSeleccionado.costo_final_periodo) - parseFloat(this.suma);
                    this.cargandoPagos = false;
                }).catch(e => {
                    console.log(e);
                    this.cargandoPagos = false;
                })

            }
        }
    })

</script>