<div v-if="buscar_entre_fechas_mostrar" >
	<div class="contiene-buscar-entre-fechas">

		<div class="fechas-buscar-texto">
			Filtrar movimientos entre fechas. Para hacer arqueos elegir la misma fecha en ambos campos. De esa manera se verán los movimientos de ese día y el saldo a ese día.
		</div>
		<div class="get_width_100 flex-row-center">
			<div class="flex-row-column">
			<input type="date" class="form-control fecha_input_caja_busqueda" v-model="fecha_inicio" name="">
			<input type="date" class="form-control fecha_input_caja_busqueda" v-model="fecha_fin" name="">
		</div>
		<div class="admin-user-boton-Crear" v-on:click="disparador(entre_fechas)"><i class="fas fa-search"></i> </div>
		</div>
		
	</div>
	
	<div v-on:click="mostrar_busqueda" class="contiene-buscar-entre-fechas-texto">Filtrar por fechas <i class="fas fa-chevron-up"></i></div>
</div>
<div v-else  v-on:click="mostrar_busqueda" class="contiene-buscar-entre-fechas-texto">
	Filtrar por fechas <i class="fas fa-chevron-down"></i>
</div>