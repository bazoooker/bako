<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
        <!-- ���� � �������� ������ -->
            <div class="col-3 filters">
                <aside class="filters__inner">
					<span class="filters__close js-show-filters"></span>


<form name="<?echo $arResult["FILTER_NAME"]."_form"?>" action="<?echo $arResult["FORM_ACTION"]?>" method="get">
	<?foreach($arResult["ITEMS"] as $arItem):
		if(array_key_exists("HIDDEN", $arItem)):
			echo $arItem["INPUT"];
		endif;
	endforeach;?>






		<?foreach($arResult["ITEMS"] as $arItem):?>
			<?if(!array_key_exists("HIDDEN", $arItem)):?>
				<h5><?=$arItem["NAME"]?></h5>
				<?=$arItem["INPUT"]?>
			<?endif?>
		<?endforeach;?>





<input class="btn btn_main btn_size-l full-width text-center" name="set_filter" value="���������"/>
<input type="hidden" name="set_filter" value="Y" />
<input class="btn btn_secondary btn_size-l full-width text-center" type="submit" name="del_filter" value="�������� ������" />

                    <!-- <a href="#" class="btn btn_secondary btn_size-l full-width text-center">�������� ������</a>

				<input type="submit" name="set_filter" value="<?=GetMessage("IBLOCK_SET_FILTER")?>" /> -->
				

</form>

                </aside>
            </div>
    <!-- ����� ���� � �������� -->
