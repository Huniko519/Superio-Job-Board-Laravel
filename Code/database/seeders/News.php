<?php
namespace Database\Seeders;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\News\Models\NewsCategory;
use Modules\News\Models\Tag;
use Modules\Media\Models\MediaFile;
use mysql_xdevapi\Table;

class News extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('core_settings')->insert(
            [
                [
                    'name' => 'news_page_list_title',
                    'val' => 'Blog',
                    'group' => "news",
                ],
                [
                    'name' => 'news_page_list_sub_title',
                    'val' => 'Blog',
                    'group' => "news",
                ],
                [
                    'name' => 'news_page_list_banner',
                    'val' => MediaFile::findMediaByName("news-banner")->id,
                    'group' => "news",
                ],
                [
                    'name' => 'news_sidebar',
                    'val' => '[{"title":null,"content":null,"type":"search_form"},{"title":"About Us","content":"Nam dapibus nisl vitae elit fringilla rutrum. Aenean sollicitudin, erat a elementum rutrum, neque sem pretium metus, quis mollis nisl nunc et massa","type":"content_text"},{"title":"Categories","content":null,"type":"category"},{"title":"Tags","content":null,"type":"tag"}]',
                    'group' => "news",
                ],
            ]
        );

        $list_categories = [
              ['name' => 'Education', 'slug' => 'education',  'status' => 'publish' ]
            , ['name' => 'Information', 'slug' => 'information',  'status' => 'publish' ]
            , ['name' => 'Interview', 'slug' => 'interview',  'status' => 'publish' ]
            , ['name' => 'Job Seeking', 'slug' => 'job-seeking',  'status' => 'publish' ]
            , ['name' => 'Jobs', 'slug' => 'jobs',  'status' => 'publish' ]
            , ['name' => 'Learn', 'slug' => 'learn',  'status' => 'publish' ]
            , ['name' => 'Skill', 'slug' => 'skill',  'status' => 'publish' ]
            , ['name' => 'Travel', 'slug' => 'travel',  'status' => 'publish' ]
        ];
        foreach ($list_categories as $category){
            $row = new NewsCategory( $category );
            $row->save();
        }
        $list_tags = [
             ['name' => 'App', 'slug' => 'app' ],
             ['name' => 'Administrative', 'slug' => 'administrative' ],
             ['name' => 'Android', 'slug' => 'android' ],
             ['name' => 'Wordpress', 'slug' => 'wordpress' ],
             ['name' => 'Design', 'slug' => 'design'],
             ['name' => 'React', 'slug' => 'react'],
        ];
        foreach ($list_tags as $tag) {
            $row = new Tag($tag);
            $row->save();
        }

        $banner_id = DB::table('media_files')->insertGetId(['file_name' => 'news-banner', 'file_path' => 'demo/news/news-banner.jpg', 'file_type' => 'image/jpeg', 'file_extension' => 'jpg']);
        $post_img = DB::table('media_files')->insertGetId(['file_name' => 'img-detail', 'file_path' => 'demo/news/img-detail.jpg', 'file_type' => 'image/jpeg', 'file_extension' => 'jpg']);
        $post_path = '';
        if (!empty($post_img)){
            $post_path = MediaFile::find($post_img);
        }


        $news = [
            'news_1' => DB::table('core_news')->insertGetId([
                'title' => 'Attract Sales And Profits',
                'slug' => Str::slug('Attract Sales And Profits', '-'),
                'content' => '<h4>Course Description</h4>
                            <p>Aliquam hendrerit sollicitudin purus, quis rutrum mi accumsan nec. Quisque bibendum orci ac nibh facilisis, at malesuada orci congue. Nullam tempus sollicitudin cursus. Ut et adipiscing erat. Curabitur this is a text link libero tempus congue.</p>
                            <p>Duis mattis laoreet neque, et ornare neque sollicitudin at. Proin sagittis dolor sed mi elementum pretium. Donec et justo ante. Vivamus egestas sodales est, eu rhoncus urna semper eu. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Integer tristique elit lobortis purus bibendum, quis dictum metus mattis. Phasellus posuere felis sed eros porttitor mattis. Curabitur massa magna, tempor in blandit id, porta in ligula. Aliquam laoreet nisl massa, at interdum mauris sollicitudin et.</p>
                            <p><img src="/uploads/'.$post_path->file_path.'" alt="" width="770" height="450" /></p>
                            <h4>Requirements</h4>
                            <ul style="list-style-type: square;">
                            <li>We do not require any previous experience or pre-defined skills to take this course. A great orientation would be enough to master UI/UX design.</li>
                            <li>A computer with a good internet connection.</li>
                            <li>Adobe Photoshop (OPTIONAL)</li>
                            </ul>',
                'status' => "publish",
                'cat_id' => rand(1, 4),
                'image_id' => MediaFile::findMediaByName("news-1")->id,
                'banner_id' => $banner_id,
                'create_user' => '1',
                'created_at' =>  date("Y-m-d H:i:s")
            ]),
            'news_2' => DB::table('core_news')->insertGetId([
                'title' => '5 Tips For Your Job Interviews',
                'slug' => Str::slug('5 Tips For Your Job Interviews', '-'),
                'content' => '<h4>Course Description</h4>
                            <p>Aliquam hendrerit sollicitudin purus, quis rutrum mi accumsan nec. Quisque bibendum orci ac nibh facilisis, at malesuada orci congue. Nullam tempus sollicitudin cursus. Ut et adipiscing erat. Curabitur this is a text link libero tempus congue.</p>
                            <p>Duis mattis laoreet neque, et ornare neque sollicitudin at. Proin sagittis dolor sed mi elementum pretium. Donec et justo ante. Vivamus egestas sodales est, eu rhoncus urna semper eu. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Integer tristique elit lobortis purus bibendum, quis dictum metus mattis. Phasellus posuere felis sed eros porttitor mattis. Curabitur massa magna, tempor in blandit id, porta in ligula. Aliquam laoreet nisl massa, at interdum mauris sollicitudin et.</p>
                            <p><img src="/uploads/'.$post_path->file_path.'" alt="" width="770" height="450" /></p>
                            <h4>Requirements</h4>
                            <ul style="list-style-type: square;">
                            <li>We do not require any previous experience or pre-defined skills to take this course. A great orientation would be enough to master UI/UX design.</li>
                            <li>A computer with a good internet connection.</li>
                            <li>Adobe Photoshop (OPTIONAL)</li>
                            </ul>',
                'status' => "publish",
                'cat_id' => rand(1, 4),
                'image_id' => MediaFile::findMediaByName("news-2")->id,
                'banner_id' => $banner_id,
                'create_user' => '1',
                'created_at' =>  date("Y-m-d H:i:s")
            ]),
            'news_3' => DB::table('core_news')->insertGetId([
                'title' => 'An Overworked Newspaper Editor',
                'slug' => Str::slug('An Overworked Newspaper Editor', '-'),
                'content' => '<h4>Course Description</h4>
                            <p>Aliquam hendrerit sollicitudin purus, quis rutrum mi accumsan nec. Quisque bibendum orci ac nibh facilisis, at malesuada orci congue. Nullam tempus sollicitudin cursus. Ut et adipiscing erat. Curabitur this is a text link libero tempus congue.</p>
                            <p>Duis mattis laoreet neque, et ornare neque sollicitudin at. Proin sagittis dolor sed mi elementum pretium. Donec et justo ante. Vivamus egestas sodales est, eu rhoncus urna semper eu. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Integer tristique elit lobortis purus bibendum, quis dictum metus mattis. Phasellus posuere felis sed eros porttitor mattis. Curabitur massa magna, tempor in blandit id, porta in ligula. Aliquam laoreet nisl massa, at interdum mauris sollicitudin et.</p>
                            <p><img src="/uploads/'.$post_path->file_path.'" alt="" width="770" height="450" /></p>
                            <h4>Requirements</h4>
                            <ul style="list-style-type: square;">
                            <li>We do not require any previous experience or pre-defined skills to take this course. A great orientation would be enough to master UI/UX design.</li>
                            <li>A computer with a good internet connection.</li>
                            <li>Adobe Photoshop (OPTIONAL)</li>
                            </ul>',
                'status' => "publish",
                'cat_id' => rand(1, 4),
                'image_id' => MediaFile::findMediaByName("news-3")->id,
                'banner_id' => $banner_id,
                'create_user' => '1',
                'created_at' =>  date("Y-m-d H:i:s")
            ]),
            'news_4' => DB::table('core_news')->insertGetId([
                'title' => 'Attract Sales And Profits',
                'slug' => Str::slug('Attract Sales And Profits 2', '-'),
                'content' => '<h4>Course Description</h4>
                            <p>Aliquam hendrerit sollicitudin purus, quis rutrum mi accumsan nec. Quisque bibendum orci ac nibh facilisis, at malesuada orci congue. Nullam tempus sollicitudin cursus. Ut et adipiscing erat. Curabitur this is a text link libero tempus congue.</p>
                            <p>Duis mattis laoreet neque, et ornare neque sollicitudin at. Proin sagittis dolor sed mi elementum pretium. Donec et justo ante. Vivamus egestas sodales est, eu rhoncus urna semper eu. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Integer tristique elit lobortis purus bibendum, quis dictum metus mattis. Phasellus posuere felis sed eros porttitor mattis. Curabitur massa magna, tempor in blandit id, porta in ligula. Aliquam laoreet nisl massa, at interdum mauris sollicitudin et.</p>
                            <p><img src="/uploads/'.$post_path->file_path.'" alt="" width="770" height="450" /></p>
                            <h4>Requirements</h4>
                            <ul style="list-style-type: square;">
                            <li>We do not require any previous experience or pre-defined skills to take this course. A great orientation would be enough to master UI/UX design.</li>
                            <li>A computer with a good internet connection.</li>
                            <li>Adobe Photoshop (OPTIONAL)</li>
                            </ul>',
                'status' => "publish",
                'cat_id' => rand(1, 4),
                'image_id' => MediaFile::findMediaByName("news-4")->id,
                'banner_id' => $banner_id,
                'create_user' => '1',
                'created_at' =>  date("Y-m-d H:i:s")
            ]),
            'news_5' => DB::table('core_news')->insertGetId([
                'title' => '5 Tips For Your Job Interviews',
                'slug' => Str::slug('5 Tips For Your Job Interviews 2', '-'),
                'content' => '<h4>Course Description</h4>
                            <p>Aliquam hendrerit sollicitudin purus, quis rutrum mi accumsan nec. Quisque bibendum orci ac nibh facilisis, at malesuada orci congue. Nullam tempus sollicitudin cursus. Ut et adipiscing erat. Curabitur this is a text link libero tempus congue.</p>
                            <p>Duis mattis laoreet neque, et ornare neque sollicitudin at. Proin sagittis dolor sed mi elementum pretium. Donec et justo ante. Vivamus egestas sodales est, eu rhoncus urna semper eu. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Integer tristique elit lobortis purus bibendum, quis dictum metus mattis. Phasellus posuere felis sed eros porttitor mattis. Curabitur massa magna, tempor in blandit id, porta in ligula. Aliquam laoreet nisl massa, at interdum mauris sollicitudin et.</p>
                            <p><img src="/uploads/'.$post_path->file_path.'" alt="" width="770" height="450" /></p>
                            <h4>Requirements</h4>
                            <ul style="list-style-type: square;">
                            <li>We do not require any previous experience or pre-defined skills to take this course. A great orientation would be enough to master UI/UX design.</li>
                            <li>A computer with a good internet connection.</li>
                            <li>Adobe Photoshop (OPTIONAL)</li>
                            </ul>',
                'status' => "publish",
                'cat_id' => rand(1, 4),
                'image_id' => MediaFile::findMediaByName("news-5")->id,
                'banner_id' => $banner_id,
                'create_user' => '1',
                'created_at' =>  date("Y-m-d H:i:s")
            ]),
            'news_6' => DB::table('core_news')->insertGetId([
                'title' => 'An Overworked Newspaper Editor',
                'slug' => Str::slug('An Overworked Newspaper Editor 2', '-'),
                'content' => '<h4>Course Description</h4>
                            <p>Aliquam hendrerit sollicitudin purus, quis rutrum mi accumsan nec. Quisque bibendum orci ac nibh facilisis, at malesuada orci congue. Nullam tempus sollicitudin cursus. Ut et adipiscing erat. Curabitur this is a text link libero tempus congue.</p>
                            <p>Duis mattis laoreet neque, et ornare neque sollicitudin at. Proin sagittis dolor sed mi elementum pretium. Donec et justo ante. Vivamus egestas sodales est, eu rhoncus urna semper eu. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Integer tristique elit lobortis purus bibendum, quis dictum metus mattis. Phasellus posuere felis sed eros porttitor mattis. Curabitur massa magna, tempor in blandit id, porta in ligula. Aliquam laoreet nisl massa, at interdum mauris sollicitudin et.</p>
                            <p><img src="/uploads/'.$post_path->file_path.'" alt="" width="770" height="450" /></p>
                            <h4>Requirements</h4>
                            <ul style="list-style-type: square;">
                            <li>We do not require any previous experience or pre-defined skills to take this course. A great orientation would be enough to master UI/UX design.</li>
                            <li>A computer with a good internet connection.</li>
                            <li>Adobe Photoshop (OPTIONAL)</li>
                            </ul>',
                'status' => "publish",
                'cat_id' => rand(1, 4),
                'image_id' => MediaFile::findMediaByName("news-6")->id,
                'banner_id' => $banner_id,
                'create_user' => '1',
                'created_at' =>  date("Y-m-d H:i:s")
            ]),
        ];

        foreach ($news as $tag){
            for ($i = 1; $i <= 3; $i++){
                DB::table('core_news_tag')->insert([
                    'news_id'   =>  $tag,
                    'tag_id'    =>  rand(1,6),
                    'create_user' => 1
                ]);
            }
        }
    }
}
