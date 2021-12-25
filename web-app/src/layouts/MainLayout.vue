<template>
  <q-layout view="lHh Lpr lFf" class="bg-white" v-if="$store.state.init.initiated">
    <q-header elevated class="bg-white text-grey-8" height-hint="64">
      <div class="container">
        <q-toolbar>
          <q-toolbar-title>
            Miniauktion
          </q-toolbar-title>

          <div class="q-gutter-sm row items-center no-wrap">
            <Locale/>
            <q-btn v-if="!$store.state.auth.authenticated" flat icon="person_outline" :to="{name:'login'}">
              {{ $t('login') }}
            </q-btn>
            <q-btn v-else round flat @click="toggleAccountDrawer" icon="person_outline">
              <q-menu fit anchor="bottom left" :offset="[200, 5]">
                <q-list>
                  <q-item :to="{name:'profile'}" v-close-popup>
                    <q-item-section>
                      {{ $t('myAccount') }}
                    </q-item-section>
                  </q-item>
                  <q-item clickable @click="onLogout" v-close-popup>
                    <q-item-section>{{ $t('logout') }}</q-item-section>
                  </q-item>
                </q-list>
              </q-menu>
            </q-btn>
          </div>
        </q-toolbar>
      </div>
    </q-header>

    <q-drawer
      v-model="accountDrawerOpen"
      behavior="mobile"
      side="right"
      bordered
      class="bg-grey-2"
    >
      <q-list>
        <q-item clickable tag="a" target="_blank" rel="noopener" href="https://facebook.quasar.dev">
          <q-item-section>
            <q-item-label>Facebook</q-item-label>
          </q-item-section>
        </q-item>
      </q-list>
    </q-drawer>

    <q-page-container>
      <router-view/>
    </q-page-container>
  </q-layout>
</template>

<script>
import {ref} from 'vue'
import Locale from "components/Locale";
import {mapActions} from 'vuex';
import notifyHelper from "src/helpers/notifyHelper";

export default {
  name: 'MainLayout',
  setup() {
    const accountDrawerOpen = ref(false);

    function toggleAccountDrawer() {
      // accountDrawerOpen.value = !accountDrawerOpen.value
    }

    return {
      accountDrawerOpen,
      toggleAccountDrawer
    }
  },
  components: {
    Locale
  },
  methods: {
    ...mapActions('auth', ['logout']),
    onLogout: function () {
      this.logout().then((res) => {
        notifyHelper.info(res);
        this.$router.push({name: 'login'});
      });
    }
  }
}
</script>
