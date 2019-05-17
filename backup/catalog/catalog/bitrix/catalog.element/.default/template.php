<?
use \Bitrix\Main;
use \Bitrix\Catalog\CatalogViewedProductTable as CatalogViewedProductTable;
use \Bitrix\Main\Text\String as StringStr;
use \Bitrix\Main\Localization\Loc as Loc;
use \Bitrix\Main\SystemException as SystemException;

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?
//���������, ���� �� ������ ����� � ����������
$curProductId = $arResult['ID'];
$itInDelay = [];
$dbBasketItems = CSaleBasket::GetList(
    array(
        "NAME" => "ASC",
        "ID" => "ASC"
    ),
    array(
        "FUSER_ID" => CSaleBasket::GetBasketUserID(),
        "LID" => SITE_ID,
        "PRODUCT_ID" => $curProductId,
        "ORDER_ID" => "NULL",
        "DELAY" => "Y"
    ),
    false,
    false,
    array("PRODUCT_ID")
);
while ($arItems = $dbBasketItems->Fetch())
{
    $itInDelay = $arItems['PRODUCT_ID'];
}
?>

<?//print_r($itInDelay)?>

<?
// ��� ���������� ������ � �������������
global $APPLICATION;
   global $USER;

$user_id = CSaleBasket::GetBasketUserID();
    if($user_id  > 0)
   {
      $product_id = $arResult['ID'];
      CatalogViewedProductTable::refresh($product_id, $user_id);
   }
?>


        <!-- PAGE CONTENT BEGIN -->            
        <main class="content" role="main">







<div class="container">
    <div class="breadcrumbs">
        
        <!-- ������ ������ ������ �� ��������. � ��������� ������ ������� ��������� � css -->



        <!-- ���� ������� -->
        <a href="/" title="�������" class="breadcrumbs__item">
            �������
        </a>
        <i class="breadcrumb__arrow">
            <span class="i i-breadcrumb-arrow"></span>
        </i>
        <!-- ���� ������� ����� -->
<?
$resSection = CIBlockSection::GetNavChain(false, $arResult["IBLOCK_SECTION_ID"]);

while($arSectionPath = $resSection->GetNext()){?>

 	<?if ($arSectionPath['DEPTH_LEVEL']  == '1') continue?>
        <!-- ���� ������� -->
        <?=$arSectionPath['SECTION_PAGE_URL'];?>
        <a href="/catalog/<?=$arSectionPath['ID']?>/" title="��������������" class="breadcrumbs__item">
            <? $str2 = substr($arSectionPath['NAME'], 5); ?>
            <?=$str2;?>
        </a>
        <i class="breadcrumb__arrow">
            <span class="i i-breadcrumb-arrow"></span>
        </i>
        <!-- ���� ������� ����� -->

<?} ?>


    </div>
</div>







<div class="bg-texture">
    <div class="container mb-80">
        <h1><?=$arResult["NAME"]?></h2>

<?


$ar_res = CCatalogProduct::GetByID($arResult['ID']);

