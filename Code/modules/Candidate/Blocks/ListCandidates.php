<?php
namespace Modules\Candidate\Blocks;

use Modules\Media\Helpers\FileHelper;
use Modules\Template\Blocks\BaseBlock;
use Modules\Candidate\Models\Candidate;
use Modules\Candidate\Models\Category;

class ListCandidates extends BaseBlock
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
                    ],
                ],
                [
                    'id'        => 'title',
                    'type'      => 'input',
                    'inputType' => 'text',
                    'label'     => __('Title')
                ],
                [
                    'id'        => 'desc',
                    'type'      => 'input',
                    'inputType' => 'text',
                    'label'     => __('Desc')
                ],
                [
                    'id' => 'load_more_url',
                    'type' => 'input',
                    'inputType' => 'text',
                    'label' => __("Load More Url"),
                    'conditions' => ['style' => 'style_1']
                ],
                [
                    'id' => 'load_more_name',
                    'type' => 'input',
                    'inputType' => 'text',
                    'label' => __("Load More Name"),
                    'conditions' => ['style' => 'style_1']
                ],
                [
                    'id'        => 'number',
                    'type'      => 'input',
                    'inputType' => 'number',
                    'label'     => __('Number Item')
                ],
                [
                    'id'      => 'category_id',
                    'type'    => 'select2',
                    'label'   => __('Filter by Category'),
                    'select2' => [
                        'ajax'  => [
                            'url'      => route('candidate.admin.category.getForSelect2'),
                            'dataType' => 'json'
                        ],
                        'width' => '100%',
                        'allowClear' => 'true',
                        'multiple' => "true",
                        'placeholder' => __('-- Select --')
                    ],
                    'pre_selected'=> route('candidate.admin.category.getForSelect2').'?pre_selected=1'
                ],
                [
                    'id'            => 'order',
                    'type'          => 'radios',
                    'label'         => __('Order'),
                    'values'        => [
                        [
                            'value'   => 'id',
                            'name' => __("Date Create")
                        ],
                        [
                            'value'   => 'title',
                            'name' => __("Title")
                        ],
                    ]
                ],
                [
                    'id'            => 'order_by',
                    'type'          => 'radios',
                    'label'         => __('Order By'),
                    'values'        => [
                        [
                            'value'   => 'asc',
                            'name' => __("ASC")
                        ],
                        [
                            'value'   => 'desc',
                            'name' => __("DESC")
                        ],
                    ]
                ]
            ],
            'category'=>__("Candidates Blocks")
        ]);
    }

    public function getName()
    {
        return __('Candidates: List Items');
    }

    public function content($model = [])
    {
        $list = $this->query($model);
        $data = [
            'rows'       => $list,
            'title'      => $model['title'] ?? "",
            'desc'      => $model['desc'] ?? "",
            'load_more_url'      => $model['load_more_url'] ?? "",
            'load_more_name'      => $model['load_more_name'] ?? "",
        ];
        $style = !empty($model['style']) ? $model['style'] : 'style_1';

        return view("Candidate::frontend.blocks.list-candidates.{$style}", $data);
    }

    public function contentAPI($model = []){
        $rows = $this->query($model);
        $model['data']= $rows->map(function($row){
            return $row->dataForApi();
        });
        return $model;
    }

    public function query($model){
        $model_candidates = Candidate::select("bc_candidates.*")->with(['translations', 'categories', 'skills', 'user']);
        if(empty($model['order'])) $model['order'] = "id";
        if(empty($model['order_by'])) $model['order_by'] = "desc";
        if(empty($model['number'])) $model['number'] = 5;
        if (!empty($model['category_id'])) {
            $category_ids = is_array($model['category_id']) ? $model['category_id'] : [$model['category_id']];
            $list_cat = Category::query()->whereIn('id', $category_ids)->where("status","publish")->pluck('id');
            if(!empty($list_cat)){
                $list_cat->toArray();
                $model_candidates
                    ->join('bc_candidate_categories', function ($join) use ($list_cat) {
                        $join->on('bc_candidate_categories.origin_id', '=', 'bc_candidates.id')
                            ->whereIn("bc_candidate_categories.cat_id", $list_cat);
                    });
            }
        }

        $model_candidates->orderBy("bc_candidates.".$model['order'], $model['order_by']);
        $model_candidates->where("bc_candidates.allow_search", "publish");
        $model_candidates->groupBy("bc_candidates.id");
        return $model_candidates->limit($model['number'])->get();
    }
}
