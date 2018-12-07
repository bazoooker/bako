<div class="data section-padding">
<div class="container">

<h1>Регистрация</h1>

<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>

<?
if ($_REQUEST['mes']=='yes') {
?>

<div class="user-notice">
<?
	ShowMessage($arParams["~AUTH_RESULT"]);
?>
</div>

<?
}
?>

<?if($arResult["USE_EMAIL_CONFIRMATION"] === "Y" && is_array($arParams["AUTH_RESULT"]) &&  $arParams["AUTH_RESULT"]["TYPE"] === "OK"):?>
	<div class="user-table-title"><?echo GetMessage("AUTH_EMAIL_SENT")?></div>
<?else:?>

<?if($arResult["USE_EMAIL_CONFIRMATION"] === "Y"):?>
	<div class="user-table-title"><?echo GetMessage("AUTH_EMAIL_WILL_BE_SENT")?></div>
<?endif?>

<form method="post" action="<?=$arResult["AUTH_URL"]?>&mes=yes" name="bform">
<?
if (strlen($arResult["BACKURL"]) > 0)
{
?>
	<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
<?
}
?>
	<input type="hidden" name="AUTH_FORM" value="Y" />
	<input type="hidden" name="TYPE" value="REGISTRATION" />
<table class="form-table user-table">
	<tbody>
		<tr>
			<td class="legend user-table-label"><?=GetMessage("AUTH_NAME")?></td>
			<td><input type="text" name="USER_NAME" maxlength="50" value="<?=$arResult["USER_NAME"]?>" /></td>
		</tr>
		<tr>
			<td class="legend user-table-label"><?=GetMessage("AUTH_LAST_NAME")?></td>
			<td><input type="text" name="USER_LAST_NAME" maxlength="50" value="<?=$arResult["USER_LAST_NAME"]?>" /></td>
		</tr>
		<tr>
			<td  class="legend user-table-label"><?=GetMessage("AUTH_EMAIL")?><?if($arResult["EMAIL_REQUIRED"]):?><span class="starrequired">*</span><?endif?></td>
			<td><input type="text" name="USER_EMAIL" maxlength="255" value="<?=$arResult["USER_EMAIL"]?>" onKeyDown="$('#logintr').find('input').val($(this).val())"/></td>
		</tr>
		<tr style="display:none" id="logintr">
			<td class="legend user-table-label"><span class="starrequired">*</span><?=GetMessage("AUTH_LOGIN_MIN")?></td>
			<td><input type="text" name="USER_LOGIN" maxlength="50" value="<?=$arResult["USER_LOGIN"]?>" /></td>
		</tr>
		<tr>
			<td class="legend user-table-label"><?=GetMessage("AUTH_PASSWORD_REQ")?><span class="starrequired">*</span></td>
			<td>
				<input type="password" name="USER_PASSWORD" maxlength="50" value="<?=$arResult["USER_PASSWORD"]?>" autocomplete="off" />
				<div class="user-table-note password-note"><?echo $arResult["GROUP_POLICY"]["PASSWORD_REQUIREMENTS"];?></div>
			</td>
		</tr>
		<tr>
			<td class="legend user-table-label"><?=GetMessage("AUTH_CONFIRM")?><span class="starrequired">*</span></td>
			<td><input type="password" name="USER_CONFIRM_PASSWORD" maxlength="50" value="<?=$arResult["USER_CONFIRM_PASSWORD"]?>" autocomplete="off" /></td>
		</tr>


<!-- 		<tr>
			<td class="legend user-table-label">Ваш телефон<span class="starrequired">*</span></td>
			<td><input id="PERSONAL_PHONE" type="text" name="UF_PHONE" maxlength="50" value="<?=$arResult["PERSONAL_PHONE"]?>" autocomplete="off" placeholder="+7 (___) ___-____"/></td>
		</tr> -->


<? 

	/* CAPTCHA */
	if ($arResult["USE_CAPTCHA"] == "Y")
	{
		?>
		<tr>
			<td colspan="2"><div class="user-table-title"><?=GetMessage("CAPTCHA_REGF_TITLE")?></div></td>
		</tr>
		<tr>
			<td></td>
			<td>
				<input type="hidden" name="captcha_sid" value="<?=$arResult["CAPTCHA_CODE"]?>" />
				<img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["CAPTCHA_CODE"]?>" width="180" height="40" alt="CAPTCHA" />
			</td>
		</tr>
		<tr>
			<td class="legend user-table-label"><?=GetMessage("CAPTCHA_REGF_PROMT")?>:<span class="starrequired">*</span></td>
			<td><input type="text" name="captcha_word" maxlength="50" value="" /></td>
		</tr>
		<?
	}
	/* CAPTCHA */
	?>
		<tr>
			<td></td>
			<td><input class="btn btn_main" type="submit" name="Register" value="<?=GetMessage("AUTH_REGISTER")?>" /></td>
		</tr>
</table>

<div class="user-table-note field-note"><span class="starrequired">*</span> <?=GetMessage("AUTH_REQ")?></div>

<!-- p>
<a href="<?=$arResult["AUTH_AUTH_URL"]?>" rel="nofollow"><b><?=GetMessage("AUTH_AUTH")?></b></a>
</p -->

</form>


<?endif?>


</div>
</div>