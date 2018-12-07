
<div class="data">
<h1>Восстановление пароля</h1>
<br>
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

<div class="user-table-title"><?=GetMessage("AUTH_FORGOT_PASSWORD_1")?></div>
<div class="user-table-title"><?=GetMessage("AUTH_GET_CHECK_STRING")?>:</div>

<form class="bform" name="bform" method="post" target="_top" action="<?=$arResult["AUTH_URL"]?>&mes=yes">
<?
if (strlen($arResult["BACKURL"]) > 0)
{
?>
	<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
<?
}
?>

	<input type="hidden" name="AUTH_FORM" value="Y">
	<input type="hidden" name="TYPE" value="SEND_PWD">

<table class="data-table bx-forgotpass-table user-table">
	<thead>
		<tr> 
			<td></td>
			<td></td>
		</tr>
	</thead>
	<tbody>
<!-- 		<tr>
			<td class="user-table-label"><?=GetMessage("AUTH_LOGIN")?></td>
			<td>
				<input type="text" name="USER_LOGIN" maxlength="50" value="<?=$arResult["LAST_LOGIN"]?>" />
					<div class="user-table-note">
					<?=GetMessage("AUTH_OR")?>
					</div>
			</td>
		</tr> -->
		<tr> 
			<td class="user-table-label"><?=GetMessage("AUTH_EMAIL")?></td>
			<td>
				<input type="text" name="USER_EMAIL" maxlength="255" />
			</td>
		</tr>
	</tbody>
	<tfoot>
		<tr>
			<td></td>
			<td>
				<input class="btn btn_main" type="submit" name="send_account_info" value="<?=GetMessage("AUTH_SEND")?>" />
			</td>
		</tr>
	</tfoot>
</table>

<div class="user-options">
	<div class="user-options-item registration-item">
		<a href="<?=$arResult["AUTH_AUTH_URL"]?>" class="btn btn_outline"><?=GetMessage("AUTH_AUTH")?></a>
	</div>
</div>
</form>
<script type="text/javascript">
document.bform.USER_LOGIN.focus();
</script>

</div>