<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
/** @var CBitrixComponentTemplate $this */
/** @var array $arParams */
/** @var array $arResult */
use Bitrix\Main;


//echo '<pre>'; print_r($arResult); echo '</pre>';

// foreach ($arResult['GRID']['ROWS'] as $key => $it) {
// 	//echo '<pre>';print_r($it);echo '</pre>';
// 	echo $key;
// 	if($it['[DELAY]'] == 'Y'){
// 		unset($arResult['GRID']['ROWS'][$key]);
// 	}
// }

$arResult['ShowDelay'] = 'N'; // не показывать отложеные / избранные

$defaultParams = array(
	'TEMPLATE_THEME' => 'blue'
);
$arParams = array_merge($defaultParams, $arParams);
unset($defaultParams);

$arParams['TEMPLATE_THEME'] = (string)($arParams['TEMPLATE_THEME']);
if ('' != $arParams['TEMPLATE_THEME'])
{
	$arParams['TEMPLATE_THEME'] = preg_replace('/[^a-zA-Z0-9_\-\(\)\!]/', '', $arParams['TEMPLATE_THEME']);
	if ('site' == $arParams['TEMPLATE_THEME'])
	{
		$templateId = (string)Main\Config\Option::get('main', 'wizard_template_id', 'eshop_bootstrap', SITE_ID);
		$templateId = (preg_match("/^eshop_adapt/", $templateId)) ? 'eshop_adapt' : $templateId;
		$arParams['TEMPLATE_THEME'] = (string)Main\Config\Option::get('main', 'wizard_'.$templateId.'_theme_id', 'blue', SITE_ID);
	}
	if ('' != $arParams['TEMPLATE_THEME'])
	{
		if (!is_file($_SERVER['DOCUMENT_ROOT'].$this->GetFolder().'/themes/'.$arParams['TEMPLATE_THEME'].'/style.css'))
			$arParams['TEMPLATE_THEME'] = '';
	}
}
if ('' == $arParams['TEMPLATE_THEME'])
	$arParams['TEMPLATE_THEME'] = 'blue';


/***** Не показывать в корзине отложеные товары *********/
foreach ($arResult['GRID']['ROWS'] as $key => $value) {
	if($value['DELAY'] == 'Y'){
		unset($arResult['GRID']['ROWS'][$key]);
	}
}

foreach ($arResult['BASKET_ITEM_RENDER_DATA'] as $key => $value) {
	if ($value['DELAYED']){
		unset($arResult['BASKET_ITEM_RENDER_DATA'][$key]);
	}
}
/*****************************************************/