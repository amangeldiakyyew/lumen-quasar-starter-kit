<template>
  <q-page class="q-pa-sm">
    <q-card>
      <q-card-section>
        <div class="text-h6 text-grey-8">
          {{ $t('editCategory') }}
          <div class="float-right">
            <BackButton></BackButton>
          </div>
        </div>
      </q-card-section>
      <q-card-section v-if="isReady">
        <CategoryForm :formData="formData" @formSubmit="onSubmit"></CategoryForm>
      </q-card-section>
    </q-card>
  </q-page>
</template>

<script>
import {defineComponent} from 'vue'
import CategoryForm from "../../components/forms/CategoryForm";
import BackButton from "../../components/buttons/BackButton";
import {mapActions} from "vuex";
import notifyHelper from "src/helpers/notifyHelper";


export default defineComponent({
  name: 'CategoryEdit',
  components: {
    CategoryForm,
    BackButton
  },
  data: function () {
    return {
      isReady: false,
      formData: {},
    }
  },
  methods: {
    ...mapActions('category', ['fetchCategory', 'updateCategory']),
    onSubmit(formData) {
      let id = this.$route.params.id;
      this.updateCategory({id, formData}).then(res => {
        notifyHelper.success(res.data);
        this.$router.go(-1);
      });
    }
  },
  created() {
    let $x = this;
    this.fetchCategory({id: this.$route.params.id, params: {with: ['parent']}}).then((res) => {
      $x.formData = res.data.data;
      $x.isReady = true;
    });
  }
})
</script>
