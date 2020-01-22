<template>
    <div class="container">
        <div class="row justify-content-center">

            <div class="col-xl-10 col-md-10 col-sm-10">

                <div class="card border-primary">

                    <div class="card-header bg-primary  text-white d-flex justify-content-between">
                        <span>Lista de Proveedores</span>
                        <vk-button class="uk-margin-small-right" @click="openModalAdd(); clearForm();" type="secondary" size="small">
                            Nuevo Proveedor
                        </vk-button>
                    </div>

                    <div class="card-body">

                        <div class="uk-overflow-auto">
                            <!--  Tabla proveedores -->
                            <table class="uk-table uk-table-hover uk-table-divider">
                                <thead>
                                    <tr>
                                       <th v-for="th in thead">
                                           {{ th }}
                                       </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr v-for="provider in providers" v:bind="provider.id">
                                        <td>{{ provider.name }}</td>
                                        <td>{{ provider.company }}</td>
                                        <td>{{ provider.address }}</td>
                                        <td>{{ provider.city }}</td>
                                        <td>{{ provider.phone }}</td>
                                        <td>{{ provider.email }}</td>
                                        <td class="d-flex justify-content-center">
                                            <a class="uk-button"  @click="loadData(provider)" title="Editar"><vk-icon icon="file-edit"></vk-icon></a>
                                            <a class="uk-button" @click.prevent="meliminar = true; fields.id = provider.id; title_message = 'Eliminar Proveedor'; button_message= 'Eliminar'" title="Eliminar"><vk-icon icon="trash"></vk-icon></a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal agregar / Editar -->
        <vk-modal :show.sync="magregar">
            <vk-modal-close @click="magregar = false"></vk-modal-close>
            <vk-modal-title>{{ title_message }}</vk-modal-title>
            <!-- Content Form -->
            <div class="uk-margin">
                <label for="name" class="uk-form-label">Nombre</label>
                <input type="text" class="uk-input" id="name" v-model="fields.name" placeholder="Ingresa nombre">
                <span v-if="errors.name_error !== ''" style="font-size: 13px; color: red;">
                    <strong>{{ errors.name_error }}</strong>
                </span>
            </div>

            <div class="uk-margin">
                <label for="company" class="uk-form-label">Empresa</label>
                <input type="text" class="uk-input" id="company" v-model="fields.company" placeholder="Ingresa el nombre de la empresa">
                <span v-if="errors.company_error !== ''" style="font-size: 13px; color: red;">
                    <strong>{{ errors.company_error }}</strong>
                </span>
            </div>

            <div class="uk-margin">
                <label for="address" class="uk-form-label">Dirección</label>
                <input type="text" class="uk-input" id="address" v-model="fields.address" placeholder="Ingresa una dirección">
                <span v-if="errors.address_error !== ''" style="font-size: 13px; color: red;">
                    <strong>{{ errors.address_error }}</strong>
                </span>
            </div>

            <div class="uk-margin">
                <label for="city" class="uk-form-label">Ciudad</label>
                <input type="text" class="uk-input" id="city" v-model="fields.city" placeholder="Ingresa una ciudad">
                <span v-if="errors.city_error !== ''" style="font-size: 13px; color: red;">
                    <strong>{{ errors.city_error }}</strong>
                </span>
            </div>

            <div class="row">
                <div class="col-md">
                    <div class="uk-margin">
                        <label for="phone" class="uk-form-label">Telefono</label>
                        <input type="text" class="uk-input" id="phone" v-model="fields.phone" placeholder="Ingresa número de telefono">
                        <span v-if="errors.phone_error !== ''" style="font-size: 13px; color: red;">
                            <strong>{{ errors.phone_error }}</strong>
                        </span>
                    </div>
                </div>
                <div class="col-md">
                    <div class="uk-margin">
                        <label for="email" class="uk-form-label">Correo Electrónico</label>
                        <input type="email" class="uk-input" id="email" v-model="fields.email" placeholder="Ingresa un email">
                        <span v-if="errors.email_error !== ''" style="font-size: 13px; color: red;">
                            <strong>{{ errors.email_error }}</strong>
                        </span>
                    </div>
                </div>
            </div>

            <!-- Buttons -->
            <div class="uk-text-right">
                <vk-button @click="magregar = false" class="uk-margin-small-right">Cancelar</vk-button>
                <vk-button type="primary" @click="(button_message === 'Guardar') ? addProvider() : updateProvider()">{{ button_message }}</vk-button>
            </div>
        </vk-modal>

        <!-- Modal ELiminar -->
        <vk-modal :show.sync="meliminar">
            <vk-modal-close @click="meliminar = false"></vk-modal-close>
            <vk-modal-title>{{ title_message }}</vk-modal-title>
            <!-- Content -->
            <p style="font-size: 14px; color: darkred;">¿Desea eliminar el registro seleccionado?</p>
            <!-- Buttons -->
            <p class="uk-text-right">
                <vk-button @click="meliminar = false" class="uk-margin-small-right">Cancelar</vk-button>
                <vk-button type="primary" @click="deleteProvider(fields.id)">{{ button_message }}</vk-button>
            </p>
        </vk-modal>
    </div>
