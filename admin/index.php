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
    Common,
    Common\TestdataButtons,
    Utility
};
use Xmf\Request;
use Xmf\Yaml;

/** @var Xmf\Module\Admin $adminObject */
/** @var Utility $utility */
/** @var Helper $helper */

require_once __DIR__ . '/admin_header.php';
// Display Admin header
xoops_cp_header();

$helper       = Helper::getInstance();
$configurator = new Common\Configurator();

//foreach (array_keys($configurator['uploadFolders']) as $i) {
//    $utility::createFolder($configurator['uploadFolders'][$i]);
//    $adminObject->addConfigBoxLine($configurator['uploadFolders'][$i], 'folder');
//    //    $adminObject->addConfigBoxLine(array($configurator['uploadFolders'][$i], '777'), 'chmod');
//}

//count "total categories"
/** @var \XoopsPersistableObjectHandler $categoryHandler */
$countCategory = $categoryHandler->getCount();
//count "total events"
/** @var \XoopsPersistableObjectHandler $eventHandler */
$countEvent = $eventHandler->getCount();
//count "total eventmembers"
/** @var \XoopsPersistableObjectHandler $eventmemberHandler */
$countEventmember = $eventmemberHandler->getCount();
//count "total eventnotmembers"
/** @var \XoopsPersistableObjectHandler $eventNotMemberHandler */
$countEventnotmember = $eventNotMemberHandler->getCount();
//count "total files"
/** @var \XoopsPersistableObjectHandler $fileHandler */
$countFile = $fileHandler->getCount();
//count "total location"
/** @var \XoopsPersistableObjectHandler $locationHandler */
$countLocation = $locationHandler->getCount();
// InfoBox Statistics
$adminObject->addInfoBox(AM_EXTCAL_STATISTICS);

// InfoBox extcal_cat
$adminObject->addInfoBoxLine(sprintf(AM_EXTCAL_THEREARE_EXTCAL_CAT, $countCategory));

// InfoBox extcal_event
$adminObject->addInfoBoxLine(sprintf(AM_EXTCAL_THEREARE_EXTCAL_EVENT, $countEvent));

// InfoBox extcal_eventmember
$adminObject->addInfoBoxLine(sprintf(AM_EXTCAL_THEREARE_EXTCAL_EVENTMEMBER, $countEventmember));

// InfoBox extcal_eventnotmember
$adminObject->addInfoBoxLine(sprintf(AM_EXTCAL_THEREARE_EXTCAL_EVENTNOTMEMBER, $countEventnotmember));

// InfoBox extcal_file
$adminObject->addInfoBoxLine(sprintf(AM_EXTCAL_THEREARE_EXTCAL_FILE, $countFile));

// InfoBox extcal_location
$adminObject->addInfoBoxLine(sprintf(AM_EXTCAL_THEREARE_EXTCAL_LOCATION, $countLocation));
// Render Index
$adminObject->displayNavigation(basename(__FILE__));

//check for latest release
//$newRelease = $utility::checkVerModule($helper);
//if (!empty($newRelease)) {
//    $adminObject->addItemButton($newRelease[0], $newRelease[1], 'download', 'style="color : Red"');
//}


//***************************************************************************************
$pendingEvent = $eventHandler->objectToArray($eventHandler->getPendingEvent(), ['cat_id']);
$eventHandler->formatEventsDate($pendingEvent, _SHORTDATESTRING);

echo '<fieldset><legend style="font-weight:bold; color:#990000;">' . _AM_EXTCAL_PENDING_EVENT . '</legend>';
echo '<fieldset><legend style="font-weight:bold; color:#0A3760;">' . _AM_EXTCAL_INFORMATION . '</legend>';
echo '<img src=' . $pathIcon16 . '/on.png>&nbsp;&nbsp;' . _AM_EXTCAL_INFO_APPROVE_PENDING_EVENT . '<br>';
echo '<img src=' . $pathIcon16 . '/edit.png>&nbsp;&nbsp;' . _AM_EXTCAL_INFO_EDIT_PENDING_EVENT . '<br>';
echo '<img src=' . $pathIcon16 . '/delete.png>&nbsp;&nbsp;' . _AM_EXTCAL_INFO_DELETE_PENDING_EVENT . '<br>';
echo '</fieldset><br>';

echo '<table class="outer" style="width:100%;">';
echo '<tr style="text-align:center;">';
echo '<th>' . _AM_EXTCAL_CATEGORY . '</th>';
echo '<th>' . _AM_EXTCAL_TITLE . '</th>';
echo '<th>' . _AM_EXTCAL_START_DATE . '</th>';
echo '<th>' . _AM_EXTCAL_ACTION . '</th>';
echo '</tr>';

if (count($pendingEvent) > 0) {
    $i = 0;
    foreach ($pendingEvent as $event) {
        $class = (0 == ++$i % 2) ? 'even' : 'odd';
        echo '<tr style="text-align:center;" class="' . $class . '">';
        echo '<td>' . $event['cat']['cat_name'] . '</td>';
        echo '<td>' . $event['event_title'] . '</td>';
        echo '<td>' . $event['formated_event_start'] . '</td>';
        echo '<td style="width:10%; text-align:center;">';
        echo '<a href="event.php?op=modify&amp;event_id=' . $event['event_id'] . '"><img src=' . $pathIcon16 . '/on.png></a>&nbsp;&nbsp;';
        echo '<a href="event.php?op=modify&amp;event_id=' . $event['event_id'] . '"><img src=' . $pathIcon16 . '/edit.png></a>&nbsp;&nbsp;';
        echo '<a href="event.php?op=delete&amp;event_id=' . $event['event_id'] . '"><img src=' . $pathIcon16 . '/delete.png></a>';
        echo '</td>';
        echo '</tr>';
    }
} else {
    echo '<tr><td colspan="4">' . _AM_EXTCAL_NO_PENDING_EVENT . '</td></tr>';
}

echo '</table></fieldset><br>';


//------------- Test Data Buttons ----------------------------
if ($helper->getConfig('displaySampleButton')) {
    TestdataButtons::loadButtonConfig($adminObject);
    $adminObject->displayButton('left', '');;
}
$op = Request::getString('op', 0, 'GET');
switch ($op) {
    case 'hide_buttons':
        TestdataButtons::hideButtons();
        break;
    case 'show_buttons':
        TestdataButtons::showButtons();
        break;
}
//------------- End Test Data Buttons ----------------------------


$adminObject->displayIndex();
echo $utility::getServerStats();

//codeDump(__FILE__);
require __DIR__ . '/admin_footer.php';


