<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */

$this->setFrameMode(true);

if(!$arResult["NavShowAlways"])
{
	if ($arResult["NavRecordCount"] == 0 || ($arResult["NavPageCount"] == 1 && $arResult["NavShowAll"] == false))
		return;
}

$strNavQueryString = ($arResult["NavQueryString"] != "" ? $arResult["NavQueryString"]."&amp;" : "");
$strNavQueryStringFull = ($arResult["NavQueryString"] != "" ? "?".$arResult["NavQueryString"] : "");
?>


<div class="text-center">
<span class="pagination__heading"><?=$arResult["NavTitle"]?>

<!-- если по убывающей -->
<?if($arResult["bDescPageNumbering"] === true):?>

	<?=$arResult["NavFirstRecordShow"]?> <?=GetMessage("nav_to")?> <?=$arResult["NavLastRecordShow"]?> <?=GetMessage("nav_of")?> <?=$arResult["NavRecordCount"]?>
		
	</span>

	<div class="pagination">
	<div class="pagination__holder">

	<?if ($arResult["NavPageNomer"] < $arResult["NavPageCount"]):?>
		<?if($arResult["bSavePage"]):?>
			<a class="pagination-link pagination-link_disabled pagination-link_beginning" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["NavPageCount"]?>"><?=GetMessage("nav_begin")?></a>
			
			<a class="pagination-link pagination-link_disabled" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]+1)?>"><?=GetMessage("nav_prev")?></a>
			
		<?else:?>
			<a class="pagination-link pagination-link_beginning" href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>"><?=GetMessage("nav_begin")?></a>
			<!-- | -->
			<?if ($arResult["NavPageCount"] == ($arResult["NavPageNomer"]+1) ):?>
				<a class="pagination-link" href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>"><?=GetMessage("nav_prev")?></a>
				<!-- | -->
			<?else:?>
				<a class="pagination-link" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]+1)?>"><?=GetMessage("nav_prev")?></a>
				<!-- | -->
			<?endif?>
		<?endif?>
	<?else:?>
		<a class="pagination-link pagination-link_beginning">
			<?=GetMessage("nav_begin")?></a> 
		</a>
		<a class="pagination-link">
			<?=GetMessage("nav_prev")?>
		</a>
	<?endif?>

	<?while($arResult["nStartPage"] >= $arResult["nEndPage"]):?>
		<?$NavRecordGroupPrint = $arResult["NavPageCount"] - $arResult["nStartPage"] + 1;?>

		<?if ($arResult["nStartPage"] == $arResult["NavPageNomer"]):?>
			<div class="search__pagination-num">
				<b><?=$NavRecordGroupPrint?></b>
			</div>
		<?elseif($arResult["nStartPage"] == $arResult["NavPageCount"] && $arResult["bSavePage"] == false):?>
			<a class="" href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>"><?=$NavRecordGroupPrint?></a>
		<?else:?>
			<a class="" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["nStartPage"]?>"><?=$NavRecordGroupPrint?></a>
		<?endif?>

		<?$arResult["nStartPage"]--?>
	<?endwhile?>



	<?if ($arResult["NavPageNomer"] > 1):?>
		<a class="" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]-1)?>"><?=GetMessage("nav_next")?></a>
		<!-- | -->
		<a class="pagination-link pagination-link_end" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=1"><?=GetMessage("nav_end")?></a>
	<?else:?>
		<a class="pagination-link pagination-link_end"><?=GetMessage("nav_next")?></a><a class=""><?=GetMessage("nav_end")?></a>
	<?endif?>



<?else:?>

	<?=$arResult["NavFirstRecordShow"]?> <?=GetMessage("nav_to")?> <?=$arResult["NavLastRecordShow"]?> <?=GetMessage("nav_of")?> <?=$arResult["NavRecordCount"]?>
	</span>

<div class="text-center">
	<div class="pagination">

	<div class="pagination__holder">

	<!-- КАКАЯ ЭТО СТРАНИЦА? 
	========================-->

	<!-- если НЕ первая -->
	<?if ($arResult["NavPageNomer"] > 1):?>
		
		<!-- не на первой -->
		<?if($arResult["bSavePage"]):?>

			<a 	class="pagination-link pagination-link_beginning" 
				href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=1">
				<?=GetMessage("nav_begin")?>
			</a>

			<a 	class="pagination-link" 
				href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]-1)?>">
				<?=GetMessage("nav_prev")?>
			</a>
		<!-- что за условие??? -->
		<?else:?>
			<a 	class="pagination-link pagination-link_beginning" 
				href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>"><?=GetMessage("nav_begin")?>
			</a>

			<?if ($arResult["NavPageNomer"] > 2):?>
				<a 	class="pagination-link" 
					href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]-1)?>"><?=GetMessage("nav_prev")?>
				</a>
			<?else:?>
				<a 	class="pagination-link" 
					href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>">
					<?=GetMessage("nav_prev")?>
				</a>
			<?endif?>
		<?endif?>


	<!-- не на первой -->
	<?else:?>
		<a class="pagination-link pagination-link_disabled pagination-link_beginning"><?=GetMessage("nav_begin")?></a>
		<a class="pagination-link pagination-link_disabled"><?=GetMessage("nav_prev")?></a>
	<?endif?>

	<!-- ========================
	 какая это страница КОНЕЦ -->





	
	<!-- ВЫВОД ЦИФР ПОСТРАНИЧНО 
	========================-->

	<?while($arResult["nStartPage"] <= $arResult["nEndPage"]):?>

		<?if ($arResult["nStartPage"] == $arResult["NavPageNomer"]):?>
			<div class="pagination-link pagination-link_number pagination-link_number-current">
				<?=$arResult["nStartPage"]?>
			</div>
		<?elseif($arResult["nStartPage"] == 1 && $arResult["bSavePage"] == false):?>
			<a class="pagination-link pagination-link_number" href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>"><?=$arResult["nStartPage"]?></a>
		<?else:?>
			<a class="pagination-link pagination-link_number" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["nStartPage"]?>"><?=$arResult["nStartPage"]?></a>
		<?endif?>
		<?$arResult["nStartPage"]++?>
	<?endwhile?>

	<!-- ====================
	ВЫВОД ЦИФР ПОСТРАНИЧНО КОНЕЦ -->



	<!-- не на последней -->
	<?if($arResult["NavPageNomer"] < $arResult["NavPageCount"]):?>
		<a 	class="pagination-link" 
			href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]+1)?>"><?=GetMessage("nav_next")?></a>
		<a 	class="pagination-link pagination-link_end" 
			href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["NavPageCount"]?>"><?=GetMessage("nav_end")?></a>


	<!-- на последней -->
	<?else:?>
		<a 	class="pagination-link pagination-link_disabled">
			<?=GetMessage("nav_next")?>
		</a>
		<a 	class="pagination-link pagination-link_disabled pagination-link_end">
			<?=GetMessage("nav_end")?>
		</a>
	<?endif?>

<?endif?>


<!-- <?if ($arResult["bShowAll"]):?>
<noindex>
	<?if ($arResult["NavShowAll"]):?>
		<a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>SHOWALL_<?=$arResult["NavNum"]?>=0" rel="nofollow">
			<?=GetMessage("nav_paged")?>
		</a>
	<?else:?>
		<a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>SHOWALL_<?=$arResult["NavNum"]?>=1" rel="nofollow">
			<?=GetMessage("nav_all")?>
		</a>
	<?endif?>
</noindex>
<?endif?> -->

</div>
</div>
</div>