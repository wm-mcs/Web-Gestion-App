const orderFunction = {
	methods: {
		isNumeric: function(num) {
			return !isNaN(num);
		},
		compareValues: function(key, order = "asc") {
			return function innerSort(a, b) {
				if (!a.hasOwnProperty(key) || !b.hasOwnProperty(key)) {
					return 0;
				}

				if (typeof a[key] === "string" && this.isNumeric(a[key])) {
					var varA = parseFloat(a[key]);
					var varB = parseFloat(b[key]);
				} else {
					var varA = typeof a[key] === "string" ? a[key].toUpperCase() : a[key];
					var varB = typeof b[key] === "string" ? b[key].toUpperCase() : b[key];
				}

				let comparison = 0;
				if (varA > varB) {
					comparison = 1;
				} else if (varA < varB) {
					comparison = -1;
				}
				return order === "desc" ? comparison * -1 : comparison;
			};
		}
	}
};
