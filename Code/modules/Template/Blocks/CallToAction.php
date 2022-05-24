<?php
namespace Modules\Template\Blocks;

use Modules\Template\Blocks\BaseBlock;
use Modules\Location\Models\Location;
use Modules\Media\Helpers\FileHelper;

class CallToAction extends BaseBlock
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
                        ],
                        [
                            'value'   => 'style_6',
                            'name' => __("Style 6")
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
                    'id'        => 'link_search',
                    'type'      => 'input',
                    'inputType' => 'text',
                    'label'     => __('Button name 1')
                ],
                [
                    'id'        => 'url_search',
                    'type'      => 'input',
                    'inputType' => 'text',
                    'label'     => __('Button url 1')
                ],
                [
                    'id'        => 'link_apply',
                    'type'      => 'input',
                    'inputType' => 'text',
                    'label'     => __('Button name 2'),
                    'conditions' => ['style' => 'style_1','style' => 'style_6']
                ],
                [
                    'id'        => 'url_apply',
                    'type'      => 'input',
                    'inputType' => 'text',
                    'label'     => __('Button url 2'),
                    'conditions' => ['style' => 'style_1','style' => 'style_6']
                ],
                [
                    'id'    => 'bg_image',
                    'type'  => 'uploader',
                    'label' => __('Background Image Uploader')
                ]
            ],
            'category'=>__("Other Block")
        ]);
    }

    public function getName()
    {
        return __('Call To Action');
    }

    public function content($model = [])
    {
        $model['style'] = !empty($model['style']) ? $model['style'] :  "style_1";
        if (!empty($model['bg_image'])) {
            $model['bg_image_url'] = FileHelper::url($model['bg_image'], 'full');
        }
        return view('Template::frontend.blocks.call-to-action.'.$model['style'], $model);
    }
}
