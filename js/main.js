

let sistema = new Vue({
    el: '#sistema',
    data: {
        mensajesSinLeer: -1
    },
    mounted: function(){
        this.getMensajesSinLeer();
    },
    methods: {
        getMensajesSinLeer(){
            axios.get("<?=base_url()?>api/usuarios_api/mensajesNoLeidos/42" ).then(
                response => {
                    this.mensajesSinLeer = response.data;
                }
            ).catch(
                error => {
                    console.log("error al obtner mensajes sin leer")
                }
            );
        }
    }
});