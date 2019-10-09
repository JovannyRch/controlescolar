<div id="app">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-success">
                <h4 class="card-title ">Alumnos</h4>
                <div class="row">
                    <div class="col-md-8">

                    </div>
                    <div class="col-md-4">
                        <div class="input-group no-border">

                            <input type="text" value="" class="form-control" v-model="buscador" placeholder="Buscar alumno...">
                            <button class="btn btn-white btn-round btn-just-icon" @click="buscarAlumno">
                                <i class="fa fa-search"></i>
                                <div class="ripple-container"></div>
                            </button>
                        </div>
                    </div>

                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <button @click="descargarPDF" class="btn btn-primary btn-rounded" id="btnDownload"> Descargar PDF </button>
                    <br>
                    <div class="alert alert-warning" v-if="mensaje" role="alert">
                        Sin resultados de la busqueda
                    </div>

                    <table v-else class="table table-striped" id="contenido">
                        <thead>
                            <tr>
                                <th>
                                    Nombre
                                </th>
                                <th>
                                    A. Paterno
                                </th>
                                <th>
                                    A. Materno
                                </th>

                                <th>
                                    Reportes
                                </th>
                                <th>
                                    Inscribir
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="usuario in filtrar">
                                <td v-text="usuario.nombre"></td>
                                <td v-text="usuario.apellido_paterno"></td>
                                <td v-text="usuario.apellido_materno"></td>
                                <td>
                                    <a :href="'<?=base_url()?>alumnos/calificaciones/'+usuario.id_usuario" class="btn btn-success btn-rounded">
                                        Curso Actual
                                    </a>

                                </td>
                                <th>
                                    <a :href="baseInscripcion+usuario.id_usuario" class="btn btn-default">Inscribir
                                        convocatoria actual
                                    </a>
                                </th>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/0.9.0rc1/jspdf.min.js"></script>
<script src="<?=base_url()?>js/jspdf.js"></script>
<script>
    var content = document.getElementById('contenido');
    var button = document.getElementById('btnDownload');


    var app = new Vue({
        el: "#app",
        data: {
            saludo: ":)",
            usuarios: [],
            buscador: "",
            baseURL: "<?= site_url('alumnos/ver')?>/",
            baseInscripcion: "<?= base_url()?>inscripciones/alumno/",
            mensaje: false
        },
        created: function () {
            this.getData();
        },
        methods: {
            getData() {
                var url = "<?=base_url()?>" + "/usuarios_api/alumnos";
                axios.get(url).then(
                    response => {
                        this.usuarios = response.data;
                    }
                ).catch(
                    error => {
                        //alert('Error');
                    }
                );
            },
            buscarAlumno() {

                axios.get("<?=base_url()?>api/usuarios_api/buscarAlumno/" + this.buscador).then(
                    response => {
                        this.usuarios = response.data;
                        this.mensaje = false;
                    }
                ).catch(
                    error => {
                        this.mensaje = true;
                    }
                );
            },
            descargarPDF() {
                var doc = new jsPDF();

                doc.setFontSize(5);
                
                doc.text(20, 20, this.alumnosToString());
                doc.save('my.pdf');
            },
            alumnosToString(){
                var resultado = "Alumnos registrados Ciclo Escolar 2018\r\n\r\n";
                for(var i in this.usuarios){
                    
                    var alumno = this.usuarios[i];
                    console.log(alumno);
                    index = parseInt(i)+1;
                    resultado = resultado + (index) +".- "+alumno.apellido_paterno+" "+alumno.apellido_materno+", "+alumno.nombre+"\r\n";
                }
                return resultado;
            }
        },
        computed: {
            filtrar: function () {
                if (this.buscador === '') {
                    return this.usuarios;
                } else {
                    return this.usuarios.filter((usuario) => {
                        return (usuario.nombre.toString() + usuario.apellido_paterno.toString() +
                            usuario.apellido_materno
                            .toString() + usuario.telefono.toString()).toLowerCase().includes(
                            this.buscador
                            .toLowerCase());
                    });
                }
            }

        }
    });

    /*
         return this.usuarios.filter((usuario) => {
                        return (usuario.nombre.toString() + usuario.apellido_paterno.toString() +
                            usuario.apellido_materno
                            .toString()).toLowerCase().includes(
                            this.buscador
                            .toLowerCase());
                    });/
     */
</script>