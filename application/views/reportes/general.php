<div id="reporteGeneral">
    <div class="row ">
        <div class="col-md-6 animated pulse infinite">
            <img src="<?=base_url()?>imgs/estudiantes.png" width="100%">
        </div>
        <div class="col-md-6 animated tada infinite">
            <div class="hit-the-floor" style="margin-top: 20%"> Matricula de {{datos.alumnos}} alumnos</div>
        </div>

        <div class="col-md-6 animated tada infinite ">
            <div class="hit-the-floor" style="margin-top: 20%"> {{datos.profesores}} profesores</div>
        </div>
        <div class="col-md-6 animated pulse infinite">
            <img src="<?=base_url()?>imgs/teachers.png" width="70%">
        </div>

        <div class="col-md-6 animated pulse infinite">
            <img src="<?=base_url()?>imgs/parents.png" width="50%">
        </div>
        <div class="col-md-6 animated bounce infinite">
            <div class="hit-the-floor" style="margin-top: 20%"> {{datos.padres}} tutores</div>
        </div>
        <div class="col-md-12 animated pulse infinite">
            <div class="hit-the-floor" style="margin-top: 5%">
                Un total de {{datos.usuarios}} usuarios
                registrados en el sistema</div>
        </div>
        <div class="col-md-12 text-center animated pulse infinite">
            <img src="<?=base_url()?>imgs/users.png" width="50%">
        </div>
        <div class="row" style="margin-top: 10%">
            <div class="col-md-6 text-center animated flip infinite">
                <img src="<?=base_url()?>imgs/message.png" width="50%">
            </div>
            <div class="col-md-6 animated pulse infinite">
                <div class="hit-the-floor " style="margin-top: 5%">
                    {{datos.mensajes}} mensajes
                    han sido enviados
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 animated jackInTheBox infinite">
                <img src="<?=base_url()?>imgs/noeyes.png">
            </div>
            <div class="col-md-6 animated jackInTheBox infinite">
                <img src="<?=base_url()?>imgs/sye.svg" width="70%" style="margin-top: 20%">
            </div>
        </div>
        <div class="col-md-6 text-center animated pulse infinite">
            <div class="hit-the-floor" style="margin-top: 5%">
                {{datos.mensajesNoLeidos}} sin leer
            </div>
        </div>
        <div class="col-md-6 text-center animated pulse infinite">
            <div class="hit-the-floor" style="margin-top: 5%">
                {{datos.mensajesLeidos}} leidos
            </div>
        </div>

        <div class="col-md-6 animated pulse infinite" style="margin-top: 10%">
            <img src="<?=base_url()?>imgs/materias.png" width="%">
        </div>
        <div class="col-md-6 animated pulse infinite" style="margin-top: 10%">
            <div class="hit-the-floor" style="margin-top: 20%"> {{datos.asignaturas}} Asignaturas</div>
        </div>

        <div class="col-md-12 animated pulse infinite">
            <div class="hit-the-floor" style="margin-top: 5%">
                Promedio  de toda la escuela {{datos.promedio}} 
             </div>
        </div>
        


    </div>
    <div id="graficareporteGeneral" style="height: 60rem">

    </div>
</div>




<script src="<?=base_url()?>js/highcharts.js"></script>
<script src="<?=base_url()?>js/series-label.js"></script>
<script src="<?=base_url()?>js/exporting.js"></script>

<script>
    let appReporteGrupo = new Vue({
        el: "#reporteGeneral",
        data: {
            datos: {},
            bandera: false

        },
        created: function () {
            this.obtenerDatos();
        },
        methods: {
            obtenerDatos() {
                let url = "<?= base_url()?>api/reportes/general";
                axios.get(url).then(
                    response => {
                        this.datos = response.data;
                        //this.graficar();
                        // this.bandera = true;
                    }).catch(
                    error => {
                        alert("No se encontraron registros");
                    }
                );
            },

            calcularLargo(alumnos) {
                let x = (alumnos * 10) + "rem";
                return "height: " + x;
            },

            graficar() {

                Highcharts.chart('graficareporteGeneral', {
                    chart: {
                        type: 'bar'
                    },
                    title: {
                        text: this.datos.convocatoria
                    },
                    subtitle: {
                        text: 'Profesor: ' + this.datos.profesor + " ----  Promedio Profesor: " + this.datos
                            .promedioProfesor
                    },
                    xAxis: {
                        categories: this.datos.asignaturas,
                        title: {
                            text: 'Asingaturas'
                        }
                    },
                    yAxis: {
                        min: 0,
                        title: {
                            text: this.datos.cantidad + ' materias'
                        },
                        labels: {
                            overflow: 'justify'
                        }
                    },
                    tooltip: {

                    },
                    plotOptions: {
                        bar: {
                            dataLabels: {
                                enabled: true
                            }
                        }
                    },
                    credits: {
                        enabled: false
                    },
                    series: [{
                        name: 'Promedio por materia',
                        data: this.datos.promedios
                    }]
                });
            }
        }
    });
</script>

<style>
    .hit-the-floor {
        color: #fff;
        font-size: 4em;
        font-weight: bold;
        font-family: Helvetica;
        text-shadow: 0 1px 0 #ccc, 0 2px 0 #c9c9c9, 0 3px 0 #bbb, 0 4px 0 #b9b9b9, 0 5px 0 #aaa, 0 6px 1px rgba(0, 0, 0, .1), 0 0 5px rgba(0, 0, 0, .1), 0 1px 3px rgba(0, 0, 0, .3), 0 3px 5px rgba(0, 0, 0, .2), 0 5px 10px rgba(0, 0, 0, .25), 0 10px 10px rgba(0, 0, 0, .2), 0 20px 20px rgba(0, 0, 0, .15);
    }

    .hit-the-floor {
        text-align: center;
    }

    body {
        background-color: #9c868f;
    }
</style>