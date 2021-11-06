import Vue from 'vue'
import VueRouter from 'vue-router'
import App from "../views/layout.vue";
import "../css/portal.css"
import Logo from '../images/onhuman-logo.png';
import MainImage from '../images/onhuman-main-image.jpg';
import Hands from '../images/onhuman-hands.png';
import axios from "axios";
import { Auth0Plugin } from "../auth/index.js";
import { authGuard } from "../auth/authGuard";
import config from '../js/config.js'


import { domain, clientId } from "../../auth_config.json";

var numeral = require("numeral");

Vue.filter("formatNumber", function (value) {
  return numeral(value).format("0,0"); // displaying other groupings/separators is possible, look at the docs
});

function multiple(guards) {
	return (to, from, next) => {
		const stack = [].concat(guards);
		function another() {
			const guard = stack.pop();
			guard ? guard(to, from, another) : next()
		}
		another();
	}
}

Vue.use(VueRouter)
Vue.use(require('vue-moment'));

Vue.use(Auth0Plugin, {
    domain,
    clientId,
    onRedirectCallback: appState => {
      router.push(
        appState && appState.targetUrl
          ? appState.targetUrl
          : window.location.pathname
      );
    }
  });

  Vue.filter('truncate', function (text, length, suffix) {
    if (text.length > length) {
        return text.substring(0, length) + suffix;
    } else {
        return text;
    }
});

const router = new VueRouter({
    routes: [
        {
        path: '/',
        component: () => import('../views/welcome.vue'),
        meta: {
            auth: false,
            title: 'Welcome'
            }
        },
        {
            path: '/dashboard',
            component: () => import('../views/dashboard.vue'),

            beforeEnter: multiple([authGuard]),
            meta: {
                auth: true,
                title: 'Welcome'
                }
            },
            {
                path: '/estimates',
                component: () => import('../views/estimates.vue'),
    
                beforeEnter: multiple([authGuard]),
                meta: {
                    auth: true,
                    title: 'Estimates'
                    }
                },
        {
        path: '/projects',
        name: "projects",
        component: () => import('../views/projects.vue'),
        beforeEnter: multiple([authGuard]),
        meta: {
            auth: true,
            title: 'Projects'
            }
        },
        {
            path: '/service-down',
            name: "service-down",
            component: () => import('../views/service-down.vue'),
            beforeEnter: multiple([authGuard]),
            meta: {
                auth: true,
                title: 'Service Down'
                }
            },
        {
            path: '/profile',
            name: "profile",
            component: () => import('../views/profile.vue'),
            beforeEnter: multiple([authGuard]),
            meta: {
                auth: true,
                title: 'Profile'
                }
            },
        {
            path: '/contacts',
            name: "contacts",
            component: () => import('../views/contacts.vue'),
            beforeEnter: multiple([authGuard]),
            meta: {
                auth: true,
                title: 'Contacts'
                }
            },
        {
            path: '/projects/project/:id',
            name: "project",
            component: () => import('../views/project-single.vue'),
            beforeEnter: multiple([authGuard]),
            meta: {
                auth: true,
                title: 'Project'
            }
        },
        {
            path: '/projects/:project_id/project-manager/:id',
            name: "project-manager",
            component: () => import('../views/project-manager-single.vue'),
            beforeEnter: multiple([authGuard]),
            meta: {
                auth: true,
                title: 'Project'
            }
        },
        { path: '*', beforeEnter: (to, from, next) => { next('/404') } },
        {
            path: '/404',
            name: '404',
            component: () => import('../views/404.vue')
          }
    ]
})


router.beforeEach((to, from, next) => {
    //config.loading = true
    next()
  })

router.beforeResolve((to, from, next) => {
    // If this isn't an initial page load.
    if(localStorage.getItem("no_account") === true) {
        var loader = document.getElementById("loader-overlay");
        loader.style.display = "none";
        alert("you have no company account");
        localStorage.setItem("no_account", false);
        Vue.prototype.$auth.logout({
            path: "#/welcome"
        })
        return
    }

    //var loader = document.getElementById("loader-overlay");
    //loader.style.display = "flex";

    if (to.name) {
        var loader = document.getElementById("loader-overlay");
        loader.style.display = "flex";
    }

    next()
})

router.afterEach((to, from) => {
    // Complete the animation of the loader
    if(config.loading === false) {
        var loader = document.getElementById("loader-overlay");
        loader.style.display = "none";
    }
})

new Vue({
    router,
    created() {
        axios.interceptors.request.use((config) => {
            var loader = document.getElementById("loader-overlay");
            loader.style.display = "flex";
          return config;
        }, (error) => {
            var loader = document.getElementById("loader-overlay");
            loader.style.display = "none";
          return Promise.reject(error);
        });
      
        axios.interceptors.response.use((response) => {
            var loader = document.getElementById("loader-overlay");
            loader.style.display = "none";
          return response;
        }, (error) => {
            var loader = document.getElementById("loader-overlay");
            loader.style.display = "none";
          return Promise.reject(error);
        });
      },
    watch: {
        '$route'(to, from) {
            document.title = to.meta.title || 'On Human Portal'
        },
        immediate: true,
    },
    el: "#app",
    render: h => h(App)
});