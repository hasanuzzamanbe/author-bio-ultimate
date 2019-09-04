window.AuthorBioBus = new window.AuthorBio.Vue();

window.AuthorBio.Vue.mixin({
    methods: {
        applyFilters: window.AuthorBio.applyFilters,
        addFilter: window.AuthorBio.addFilter,
        addAction: window.AuthorBio.addFilter,
        doAction: window.AuthorBio.doAction,
        $get: window.AuthorBio.$get,
        $adminGet: window.AuthorBio.$adminGet,
        $adminPost: window.AuthorBio.$adminPost,
        $post: window.AuthorBio.$post
    }
});

import {routes} from './routes'

const router = new window.AuthorBio.Router({
    routes: window.AuthorBio.applyFilters('author_bio_global_vue_routes', routes),
    linkActiveClass: 'active'
});

import App from './AdminApp'
if(document.getElementById("authorbioapp")) {
    new window.AuthorBio.Vue({
        el: '#authorbioapp',
        render: h => h(App),
        router: router
    });
}
