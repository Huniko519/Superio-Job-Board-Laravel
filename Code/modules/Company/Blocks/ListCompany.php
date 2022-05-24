<?php
namespace Modules\Company\Blocks;

use Illuminate\Database\Eloquent\Builder;
use Modules\Template\Blocks\BaseBlock;
use Modules\Company\Models\Company;
use Modules\Candidate\Models\Category;

class ListCompany extends BaseBlock
{
    function __construct()
    {
        $this->setOptions([
            'settings' => [
                [
                    'id'            => 'style',
                    'type'          => 'radios',
                    'label'         => __('Style'),
                    'values'        => [
                        [
                            'value'   => '',
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
                        ],
                    ]
                ],
                [
                    'id'        => 'title',
                    'type'      => 'input',
                    'inputType' => 'text',
                    'label'     => __('Title')
                ],
                [
                    'id' => 'sub_title',
                    'type' => 'input',
                    'inputType' => 'text',
                    'label' => __("Sub Title")
                ],
                [
                    'id' => 'load_more_url',
                    'type' => 'input',
                    'inputType' => 'text',
                    'label' => __("Load More Url"),
                    'conditions' => ['style' => 'style_5']
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
                        'placeholder' => __('-- Select --'),
                        'multiple' => "true",
                    ],
                    'pre_selected'=> route('candidate.admin.category.getForSelect2', ['pre_selected' => 1])
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
                            'value'   => 'name',
                            'name' => __("Name")
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
            'category'=>__("Company Blocks")
        ]);
    }

    public function getName()
    {
        return __('Company: List Items');
    }

    public function content($model = [])
    {
        $list = $this->query($model);
        $data = [
            'rows'       => $list,
            'title' => isset($model['title']) ? $model['title'] : '',
            'sub_title' => isset($model['sub_title']) ? $model['sub_title'] : '',
            'load_more_url'=>isset($model['load_more_url']) ? $model['load_more_url'] : '',
        ];
        $style = (!empty($model['style'])) ? $model['style'] : 'index';
        return view('Company::frontend.blocks.list-company.'.$style, $data);
    }

    public function contentAPI($model = []){
        $rows = $this->query($model);
        $model['data']= $rows->map(function($row){
            return $row->dataForApi();
        });
        return $model;
    }

    public function query($model){
        $model_company = Company::select("bc_companies.*")->with(['translations']);
        if(empty($model['order'])) $model['order'] = "id";
        if(empty($model['order_by'])) $model['order_by'] = "desc";
        if(empty($model['number'])) $model['number'] = 5;
        if (!empty($model['category_id'])) {
            $category_ids = $model['category_id'];
            $list_cat = Category::query()->whereIn('id', $category_ids)->where("status","publish")->get();
            if(!empty($list_cat)){
                $where_left_right = [];
                $params = [];
                foreach ($list_cat as $cat){
                    $where_left_right[] = " ( bc_categories._lft >= ? AND bc_categories._rgt <= ? ) ";
                    $params[] = $cat->_lft;
                    $params[] = $cat->_rgt;
                }
                $sql_where_join = " ( ".implode("OR" , $where_left_right)." )  ";
                $model_company
                    ->join('bc_categories', function ($join) use($sql_where_join,$params) {
                        $join->on('bc_categories.id', '=', 'bc_companies.category_id')
                            ->WhereRaw($sql_where_join,$params);
                    });
            }
        }

        $model_company->orderBy("bc_companies.".$model['order'], $model['order_by']);
        $model_company->where("bc_companies.status", "publish");
        $model_company->groupBy("bc_companies.id");
        $model_company->withCount(['job' => function (Builder $query) {
            $query->where('status', 'publish');
        }]);
        return $model_company->with(['location'])->limit($model['number'])->get();
    }
}
