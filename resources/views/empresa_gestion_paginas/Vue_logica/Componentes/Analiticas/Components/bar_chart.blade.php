const barChart = {
	extends: VueChartJs.Bar,
	mixins: [VueChartJs.mixins.reactiveProp],

	data: function() {
		return {
			options: {
				responsive: true,
				maintainAspectRatio: false,
				scales: {
					xAxes: [
						{
							gridLines: {
								offsetGridLines: true,
								stacked: true
							}
						}
					],
					yAxes: [
						{
							stacked: true
						}
					]
				}
			}
		};
	},

	mounted() {
		this.renderChart(this.chartData, this.options);
	}
};