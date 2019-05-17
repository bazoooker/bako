<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
if(count($arResult["PERSON_TYPE"]) > 1)
{
	?>
<?
// при регистрации мы устанавливаем тип пользователя - физ или юрлицо
// теперь мы должны сразу подставить тип плательщика
// на другом проекте будут другие идшники!!!!!!!!!!!!!!!

global $USER;
if ($USER->IsAuthorized()){

	$arFilter = array("ID" => $USER->GetID());
	$arParams["SELECT"] = array( "UF_*" );
	$arRes = CUser::GetList(($by=""), ($order=""),$arFilter,$arParams);
	$arUser = $arRes->Fetch();
	if($arUser['UF_TYPE']==4) {
?>
<script>
$(document).ready(function(){
	$('.authorizedtype, #sale_order_props, .profile_list').hide();
	$('.loading').show();
	$('select[name=PERSON_TYPE]').val('1');submitForm();
});
</script>
<?
	}
	if($arUser['UF_TYPE']==5) {
?>
<script>
$(document).ready(function(){
	$('.loading').show();
	$('.authorizedtype, #sale_order_props, .profile_list').hide();
	$('select[name=PERSON_TYPE]').val('2');submitForm();
});
</script>
<?
	}
}
?>
    <div class="customer_type">
        <h2 class="customer_title"><?=GetMessage("SOA_CUSTOMER_TITLE")?></h2>
        <div style="clear:  both;"></div>
    </div>
<?
if ($USER->IsAuthorized()){
?>
<div class=loading></div>
<?
}
?>
    	<div class="type authorizedtype <?=($USER->IsAuthorized())?"authorizedtype":""?>">
	<DIV CLASS="bx_block r1x3 pt8">
		Тип покупателя
	</DIV>
	<div class="bx_block r3x1">
            <select id="PERSON_TYPE_<?= $v["ID"] ?>" name="PERSON_TYPE" onChange="submitForm()">
        		<?foreach($arResult["PERSON_TYPE"] as $v):?>
                    <option value="<?= $v["ID"] ?>" <?if ($v["CHECKED"]=="Y") echo " selected=\"selected\"";?>><?= $v["NAME"] ?></option>
        		<?endforeach;?>
            </select>
    		<input type="hidden" name="PERSON_TYPE_OLD" value="<?=$arResult["USER_VALS"]["PERSON_TYPE_ID"]?>" />
    	</div>
	</div>
	<?
}
else
{
	if(IntVal($arResult["USER_VALS"]["PERSON_TYPE_ID"]) > 0)
	{
		//for IE 8, problems with input hidden after ajax
		?>
		<span style="display:none;">
		<input type="text" name="PERSON_TYPE" value="<?=IntVal($arResult["USER_VALS"]["PERSON_TYPE_ID"])?>" />
		<input type="text" name="PERSON_TYPE_OLD" value="<?=IntVal($arResult["USER_VALS"]["PERSON_TYPE_ID"])?>" />
		</span>
		<?
	}
	else
	{
		foreach($arResult["PERSON_TYPE"] as $v)
		{
			?>
			<input type="hidden" id="PERSON_TYPE" name="PERSON_TYPE" value="<?=$v["ID"]?>" />
			<input type="hidden" name="PERSON_TYPE_OLD" value="<?=$v["ID"]?>" />
			<?
		}
	}
}
?>