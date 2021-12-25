const routes = [
  {
    name: 'login',
    path: '/login',
    component: () => import('src/pages/Login.vue')
  },
  {
    path: '/',
    component: () => import('layouts/MainLayout.vue'),
    children: [
      {name: 'home', path: '/', component: () => import('pages/Dashboard.vue')},

      //Users
      {name: 'admins', path: '/admins', component: () => import('pages/Admin/AdminList.vue')},
      {name: 'adminAdd', path: '/admins/add', component: () => import('pages/Admin/AdminAdd.vue')},
      {name: 'adminEdit', path: '/admins/:id/edit', component: () => import('pages/Admin/AdminEdit.vue')},

      //Users
      {name: 'users', path: '/users', component: () => import('pages/User/UserList.vue')},
      {name: 'userAdd', path: '/users/add', component: () => import('pages/User/UserAdd.vue')},
      {name: 'userEdit', path: '/users/:id/edit', component: () => import('pages/User/UserEdit.vue')},

      //Categories
      {name: 'categories', path: '/categories', component: () => import('pages/Category/CategoryList.vue')},
      {name: 'categoryAdd', path: '/categories/add', component: () => import('pages/Category/CategoryAdd.vue')},
      {name: 'categoryEdit', path: '/categories/:id/edit', component: () => import('pages/Category/CategoryEdit.vue')},

      //Information
      {name: 'information', path: '/information', component: () => import('pages/Information/InformationList.vue')},
      {
        name: 'informationAdd',
        path: '/information/add',
        component: () => import('pages/Information/InformationAdd.vue')
      },
      {
        name: 'informationEdit',
        path: '/information/:id/edit',
        component: () => import('pages/Information/InformationEdit.vue')
      },

      //Settings
      {name: 'settings', path: '/settings', component: () => import('pages/Setting/SettingList.vue')},

      //System
      //Countries
      {
        name: 'countries',
        path: '/system/countries',
        component: () => import('pages/Country/CountryList.vue')
      },
      {
        name: 'countryAdd',
        path: '/system/countries/add',
        component: () => import('pages/Country/CountryAdd.vue')
      },
      {
        name: 'countryEdit',
        path: '/system/countries/:id/edit',
        component: () => import('pages/Country/CountryEdit.vue')
      },
      //States
      {
        name: 'states',
        path: '/system/states',
        component: () => import('pages/State/StateList.vue')
      },
      {
        name: 'stateAdd',
        path: '/system/states/add',
        component: () => import('pages/State/StateAdd.vue')
      },
      {
        name: 'stateEdit',
        path: '/system/states/:id/edit',
        component: () => import('pages/State/StateEdit.vue')
      },

    ],
    meta: {
      requiresAuth: true
    }
  },
  {
    name: '404',
    path: '/:catchAll(.*)*',
    component: () => import('pages/Error404.vue')
  },
];

export default routes
