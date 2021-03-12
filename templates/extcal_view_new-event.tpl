<form action="<{$navigSelectBox.action|default:false}>" method="<{$navigSelectBox.method|default:false}>">
    <{foreach item=element from=$navigSelectBox.elements|default:false}>
    <{$element.body|default:false}>
    <{/foreach}>
</form>

<{include file="db:extcal_navbar.tpl"}>

<{$formEdit}>


<div style="text-align:right;"><a href="<{$xoops_url}>/modules/extcal/rss.php?cat=<{$selectedCat|default:false}>">
        <img src="assets/images/icons/rss.gif" alt="RSS Feed">
    </a></div>

<{include file='db:system_notification_select.tpl'}>
