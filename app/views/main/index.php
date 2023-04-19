<p>Главная страница</p>

<?php 
	//Верификация запроса
	$_SESSION['oauth2state'] = bin2hex(random_bytes(16));
?>

	<div>
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
		</div>';
	<script>
	handleOauthError = function(event) {
		alert('ID клиента - ' + event.client_id + ' Ошибка - ' + event.error);
	}
	</script>
<?php
	die;
?>
