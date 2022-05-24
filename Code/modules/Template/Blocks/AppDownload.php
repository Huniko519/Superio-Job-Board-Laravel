<?php
namespace Modules\Template\Blocks;

use Modules\Media\Helpers\FileHelper;

class AppDownload extends BaseBlock
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
                    'label' => __("Sub title")
                ],
                [
                    'id' => 'desc',
                    'type' => 'input',
                    'inputType' => 'text',
                    'label' => __("Description")
                ],
                [
                    'id' => 'button_image_1',
                    'type' => 'uploader',
                    'label' => __("Button image 1")
                ],
                [
                    'id' => 'button_url_1',
                    'type' => 'input',
                    'inputType' => 'text',
                    'label' => __("Button url 1")
                ],
                [
                    'id' => 'button_image_2',
                    'type' => 'uploader',
                    'label' => __("Button image 2")
                ],
                [
                    'id' => 'button_url_2',
                    'type' => 'input',
                    'inputType' => 'text',
                    'label' => __("Button url 2")
                ],
                [
                    'id' => 'featured_image',
                    'type' => 'uploader',
                    'label' => __("Featured Image")
                ],
            ],
            'category'=>__("Other Block")
        ]);
    }

    public function getName()
    {
        return __('App Download');
    }

    public function content($model = [])
    {
        $model = block_attrs([
            'title' => '',
            'sub_title' => '',
            'desc' => '',
            'button_image_1' => '',
            'button_image_1_url' => !empty($model['button_image_1']) ? FileHelper::url($model['button_image_1'], 'full') : '',
            'button_url_1' => '#',
            'button_image_2' => '',
            'button_image_2_url' => !empty($model['button_image_2']) ? FileHelper::url($model['button_image_2'], 'full') : '',
            'button_url_2' => '#',
            'featured_image' => '',
            'featured_image_url' => !empty($model['featured_image']) ? FileHelper::url($model['featured_image'], 'full') : '',
        ], $model);

        return view("Template::frontend.blocks.app-download.style_1", $model);
    }

    public function contentAPI($model = []){

    }
}
