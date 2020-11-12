<?php

use XoopsModules\Extcal\{Helper,
    EventHandler
};

require_once __DIR__ . '/header.php';
require_once __DIR__ . '/include/constantes.php';

require_once XOOPS_ROOT_PATH . '/class/template.php';

error_reporting(0);
$GLOBALS['xoopsLogger']->activated = false;
global $xoopsConfig;

/** @var Helper $helper */
$helper = Helper::getInstance();
/** @var EventHandler $eventHandler */
$eventHandler = Helper::getInstance()->getHandler(_EXTCAL_CLN_EVENT);

$cat = \Xmf\Request::getInt('cat', 0, 'GET');

if (function_exists('mb_http_output')) {
    mb_http_output('pass');
}

header('Content-Type:text/xml; charset=utf-8');
$tpl          = new \XoopsTpl();
$tpl->caching = 0;
$tpl->xoops_setCacheTime($helper->getConfig('rss_cache_time') * _EXTCAL_TS_MINUTE);
if (!$tpl->is_cached('db:extcal_rss.tpl', $cat)) {
    $events = $eventHandler->getUpcommingEvent($helper->getConfig('rss_nb_event'), $cat);
    if (is_array($events)) {
        $tempSitemap = htmlspecialchars($xoopsConfig['sitename'], ENT_QUOTES);
        $tpl->assign('channel_title', xoops_utf8_encode($tempSitemap));
        $tpl->assign('channel_link', XOOPS_URL . '/');
        $tempSlogan = htmlspecialchars($xoopsConfig['slogan'], ENT_QUOTES);
        $tpl->assign('channel_desc', xoops_utf8_encode($tempSlogan));
        $tpl->assign('channel_lastbuild', formatTimestamp(time(), 'rss'));
        $tpl->assign('channel_webmaster', $xoopsConfig['adminmail']);
        $tpl->assign('channel_editor', $xoopsConfig['adminmail']);
        $tpl->assign('channel_category', 'Event');
        $tpl->assign('channel_generator', 'XOOPS');
        $tpl->assign('channel_language', _LANGCODE);
        $tpl->assign('image_url', XOOPS_URL . '/modules/extcal/assets/images/logoModule.png');
        $tpl->assign('image_width', 92);
        $tpl->assign('image_height', 52);
        foreach ($events as $event) {
            $tempTitle = htmlspecialchars($event->getVar('event_title'), ENT_QUOTES);
            $tempDesc  = htmlspecialchars($event->getVar('event_desc'), ENT_QUOTES);
            $tpl->append(
                'items',
                [
                    'title'       => xoops_utf8_encode($tempTitle),
                    'link'        => XOOPS_URL . '/modules/extcal/event.php?event=' . $event->getVar('event_id'),
                    'guid'        => XOOPS_URL . '/modules/extcal/event.php?event=' . $event->getVar('event_id'),
                    'pubdate'     => formatTimestamp($event->getVar('event_start'), 'rss'),
                    'description' => xoops_utf8_encode($tempDesc),
                ]
            );
        }
    }
}
$tpl->display('db:extcal_rss.tpl', $cat);
