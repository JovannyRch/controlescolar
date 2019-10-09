<div id="appReporteGrupo">
    <div id="grafica1" style="height: 50rem; margin: 0 auto;" >

    </div>
</div>




<script src="<?=base_url()?>js/highcharts.js"></script>
<script src="<?=base_url()?>js/series-label.js"></script>
<script src="<?=base_url()?>js/exporting.js"></script>
<script src="<?=base_url()?>js/export-data.js"></script>

<script>
    let appReporteGrupo = new Vue({
        el: "#appReporteGrupo",
        data: {
            datos: {},
            bandera: false

        },
        created: function () {
            this.obtenerDatos();
        },
        methods: {

            obtenerDatos() {
                let url = "<?= base_url()?>api/reportes/grupoMaterias/<?=$id_grupo?>";
                axios.get(url).then(
                    response => {
                        this.datos = response.data;
                        this.graficar();
                        this.bandera = true;
                    }).catch(
                    error => {
                        alert("No se encontraron registros");
                    }
                );
            },

            calcularLargo(alumnos){
                let x = (alumnos*10)+"rem";
                return "height: "+x;
            }
            ,

            graficar() {

                Highcharts.chart('grafica1', {
                    chart: {
                        type: 'bar'
                    },
                    title: {
                        text: this.datos.convocatoria
                    },
                    subtitle: {
                        text: 'Grupo: '+this.datos.grupo+",   Promedio Grupal: "+this.datos.promedioGrupo
                    },
                    xAxis: {
                        categories: this.datos.materias,
                        title: {
                            text: 'Materias'
                        }
                    },
                    yAxis: {
                        min: 0,
                        title: {
                            text: this.datos.cantidad+' materias'
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
                        name: 'Promedio por materias',
                        data: this.datos.calificaciones
                    }]
                });
            }
        }
    });
</script>