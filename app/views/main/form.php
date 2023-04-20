<div class="row justify-content-center">
	<div class="form-holder">
		<h2 class="mb-10">Форма создания сделки</h2>
		<form class="w-100" id="main-from" action="/formHandle" method="POST">
			<label class="form-label" for="name">Имя</label>
			<input class="form-control mb-3" id="name" name="name" type="text" value="Ваше имя">

			<label class="form-label" for="email">Почта</label>
			<input class="form-control mb-3" id="email" name="email" type="text" value="example@mail.com">

			<label class="form-label" for="phone" >Телефон</label>
			<input class="form-control mb-3" id="phone" name="phone" type="phone" value="+79999999999">

			<label class="form-label" for="price">Цена</label>
			<input class="form-control mb-3" id="price" name="price" type="number" value="1000">

			<input class="btn btn-primary w-100" id="submit-form" type="submit" value="Создать сделку">

			<p class="mt-3" id="result-info"></p>
		</form>
	</div>
</div>
