import VueRouter from 'vue-router';

let routes = [
    {
      path: '*',
      redirect: '/home'
    },
    {
        path: '/home',
        component: require('./components/HomeComponet.vue').default
    },
    {
        path: '/products',
        component: require('./components/ProductComponent.vue').default
    },
    {
        path: '/users',
        component: require('./components/UsersComponent.vue').default
    },
    {
        path:  '/providers',
        component: require('./components/ProviderComponent').default
    },
    {
        path:  '/categories',
        component: require('./components/CategoryComponent').default
    },
    {
        path:  '/brands',
        component: require('./components/BrandComponent').default
    }
];

export default new VueRouter({
    mode: 'history',
    routes
});
