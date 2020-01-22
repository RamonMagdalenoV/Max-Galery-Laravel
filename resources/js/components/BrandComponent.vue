<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card border-primary">
                    <div class="card-header bg-primary text-white d-flex justify-content-between">
                        <span>Lista de marcas</span>
                        <vk-button class="uk-margin-small-right"
                                   @click="modal_text.title_message = 'Almacenar marca';  modal_text.button_message='Guardar'; modaladd = true; clearErrors(); clearForm();" type="secondary" size="small">
                            Agregar marca
                        </vk-button>
                    </div>
                    <div class="card-body">
                        <div class="uk-overflow-auto">
                            <table class="uk-table  uk-table-hover uk-table-divider">
                                <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Creación</th>
                                    <th>Opciones</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="brand in brands" v-bind:id="brand.id">
                                    <td>{{brand.name}}</td>
                                    <td>{{brand.created_at}}</td>
                                    <td>
                                        <a @click="loadData(brand); modal_text.title_message='Edición de marca'; clearErrors() ; modal_text.button_message = 'Editar'; modaladd = true;" class="uk-button" title="Editar">
                                            <vk-icon icon="file-edit" title="Editar"></vk-icon>
                                        </a>
                                        <a class="uk-button" @click="fields.id = brand.id; modaldelete = true;" title="Eliminar">
                                            <vk-icon icon="trash"></vk-icon>
                                        </a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- =================== MODAL AGREGAR EDITAR ==================== -->
        <vk-modal :show.sync="modaladd">
            <vk-modal-close @click="modaladd = false"></vk-modal-close>
            <vk-modal-title>{{ modal_text.title_message }}</vk-modal-title>

            <!-- == FORM == -->
            <div class="uk-margin">
                <label for="name" class="uk-form-label">Nombre</label>
                <input type="text" class="uk-input" id="name" v-model="fields.name" placeholder="Ingresa nombre de la marca">
                <span v-if="errors.name_error !== ''" style="font-size: 13px; color: red;">
                    <strong>{{ errors.name_error }}</strong>
                </span>
            </div>

            <div class="uk-text-right">
                <vk-button @click="modaladd = false" class="uk-margin-small-right">Cancelar</vk-button>
                <vk-button @click="(modal_text.button_message === 'Guardar') ? addBrand(): updateBrand() " type="primary">{{modal_text.button_message}}</vk-button>
            </div>
        </vk-modal>

        <!-- =================== MODAL ELIMINAR ==================== -->
        <vk-modal :show.sync="modaldelete">
            <vk-modal-close @click="modaldelete = false"></vk-modal-close>
            <vk-modal-title>Eliminar Marca</vk-modal-title>

            <!-- Content -->
            <p style="font-size: 14px; color: darkred;">¿Desea eliminar el registro seleccionado?</p>

            <div class="uk-text-right">
                <vk-button @click="modaldelete = false" class="uk-margin-small-right">Cancelar</vk-button>
                <vk-button @click="deleteBrand(fields.id);" type="primary">Eliminar</vk-button>
            </div>
        </vk-modal>
    </div>
</template>

<script>
    export default {
        data(){
            return{
                modaladd: false,
                modaldelete: false,
                modal_text: {title_message: '', button_message: ''},
                fields: {id: '', name: '', created_at: ''},
                errors: {name_error: ''},
                brands: []
            }
        },
        created: function()
        {
            this.getBrands();
        },
        methods: {
            getBrands()
            {
                let me = this;
                axios.get('/marcas').then(response => {
                    me.brands = response.data;
                });

            },
            addBrand()
            {
                let me = this;
                me.clearErrors();
                axios.post('/marcas/agregar', me.fields).then(response =>
                {
                    me.modaladd = false;
                    me.getBrands();
                    me.$notify({title: 'Acción', message: 'Marca agregada correctamente!', type: 'success'});
                })
                .catch(error => {
                    let err = error.response.data.errors;
                    if(err.hasOwnProperty('name')){
                        me.errors.name_error = err.name[0];
                    }

                });
            },
            updateBrand()
            {
                let me = this;
                me.clearErrors();
                axios.put('/marcas/editar', me.fields)
                .then(response => {
                    me.modaladd = false;
                    me.getBrands();
                    me.$notify({title: 'Acción', message: 'Marca editada correctamente!', type: 'success'});
                })
                .catch(error => {
                    let err = error.response.data.errors;
                    if(err.hasOwnProperty('name')){
                        me.errors.name_error = err.name[0];
                    }
                });
            },
            deleteBrand(id)
            {
                let me = this;
                axios.delete('/marcas/eliminar/'+id)
                .then(response => {
                    me.modaldelete = false;
                    me.getBrands();
                    me.$notify({title: 'Acción', message: 'Marca eliminada correctamente!', type: 'success'});
                });
            }
            ,
            clearErrors()
            {
                let me = this;
                me.errors.name_error = '';
            },
            clearForm()
            {
                let me = this;
                me.fields.id = '';
                me.fields.name = '';
                me.fields.created_at = '';
            },
            loadData(brand)
            {
                let me = this;
                me.fields.id = brand.id;
                me.fields.name = brand.name;
            }
        }
    }
</script>
