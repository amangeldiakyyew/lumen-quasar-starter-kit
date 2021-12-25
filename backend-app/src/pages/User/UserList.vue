<template>
  <q-page class="q-pa-sm">
    <q-card>
      <q-card-section>
        <div class="text-h6 text-grey-8">
          {{ $t('users') }}
          <div class="float-right">
            <q-btn :label="$t('add')" :to="{name:'userAdd'}" class="text-capitalize q-mr-md" icon="add"
                   color="primary"/>
            <q-btn :label="$t('bulkDelete')" @click="onBulkDelete()" class="text-capitalize" icon="delete"
                   color="red"/>
          </div>
        </div>
      </q-card-section>
      <q-card-section class="q-pa-none">
        <q-table
          :loading="loading"
          :columns="columns"
          :rows="userList"
          row-key="email"
          :filter="filter"
          selection="multiple"
          v-model:selected="selected"
          v-model:pagination="pagination"
          :rows-per-page-options="[15,25,30,40,50,100]"
          @request="onRequest"
        >
          <template #top-right>
            <q-input borderless dense debounce="300" v-model="filter" :placeholder="$t('search')">
              <template v-slot:append>
                <q-icon name="search"/>
              </template>
            </q-input>
          </template>

          <template #body-cell-createdAt="props">
            <q-td :props="props">
              {{ helpers.formatDate(props.row.created_at) }}
            </q-td>
          </template>

          <template #body-cell-action="props">
            <q-td :props="props">
              <q-btn
                class="q-mr-md"
                color="primary"
                icon-right="edit"
                no-caps
                flat
                dense
                :to="{name:'userEdit',params: {id:props.row.id}}"
              />
              <q-btn
                color="red"
                icon-right="delete"
                no-caps
                flat
                dense
                @click="onDelete(props)"
              />
            </q-td>
          </template>
        </q-table>
      </q-card-section>
    </q-card>
  </q-page>
</template>

<script>
import {defineComponent} from 'vue'
import {mapActions} from 'vuex'
import helpers from 'src/helpers/helper'

export default defineComponent({
  name: 'UserList',
  data() {
    return {
      helpers,
      userList: [],
      selected: [],
      filter: '',
      pagination: {
        page: 1,
        rowsPerPage: 25,
        rowsNumber: 0,
        sortBy: '',
        descending: false,
      },
      loading: true,
      columns: [
        {name: 'id', label: 'ID', field: 'id', align: 'left', sortable: true},
        {name: 'email', label: this.$t('email'), field: 'email', align: 'left', sortable: true},
        {name: 'fullName', label: this.$t('fullName'), field: 'full_name', align: 'left', sortable: false},
        {name: 'createdAt', label: this.$t('createdAt'), field: 'created_at', align: 'left'},
        {name: 'action', label: this.$t('actions'), field: 'action'}
      ]
    }
  },
  methods: {
    ...mapActions('user', ['fetchUsers', 'deleteUser']),
    request(params = {}) {
      this.fetchUsers(params).then((res) => {
        this.userList = res.data.data;
        this.pagination.page = res.data.meta.current_page;
        this.pagination.rowsPerPage = res.data.meta.per_page;
        this.pagination.rowsNumber = res.data.meta.total;
      }).finally(() => {
        this.loading = false;
      });
    },
    onRequest(props) {
      let sortBy = props.pagination.sortBy;
      if (this.pagination.descending) {
        this.pagination.descending = false;
      } else {
        this.pagination.descending = true;
        sortBy = '-' + sortBy;
      }
      this.request({
        page: props.pagination.page,
        per_page: props.pagination.rowsPerPage,
        sort_by: sortBy,
        q: JSON.parse(JSON.stringify(props.filter))
      });
    },
    onDelete(item) {
      const index = this.userList.indexOf(item.row);
      if (confirm(this.$t('sureToDelete'))) {
        this.userList.splice(index, 1);
        this.deleteUser({id: item.row.id});
      }
    },
    onBulkDelete() {
      if (confirm(this.$t('sureToDelete'))) {
        const ids = this.selected.map(x => x.id);
        ids.forEach((x, i) => {
          let index = this.userList.findIndex(function (u) {
            return u.id === x;
          });
          if (index !== -1) {
            this.userList.splice(index, 1);
          }
          this.deleteUser({id: x});
        });
      }

    }
  },
  created() {
    this.request();
  }
})
</script>
