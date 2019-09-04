import Vue from 'vue';
import Router from 'vue-router';
import Home from './components/Home';
import Login from './components/Login';
import Dashboard from './components/Dashboard';

Vue.use(Router);

const router = new Router({
  mode: 'history',
  base: '/',
  routes: [
    {
      path: '/login/',
      name: 'login',
      component: Login
    },
    {
      path: '/dashboard',
      name: 'dashboard',
      component: Dashboard
    },
  ]
});

new Vue({
  router,
  render: h => h(Home)
}).$mount('#app');
