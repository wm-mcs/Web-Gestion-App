<div v-if="buscar_entre_fechas_mostrar" >
	<div class="contiene-buscar-entre-fechas">

		<div class="fechas-buscar-texto">
			Buscar los movimientos entre fechas.
		</div>
		<div class="flex-row-column get_width_100">
			<input type="date" class="form-control fecha_input_caja_busqueda" v-model="fecha_inicio" name="">
			<input type="date" class="form-control fecha_input_caja_busqueda" v-model="fecha_fin" name="">
		</div>
		<div class="admin-user-boton-Crear" v-on:click="disparador(entre_fechas)"><i class="fas fa-search"></i> </div>
	</div>
	<div class="contiene-buscar-entre-fechas">
		<div class="fechas-buscar-texto">
			Ver los movimientos de ese día y el saldo a ese día.
		</div>
		<div class="flex-row-column get_width_100">
			<input type="date" class="form-control fecha_input_caja_busqueda" v-model="fecha_inicio" name="">
			
		</div>
		<div class="admin-user-boton-Crear" v-on:click="disparador(arqueo)">  </div>
	</div>
</div>
<div v-else  v-on:click="mostrar_busqueda" class="contiene-buscar-entre-fechas-texto">
	Filtrar por fechas
</div>