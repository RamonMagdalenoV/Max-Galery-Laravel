<template xmlns:v="http://www.w3.org/1999/xhtml">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-xl-10 col-sm-10">
            <div class="card border-primary">
                <div class="card-header bg-primary  text-white d-flex justify-content-between">
                    <span>Lista de Usuarios</span>
                    <vk-button class="uk-margin-small-right" type="secondary" size="small" @click="magregar = true; title_message = 'Almacenar Usuario'; button_message ='Guardar'; password_label = 'Contraseña'; clearForm()">Nuevo Usuario</vk-button>
                </div>
                <div class="card-body">
                    <div class="uk-overflow-auto">
                        <!-- Tabla Usuarios -->
                        <table class="uk-table uk-table-hover uk-table-divider">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Email</th>
                                    <th>Tipo</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="usuario in usuarios" v:bind="usuario.id">
                                    <td v-text="usuario.name"></td>
                                    <td v-text="usuario.email"></td>
                                    <td><vk-label type="success">{{ usuario.type }}</vk-label></td>
                                    <td class="d-flex justify-content-center">
                                        <a class="uk-button"  @click="magregar = true; loadData(usuario); password_label = 'Nueva Contraseña (Dejar en blanco si no requiere cambiar la contraseña)'" title="Editar"><vk-icon icon="file-edit"></vk-icon></a>
                                        <a class="uk-button" @click.prevent="meliminar = true; campos.id = usuario.id; title_message = 'Eliminar Usuario'; button_message='Eliminar'" title="Eliminar"><vk-icon icon="trash"></vk-icon></a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        </div>

        <!-- Modal Agregar / Editar -->
        <vk-modal :show.sync="magregar">
            <vk-modal-close @click="magregar = false"></vk-modal-close>
            <vk-modal-title>{{ title_message }}</vk-modal-title>
            <!-- Form -->
            <div class="uk-margin">
                <label class="uk-form-label" for="name">Nombre</label>
                <div class="uk-form-controls">
                    <input class="uk-input" v-model="campos.name" id="name" type="text" placeholder="Ingresa un nombre">
                    <span  v-if="name_message !== 'Default Message'" style="font-size: 13px; color: red;">
                        <strong>{{ name_message }}</strong>
                    </span>
                </div>
            </div>

            <div class="uk-margin">
                <label class="uk-form-label" for="email">Correo Electrónico</label>
                <div class="uk-form-controls">
                    <input class="uk-input" v-model="campos.email" id="email" type="email" placeholder="Ingresa un email">
                    <span  v-if="email_message !== 'Default Message'" style="font-size: 13px; color: red;">
                        <strong>{{ email_message }}</strong>
                    </span>
                </div>
            </div>

            <div class="uk-margin">
                <label class="uk-form-label" for="type">Tipo de Usuario</label>
                <div class="uk-form-controls">
                    <select class="uk-select" id="type" v-model="campos.type">
                        <option selected>Administrador</option>
                        <option>Normal</option>
                    </select>
                </div>
            </div>

            <div class="uk-margin">
                <label class="uk-form-label" for="password">{{ password_label }}</label>
                <div class="uk-form-controls">
                    <input class="uk-input" v-model="campos.password" id="password" type="password" placeholder="Ingresa una clave">
                    <span  v-if="password_message !== 'Default Message'" style="font-size: 13px; color: red;">
                        <strong>{{ password_message }}</strong>
                    </span>
                </div>
            </div>

            <div class="uk-margin" v-if="button_message === 'Guardar'">
                <label class="uk-form-label" for="password-confirm">Confirmar Contraseña</label>
                <div class="uk-form-controls">
                    <input class="uk-input" v-model="campos.password_confirmation" id="password-confirm" type="password" placeholder="Ingresa una clave">
                </div>
            </div>
            <!-- Buttons -->
            <p class="uk-text-right">
                <vk-button @click="magregar = false" class="uk-margin-small-right">Cancelar</vk-button>
                <vk-button type="primary" @click="(button_message === 'Guardar') ? addUsers() : updateUser();">{{ button_message }}</vk-button>
            </p>
        </vk-modal>

        <!-- Modal Eliminar -->
        <vk-modal :show.sync="meliminar">
            <vk-modal-close @click="meliminar = false"></vk-modal-close>
            <vk-modal-title>{{ title_message }}</vk-modal-title>
            <!-- Content -->
            <p style="font-size: 14px; color: darkred;">¿Desea eliminar el registro seleccionado?</p>
            <!-- Buttons -->
            <p class="uk-text-right">
                <vk-button @click="meliminar = false" class="uk-margin-small-right">Cancelar</vk-button>
                <vk-button type="primary" @click="deleteUser(campos.id)">{{ button_message }}</vk-button>
            </p>
        </vk-modal>
    </div>
