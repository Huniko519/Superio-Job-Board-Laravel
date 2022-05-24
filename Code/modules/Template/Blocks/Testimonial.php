<?php
namespace Modules\Template\Blocks;

use Modules\Media\Helpers\FileHelper;

class Testimonial extends BaseBlock
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
                            'value'   => 'index',
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
                        [
                            'value'   => 'style_6',
                            'name' => __("Style 6")
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
                    'id'          => 'list_item',
                    'type'        => 'listItem',
                    'label'       => __('List Item(s)'),
                    'title_field' => 'title',
                    'settings'    => [
                        [
                            'id'        => 'title',
                            'type'      => 'input',
                            'inputType' => 'text',
                            'label'     => __('Title')
                        ],
                        [
                            'id'    => 'desc',
                            'type'  => 'textArea',
                            'label' => __('Desc')
                        ],
                        [
                            'id'        => 'info_name',
                            'type'      => 'input',
                            'inputType' => 'text',
                            'label'     => __('Info Name')
                        ],
                        [
                            'id'        => 'position',
                            'type'      => 'input',
                            'inputType' => 'text',
                            'label'     => __('Position')
                        ],
                        [
                            'id'    => 'avatar',
                            'type'  => 'uploader',
                            'label' => __('Avatar Image')
                        ],
                    ]
                ],
                [
                    'id' => 'banner_image',
                    'type' => 'uploader',
                    'label' => __("Banner Image Left"),
                    'conditions' => ['style' => 'style_5','style' => 'style_6']
                ],
                [
                    'id' => 'banner_image_2',
                    'type' => 'uploader',
                    'label' => __("Banner Image Right"),
                    'conditions' => ['style' => 'style_5']
                ],
            ],
            'category'=>__("Other Block")
        ]);
    }

    public function getName()
    {
        return __('List Testimonial');
    }

    public function content($model = [])
    {
        $model = block_attrs([
            'title'=>'',
            'sub_title'=>'',
            'list_item'=>'',
            'style'=>'',
            'banner_image' => '',
            'banner_image_2' => '',
            'banner_image_url' => !empty($model['banner_image']) ? FileHelper::url($model['banner_image'], 'full') : '',
            'banner_image_2_url' => !empty($model['banner_image_2']) ? FileHelper::url($model['banner_image_2'], 'full') : '',
        ], $model);
        $blade = (!empty($model['style'])) ? $model['style'] : 'index';

        return view("Template::frontend.blocks.testimonial.{$blade}", $model);
    }

    public function contentAPI($model = []){
        if(!empty($model['list_item'])){
            foreach (  $model['list_item'] as &$item ){
                $item['avatar_url'] = FileHelper::url($item['avatar'], 'full');
            }
        }
        return $model;
    }
}
