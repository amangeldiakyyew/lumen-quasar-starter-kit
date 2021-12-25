<template>
  <q-layout>
    <q-page-container>
      <q-page class="flex bg-image flex-center">
        <q-card v-bind:style="$q.screen.lt.sm?{'width': '80%'}:{'width':'30%'}">
          <q-card-section>
            <q-avatar size="103px" class="absolute-center shadow-10 bg-white">
              <q-icon name="account_circle" size="60px"></q-icon>
            </q-avatar>
          </q-card-section>
          <q-card-section>
            <div class="text-center q-pt-lg">
              <div class="col text-h6 ellipsis">
                {{$t('signIn')}}
              </div>
            </div>
          </q-card-section>
          <q-card-section>
            <q-form
              class="q-gutter-md"
              v-on:submit="onLogin"
            >
              <q-input
                type="email"
                v-model="email"
                :label="$t('email')"
                filled
                lazy-rules
                ref="email"
              />

              <q-input
                type="password"
                v-model="password"
                :label="$t('password')"
                filled
                lazy-rules
              />
              <q-banner inline-actions class="text-white bg-red" v-if="errorMessage.length>0">
                <div v-html="errorMessage"></div>
              </q-banner>
              <div>
                <q-btn type="submit" :label="$t('signIn')" :loading="loading" color="primary"/>
              </div>
            </q-form>
          </q-card-section>
        </q-card>
      </q-page>
    </q-page-container>
  </q-layout>
</template>

<script>
  import {defineComponent} from 'vue'
  import {mapActions} from 'vuex';
  import notifyHelper from "src/helpers/notifyHelper";

  export default defineComponent({
    data: () => {
      return {
        email: 'amangeldiakyyew@gmail.com',
        password: '123456',
        errorMessage: '',
        loading: false,
      }
    },
    methods: {
      ...mapActions({
        login: 'auth/login'
      }),
      onLogin() {
        let $x = this;
        let credentials = {
          email: this.email,
          password: this.password
        };
        $x.loading = true;
        this.login({credentials}).then((res) => {
          $x.loading = false;
          this.$router.push({name: 'home'});
        }).catch((err) => {
          $x.loading = false;
          notifyHelper.error(err);
        });
      }
    }
  })
</script>

<style>

  .bg-image {
    background-image: linear-gradient(135deg, #7028e4 0%, #e5b2ca 100%);
  }
</style>
