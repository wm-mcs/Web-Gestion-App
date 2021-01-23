// buscador de eventos por marca
$("body").on("change", "#select_marcas_en_evento", function (e) {
	e.preventDefault();

	var form = $(this).parents();
	form.submit();
});

$("body").on("click", ".admin-boton-editar", function (e) {
	e.preventDefault();

	var form = $(this).parents();

	form.submit();
});

// buscador de eventos por marca
$("body").on("click", ".editar-evento-guardar", function (e) {
	e.preventDefault();

	var form = $(this).parents();

	$("input[name=tipo_de_boton]").val("guardar");

	form.submit();
});

// buscador de eventos por marca
$("body").on("click", ".editar-evento-guardar-y-salir", function (e) {
	e.preventDefault();

	var form = $(this).parents();

	$("input[name=tipo_de_boton]").val("guardar-y-salir");

	form.submit();
});

// buscador de eventos por marca
$("body").on("click", ".ocultar-esto", function (e) {
	$(this).hide();
});

$("body").on("click", ".disparar-este-form", function (e) {
	var form = $(this).parents();
	form.submit();
});

$("body").on("click", ".super-confirmacion", function (e) {
	return confirm("¿Estás seguro que quieres hacer esto?");
});
