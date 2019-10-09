<div id="app" class="card">
    <div class="card-head">
        <h1 class="text-center">{{datos.nombre}}</h1>

        <h3 class="text-center">{{datos.convocatoria}}</h3>
    </div>

    <div class="card-body">
        <ol class="list-group">
            <li class="list-group-item m-4" v-for="a in datos.asignaturas">
                <div class="row ">
                    <div class="col-6 col-md-4  ">
                        <b>Asignatura: </b> {{a.asignatura}}
                    </div>
                    <div class="col-6 col-md-4 ">
                        <b>Curso: </b>{{a.curso}}
                    </div>
                   
                </div>
                <ul class="list-group">
                    <div v-if="a.grupos.length == 0" class="p-2">
                        <div class="wy-alert-neutral text-center">
                            No hay grupos asignados para la materia
                        </div>
                    </div>
                    <li v-for="g in a.grupos" class="list-group-item" v-else>
                        Grupo(s)
                        <br><br>
                        <div class="row">
                            <div class="col-12 col-md-10" style="border: 1px solid black">
                                <div> <b>Grupo: </b> {{g.grupo}}</div>
                                <div><b>Aula: </b>{{g.aula}}</div>
                            </div>
                            <div class="col-md-2 col-12">
                                <a :href="'<?=base_url()?>profesores/grupo/'+a.id_asignatura+'/'+g.id_grupo" class="btn btn-success">
                                    <i class="fa fa-eye"></i>
                                    Ver grupo
                                </a>
                            </div>
                        </div>
                    </li>
                </ul>
            </li>
        </ol>
    </div>
</div>
<script>
    let app = new Vue({
        el: '#app',
        data: {
            id_profesor: '<?=$id_profesor?>',
            datos: {}
        },
        mounted: function () {
            this.cargarDatos();
        },
        methods: {
            cargarDatos() {
                let url = "<?= base_url() ?>api/asignatura/materiasProfesor/" + this.id_profesor;
                axios.get(url).then(
                    response => {
                        this.datos = response.data;
                    }
                ).catch(
                    error => {
                        alert("Erro al cargar los datos");
                    }
                );
            }
        }
    });
</script>