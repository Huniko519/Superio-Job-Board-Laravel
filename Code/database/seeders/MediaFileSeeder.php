<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MediaFileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //general
        DB::table('media_files')->insert([
            ['file_name' => 'avatar', 'file_path' => 'demo/general/avatar.jpg', 'file_type' => 'image/jpeg', 'file_extension' => 'jpg'],
            ['file_name' => 'avatar-2', 'file_path' => 'demo/general/avatar-2.jpg', 'file_type' => 'image/jpeg', 'file_extension' => 'jpg'],
            ['file_name' => 'avatar-3', 'file_path' => 'demo/general/avatar-3.jpg', 'file_type' => 'image/jpeg', 'file_extension' => 'jpg'],
            ['file_name' => 'ico_adventurous', 'file_path' => 'demo/general/ico_adventurous.png', 'file_type' => 'image/png', 'file_extension' => 'png'],
            ['file_name' => 'ico_localguide', 'file_path' => 'demo/general/ico_localguide.png', 'file_type' => 'image/png', 'file_extension' => 'png'],
            ['file_name' => 'ico_maps', 'file_path' => 'demo/general/ico_maps.png', 'file_type' => 'image/png', 'file_extension' => 'png'],
            ['file_name' => 'ico_paymethod', 'file_path' => 'demo/general/ico_paymethod.png', 'file_type' => 'image/png', 'file_extension' => 'png'],
            ['file_name' => 'logo', 'file_path' => 'demo/general/logo.svg', 'file_type' => 'image/svg+xml', 'file_extension' => 'svg'],
            ['file_name' => 'logo-white', 'file_path' => 'demo/general/logo-2.svg', 'file_type' => 'image/svg+xml', 'file_extension' => 'svg'],
            ['file_name' => 'bg_contact', 'file_path' => 'demo/general/bg-contact.jpg', 'file_type' => 'image/jpeg', 'file_extension' => 'jpg'],
            ['file_name' => 'favicon', 'file_path' => 'demo/general/favicon.png', 'file_type' => 'image/png', 'file_extension' => 'png'],
            ['file_name' => 'thumb-vendor-register', 'file_path' => 'demo/general/thumb-vendor-register.jpg', 'file_type' => 'image/jpeg', 'file_extension' => 'jpg'],
            ['file_name' => 'bg-video-vendor-register1', 'file_path' => 'demo/general/bg-video-vendor-register1.jpg', 'file_type' => 'image/jpeg', 'file_extension' => 'jpg'],
            ['file_name' => 'ico_chat_1', 'file_path' => 'demo/general/ico_chat_1.svg', 'file_type' => 'image/svg', 'file_extension' => 'svg'],
            ['file_name' => 'ico_friendship_1', 'file_path' => 'demo/general/ico_friendship_1.svg', 'file_type' => 'image/svg', 'file_extension' => 'svg'],
            ['file_name' => 'ico_piggy-bank_1', 'file_path' => 'demo/general/ico_piggy-bank_1.svg', 'file_type' => 'image/svg', 'file_extension' => 'svg'],
            ['file_name' => 'ads-bg-4', 'file_path' => 'demo/general/ads-bg-4.png', 'file_type' => 'image/png', 'file_extension' => 'png'],
            ['file_name' => 'process-1', 'file_path' => 'demo/general/process-1.png', 'file_type' => 'image/png', 'file_extension' => 'png'],
            ['file_name' => 'process-2', 'file_path' => 'demo/general/process-2.png', 'file_type' => 'image/png', 'file_extension' => 'png'],
            ['file_name' => 'process-3', 'file_path' => 'demo/general/process-3.png', 'file_type' => 'image/png', 'file_extension' => 'png'],
            ['file_name' => 'home-6-banner', 'file_path' => 'demo/general/home-6-banner.png', 'file_type' => 'image/png', 'file_extension' => 'png'],
            ['file_name' => 'job-post-img', 'file_path' => 'demo/general/job-post-img.jpg', 'file_type' => 'image/jpeg', 'file_extension' => 'jpg'],
            ['file_name' => 'video-img', 'file_path' => 'demo/general/video-img.jpg', 'file_type' => 'image/jpeg', 'file_extension' => 'jpg'],
        ]);

        //Location
        DB::table('media_files')->insert([
            ['file_name' => 'location-1', 'file_path' => 'demo/location/location-1.png', 'file_type' => 'image/png', 'file_extension' => 'png'],
            ['file_name' => 'location-2', 'file_path' => 'demo/location/location-2.png', 'file_type' => 'image/png', 'file_extension' => 'png'],
            ['file_name' => 'location-3', 'file_path' => 'demo/location/location-3.png', 'file_type' => 'image/png', 'file_extension' => 'png'],
            ['file_name' => 'location-4', 'file_path' => 'demo/location/location-4.png', 'file_type' => 'image/png', 'file_extension' => 'png'],
            ['file_name' => 'location-5', 'file_path' => 'demo/location/location-5.png', 'file_type' => 'image/png', 'file_extension' => 'png'],
            ['file_name' => 'location-6', 'file_path' => 'demo/location/location-6.jpg', 'file_type' => 'image/jpeg', 'file_extension' => 'jpg'],
            ['file_name' => 'location-7', 'file_path' => 'demo/location/location-7.jpg', 'file_type' => 'image/jpeg', 'file_extension' => 'jpg'],
            ['file_name' => 'location-8', 'file_path' => 'demo/location/location-8.jpg', 'file_type' => 'image/jpeg', 'file_extension' => 'jpg']
        ]);//Location

        //News
        DB::table('media_files')->insert([
            ['file_name' => 'news-1', 'file_path' => 'demo/news/news-1.jpg', 'file_type' => 'image/jpeg', 'file_extension' => 'jpg'],
            ['file_name' => 'news-2', 'file_path' => 'demo/news/news-2.jpg', 'file_type' => 'image/jpeg', 'file_extension' => 'jpg'],
            ['file_name' => 'news-3', 'file_path' => 'demo/news/news-3.jpg', 'file_type' => 'image/jpeg', 'file_extension' => 'jpg'],
            ['file_name' => 'news-4', 'file_path' => 'demo/news/news-4.jpg', 'file_type' => 'image/jpeg', 'file_extension' => 'jpg'],
            ['file_name' => 'news-5', 'file_path' => 'demo/news/news-5.jpg', 'file_type' => 'image/jpeg', 'file_extension' => 'jpg'],
            ['file_name' => 'news-6', 'file_path' => 'demo/news/news-6.jpg', 'file_type' => 'image/jpeg', 'file_extension' => 'jpg'],
            ['file_name' => 'news-7', 'file_path' => 'demo/news/news-7.jpg', 'file_type' => 'image/jpeg', 'file_extension' => 'jpg'],
            ['file_name' => 'news-banner', 'file_path' => 'demo/news/news-banner.jpg', 'file_type' => 'image/jpeg', 'file_extension' => 'jpg'],
        ]);

        //Home Page
        DB::table('media_files')->insert([
            ['file_name' => 'image-1', 'file_path' => 'demo/general/image-1.png', 'file_type' => 'image/png', 'file_extension' => 'png'],
            ['file_name' => 'image-2', 'file_path' => 'demo/general/image-2.jpg', 'file_type' => 'image/jpeg', 'file_extension' => 'jpg'],
            ['file_name' => 'image-3', 'file_path' => 'demo/general/image-3.png', 'file_type' => 'image/png', 'file_extension' => 'png'],
            ['file_name' => 'count-employers', 'file_path' => 'demo/general/count-employers.png', 'file_type' => 'image/png', 'file_extension' => 'png'],
            ['file_name' => 'app-list', 'file_path' => 'demo/general/app-list.png', 'file_type' => 'image/png', 'file_extension' => 'png'],
            ['file_name' => 'mobile-app', 'file_path' => 'demo/general/mobile-app.jpg', 'file_type' => 'image/jpeg', 'file_extension' => 'jpg'],
            ['file_name' => 'apple', 'file_path' => 'demo/general/apple.png', 'file_type' => 'image/png', 'file_extension' => 'png'],
            ['file_name' => 'google', 'file_path' => 'demo/general/google.png', 'file_type' => 'image/png', 'file_extension' => 'png'],
            ['file_name' => 'bg-1', 'file_path' => 'demo/general/bg-1.jpg', 'file_type' => 'image/jpeg', 'file_extension' => 'jpg'],
            ['file_name' => 'banner-img-1', 'file_path' => 'demo/general/banner-img-1.png', 'file_type' => 'image/png', 'file_extension' => 'png'],
            ['file_name' => 'banner-img-2', 'file_path' => 'demo/general/banner-img-2.png', 'file_type' => 'image/png', 'file_extension' => 'png'],
            ['file_name' => 'banner-img-3', 'file_path' => 'demo/general/banner-img-3.png', 'file_type' => 'image/png', 'file_extension' => 'png'],
            ['file_name' => 'banner-1-1', 'file_path' => 'demo/general/banner-1-1.png', 'file_type' => 'image/png', 'file_extension' => 'png'],
            ['file_name' => 'banner-1-2', 'file_path' => 'demo/general/banner-1-2.png', 'file_type' => 'image/png', 'file_extension' => 'png'],
            ['file_name' => 'banner-1-3', 'file_path' => 'demo/general/banner-1-3.png', 'file_type' => 'image/png', 'file_extension' => 'png'],
            ['file_name' => 'banner-1-4', 'file_path' => 'demo/general/banner-1-4.png', 'file_type' => 'image/png', 'file_extension' => 'png'],
            ['file_name' => 'banner-2-1', 'file_path' => 'demo/general/banner-2-1.png', 'file_type' => 'image/png', 'file_extension' => 'png'],
            ['file_name' => 'homepage-4-banner', 'file_path' => 'demo/general/homepage-4-banner.png', 'file_type' => 'image/png', 'file_extension' => 'png'],
        ]);


        //Candidates
        DB::table('media_files')->insert([
            ['file_name' => 'candidate-1', 'file_path' => 'demo/candidate/candidate-1.png', 'file_type' => 'image/png', 'file_extension' => 'png'],
            ['file_name' => 'candidate-2', 'file_path' => 'demo/candidate/candidate-2.png', 'file_type' => 'image/png', 'file_extension' => 'png'],
            ['file_name' => 'candidate-3', 'file_path' => 'demo/candidate/candidate-3.png', 'file_type' => 'image/png', 'file_extension' => 'png'],
            ['file_name' => 'candidate-4', 'file_path' => 'demo/candidate/candidate-4.png', 'file_type' => 'image/png', 'file_extension' => 'png'],
            ['file_name' => 'candidate-5', 'file_path' => 'demo/candidate/candidate-5.png', 'file_type' => 'image/png', 'file_extension' => 'png'],
            ['file_name' => 'candidate-6', 'file_path' => 'demo/candidate/candidate-6.png', 'file_type' => 'image/png', 'file_extension' => 'png'],
            ['file_name' => 'candidate-7', 'file_path' => 'demo/candidate/candidate-7.png', 'file_type' => 'image/png', 'file_extension' => 'png'],
            ['file_name' => 'candidate-8', 'file_path' => 'demo/candidate/candidate-8.png', 'file_type' => 'image/png', 'file_extension' => 'png'],
            ['file_name' => 'candidate-9', 'file_path' => 'demo/candidate/candidate-9.png', 'file_type' => 'image/png', 'file_extension' => 'png'],
            ['file_name' => 'candidate', 'file_path' => 'demo/candidate/candidate.png', 'file_type' => 'image/png', 'file_extension' => 'png'],

            ['file_name' => 'portfolio-1', 'file_path' => 'demo/candidate/portfolio-1.jpg', 'file_type' => 'image/jpeg', 'file_extension' => 'jpg'],
            ['file_name' => 'portfolio-2', 'file_path' => 'demo/candidate/portfolio-2.jpg', 'file_type' => 'image/jpeg', 'file_extension' => 'jpg'],
            ['file_name' => 'portfolio-3', 'file_path' => 'demo/candidate/portfolio-3.jpg', 'file_type' => 'image/jpeg', 'file_extension' => 'jpg'],
            ['file_name' => 'portfolio-4', 'file_path' => 'demo/candidate/portfolio-4.jpg', 'file_type' => 'image/jpeg', 'file_extension' => 'jpg'],
            ['file_name' => 'portfolio-5', 'file_path' => 'demo/candidate/portfolio-5.jpg', 'file_type' => 'image/jpeg', 'file_extension' => 'jpg'],
            ['file_name' => 'portfolio-6', 'file_path' => 'demo/candidate/portfolio-6.jpg', 'file_type' => 'image/jpeg', 'file_extension' => 'jpg'],


            ['file_name' => 'resume_1', 'file_path' => 'demo/candidate/resume_1.docx', 'file_type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'file_extension' => 'docx'],
            ['file_name' => 'resume_2', 'file_path' => 'demo/candidate/resume_2.docx', 'file_type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'file_extension' => 'docx'],
            ['file_name' => 'resume_3', 'file_path' => 'demo/candidate/resume_3.docx', 'file_type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'file_extension' => 'docx'],
            ['file_name' => 'resume_4', 'file_path' => 'demo/candidate/resume_4.docx', 'file_type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'file_extension' => 'docx'],
            ['file_name' => 'resume_5', 'file_path' => 'demo/candidate/resume_5.docx', 'file_type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'file_extension' => 'docx'],
            ['file_name' => 'resume_6', 'file_path' => 'demo/candidate/resume_6.docx', 'file_type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'file_extension' => 'docx'],
            ['file_name' => 'resume_7', 'file_path' => 'demo/candidate/resume_7.docx', 'file_type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'file_extension' => 'docx'],
            ['file_name' => 'resume_8', 'file_path' => 'demo/candidate/resume_8.docx', 'file_type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'file_extension' => 'docx'],
            ['file_name' => 'resume_9', 'file_path' => 'demo/candidate/resume_9.docx', 'file_type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'file_extension' => 'docx'],
            ['file_name' => 'resume_10', 'file_path' => 'demo/candidate/resume_10.docx', 'file_type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'file_extension' => 'docx'],

        ]);

        //Company
        DB::table('media_files')->insert([
            ['file_name' => 'bc_company-1', 'file_path' => 'demo/company/bc_company-1.png', 'file_type' => 'image/png', 'file_extension' => 'png'],
            ['file_name' => 'bc_company-2', 'file_path' => 'demo/company/bc_company-2.png', 'file_type' => 'image/png', 'file_extension' => 'png'],
            ['file_name' => 'bc_company-3', 'file_path' => 'demo/company/bc_company-3.png', 'file_type' => 'image/png', 'file_extension' => 'png'],
            ['file_name' => 'bc_company-4', 'file_path' => 'demo/company/bc_company-4.png', 'file_type' => 'image/png', 'file_extension' => 'png'],
            ['file_name' => 'bc_company-5', 'file_path' => 'demo/company/bc_company-5.png', 'file_type' => 'image/png', 'file_extension' => 'png'],
            ['file_name' => 'bc_company-6', 'file_path' => 'demo/company/bc_company-6.png', 'file_type' => 'image/png', 'file_extension' => 'png'],
            ['file_name' => 'bc_company-7', 'file_path' => 'demo/company/bc_company-7.png', 'file_type' => 'image/png', 'file_extension' => 'png'],
            ['file_name' => 'bc_company-8', 'file_path' => 'demo/company/bc_company-8.png', 'file_type' => 'image/png', 'file_extension' => 'png'],
            ['file_name' => 'bc_company-9', 'file_path' => 'demo/company/bc_company-9.png', 'file_type' => 'image/png', 'file_extension' => 'png'],
            ['file_name' => 'bc_company-10', 'file_path' => 'demo/company/bc_company-10.png', 'file_type' => 'image/png', 'file_extension' => 'png'],
            ['file_name' => 'bc_company-11', 'file_path' => 'demo/company/bc_company-11.png', 'file_type' => 'image/png', 'file_extension' => 'png'],
            ['file_name' => 'bc_company-12', 'file_path' => 'demo/company/bc_company-12.png', 'file_type' => 'image/png', 'file_extension' => 'png'],
        ]);
    }
}
