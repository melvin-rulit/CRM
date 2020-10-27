import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

import Region from "./components/Menu/MenuComponent"

const routes = [
    { path: '/', component: Region },
];


export default new vueRouter({
    mode: "history",
    routes
});
