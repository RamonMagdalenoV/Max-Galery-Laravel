<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">

                <div class="card border-primary">
                    <div class="card-header bg-primary text-white d-flex justify-content-between">
                        <span>Lista de categorias</span>
                        <vk-button class="uk-margin-small-right" @click="clearForm(); clearErrors();  magregar = true; button_message = 'Guardar'; title_message = 'Almacenar Categoria'" type="secondary" size="small">Agregar categoria</vk-button>
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
                                    <tr v-for="category in categories" v-bind:id="category.id">
                                        <td>{{ category.category_name }}</td>
                                        <td>{{ category.created_at }}</td>
                                        <td>
                                            <a class="uk-button"  @click="loadData(category); clearErrors(); magregar = true; title_message = 'Edición de Categorias'; button_message = 'Editar'" title="Editar"><vk-icon icon="file-edit"></vk-icon></a>
                                            <a class="uk-button" @click.prevent="meliminar = true; fields.id = category.id;" title="Eliminar"><vk-icon icon="trash"></vk-icon></a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!--  Modal Agregar / Editar-->
        <vk-modal :show.sync="magregar">
            <vk-modal-close @click="magregar = false"></vk-modal-close>
            <vk-modal-title>{{ title_message }}</vk-modal-title>
            <!-- Content Form -->
            <div class="uk-margin">
                <label for="name" class="uk-form-label">Nombre</label>
                <input type="text" class="uk-input" id="name" v-model="fields.category_name" placeholder="Ingresa nombre">
                <span v-if="errors.name_error !== ''" style="font-size: 13px; color: red;">
                    <strong>{{ errors.name_error }}</strong>
                </span>
            </div>

            <!-- Buttons -->
            <div class="uk-text-right">
                <vk-button @click="magregar = false" class="uk-margin-small-right">Cancelar</vk-button>
                <vk-button type="primary" @click="(button_message === 'Guardar') ? addCategory() : updateCategory()">{{ button_message }}</vk-button>
            </div>
        </vk-modal>

        <!-- Modal ELiminar -->
        <vk-modal :show.sync="meliminar">
            <vk-modal-close @click="meliminar = false"></vk-modal-close>
            <vk-modal-title>Eliminar Categoria</vk-modal-title>
            <!-- Content -->
            <p style="font-size: 14px; color: darkred;">¿Desea eliminar el registro seleccionado?</p>
            <!-- Buttons -->
            <p class="uk-text-right">
                <vk-button @click="meliminar = false" class="uk-margin-small-right">Cancelar</vk-button>
                <vk-button type="primary" @click="deleteCategory(fields.id)">Eliminar</vk-button>
            </p>
        </vk-modal>

    </div>
</template>

<script>
    export default {
        data(){
            return {
                fields: {id: '', name_category: '', created_at: ''},
                errors: {name_error: ''},
                categories: [],
                button_message: '',
                title_message : '',
                magregar: false,
                meliminar: false

            }
        },
        created: function(){
            this.getCategories();
        },
        methods:{
            getCategories()
            {
                let me = this;
                axios.get('/categorias').then(response => {
                    me.categories = response.data;
                });
            },
            addCategory()
            {
                let me = this;
                me.clearErrors();
                axios.post('/categorias/agregar',me.fields).then(response => {
                    me.magregar = false;
                    me.getCategories();
                    me.$notify({title : 'Acción', message : 'Categoria agregada correctamente!', type : 'success'});
                }).catch(error => {
                    let err = error.response.data.errors;
                    if(err.hasOwnProperty('category_name')){
                        me.errors.name_error = err.category_name[0];
                    }

                });
            },
            updateCategory()
            {
                let me = this;
                axios.put('/categorias/actualizar',me.fields).then(response => {
                    me.magregar = false;
                    me.getCategories();
                    me.$notify({title : 'Acción', message : 'Categoria actualizada correctamente!', type : 'success'});
                }).catch(error => {
                    let err = error.response.data.errors;
                    if(err.hasOwnProperty('category_name')){
                        me.errors.name_error = err.category_name[0];
                    }
                });
            },
            deleteCategory(id)
            {
                let me =this;
                axios.delete('/categorias/eliminar/'+id).then(response => {
                    me.meliminar = false;
                    me.getCategories();
                    me.$notify({title : 'Acción', message : 'Categoria eliminada correctamente!', type : 'success'});
                });
            },
            loadData(category)
            {
                let me = this;
                me.fields.category_name = category.category_name;
                me.fields.id = category.id;
            },
            clearForm()
            {
                let me = this;
                me.fields.category_name = '';
                me.fields.created_at = '';
            },
            clearErrors(){
                let me = this;
                me.errors.name_error = '';
            }
        }
    }
</script>
