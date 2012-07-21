<?php

function include_og_metas()
{
    $context = sfContext::getInstance();
    $i18n = sfConfig::get('sf_i18n') ? $context->getI18N() : null;
    $ogPresent = false;
    // getOGMetas() listener is into plugin configuration
    foreach ($context->getResponse()->getOGMetas() as $property => $content)
    {
        $ogPresent = true;
        echo tag('meta', array('property' => 'og:' . $property, 'content' => null === $i18n ? $content : $i18n->__($content))) . "\n";
    }

    // autoappend og:url
    if ($ogPresent)
    {
        $url = url_for($context->getRouting()->getCurrentInternalUri(true), true);
        echo tag('meta', array('property' => 'og:url', 'content' => $url)) . "\n";
    }
}