</template>

<script>
    export default {
        data(){
            return{
                campos: {
                    id: null,
                    name: '',
                    email: '',
                    type: '',
                    password: '',
                    password_confirmation: ''
                },
                usuarios: [],
                data: [],
                success : null,
                title_message: '',
                button_message: '',
                password_message: 'Default Message',
                email_message: 'Default Message',
                name_message: 'Default Message',
                password_label: 'Contraseña',
                magregar: false,
                meliminar: false
            }
        },
        created: function () {
            this.getUsers();
        },
        methods: {
            getUsers(){
                axios.get('/usuarios').then( response => {
                    this.usuarios = response.data;
                });
            },
            addUsers(){
                let me = this;
                me.clearMessages();
                axios.post('/registrar/usuario', this.campos).then( response => {
                    me.clearForm();
                    me.magregar = false;
                    me.getUsers();
                    me.$notify({title : 'Acción', message : 'Usuario agregado correctamente!', type : 'success'});
                }).catch( error => {
                    let err = error.response.data.errors;
                    if(err.hasOwnProperty('name')){
                        me.name_message = err.name[0];
                    }else if(err.hasOwnProperty('email')){
                        me.email_message = err.email[0];
                    }else if(err.hasOwnProperty('password')){
                        me.password_message = err.password[0];
                    }
                });
            },
            deleteUser(id){
                let me = this;
                axios.delete('eliminar/usuario/'+id).then(response => {
                    me.meliminar = false;
                    me.getUsers();
                    me.$notify({title : 'Acción', message : 'Usuario eliminado correctamente!', type : 'success'});
                });
            },
            updateUser(){
              let me  = this;
              me.clearMessages();

              axios.put('/actualizar/usuario', me.campos).then(response => {
                me.magregar = false;
                me.clearForm();
                me.$notify({title : 'Acción', message : 'Usuario actualizado correctamente!', type : 'success'});
                me.getUsers();
              }).catch(error => {
                  let err = error.response.data.errors;
                  if(err.hasOwnProperty('name')){
                      me.name_message = err.name[0];
                  }else if(err.hasOwnProperty('email')){
                      me.email_message = err.email[0];
                  }
              });
            },
            clearForm(){
                let me = this;
                me.clearMessages();
                me.campos.name = '';
                me.campos.email = '';
                me.campos.type = 'Administrador';
                me.campos.password = '';
                me.campos.password_confirmation = '';
            },
            loadData(usuario){
                let me = this;
                me.title_message = 'Edición de Usuario';
                me.button_message = 'Editar';
                me.clearMessages();
                me.campos.id = usuario.id;
                me.campos.name = usuario.name;
                me.campos.email = usuario.email;
                me.campos.type = usuario.type;
                me.campos.password = '';
                me.magregar = true;
            },
            clearMessages(){
                this.password_message = 'Default Message';
                this.name_message = 'Default Message';
                this.email_message = 'Default Message';
            }
        }
    }
</script>
