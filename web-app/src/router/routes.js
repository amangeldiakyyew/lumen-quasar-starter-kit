const routes = [
  {
    path: '/',
    component: () => import('layouts/MainLayout.vue'),
    children: [
      /*-----*/
      {
        path: '',
        name: 'home',
        component: () => import('pages/Home/Home.vue')
      },
      {
        path: '/login',
        name: 'login',
        component: () => import('pages/Auth/Login.vue'),
        meta: {
          disableOnAuth: true
        }
      },
      {
        path: '/register',
        name: 'register',
        component: () => import('pages/Auth/Register.vue'),
        meta: {
          disableOnAuth: true
        }
      },
      {
        path: '/kategori/:slug',
        name: 'category',
        component: () => import('pages/Category/Category.vue')
      },

      /*-Auth-*/
      {
        path: '/profile',
        name: 'profile',
        component: () => import('pages/Profile/Profile.vue'),
        meta: {
          requiresAuth: true
        }
      }

    ]
  },

  // Always leave this as last one,
  // but you can also remove it
  {
    path: '/:catchAll(.*)*',
    component: () => import('pages/Error/Error404.vue')
  }
]

export default routes
