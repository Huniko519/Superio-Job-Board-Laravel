<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Modules\Candidate\Models\Category;
use Modules\Media\Models\MediaFile;
use Modules\Review\Models\Review;
use Modules\Review\Models\ReviewMeta;
class CandidateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
                'name'        => 'Accounting / Finance',
                'slug'        => Str::slug('Accounting Finance', '-'),
                'icon'        => 'icon flaticon-money-1',
                'status'      => 'publish',
                'created_at'  => date("Y-m-d H:i:s")
            ],
            [
                'name'        => 'Marketing',
                'slug'        => Str::slug('Marketing', '-'),
                'icon'        => 'icon flaticon-promotion',
                'status'      => 'publish',
                'created_at'  => date("Y-m-d H:i:s")
            ],
            [
                'name'        => 'Design',
                'slug'        => Str::slug('Design', '-'),
                'icon'        => 'icon flaticon-vector',
                'status'      => 'publish',
                'created_at'  => date("Y-m-d H:i:s")
            ],
            [
                'name'        => 'Development',
                'slug'        => Str::slug('Development', '-'),
                'icon'        => 'icon flaticon-web-programming',
                'status'      => 'publish',
                'created_at'  => date("Y-m-d H:i:s")
            ],
            [
                'name'        => 'Human Resource',
                'slug'        => Str::slug('Human Resource', '-'),
                'icon'        => 'icon flaticon-headhunting',
                'status'      => 'publish',
                'created_at'  => date("Y-m-d H:i:s")
            ],
            [
                'name'        => 'Project Management',
                'slug'        => Str::slug('Project Management', '-'),
                'icon'        => 'icon flaticon-rocket-ship',
                'status'      => 'publish',
                'created_at'  => date("Y-m-d H:i:s")
            ],
            [
                'name'        => 'Customer Service',
                'slug'        => Str::slug('Customer Service', '-'),
                'icon'        => 'icon flaticon-support-1',
                'status'      => 'publish',
                'created_at'  => date("Y-m-d H:i:s")
            ],
            [
                'name'        => 'Health and Care',
                'slug'        => Str::slug('Health and Care', '-'),
                'icon'        => 'icon flaticon-first-aid-kit-1',
                'status'      => 'publish',
                'created_at'  => date("Y-m-d H:i:s")
            ],
            [
                'name'        => 'Automotive Jobs',
                'slug'        => Str::slug('Automotive Jobs', '-'),
                'icon'        => 'icon flaticon-car',
                'status'      => 'publish',
                'created_at'  => date("Y-m-d H:i:s")
            ]
        ];

        foreach ($categories as $category){
                $row = new Category( $category );
                $row->save();
        }


        $medias = MediaFile::query()->where('file_name', 'LIKE', '%portfolio%')->limit(4)->pluck('id')->toArray();
        $gallery_images = implode(",", $medias);

        $gender = ['male', 'female'];
        $salaryType = ['hourly', 'daily', 'weekly', 'monthly'];
        $educationLevel = ['certificate', 'diploma', 'associate', 'bachelor', 'master', 'professional'];
        $maps = [
            'map_lat' => ['40.94401669296697','40.77055783505125','40.7427837','40.70437865245596','40.641311','41.080938','41.079386'],
            'map_lng' => ['-74.16938781738281','-74.26002502441406','-73.11445617675781','-73.98674011230469','-73.778139','-73.535957','-73.519478']
        ];

        $dataArr = \App\User::where('role_id', 3)->take(9)->get();
        $i = 1;
        foreach($dataArr as $data){
            DB::table('bc_candidates')->insert(
                [
                    'id' => $data->id,
                    'title' => 'UI Designer at Invision',
                    'gender'   => $gender[array_rand($gender)],
                    'allow_search'   => 'publish',
                    'create_user'   => $data->id,
                    'gallery'  => $gallery_images,
                    'video'     => 'https://www.youtube.com/watch?v=bhOiLfkChPo',
                    'video_cover_id' => MediaFile::findMediaByName('video-img')->id,
                    'created_at' =>  date("Y-m-d H:i:s"),
                    'slug' => Str::slug('UI Designer at Invision '.$i, '-'),
                    'expected_salary' => rand(100, 1000),
                    'salary_type' => $salaryType[array_rand($salaryType)],
                    'city' => 'New York',
                    'country' => 'US',
                    'languages' => 'English, German, Spanish',
                    'education_level' => $educationLevel[array_rand($educationLevel)],
                    'experience_year' => rand(0,5),
                    'map_lat' => $maps['map_lat'][$i - 1],
                    'map_lng' => $maps['map_lng'][$i - 1],
                    'map_zoom' => '16',
                    'location_id' => rand(1, 5),
                    'education' => '[{"from":"2015","to":"2019","location":"Harvard University","reward":"MBA from Harvard Business School","information": "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin a ipsum tellus.<br/> Interdum et malesuada fames ac anteipsum primis in faucibus."},{"from":"2011","to":"2015","location":"Tomms College","reward":"Bachlors in Fine Arts","information": "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin a ipsum tellus.<br/> Interdum et malesuada fames ac anteipsum primis in faucibus."}]',
                    'experience' => '[{"from":"2015","to":"2019","location":"Google","position":"Web Designer","information": "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin a ipsum tellus.<br/> Interdum et malesuada fames ac anteipsum primis in faucibus."},{"from":"2011","to":"2015","location":"Facebook","position":"CEO Founder","information": "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin a ipsum tellus.<br/> Interdum et malesuada fames ac anteipsum primis in faucibus."},{"from":"2011","to":"2015","location":"Tomms College","position":"CEO Founder","information": "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin a ipsum tellus.<br/> Interdum et malesuada fames ac anteipsum primis in faucibus."}]',
                    'award' => '[{"from":"2015","to":"2019","location":"Harvard University","reward":"Perfect Attendance Programs","information": "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin a ipsum tellus.<br/> Interdum et malesuada fames ac anteipsum primis in faucibus."},{"from":"2011","to":"2015","location":"Tomms College","reward":"Top Performer Recognition","information": "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin a ipsum tellus.<br/> Interdum et malesuada fames ac anteipsum primis in faucibus."}]',
                    'social_media' => '{"skype":"superio.test","facebook":"https:\/\/superio.test\/","twitter":"https:\/\/superio.test\/","instagram":"https:\/\/superio.test\/","pinterest":"https:\/\/superio.test\/","dribbble":"https:\/\/superio.test\/","google":"https:\/\/superio.test\/","linkedin":"https:\/\/superio.test\/"}'
                ]
            );

            DB::table('bc_candidate_cvs')->insert(
                [
                    'file_id' => MediaFile::findMediaByName("resume_".$i)->id,
                    'origin_id' => $data->id,
                    'is_default' => 1,
                    'create_user' => $data->id,
                    'created_at' =>  date("Y-m-d H:i:s")
                ]
            );

            DB::table('bc_candidate_skills')->insert(
                [
                    [
                        'origin_id' => $data->id,
                        'skill_id' => rand(1,2),
                        'created_at'  => date("Y-m-d H:i:s")
                    ],
                    [
                        'origin_id' => $data->id,
                        'skill_id' => rand(3,4),
                        'created_at'  => date("Y-m-d H:i:s")
                    ],
                    [
                        'origin_id' => $data->id,
                        'skill_id' => rand(5,6),
                        'created_at'  => date("Y-m-d H:i:s")
                    ],
                    [
                        'origin_id' => $data->id,
                        'skill_id' => rand(7,8),
                        'created_at'  => date("Y-m-d H:i:s")
                    ]
                ]
            );

            DB::table('bc_candidate_categories')->insert(
                [
                    [
                        'origin_id' => $data->id,
                        'cat_id' => rand(1,5),
                        'created_at'  => date("Y-m-d H:i:s")
                    ],
                    [
                        'origin_id' => $data->id,
                        'cat_id' => rand(6,9),
                        'created_at'  => date("Y-m-d H:i:s")
                    ]
                ]
            );

            $i++;
        }



        // Settings
        DB::table('core_settings')->insert(
            [
                [
                    'name' => 'candidate_page_search_title',
                    'val' => 'Find Candidates',
                ],
                [
                    'name' => 'candidate_page_search_title_ja',
                    'val' => '仕事を探す',
                ],
                [
                    'name' => 'candidate_list_layout',
                    'val' => 'v1',
                ],
                [
                    'name' => 'candidate_single_layout',
                    'val' => 'v1',
                ],
                [
                    'name' => 'candidate_sidebar_search_fields',
                    'val' => '[
                        {"title":"Search by Keywords","type":"keyword","position":"1"},
                        {"title":"Location","type":"location","position":"2"},
                        {"title":"Category","type":"category","position":"3"},
                        {"title":"Skills","type":"skill","position":"4"},
                        {"title":"Date Posted","type":"date_posted","position":"5"},
                        {"title":"Experience Level","type":"experience","position":"6"},
                        {"title":"Education Levels","type":"education","position":"7"}

                    ]',
                ],
                [
                    'name' => 'candidate_location_search_style',
                    'val' => 'autocomplete'
                ]
            ]
        );

    }
}
