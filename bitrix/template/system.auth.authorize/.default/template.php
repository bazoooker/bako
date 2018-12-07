				<div class="block-content">

					<div class="data">

	<?if($_REQUEST['confirm_code']==""){
		echo "<h1>Авторизация</h1>";
	}
	?>


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

	<?
	ShowMessage($arResult['ERROR_MESSAGE']);
	?>

<div class="authorization">

	<div class="authorization-login">

		<?if($arResult["AUTH_SERVICES"]):?>
		<?endif?>

			<div class="auth-note user-table-title"><?=GetMessage("AUTH_PLEASE_AUTH")?></div>

			<form name="form_auth" method="post" target="_top" action="<?=$arResult["AUTH_URL"]?>&mes=yes">

				<input type="hidden" name="AUTH_FORM" value="Y" />
				<input type="hidden" name="TYPE" value="AUTH" />
				<?if (strlen($arResult["BACKURL"]) > 0):?>
				<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
				<?endif?>
				<?foreach ($arResult["POST"] as $key => $value):?>
				<input type="hidden" name="<?=$key?>" value="<?=$value?>" />
				<?endforeach?>

				<table class="form-table user-table">
					<tr>
						<td class="bx-auth-label user-table-label"><?=GetMessage("AUTH_LOGIN")?></td>
						<td><input class="bx-auth-input" type="text" name="USER_LOGIN" maxlength="255" value="<?=$arResult["LAST_LOGIN"]?>" /></td>
					</tr>
					<tr>
						<td class="bx-auth-label user-table-label"><?=GetMessage("AUTH_PASSWORD")?></td>
						<td><input class="bx-auth-input" type="password" name="USER_PASSWORD" maxlength="255" autocomplete="off" />
						</td>
					</tr>
		<?if ($arResult["STORE_PASSWORD"] == "Y"):?>
					<tr>
						<td></td>
						<td>
							<input type="checkbox" id="USER_REMEMBER" class="checkbox-input" name="USER_REMEMBER" value="Y" />
							<label class="user-table-note checkbox-note" for="USER_REMEMBER"><?=GetMessage("AUTH_REMEMBER_ME")?></label>
						</td>
					</tr>
		<?endif?>
					<tr>
						<td></td>
						<td class="authorize-submit-cell"><input class="btn btn_main" type="submit" name="Login" value="<?=GetMessage("AUTH_AUTHORIZE")?>" /></td>
					</tr>
				</table>

				<div class="user-options">

					<?if($arParams["NOT_SHOW_LINKS"] != "Y" && $arResult["NEW_USER_REGISTRATION"] == "Y" && $arParams["AUTHORIZE_REGISTRATION"] != "Y"):?>
						<div class="user-options-item registration-item">
							<noindex>						
								<!-- <a href="<?=$arResult["AUTH_REGISTER_URL"]?>" class="btn btn_outline" rel="nofollow"><?=GetMessage("AUTH_REGISTER")?></a> -->
								<a href="/auth/?register=yes" class="btn btn_outline" rel="nofollow"><?=GetMessage("AUTH_REGISTER")?></a>
								<div class="user-table-note"><?=GetMessage("AUTH_FIRST_ONE")?></div>
							</noindex>
						</div>
					<?endif?>

					<?if ($arParams["NOT_SHOW_LINKS"] != "Y"):?>
						<div class="user-options-item reminder-item">
							<noindex>
								<a href="<?=$arResult["AUTH_FORGOT_PASSWORD_URL"]?>" class="btn btn_outline" rel="nofollow"><?=GetMessage("AUTH_FORGOT_PASSWORD_2")?></a>
							</noindex>
						</div>
					<?endif?>
				</div>

			</form>

	</div>

	<script type="text/javascript">
	<?if (strlen($arResult["LAST_LOGIN"])>0):?>
	try{document.form_auth.USER_PASSWORD.focus();}catch(e){}
	<?else:?>
	try{document.form_auth.USER_LOGIN.focus();}catch(e){}
	<?endif?>
	</script>

	<?if($arResult["AUTH_SERVICES"]):?>
	<div class="authorization-social">
	<?
	$APPLICATION->IncludeComponent("bitrix:socserv.auth.form", "",
		array(
			"AUTH_SERVICES" => $arResult["AUTH_SERVICES"],
			"CURRENT_SERVICE" => $arResult["CURRENT_SERVICE"],
			"AUTH_URL" => $arResult["AUTH_URL"],
			"POST" => $arResult["POST"],
			"SHOW_TITLES" => $arResult["FOR_INTRANET"]?'N':'Y',
			"FOR_SPLIT" => $arResult["FOR_INTRANET"]?'Y':'N',
			"AUTH_LINE" => $arResult["FOR_INTRANET"]?'N':'Y',
		),
		$component,
		array("HIDE_ICONS"=>"Y")
	);
	?>
	</div>
	<?endif?>

</div>
<div class=clear></div>
</div></div>