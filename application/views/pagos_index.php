<div class="card" id="app">
    <div class="card-body">
        <h4 class="card-title text-center">Pagos</h4>
        <div class="row">
            <div class="col-sm-12 col-md-6">
                <div class="form-group">
                    <label for="">Seleccione alumno</label>
                    <select class="form-control" name="" >
                        <option :value="a.id"  v-for="a in alumnos"> {{a.nombre}} {{a.paterno}} {{a.materno}}</option>
                    </select>
                </div>

            </div>

            <div class="col-sm-12 col-md-6">
                <div class="form-group">
                    <label for="">Introduzca monto</label>
                    <input type="number" class="form-control" name="" id="" aria-describedby="helpId" placeholder="">
                </div>
            </div>

            <div class="col-sm-12 text-center">

                <button class="btn btn-success">Registrar pago</button>

                </div>

        </div>
    </div>
</div>

<script>

    var app = new Vue({
        el: "#app",
        data: {
            alumnos: []
        },
        created: function(){
            this.getAlumnos();
        },
        methods: {
            getAlumnos(){

            }
        }
    })

</script>