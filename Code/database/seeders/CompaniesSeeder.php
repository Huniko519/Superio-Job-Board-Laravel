<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Modules\Media\Models\MediaFile;
use Modules\Core\Models\Attributes;

class CompaniesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $team_size = DB::table('bc_attrs')->insertGetId([
            'name'=>'Company size',
            'slug'=>'company-size',
            'service'=>'company'
        ]);
        if($team_size)
        {
            $terms = [
                ['name'=>'10-50 Members','slug'=>'10-50-member','attr_id'=>$team_size],
                ['name'=>'50-100 Members','slug'=>'50-100-member','attr_id'=>$team_size],
                ['name'=>'100-200 Members','slug'=>'100-200-member','attr_id'=>$team_size],
                ['name'=>'200-500 Members','slug'=>'200-500-member','attr_id'=>$team_size],
                ['name'=>'500-1000 Members','slug'=>'500-1000-member','attr_id'=>$team_size],
                ['name'=>'1000-10000 Members','slug'=>'1000-10000','attr_id'=>$team_size]
            ];
            DB::table('bc_terms')->insert($terms);
        }
        $users = \App\User::where('role_id', 2)->take(12)->get();
        $company_name = ['Netflix','Opendoor','Checkr','Mural','Astronomer','Figma','Stripe','Invision','Samsung','Nokia','VinFast','Apple'];
        $maps = [
            'map_lat' => ['40.94401669296697','40.77055783505125','40.7427837','40.70437865245596','40.641311','41.080938','41.079386','40.77055783505125','40.7427837','40.70437865245596','40.641311', '40.94401669296697'],
            'map_lng' => ['-74.16938781738281','-74.26002502441406','-73.11445617675781','-73.98674011230469','-73.778139','-73.535957','-73.519478','-74.16938781738281','-74.26002502441406','-73.11445617675781','-73.98674011230469','-73.778139']
        ];
        foreach ($users as $key => $user)
        {
            $category = \Modules\Candidate\Models\Category::where('status','publish')->inRandomOrder()->first();
            $name = $company_name[$key];
            DB::table('bc_companies')->insert(
                [
                    'name' => $name,
                    'slug'=>Str::slug($name),
                    'email' => $user->email,
                    'phone'   => '112 666 888',
                    'website'=> 'https://'.Str::slug($name).'.com',
                    'avatar_id'=>MediaFile::findMediaByName("bc_company-".($key +1))->id,
                    'cover_id'=>2,
                    'founded_in'=>date("Y-m-d"),
                    'allow_search'   => 1,
                    'owner_id'=>$user->id,
                    'category_id'=>$category ? $category->id : 0,
                    'team_size'=>1,
                    'map_lat' => $maps['map_lat'][$key],
                    'map_lng' => $maps['map_lng'][$key],
                    'about'=>'<h4>Hello! This is my story.</h4>
                        <p>Hello! I am a Seattle/Tacoma, Washington area graphic designer with over 6 years of graphic design experience. I specialize in designing infographics, icons, brochures, and flyers.</p>
                        <ul class="instructor_estimate">
                            <li>Included in my estimate:</li>
                            <li>Custom illustrations</li>
                            <li>Stock images</li>
                            <li>Any final files you need</li>
                        </ul>
                        <p>If you have a specific budget or deadline, let me know and I will work with you!</p>',
                    'social_media' => '{"skype":"bookingcore.org","facebook":"https:\/\/bookingcore.org\/","twitter":"https:\/\/bookingcore.org\/","instagram":"https:\/\/bookingcore.org\/","pinterest":"https:\/\/bookingcore.org\/","dribbble":"https:\/\/bookingcore.org\/","google":"https:\/\/bookingcore.org\/"}',
                    'city'=>'London',
                    'country' => 'UK',
                    'address'=>'Washington',
                    'status'   => 'publish',
                    'location_id'=>1,
                    'created_at' =>  date("Y-m-d H:i:s"),
                    'is_featured'=>rand(0,1)
                ]);
        }

        // Settings
        DB::table('core_settings')->insert(
            [
                [
                    'name' => 'company_page_search_title',
                    'val' => 'Find Companies',
                ],
                [
                    'name' => 'company_page_search_title_ja',
                    'val' => '会社を探す',
                ],
                [
                    'name' => 'company_list_layout',
                    'val' => 'company-list-v1',
                ],
                [
                    'name' => 'single_company_layout',
                    'val' => 'company-single-v1',
                ],
                [
                    'name' => 'company_sidebar_search_fields',
                    'val' => '[{"title":"Search by Keywords","type":"keyword","position":"1"},{"title":"Location","type":"location","position":"2"},{"title":"Category","type":"category","position":"3"},{"title":"Attribute","type":"att","position":"4"},{"title":"Founded Date","type":"founded_date","position":"5"}]',
                ],
                [
                    'name' => 'company_sidebar_cta',
                    'val' => '{"title":"Recruiting?","desc":"Advertise your jobs to millions of monthly users and search 15.8 million CVs in our database.","button":{"url":"#","name":"Start Recruiting Now","target":"_blank"},"image":"'.MediaFile::findMediaByName("ads-bg-4")->id.'"}'
                ],
                [
                    'name' => 'company_location_search_style',
                    'val' => 'autocomplete',
                ]
            ]
        );
    }
}
