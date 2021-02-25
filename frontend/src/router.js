import Vue from "vue";
import VueRouter from "vue-router";

Vue.use(VueRouter);

const routes = [
    {
        path:'/main',
        component: require('./components/pages/test.vue').default
    },

];

export default new VueRouter({
    mode: "history",
    routes
});
