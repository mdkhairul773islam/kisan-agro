// Do sale controller
app.controller('editDoSaleController', function($scope, $http) {
	$scope.cart = [];
	$scope.presentBalance = 0.00;
	$scope.isDisabled = false;
	$scope.dueLimitCheck = true;

	$scope.amount = {
		total: 0,
		totalqty: 0,
		paid: null,
	};

	$scope.$watchGroup(['voucher_no', 'godown_code'], function(watchInfo) {
		$scope.cart = [];
		var voucher_no = watchInfo[0];
        var godown_code = watchInfo[1];
		
		// Get all products initial godown wise
		$scope.allProducts = [];
		if (typeof godown_code != 'undefined') {
			$http({
				method: 'POST',
				url: url + 'result',
				data: {
					table: 'stock',
					cond: {
						'godown_code': godown_code,
						'quantity >': 0,
						'type': "finish_product",
					},
					select: ['code', 'name', 'specification', 'batch_no']
				}
			}).success(function(products) {
				if (products.length > 0) {
					$scope.allProducts = products;
				}
			});
		}
		
		/* Get This Voucher Information */
		$http({
            method: 'post',
            url: url + 'result',
            data: {
                table: 'saprecords',
                cond: {voucher_no: voucher_no, trash: '0'}
            }
        }).success(function (voucherInfo) {
            if (voucherInfo.length > 0){
                // get voucher items
                $http({
                    method: 'POST',
                    url: url + 'join',
                    data: {
                        tableFrom: 'sapitems',
                        tableTo: 'stock',
                        joinCond: 'sapitems.product_code=stock.code AND sapitems.godown_code=stock.godown_code',
                        cond: {
                            'sapitems.voucher_no': voucher_no,
                            'sapitems.godown_code': godown_code,
							'stock.type': 'finish_product',
                            'sapitems.trash': '0',
                        },
                        select: ['sapitems.*', 'stock.name', 'stock.quantity AS stock_quantity']
                    }
                }).success(function(voucherItems) {
					console.log("res", voucherItems);
                    angular.forEach(voucherItems, function (row, index) {
                        var item = {
                            item_id: row.id,
                            product: row.name,
							batch_no: row.batch_no,
							product_code: row.product_code,
							unit: row.unit.toUpperCase(),
							godown_code: row.godown_code,
							maxQuantity: parseInt(row.quantity),
							stock_qty: parseInt(row.stock_quantity),
							quantity: 1.00,
							bag_size: parseFloat(row.bag_size) > 0 ? parseFloat(row.bag_size) : 1,
							no_of_bag: parseFloat(row.no_of_bag),
							subtotal: 0,
							purchase_price: parseFloat(row.purchase_price),
							sale_price: parseFloat(row.sale_price),
                        };

                        $scope.cart.push(item);
                    });
                });
				$scope.dueLimitCheck = voucherInfo[0].due_limit_reference !=="" ? false : true;
				$scope.amount.paid = parseFloat(voucherInfo[0].paid);
				$scope.findPartyFn(voucherInfo[0].party_code);
            }
        });
	});

	/* New product add */
	$scope.addNewProductFn = function() {
		if (typeof $scope.product_code !== 'undefined') {
			var condition = {
				table: 'stock',
				cond: {
					code: $scope.product_code,
					godown_code: (typeof $scope.godown_code != 'undefined') ? $scope.godown_code : $scope.select_godown_code
				}
			};

			$http({
				method: 'POST',
				url: url + 'result',
				data: condition
			}).success(function(response) {
				if (response.length > 0) {
					var newItem = {
						product: response[0].name,
						batch_no: response[0].batch_no,
						product_code: response[0].code,
						unit: response[0].unit.toUpperCase(),
						godown_code: response[0].godown_code,
						maxQuantity: parseInt(response[0].quantity),
						stock_qty: parseInt(response[0].quantity),
						quantity: 1.00,
						bag_size: parseFloat(response[0].bag_size) > 0 ? parseFloat(response[0].bag_size) : 1,
						no_of_bag: 0,
						subtotal: 0.00,
						purchase_price: parseFloat(response[0].purchase_price),
						sale_price: parseFloat(response[0].sell_price),
					};
					$scope.cart.push(newItem);
				}
			});
		}
	}

	//calculateTotalQty like bag_size*bag_no = total qty
	$scope.calculateTotalQty = function(i) {
		var total_quantity = 0;
		total_quantity = parseFloat($scope.cart[i].bag_size) * parseFloat($scope.cart[i].no_of_bag);
		$scope.cart[i].quantity = total_quantity.toFixed();
		return $scope.cart[i].quantity;
	};

	$scope.setSubtotalFn = function(index) {
		var total = 0.0;
		total = parseFloat($scope.cart[index].sale_price * $scope.cart[index].quantity);
		$scope.cart[index].subtotal = total;
		return $scope.cart[index].subtotal.toFixed();
	}

	$scope.purchaseSubtotalFn = function(index) {
		$scope.cart[index].purchase_subtotal = $scope.cart[index].purchase_price * $scope.cart[index].quantity;
		return $scope.cart[index].purchase_subtotal.toFixed();
	}

	$scope.getTotalFn = function() {
		var total = 0;
		angular.forEach($scope.cart, function(item) {
			total += parseFloat(item.subtotal);
		});
		$scope.amount.total = total.toFixed();
		return $scope.amount.total;
	}
	/* Total Voucher Qty */
	$scope.getTotalQtyFn = function() {
		var total = 0;
		angular.forEach($scope.cart, function(item) {
			total += parseFloat(item.quantity);
		});

		$scope.amount.totalqty = total.toFixed();
		return $scope.amount.totalqty;
	}

	$scope.getCurrentTotalFn = function() {
		var total = 0.00;

		if ($scope.partyInfo.sign == 'Receivable') {
			total = (parseFloat($scope.partyInfo.balance) + parseFloat($scope.amount.total)) - $scope.amount.paid;

			if (total > 0) {
				$scope.partyInfo.csign = "Receivable";
			} else if (total < 0) {
				$scope.partyInfo.csign = "Payable";
			} else {
				$scope.partyInfo.csign = "Receivable";
			}
		} else {
			total = (parseFloat($scope.partyInfo.balance) + $scope.amount.paid) - parseFloat($scope.amount.total);

			if (total > 0) {
				$scope.partyInfo.csign = "Payable";
			} else if (total < 0) {
				$scope.partyInfo.csign = "Receivable";
			} else {
				$scope.partyInfo.csign = "Receivable";
			}
		}
		$scope.presentBalance = Math.abs(total.toFixed(2));

		if (typeof $scope.party_code !== "undefined") {
			if ($scope.partyInfo.csign == "Receivable" && $scope.presentBalance <= $scope.partyInfo.credit_limit) {
				$scope.isDisabled = false;
				$scope.message = "";
			} else if ($scope.partyInfo.csign == "Payable" && $scope.presentBalance <= $scope.partyInfo.credit_limit) {
				$scope.isDisabled = false;
				$scope.message = "";
			} else {
				$scope.isDisabled = "true";
				$scope.message = "Total is being crossed the Credit Limit!";
			}
		}

		return $scope.presentBalance;
	}

	// get party previous balance
	$scope.partyInfo = {
		code: '',
		name: '',
		contact: '',
		address: '',
		balance: 0,
		payment: 0,
		credit_limit: 0,
		dueLimit: 0,
		sign: '',
		csign: ''
	};
	$scope.findPartyFn = function(party_code) {
		if (typeof party_code !== 'undefined') {
			var condition = {
				table: "parties",
				cond: {
					code: party_code
				},
				select: ['code', 'name', 'mobile', 'address', 'initial_balance', 'credit_limit', 'due_limit']
			};

			$http({
				method: 'POST',
				url: url + 'result',
				data: condition
			}).success(function(partyResponse) {

				if (partyResponse.length > 0) {

					$scope.partyInfo.code = partyResponse[0].code;
					$scope.partyInfo.name = partyResponse[0].name;
					$scope.partyInfo.mobile = partyResponse[0].mobile;
					$scope.partyInfo.address = partyResponse[0].address;
					$scope.partyInfo.credit_limit = parseFloat(partyResponse[0].credit_limit);
					$scope.partyInfo.dueLimit = parseFloat(partyResponse[0].due_limit);

					$http({
						method: "POST",
						url: url + "client_balance",
						data: {
							party_code: party_code
						}
					}).success(function(balanceInfo) {
						$scope.partyInfo.balance = Math.abs(parseFloat(balanceInfo.balance));
						$scope.partyInfo.sign = balanceInfo.status;
					});
				}
			});
		}
	}

	$scope.dueLimitCheckFn = function() {
		$scope.dueLimitCheck != $scope.dueLimitCheck;
		if (!$scope.dueLimitCheck) {
			$scope.partyInfo.dueLimit = 0;
		} else {
			$scope.findPartyFn($scope.party_code);
		}
	}

	$scope.getVoucherPayAmountFn = function() {
		if ($scope.dueLimitCheck) {
			return (($scope.partyInfo.dueLimit * $scope.amount.total) / 100).toFixed();
		}
		return 0;
	}

	// delete items
	$scope.trashCart = [];
	$scope.deleteItemFn = function(index) {
		if ($scope.cart[index].item_id !== ''){

			var alartInfo =  confirm("Are you sure you want to delete this data!");

			if (alartInfo){

				var item = {
					item_id: $scope.cart[index].item_id,
					product_code: $scope.cart[index].product_code,
				};

				$scope.trashCart.push(item);
				$scope.cart.splice(index, 1);
			}
		}else{
			$scope.cart.splice(index, 1);
		}
	};
});