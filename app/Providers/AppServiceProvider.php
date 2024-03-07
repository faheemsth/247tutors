<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\WebSetting;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();


        $keys = array(
            "topbaremail",
            "Ph_num",
            "Maintopbaremail",
            "MainPh_num",
            "fblink",
            "instlink",
            "xlink",
            "inlink",

            "hero_title",
            "hero_desc",
            "highlight_text",
            "hero_short_desc",


            "card1_title",
            "card1_desc",
            "card2_title",
            "card2_desc",
            "card3_title",
            "card3_desc",
            "card4_title",
            "card4_desc",

            "st_one",
            "st_two",
            "st_three",
            "st_four",

            "tutor_one",
            "tutor_two",
            "tutor_three",
            "tutor_four",

            "org_one",
            "org_two",
            "org_three",
            "org_four",

            "faq_desc",
            "accfirst_title",
            "accfirst_desc",
            "accsec_title",
            "accsec_desc",
            "accthird_title",
            "accthird_desc",
            "accfour_title",
            "accfour_desc",

            "pricing_title",
            "pricing_desc",
            "pricing_short_desc",

            "pricecard1_desc",
            "pricecard2_desc",
            "pricecard3_desc",
            "price_desc",

            "card5_title",
            "card5_desc",
            "card6_title",
            "card6_desc",

        );

          $web_settings = array();

          $settings = WebSetting::whereIn('field_key', $keys)->get();

          if (sizeOf($settings) > 0) {
            foreach ($settings as $setting) {
              $web_settings[$setting->field_key] = $setting->field_value;
            }
          }

          View::share('web_settings',$web_settings);
    }
}
