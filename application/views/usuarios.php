<div id="app">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-light">
                <div class="row">
                    <div class="col-md-5">Usuarios</div>
                    <input type="text" v-model="buscador" placeholder="Buscador usuarios" class="form-control col-md-3">
                    <div class="col-md-4">
                        <a href="<?= base_url('usuarios/registro');?>" class="btn btn-success">
                            <i class="fa fa-user-plus"></i> Registrar Usuario
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>
                                    Tipo Usuario
                                </th>
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
                                <td v-text="getTipo(usuario.id_tipo_usuario)"></td>
                                <td v-text="usuario.nombre"></td>
                                <td v-text="usuario.apellido_paterno"></td>
                                <td v-text="usuario.apellido_materno"></td>
                                <td v-text="usuario.telefono"></td>
                                <td>
                                    <a class="btn btn-outline-success" :href="urlVer+usuario.id_usuario">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <a class="btn btn-outline-warning" :href="urlEditar+usuario.id_usuario">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <button class="btn btn-outline-danger" @click="eliminar(usuario.id_usuario)">
                                        <i class="fa fa-trash"></i>
                                    </button>
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
            urlEditar: "<?= site_url('usuarios/editar');?>/",
            urlVer: "<?= site_url('usuarios/ver');?>/",
            usuarios: [],
            buscador: ""
        },
        created: function () {
            this.getData();
        },
        methods: {
            getTipo(tipo) {
                if (tipo === "1") return "ADMINISTRADOR";
                if (tipo === "2") return "PROFESOR";
                if (tipo === "3") return "PADRE";
                if (tipo === "4") return "ALUMNO";
            },
            getData() {
                var url = "<?=base_url()?>" + "index.php/usuarios_api/usuarios";
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
            eliminar(id) {
                var respuesta = confirm("Confirmar eliminación");
                if (respuesta) {
                    var url = "<?=base_url()?>" + "index.php/usuarios_api/usuarios/" + id;
                    axios.delete(url).then(
                        response => {
                            this.getData();
                        }
                    ).catch(
                        error => {
                            alert("Error al eliminar")
                        }
                    );
                }
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
</script>