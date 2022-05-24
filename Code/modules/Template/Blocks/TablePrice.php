<?php
namespace Modules\Template\Blocks;

use Modules\Media\Helpers\FileHelper;

class TablePrice extends BaseBlock
{
    function __construct()
    {
        $this->setOptions([
            'settings' => [
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
                    'id' => 'sale_off_text',
                    'type' => 'input',
                    'inputType' => 'text',
                    'label' => __("Sale Of Text")
                ],
                [
                    'id' => 'monthly_title',
                    'type' => 'input',
                    'inputType' => 'text',
                    'label' => __("Monthly Title")
                ],
                [
                    'id'          => 'monthly_list',
                    'type'        => 'listItem',
                    'label'       => __('Price List - Monthly'),
                    'title_field' => 'title',
                    'settings'    => [
                        [
                            'id'        => 'title',
                            'type'      => 'input',
                            'inputType' => 'text',
                            'label'     => __('Title')
                        ],
                        [
                            'id'        => 'price',
                            'type'      => 'input',
                            'inputType' => 'text',
                            'label'     => __('Price')
                        ],
                        [
                            'id'        => 'unit',
                            'type'      => 'input',
                            'inputType' => 'text',
                            'label'     => __('Unit')
                        ],
                        [
                            'id'    => 'featured',
                            'type'  => 'editor',
                            'inputType' => 'textArea',
                            'label' => __('Featured')
                        ],
                        [
                            'id'        => 'button_name',
                            'type'      => 'input',
                            'inputType' => 'text',
                            'label'     => __('Button Name')
                        ],
                        [
                            'id'        => 'button_url',
                            'type'      => 'input',
                            'inputType' => 'text',
                            'label'     => __('Button Url')
                        ],
                        [
                            'id' => 'is_recommended',
                            'type' => 'checkbox',
                            'label' => __("Recommended?")
                        ]
                    ]
                ],
                [
                    'id' => 'annual_title',
                    'type' => 'input',
                    'inputType' => 'text',
                    'label' => __("AnnualSave Title")
                ],
                [
                    'id'          => 'annual_list',
                    'type'        => 'listItem',
                    'label'       => __('Price List - AnnualSave'),
                    'title_field' => 'title',
                    'settings'    => [
                        [
                            'id'        => 'title',
                            'type'      => 'input',
                            'inputType' => 'text',
                            'label'     => __('Title')
                        ],
                        [
                            'id'        => 'price',
                            'type'      => 'input',
                            'inputType' => 'text',
                            'label'     => __('Price')
                        ],
                        [
                            'id'        => 'unit',
                            'type'      => 'input',
                            'inputType' => 'text',
                            'label'     => __('Unit')
                        ],
                        [
                            'id'    => 'featured',
                            'type'  => 'editor',
                            'inputType' => 'textArea',
                            'label' => __('Featured')
                        ],
                        [
                            'id'        => 'button_name',
                            'type'      => 'input',
                            'inputType' => 'text',
                            'label'     => __('Button Name')
                        ],
                        [
                            'id'        => 'button_url',
                            'type'      => 'input',
                            'inputType' => 'text',
                            'label'     => __('Button Url')
                        ],
                        [
                            'id' => 'is_recommended',
                            'type' => 'checkbox',
                            'label' => __("Recommended?")
                        ]
                    ]
                ],
                [
                    'id' => 'button_target',
                    'type' => 'checkbox',
                    'label' => __("Open in new tab?")
                ]
            ],
            'category'=>__("Other Block")
        ]);
    }

    public function getName()
    {
        return __('Table Pricing');
    }

    public function content($model = [])
    {
        $model = block_attrs([
            'style' => 'style_1',
            'title' => '',
            'sub_title' => '',
            'monthly_title' => '',
            'monthly_list' => '',
            'annual_title' => '',
            'annual_list' => '',
            'sale_off_text' => '',
            'button_target' => '',
        ], $model);

        $style = $model['style'] ? $model['style'] : 'style_1';

        return view("Template::frontend.blocks.table-price.{$style}", $model);
    }

    public function contentAPI($model = []){

    }
}
