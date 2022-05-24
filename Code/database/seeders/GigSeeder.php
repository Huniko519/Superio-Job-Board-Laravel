<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Gig\Models\Gig;
use Modules\Gig\Models\GigCategory;
use Modules\Gig\Models\GigCategoryType;
use Modules\Review\Models\Review;
use Modules\Review\Models\ReviewMeta;
use Modules\Gig\Models\GigOrder;

class GigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        $cat_image_id = DB::table('media_files')->insertGetId(['file_name' => 'gig-category-img', 'file_path' => 'demo/gig/category-img.png', 'file_type' => 'image/png', 'file_extension' => 'png']);
        $subcat_image_ids[] = DB::table('media_files')->insertGetId(['file_name' => 'gig-sub-cat-1', 'file_path' => 'demo/gig/sub-cat-1.png', 'file_type' => 'image/png', 'file_extension' => 'png']);
        $subcat_image_ids[] = DB::table('media_files')->insertGetId(['file_name' => 'gig-sub-cat-2', 'file_path' => 'demo/gig/sub-cat-2.png', 'file_type' => 'image/png', 'file_extension' => 'png']);
        $subcat_image_ids[] = DB::table('media_files')->insertGetId(['file_name' => 'gig-sub-cat-3', 'file_path' => 'demo/gig/sub-cat-3.png', 'file_type' => 'image/png', 'file_extension' => 'png']);
        $subcat_image_ids[] = DB::table('media_files')->insertGetId(['file_name' => 'gig-sub-cat-4', 'file_path' => 'demo/gig/sub-cat-4.png', 'file_type' => 'image/png', 'file_extension' => 'png']);
        $subcat_image_ids[] = DB::table('media_files')->insertGetId(['file_name' => 'gig-sub-cat-5', 'file_path' => 'demo/gig/sub-cat-5.png', 'file_type' => 'image/png', 'file_extension' => 'png']);


        $type_image_ids[] = DB::table('media_files')->insertGetId(['file_name' => 'gig-type1', 'file_path' => 'demo/gig/type1.png', 'file_type' => 'image/png', 'file_extension' => 'png']);
        $type_image_ids[] = DB::table('media_files')->insertGetId(['file_name' => 'gig-type2', 'file_path' => 'demo/gig/type2.png', 'file_type' => 'image/png', 'file_extension' => 'png']);
        $type_image_ids[] = DB::table('media_files')->insertGetId(['file_name' => 'gig-type3', 'file_path' => 'demo/gig/type3.png', 'file_type' => 'image/png', 'file_extension' => 'png']);
        $type_image_ids[] = DB::table('media_files')->insertGetId(['file_name' => 'gig-type4', 'file_path' => 'demo/gig/type4.png', 'file_type' => 'image/png', 'file_extension' => 'png']);

        $children = [];
        $childrenLv2 = [];

        for($i = 1; $i <= 4; $i++){
            $childrenLv2[] = ['name'=>$faker->sentence(rand(2,3)),'image_id'=>$subcat_image_ids[rand(0,count($subcat_image_ids)-1)],'content'=>$faker->paragraph()];
        }

        for($i = 1; $i <= 3; $i++){
            $children[] = ['name'=>$i == 1 ? 'Logo Design' : $faker->sentence(rand(2,3)),'image_id'=>$subcat_image_ids[rand(0,count($subcat_image_ids)-1)],'content'=>$faker->paragraph(),'children'=>$childrenLv2];
        }

        $faqs = [
            ['title'=>$faker->sentence(2),'content'=>$faker->paragraph()],
            ['title'=>$faker->sentence(2),'content'=>$faker->paragraph()],
            ['title'=>$faker->sentence(2),'content'=>$faker->paragraph()],
            ['title'=>$faker->sentence(2),'content'=>$faker->paragraph()],
        ];

        $cats = [
            'Graphics & Design',
            'Digital Marketing',
            'Video & Animation',
        ];
        $cat_objects = [];
        foreach ($cats as $name){
            $cat_objects [] = $root_cat = GigCategory::create([
                'name'=>$name,
                'content'=>$faker->paragraph(),
                'image_id'=>$cat_image_id,
                'children'=>$children,
                'news_cat_id'=>rand(1,8),
                'faqs'=>$faqs
            ]);
            GigCategoryType::create([
                'name'=>$faker->sentence(2),
                'cat_id'=>$root_cat->id,
                'cat_children'=>$root_cat->children->pluck('id')->random(rand(2,3))->all(),
                'image_id'=>$type_image_ids[rand(0,count($type_image_ids) - 1)]
            ]);
            GigCategoryType::create([
                'name'=>$faker->sentence(2),
                'cat_id'=>$root_cat->id,
                'cat_children'=>$root_cat->children->pluck('id')->random(rand(2,3))->all(),
                'image_id'=>$type_image_ids[rand(0,count($type_image_ids) - 1)]
            ]);
            GigCategoryType::create([
                'name'=>$faker->sentence(2),
                'cat_id'=>$root_cat->id,
                'cat_children'=>$root_cat->children->pluck('id')->random(rand(2,3))->all(),
                'image_id'=>$type_image_ids[rand(0,count($type_image_ids) - 1)]
            ]);
        }

        for($i = 1; $i <= 20; $i++){
            $cat = $cat_objects[rand(0,count($cat_objects) - 1)];
            $delivery_time= rand(1,3);
            $gig = Gig::create([
               'title'=>$i == 1 ? 'I will Quod corrupti veritatis' : 'I will '.$faker->sentence(),
                'basic_price'=>rand(5,10),
                'standard_price'=>rand(15,50),
                'premium_price'=>rand(100,300),
                'basic_delivery_time'=>$delivery_time,
                'packages'=>[
                    ['name'=>'Basic','key'=>'basic','desc'=>$faker->sentence(),'delivery_time'=>$delivery_time,'revision'=>3],
                    ['name'=>'Standard','key'=>'standard','desc'=>$faker->sentence(),'delivery_time'=>4,'revision'=>3],
                    ['name'=>'Premium','key'=>'premium','desc'=>$faker->sentence(),'delivery_time'=>6,'revision'=>3],
                ],
                'package_compare'=>[
                    ['name'=>$faker->sentence(3),'content'=>'No','content1'=>'Yes','content2'=>'Yes'],
                    ['name'=>$faker->sentence(3),'content'=>'No','content1'=>'Yes','content2'=>'Yes'],
                    ['name'=>$faker->sentence(3),'content'=>'No','content1'=>'Yes','content2'=>'Yes'],
                ],
                'content'=>$faker->paragraphs(10,true),
                'author_id'=>1,
                'image_id'=>$type_image_ids[rand(0,count($type_image_ids) - 1)],
                'gallery'=>implode(', ',$type_image_ids),
                'cat_id'=>$cat->id,
                'cat2_id'=>$cat->children[0]->id ?? 0,
                'cat3_id'=>$cat->children[0]->children[0]->id ?? 0,
                'video_url'=>'https://www.youtube.com/watch?v=K1QICrgxTjA',
                'status'=>'publish'
            ]);

            for ($k = 1 ; $k <= 3 ; $k++){
                $metaReview = [];
                $list_meta = [
                    "Service",
                    "Organization",
                    "Friendliness",
                    "Area Expert",
                    "Safety",
                ];
                $total_point = 0;
                foreach ($list_meta as $key => $value) {
                    $point = rand(4,5);
                    $total_point += $point;
                    $metaReview[] = [
                        "object_id"    => $gig->id,
                        "object_model" => "gig",
                        "name"         => $value,
                        "val"          => $point,
                        "create_user"  => "1",
                    ];
                }
                $rate = round($total_point / count($list_meta), 1);
                if ($rate > 5) $rate = 5;
                $review = new Review([
                    "object_id"    => $gig->id,
                    "object_model" => "gig",
                    "title"        => $faker->sentence(2),
                    "content"      => "Eum eu sumo albucius perfecto, commodo torquatos consequuntur pro ut, id posse splendide ius. Cu nisl putent omittantur usu, mutat atomorum ex pro, ius nibh nonumy id. Nam at eius dissentias disputando, molestie mnesarchum complectitur per te",
                    "rate_number"  => $rate,
                    "author_ip"    => "127.0.0.1",
                    "status"       => "approved",
                    "publish_date" => date("Y-m-d H:i:s"),
                    'create_user' => rand(1,2),
                    'vendor_id' => $gig->author_id,
                ]);
                if ($review->save()) {
                    if (!empty($metaReview)) {
                        foreach ($metaReview as $meta) {
                            $meta['review_id'] = $review->id;
                            $reviewMeta = new ReviewMeta($meta);
                            $reviewMeta->save();
                        }
                    }
                }
            }

            $gig->update_service_rate();
            //create order
//            GigOrder::create([
//                'order_item_id'=>'',
//                'gig_id'=>$gig->id,
//                'author_id'=>$gig->author_id,
//                'customer_id'=>1,
//                'create_user'=>1,
//                'created_at'=>date("Y-m-d H:i:s")
//            ]);
        }
        setting_update_item('gig_booking_buyer_fees',[
            [
                'name'=>'Service fee',
                'price'=>'2',
                'unit'=>'fixed'
            ]
        ]);
    }
}
