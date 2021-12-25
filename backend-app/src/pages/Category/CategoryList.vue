<template>
  <q-page class="q-pa-sm">
    <q-card>
      <q-card-section>
        <div class="text-h6 text-grey-8">
          {{ $t('categories') }}
          <div class="float-right">
            <q-btn :label="$t('add')" :to="{name:'categoryAdd'}" class="text-capitalize q-mr-md" icon="add"
                   color="primary"/>
          </div>
        </div>
      </q-card-section>
      <q-card-section class="q-pa-md q-gutter-sm">

        <q-inner-loading
          :showing="loading"
          :label="$t('pleaseWait')"
          color="primary"
        />

        <q-input
          v-model="searchText"
          debounce="500"
          filled
          :placeholder="$t('search')"
          :loading="searchLoading"
          @change="onSearch"
        >
          <template v-slot:prepend>
            <q-icon name="search"/>
          </template>
        </q-input>


        <q-tree
          :nodes="categoryList"
          node-key="id"
          label-key="name"
          children-key="children"
          @lazy-load="onLazyLoad"
        >
          <template v-slot:default-header="prop">
            <div class="row items-center">
              <q-icon :name="prop.node.icon_class || 'star'" color="orange" class="q-mr-sm"/>
              <span class="q-mr-md">{{ prop.node.name }}</span>
              <q-badge color="orange" class="q-mr-md">{{ prop.node.price }}</q-badge>
              <q-btn
                class="q-mr-md"
                color="primary"
                icon-right="edit"
                no-caps
                flat
                dense
                :to="{name:'categoryEdit',params: {id:prop.node.id}}"
              />
              <q-btn
                color="red"
                icon-right="delete"
                no-caps
                flat
                dense
                @click="onDelete(prop.node.id)"
              />
            </div>
          </template>
        </q-tree>

        <div class="q-pa-lg flex flex-center">
          <q-pagination
            v-model="pagination.currentPage"
            :min="pagination.firstPage"
            :max="pagination.lastPage"
            :max-pages="6"
            direction-links
            @update:model-value="onPageChange"
          >
          </q-pagination>
        </div>

      </q-card-section>
    </q-card>
  </q-page>
</template>

<script>
import {defineComponent} from 'vue'
import {mapActions} from 'vuex'
import pagination from "src/helpers/paginationHelper";

export default defineComponent({
  name: 'CategoryList',
  data() {
    return {
      searchLoading: false,
      loading: true,
      searchText: '',
      categoryList: [],
      pagination: pagination.data,
    }
  },
  methods: {
    ...mapActions('category', ['deleteCategory', 'fetchCategories', 'fetchCategory']),
    query(data = {}, callback = false) {
      let $x = this;
      this.fetchCategories(data).then((res) => {
        pagination.setData($x.pagination, res.data.meta);
        res.data.data.map((v) => {
          v.lazy = true;
        });
        this.categoryList = Object.freeze(res.data.data);
        if (callback) {
          callback();
        }
      }).finally(function () {
        $x.loading = false;
      });
    },
    onSearch(val) {
      let $x = this;
      if (val.length > 1) {
        $x.searchLoading = true;
        this.query({params: {q: val}}, function () {
          $x.searchLoading = false;
        });
      }
    },
    onLazyLoad({node, done}) {
      this.fetchCategory({id: node.id, params: {with: ['children']}}).then((res) => {
        res.data.data.children.map((v) => {
          v.lazy = true;
        });
        done(res.data.data.children);
      }).catch(() => {
        done([]);
      });
    },
    onPageChange(page) {
      this.loading = true;
      let query = {
        params: {page}
      }
      if (this.searchText.length > 1) {
        query.params.q = this.searchText;
      }
      this.query(query);
    },
    onDelete(id) {
      if (confirm(this.$t('sureToDelete'))) {
        this.categoryList = this.recursiveRemove(this.categoryList, id);
        this.deleteCategory({id});
      }
    },
    recursiveRemove(list, id) {
      return list.map(item => {
        return {...item}
      }).filter(item => {
        if ('children' in item) {
          item.children = this.recursiveRemove(item.children, id);
        }
        return item.id !== id;
      });
    },
  },
  created() {
    this.query();
  },
});
</script>

