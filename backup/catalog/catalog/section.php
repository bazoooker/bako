<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<!-- Вывод подразделов каталога -->



<div class="container">


    <div class="breadcrumbs">
        
        <!-- выводи ссылку вместе со стрелкой. У последней ссылки стрелка убирается в css -->

        <!-- один уровень -->
        <a href="/" title="Главная" class="breadcrumbs__item">
            Главная
        </a>
        <i class="breadcrumb__arrow">
            <span class="i i-breadcrumb-arrow"></span>
        </i>
<?
$resSection = CIBlockSection::GetNavChain(false, $arResult["VARIABLES"]["SECTION_ID"]);

while($arSectionPath = $resSection->GetNext()){?>
 <? ?>
 	<?if ($arSectionPath['DEPTH_LEVEL']  == '1') continue?>
       
        <?=$arSectionPath['SECTION_PAGE_URL'];?>
        <a href="/catalog/<?=$arSectionPath['ID']?>/" title="Инфраструктура" class="breadcrumbs__item">
            <? $str2 = substr($arSectionPath['NAME'], 5); ?>
            <?=$str2?>
        </a>
        <i class="breadcrumb__arrow">
            <span class="i i-breadcrumb-arrow"></span>
        </i>

<?} 

?>


    </div>
</div>




<div class="bg-texture">
    <div class="container mb-80">
    	<?$res = CIBlockSection::GetByID($arResult["VARIABLES"]["SECTION_ID"]);
		if($ar_res = $res->GetNext())?>

		<!-- убрать цифры в названии раздела -->
            <? $str2 = substr($ar_res['NAME'], 5); ?>
        <h1><?=$str2?></h2>


        <div class="row product-list">


<?
if (CModule::IncludeModule("iblock"))
{
    $arFilter = array(
        "ACTIVE" => "Y",
        "GLOBAL_ACTIVE" => "Y",
        "IBLOCK_ID" => $arParams["IBLOCK_ID"],
    );
    if(strlen($arResult["VARIABLES"]["SECTION_CODE"])>0)
    {
        $arFilter["=CODE"] = $arResult["VARIABLES"]["SECTION_CODE"];
    }
    elseif($arResult["VARIABLES"]["SECTION_ID"]>0)
    {
        $arFilter["ID"] = $arResult["VARIABLES"]["SECTION_ID"];
    }
        
    $obCache = new CPHPCache;
    if($obCache->InitCache(36000, serialize($arFilter), "/iblock/catalog"))
    {
        $arCurSection = $obCache->GetVars();
    }
    else
    {
        $arCurSection = array();
        $dbRes = CIBlockSection::GetList(array(), $arFilter, false, array("ID"));
        $dbRes = new CIBlockResult($dbRes);
   if(defined("BX_COMP_MANAGED_CACHE"))
        {
            global $CACHE_MANAGER;
            $CACHE_MANAGER->StartTagCache("/iblock/catalog");

            if ($arCurSection = $dbRes->GetNext())
            {
                $CACHE_MANAGER->RegisterTag("iblock_id_".$arParams["IBLOCK_ID"]);
            }
            $CACHE_MANAGER->EndTagCache();
        }
        else
        {
            if(!$arCurSection = $dbRes->GetNext())
                $arCurSection = array();
        }
      $obCache->EndDataCache($arCurSection);
    }
    ?>
   <?$APPLICATION->IncludeComponent(
      "bitrix:catalog.smart.filter",
      "visual_vertical",
      Array(
         "PRICE_CODE" => array(0=>"Розничные",),
         "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
         "IBLOCK_ID" => $arParams["IBLOCK_ID"],
         "SECTION_ID" => $arCurSection['ID'],
         "FILTER_NAME" => $arParams["FILTER_NAME"],
         "CACHE_TYPE" => $arParams["CACHE_TYPE"],
         "CACHE_TIME" => $arParams["CACHE_TIME"],
         "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
         "SAVE_IN_SESSION" => "N",
         "XML_EXPORT" => "Y",
         "SECTION_TITLE" => "NAME",
         "SECTION_DESCRIPTION" => "DESCRIPTION",
         'HIDE_NOT_AVAILABLE' => $arParams["HIDE_NOT_AVAILABLE"],
         "TEMPLATE_THEME" => $arParams["TEMPLATE_THEME"]
      ),
      $component,
      array('HIDE_ICONS' => 'Y')
   );?>
<?}?>
 
<?
// всякие сортировки и кол-во для показа
$pageElementCount = $arParams["PAGE_ELEMENT_COUNT"];
if (array_key_exists("showBy", $_REQUEST)) {
    if ( intVal($_REQUEST["showBy"]) && in_array(intVal($_REQUEST["showBy"]), array(15, 30, 45, 60)) ) {
        $pageElementCount = intVal($_REQUEST["showBy"]); 
        $_SESSION["showBy"] = $pageElementCount;
    } elseif ($_SESSION["showBy"]) {
        $pageElementCount = intVal($_SESSION["showBy"]);
    }
}

