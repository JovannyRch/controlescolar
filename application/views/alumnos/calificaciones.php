<script src="<?=base_url()?>js/highcharts.js"></script>
<script src="<?=base_url()?>js/series-label.js"></script>
<script src="<?=base_url()?>js/exporting.js"></script>
<script src="<?=base_url()?>js/export-data.js"></script>

<div id="calificacionesApp">
    <h1 class="text-center">{{datos.alumno}}</h1>
    <div id="container" style="min-width: 310px; height: 34rem; margin: 0 auto">

    </div>
</div>


<script>
    let calificacionesApp = new Vue({
        el: "#calificacionesApp",
        data: {
            datos: {}
        },
        created: function () {
            this.obtenerDatos();

        },
        methods: {

            obtenerDatos() {
                let url = "<?= base_url()?>api/alumnos/reporteCalificaciones/<?=$id_alumno?>";
                axios.get(url).then(
                    response => {
                        this.datos = response.data;
                        this.graficar();

                    }).catch(
                    error => {
                        alert("No se encontraron registros");
                    }
                );
            },

            graficar() {
                Highcharts.chart('container', {
                    title: {
                        text: this.datos.curso + ": " + this.datos.promedioCurso
                    },
                    subtitle: {
                        text: this.datos.alumno
                    },
                    xAxis: {
                        categories: this.datos.materias
                    },
                    yAxis: {
                        title: 'calificaciones'
                    },
                    labels: {
                        items: [{
                            style: {
                                left: '50px',
                                top: '18px',
                                color: (Highcharts.theme && Highcharts.theme.textColor) ||
                                    'black'
                            }
                        }]
                    },
                    series: this.datos.calificaciones
                });
            }
        }
    });
</script>