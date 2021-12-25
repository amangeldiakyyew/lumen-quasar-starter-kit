<template>
  <q-page class="container" padding>
    <q-card>
      <q-tabs
        v-model="tab"
        class="text-grey"
        active-color="primary"
        indicator-color="primary"
        align="justify"
        narrow-indicator
      >
        <q-tab name="accountInformation" :label="$t('accountInformation')"/>
        <q-tab name="notifications" :label="$t('notifications')"/>
      </q-tabs>
      <q-separator/>
      <q-tab-panels v-model="tab" animated>
        <q-tab-panel name="accountInformation" class="q-pa-md">
          <q-form
            @submit="onSubmit"
            class="row q-col-gutter-md"
          >
            <q-input filled stack-label
                     v-model="user.email"
                     :label="$t('email')"
                     :error-message="getError('email')"
                     :error="hasError('email')"
                     @focus="removeError('email')"
                     class="col-12"
            />
            <q-input v-model="user.password" filled stack-label outlined :type="isPwd ? 'password' : 'text'"
                     :label="$t('password')"
                     :hint="$t('leavePasswordEmpty')"
                     :error-message="getError('password')"
                     :error="hasError('password')"
                     @focus="removeError('password')"
                     class="col-12"
            >
              <template v-slot:append>
                <q-icon
                  :name="isPwd ? 'visibility_off' : 'visibility'"
                  class="cursor-pointer"
                  @click="isPwd = !isPwd"
                />
              </template>
            </q-input>
            <q-input filled stack-label
                     v-model="user.name"
                     :label="$t('name')"
                     :error-message="getError('name')"
                     :error="hasError('name')"
                     @focus="removeError('name')"
                     class="col-12 col-lg-6"
            />
            <q-input filled stack-label
                     v-model="user.surname"
                     :label="$t('surname')"
                     :error-message="getError('surname')"
                     :error="hasError('surname')"
                     @focus="removeError('surname')"
                     class="col-12 col-lg-6"
            />
            <div class="col-12">
              <q-btn type="submit" :loading="saving" :label="$t('save')" color="primary" class="float-right"/>
            </div>
          </q-form>
        </q-tab-panel>

        <q-tab-panel name="notifications">
          <div class="text-h6">{{ $t('notifications') }}</div>
          Lorem ipsum dolor sit amet consectetur adipisicing elit.
        </q-tab-panel>
      </q-tab-panels>
    </q-card>
  </q-page>
</template>

<script>
import {defineComponent} from 'vue';
import {validationHelper} from "src/helpers/validationHelper";
import {mapActions} from "vuex";
import notifyHelper from "src/helpers/notifyHelper";

export default defineComponent({
  name: 'Profile',
  setup() {
    const {setErrors, getError, hasError, removeError} = validationHelper();
    return {setErrors, getError, hasError, removeError};
  },
  data() {
    return {
      user: {},
      saving: false,
      tab: 'accountInformation',
      isPwd: 'password',
    }
  },
  beforeMount() {
    this.user = JSON.parse(JSON.stringify(this.$store.state.auth.user))
  },
  methods: {
    ...mapActions('profile', ['update']),
    onSubmit() {
      let $v = this;
      this.saving = true;
      this.update({user: this.user}).then(res => {
        notifyHelper.success(res)
      }).catch((error) => {
        notifyHelper.error(error)
        $v.setErrors(error.response.data)
      }).finally(() => {
        $v.saving = false;
      });
    }
  },
})
</script>
