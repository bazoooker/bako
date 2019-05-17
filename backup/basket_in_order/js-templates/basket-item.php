<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

/**
 * @var array $mobileColumns
 * @var array $arParams
 * @var string $templateFolder
 */

$usePriceInAdditionalColumn = in_array('PRICE', $arParams['COLUMNS_LIST']) && $arParams['PRICE_DISPLAY_MODE'] === 'Y';
$useSumColumn = in_array('SUM', $arParams['COLUMNS_LIST']);
$useActionColumn = in_array('DELETE', $arParams['COLUMNS_LIST']);

$restoreColSpan = 2 + $usePriceInAdditionalColumn + $useSumColumn + $useActionColumn;

$positionClassMap = array(
	'left' => 'basket-item-label-left',
	'center' => 'basket-item-label-center',
	'right' => 'basket-item-label-right',
	'bottom' => 'basket-item-label-bottom',
	'middle' => 'basket-item-label-middle',
	'top' => 'basket-item-label-top'
);

$discountPositionClass = '';
if ($arParams['SHOW_DISCOUNT_PERCENT'] === 'Y' && !empty($arParams['DISCOUNT_PERCENT_POSITION']))
{
	foreach (explode('-', $arParams['DISCOUNT_PERCENT_POSITION']) as $pos)
	{
		$discountPositionClass .= isset($positionClassMap[$pos]) ? ' '.$positionClassMap[$pos] : '';
	}
}

$labelPositionClass = '';
if (!empty($arParams['LABEL_PROP_POSITION']))
{
	foreach (explode('-', $arParams['LABEL_PROP_POSITION']) as $pos)
	{
		$labelPositionClass .= isset($positionClassMap[$pos]) ? ' '.$positionClassMap[$pos] : '';
	}
}

?>
<script id="basket-item-template" type="text/html">

	<div class="product-full" id="basket-item-{{ID}}" data-entity="basket-item" data-id="{{ID}}">               
        <a href="{{DETAIL_PAGE_URL}}" class="product-full__img" style="background-image: url({{{IMAGE_URL}}}{{^IMAGE_URL}}/img/no-photo.png{{/IMAGE_URL}});"></a>

        <div class="product-full__info">
            <a class="product-full__name" href="{{DETAIL_PAGE_URL}}">
                {{NAME}}
            </a>

            <div class="product-full__controls">
                <div class="product-controls-horiz" data-entity="basket-item-quantity-block">
                    <span class="product-controls-horiz__arrow-left " data-entity="basket-item-quantity-minus">
                        <i class="i i-caret_up"></i>
                    </span>
                    <input type="text" class="product-controls-horiz__quant" value="{{QUANTITY}}"
    				{{#NOT_AVAILABLE}} disabled="disabled"{{/NOT_AVAILABLE}}
    				data-value="{{QUANTITY}}" data-entity="basket-item-quantity-field"
    				id="basket-item-quantity-{{ID}}">
                    <!-- <input id="" type="text" name="quantity" class="product-controls-horiz__quant" value="77"> -->

                    <span class="product-controls-horiz__arrow-right" data-entity="basket-item-quantity-plus">
                        <i class="i i-caret_down"></i>    
                    </span>
                </div>
                
            </div>
        </div>
        <span class="product-full__price" id="basket-item-sum-price-{{ID}}">{{{SUM_PRICE_FORMATED}}}</span>&nbsp;

        <span class="basket-item-actions-remove" data-entity="basket-item-delete" onclick="delInCart({{ID}})"></span>
    </div>

	
</script>