<?php
namespace Modules\Job\Blocks;

use Illuminate\Support\Facades\DB;
use Modules\Job\Models\JobCategory;
use Modules\Media\Helpers\FileHelper;
use Modules\Template\Blocks\BaseBlock;

class JobCategories extends BaseBlock
{
    function __construct()
    {
        $this->setOptions([
            'settings' => [
                [
                    'id'    => 'style',
                    'type'  => 'radios',
                    'label' => __('Style'),
                    'value' => 'style_1',
                    'values' => [
                        [
                            'value'   => 'style_1',
                            'name' => __("Style 1")
                        ],
                        [
                            'value'   => 'style_2',
                            'name' => __("Style 2")
                        ],
                        [
                            'value'   => 'style_3',
                            'name' => __("Style 3")
                        ],
                        [
                            'value'   => 'style_4',
                            'name' => __("Style 4")
                        ],
                        [
                            'value'   => 'style_5',
                            'name' => __("Style 5")
                        ]
                    ],
                ],
                [
                    'id' => 'title',
                    'type' => 'input',
                    'inputType' => 'text',
                    'label' => __("Title")
                ],
                [
                    'id' => 'sub_title',
                    'type' => 'input',
                    'inputType' => 'text',
                    'label' => __("Sub Title")
                ],
                [
                    'id'           => 'job_categories',
                    'type'         => 'select2',
                    'label'        => __('Select Job Categories'),
                    'select2'      => [
                        'ajax'     => [
                            'url'      => route('candidate.admin.category.getForSelect2'),
                            'dataType' => 'json'
                        ],
                        'width'    => '100%',
                        'multiple' => "true",
                    ],
                    'pre_selected' => route('candidate.admin.category.getForSelect2', ['pre_selected' => 1])
                ],
            ],
            'category'=>__("Job Blocks")
        ]);
    }

    public function getName()
    {
        return __('Job Categories');
    }

    public function content($model = [])
    {
        $model = block_attrs([
            'style' => 'style_1',
            'title' => '',
            'sub_title' => '',
            'job_categories' => ''
        ], $model);

        $style = $model['style'] ? $model['style'] : 'style_1';

        if(!empty($model['job_categories'])){
            $model['job_categories'] = JobCategory::with('openJobs')->whereIn('bc_job_categories.id', $model['job_categories'])->take(1000)->get();
        }

        return view("Job::frontend.layouts.blocks.job-categories.{$style}", $model);
    }

    public function contentAPI($model = []){

    }
}
