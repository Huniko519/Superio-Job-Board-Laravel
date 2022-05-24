<?php


namespace Modules\Email\Plugins;


use Pelago\Emogrifier\CssInliner;
use Swift_Events_SendEvent;

class InlineCssPlugin implements \Swift_Events_SendListener
{
    /**
     * Inline the CSS before an email is sent.
     *
     * @param \Swift_Events_SendEvent $evt
     */
    public function beforeSendPerformed(\Swift_Events_SendEvent $evt)
    {
        $message = $evt->getMessage();

        $properTypes = [
            'text/html',
            'multipart/alternative',
            'multipart/mixed',
        ];

        $css = file_get_contents(public_path('module/email/css/style.css'));
        $css.=' .b-header{
            background: '.setting_item('style_main_color','#5291fa').';
        }';

        if ($message->getBody() && in_array($message->getContentType(), $properTypes)) {
            $message->setBody(CssInliner::fromHtml($message->getBody())->inlineCss($css)->render());
        }

        foreach ($message->getChildren() as $part) {
            if (strpos($part->getContentType(), 'text/html') === 0) {
                $message->setBody(CssInliner::fromHtml($part->getBody())->inlineCss($css)->render());
            }
        }
    }

    public function sendPerformed(Swift_Events_SendEvent $evt)
    {
        // TODO: Implement sendPerformed() method.
    }
}
