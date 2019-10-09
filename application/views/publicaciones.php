<div id="app">
    <div class="row">
        <div class="col-10">

        </div>
        <div class="col-2 p-3">
            <button class="btn btn-success" data-toggle="modal" data-target="#exampleModal" @click="nuevaPublicacion">
                Crear publicacion
            </button>
        </div>
        <div v-show="publicaciones.length != 0" class="row">
            <div v-for="p in publicaciones" class="card col-4">
                <img class="card-img-top" :src="p.imagen" :alt="p.titulo">
                <div class="card-body">
                    <h4 class="card-title">{{p.titulo}}</h4>
                    <p class="card-text">{{p.cuerpo}}</p>
                    <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" @click="editarPost(p)">Editar</a>
                    <a href="#" class="btn btn-danger" data-toggle="modal" data-target="#modalDelete" @click="copiarPublicacion(p)" >Eliminar</a>
                </div>
            </div>
        </div>
        <div v-show="publicaciones.length == 0" class="col-12">
            <div class="alert alert-warning text-center" role="alert">
                No hay publicaciones
            </div>
        </div>
    </div>
    <!-- Modal  -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 v-if="!editar" class="modal-title" id="exampleModalLabel">Nueva publicación</h5>
                    <h5 v-else class="modal-title" id="exampleModalLabel">Editar publicación</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="titulo">Título</label>
                        <input type="text" class="form-control" id="titulo" placeholder="Título" v-model="publicacion.titulo">
                    </div>
                    <div class="form-group">
                        <label for="titulo">Cuerpo</label>
                        <textarea name="" id="" cols="30" rows="10" class="form-control" v-model="publicacion.cuerpo"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="titulo">URL imagen</label>
                        <input type="text" class="form-control" id="titulo" placeholder="Imagen" v-model="publicacion.imagen">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button v-if="!editar" type="button" class="btn btn-primary" data-dismiss="modal" @click="postPosts">Crear
                        publicación</button>
                    <button v-else type="button" class="btn btn-primary" data-dismiss="modal" @click="putPost">Guardar
                        cambios</button>
                </div>
            </div>
        </div>
    </div>

     <!-- Modal  -->
     <div class="modal fade" id="modalDelete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
     <div class="modal-dialog" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="exampleModalLabel">Confirmar eliminación</h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
             </div>
             <div class="modal-body">
                <span class="text-center">¿Estás seguro de eliminar la publicación</span>
                <span> <b>{{publicacion.titulo}}?</b></span>
             </div>
             <div class="modal-footer">
                 <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                 <button type="button" class="btn btn-danger" data-dismiss="modal" @click="deletePost">Eliminar</button>
             </div>
         </div>
     </div>
 </div>
</div>
<script>
    let app = new Vue({
        el: '#app',
        data: {
            publicaciones: [],
            publicacion: {
                titulo: '',
                imagen: '',
                cuerpo: ''
            },
            editar: false
        },
        created: function () {
            this.getPosts();
        },
        methods: {
            postPosts() {
                var url = "<?=base_url()?>index.php/api/posts/posts";
                var data = {
                    titulo: this.publicacion.titulo,
                    cuerpo: this.publicacion.cuerpo,
                    imagen: this.publicacion.imagen
                };
                axios.post(url, data)
                    .then(response => {
                        console.log("Éxito en post de Posts");
                        this.getPosts();
                    }).catch(error => {
                        console.log("Error en post de Posts");
                    });
            },
            getPosts() {
                var url = "<?=base_url()?>index.php/api/posts/posts";
                axios.get(url)
                    .then(response => {
                        console.log("Éxito en get de Posts");
                        this.publicaciones = response.data;
                    }).catch(error => {
                        console.log("Error en get de Posts");
                    });
            },
            putPost() {
                var url = "<?=base_url()?>index.php/api/posts/posts/"+this.publicacion.id_post;
                let datos = {
                    imagen: this.publicacion.imagen,
                    titulo: this.publicacion.titulo,
                    cuerpo: this.publicacion.cuerpo
                }
                console.log(datos.titulo);
                axios.put(url,datos)
                    .then(response => {
                        console.log("Éxito al actualizar");
                        this.getPosts();
                    }).catch(error => {
                        console.log("");
                    });
            },
            deletePost(){
                var url = "<?=base_url()?>index.php/api/posts/posts/"+this.publicacion.id_post;
                axios.delete(url)
                    .then(response => {
                        console.log("Eliminado con exito");
                        this.getPosts();
                    }).catch(error => {
                        console.log("");
                    });
            },
            editarPost(publicacion) {
                this.publicacion = Object.assign({}, publicacion);
                this.editar = true;
            },
            nuevaPublicacion() {
                this.editar = false;
                this.publicacion = {
                    titulo: '',
                    imagen: '',
                    cuerpo: ''
                }
            },
            copiarPublicacion(publicacion){
                this.publicacion = Object.assign({}, publicacion);
            }
        }
    });
</script>