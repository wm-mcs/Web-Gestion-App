<div v-if="buscar_entre_fechas_mostrar" class="contiene-buscar-entre-fechas">
	<input type="date" class="form-control get_width_40" v-model="fecha_inicio" name="">
	<input type="date" class="form-control get_width_40" v-model="fecha_fin" name="">
	<div class="admin-user-boton-Crear" v-on:click="getMovimientosDeCaja"><i class="fas fa-search"></i></div>
</div>
<div v-else  v-on:click="mostrar_busqueda" class="contiene-buscar-entre-fechas-texto">
	Filtrar por fechas
</div>