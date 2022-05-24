<?php
namespace Modules\News\Blocks;

use Modules\Template\Blocks\BaseBlock;
use Modules\News\Models\News;
use Modules\News\Models\NewsCategory;

class ListNews extends BaseBlock
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
                        ]
                    ],
                ],
                [
                    'id'        => 'title',
                    'type'      => 'input',
                    'inputType' => 'text',
                    'label'     => __('Title')
                ],
                [
                    'id'        => 'sub_title',
                    'type'      => 'input',
                    'inputType' => 'text',
                    'label'     => __('Sub Title')
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
                            'url'      => url('/admin/module/news/category/getForSelect2'),
                            'dataType' => 'json'
                        ],
                        'width' => '100%',
                        'allowClear' => 'true',
                        'placeholder' => __('-- Select --')
                    ],
                    'pre_selected'=>url('/admin/module/news/category/getForSelect2?pre_selected=1')
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
            'category'=>__("News Blocks")
        ]);
    }

    public function getName()
    {
        return __('News: List Items');
    }

    public function content($model = [])
    {
        $list = $this->query($model);
        $data = [
            'rows'       => $list,
            'title'      => $model['title'] ?? "",
            'sub_title'  => $model['sub_title'] ?? "",
            'desc'      => $model['desc'] ?? "",
        ];
        $style = !empty($model['style']) ? $model['style'] : 'style_1';

        return view('News::frontend.blocks.list-news.'.$style, $data);
    }

    public function contentAPI($model = []){
        $rows = $this->query($model);
        $model['data']= $rows->map(function($row){
            return $row->dataForApi();
        });
        return $model;
    }

    public function query($model){
        $model_news = News::select("core_news.*")->with(['translations']);
        if(empty($model['order'])) $model['order'] = "id";
        if(empty($model['order_by'])) $model['order_by'] = "desc";
        if(empty($model['number'])) $model['number'] = 3;
        if (!empty($model['category_id'])) {
            $category_ids = [$model['category_id']];
            $list_cat = NewsCategory::whereIn('id', $category_ids)->where("status","publish")->get();
            if(!empty($list_cat)){
                $where_left_right = [];
                $params = [];
                foreach ($list_cat as $cat){
                    $where_left_right[] = " ( core_news_category._lft >= ? AND core_news_category._rgt <= ? ) ";
                    $params[] = $cat->_lft;
                    $params[] = $cat->_rgt;
                }
                $sql_where_join = " ( ".implode("OR" , $where_left_right)." )  ";
                $model_news
                    ->join('core_news_category', function ($join) use($sql_where_join,$params) {
                        $join->on('core_news_category.id', '=', 'core_news.cat_id')
                            ->WhereRaw($sql_where_join,$params);
                    });
            }
        }

        $model_news->orderBy("core_news.".$model['order'], $model['order_by']);
        $model_news->where("core_news.status", "publish");
        $model_news->groupBy("core_news.id");
        return $model_news->with(['getCategory'])->limit($model['number'])->get();
    }
}
