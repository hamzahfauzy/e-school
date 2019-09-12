require('./bootstrap');

var Vue = require('vue');

Vue.component('class-room-component', require('./components/ClassRoomComponent.vue').default);
Vue.component('student-component', require('./components/StudentComponent.vue').default);

vue = new Vue({
    el:"#app"
})