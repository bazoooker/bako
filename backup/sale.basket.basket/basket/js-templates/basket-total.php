<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

/**
 * @var array $arParams
 */
?>
<script id="basket-total-template" type="text/html">

            <footer class="basket__footer" data-entity="basket-checkout-aligner" style="padding: 40px 176px 38px 40px;">
               <button class="btn btn_main btn_size-l basket__btn" data-entity="basket-checkout-button">
						<?=Loc::getMessage('SBB_ORDER')?>
				</button>
               <div class="basket__total">
                   <span class="basket__note">Итого товаров <?= count ($arBasketItems) ?> на сумму</span>
                   <span class="basket__sum" data-entity="basket-total-price">{{{PRICE_FORMATED}}}</span>
               </div>
            </footer>

</script>