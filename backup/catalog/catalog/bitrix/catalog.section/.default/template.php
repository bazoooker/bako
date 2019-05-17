<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?//print_r($_SESSION['SORT_NAME'])?>


    <div class="row">




		<?foreach($arResult["ITEMS"] as $cell=>$arElement):?>
		<?
		$this->AddEditAction($arElement['ID'], $arElement['EDIT_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT"));
		$this->AddDeleteAction($arElement['ID'], $arElement['DELETE_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BCS_ELEMENT_DELETE_CONFIRM')));
		?>

        <?
        //Проверяем, есть ли данный товар в отложенных
        $curProductId = $arElement['ID'];
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
        while ($arItemsFav = $dbBasketItems->Fetch())
        {
            $itInDelay = $arItemsFav['PRODUCT_ID'];
        }
        ?>	
<?	
// количество товара
//$ar_res = CCatalogProduct::GetByID($arElement['ID']);

?>
		<div class="col-4">
			<!-- <a href="<?=$arElement["DETAIL_PAGE_URL"]?>" class="product-thumb"> -->
            <div class="product-thumb <?if (!empty($itInDelay)) echo ' product-thumb_in-fav'?>">

				<span id="wish_<?=$arElement["ID"]?>" class="product-thumb__fav js-show-pop-up-message" 
                    <?if (!empty($itInDelay)):?>
                            onclick="del_in_wish(
                                '<?=$arElement["ID"]?>',
                                '<?=$arElement["CATALOG_PRICE_ID_1"]?>',
                                '<?=$arElement["CATALOG_PRICE_1"]?>',
                                '<?=$arElement["NAME"]?>',
                                '<?=$arElement["DETAIL_PAGE_URL"]?>',
                                this);"
                    <?else:?>
                            onclick="add2wish(
                                '<?=$arElement["ID"]?>',
                                '<?=$arElement["CATALOG_PRICE_ID_1"]?>',
                                '<?=$arElement["CATALOG_PRICE_1"]?>',
                                '<?=$arElement["NAME"]?>',
                                '<?=$arElement["DETAIL_PAGE_URL"]?>',
                                this);"
                    <?endif;?>
                    data-target-message="fav-controls">
                    <i class="fa fa-star" aria-hidden="true"></i>            
                </span>
                    <div class="product-thumb__body">
                        <?
                        if(is_array($arElement["PREVIEW_PICTURE"])){
                            $path = $arElement["PREVIEW_PICTURE"]["SRC"];
                        }elseif(is_array($arElement["DETAIL_PICTURE"])){
                            $path = $arElement["DETAIL_PICTURE"]["SRC"];
                        }else{
                            $path = "/img/no-photo.png";
                        }?>
                        
                        <a href="<?=$arElement["DETAIL_PAGE_URL"]?>" class="product-thumb__img" style="background-image: url(<?=$path?>);"></a>
                            <a href="<?=$arElement["DETAIL_PAGE_URL"]?>" class="product-thumb__name"><?=$arElement["NAME"]?></a>
                                <span class="product-thumb__articul">Артикул: 
                                   <?if ($arElement['PROPERTIES']['CML2_ARTICLE']['VALUE'] != ''):?>
                                        <b><?=$arElement['PROPERTIES']['CML2_ARTICLE']['VALUE']?></b>
                            	   <?endif;?>
                                </span>
                    </div>
            <!-- </a> -->

			                <footer class="product-thumb__footer">
                                <div class="product-thumb__avail-price">
                                    <div class="product-thumb__avail">
                                        <span>В наличии:</span>
                                        <b><?=$arElement["CATALOG_QUANTITY"]?></b>
                                    </div>
<!-- 13 минимальная цена торгового предложения -->
				            <?foreach($arElement["PRICES"] as $code=>$arPrice):?>
					           <?if($arPrice["CAN_ACCESS"]):?>

									<div class="product-thumb__price">
                                        <?=$arPrice["VALUE"]?> &#8381;
                                    </div>

					           <?endif;?>
				            <?endforeach;?>                                    

                                </div>
                                <div class="product-thumb__controls">
                                    <div class="product-controls">
                                        <div class="product-controls__quant" id="QUANTITY_PRODUCT_<?=$arElement['ID']?>">1</div>
                                        <div class="product-controls__arrows">
                                            <span class="product-controls__arrow-up" onclick="Quantity(<?=$arElement['ID']?>, 1, 'up', 1);">
                                                <i class="i i-caret_up"></i>
                                            </span>
                                            <span class="product-controls__arrow-down" onclick="Quantity(<?=$arElement['ID']?>, 1, 'down', 1);">
                                                <i class="i i-caret_down"></i>    
                                            </span>
                                        </div>
                                        <!-- <noindex>
<a href="<?echo $arOffer["ADD_URL"]?>" rel="nofollow">В корзину</a>						
										</noindex> -->

                                        <div id="<?=$arElement['ID']?>" class="product-controls__btn btn_add-to-cart js-show-cart-msge">в корзину</div>
                                    </div>
                                </div>
                            </footer>

            		<? if($arElement['PROPERTIES']['NOVYY_TOVAR']['VALUE'] == ''): ?>
            			<div class="product-thumb__badge product-thumb__badge_new">Новинка</div></br>
        			<?endif?>
        			<? if($arElement['PROPERTIES']['TOVAR_PO_AKTSII']['VALUE'] == ''): ?>
            			<div class="product-thumb__badge product-thumb__badge_sale">распродажа</div>
        			<?endif?>


    				<?if($arParams["DISPLAY_COMPARE"]):?>
    					<noindex>
    					<a href="<?echo $arElement["COMPARE_URL"]?>" rel="nofollow"><?echo GetMessage("CATALOG_COMPARE")?></a>
    					</noindex>
    				<?endif?>

			</div><!--product-thumb-->
		</div>

		
		<?endforeach; // foreach($arResult["ITEMS"] as $arElement):?>




    </div><!-- .row -->
<!-- 
            </div> -->



<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
	<br /><?=$arResult["NAV_STRING"]?>
<?endif;?>



