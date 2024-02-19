<?php

namespace Database\Seeders;

use App\Models\WebSetting;
use Illuminate\Database\Seeder;
use App\Http\Controllers\WebsiteSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class WebSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $data = array(
            "topbaremail" => '',
            "Ph_num" => '',
            "fblink" => '',
            "instlink" => '',
            "xlink" => '',
            "inlink" => '',

            "hero_title" => '',
            "hero_desc" => '',
            "highlight_text" => '',
            "hero_short_desc" => '',


            "card1_title" => '',
            "card1_desc" => '',
            "card2_title" => '',
            "card2_desc" => '',
            "card3_title" => '',
            "card3_desc" => '',
            "card4_title" => '',
            "card4_desc" => '',

            "st_one" => '',
            "st_two" => '',
            "st_three" => '',
            "st_four" => '',

            "tutor_one" => '',
            "tutor_two" => '',
            "tutor_three" => '',
            "tutor_four" => '',

            "org_one" => '',
            "org_two" => '',
            "org_three" => '',
            "org_four" => '',

            "faq_desc" => '',
            "accfirst_title" => '',
            "accfirst_desc" => '',
            "accsec_title" => '',
            "accsec_desc" => '',
            "accthird_title" => '',
            "accthird_desc" => '',
            "accfour_title" => '',
            "accfour_desc" => '',

            "pricing_title" => '',
            "pricing_desc" => '',
            "pricing_short_desc" => '',

            "pricecard1_desc" => '',
            "pricecard2_desc" => '',
            "pricecard3_desc" => '',
            "price_desc"=>'',

            "card5_title" => '',
            "card5_desc" => '',
            "card6_title" => '',
            "card6_desc" => '',

        );

        foreach ($data as $key => $value) {
          $sys_setting = new WebSetting();
          $sys_setting->field_key = $key;
          $sys_setting->field_value = $value;
          $sys_setting->save();
        }

    }
}
