<div id="appReportesMaterias">

</div>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/series-label.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>

<div id="container" style="height: 200rem"></div>
<script>
    //Consumiremos la api usando axios y Vue.js

    const appReportesMaterias = new Vue({
        el: '#appReportesMaterias',
        data: {
            saludo: 'hola a todos',
            datos: {}
        },
        methods: {
            cargarDatos() {
                var url = "<?=base_url()?>api/reportes/materias"
                axios.get(url).then(
                    response => {
                        this.datos = response.data;
                        this.graficar();
                    }
                ).catch(
                    error => {
                        alert("Error al obtener los datos");
                    }
                );
            },

            graficar() {

                Highcharts.chart('container', {
                    chart: {
                        type: 'bar'
                    },
                    title: {
                        text: 'Promedios de asignaturas por evaluación'
                    }   
                    ,
                    xAxis: {
                        //Materias
                        categories: this.datos.asignaturas,
                        title: {
                            text: null
                        }
                    },
                    yAxis: {
                        min: 0,
                        
                        labels: {
                            overflow: 'justify'
                        }
                    },
                    plotOptions: {
                        bar: {
                            dataLabels: {
                                enabled: true
                            }
                        }
                    },
                    legend: {
                        layout: 'vertical',
                        align: 'right',
                        verticalAlign: 'top',
                        x: -40,
                        y: 80,
                        floating: true,
                        borderWidth: 1,
                        backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) ||
                            '#FFFFFF'),
                        shadow: true
                    },
                    credits: {
                        enabled: false
                    },
                    series: this.datos.evaluaciones
                });


            }
        },
        created: function () {
            this.cargarDatos();
        }
    });
</script>