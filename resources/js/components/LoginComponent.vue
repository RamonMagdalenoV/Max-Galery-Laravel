<template>
    <form class="uk-form-horizontal uk-margin-medium">
        <div class="uk-margin">
            <label for="email" class="uk-form-label">Correo Electrónico</label>

            <div class="uk-form-controls">
                <input type="email" v-model="campos.email" class="uk-input" id="email" placeholder="Ingresa tu email">
                <span  v-if="email_message !== 'Default Message'" style="font-size: 13px; color: red;">
                    <strong>{{ email_message }}</strong>
                </span>
            </div>


        </div>

        <div class="uk-margin">
            <label for="password" class="uk-form-label">Contraseña</label>

            <div class="uk-form-controls">
                <input type="password" id="password" v-model="campos.password" class="uk-input" placeholder="Ingresa tu clave">
                <span v-if="password_message !== 'Default Message'" style="font-size: 13px; color: red;">
                    <strong>{{ password_message }}</strong>
                </span>
            </div>


        </div>

        <div class="uk-margin d-flex justify-content-end">
            <vk-button type="primary" @click="IniciarSesion()">Ingresar</vk-button>
        </div>
    </form>
</template>

<script>
    export default {
        data(){
            return{
                email_message: 'Default Message',
                password_message: 'Default Message',
                errors: [],
                campos: {
                    email: '',
                    password: '',
                }
            }
        },
        methods:{
            IniciarSesion: function () {
                console.log('Iniciar Sesión');
                this.email_message = 'Default Message';
                this.password_message = 'Default Message';
                axios.post('/login', this.campos).then(function (response) {
                    window.location.href = '/';
                }).catch( error => {
                    let err = error.response.data.errors;
                    if(err.hasOwnProperty('email'))
                        this.email_message = err.email[0];
                    else if(err.hasOwnProperty('password'))
                        this.password_message = err.password[0];

                });
            }
        }
    }
</script>
