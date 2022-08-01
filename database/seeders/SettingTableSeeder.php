<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->insert([[
            'key' => 'date_format',
            'value' => 'd M, Y',
            'created_at' => now(),
            'updated_at' => now()
        ], [
            'key' => 'datetime_format',
            'value' => 'd M, Y',
            'created_at' => now(),
            'updated_at' => now()
        ], [
            'key' => 'site_title',
            'value' => env('APP_NAME'),
            'created_at' => now(),
            'updated_at' => now()
        ], [
            'key' => 'site_description',
            'value' => 'Description for your portal !',
            'created_at' => now(),
            'updated_at' => now()
        ], [
            'key' => 'envato_purchasecode',
            'value' => null,
            'created_at' => now(),
            'updated_at' => now()
        ],[
            'key' => 'site_logo',
            'value' => 'default.png',
            'created_at' => now(),
            'updated_at' => now()
        ], [
            'key' => 'site_favicon',
            'value' => 'favicon.png',
            'created_at' => now(),
            'updated_at' => now()
        ], [
            'key' => 'CAPTCHATYPE',
            'value' => 'off',
            // 'value' => '6LdIWswUAAAAAMRp6xt2wBu7V59jUvZvKWf_rbJc',
            'created_at' => now(),
            'updated_at' => now()
        ],[
            'key' => 'GOOGLE_RECAPTCHA_KEY',
            'value' => '',
            // 'value' => '6LdIWswUAAAAAMRp6xt2wBu7V59jUvZvKWf_rbJc',
            'created_at' => now(),
            'updated_at' => now()
        ], [
            'key' => 'GOOGLE_RECAPTCHA_SECRET',
            'value' => '',
            // 'value' => '6LdIWswUAAAAAIsdboq_76c63PHFsOPJHNR-z-75',
            'created_at' => now(),
            'updated_at' => now()
        ], [
            'key' => 'USER_REOPEN_ISSUE',
            'value' => 'yes',
            'created_at' => now(),
            'updated_at' => now()
        ], [
            'key' => 'USER_REOPEN_TIME',
            'value' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ], [
            'key' => 'AUTO_CLOSE_TICKET',
            'value' => 'yes',
            'created_at' => now(),
            'updated_at' => now()
        ],  [
            'key' => 'AUTO_CLOSE_TICKET_TIME',
            'value' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ], [
            'key' => 'AUTO_OVERDUE_TICKET',
            'value' => 'yes',
            'created_at' => now(),
            'updated_at' => now()
        ],  [
            'key' => 'AUTO_OVERDUE_TICKET_TIME',
            'value' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ],[
            'key' => 'AUTO_RESPONSETIME_TICKET',
            'value' => 'yes',
            'created_at' => now(),
            'updated_at' => now()
        ],  [
            'key' => 'AUTO_RESPONSETIME_TICKET_TIME',
            'value' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ],[
            'key' => 'CUSTOMER_TICKETID',
            'value' => 'SP',
            'created_at' => now(),
            'updated_at' => now()
        ],  [
            'key' => 'GUEST_TICKET',
            'value' => 'yes',
            'created_at' => now(),
            'updated_at' => now()
        ],[
            'key' => 'PRIORITY_ENABLE',
            'value' => 'no',
            'created_at' => now(),
            'updated_at' => now()
        ], [
            'key' => 'REGISTER_POPUP',
            'value' => 'no',
            'created_at' => now(),
            'updated_at' => now()
        ],[
            'key' => 'REGISTER_DISABLE',
            'value' => 'on',
            'created_at' => now(),
            'updated_at' => now()
        ], [
            'key' => 'CUSTOMER_CLOSE_TICKET',
            'value' => 'yes',
            'created_at' => now(),
            'updated_at' => now()
        ], [
            'key' => 'USER_FILE_UPLOAD_ENABLE',
            'value' => 'yes',
            'created_at' => now(),
            'updated_at' => now()
        ], [
            'key' => 'GUEST_FILE_UPLOAD_ENABLE',
            'value' => 'yes',
            'created_at' => now(),
            'updated_at' => now()
        ], [
            'key' => 'GOOGLE_ANALYTICS_ENABLE',
            'value' => 'no',
            'created_at' => now(),
            'updated_at' => now()
        ],
        [
            'key' => 'AUTO_NOTIFICATION_DELETE_ENABLE',
            'value' => 'on',
            'created_at' => now(),
            'updated_at' => now()
        ],
        [
            'key' => 'AUTO_NOTIFICATION_DELETE_DAYS',
            'value' => '60',
            'created_at' => now(),
            'updated_at' => now()
        ],
        [
            'key' => 'GOOGLE_ANALYTICS',
            'value' => null,
            'created_at' => now(),
            'updated_at' => now()
        ], [
            'key' => 'FILE_UPLOAD_MAX',
            'value' => '3',
            'created_at' => now(),
            'updated_at' => now()
        ], [
            'key' => 'FILE_UPLOAD_TYPES',
            'value' => '.jpg,.jpeg,.png',
            'created_at' => now(),
            'updated_at' => now()
        ], [
            'key' => 'KNOWLEDGE_ENABLE',
            'value' => 'yes',
            'created_at' => now(),
            'updated_at' => now()
        ],[
            'key' => 'FAQ_ENABLE',
            'value' => 'yes',
            'created_at' => now(),
            'updated_at' => now()
        ], 
        [
            'key' => 'CONTACT_ENABLE',
            'value' => 'yes',
            'created_at' => now(),
            'updated_at' => now()
        ],
        [
            'key' => 'MAINTENANCE_MODE',
            'value' => 'off',
            'created_at' => now(),
            'updated_at' => now()
        ],[
            'key' => 'MAINTENANCE_MODE_VALUE',
            'value' => null,
            'created_at' => now(),
            'updated_at' => now()
        ],[
            'key' => 'PROFILE_USER_ENABLE',
            'value' => 'yes',
            'created_at' => now(),
            'updated_at' => now()
        ],[
            'key' => 'PROFILE_AGENT_ENABLE',
            'value' => 'yes',
            'created_at' => now(),
            'updated_at' => now()
        ],[
            'key' => 'RECAPTCH_ENABLE_REGISTER',
            'value' => 'no',
            'created_at' => now(),
            'updated_at' => now()
        ],[
            'key' => 'RECAPTCH_ENABLE_CONTACT',
            'value' => 'no',
            'created_at' => now(),
            'updated_at' => now()
        ],[
            'key' => 'RECAPTCH_ENABLE_LOGIN',
            'value' => 'no',
            'created_at' => now(),
            'updated_at' => now()
        ],[
            'key' => 'RECAPTCH_ENABLE_GUEST',
            'value' => 'no',
            'created_at' => now(),
            'updated_at' => now()
        ], 
        [
            'key' => 'COUNTRY_BLOCKTYPE',
            'value' => 'block',
            'created_at' => now(),
            'updated_at' => now()
        ],
        [
            'key' => 'COUNTRY_LIST',
            'value' => '',
            'created_at' => now(),
            'updated_at' => now()
        ],
        
        [
            'key' => 'ADMIN_COUNTRY_BLOCKTYPE',
            'value' => 'block',
            'created_at' => now(),
            'updated_at' => now()
        ],
        
        [
            'key' => 'ADMIN_COUNTRY_LIST',
            'value' => '',
            'created_at' => now(),
            'updated_at' => now()
        ],
        [
            'key' => 'DOS_Enable',
            'value' => 'off',
            'created_at' => now(),
            'updated_at' => now()
        ],
        [
            'key' => 'IPMAXATTEMPT',
            'value' => '10',
            'created_at' => now(),
            'updated_at' => now()
        ],
        [
            'key' => 'IPSECONDS',
            'value' => '30',
            'created_at' => now(),
            'updated_at' => now()
        ],
        [
            'key' => 'IPBLOCKTYPE',
            'value' => 'captcha',
            'created_at' => now(),
            'updated_at' => now()
        ],
        [
            'key' => 'GOOGLEFONT_DISABLE',
            'value' => 'off',
            'created_at' => now(),
            'updated_at' => now()
        ],
        [
            'key' => 'FORCE_SSL',
            'value' => 'off',
            'created_at' => now(),
            'updated_at' => now()
        ],
        [
            'key' => 'DARK_MODE',
            'value' => '0',
            'created_at' => now(),
            'updated_at' => now()
        ],
        [
            'key' => 'SPRUKOADMIN_P',
            'value' => 'on',
            'created_at' => now(),
            'updated_at' => now()
        ],
        [
            'key' => 'SPRUKOADMIN_C',
            'value' => 'off',
            'created_at' => now(),
            'updated_at' => now()
        ],
        [
            'key' => 'ticket_default_assigned_user_id',
            'value' => 2,
            'created_at' => now(),
            'updated_at' => now()
        ], [
            'key' => 'social_media_facebook',
            'value' => '',
            'created_at' => now(),
            'updated_at' => now()
        ], [
            'key' => 'social_media_instagram',
            'value' => '',
            'created_at' => now(),
            'updated_at' => now()
        ], [
            'key' => 'social_media_twitter',
            'value' => '',
            'created_at' => now(),
            'updated_at' => now()
        ], [
            'key' => 'social_media_youtube',
            'value' => '',
            'created_at' => now(),
            'updated_at' => now()
        ], [
            'key' => 'social_media_pinterest',
            'value' => '',
            'created_at' => now(),
            'updated_at' => now()
        ], [
            'key' => 'social_media_envato',
            'value' => '',
            'created_at' => now(),
            'updated_at' => now()
        ], [
            'key' => 'default_lang',
            'value' => 'english',
            'created_at' => now(),
            'updated_at' => now()
        ], [
            'key' => 'theme_color',
            'value' => 'rgba(51 ,102 ,255, 1)',
            'created_at' => now(),
            'updated_at' => now()
        ], [
            'key' => 'theme_color_dark',
            'value' => 'rgba(24, 71, 128, 1)',
            'created_at' => now(),
            'updated_at' => now()
        ], [
            'key' => 'popular_categories',
            'value' => '[]',
            'created_at' => now(),
            'updated_at' => now()
        ], [
            'key' => 'home_featured_categories',
            'value' => '[]',
            'created_at' => now(),
            'updated_at' => now()
        ], [
            'key' => 'home_categories',
            'value' => '[]',
            'created_at' => now(),
            'updated_at' => now()
        ], [
            'key' => 'home_max_articles',
            'value' => '10',
            'created_at' => now(),
            'updated_at' => now()
        ], [
            'key' => 'mail_driver',
            'value' => env('MAIL_DRIVER', 'sendmail'),
            'created_at' => now(),
            'updated_at' => now()
        ], [
            'key' => 'mail_host',
            'value' => env('MAIL_HOST', 'smtp.mailtrap.io'),
            'created_at' => now(),
            'updated_at' => now()
        ], [
            'key' => 'mail_port',
            'value' => env('MAIL_PORT', '2525'),
            'created_at' => now(),
            'updated_at' => now()
        ], [
            'key' => 'mail_from_address',
            'value' => env('MAIL_FROM_ADDRESS', 'admin@example.com'),
            'created_at' => now(),
            'updated_at' => now()
        ], [
            'key' => 'mail_from_name',
            'value' => env('MAIL_FROM_NAME', 'smtp'),
            'created_at' => now(),
            'updated_at' => now()
        ], [
            'key' => 'mail_encryption',
            'value' => env('MAIL_ENCRYPTION', 'ssl'),
            'created_at' => now(),
            'updated_at' => now()
        ], [
            'key' => 'MAIL_USERNAME',
            'value' => env('MAIL_USERNAME', ''),
            'created_at' => now(),
            'updated_at' => now()
        ], [
            'key' => 'MAIL_PASSWORD',
            'value' => env('MAIL_PASSWORD', ''),
            'created_at' => now(),
            'updated_at' => now()
        ],
        [
            'key' => 'IMAP_STATUS',
            'value' => 'off',
            'created_at' => now(),
            'updated_at' => now()
        ],
        [
            'key' => 'IMAP_HOST',
            'value' => env('IMAP_HOST', null),
            'created_at' => now(),
            'updated_at' => now()
        ], [
            'key' => 'IMAP_PORT',
            'value' => env('IMAP_PORT', null),
            'created_at' => now(),
            'updated_at' => now()
        ],  [
            'key' => 'IMAP_PROTOCOL',
            'value' => env('IMAP_PROTOCOL', null),
            'created_at' => now(),
            'updated_at' => now()
        ], [
            'key' => 'IMAP_ENCRYPTION',
            'value' => env('IMAP_ENCRYPTION', null),
            'created_at' => now(),
            'updated_at' => now()
        ], [
            'key' => 'IMAP_USERNAME',
            'value' => env('IMAP_USERNAME', ''),
            'created_at' => now(),
            'updated_at' => now()
        ], [
            'key' => 'IMAP_PASSWORD',
            'value' => env('IMAP_PASSWORD', ''),
            'created_at' => now(),
            'updated_at' => now()
        ]
    ]);
    }
}