// Проверяем направление сортировки и меняем в случае необходимости:

if (isset($_REQUEST['orderBy'])) {
    if ($_REQUEST['orderBy'] == 'asc') {
        $orderBy = 'desc';
    } else {
        $orderBy = 'asc';
    }
} else {
    $orderBy = 'desc';
}


// передадим полученные данные в переменную $sortBy:
if (isset($_REQUEST['sortBy'])) {
    $sortBy = $_REQUEST['sortBy'];
} else {
    $sortBy = 'sort';
}
if ($sortBy=='price') {
    $sortBy = 'CATALOG_PRICE_1';
}
if ($sortBy=='show_counter') {
    $sortBy = 'show_counter';
}
if ($sortBy=='qty') {
    $sortBy = 'CATALOG_QUANTITY';
}
?>

            <div class="col-9">

                <div class="product-list-controls">
                    <span class="btn btn_main btn_size-s js-show-filters">фильтры</span>

<!--                     <div class="show_number">
                        <span class="show_title">Показать по </span>
                        <span class="number_list">
                            <? for( $i = 15; $i <= 60; $i+=15 ) : ?>
                                <a rel="nofollow" <? if ($i == $pageElementCount): ?>class="current"<? endif; ?> 
                                     href="<?= $APPLICATION->GetCurPageParam('showBy='.$i, array('showBy', 'mode')) ?>"
                                >
                                    <span><?= $i ?></span>
                                </a>
                            <? endfor; ?>
                        </span>
                    </div> -->
                    <div class="sort">
                        <span>Сортировать:</span>
    <a rel="nofollow" class="sort__link <?if($sortBy == 'CATALOG_PRICE_1'):?> active <? endif; ?>"
         href="<?= $APPLICATION->GetCurPageParam('sortBy=price&orderBy='.$orderBy, array('sortBy', 'orderBy')) ?>">по цене</a>
    <a rel="nofollow" class="sort__link <?if($sortBy == 'CATALOG_QUANTITY'):?> active <? endif; ?>"
   href="<?= $APPLICATION->GetCurPageParam('sortBy=qty&orderBy='.$orderBy, array('sortBy', 'orderBy')) ?>">по наличию</a>
    <a rel="nofollow" class="sort__link <?if($sortBy == 'show_counter'):?> active <? endif; ?>"
         href="<?= $APPLICATION->GetCurPageParam('sortBy=show_counter&orderBy='.$orderBy, array('sortBy', 'orderBy')) ?>">по популярности</a>
                        <!-- <a href="javascript:void(0)" class="sort__link active js-prod-sort">по цене</a>
                        <a href="javascript:void(0)" class="sort__link js-prod-sort">по наличию</a>
                        <a href="javascript:void(0)" class="sort__link js-prod-sort">по популярности</a> -->
                    </div>

                    <!-- вид пока убираем -->

                    <div class="view">
                        <span>Вид:</span> 
                        <div class="view__btn-group">
                            <a id="plitka" title="Плиткой" class="active view-list js-prod-view" href="javascript:void(0)">
                                <i class="i view-cards_active"></i>
                            </a> 
                            <a id="spisok" title="Списком" class="view-image js-prod-view" href="javascript:void(0)">
                                <i class="i view-list_active"></i>
                            </a>
                        </div>
                    </div>
                </div>

        <div class="default"> 
        <?
        $APPLICATION->IncludeComponent(
          "bitrix:catalog.section",
          "",
          Array(
            "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
            "IBLOCK_ID" => $arParams["IBLOCK_ID"],
            "ELEMENT_SORT_FIELD" => $sortBy,
            "ELEMENT_SORT_ORDER" => $orderBy,
            "PROPERTY_CODE" => $arParams["LIST_PROPERTY_CODE"],
            "META_KEYWORDS" => $arParams["LIST_META_KEYWORDS"],
            "META_DESCRIPTION" => $arParams["LIST_META_DESCRIPTION"],
            "BROWSER_TITLE" => $arParams["LIST_BROWSER_TITLE"],
            "INCLUDE_SUBSECTIONS" => $arParams["INCLUDE_SUBSECTIONS"],
            "BASKET_URL" => $arParams["BASKET_URL"],
            "ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
            "PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
            "SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
            "FILTER_NAME" => $arParams["FILTER_NAME"],
            "DISPLAY_PANEL" => $arParams["DISPLAY_PANEL"],
            "CACHE_TYPE" => $arParams["CACHE_TYPE"],
            "CACHE_TIME" => $arParams["CACHE_TIME"],
            "CACHE_FILTER" => $arParams["CACHE_FILTER"],
            "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
            "SET_TITLE" => $arParams["SET_TITLE"],
            "SET_STATUS_404" => $arParams["SET_STATUS_404"],
            "DISPLAY_COMPARE" => $arParams["USE_COMPARE"],
            "PAGE_ELEMENT_COUNT" => $pageElementCount,
            "LINE_ELEMENT_COUNT" => $arParams["LINE_ELEMENT_COUNT"],
            "PRICE_CODE" => $arParams["PRICE_CODE"],
            "USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
            "SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],

            "PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],

            "DISPLAY_TOP_PAGER" => $arParams["DISPLAY_TOP_PAGER"],
            "DISPLAY_BOTTOM_PAGER" => $arParams["DISPLAY_BOTTOM_PAGER"],
            "PAGER_TITLE" => $arParams["PAGER_TITLE"],
            "PAGER_SHOW_ALWAYS" => $arParams["PAGER_SHOW_ALWAYS"],
            "PAGER_TEMPLATE" => $arParams["PAGER_TEMPLATE"],
            "PAGER_DESC_NUMBERING" => $arParams["PAGER_DESC_NUMBERING"],
            "PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
            "PAGER_SHOW_ALL" => $arParams["PAGER_SHOW_ALL"],

            "OFFERS_CART_PROPERTIES" => $arParams["OFFERS_CART_PROPERTIES"],
            "OFFERS_FIELD_CODE" => $arParams["LIST_OFFERS_FIELD_CODE"],
            "OFFERS_PROPERTY_CODE" => $arParams["LIST_OFFERS_PROPERTY_CODE"],
            "OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
            "OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
            "OFFERS_LIMIT" => $arParams["LIST_OFFERS_LIMIT"],

            "SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
            "SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
            "SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
            "DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["element"],
          ),
          $component
        );

        ?>
        </div>

        <div class="list" style="display:none;">
                
            <?
            $APPLICATION->IncludeComponent(
              "bitrix:catalog.section",
              "list",
              Array(
                "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
                "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                "ELEMENT_SORT_FIELD" => $sortBy,
                "ELEMENT_SORT_ORDER" => $orderBy,
                "PROPERTY_CODE" => $arParams["LIST_PROPERTY_CODE"],
                "META_KEYWORDS" => $arParams["LIST_META_KEYWORDS"],
                "META_DESCRIPTION" => $arParams["LIST_META_DESCRIPTION"],
                "BROWSER_TITLE" => $arParams["LIST_BROWSER_TITLE"],
                "INCLUDE_SUBSECTIONS" => $arParams["INCLUDE_SUBSECTIONS"],
                "BASKET_URL" => $arParams["BASKET_URL"],
                "ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
                "PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
                "SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
                "FILTER_NAME" => $arParams["FILTER_NAME"],
                "DISPLAY_PANEL" => $arParams["DISPLAY_PANEL"],
                "CACHE_TYPE" => $arParams["CACHE_TYPE"],
                "CACHE_TIME" => $arParams["CACHE_TIME"],
                "CACHE_FILTER" => $arParams["CACHE_FILTER"],
                "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
                "SET_TITLE" => $arParams["SET_TITLE"],
                "SET_STATUS_404" => $arParams["SET_STATUS_404"],
                "DISPLAY_COMPARE" => $arParams["USE_COMPARE"],
                "PAGE_ELEMENT_COUNT" => $pageElementCount,
                "LINE_ELEMENT_COUNT" => $arParams["LINE_ELEMENT_COUNT"],
                "PRICE_CODE" => $arParams["PRICE_CODE"],
                "USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
                "SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],

                "PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],

                "DISPLAY_TOP_PAGER" => $arParams["DISPLAY_TOP_PAGER"],
                "DISPLAY_BOTTOM_PAGER" => $arParams["DISPLAY_BOTTOM_PAGER"],
                "PAGER_TITLE" => $arParams["PAGER_TITLE"],
                "PAGER_SHOW_ALWAYS" => $arParams["PAGER_SHOW_ALWAYS"],
                "PAGER_TEMPLATE" => $arParams["PAGER_TEMPLATE"],
                "PAGER_DESC_NUMBERING" => $arParams["PAGER_DESC_NUMBERING"],
                "PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
                "PAGER_SHOW_ALL" => $arParams["PAGER_SHOW_ALL"],

                "OFFERS_CART_PROPERTIES" => $arParams["OFFERS_CART_PROPERTIES"],
                "OFFERS_FIELD_CODE" => $arParams["LIST_OFFERS_FIELD_CODE"],
                "OFFERS_PROPERTY_CODE" => $arParams["LIST_OFFERS_PROPERTY_CODE"],
                "OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
                "OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
                "OFFERS_LIMIT" => $arParams["LIST_OFFERS_LIMIT"],

                "SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
                "SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
                "SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
                "DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["element"],
              ),
              $component
            );

            ?>

        </div>

          </div>
        </div>
    </div>
</div>


<script type="text/javascript">

$('#spisok').click(function(e){
    $('.list').show();
    $('.default').hide();
});   


$('#plitka').click(function(e){
  $('.default').show();
  $('.list').hide();
});




</script>