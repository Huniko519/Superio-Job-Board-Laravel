<?php
namespace Modules\Template\Blocks;

use Modules\Media\Helpers\FileHelper;

class AboutBlock extends BaseBlock
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
                    'label' => __("Sub Title"),
                    'conditions' => ['style' => 'style_4','style' => 'style_5']
                ],
                [
                    'id' => 'content',
                    'type' => 'editor',
                    'inputType' => 'textArea',
                    'label' => __("Content")
                ],
                [
                    'id' => 'button_name',
                    'type' => 'input',
                    'inputType' => 'text',
                    'label' => __("Button name")
                ],
                [
                    'id' => 'button_url',
                    'type' => 'input',
                    'inputType' => 'text',
                    'label' => __("Button url")
                ],
                [
                    'id' => 'button_target',
                    'type' => 'checkbox',
                    'label' => __("Open in new tab?")
                ],
                [
                    'id' => 'button_color',
                    'type' => 'input',
                    'inputType' => 'text',
                    'label' => __("Button custom color")
                ],
                [
                    'id' => 'featured_image',
                    'type' => 'uploader',
                    'label' => __("Featured Image")
                ],
                [
                    'id' => 'image_2',
                    'type' => 'uploader',
                    'label' => __("Image 2 (opt)")
                ],
                [
                    'id' => 'sub_image_2',
                    'type' => 'input',
                    'inputType' => 'text',
                    'label' => __("Sub Title Image 2")
                ],
            ],
            'category'=>__("Other Block")
        ]);
    }

    public function getName()
    {
        return __('About Us Block');
    }

    public function content($model = [])
    {
        $model = block_attrs([
            'style' => 'style_1',
            'title' => '',
            'sub_title'=>'',
            'content' => '',
            'button_name' => __("Get Started"),
            'button_url' => '',
            'button_target' => 0,
            'featured_image' => '',
            'featured_image_url' => !empty($model['featured_image']) ? FileHelper::url($model['featured_image'], 'full') : '',
            'image_2' => '',
            'image_2_url' => !empty($model['image_2']) ? FileHelper::url($model['image_2'], 'full') : '',
            'sub_image_2'=>'',
        ], $model);

        $style = $model['style'] ? $model['style'] : 'style_1';

        return view("Template::frontend.blocks.about.{$style}", $model);
    }

    public function contentAPI($model = []){

    }
}
