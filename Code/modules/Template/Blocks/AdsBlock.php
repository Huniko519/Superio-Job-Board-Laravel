<?php
namespace Modules\Template\Blocks;

use Modules\Media\Helpers\FileHelper;

class AdsBlock extends BaseBlock
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
                        ]
                    ],
                ],
                [
                    'id'          => 'list_item',
                    'type'        => 'listItem',
                    'label'       => __('List Ads Item(s)'),
                    'title_field' => 'title',
                    'settings'    => [
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
                            'id'        => 'button_name',
                            'type'      => 'input',
                            'inputType' => 'text',
                            'label'     => __('Button name')
                        ],
                        [
                            'id'    => 'image_id',
                            'type'  => 'uploader',
                            'label' => __('Ads Image')
                        ],
                        [
                            'id'        => 'ads_link',
                            'type'      => 'input',
                            'inputType' => 'text',
                            'label'     => __('Ads Link')
                        ],
                    ]
                ],
            ],
            'category'=>__("Other Block")
        ]);
    }

    public function getName()
    {
        return __('Ads Block');
    }

    public function content($model = [])
    {
        $style = (!empty($model['style'])) ? $model['style'] : 'style_1';

        return view("Template::frontend.blocks.ads.{$style}", $model);
    }

    public function contentAPI($model = []){

    }
}
