<template>
  <div>
    <section>
      <q-list class="row">
        <q-item v-for="(categoryChildren,index) in category.children"
                :key="index"
                :label="categoryChildren.name"
                :to="{name: 'Category', params: {slug:categoryChildren.slug}}"
                class="col-12 col-sm-6 col-md-4 col-xl-3">
          <q-item-section avatar>
            <q-icon :color="categoryChildren.color" :name="categoryChildren.icon"></q-icon>
          </q-item-section>
          <q-item-section>
            <q-item-label>{{ categoryChildren.name }}</q-item-label>
            <q-item-label caption :lines="1">

            </q-item-label>
          </q-item-section>
        </q-item>
      </q-list>
    </section>
  </div>
</template>

<script>
import {defineComponent} from 'vue';

export default defineComponent({
  name: 'Category',
  methods: {

  }
})
</script>
