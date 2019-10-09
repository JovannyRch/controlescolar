<div id="app">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-success">
                <h4 class="card-title ">Padres</h4>
                <div class="row">
                    <div class="col-md-8">

                    </div>
                    <div class="col-md-4">
                        <div class="input-group no-border">
                            <button class="btn btn-white btn-round btn-just-icon" data-toggle="modal" data-target="#exampleModal">
                                <i class="fa fa-search"></i>
                                <div class="ripple-container"></div>
                            </button>
                            <input type="text" value="" class="form-control" v-model="buscador" placeholder="Buscar padre...">
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
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
                                    Teléfono
                                </th>
                                <th>
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="usuario in filtrar">
                                <td v-text="usuario.nombre"></td>
                                <td v-text="usuario.apellido_paterno"></td>
                                <td v-text="usuario.apellido_materno"></td>
                                <td v-text="usuario.telefono"></td>
                                <td>
                                    <a :href="baseURL+usuario.id_usuario">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <i class="fa fa-edit"></i>
                                    <i class="fa fa-trash"></i>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

</div>
<script>
    var app = new Vue({
        el: "#app",
        data: {
            saludo: ":)",
            usuarios: [],
            buscador: "",
            baseURL: "<?= site_url('profesores/ver')?>/"
        },
        created: function () {
            this.getData();
        },
        methods: {
            getData() {
                var url = "<?=base_url()?>" + "index.php/usuarios_api/padres";
                axios.get(url).then(
                    response => {
                        this.usuarios = response.data;
                    }
                ).catch(
                    error => {
                        //alert('Error');
                    }
                );
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
                            .toString()).toLowerCase().includes(
                            this.buscador
                            .toLowerCase());
                    });
                }
            }

        }
    });
</script>