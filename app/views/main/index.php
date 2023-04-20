<?php 
	//Верификация запроса
	$_SESSION['oauth2state'] = bin2hex(random_bytes(16));
	$clientParams = $vars['clientParams'];
?>
	<h2 class="mt-50 mb-10">Чтобы продолжить, пожалуйста, дайте интеграции доступ к вашему аккаунту AmoCRM</h2>
	<div class="row justify-content-center">
		<script
			class="amocrm_oauth"
			charset="utf-8"
			data-client-id="<?php echo $clientParams['clientId'] ?>"
			data-title="Установить интеграцию"
			data-compact="false"
			data-class-name="className"
			data-color="default"
			data-state="<?php echo $_SESSION['oauth2state'] ?>"
			data-error-callback="handleOauthError"
			src="https://www.amocrm.ru/auth/button.min.js"
		></script>
	</div>
	<script>
	handleOauthError = function(event) {
		alert('ID клиента - ' + event.client_id + ' Ошибка - ' + event.error);
	}
	</script>

