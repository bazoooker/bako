<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?foreach($arResult as $arItem):?>
<?
	if($arItem['DEPTH_LEVEL']==1) {
		if ($arItem["SELECTED"]) {
?>
			<a class="active" href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a>
<?
		} else {
?>
			<a href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a>
<?
		}
	}
?>
<?endforeach?>
