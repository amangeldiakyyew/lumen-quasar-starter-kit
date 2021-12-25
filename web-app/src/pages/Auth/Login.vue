<template>
  <q-page class="row justify-center bg-grey-2 q-pt-xl">
    <div class="col col-xl-3 col-lg-3 col-md-4 col-sm-6 col-xs-8 col-12">
      <q-card>
        <q-card-section>
          <q-form
            @submit="onSubmit"
            class="q-gutter-md"
          >
            <h1 class="text-h5">{{ $t('login') }}</h1>
            <q-input v-model="credentials.email" filled stack-label
                     :label="$t('email')"
                     :error-message="getError('email')"
                     :error="hasError('email')"
                     @focus="removeError('email')"
            />
            <q-input v-model="credentials.password" filled stack-label outlined :type="isPwd ? 'password' : 'text'"
                     :label="$t('password')"
                     :error-message="getError('password')"
                     :error="hasError('password')"
                     @focus="removeError('password')"
            >
              <template v-slot:append>
                <q-icon
                  :name="isPwd ? 'visibility_off' : 'visibility'"
                  class="cursor-pointer"
                  @click="isPwd = !isPwd"
                />
              </template>
            </q-input>
            <div class="q-gutter-md">
              <q-btn type="submit" :loading="loading" :label="$t('login')" color="primary" class="full-width"/>
              <q-btn :to="{name:'register'}" :label="$t('createAccount')" flat text-color="primary" class="full-width"/>
            </div>
          </q-form>
        </q-card-section>
      </q-card>
    </div>
  </q-page>
</template>

<script>
import {defineComponent} from 'vue';
import {mapActions} from "vuex";
import {validationHelper} from "src/helpers/validationHelper";
import notifyHelper from "src/helpers/notifyHelper";

export default defineComponent({
  name: 'Login',
  setup() {
    const {setErrors, getError, hasError, removeError} = validationHelper();
    return {setErrors, getError, hasError, removeError};
  },
  data() {
    return {
      credentials: {
        email: /*this.$route.query.email*/'amangeldiakyyew@gmail.com',
        password: '123456',
      },
      loading: false,
      isPwd: 'password',
    }
  },
  methods: {
    ...mapActions('auth', ['login']),
    onSubmit() {
      const $v = this;
      this.loading = true;
      this.login({credentials: this.credentials}).then(function (res) {
        notifyHelper.success(res)
        $v.$router.push({name: 'home'});
      }).catch((error) => {
        notifyHelper.error(error)
        $v.setErrors(error.response.data)
      }).finally(() => {
        $v.loading = false;
      });
    }
  },
})
</script>
