/* Incluimos el archivo de bootstrap
*   el cual contiene lo necesario
* * para funcionar */
require('./bootstrap');

/**
 * Vue Router
 */
import VueRouter from 'vue-router';


/**
 * Importamos desde nuestros modulos de node npm
 * @type Object Vue JS
 */
window.Vue = require('vue');

/** ==================================================================================
 *                              VUE ROUTER FROM VUE JS
 * =================================================================================== */

Vue.use(VueRouter);



/**
 * Registro de Componentes de Vue Js
 */
Vue.component('users', require('./components/UsersComponent.vue').default);
Vue.component('login', require('./components/LoginComponent.vue').default);
Vue.component('home', require('./components/HomeComponet.vue').default);

Vue.component('providers', require('./components/ProviderComponent').default);
Vue.component('categories', require('./components/CategoryComponent').default);

/**
 * Importación del Framewor UIkit for Vue Js
 */

import Vuikit from 'vuikit';
import VuikitIcons from '@vuikit/icons'

import '@vuikit/theme'


Vue.use(Vuikit);
Vue.use(VuikitIcons);

import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';
Vue.use(ElementUI);


/**
 * Importando Rutas para Vue Router
 */

import router from './routes.js';



/**
 * Instancia de VueJS donde podemos
 * agregar los componente registrados y creados
 */
const app = new Vue({
    el: '#app',
    router
});


