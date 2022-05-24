<?php
namespace Modules\Location\Blocks;

use Modules\Template\Blocks\BaseBlock;
use Modules\Location\Models\Location;

class ListLocations extends BaseBlock
{
    function __construct()
    {
        $this->setOptions([
            'settings' => [
                [
                    'id'            => 'layout',
                    'type'          => 'radios',
                    'label'         => __('Style Background'),
                    'values'        => [
                        [
                            'value'   => 'style_1',
                            'name' => __("Style 1")
                        ],
                        [
                            'value'   => 'style_2',
                            'name' => __("Style 2")
                        ]
                    ]
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
                    'id' => 'load_more_url',
                    'type' => 'input',
                    'inputType' => 'text',
                    'label' => __("Load More Url"),
                    'conditions' => ['style' => 'style_2']
                ],
                [
                    'id' => 'load_more_name',
                    'type' => 'input',
                    'inputType' => 'text',
                    'label' => __("Load More Name"),
                    'conditions' => ['style' => 'style_2']
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
                            'name' => __("Title")
                        ],
                    ],
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
                    ],
                ],
                [
                    'id'           => 'custom_ids',
                    'type'         => 'select2',
                    'label'        => __('List Location by IDs'),
                    'select2'      => [
                        'ajax'     => [
                            'url'      => route('location.admin.getForSelect2'),
                            'dataType' => 'json'
                        ],
                        'width'    => '100%',
                        'multiple' => "true",
                    ],
                    'pre_selected' => route('location.admin.getForSelect2', [
                        'pre_selected' => 1
                    ])
                ]
            ],
            'category'=>__("Location Blocks")
        ]);
    }

    public function getName()
    {
        return __('List Locations');
    }

    public function content($model = [])
    {
        $list = $this->query($model);
        $data = [
            'rows'         => $list,
            'title'        => $model['title'] ?? '',
            'sub_title'         => $model['sub_title'] ?? "",
            'load_more_url'         => $model['load_more_url'] ?? "",
            'load_more_name'         => $model['load_more_name'] ?? "",
            'layout'       => !empty($model['layout']) ? $model['layout'] : "style_1"
        ];
        return view("Location::frontend.blocks.list-locations.{$data['layout']}", $data);
    }

    public function contentAPI($model = []){
        $rows = $this->query($model);
        $model['data']= $rows->map(function($row){
            return $row->dataForApi();
        });
        return $model;
    }

    public function query($model){
        if(empty($model['order'])) $model['order'] = "id";
        if(empty($model['order_by'])) $model['order_by'] = "desc";
        if(empty($model['number'])) $model['number'] = 5;
        $model_location = Location::query()->with(['translations', 'openJobs']);
        $model_location->where("status","publish");
        if(!empty( $model['custom_ids'] )){
            $model_location->whereIn("id",$model['custom_ids']);
        }
        $model_location->orderBy($model['order'], $model['order_by']);
        return $model_location->limit($model['number'])->get();
    }
}
