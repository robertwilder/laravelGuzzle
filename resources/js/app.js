

require('./bootstrap');

window.Vue = require('vue');


Vue.component('quiz-component', require('./components/QuizComponent.vue').default);
Vue.component('singleq-component', require('./components/SingleQComponent.vue').default);
Vue.component('quizsingle-component', require('./components/QuizSingle.vue').default);

const app = new Vue({
    el: '#app',

    data() {
        return {
          questions: {},
        }
    },
    methods: {
        getQuestions(){
            axios.get('/questions')
                 .then((response)=>{
                   this.questions = response.data
                 })
        }
    },
    created() {
        this.getQuestions()
    }
});


