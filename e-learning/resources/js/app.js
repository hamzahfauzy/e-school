require('./bootstrap');

var Vue = require('vue');

Vue.component('admin-component', require('./components/AdminComponent.vue').default);
Vue.component('sidebar-component', require('./components/SidebarComponent.vue').default);
Vue.component('footer-component', require('./components/FooterComponent.vue').default);
Vue.component('announcement-component', require('./components/AnnouncementComponent.vue').default);
Vue.component('assignment-component', require('./components/AssignmentComponent.vue').default);
Vue.component('question-component', require('./components/QuestionComponent.vue').default);
Vue.component('exam-component', require('./components/ExamComponent.vue').default);
Vue.component('show-question-component', require('./components/ShowQuestionComponent.vue').default);
Vue.component('show-exam-component', require('./components/ShowExamComponent.vue').default);
Vue.component('virtual-classroom-component', require('./components/VirtualClassroomComponent.vue').default);

vue = new Vue({
    el:"#app"
})
