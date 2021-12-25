<template>
  <q-layout view="lHh Lpr lFf">
    <q-header elevated class="bg-secondary">
      <q-toolbar>
        <q-btn
          flat
          dense
          round
          @click="toggleLeftDrawer"
          icon="menu"
          aria-label="Menu"
        />
        <q-toolbar-title>
        </q-toolbar-title>
        <q-space/>
        <div class="q-gutter-sm row items-center no-wrap">
          <q-btn round dense flat color="white" :icon="$q.fullscreen.isActive ? 'fullscreen_exit' : 'fullscreen'"
                 @click="$q.fullscreen.toggle()"
                 v-if="$q.screen.gt.sm">
          </q-btn>
          <q-btn round dense flat color="white" icon="notifications">
            <q-badge color="red" text-color="white" floating>
              5
            </q-badge>
            <q-menu>
              <q-list style="min-width: 100px">
                <q-card class="text-center no-shadow no-border">
                  <q-btn label="View All" style="max-width: 120px !important;" flat dense class="text-indigo-8"></q-btn>
                </q-card>
              </q-list>
            </q-menu>
          </q-btn>
          <q-btn round flat>
            <q-avatar size="26px">
              <img src="https://cdn.quasar.dev/img/boy-avatar.png">
            </q-avatar>
            <q-menu auto-close :offset="[110, 0]">
              <q-list style="min-width: 150px">
                <q-item :to="{name:'adminEdit',params: {id: $store.state.auth.user.id}}">
                  <q-item-section>{{ $t('myAccount') }}</q-item-section>
                </q-item>
                <q-item clickable @click="onLogout">
                  <q-item-section>{{ $t('logout') }}</q-item-section>
                </q-item>
              </q-list>
            </q-menu>
          </q-btn>
        </div>
      </q-toolbar>
    </q-header>

    <q-drawer v-model="leftDrawerOpen" show-if-above class="bg-secondary text-white">


      <q-list>
        <MenuLinks v-for="(link,index) in links" :link="link" :key="index"></MenuLinks>

      </q-list>
    </q-drawer>

    <q-page-container class="bg-grey-2">
      <router-view/>
    </q-page-container>

  </q-layout>
</template>

<script>

import {defineComponent, ref} from 'vue'
import {mapActions} from 'vuex'
import MenuLinks from "components/MenuLinks";

export default defineComponent({
  name: 'MainLayout',
  setup() {
    const leftDrawerOpen = ref(false)
    return {
      leftDrawerOpen,
      toggleLeftDrawer() {
        leftDrawerOpen.value = !leftDrawerOpen.value
      }
    }
  },
  data() {
    return {
      links: [
        {
          name: this.$t('homePage'),
          to: {name: 'home'},
          icon: 'dashboard',
          level: 0,
          children: []
        },
        {
          name: this.$t('users'),
          to: {name: 'users'},
          icon: 'people',
          level: 0,
          children: []
        },
        {
          name: this.$t('admins'),
          to: {name: 'admins'},
          icon: 'admin_panel_settings',
          level: 0,
          children: []
        },
        {
          name: this.$t('categories'),
          to: {name: 'categories'},
          icon: 'category',
          level: 0,
          children: []
        },
        {
          name: this.$t('informationPages'),
          to: {name: 'information'},
          icon: 'info',
          level: 0,
          children: []
        },
        {
          name: this.$t('system'),
          to: '',
          icon: 'more',
          level: 0,
          children: [
            {
              name: this.$t('countries'),
              to: {name: 'countries'},
              icon: 'public',
              level: 0.2,
              children: []
            },
            {
              name: this.$t('states'),
              to: {name: 'states'},
              icon: 'public',
              level: 0.2,
              children: []
            },
          ]
        },
        {
          name: this.$t('settings'),
          to: {name: 'settings'},
          icon: 'settings',
          level: 0,
          children: []
        },
      ]
    }
  },
  components: {
    MenuLinks,
  },
  methods: {
    ...mapActions('auth', ['logout']),
    onLogout: function () {
      this.logout().then(() => {
        this.$router.push({name: 'login'});
      });
    }
  }
})
</script>
