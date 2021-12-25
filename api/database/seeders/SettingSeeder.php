<?php

namespace Database\Seeders;

use App\Models\SettingGroupModel;
use App\Models\SettingModel;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $groupData = [
            [
                'key' => 'general',
                'name' => 'Genel',
                'data' => [
                    [
                        'name' => 'Ücretsiz Ürün Ekleme',
                        'type' => 'switch',
                        'key' => 'add_products_free',
                        'value' => 1,
                        'hint' => '',
                    ],
                ]
            ],
            [
                'key' => 'site',
                'name' => 'Site',
                'data' => [
                    [
                        'name' => 'Bakım Modu',
                        'type' => 'switch',
                        'key' => 'maintenance',
                        'value' => 0,
                        'hint' => '',
                    ],
                    [
                        'name' => 'Logo',
                        'type' => 'image',
                        'key' => 'logo',
                        'value' => '',
                        'hint' => '',
                    ],
                    [
                        'name' => 'Favicon',
                        'type' => 'image',
                        'key' => 'favicon',
                        'value' => '',
                        'hint' => '',
                    ],
                    [
                        'name' => 'Footer Ödeme Resmi',
                        'type' => 'image',
                        'key' => 'payment_image',
                        'value' => '',
                        'hint' => '',
                    ],
                ]
            ],
            [
                'key' => 'mail',
                'name' => 'Mail',
                'data' => [
                    [
                        'name' => 'SMTP Host',
                        'type' => 'text',
                        'key' => 'smtp_host',
                        'value' => '',
                        'hint' => '',
                    ],
                    [
                        'name' => 'SMTP Kullanıcı Adı',
                        'type' => 'text',
                        'key' => 'smtp_username',
                        'value' => '',
                        'hint' => '',
                    ],
                    [
                        'name' => 'SMTP Şifre',
                        'type' => 'text',
                        'key' => 'smtp_password',
                        'value' => '',
                        'hint' => '',
                    ],
                    [
                        'name' => 'SMTP Port',
                        'type' => 'number',
                        'key' => 'smtp_port',
                        'value' => '',
                        'hint' => '',
                    ],
                    [
                        'name' => 'SMTP Mail Şifreleme',
                        'type' => 'switch',
                        'key' => 'smtp_encryption',
                        'value' => 0,
                        'hint' => '',
                    ],
                ]
            ],
            [
                'key' => 'mail_notification',
                'name' => 'Mail Bildirimi',
                'data' => [
                    [
                        'name' => 'Hoşgeldiniz Maili',
                        'type' => 'switch',
                        'key' => 'on_register',
                        'value' => 1,
                        'hint' => '',
                    ],
                ]
            ],
        ];

        $gi = 0;
        foreach ($groupData as $groupDatum) {
            $gi++;
            $sg = SettingGroupModel::query()->where('key', $groupDatum['key'])->first();
            if (!$sg) {
                $groupDatum['sort_order'] = $gi;
                $sg = SettingGroupModel::query()->create([
                    'name' => $groupDatum['name'],
                    'key' => $groupDatum['key'],
                    'sort_order' => $gi,
                ]);
            }

            if ($sg) {
                $si = 0;
                foreach ($groupDatum['data'] as $settingDatum) {
                    $si++;
                    $s = SettingModel::query()
                        ->where('group_id', $sg->id)
                        ->where('key', $settingDatum['key'])
                        ->first();
                    if (!$s) {
                        $settingDatum['group_id'] = $sg->id;
                        $settingDatum['sort_order'] = $si;
                        $s = SettingModel::query()->create($settingDatum);
                    }
                }
            }
        }

    }
}
