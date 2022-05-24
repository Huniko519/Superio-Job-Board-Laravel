<?php
namespace Modules\Template\Blocks;

use Modules\Media\Helpers\FileHelper;
use Modules\Template\Blocks\BaseBlock;

class BlockCounter extends BaseBlock
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
                        ]
                    ],
                ],
                [
                    'id'          => 'list_item',
                    'type'        => 'listItem',
                    'label'       => __('List Item(s)'),
                    'title_field' => 'title',
                    'settings'    => [
                        [
                            'id'    => 'number',
                            'type'      => 'input',
                            'inputType' => 'text',
                            'label' => __('Count Number'),
                        ],
                        [
                            'id'    => 'symbol',
                            'type'      => 'input',
                            'inputType' => 'text',
                            'label' => __('Count symbol'),
                        ],
                        [
                            'id'    => 'desc',
                            'type'      => 'input',
                            'inputType' => 'text',
                            'label' => __('Desc')
                        ],
                    ]
                ]
            ],
            'category'=>__("Other Block")
        ]);
    }

    public function getName()
    {
        return __('Block Counter');
    }

    public function content($model = [])
    {
        $blade = (!empty($model['style'])) ? $model['style'] : 'style_1';
        return view('Template::frontend.blocks.count-number.'.$blade, $model);
    }
}