if(is_array($arResult["PREVIEW_PICTURE"])){
    $path = $arResult["PREVIEW_PICTURE"]["SRC"];
}elseif(is_array($arResult["DETAIL_PICTURE"])){
    $path = $arResult["DETAIL_PICTURE"]["SRC"];
}else{
    $path = "/img/no-photo.png";
}
?>

        <div class="product">
            <div class="row">
                <div class="col-4">
                    <div class="product__img">
                        <div class="product__img-inner" style="background-image: url(<?=$path?>);"></div>

                        <? if($arResult['PROPERTIES']['NOVYY_TOVAR']['VALUE'] == ''): ?>
		    				<div class="product-thumb__badge product-thumb__badge_new">�������</div></br>
						<?endif;?>
						<? if($arResult['PROPERTIES']['TOVAR_PO_AKTSII']['VALUE'] == ''): ?>
		    				<div class="product-thumb__badge product-thumb__badge_sale">����������</div>
						<?endif?>
                       
                    </div>


                </div>
                <div class="col-4">
                    <div class="product__main-features">
                        <ul>
                            <?$cou = 0;?>
                        <?foreach($arResult["DISPLAY_PROPERTIES"] as $pid=>$arProperty):?>
                            <?if ($cou == 6) break;?>
                            <li><span><?=$arProperty["NAME"]?>:</span>&nbsp;<b><?
                            if(is_array($arProperty["DISPLAY_VALUE"])):
                                echo implode("&nbsp;/&nbsp;", $arProperty["DISPLAY_VALUE"]);
                            elseif($pid=="MANUAL"):
                                ?><a href="<?=$arProperty["VALUE"]?>"><?=GetMessage("CATALOG_DOWNLOAD")?></a><?
                            else:?>
                                <?=$arProperty["DISPLAY_VALUE"];?></b></li>
                            <?endif?></b>
                            <?$cou++;?>
                        <?endforeach?>
                        
                        </ul>
                        
                        <div id="favorites">                    
                            <?if (!empty($itInDelay)):?>
                                <a href="javascript:void(0)" class="clean_wishlist btn btn_size-m btn_outline" 
                                    onclick="del_in_wish(
                                        '<?=$arResult["ID"]?>',
                                        '<?=$arResult["CATALOG_PRICE_ID_1"]?>',
                                        '<?=$arResult["CATALOG_PRICE_1"]?>',
                                        '<?=$arResult["NAME"]?>',
                                        '<?=$arResult["DETAIL_PAGE_URL"]?>',
                                        this);">
                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                        ������� �� ����������
                                </a>
                            <?else:?>
                                <a href="javascript:void(0)"  class="wishbtn btn btn_size-m btn_outline"
                                    onclick="add2wish(
                                        '<?=$arResult["ID"]?>',
                                        '<?=$arResult["CATALOG_PRICE_ID_1"]?>',
                                        '<?=$arResult["CATALOG_PRICE_1"]?>',
                                        '<?=$arResult["NAME"]?>',
                                        '<?=$arResult["DETAIL_PAGE_URL"]?>',
                                        this);">
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        �������� � ���������
                                </a>
                            <?endif;?>
                        </div>  

                        <!-- <?if($arResult["DETAIL_TEXT"] != ''):?>
                            <a href="#all-features"><i class="fa fa-list-ul" aria-hidden="true"></i>&nbsp;&nbsp;��� �������������� ������</a>
                        <?endif;?>   -->                  




                    </div>
                </div>
                <div class="col-4">
                    <div class="product__call-to-action">
                        <footer class="product-thumb__footer">
                            <div class="product-thumb__avail-price">




                                <div class="product-thumb__avail">
                                    <span>� �������:</span>
                                    <b><?=$ar_res["QUANTITY"]?></b>
                                </div>
<!-- 13 ����������� ���� ��������� ����������� -->
				<?foreach($arResult["PRICES"] as $code=>$arPrice):?>
					<?if($arPrice["CAN_ACCESS"]):?>

                                <div class="product-thumb__price">
                                    <?=$arPrice["DISCOUNT_VALUE"]?> &#8381;
                                </div>

					<?endif;?>
				<?endforeach;?>
                            </div>
                            <div class="product-thumb__controls">
                                <div class="product-controls">
                                    <div id="QUANTITY_PRODUCT_<?=$arResult['ID']?>" class="product-controls__quant">1</div>
                                    <div class="product-controls__arrows">
                                        <span class="product-controls__arrow-up" onclick="Quantity(<?=$arResult['ID']?>, 1, 'up', 1);">
                                            <i class="i i-caret_up"></i>
                                        </span>
                                        <span class="product-controls__arrow-down" onclick="Quantity(<?=$arResult['ID']?>, 1, 'down', 1);">
                                            <i class="i i-caret_down"></i>    
                                        </span>
                                    </div>
                
                                    
                                    <div id="<?=$arResult['ID']?>" class="product-controls__btn btn_add-to-cart js-show-cart-msge">� �������</div>
                                </div>
                            </div>
                        </footer>

                    </div>



					<div class="product__address">
                        <img src="/img/icons/i-pin_big.png" alt="">
                        <p>
                            ���������� ����� ��� ������� ���� ����� �� ������ �� ������: �������, ��. ��������� 7
                        </p>
                    </div>
                </div>
            </div>
        </div>











    <?//if($arResult["DETAIL_TEXT"] != ''):?>
        <div id="all-features" class="product-lead">
            <h2 class="text-left js-fancy-heading">
                �������������� ������
            </h2>

            <div class="row">
                
                <?$column = ceil(count($arResult["DISPLAY_PROPERTIES"])/3);?>
                <?$iter = 0;?>
            	
                 <div class="col-4">

                    <?foreach($arResult["DISPLAY_PROPERTIES"] as $pid=>$arProperty):?>

                        <?if ($iter == $column):?>
                            <?$iter=0;?>
                            </div> 
                            <div class="col-4">
                        <?endif;?>           
                        <div class="product-feature">
                            <span class="product-feature__name"><?=$arProperty["NAME"]?></span>
                            <span class="product-feature__separator"></span>
                            <span class="product-feature__value">
                                <?if(is_array($arProperty["DISPLAY_VALUE"])):
                                    echo implode("&nbsp;/&nbsp;", $arProperty["DISPLAY_VALUE"]);?>
                                <?else:?>
                                    <?=$arProperty["DISPLAY_VALUE"];?>
                                <?endif;?>
                                    
                            </span>
                        </div>  
                        <?$iter++;?>                  
                    <?endforeach;?>

                </div>

            </div>
        </div>
    <?//endif;?>

  

