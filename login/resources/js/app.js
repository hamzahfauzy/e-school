require('./bootstrap');

var Vue = require('vue');

Vue.component('login-component', require('./components/LoginComponent.vue').default);
Vue.component('admin-component', require('./components/AdminComponent.vue').default);
Vue.component('user-component', require('./components/UserComponent.vue').default);
Vue.component('role-component', require('./components/RoleComponent.vue').default);
Vue.component('application-portal-component', require('./components/ApplicationPortalComponent.vue').default);
Vue.component('cloud-setting-component', require('./components/CloudSettingComponent.vue').default);

vue = new Vue({
    el: '#app',
});