</template>

<script>
    export default {
        data(){
            return{
                magregar: false,
                meliminar: false,
                thead: ['Nombre','Empresa','Dirección','Ciudad','Telefono','Email','Opciones'],
                title_message: '',
                button_message: '',
                errors: { name_error: '', company_error: '', phone_error: '', email_error: '', address_error: '', city_error: '' },
                fields: {
                    id: '',
                    name: '',
                    company: '',
                    phone: '',
                    email: '',
                    address: '',
                    city: ''
                },
                providers: []
            }
        },
        created: function(){
          this.getProviders();
        },
        methods: {
            getProviders(){
                let me = this;
                axios.get('/proveedores').then(response => {
                    me.providers = response.data;
                })
            },
            addProvider(){
                let me = this;
                me.clearErrors();
                axios.post('/registrar/proveedor', me.fields).then(response => {
                    me.clearForm();
                    me.magregar = false;
                    me.getProviders();
                    me.$notify({title : 'Acción', message : 'Proveedor agregado correctamente!', type : 'success'});
                }).catch(error => {
                    let err = error.response.data.errors;
                    if(err.hasOwnProperty('name'))
                        me.errors.name_error = err.name[0];
                    else if(err.hasOwnProperty('company'))
                        me.errors.company_error = err.company[0];
                    else if(err.hasOwnProperty('address'))
                        me.errors.address_error = err.address[0];
                    else if(err.hasOwnProperty('city'))
                        me.errors.city_error = err.city[0];
                    else if(err.hasOwnProperty('phone'))
                        me.errors.phone_error = err.phone[0];
                    else if(err.hasOwnProperty('email'))
                        me.errors.email_error = err.email[0];

                });
            },
            updateProvider(){
                let me = this;
                me.clearErrors();
                axios.put('/actualizar/proveedor', me.fields).then(response => {
                    me.clearForm();
                    me.magregar = false;
                    me.getProviders();
                    me.$notify({title : 'Acción', message : 'Proveedor editado correctamente!', type : 'success'});
                }).catch(error => {
                    let err = error.response.data.errors;
                    if(err.hasOwnProperty('name'))
                        me.errors.name_error = err.name[0];
                    else if(err.hasOwnProperty('company'))
                        me.errors.company_error = err.company[0];
                    else if(err.hasOwnProperty('address'))
                        me.errors.address_error = err.address[0];
                    else if(err.hasOwnProperty('city'))
                        me.errors.city_error = err.city[0];
                    else if(err.hasOwnProperty('phone'))
                        me.errors.phone_error = err.phone[0];
                    else if(err.hasOwnProperty('email'))
                        me.errors.email_error = err.email[0];
                });
            },
            deleteProvider(id){
                let me = this;
                axios.delete('/eliminar/proveedor/'+id).then(response => {
                    me.meliminar = false;
                    me.getProviders();
                    me.$notify({title : 'Acción', message : 'Proveedor eliminado correctamente!', type : 'success'});
                });
            },
            clearForm(){
                let me = this;
                me.fields.name = '';
                me.fields.company = '';
                me.fields.phone = '';
                me.fields.email = '';
                me.fields.address = '';
                me.fields.city = '';
            },
            clearErrors(){
              let me = this;
              me.errors.name_error = '';
              me.errors.company_error = '';
              me.errors.address_error = '';
              me.errors.city_error = '';
              me.errors.phone_error = '';
              me.errors.email_error = '';
            },
            openModalAdd(){
                let me = this;
                me.title_message = 'Almacenar proveedor';
                me.button_message = 'Guardar';
                me.magregar = true;
            },
            loadData(provider){
                let me = this;
                me.title_message = 'Edición de Provedor';
                me.button_message = 'Editar';
                me.fields.id = provider.id;
                me.fields.name = provider.name;
                me.fields.company = provider.company;
                me.fields.address = provider.address;
                me.fields.city = provider.city;
                me.fields.phone = provider.phone;
                me.fields.email = provider.email;
                me.magregar = true;
            }
        }
    }
</script>
