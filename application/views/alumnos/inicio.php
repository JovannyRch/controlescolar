<div id="app">

    <center>
        <div class="csslider infinity" id="slider1">

            <input type="radio" name="slides" checked="checked" id="slides_x" />
            <input type="radio" name="slides" :id="'slides_'+index" v-for="(p,index) in publicaciones" />
            <ul>
                <li>
                    <br><br><br><br>

                    <h1 class="text-center">Bienvenido</h1>
                  
                    <h1 class="text-center">
                        <?= $this->session->userdata('nombre');?>
                        <?= $this->session->userdata('apellido_paterno');?>
                        <?= $this->session->userdata('apellido_materno');?>
                    </h1>
                    <h1 class="text-center">al Sistema de Control Escolar</h1>

                </li>

                <li class="scrollable" v-for="p in publicaciones">

                    <img :src="p.imagen" class="imagen">
                    <h1 style="padding-left: 3%">{{p.titulo}}</h1>
                    <p>
                        {{p.cuerpo}}
                    </p>
                </li>

            </ul>
            <div class="arrows">
                <label for="slides_x"></label>
                <label :for="'slides_'+index" v-for="(p,index) in publicaciones"></label>

                <label class="goto-first" for="slides_x"></label>
                <label class="goto-last" :for="'slides_'+last_index"></label>
            </div>
            <div class="navigation">
                <div>
                    <label for="slides_x"></label>
                    <label :for="'slides_'+index" v-for="(p,index) in publicaciones"></label>

                </div>
            </div>
        </div>
    </center>

</div>
<script>
    let app = new Vue({
        el: '#app',
        data: {
            publicaciones: [],
            last_index: 2
        },
        created: function () {
            this.getPosts();
        },
        methods: {

            getPosts() {
                var url = "<?=base_url()?>index.php/api/posts/posts";
                axios.get(url)
                    .then(response => {
                        console.log("Éxito en get de Posts");
                        this.publicaciones = response.data;
                        this.last_index = this.publicaciones.length - 1;
                    }).catch(error => {
                        console.log("Error en get de Posts");
                    });
            }
        }
    });
