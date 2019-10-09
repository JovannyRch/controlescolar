<div id="cursos">
        <div class="card">
            <div class="card-title">
                    <h2 class="text-center p-3">{{curso}}</h2>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4"><b>{{convocatoria}}</b></div>
                    <div class="col-md-4">Grupo: <b>{{grupo}}</b></div>
                    <div class="col-md-4">Aula: <b>{{aula}}</b></div>
                    
                    <table class="table table-striped" style="margin-top: 3%" >
                        <thead>
                            <th>#</th>
                            <th>Asignatura</th>
                            <th>Profesor</th>
                            <th></th>
                        </thead>
                        <tbody>
                            <tr v-for="(m,index) in materias">
                                <td style="width: 3%">{{index + 1}}</td>
                                <td>{{m.nombre}}</td>
                                <td>{{m.profesor}}</td>
                                <td>
                                    <button class="btn btn-primary btn-rounded">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
</div>    
    <script>
        let convocatoria = '<?= $convocatoria ?>';
        let grupo = '<?= $grupo?>';
        let aula = '<?= $aula?>';
        let curso = '<?= $curso ?>';
        let materias = JSON.parse('<?= json_encode($materias) ?>');
        let cursos = new Vue(
            {
                el: '#cursos',
                data: {
                    convocatoria: convocatoria,
                    grupo: grupo,
                    aula: aula,
                    curso: curso,
                    materias: materias
                },
                methods: {
                    getCursos(){
                        
                    }
                },
                created: {
    
                }
            }
        );
    </script>