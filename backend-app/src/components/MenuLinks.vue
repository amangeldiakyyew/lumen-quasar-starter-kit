<template>
  <div>
    <q-item v-if="link.children.length===0" :to="link.to" :inset-level="link.level"
            active-class="q-item-no-link-highlighting">
      <q-item-section avatar>
        <q-icon :name="link.icon"/>
      </q-item-section>
      <q-item-section>
        <q-item-label>{{ link.name }}</q-item-label>
      </q-item-section>
    </q-item>

    <q-expansion-item :icon="link.icon" :label="link.name" :header-inset-level="link.level"
                      v-if="link.children.length>0">
      <MenuLinks v-for="(child,i) in link.children" :link="child" :key="i"></MenuLinks>
    </q-expansion-item>
  </div>
</template>

<script>
import {defineComponent} from 'vue'

export default defineComponent({
  name: 'MenuLinks',
  props: {
    link: Object,
  }
});
</script>
