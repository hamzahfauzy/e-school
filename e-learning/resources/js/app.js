require('./bootstrap');

var Vue = require('vue');

Vue.component('admin-component', require('./components/AdminComponent.vue').default);
Vue.component('sidebar-component', require('./components/SidebarComponent.vue').default);
Vue.component('footer-component', require('./components/FooterComponent.vue').default);
Vue.component('announcement-component', require('./components/AnnouncementComponent.vue').default);

vue = new Vue({
    el:"#app"
})
