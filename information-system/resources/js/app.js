require('./bootstrap');

var Vue = require('vue');

Vue.component('class-room-component', require('./components/ClassRoomComponent.vue').default,);
Vue.component('class-room-single-component', require('./components/ClassRoomSingleComponent.vue').default);
Vue.component('student-component', require('./components/StudentComponent.vue').default);
Vue.component('employee-component', require('./components/EmployeeComponent.vue').default);
Vue.component('employee-single-component', require('./components/EmployeeSingleComponent.vue').default);
Vue.component('major-component', require('./components/MajorComponent.vue').default);
Vue.component('study-component', require('./components/StudyComponent.vue').default);
Vue.component('schedule-component', require('./components/ScheduleComponent.vue').default);

vue = new Vue({
    el:"#app"
})