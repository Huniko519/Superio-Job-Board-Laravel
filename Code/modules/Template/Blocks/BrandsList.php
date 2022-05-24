<?php
namespace Modules\Template\Blocks;

class BrandsList extends BaseBlock
{
    function __construct()
    {
        $this->setOptions([
            'settings' => [
                [
                    'id'    => 'style',
                    'type'  => 'radios',
                    'label' => __('Style'),
                    'values' => [
                        [
                            'value'   => 'style_1',
                            'name' => __("Normal")
                        ],
                        [
                            'value'   => 'style_2',
                            'name' => __("Black & white color")
                        ],
                        [
                            'value'   => 'style_3',
                            'name' => __("Style 3")
                        ]
                    ],
                ],
                [
                    'id'        => 'title',
                    'type'      => 'input',
                    'inputType' => 'text',
                    'label'     => __('Title'),
                    'conditions' => ['style' => 'style_3']
                ],
                [
                    'id'        => 'sub_title',
                    'type'      => 'input',
                    'inputType' => 'text',
                    'label'     => __('Sub Title'),
                    'conditions' => ['style' => 'style_3']
                ],
                [
                    'id'          => 'list_item',
                    'type'        => 'listItem',
                    'label'       => __('List Brand Item(s)'),
                    'title_field' => 'title',
                    'settings'    => [
                        [
                            'id'        => 'title',
                            'type'      => 'input',
                            'inputType' => 'text',
                            'label'     => __('Title')
                        ],
                        [
                            'id'    => 'image_id',
                            'type'  => 'uploader',
                            'label' => __('Logo Image')
                        ],
                        [
                            'id'        => 'brand_link',
                            'type'      => 'input',
                            'inputType' => 'text',
                            'label'     => __('Brand Link')
                        ],
                    ]
                ],
            ],
            'category'=>__("Other Block")
        ]);
    }

    public function getName()
    {
        return __('Brands List');
    }

    public function content($model = [])
    {
        $model = block_attrs([
            'style'=>'',
            'title' => '',
            'sub_title' => '',
            'list_item'=>''
        ], $model);
        if(!empty($model['image_id'])){
            $model['image_url'] = get_file_url($model['image_id'] , 'full');
        }
        $blade = (!empty($model['style'])) ? $model['style'] : 'style_1';
        if(!empty($model['style']) && $model['style'] == 'style_2') $blade = 'style_1';

        return view('Template::frontend.blocks.brands-list.'.$blade, $model);
    }

    public function contentAPI($model = []){
        if(!empty($model['image_id'])){
            $model['image_url'] = get_file_url($model['image_id'] , 'full');
        }
        return $model;
    }
}
