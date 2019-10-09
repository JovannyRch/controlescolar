</div>
        </div>
    </div>
</div>
<script>
let sistema = new Vue({
    el: '#sistema',
    data: {
        mensajesSinLeer: 0
    },
    mounted: function(){
        this.getMensajesSinLeer();
    },
    methods: {
        getMensajesSinLeer(){
            axios.get("<?=base_url()?>api/usuarios_api/mensajesNoLeidos/<?= $this->session->userdata('id_usuario');?>" ).then(
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
});</script>

<script src="<?=base_url()?>vendor/jquery/jquery.min.js"></script>
<script src="<?=base_url()?>vendor/popper.js/popper.min.js"></script>
<script src="<?=base_url()?>vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="<?=base_url()?>vendor/chart.js/chart.min.js"></script>
<script src="<?=base_url()?>js/carbon.js"></script>
<script src="<?=base_url()?>js/demo.js"></script>

</body>
</html>
