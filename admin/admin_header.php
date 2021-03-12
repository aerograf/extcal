<?php
/*
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

/**
 * @copyright    {@link https://xoops.org/ XOOPS Project}
 * @license      {@link https://www.gnu.org/licenses/gpl-2.0.html GNU GPL 2 or later}
 * @package      extcal
 * @since
 * @author       XOOPS Development Team,
 */

use XoopsModules\Extcal\{Helper,
    Utility,
    CategoryHandler,
    EventHandler,
    EventmemberHandler,
    EventNotMemberHandler,
    FileHandler,
    LocationHandler
};
use Xmf\Module\Admin;
/** @var Helper $helper */
/** @var CategoryHandler $categoryHandler */
/** @var EventHandler $eventHandler */
/** @var EventmemberHandler $eventmemberHandler */
/** @var EventNotMemberHandler $eventNotMemberHandler */
/** @var FileHandler $fileHandler */
/** @var LocationHandler $locationHandler */

require_once dirname(__DIR__, 3) . '/include/cp_header.php';
require_once $GLOBALS['xoops']->path('www/class/xoopsformloader.php');
require_once dirname(__DIR__) . '/include/constantes.php';

require_once dirname(__DIR__) . '/preloads/autoloader.php';

$moduleDirName      = basename(dirname(__DIR__));
$moduleDirNameUpper = mb_strtoupper($moduleDirName);

$helper = Helper::getInstance();
/** @var Xmf\Module\Admin $adminObject */
$adminObject = Admin::getInstance();
$utility     = new Utility();

require_once dirname(__DIR__) . '/include/common.php';

$adminObject = Admin::getInstance();

$pathIcon16    = Admin::iconUrl('', 16);
$pathIcon32    = Admin::iconUrl('', 32);
$pathModIcon32 = $helper->getModule()->getInfo('modicons32');

// Load language files
$helper->loadLanguage('admin');
$helper->loadLanguage('modinfo');
$helper->loadLanguage('main');
$helper->loadLanguage('common');

$myts = \MyTextSanitizer::getInstance();

if (!isset($GLOBALS['xoopsTpl']) || !($GLOBALS['xoopsTpl'] instanceof \XoopsTpl)) {
    require_once $GLOBALS['xoops']->path('class/template.php');
    $xoopsTpl = new \XoopsTpl();
}

$categoryHandler = $helper->getHandler(_EXTCAL_CLN_CAT);
$eventHandler = $helper->getHandler(_EXTCAL_CLN_EVENT);
$eventmemberHandler = $helper->getHandler(_EXTCAL_CLN_MEMBER);
$eventNotMemberHandler = $helper->getHandler(_EXTCAL_CLN_NOT_MEMBER);
$fileHandler = $helper->getHandler(_EXTCAL_CLN_FILE);
$locationHandler = $helper->getHandler(_EXTCAL_CLN_LOCATION);
