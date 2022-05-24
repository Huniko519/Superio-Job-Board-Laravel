<?php
namespace Modules\Template\Blocks;

use Modules\Media\Helpers\FileHelper;
use Modules\Template\Blocks\BaseBlock;

class BreadcrumbSection extends BaseBlock
{
    function __construct()
    {
        $this->setOptions([
            'settings' => [
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
                    'id'        => 'bg_color',
                    'type'      => 'input',
                    'inputType' => 'text',
                    'label'     => __('Background Color')
                ]
            ],
            'category'=>__("Other Block")
        ]);
    }

    public function getName()
    {
        return __('Breadcrumb Section');
    }

    public function content($model = []){
        $bg_color = (!empty($model['bg_color'])) ? $model['bg_color'] : '';
        $model['bg_class'] = (!empty($bg_color)) ? 'bg_color' : '';
        return view('Template::frontend.blocks.box-hero', $model);
    }

    public function contentAPI($model = []){
        if (!empty($model['bg_image'])) {
            $model['bg_image_url'] = FileHelper::url($model['bg_image'], 'full');
        }
        return $model;
    }
}
