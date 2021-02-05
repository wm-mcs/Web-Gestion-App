const misChartMixin = {
	data: function() {
		return {
			colorSuccess: "#4bb543",
			colorDanger: "#fcb6b6"
		};
	},
	methods: {
		recetChartData: function() {
			this.chartData = {
				labels: [],
				datasets: []
			};
		},
		setDataSet: function(label, backgroundColor = [], data = []) {
			return {
				label: label,
				backgroundColor: backgroundColor,
				data: data
			};
		},

		calcularSaldo: function(esDeudor, data) {
			let REDUCER = (acc, movimiento) =>
				parseFloat(acc) + parseFloat(movimiento.valor);
			let deduroSumados = data
				.filter(movimiento => movimiento.tipo_saldo === "deudor")
				.reduce(REDUCER, 0);
			let acredorSumados = data
				.filter(movimiento => movimiento.tipo_saldo === "acredor")
				.reduce(REDUCER, 0);

			return esDeudor
				? deduroSumados - acredorSumados
				: acredorSumados - deduroSumados;
		}
	}
};