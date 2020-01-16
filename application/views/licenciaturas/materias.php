.<div class="card" id="app">
    <div class="card-body">
        <h4 class="card-title">Agregar materias a las licenciaturas</h4>
        {{licenciaturas}}
    </div>
    <script>

        var app = new Vue({
            el: "#app",
            data: {
                licenciaturas: [],
                asignaturas: [],

            },
            created: function () {
                this.getlicenciaturas();
            },
            methods: {
                getlicenciaturas() {
                    //jovannyrch@gmail.com
                    axios.get(`<?=base_url()?>api/curso/curso`).then(response => {
                        this.licenciaturas = response.data;
                    }).catch(e => {
                        console.log(e);
                    })
                },
                getasignaturas() {
                    //jovannyrch@gmail.com
                    axios.get(`<?=base_url()?>/api/asignatura/asignatura`).then(response => {
                        this.asignaturas = response.data;
                    }).catch(e => {
                        console.log(e);
                    })
                }
            }
        })

    </script>
</div>