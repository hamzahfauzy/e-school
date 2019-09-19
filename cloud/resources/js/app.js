require('./bootstrap');

var Vue = require('vue');

Vue.component('index-component', require('./components/IndexComponent.vue').default);
Vue.component('file-component', require('./components/FileComponent.vue').default);
Vue.component('share-component', require('./components/ShareComponent.vue').default);

vue = new Vue({
    el:"#app"
})
