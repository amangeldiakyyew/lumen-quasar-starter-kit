<template>
  <router-view/>
</template>
<script>
import {defineComponent} from 'vue';
import {mapActions} from 'vuex';
import {Loading} from "quasar";

export default defineComponent({
  name: 'App',
  setup() {
    Loading.show({
      boxClass: 'bg-grey-2 text-grey-9',
      spinnerColor: 'primary'
    });
  },
  methods: {
    ...mapActions('init', ['fetchInitData']),
  },
  beforeMount() {
    this.fetchInitData().finally(() => {
      Loading.hide();
    });
  }
})
</script>
