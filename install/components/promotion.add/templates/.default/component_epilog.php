<?php

use Bitrix\Main\Page\Asset;
$uri = $arParams['TEMPLATE_URI']."/templates/".$arParams['COMPONENT_TEMPLATE']."/";

?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css">
<?
Asset::getInstance()->addCss($uri.'libs/css/froala_editor.css');
Asset::getInstance()->addCss($uri.'libs/css/froala_style.css');
Asset::getInstance()->addCss($uri.'libs/css/code_view.css');
Asset::getInstance()->addCss($uri.'libs/css/colors.css');
Asset::getInstance()->addCss($uri.'libs/css/emoticons.css');
Asset::getInstance()->addCss($uri.'libs/css/image_manager.css');
Asset::getInstance()->addCss($uri.'libs/css/image.css');
Asset::getInstance()->addCss($uri.'libs/css/line_breaker.css');
Asset::getInstance()->addCss($uri.'libs/css/table.css');
Asset::getInstance()->addCss($uri.'libs/css/char_counter.css');
Asset::getInstance()->addCss($uri.'libs/css/video.css');
Asset::getInstance()->addCss($uri.'libs/css/fullscreen.css');
Asset::getInstance()->addCss($uri.'libs/css/file.css');
Asset::getInstance()->addCss($uri.'libs/css/quick_insert.css');
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/codemirror.min.css">
<?
Asset::getInstance()->addCss($uri.'libs/selectize/selectize.default.css');
?>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/codemirror.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/mode/xml/xml.min.js"></script>
<?
Asset::getInstance()->addJs($uri.'libs/js/froala_editor.min.js');
Asset::getInstance()->addJs($uri.'libs/js/plugins/align.min.js');
Asset::getInstance()->addJs($uri.'libs/js/plugins/char_counter.min.js');
Asset::getInstance()->addJs($uri.'libs/js/plugins/code_beautifier.min.js');
Asset::getInstance()->addJs($uri.'libs/js/plugins/code_view.min.js');
Asset::getInstance()->addJs($uri.'libs/js/plugins/colors.min.js');
Asset::getInstance()->addJs($uri.'libs/js/plugins/draggable.min.js');
Asset::getInstance()->addJs($uri.'libs/js/plugins/emoticons.min.js');
Asset::getInstance()->addJs($uri.'libs/js/plugins/entities.min.js');
Asset::getInstance()->addJs($uri.'libs/js/plugins/file.min.js');
Asset::getInstance()->addJs($uri.'libs/js/plugins/font_size.min.js');
Asset::getInstance()->addJs($uri.'libs/js/plugins/font_family.min.js');
Asset::getInstance()->addJs($uri.'libs/js/plugins/fullscreen.min.js');
Asset::getInstance()->addJs($uri.'libs/js/plugins/image.min.js');
Asset::getInstance()->addJs($uri.'libs/js/plugins/image_manager.min.js');
Asset::getInstance()->addJs($uri.'libs/js/plugins/line_breaker.min.js');
Asset::getInstance()->addJs($uri.'libs/js/plugins/inline_style.min.js');
Asset::getInstance()->addJs($uri.'libs/js/plugins/link.min.js');
Asset::getInstance()->addJs($uri.'libs/js/plugins/lists.min.js');
Asset::getInstance()->addJs($uri.'libs/js/plugins/paragraph_format.min.js');
Asset::getInstance()->addJs($uri.'libs/js/plugins/paragraph_style.min.js');
Asset::getInstance()->addJs($uri.'libs/js/plugins/quick_insert.min.js');
Asset::getInstance()->addJs($uri.'libs/js/plugins/quote.min.js');
Asset::getInstance()->addJs($uri.'libs/js/plugins/table.min.js');
Asset::getInstance()->addJs($uri.'libs/js/plugins/save.min.js');
Asset::getInstance()->addJs($uri.'libs/js/plugins/url.min.js');
Asset::getInstance()->addJs($uri.'libs/js/plugins/video.min.js');
Asset::getInstance()->addJs($uri.'libs/selectize/selectize.min.js');
Asset::getInstance()->addJs($uri.'libs/cleave.min.js');
Asset::getInstance()->addJs($uri.'js/class.js');
Asset::getInstance()->addJs($uri.'js/script.js');
Bitrix\Main\Diag\Debug::dumpToFile($uri.'libs/css/froala_editor.css', 'was', 'testivan.txt');
?>

