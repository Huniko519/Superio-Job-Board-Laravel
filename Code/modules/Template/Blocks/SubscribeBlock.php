<?php
namespace Modules\Template\Blocks;

use Modules\Media\Helpers\FileHelper;

class SubscribeBlock extends BaseBlock
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
                    'id'        => 'title',
                    'type'      => 'input',
                    'inputType' => 'text',
                    'label'     => __('Title'),
                ],
                [
                    'id'        => 'sub_title',
                    'type'      => 'input',
                    'inputType' => 'text',
                    'label'     => __('Sub Title'),
                ],
                [
                    'id'        => 'button_name',
                    'type'      => 'input',
                    'inputType' => 'text',
                    'label'     => __('Button name'),
                ],
            ],
            'category'=>__("Other Block")
        ]);
    }

    public function getName()
    {
        return __('Subscribe Block');
    }

    public function content($model = [])
    {
        $style = (!empty($model['style'])) ? $model['style'] : 'style_1';

        return view("Template::frontend.blocks.subscribe.{$style}", $model);
    }

    public function contentAPI($model = []){

    }
}