</script>
<style>
    .csslider {
        -moz-perspective: 1300px;
        -ms-perspective: 1300px;
        -webkit-perspective: 1300px;
        perspective: 1300px;
        display: inline-block;
        text-align: left;
        position: relative;
        margin-bottom: 22px;
    }

    .csslider>input {
        display: none;
    }

    .csslider>input:nth-of-type(10):checked~ul li:first-of-type {
        margin-left: -900%;
    }

    .csslider>input:nth-of-type(9):checked~ul li:first-of-type {
        margin-left: -800%;
    }

    .csslider>input:nth-of-type(8):checked~ul li:first-of-type {
        margin-left: -700%;
    }

    .csslider>input:nth-of-type(7):checked~ul li:first-of-type {
        margin-left: -600%;
    }

    .csslider>input:nth-of-type(6):checked~ul li:first-of-type {
        margin-left: -500%;
    }

    .csslider>input:nth-of-type(5):checked~ul li:first-of-type {
        margin-left: -400%;
    }

    .csslider>input:nth-of-type(4):checked~ul li:first-of-type {
        margin-left: -300%;
    }

    .csslider>input:nth-of-type(3):checked~ul li:first-of-type {
        margin-left: -200%;
    }

    .csslider>input:nth-of-type(2):checked~ul li:first-of-type {
        margin-left: -100%;
    }

    .csslider>input:nth-of-type(1):checked~ul li:first-of-type {
        margin-left: 0%;
    }

    .csslider>ul {
        position: relative;
        width: 820px;
        height: 420px;
        z-index: 1;
        font-size: 0;
        line-height: 0;
        border: 10px;
        margin: 0 auto;
        padding: 0;
        overflow: hidden;
        white-space: nowrap;
        -moz-box-sizing: border-box;
        -webkit-box-sizing: border-box;
        box-sizing: border-box;
    }

    .csslider>ul>li {
        position: relative;
        display: inline-block;
        width: 100%;
        height: 100%;
        overflow: hidden;
        font-size: 15px;
        font-size: initial;
        line-height: normal;
        -moz-transition: all 0.5s cubic-bezier(0.4, 1.3, 0.65, 1);
        -o-transition: all 0.5s ease-out;
        -webkit-transition: all 0.5s cubic-bezier(0.4, 1.3, 0.65, 1);
        transition: all 0.5s cubic-bezier(0.4, 1.3, 0.65, 1);
        vertical-align: top;
        -moz-box-sizing: border-box;
        -webkit-box-sizing: border-box;
        box-sizing: border-box;
        white-space: normal;
    }

    .csslider>ul>li.scrollable {
        overflow-y: scroll;
    }

    .csslider>.navigation {
        position: absolute;
        bottom: -8px;
        left: 50%;
        z-index: 10;
        margin-bottom: -10px;
        font-size: 0;
        line-height: 0;
        text-align: center;
        -webkit-touch-callout: none;
        -webkit-user-select: none;
        -khtml-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    .csslider>.navigation>div {
        margin-left: -100%;
    }

    .csslider>.navigation label {
        position: relative;
        display: inline-block;
        cursor: pointer;
        border-radius: 50%;
        margin: 0 4px;
        padding: 4px;
        background: #3A3A3A;
    }

    .csslider>.navigation label:hover:after {
        opacity: 1;
    }

    .csslider>.navigation label:after {
        content: '';
        position: absolute;
        left: 50%;
        top: 50%;
        margin-left: -6px;
        margin-top: -6px;
        background: #71ad37;
        border-radius: 50%;
        padding: 6px;
        opacity: 0;
    }

    .csslider>.arrows {
        -webkit-touch-callout: none;
        -webkit-user-select: none;
        -khtml-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    .csslider.inside .navigation {
        bottom: 10px;
        margin-bottom: 10px;
    }

    .csslider.inside .navigation label {
        border: 1px solid #7e7e7e;
    }

    .csslider>input:nth-of-type(1):checked~.navigation label:nth-of-type(1):after,
    .csslider>input:nth-of-type(2):checked~.navigation label:nth-of-type(2):after,
    .csslider>input:nth-of-type(3):checked~.navigation label:nth-of-type(3):after,
    .csslider>input:nth-of-type(4):checked~.navigation label:nth-of-type(4):after,
    .csslider>input:nth-of-type(5):checked~.navigation label:nth-of-type(5):after,
    .csslider>input:nth-of-type(6):checked~.navigation label:nth-of-type(6):after,
    .csslider>input:nth-of-type(7):checked~.navigation label:nth-of-type(7):after,
    .csslider>input:nth-of-type(8):checked~.navigation label:nth-of-type(8):after,
    .csslider>input:nth-of-type(9):checked~.navigation label:nth-of-type(9):after,
    .csslider>input:nth-of-type(10):checked~.navigation label:nth-of-type(10):after,
    .csslider>input:nth-of-type(11):checked~.navigation label:nth-of-type(11):after {
        opacity: 1;
    }

    .csslider>.arrows {
        position: absolute;
        left: -31px;
        top: 50%;
        width: 100%;
        height: 26px;
        padding: 0 31px;
        z-index: 0;
        -moz-box-sizing: content-box;
        -webkit-box-sizing: content-box;
        box-sizing: content-box;
    }

    .csslider>.arrows label {
        display: none;
        position: absolute;
        top: -50%;
        padding: 13px;
        box-shadow: inset 2px -2px 0 1px #3A3A3A;
        cursor: pointer;
        -moz-transition: box-shadow 0.15s, margin 0.15s;
        -o-transition: box-shadow 0.15s, margin 0.15s;
        -webkit-transition: box-shadow 0.15s, margin 0.15s;
        transition: box-shadow 0.15s, margin 0.15s;
    }

    .csslider>.arrows label:hover {
        box-shadow: inset 3px -3px 0 2px #71ad37;
        margin: 0 0px;
    }

    .csslider>.arrows label:before {
        content: '';
        position: absolute;
        top: -100%;
        left: -100%;
        height: 300%;
        width: 300%;
    }

    .csslider.infinity>input:first-of-type:checked~.arrows label.goto-last,
    .csslider>input:nth-of-type(1):checked~.arrows>label:nth-of-type(0),
    .csslider>input:nth-of-type(2):checked~.arrows>label:nth-of-type(1),
    .csslider>input:nth-of-type(3):checked~.arrows>label:nth-of-type(2),
    .csslider>input:nth-of-type(4):checked~.arrows>label:nth-of-type(3),
    .csslider>input:nth-of-type(5):checked~.arrows>label:nth-of-type(4),
    .csslider>input:nth-of-type(6):checked~.arrows>label:nth-of-type(5),
    .csslider>input:nth-of-type(7):checked~.arrows>label:nth-of-type(6),
    .csslider>input:nth-of-type(8):checked~.arrows>label:nth-of-type(7),
    .csslider>input:nth-of-type(9):checked~.arrows>label:nth-of-type(8),
    .csslider>input:nth-of-type(10):checked~.arrows>label:nth-of-type(9),
    .csslider>input:nth-of-type(11):checked~.arrows>label:nth-of-type(10) {
        display: block;
        left: 0;
        right: auto;
        -moz-transform: rotate(45deg);
        -ms-transform: rotate(45deg);
        -o-transform: rotate(45deg);
        -webkit-transform: rotate(45deg);
        transform: rotate(45deg);
    }

    .csslider.infinity>input:last-of-type:checked~.arrows label.goto-first,
    .csslider>input:nth-of-type(1):checked~.arrows>label:nth-of-type(2),
    .csslider>input:nth-of-type(2):checked~.arrows>label:nth-of-type(3),
    .csslider>input:nth-of-type(3):checked~.arrows>label:nth-of-type(4),
    .csslider>input:nth-of-type(4):checked~.arrows>label:nth-of-type(5),
    .csslider>input:nth-of-type(5):checked~.arrows>label:nth-of-type(6),
    .csslider>input:nth-of-type(6):checked~.arrows>label:nth-of-type(7),
    .csslider>input:nth-of-type(7):checked~.arrows>label:nth-of-type(8),
    .csslider>input:nth-of-type(8):checked~.arrows>label:nth-of-type(9),
    .csslider>input:nth-of-type(9):checked~.arrows>label:nth-of-type(10),
    .csslider>input:nth-of-type(10):checked~.arrows>label:nth-of-type(11),
    .csslider>input:nth-of-type(11):checked~.arrows>label:nth-of-type(12) {
        display: block;
        right: 0;
        left: auto;
        -moz-transform: rotate(225deg);
        -ms-transform: rotate(225deg);
        -o-transform: rotate(225deg);
        -webkit-transform: rotate(225deg);
        transform: rotate(225deg);
    }

    /*#region MODULES */
    /*#endregion */
    /*___________________________________ LAYOUT ___________________________________ */
    @font-face {
        font-family: 'Lato';
        font-style: normal;
        font-weight: 400;
        src: local('Lato Regular'), local('Lato-Regular'), url(https://fonts.gstatic.com/s/lato/v14/S6uyw4BMUTPHjx4wWw.ttf) format('truetype');
    }

    @font-face {
        font-family: 'Raleway';
        font-style: normal;
        font-weight: 400;
        src: local('Raleway'), local('Raleway-Regular'), url(https://fonts.gstatic.com/s/raleway/v12/1Ptug8zYS_SKggPNyC0ISg.ttf) format('truetype');
    }

    @font-face {
        font-family: 'Raleway';
        font-style: normal;
        font-weight: 700;
        src: local('Raleway Bold'), local('Raleway-Bold'), url(https://fonts.gstatic.com/s/raleway/v12/1Ptrg8zYS_SKggPNwJYtWqZPBQ.ttf) format('truetype');
    }

    ::-webkit-scrollbar {
        width: 2px;
        background: rgba(190, 23, 23, 0.1);
    }

    ::-webkit-scrollbar-track {
        background: none;
    }

    ::-webkit-scrollbar-thumb {
        background: rgba(74, 168, 0, 0.6);
    }

    #slider1 {
        font-family: 'Lato';
    }

    #slider1>input:nth-of-type(3):checked~ul #bg {
        width: 80%;
        padding: 22px;
        -moz-transition: 0.5s 0.5s;
        -o-transition: 0.5s 0.5s;
        -webkit-transition: 0.5s 0.5s;
        transition: 0.5s 0.5s;
    }

    #slider1>input:nth-of-type(3):checked~ul #bg div {
        -moz-transform: translate(0);
        -ms-transform: translate(0);
        -o-transform: translate(0);
        -webkit-transform: translate(0);
        transform: translate(0);
        -moz-transition: 0.5s 0.9s;
        -o-transition: 0.5s 0.9s;
        -webkit-transition: 0.5s 0.9s;
        transition: 0.5s 0.9s;
    }

    #slider1>input:nth-of-type(6):checked~ul #dex-sign {
        -moz-animation: sign-anim 3.5s 0.5s steps(85) forwards;
        -o-animation: sign-anim 3.5s 0.5s steps(85) forwards;
        -webkit-animation: sign-anim 3.5s 0.5s steps(85) forwards;
        animation: sign-anim 3.5s 0.5s steps(85) forwards;
    }

    #bg {
        color: #000;
        padding: 22px 0;
        position: absolute;
        left: 0;
        top: 16%;
        height: 20%;
        width: 0;
        z-index: 10;
        overflow: hidden;
    }

    #bg:before {
        content: '';
        position: absolute;
        left: -1px;
        top: 1px;
        height: 100%;
        width: 100%;
        z-index: -1;
        background: url(https://raw.github.com/drygiel/csslider/master/examples/themes/fruit.jpg) 1px 23%;
        -webkit-filter: blur(7px);
    }

    #bg:after {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        height: 100%;
        width: 100%;
        z-index: 20;
        background: rgba(0, 0, 0, 0.35);
        pointer-events: none;
    }

    #bg div {
        -moz-transform: translate(120%);
        -ms-transform: translate(120%);
        -o-transform: translate(120%);
        -webkit-transform: translate(120%);
        transform: translate(120%);
    }

    .scrollable p {
        padding: 30px;
        text-align: justify;
        line-height: 140%;
        font-size: 120%;
    }

    #center {
        text-align: center;
        margin-top: 25%;
    }

    #center a {
        text-decoration: none;
        text-transform: uppercase;
        letter-spacing: 2px;
        font-variant: small-caps;
    }

    /*___________________________________ LINK ___________________________________ */
    a.nice-link {
        position: relative;
        color: #71ad37;
    }

    h1 a.nice-link:after {
        border-bottom: 1px solid #a5ff0e;
    }

    a.nice-link:after {
        text-align: justify;
        display: inline-block;
        content: attr(data-text);
        position: absolute;
        left: 0;
        top: 0;
        white-space: nowrap;
        overflow: hidden;
        color: #a5ff0e;
        min-height: 100%;
        width: 0;
        max-width: 100%;
        background: #3A3A3A;
        -moz-transition: 0.3s;
        -o-transition: 0.3s;
        -webkit-transition: 0.3s;
        transition: 0.3s;
    }

    a.nice-link:hover {
        color: #71ad37;
    }

    a.nice-link:hover:after {
        width: 100%;
    }

    /*___________________________________ SIGN ___________________________________ */
    #dex-sign {
        width: 255px;
        height: 84px;
        position: absolute;
        left: 33%;
        top: 45%;
        opacity: 0.7;
        background: url(http://www.drygiel.com/projects/sign/frames-255-white.png) 0 0 no-repeat;
    }

    #dex-sign:hover {
        opacity: 1;
        -webkit-filter: invert(30%) brightness(80%) sepia(100%) contrast(110%) saturate(953%) hue-rotate(45deg);
    }

    @-webkit-keyframes sign-anim {
        to {
            background-position: 0 -7140px;
        }
    }

    @-moz-keyframes sign-anim {
        to {
            background-position: 0 -7140px;
        }
    }

    @keyframes sign-anim {
        to {
            background-position: 0 -7140px;
        }
    }

    .imagen {
        display: block;
        margin-left: auto;
        margin-right: auto;
        width: 40%;
    }
</style>