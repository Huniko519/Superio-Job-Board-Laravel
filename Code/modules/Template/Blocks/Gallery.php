<?php
namespace Modules\Template\Blocks;

use Modules\Media\Helpers\FileHelper;
use Modules\Template\Blocks\BaseBlock;

class Gallery extends BaseBlock
{
    function __construct()
    {
        $this->setOptions([
            'settings' => [
                [
                    'id'            => 'style',
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
                    'id'          => 'list_item',
                    'type'        => 'listItem',
                    'label'       => __('List Item(s)'),
                    'title_field' => 'title',
                    'settings'    => [
                        [
                            'id'    => 'image_id',
                            'type'  => 'uploader',
                            'label' => __('Gallery Image')
                        ]
                    ],
                    'conditions' => ['style' => 'style_1']
                ],
                [
                    'id'        => 'title',
                    'type'      => 'input',
                    'inputType' => 'text',
                    'label'     => __('Title'),
                    'conditions' => ['style' => 'style_2']
                ],
                [
                    'id' => 'sub_title',
                    'type' => 'input',
                    'inputType' => 'text',
                    'label' => __("Sub Title"),
                    'conditions' => ['style' => 'style_2']
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
                    'id'          => 'list_item2',
                    'type'        => 'listItem',
                    'label'       => __('List Item(s)'),
                    'title_field' => 'title',
                    'settings'    => [
                        [
                            'id'    => 'image_id',
                            'type'  => 'uploader',
                            'label' => __('Gallery Image')
                        ],
                        [
                            'id'        => 'title',
                            'type'      => 'input',
                            'inputType' => 'text',
                            'label'     => __('Title')
                        ],
                        [
                            'id' => 'sub_title',
                            'type' => 'input',
                            'inputType' => 'text',
                            'label' => __("Sub Title")
                        ],
                        [
                            'id' => 'url_item',
                            'type' => 'input',
                            'inputType' => 'text',
                            'label' => __("Url")
                        ],
                    ],
                    'conditions' => ['style' => 'style_2']
                ],

            ],
            'category'=>__("Other Block")
        ]);
    }

    public function getName()
    {
        return __('Gallery');
    }

    public function content($model = [])
    {
        $style = (!empty($model['style'])) ? $model['style'] : 'style_1';
        if ($style == 'style_1'){
            $items = $itemFirst = $itemCenter = $itemLast = [];
            if (!empty($model['list_item'])){
                foreach ($model['list_item'] as $k => $item){
                    if ($k > 5) continue;
                    if ($k == 0){
                        $itemFirst[] = $item;
                    } elseif ($k == 5){
                        $itemLast[] = $item;
                    } else {
                        $itemCenter[] = $item;
                    }
                }
                $itemCenter = array_chunk($itemCenter,2);
                $items = [$itemFirst,$itemCenter[0],$itemCenter[1],$itemLast];
            }
            $model['list_item'] = array_values($items);
        }
        if ($style == 'style_2'){
            $items = $itemFirst = $itemCenter = $itemLast = [];
            if (!empty($model['list_item2'])){
                foreach ($model['list_item2'] as $k => $item){
                    if ($k > 5) continue;
                    if ($k == 0){
                        $itemFirst[] = $item;
                    } elseif ($k == 5){
                        $itemLast[] = $item;
                    } else {
                        $itemCenter[] = $item;
                    }
                }
                $itemCenter = array_chunk($itemCenter,2);
                $items = [$itemFirst,$itemCenter[0],$itemCenter[1]];
            }
            $model['list_item2'] = array_values($items);
        }
        return view('Template::frontend.blocks.gallery.'.$style, $model);
    }
}
