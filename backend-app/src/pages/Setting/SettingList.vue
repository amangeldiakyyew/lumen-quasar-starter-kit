<template>
  <q-page class="q-pa-sm">
    <q-card>
      <q-card-section>
        <div class="text-h6 text-grey-8">
          {{ $t('settings') }}
          <div class="float-right">
          </div>
        </div>
      </q-card-section>

      <q-card-section class="q-pa-none">
        <q-tabs
          v-model="activeTab"
          narrow-indicator
          mobile-arrows
          class="text-grey"
          active-color="primary"
          indicator-color="primary"
          align="left"
        >
          <q-tab v-for="(settingGroup , index) in settingGroups"
                 :key="index"
                 :name="settingGroup.key"
                 :label="settingGroup.name"/>
        </q-tabs>
        <q-separator/>
        <q-tab-panels v-model="activeTab" animated>
          <q-tab-panel v-for="(settingGroup , index) in settingGroups"
                       :key="index"
                       :name="settingGroup.key"
                       class="q-gutter-md">
            <div class="text-h6">{{ settingGroup.name }}</div>
            <div v-for="(setting,i) in settingGroup.settings" :key="i">
              <q-input
                v-if="setting.type==='text'"
                filled
                type="text"
                v-model="setting.value"
                :label="setting.name"
              />
              <q-input
                v-else-if="setting.type==='number'"
                filled
                type="number"
                v-model="setting.value"
                :label="setting.name"
              />
              <q-toggle
                v-else-if="setting.type==='switch'"
                v-model="setting.value"
                :label="setting.name"
                :true-value="'1'"
                :false-value="'0'"
              />
              <q-uploader
                v-else-if="setting.type==='image'"
                auto-upload
                max-files="1"
                :flat="true"
                :label="setting.name"
                :url="uploadUrl"
                :field-name="setting.key"
                :form-fields="[{name:'type',value:'setting'}]"
                accept="image/*"
                @uploaded="fileUploaded($event,setting)"
                @added="fileAdded"
              >
              </q-uploader>
              <img v-if="setting.type==='image' && helper.isObject(setting.value)" :src="helper.image(setting.value)"
                   alt="" style="max-height: 60px;width: auto;">
            </div>
          </q-tab-panel>
        </q-tab-panels>
      </q-card-section>

      <q-card-section>
        <q-btn :loading="saving" :label="$t('save')" @click="saveSettings" type="button" color="primary"/>
      </q-card-section>

    </q-card>
  </q-page>
</template>

<script>
import {defineComponent} from 'vue'
import {mapActions} from 'vuex'
import {CONSTANTS} from "boot/constants";
import helper from "src/helpers/helper";


export default defineComponent({
  name: 'SettingList',
  data() {
    return {
      saving: false,
      helper: helper,
      test: '',
      uploadUrl: CONSTANTS.baseApiUrl + '/upload/',
      activeTab: '',
      settingGroups: [],
    }
  },
  methods: {
    ...mapActions('setting', ['fetchSettings', 'updateSettings']),
    request() {
      let $x = this;
      this.fetchSettings().then(function (res) {
        $x.activeTab = res.data[0].key;
        $x.settingGroups = res.data;
      });
    },
    saveSettings() {
      if (this.settingGroups.length >= 2) {
        this.saving = true;
        this.updateSettings({formData: this.settingGroups}).then(res => {
          helper.notify(res.data);
        }).finally(() => {
          this.saving = false;
        });
      }
    },
    fileUploaded(info, settingObj) {
      settingObj.value = JSON.parse(info.xhr.responseText);
    },
    fileAdded(info) {
      //console.log(info);
    }
  },
  created() {
    this.request();
  }
})
</script>
