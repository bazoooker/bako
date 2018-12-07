<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>


<div class="data">
<h1>Восстановление пароля</h1>
<p><br></p>
<div class="user-notice">
<?
ShowMessage($arParams["~AUTH_RESULT"]);
?>
</div>
<div class="bx-auth">
<!--
<div class="user-table-title"><?=GetMessage("AUTH_CHANGE_PASSWORD")?></div>
-->
<form method="post" action="<?=$arResult["AUTH_FORM"]?>" name="bform">
	<?if (strlen($arResult["BACKURL"]) > 0): ?>
	<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
	<? endif ?>
	<input type="hidden" name="AUTH_FORM" value="Y">
	<input type="hidden" name="TYPE" value="CHANGE_PWD">
	<table class="data-table bx-changepass-table user-table">
		<thead>
			<tr></tr>
		</thead>
		<tbody>
			<tr>
				<td class="user-table-label"><?=GetMessage("AUTH_LOGIN")?><span class="starrequired">*</span></td>
				<td><input type="text" name="USER_LOGIN" maxlength="50" value="<?=$arResult["LAST_LOGIN"]?>" class="bx-auth-input" /></td>
			</tr>
			<tr>
				<td class="user-table-label"><?=GetMessage("AUTH_CHECKWORD")?><span class="starrequired">*</span></td>
				<td><input type="text" name="USER_CHECKWORD" maxlength="50" value="<?=$arResult["USER_CHECKWORD"]?>" class="bx-auth-input" /></td>
			</tr>
			<tr>
				<td class="user-table-label"><?=GetMessage("AUTH_NEW_PASSWORD_REQ")?><span class="starrequired">*</span></td>
				<td>
					<input type="password" name="USER_PASSWORD" maxlength="50" value="<?=$arResult["USER_PASSWORD"]?>" class="bx-auth-input" autocomplete="off" />
					<div class="user-table-note password-note"><?echo $arResult["GROUP_POLICY"]["PASSWORD_REQUIREMENTS"];?></div>
<?if($arResult["SECURE_AUTH"]):?>
				<span class="bx-auth-secure" id="bx_auth_secure" title="<?echo GetMessage("AUTH_SECURE_NOTE")?>" style="display:none">
					<div class="bx-auth-secure-icon"></div>
				</span>
				<noscript>
				<span class="bx-auth-secure" title="<?echo GetMessage("AUTH_NONSECURE_NOTE")?>">
					<div class="bx-auth-secure-icon bx-auth-secure-unlock"></div>
				</span>
				</noscript>
<script type="text/javascript">
document.getElementById('bx_auth_secure').style.display = 'inline-block';
</script>
<?endif?>
				</td>
			</tr>
			<tr>
				<td class="user-table-label"><?=GetMessage("AUTH_NEW_PASSWORD_CONFIRM")?><span class="starrequired">*</span></td>
				<td><input type="password" name="USER_CONFIRM_PASSWORD" maxlength="50" value="<?=$arResult["USER_CONFIRM_PASSWORD"]?>" class="bx-auth-input" autocomplete="off" /></td>
			</tr>
		</tbody>
		<tfoot>
			<tr>
				<td></td>
				<td><input class="user-table-button" type="submit" name="change_pwd" value="<?=GetMessage("AUTH_CHANGE")?>" /></td>
			</tr>
		</tfoot>
	</table>

<div class="user-table-note field-note"><span class="starrequired">*</span><?=GetMessage("AUTH_REQ")?></div>

<div class="user-options">
	<div class="user-options-item registration-item">
		<a href="<?=$arResult["AUTH_AUTH_URL"]?>"><b><?=GetMessage("AUTH_AUTH")?></b></a>
	</div>
</div>

</form>

<script type="text/javascript">
document.bform.USER_LOGIN.focus();
</script>
</div>
</div>