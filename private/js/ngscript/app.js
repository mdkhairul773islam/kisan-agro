var app = angular.module("MainApp", ['ui.select2', 'angularUtils.directives.dirPagination', 'ngSanitize']);

var url = window.location.origin + '/kishan/ajax/';
var siteurl = window.location.origin + '/kishan/';

// var url = window.location.origin + '/ajax/';  
// var siteurl = window.location.origin + '/';


app.constant('select2Options', 'allowClear:true');

// custom filter in Angular js
app.filter('removeUnderScore', function () {
    return function (input) {
        return input.replace(/_/gi, " ");
    }
});

app.filter('textToLower', function () {
    return function (input) {
        return input.replace(/_/gi, " ").toLowerCase();
    }
});

//remove underscore and ucwords
app.filter("textBeautify", function () {
    return function (str) {
        var str = str.replace(/_/gi, " ").toLowerCase(),
            txt = str.replace(/\b[a-z]/g, function (letter) {
                return letter.toUpperCase();
            });

        return txt;
    }
});

//remove dash and ucwords
app.filter("removeDash", function () {
    return function (str) {
        var str = str.replace(/-/gi, " ").toLowerCase();
        txt = str.replace(/\b[a-z]/g, function (letter) {
            return letter.toUpperCase();
        });
        return txt;
    }
});


app.filter('join', function () {
    return function (input) {
        console.log(typeof input);
        return (typeof input === 'object') ? "" : input.join();
    }
});


app.filter("showStatus", function () {
    return function (input) {
        if (input == 1) {
            return "Available";
        } else {
            return "Not Available";
        }
    }
});


app.filter("status", function () {
    return function (input) {
        if (input == "active") {
            return "Running";
        } else {
            return "Blocked";
        }
    }
});


app.filter("fNumber", function () {
    return function (input) {
        var myNum = new Intl.NumberFormat('en-IN').format(input);
        return myNum;
    }
});


//show all Category
app.controller("showcategoryCtrl", function ($scope, $http) {
    $scope.reverse = false;
    $scope.perPage = "500";
    $scope.allCategory = [];


    $http({
        method: 'post',
        url: url + 'left_join',
        data: {
            tableFrom: 'category',
            tableTo: 'department',
            joinCond: 'category.department_id=department.id',
            cond: {'category.trash': 0},
            select: ['category.*', 'department.department_name']
        }
    }).success(function (response) {

        if (response.length > 0) {
            $scope.allCategory = response;
        }
    })


    //Pre Loader
    $("#loading").fadeOut("fast", function () {
        $("#data").fadeIn('slow');
    });
});


// show All Materials Ctrl
app.controller("showAllMaterials", ['$scope', '$http', function ($scope, $http) {
    $scope.allMaterials = [];
    $scope.perPage = "20";
    var where = {
        table: "materials",
        cond: {
            type: "raw",
            trash: "0"
        }
    };

    $http({
        method: "POST",
        url: url + "read",
        data: where
    }).success(function (response) {
        if (response.length > 0) {
            angular.forEach(response, function (row, key) {
                row['sl'] = key + 1;
                $scope.allMaterials.push(row);
            });
        } else {
            $scope.allMaterials = [];
        }

        //Loader
        $("#loading").fadeOut("fast", function () {
            $("#data").fadeIn('slow');
        });
    });
}]);


//show all Product Controller
app.controller("showAllProductCtrl", function ($scope, $http) {
    $scope.perPage = "20";
    $scope.products = [];

    var where = {
        table: 'materials',
        cond: {
            type: "finish_product",
            trash: "0"
        }
    };


    $http({
        method: 'POST',
        url: url + 'read',
        data: where
    }).success(function (response) {
        if (response.length > 0) {
            angular.forEach(response, function (values, index) {
                values['sl'] = index + 1;
                $scope.products.push(values);
            });
        } else {
            $scope.products = [];
        }

        //Loader
        $("#loading").fadeOut("fast", function () {
            $("#data").fadeIn('slow');
        });
    });
});


//show all SR from the database controller
app.controller("damageCtrl", function ($scope, $http) {
    $scope.perPage = "50";
    $scope.reverse = false;
    $scope.allSr = [];
    $scope.damageQty = function () {
        var condition = {
            table: 'stock',
            cond: {
                code: $scope.damage,
                type: 'finish_product'
            }
        };

        $http({
            method: "POST",
            url: url + "read",
            data: condition
        }).success(function (response) {
            if (response.length > 0) {
                // $scope.quantity.push(response[0].quantity);
                $scope.quantity = response[0].quantity;
            }
            console.log($scope.quantity);
        });
    }

});


//show all Party from the database controller
app.controller("allCompanyCtrl", function ($scope, $http) {
    $scope.perPage = "10";
    $scope.reverse = false;
    $scope.allParty = [];

    var where = {
        table: "parties",
        cond: {type: "company"}
    };

    $http({
        method: "POST",
        url: url + "read",
        data: where
    }).success(function (response) {
        if (response.length > 0) {
            angular.forEach(response, function (row, index) {
                response[index].sl = index + 1;

                var where = {
                    table: "partybalance",
                    cond: {code: row.code}
                };

                $http({
                    method: "POST",
                    url: url + "read",
                    data: where
                }).success(function (item) {

                    response[index].initial_balance = Math.abs(item[0].initial_balance);
                    response[index].balance = Math.abs(item[0].balance);

                    if (item[0].balance < 0) {
                        response[index].color = 'color: red; font-weight: bold;';
                        response[index].status = 'Payable';
                    } else {
                        response[index].color = 'color: green; font-weight: bold;';
                        response[index].status = 'Receivable';
                    }

                });

            });

            $scope.allParty = response;
            console.log(response);
        }
        //loading
        $("#loading").fadeOut("fast", function () {
            $("#data").fadeIn('slow');
        });

    });

});


//show all Party from the database controller
app.controller("allClientCtrl", function ($scope, $http) {
    $scope.perPage = "0";
    $scope.reverse = false;
    $scope.allParty = [];

    var condition = {
        tableFrom: "parties",
        tableTo: "partybalance",
        joinCond: "parties.code = partybalance.code",
        cond: {
            'parties.type': "client",
            'parties.trash': "0"
        },
        select: ['parties.*', 'partybalance.initial_balance', 'partybalance.credit_limit'],
        order_col: 'parties.id'
    };

    $http({
        method: "POST",
        url: url + "join",
        data: condition
    }).success(function (response) {

        if (response.length > 0) {
            angular.forEach(response, function (row, index) {


                row.sl = index + 1;
                row.security_money = 0;
                row.clColor = (parseFloat(row.credit_limit) < 0 ? "red" : "green");
                row.credit_limit = parseFloat(row.credit_limit);

                // get client balance info
                $http({
                    method: "POST",
                    url: url + "client_balance",
                    data: {party_code: row.code}
                }).success(function (balanceRes) {
                    row.balanceColor = (parseFloat(balanceRes.balance) < 0 ? "red" : "green");
                    row.balance = parseFloat(balanceRes.balance);
                });

                // get meta info
                var metaWhere = {
                    table: 'partymeta',
                    cond: {"party_code": row.code, "meta_key": "security"}
                };

                $http({
                    method: "POST",
                    url: url + "read",
                    data: metaWhere
                }).success(function (metaData) {
                    if (metaData.length > 0) {
                        var data = angular.fromJson(metaData[0].meta_value);

                        angular.forEach(data, function (item) {
                            row.security_money += parseFloat(item.amount);
                        });
                    }
                });

                $scope.allParty.push(row);

            });

        }


        // loading
        $("#loading").fadeOut("fast", function () {
            $("#data").fadeIn('slow');
        });
    });

});


//clientalltransaction ctrl
app.controller("clientAllTransactionCtrl", function ($scope, $http) {
    $scope.getPartyInfo = function () {

        var where = {
            table: "parties",
            cond: {
                type: "client",
                code: $scope.party_code,
                trash: 0
            }
        };

        console.log(where);

        $http({
            method: "POST",
            url: url + "read",
            data: where
        }).success(function (response) {
            if (response.length == 1) {
                $scope.name = response[0].name + " [ " + response[0].address + " ]";
                console.log($scope.name);
            } else {
                $scope.name = "";
            }
        });
    };
});


//client ledger ctrl
app.controller("clientLedgerCtrl", function ($scope, $http) {
    $scope.getPartyInfo = function () {

        var where = {
            table: "parties",
            cond: {
                type: "client",
                code: $scope.party_code,
                status: "active",
                trash: 0
            }
        };

        console.log(where);

        $http({
            method: "POST",
            url: url + "read",
            data: where
        }).success(function (response) {
            if (response.length == 1) {
                $scope.name = response[0].name + " [ " + response[0].address + " ]";
                console.log($scope.name);
            } else {
                $scope.name = "";
            }
        });
    };
});


//show all Party from the database controller
app.controller("allCrushingClientCtrl", function ($scope, $http) {
    $scope.perPage = "50";
    $scope.reverse = false;
    $scope.allParty = [];

    var condition = {
        from: "crushing_parties",
        join: "crushing_partybalance",
        cond: "crushing_parties.code = crushing_partybalance.code",
        where: {
            'crushing_parties.type': "client",
            'crushing_parties.trash': "0"
        }
    };

    $http({
        method: "POST",
        url: url + "readJoinData",
        data: condition
    }).success(function (response) {
        if (response.length > 0) {
            angular.forEach(response, function (row, index) {
                row.sl = index + 1;
                row.security_money = 0;

                row.balanceColor = (row.balance >= 0) ? "green" : "red";
                row.clColor = (row.credit_limit >= 0) ? "green" : "red";

                row.balance = Math.abs(row.balance);
                row.credit_limit = Math.abs(row.credit_limit);

                // get meta info
                var metaWhere = {
                    table: 'crushing_partymeta',
                    cond: {"party_code": row.code, "meta_key": "security"}
                };

                $http({
                    method: "POST",
                    url: url + "read",
                    data: metaWhere
                }).success(function (metaData) {
                    if (metaData.length > 0) {
                        var data = angular.fromJson(metaData[0].meta_value);

                        angular.forEach(data, function (item) {
                            row.security_money += parseFloat(item.amount);
                        });
                    }
                });
                $scope.allParty.push(row);
                //console.log($scope.allParty);
            });
        }
        // loading
        $("#loading").fadeOut("fast", function () {
            $("#data").fadeIn('slow');
        });
        //console.log(response);
    });
});


// Edit client ctrl
app.controller("EditCrushingClientCtrl", ['$scope', '$http', function ($scope, $http) {
    $scope.items = [{
        brand: "",
        balance: 0,
        limit: 0,
        status: "receivable"
    }];

    $scope.$watch("partyCode", function () {
        var where = {
            table: "crushing_partybalance",
            cond: {code: $scope.partyCode}
        };

        $http({
            method: "POST",
            url: url + "read",
            data: where
        }).success(function (response) {
            if (response.length > 0) {
                $scope.items = [];
                angular.forEach(response, function (values) {
                    values.status = (parseFloat(values.initial_balance) <= 0) ? "receivable" : "payable";
                    values.amount = Math.abs(parseFloat(values.initial_balance));
                    values.credit_limit = parseFloat(values.credit_limit);
                    $scope.items.push(values);
                });
            }
            //console.log($scope.items);
        });

    });

    $scope.addNewFn = function () {
        var newobj = {
            brand: "",
            balance: 0,
            limit: 0,
            status: "receivable"
        };

        $scope.items.push(newobj);
    }

    $scope.deleteFn = function (index) {
        $scope.items.splice(index, 1);
    }

}]);


// Client transaction controller start here
app.controller('CrushingClientTransactionCtrl', ['$scope', '$http', function ($scope, $http) {
    $scope.sign = 'Receivable';
    $scope.csign = 'Receivable';

    $scope.payment = 0;
    $scope.displayBalance = 0;

    // get client information
    $scope.getclientInfo = function () {
        var condition = {
            table: 'crushing_partybalance',
            cond: {code: $scope.code}
        };

        $http({
            method: "POST",
            url: url + "read",
            data: condition
        }).success(function (response) {
            if (response.length > 0) {
                var balance = parseFloat(response[0].balance);

                $scope.displayBalance = parseFloat(response[0].balance);
                $scope.balance = Math.abs(balance);

                if (balance < 0) {
                    $scope.sign = 'Payable';
                } else {
                    $scope.sign = 'Receivable';
                }
            }
            //console.log(response);
        });
    };

    $scope.getTotalFn = function () {
        var total = $scope.displayBalance - $scope.payment;
        $scope.csign = (total >= 0) ? "Receivable" : "Payable";
        return Math.abs(total);
    }
}]);


// client edit transaction controller start here
app.controller('CrushingClientTransactionEditCtrl', ['$scope', '$http', function ($scope, $http) {
    $scope.payment = 0;

    $scope.$watchGroup(['id', 'transactionBy'], function (input) {
        if (input[1] == 'cheque') {

            $http({
                method: 'POST',
                url: url + "read",
                data: {
                    table: 'crushing_partytransactionmeta',
                    cond: {transaction_id: input[0]}
                }
            }).success(function (response) {
                if (response.length > 0) {
                    angular.forEach(response, function (row) {
                        if (row.meta_key == 'bankname') {
                            $scope.bankname = row.meta_value;
                        }
                        if (row.meta_key == 'branchname') {
                            $scope.branchname = row.meta_value;
                        }
                        if (row.meta_key == 'account_no') {
                            $scope.accountno = row.meta_value;
                        }
                        if (row.meta_key == 'chequeno') {
                            $scope.chequeno = row.meta_value;
                        }
                        if (row.meta_key == 'passdate') {
                            $scope.passdate = row.meta_value;
                        }
                    });
                }
                //console.log(response);
            });
        }
    });

    $scope.getTotalFn = function () {
        var total = $scope.balance - ($scope.payment - $scope.prevPayment);
        $scope.csign = (total >= 0) ? "Receivable" : "Payable";

        return Math.abs(total);
    }

}]);


// sale controller
app.controller('multiSaleReturn', function ($scope, $http) {

    $scope.cart = [];

    $scope.partyInfo = {
        name: '',
        mobile: '',
        address: '',
        balance: 0,
        previous_balance: 0,
        current_balance: 0,
        sign: 'Receivable',
        csign: 'Receivable'
    };


    $scope.sap_type = 'cash';
    $scope.cashBtn = 'btn-success';
    $scope.creditBtn = 'btn-default';

    $scope.setSaleType = function (saleType) {

        $scope.partyInfo = {
            name: '',
            mobile: '',
            address: '',
            balance: 0,
            previous_balance: 0,
            current_balance: 0,
            sign: 'Receivable',
            csign: 'Receivable'
        };

        if (typeof saleType !== "undefined" && saleType == 'credit') {

            $scope.cashBtn = 'btn-default';
            $scope.creditBtn = 'btn-success';
            $scope.sap_type = 'credit';
        } else {
            $scope.cashBtn = 'btn-success';
            $scope.creditBtn = 'btn-default';

            $scope.sap_type = 'cash';
        }
    };

    // get party info and balance
    $scope.findPartyFn = function (party_code) {
        if (typeof party_code != 'undefined') {

            var test = {
                table: 'parties',
                cond: {code: party_code, type: 'client'},
                select: ['code', 'name', 'mobile', 'address', 'client_type']
            };

            $http({
                method: 'POST',
                url: url + 'result',
                data: test
            }).success(function (partyRes) {
                if (partyRes.length > 0) {

                    // gat party information
                    $scope.partyInfo.name = partyRes[0].name;
                    $scope.partyInfo.mobile = partyRes[0].mobile;
                    $scope.partyInfo.address = partyRes[0].address;

                    // gat party balance
                    $http({
                        method: 'POST',
                        url: url + 'client_balance',
                        data: {party_code: party_code}
                    }).success(function (balanceRes) {
                        $scope.partyInfo.balance = Math.abs(balanceRes.balance);
                        $scope.partyInfo.previous_balance = Math.abs(parseFloat(balanceRes.balance));
                        $scope.partyInfo.sign = balanceRes.status;
                    });
                }
            });
        }
    }


    // add product in the card
    $scope.productCodeList = [];
    $scope.addNewProductFn = function (product_code) {
        if (typeof product_code !== 'undefined' && $scope.productCodeList.indexOf(product_code) == '-1') {

            $http({
                method: 'POST',
                url: url + 'result',
                data: {
                    table: 'stock',
                    cond: {
                        'code': product_code,
                        'type': 'finish_product',
                    }
                }
            }).success(function (response) {

                if (response.length > 0) {

                    // push product code for check this product exists
                    $scope.productCodeList.push(product_code);

                    var salePrice = $scope.sap_type == 'cash' ? parseFloat(response[0].sell_price) : parseFloat(response[0].dealer_price);

                    var newItem = {
                        product_code: response[0].code,
                        product_name: response[0].name,
                        unit: response[0].unit,
                        weight: parseFloat(response[0].weight),
                        purchase_price: parseFloat(response[0].purchase_price),
                        sale_price: salePrice,
                        stock_qty: parseFloat(response[0].quantity),
                        quantity: '',
                        subtotal: 0,
                    };
                    $scope.cart.push(newItem);
                }
            });
        }
    };


    // get product wise sub total for sale
    $scope.setSubtotalFn = function (index) {
        var quantity = !isNaN(parseFloat($scope.cart[index].quantity)) ? parseFloat($scope.cart[index].quantity) : 0;
        $scope.cart[index].subtotal = $scope.cart[index].sale_price * quantity;
        return $scope.cart[index].subtotal.toFixed();
    };


    // get total return amount
    $scope.totalQuantity = 0;

    $scope.getTotalFn = function () {

        var totalAmount = totalQuantity = 0;
        angular.forEach($scope.cart, function (item) {
            totalAmount += parseFloat(item.subtotal);
            totalQuantity += !isNaN(parseFloat(item.quantity)) ? parseFloat(item.quantity) : 0;
        });

        $scope.totalQuantity = totalQuantity;

        return Math.abs(totalAmount.toFixed(2));
    };


    // calculate current balance
    $scope.getCurrentTotalFn = function () {

        var payment = !isNaN(parseFloat($scope.payment)) ? parseFloat($scope.payment) : 0;

        var balance = $scope.partyInfo.previous_balance - (parseFloat($scope.getTotalFn()) - payment);

        $scope.partyInfo.csign = (balance < 0 ? "Payable" : "Receivable");
        $scope.partyInfo.current_balance = balance;

        $scope.isDisable = ($scope.totalQuantity > 0 ? false : true);

        return Math.abs(balance.toFixed(2));
    };


    // delete item in the card
    $scope.deleteItemFn = function (index) {
        $scope.cart.splice(index, 1);
        $scope.productCodeList.splice(index, 1);
    };
});


// sale controller
app.controller('DamageAddController', function ($scope, $http) {

    $scope.cart = [];
    $scope.active = false;
    $scope.currentBalance = 0;

    // initialize variable
    $scope.amount = {
        total_quantity: 0,
        purchase_total: 0,
        sale_total: 0,
        current_balance: 0,
        paid: 0,
    }

    // initialize party info
    $scope.partyInfo = {
        code: '',
        name: '',
        mobile: '',
        address: '',
        client_type: '',
        balance: 0,
        payment: 0,
        cl: 0,
        sign: 'Receivable',
        csign: 'Receivable'
    };

    // get party info and balance
    $scope.findPartyFn = function (party_code) {
        if (typeof party_code != 'undefined') {

            var test = {
                table: 'parties',
                cond: {code: party_code, type: 'client'},
                select: ['code', 'name', 'mobile', 'address', 'client_type']
            };

            $http({
                method: 'POST',
                url: url + 'result',
                data: test
            }).success(function (partyRes) {
                if (partyRes.length > 0) {

                    // gat party information
                    $scope.partyInfo.name = partyRes[0].name;
                    $scope.partyInfo.mobile = partyRes[0].mobile;
                    $scope.partyInfo.address = partyRes[0].address;
                    $scope.partyInfo.client_type = partyRes[0].client_type;

                    // gat party balance
                    $http({
                        method: 'POST',
                        url: url + 'client_balance',
                        data: {party_code: party_code}
                    }).success(function (balanceRes) {
                        $scope.partyInfo.balance = Math.abs(balanceRes.balance);
                        $scope.partyInfo.sign = balanceRes.status;
                    });
                }
            });
        }
    }


    // add product in the card
    $scope.productCodeList = [];
    $scope.addNewProductFn = function (product_code) {
        if (typeof $scope.partyInfo.client_type != 'undefined' && typeof product_code !== 'undefined' && $scope.productCodeList.indexOf(product_code) == '-1') {

            var condition = {
                tableFrom: 'stock',
                tableTo: ['materials', 'materials_price'],
                joinCond: ['materials.code=stock.code AND materials.type=stock.type', 'materials_price.code=stock.code'],
                cond: {
                    'stock.code': product_code,
                    'stock.godown': 1,
                    'stock.type': 'finish_product',
                    'materials_price.type': $scope.partyInfo.client_type,
                },
                select: ['stock.name', 'stock.code', 'stock.quantity', 'stock.unit', 'stock.godown', 'materials.production_cost', 'materials.weight', 'materials_price.price']
            };

            $http({
                method: 'POST',
                url: url + 'join',
                data: condition
            }).success(function (response) {

                if (response.length > 0) {

                    // push product code for check this product exists
                    $scope.productCodeList.push(product_code);
                    $scope.active = false;

                    angular.forEach(response, function (item) {
                        var newItem = {
                            product_name: item.name,
                            product_code: item.code,
                            godown: item.godown,
                            weight: item.weight,
                            maxQuantity: parseInt(item.quantity),
                            stock_qty: parseInt(item.quantity),
                            quantity: '',
                            unit: item.unit,
                            subtotal: 0,
                            purchase_price: parseFloat(item.production_cost),
                            sale_price: parseFloat(item.price),
                        };
                        $scope.cart.push(newItem);
                    });
                }
            });
        } else {
            $scope.active = true;
        }
    }

    // get calculate total weight
    $scope.calculateWeight = function (i) {
        $scope.cart[i].total_weight = parseFloat($scope.cart[i].weight) * parseFloat($scope.cart[i].quantity);
        return $scope.cart[i].total_weight;
    };

    // get product wise sub total for purchase
    $scope.purchaseSubtotalFn = function (index) {
        $scope.cart[index].purchase_subtotal = $scope.cart[index].purchase_price * $scope.cart[index].quantity;
        return $scope.cart[index].purchase_subtotal.toFixed();
    }

    // get product wise sub total for sale
    $scope.setSubtotalFn = function (index) {
        $scope.cart[index].subtotal = $scope.cart[index].sale_price * $scope.cart[index].quantity;
        return $scope.cart[index].subtotal.toFixed();
    }

    // get total return quantity
    $scope.getTotalQtyFn = function () {
        var total = 0;
        angular.forEach($scope.cart, function (item) {
            total += (typeof parseFloat(item.quantity) !== "undefined" && item.quantity != "") ? parseFloat(item.quantity) : 0;
        });

        $scope.amount.total_quantity = total;
        return $scope.amount.total_quantity;
    }

    // get total purchase amount
    $scope.getPurchaseTotalFn = function () {
        var total = 0;
        angular.forEach($scope.cart, function (item) {
            total += parseFloat(item.purchase_subtotal);
        });

        $scope.amount.purchase_total = total.toFixed();
        return $scope.amount.purchase_total;
    }

    // get total return amount
    $scope.getTotalFn = function () {
        var total = 0;
        angular.forEach($scope.cart, function (item) {
            total += parseFloat(item.subtotal);
        });

        $scope.amount.sale_total = total.toFixed();
        return $scope.amount.sale_total;
    }


    // calculate current balance
    $scope.getCurrentTotalFn = function () {

        var balance = 0;

        if ($scope.partyInfo.sign == 'Receivable') {
            balance = (parseFloat($scope.partyInfo.balance) - parseFloat($scope.getTotalFn()));
        } else {
            balance = 0 - (parseFloat($scope.getTotalFn()) + parseFloat($scope.partyInfo.balance));
        }

        $scope.partyInfo.csign = (balance < 0 ? "Payable" : "Receivable");

        $scope.amount.current_balance = Math.abs(balance.toFixed(2));

        return $scope.amount.current_balance;
    }


    // delete item in the card
    $scope.deleteItemFn = function (index) {
        $scope.cart.splice(index, 1);
        $scope.productCodeList.splice(index, 1);
    }
});


function arrayCheck(inputArray, columnName) {
    return inputArray.some(function (el) {
        return el.columnName === columnName;
    });
}


// requisition entry controller
app.controller('requisitionEntryCtrl', function ($scope, $http) {

    $scope.cart = [];
    $scope.productList = {};
    $scope.getProductList = function(productType){
        
        $scope.cart = [];
        $scope.productList = {};
        
        if(productType !== 'undefined' && productType != ''){
            
            $http({
                method: 'POST',
                url: url + 'result',
                data: {
                    table: 'materials',
                    cond:{type: productType, status: 'available', trash: 0},
                    select: ['code', 'name', 'specification']
                }
            }).success(function (response) {
                if(response.length > 0){
                    $scope.productList = response;
                }
            });
        }
    };

    // add product
    $scope.erroeMessage = false;
    $scope.checkProductCode = [];
    $scope.addNewProductFn = function (productCode) {
        if (typeof productCode !== 'undefined' && productCode != '') {

            if ($scope.checkProductCode.includes(productCode) != true) {
                
                $http({
                    method: 'POST',
                    url: siteurl + 'purchase/requisition/cartItem',
                    data: {product_code: productCode}
                }).success(function (response) {
                    if(response){
                        $scope.cart.push(response);
                    }
                });

                $scope.erroeMessage = false;
            } else {
                $scope.erroeMessage = true;
            }
        }
    };


    $scope.setSubtotalFn = function (index) {
        var subtotal = $scope.cart[index].subtotal = parseFloat($scope.cart[index].purchase_price) * $scope.cart[index].quantity;
        return $scope.cart[index].subtotal = Math.abs(subtotal.toFixed(2));
    };

    $scope.totalQuantity = 0;
    $scope.getTotalFn = function () {

        var totalAmount = totalQuantity = 0;

        angular.forEach($scope.cart, function (item) {
            totalAmount += parseFloat(item.subtotal);
            totalQuantity += !isNaN(parseFloat(item.quantity)) ? parseFloat(item.quantity) : 0;
        });

        $scope.totalQuantity = totalQuantity;

        $scope.isDisable = totalQuantity > 0 ? false : true;

        return Math.abs(totalAmount.toFixed(2));
    };

    $scope.deleteItemFn = function (index) {
        $scope.checkProductCode.splice(index, 1);
        $scope.cart.splice(index, 1);
    };
});

// requisition edit controller
app.controller('requisitionEditCtrl', function ($scope, $http) {

    $scope.cart = [];
    $scope.productList = {};

    $scope.$watch('productType', function (productType) {
        $scope.cart = [];
        $scope.productList = {};

        if(productType !== 'undefined' && productType != ''){

            $http({
                method: 'POST',
                url: url + 'result',
                data: {
                    table: 'materials',
                    cond:{type: productType, status: 'available', trash: 0},
                    select: ['code', 'name', 'specification']
                }
            }).success(function (response) {
                if(response.length > 0){
                    $scope.productList = response;
                }
            });
        }
    });

    // add product
    $scope.erroeMessage = false;
    $scope.checkProductCode = [];

    $scope.$watch('voucherNo', function (voucherNo) {

        if (typeof voucherNo !== 'undefined' && voucherNo != '') {

            $http({
                method: 'POST',
                url: siteurl + 'purchase/requisition/editCartItem',
                data: {voucher_no: voucherNo}
            }).success(function (response) {

                if (response.length > 0) {

                    angular.forEach(response, function (row) {

                        $scope.checkProductCode.push(row.code);

                        row.quantity = parseFloat(row.quantity);
                        row.purchase_price = parseFloat(row.purchase_price);
                        row.sale_price = parseFloat(row.sale_price);

                        $scope.cart.push(row);
                    });
                }
            });
        }
    });


    $scope.addNewProductFn = function (productCode) {
        if (typeof productCode !== 'undefined' && productCode != '') {

            if ($scope.checkProductCode.includes(productCode) != true) {

                $scope.checkProductCode.push(productCode);

                $http({
                    method: 'POST',
                    url: siteurl + 'purchase/requisition/cartItem',
                    data: {product_code: productCode}
                }).success(function (response) {
                    if(response){
                        $scope.cart.push(response);
                    }
                });

                $scope.erroeMessage = false;
            } else {
                $scope.erroeMessage = true;
            }
        }
    };


    $scope.setSubtotalFn = function (index) {
        var subtotal = $scope.cart[index].subtotal = $scope.cart[index].purchase_price * $scope.cart[index].quantity;
        return $scope.cart[index].subtotal = Math.abs(subtotal.toFixed(2));
    };

    $scope.totalQuantity = 0;
    $scope.getTotalFn = function () {

        var totalAmount = totalQuantity = 0;

        angular.forEach($scope.cart, function (item) {
            totalAmount += parseFloat(item.subtotal);
            totalQuantity += !isNaN(parseFloat(item.quantity)) ? parseFloat(item.quantity) : 0;
        });

        $scope.totalQuantity = totalQuantity;

        $scope.isDisable = totalQuantity > 0 ? false : true;

        return Math.abs(totalAmount.toFixed(2));
    };

    $scope.deleteItem = [];
    $scope.deleteItemFn = function (index) {

        if ($scope.cart[index].item_id) {
            var alert = confirm('Do you want to delete this data?');
            if (alert) {

                $scope.deleteItem.push({
                    id: $scope.cart[index].item_id,
                    code: $scope.cart[index].code,
                    quantity: $scope.cart[index].old_quantity,
                });

                $scope.checkProductCode.splice(index, 1);
                $scope.cart.splice(index, 1);
            }
        } else {
            $scope.checkProductCode.splice(index, 1);
            $scope.cart.splice(index, 1);
        }
    };
});


// purchase order entry controller
app.controller('purchaseOrderEntryCtrl', function ($scope, $http) {

    $scope.cart = [];
    $scope.getProductList = function(referenceNo){

        $scope.cart = [];

        if (typeof referenceNo !== 'undefined' && referenceNo != ''){

            $http({
                method: 'post',
                url: siteurl + 'purchase/purchaseOrder/cartItem',
                data: {reference_no: referenceNo}
            }).success(function(response){

                if (response.length > 0){
                    angular.forEach(response, function (row) {

                        row.quantity = parseFloat(row.quantity);
                        row.purchase_price = parseFloat(row.purchase_price);
                        row.sale_price = parseFloat(row.sale_price);

                        $scope.cart.push(row);
                    });
                }
            });
        }
    };

    $scope.setDiscountFn = function (index) {

        var quantity = !isNaN(parseFloat($scope.cart[index].quantity)) ? parseFloat($scope.cart[index].quantity) : 0;
        var discountPer = !isNaN(parseFloat($scope.cart[index].discount_per)) ? parseFloat($scope.cart[index].discount_per) : 0;
        var purchasePrice = !isNaN(parseFloat($scope.cart[index].purchase_price)) ? parseFloat($scope.cart[index].purchase_price) : 0;
        var discount = ((purchasePrice * quantity) / 100) * discountPer;

        $scope.cart[index].discount = Math.abs(discount.toFixed(2));
        return $scope.cart[index].discount;
    };

    $scope.setSubtotalFn = function (index) {

        var quantity = !isNaN(parseFloat($scope.cart[index].quantity)) ? parseFloat($scope.cart[index].quantity) : 0;
        var purchasePrice = !isNaN(parseFloat($scope.cart[index].purchase_price)) ? parseFloat($scope.cart[index].purchase_price) : 0;
        var subtotal = (purchasePrice * quantity);

        $scope.cart[index].subtotal = Math.abs(subtotal.toFixed(2));
        return $scope.cart[index].subtotal;
    };

    $scope.totalQuantity = 0;
    $scope.totalDiscount = 0;
    $scope.getTotalFn = function () {

        var totalAmount = totalQuantity = totalDiscount = 0;

        angular.forEach($scope.cart, function (item) {
            totalAmount += parseFloat(item.subtotal);
            totalQuantity += !isNaN(parseFloat(item.quantity)) ? parseFloat(item.quantity) : 0;
            totalDiscount += parseFloat(item.discount);
        });

        $scope.totalQuantity = totalQuantity;
        $scope.totalDiscount = Math.abs(totalDiscount.toFixed(2));
        $scope.isDisable = totalQuantity > 0 ? false : true;

        return Math.abs(totalAmount.toFixed(2));
    };

    $scope.getGrandTotalFn = function(){

        var totalBill = parseFloat($scope.getTotalFn()) - parseFloat($scope.totalDiscount);
        return totalBill;
    };

    $scope.deleteItemFn = function (index) {
        $scope.cart.splice(index, 1);
    };
});

// order edit controller
app.controller('orderEditCtrl', function ($scope, $http) {

    $scope.cart = [];

    // add product
    $scope.erroeMessage = false;
    $scope.checkProductCode = [];

    $scope.$watch('voucherNo', function (voucherNo) {

        if (typeof voucherNo !== 'undefined' && voucherNo != '') {

            $http({
                method: 'POST',
                url: url + 'join',
                data: {
                    tableFrom: 'order_items',
                    tableTo: 'materials',
                    joinCond: 'order_items.product_code=materials.code',
                    cond: {'order_items.voucher_no': voucherNo, 'order_items.trash': 0},
                    select: ['order_items.*', 'materials.name', 'materials.unit']
                }
            }).success(function (response) {

                if (response.length > 0) {

                    angular.forEach(response, function (row) {

                        $scope.checkProductCode.push(row.product_code);

                        var item = {
                            item_id: row.id,
                            product: row.name,
                            code: row.product_code,
                            unit: row.unit,
                            purchase_price: parseFloat(row.purchase_price),
                            old_quantity: parseFloat(row.quantity),
                            quantity: parseFloat(row.quantity),
                            discount: 0,
                            subtotal: 0,
                        };

                        $scope.cart.push(item);
                    });
                }
            });
        }
    });


    $scope.addNewProductFn = function (productCode) {
        if (typeof productCode !== 'undefined' && productCode != '') {

            if ($scope.checkProductCode.includes(productCode) != true) {

                $http({
                    method: 'POST',
                    url: url + 'result',
                    data: {
                        table: 'materials',
                        cond: {code: productCode, trash: 0}
                    }
                }).success(function (response) {

                    if (response.length > 0) {

                        $scope.checkProductCode.push(response[0].code);

                        var item = {
                            item_id: '',
                            product: response[0].name,
                            code: response[0].code,
                            unit: response[0].unit,
                            purchase_price: parseFloat(response[0].purchase_price),
                            old_quantity: 0,
                            quantity: '',
                            discount: 0,
                            subtotal: 0,
                        };

                        $scope.cart.push(item);
                    }
                });
                $scope.erroeMessage = false;
            } else {
                $scope.erroeMessage = true;
            }
        }
    };


    $scope.setSubtotalFn = function (index) {
        var subtotal = $scope.cart[index].subtotal = $scope.cart[index].purchase_price * $scope.cart[index].quantity;
        return $scope.cart[index].subtotal = Math.abs(subtotal.toFixed(2));
    };

    $scope.totalQuantity = 0;
    $scope.getTotalFn = function () {

        var totalAmount = totalQuantity = 0;

        angular.forEach($scope.cart, function (item) {
            totalAmount += parseFloat(item.subtotal);
            totalQuantity += !isNaN(parseFloat(item.quantity)) ? parseFloat(item.quantity) : 0;
        });

        $scope.totalQuantity = totalQuantity;

        $scope.isDisable = totalQuantity > 0 ? false : true;

        return Math.abs(totalAmount.toFixed(2));
    };

    $scope.deleteItem = [];
    $scope.deleteItemFn = function (index) {

        if ($scope.cart[index].item_id) {
            var alert = confirm('Do you want to delete this data?');
            if (alert) {

                $scope.deleteItem.push({
                    id: $scope.cart[index].item_id,
                    code: $scope.cart[index].code,
                    quantity: $scope.cart[index].old_quantity,
                });

                $scope.checkProductCode.splice(index, 1);
                $scope.cart.splice(index, 1);
            }
        } else {
            $scope.checkProductCode.splice(index, 1);
            $scope.cart.splice(index, 1);
        }
    };
});

// order purchase entry controller
app.controller('orderPurchaseEntryCtrl', function ($scope, $http) {

    $scope.party_code = '';
    $scope.party_name = '';
    $scope.mobile = '';
    $scope.address = '';
    $scope.balance = 0;
    $scope.previous_balance = 0;
    $scope.previous_sign = 'Receivable';

    $scope.cart = [];
    $scope.$watch('orderNo', function (orderNo) {

        $scope.party_code = '';
        $scope.party_name = '';
        $scope.mobile = '';
        $scope.address = '';
        $scope.balance = 0;
        $scope.previous_balance = 0;
        $scope.previous_sign = 'Receivable';

        $scope.cart = [];

        if (typeof orderNo !== 'undefined' && orderNo != '') {

            $http({
                method: 'post',
                url: siteurl + 'purchase/order_purchase/cartList',
                data: {voucher_no: orderNo}
            }).success(function (response) {

                if (typeof response.cart !== "undefined" && response.cart.length > 0) {
                    angular.forEach(response.cart, function (row) {

                        row.purchase_price = parseFloat(row.purchase_price);
                        row.sale_price = parseFloat(row.sale_price);
                        row.dealer_price = parseFloat(row.dealer_price);
                        row.order_quantity = parseFloat(row.order_quantity);
                        row.old_received_quantity = parseFloat(row.old_received_quantity);
                        row.old_remaining_quantity = parseFloat(row.old_remaining_quantity);
                        row.remaining_quantity = parseFloat(row.remaining_quantity);
                        row.quantity = row.quantity;

                        $scope.cart.push(row);
                    });


                    $scope.order_no = response.order_no;
                    $scope.party_code = response.party_code;
                    $scope.party_name = response.name;
                    $scope.mobile = response.mobile;
                    $scope.address = response.address;
                    $scope.balance = Math.abs(parseFloat(response.previous_balance));
                    $scope.previous_balance = parseFloat(response.previous_balance);
                    $scope.previous_sign = response.previous_sign;
                }
            });
        }
    });

    $scope.getReceivedQtyFn = function (index) {
        var quantity = !isNaN(parseFloat($scope.cart[index].quantity)) ? parseFloat($scope.cart[index].quantity) : 0;
        var receivedQuantity = $scope.cart[index].old_received_quantity + quantity;
        return $scope.cart[index].received_quantity = receivedQuantity;
    };
    
    $scope.getRemainingQuantityFn = function (index) {
        var quantity = !isNaN(parseFloat($scope.cart[index].quantity)) ? parseFloat($scope.cart[index].quantity) : 0;
        var remainingQuantity = $scope.cart[index].old_remaining_quantity - quantity;
        return $scope.cart[index].remaining_quantity = remainingQuantity;
    };

    $scope.setSubtotalFn = function (index) {
        var quantity = !isNaN(parseFloat($scope.cart[index].quantity)) ? parseFloat($scope.cart[index].quantity) : 0;
        var subtotal = $scope.cart[index].subtotal = $scope.cart[index].purchase_price * quantity;
        return $scope.cart[index].subtotal = Math.abs(subtotal.toFixed(2));
    };

    $scope.totalQuantity = 0;
    $scope.oldTotalQuantity = 0;
    $scope.getTotalFn = function () {

        var totalAmount = totalQuantity = oldTotalQuantity = 0;

        angular.forEach($scope.cart, function (item) {
            totalAmount += parseFloat(item.subtotal);
            totalQuantity += !isNaN(parseFloat(item.quantity)) ? parseFloat(item.quantity) : 0;
        });

        $scope.totalQuantity = totalQuantity;
        $scope.oldTotalQuantity = oldTotalQuantity;

        $scope.isDisable = totalQuantity > 0 ? false : true;

        return Math.abs(totalAmount.toFixed(2));
    };

    $scope.current_balance = 0;
    $scope.current_sign = 'Receivable';

    // calculate current balance
    $scope.getCurrentTotalFn = function () {

        var payment = !isNaN(parseFloat($scope.payment)) ? parseFloat($scope.payment) : 0;

        var balance = $scope.previous_balance - parseFloat($scope.getTotalFn()) + payment;

        $scope.current_balance = balance;
        $scope.current_sign = (balance < 0 ? "Payable" : "Receivable");


        return Math.abs(balance.toFixed(2));
    };

    $scope.deleteItemFn = function (index) {
        $scope.cart.splice(index, 1);
    };
});


// add purchase entry
app.controller('PurchaseEntry', function ($scope, $http) {

    $scope.cart = [];
    $scope.isDisable = true;

    $scope.partyInfo = {
        name: '',
        mobile: '',
        address: '',
        balance: 0,
        previous_balance: 0,
        current_balance: 0,
        sign: 'Receivable',
        csign: 'Receivable'
    };


    $scope.setPartyfn = function (partyCode) {

        $scope.partyInfo = {
            name: '',
            mobile: '',
            address: '',
            balance: 0,
            previous_balance: 0,
            current_balance: 0,
            sign: 'Receivable',
            csign: 'Receivable'
        };

        if (typeof partyCode !== 'undefined' && partyCode != '') {

            $http({
                method: "POST",
                url: url + "result",
                data: {
                    table: 'parties',
                    cond: {code: partyCode}
                }
            }).success(function (response) {
                console.log(response);
                if (response.length > 0) {

                    $scope.partyInfo.name = response[0].name;
                    $scope.partyInfo.mobile = response[0].mobile;
                    $scope.partyInfo.address = response[0].address;

                    // get supplier balance
                    $http({
                        method: "POST",
                        url: url + "supplier_balance",
                        data: {party_code: response[0].code}
                    }).success(function (balanceRes) {
                        $scope.partyInfo.balance = Math.abs(parseFloat(balanceRes.balance).toFixed(2));
                        $scope.partyInfo.previous_balance = parseFloat(balanceRes.balance);
                        $scope.partyInfo.sign = balanceRes.status;
                    });

                }
            });
        }
    }

    // add product
    $scope.erroeMessage = false;
    $scope.checkProductCode = [];
    $scope.addNewProductFn = function (productCode) {
        if (typeof productCode !== 'undefined' && productCode != '') {
            $scope.active = false;

            if ($scope.checkProductCode.includes(productCode) != true) {


                $http({
                    method: 'POST',
                    url: url + 'result',
                    data: {
                        table: 'materials',
                        cond: {code: productCode, trash: 0}
                    }
                }).success(function (response) {

                    if (response.length > 0) {

                        $scope.checkProductCode.push(response[0].code);

                        var item = {
                            product: response[0].name,
                            code: response[0].code,
                            unit: response[0].unit,
                            purchase_price: parseFloat(response[0].purchase_price),
                            sale_price: parseFloat(response[0].sale_price),
                            quantity: '',
                            discount: 0,
                            subtotal: 0,
                            godown: 1
                        };
                        $scope.cart.push(item);
                    } else {
                        $scope.cart = [];
                    }
                });
                $scope.erroeMessage = false;
            } else {
                $scope.erroeMessage = true;
            }

        }
    }


    $scope.setSubtotalFn = function (index) {
        var total = $scope.cart[index].subtotal = $scope.cart[index].purchase_price * $scope.cart[index].quantity;
        return $scope.cart[index].subtotal = Math.abs(total.toFixed(2));
    }

    $scope.totalQuantity = 0;
    $scope.getTotalFn = function () {

        var totalAmount = totalQuantity = 0;

        angular.forEach($scope.cart, function (item) {
            totalAmount += parseFloat(item.subtotal);
            totalQuantity += !isNaN(parseFloat(item.quantity)) ? parseFloat(item.quantity) : 0;
        });

        $scope.totalQuantity = totalQuantity;

        return Math.abs(totalAmount.toFixed(2));
    }

    $scope.getTotalDiscountFn = function () {
        var totalDiscount = 0;
        angular.forEach($scope.cart, function (item) {
            totalDiscount += parseFloat(item.discount);
        });
        return Math.abs(totalDiscount.toFixed(2));
    }

    $scope.getGrandTotalFn = function () {
        var transportCost = (!isNaN(parseFloat($scope.transportCost)) ? parseFloat($scope.transportCost) : 0);
        var grandTotal = parseFloat($scope.getTotalFn()) + transportCost - parseFloat($scope.getTotalDiscountFn());
        return Math.abs(grandTotal.toFixed(2));
    }

    $scope.getCurrentTotalFn = function () {

        var payment = (!isNaN(parseFloat($scope.payment)) ? parseFloat($scope.payment) : 0);

        var balance = $scope.partyInfo.previous_balance - parseFloat($scope.getGrandTotalFn()) + payment;

        $scope.partyInfo.sign = (balance < 0 ? 'Payable' : 'Receivable');
        $scope.partyInfo.current_balance = balance;

        $scope.isDisable = ($scope.totalQuantity > 0 ? false : true);

        return Math.abs(balance.toFixed(2));
    }

    $scope.deleteItemFn = function (index) {
        $scope.checkProductCode.splice(index, 1);
        $scope.cart.splice(index, 1);
    }

});


// add purchase return controller
app.controller('addPurchaseReturn', function ($scope, $http) {

    $scope.cart = [];
    $scope.active = false;


    // initialize party info
    $scope.partyInfo = {
        name: '',
        mobile: '',
        address: '',
        balance: 0,
        previous_balance: 0,
        current_balance: 0,
        sign: 'Receivable',
        csign: 'Receivable'
    };

    // get party info and balance
    $scope.findPartyFn = function (partyCode) {

        $scope.partyInfo = {
            name: '',
            mobile: '',
            address: '',
            balance: 0,
            previous_balance: 0,
            current_balance: 0,
            sign: 'Receivable',
            csign: 'Receivable'
        };

        if (typeof partyCode != 'undefined' && partyCode != '') {

            var test = {
                table: 'parties',
                cond: {code: partyCode, type: 'supplier'},
                select: ['code', 'name', 'mobile', 'address']
            };

            $http({
                method: 'POST',
                url: url + 'result',
                data: test
            }).success(function (partyRes) {
                if (partyRes.length > 0) {

                    // gat party information
                    $scope.partyInfo.name = partyRes[0].name;
                    $scope.partyInfo.mobile = partyRes[0].mobile;
                    $scope.partyInfo.address = partyRes[0].address;

                    // gat party balance
                    $http({
                        method: 'POST',
                        url: url + 'supplier_balance',
                        data: {party_code: partyRes[0].code}
                    }).success(function (balanceRes) {
                        $scope.partyInfo.balance = Math.abs(parseFloat(balanceRes.balance));
                        $scope.partyInfo.previous_balance = parseFloat(balanceRes.balance);
                        $scope.partyInfo.sign = balanceRes.status;
                    });
                }
            });
        }
    }


    // add product in the card
    $scope.productCodeList = [];
    $scope.addNewProductFn = function (productCode) {
        if (typeof productCode !== 'undefined' && $scope.productCodeList.indexOf(productCode) == '-1') {

            $http({
                method: 'POST',
                url: url + 'result',
                data: {
                    table: 'stock',
                    cond: {
                        code: productCode,
                        type: 'raw'
                    },
                }
            }).success(function (response) {

                if (response.length > 0) {

                    // push product code for check this product exists
                    $scope.productCodeList.push(productCode);
                    $scope.active = false;

                    angular.forEach(response, function (item) {
                        var newItem = {
                            product_name: item.name,
                            product_code: item.code,
                            weight: item.weight,
                            stock_qty: parseInt(item.quantity),
                            quantity: '',
                            unit: item.unit,
                            purchase_price: parseFloat(item.purchase_price),
                            sale_price: parseFloat(item.sell_price),
                            subtotal: 0,
                        };
                        $scope.cart.push(newItem);
                    });
                }
            });
        } else {
            $scope.active = true;
        }
    }


    // get calculate total weight
    $scope.calculateWeight = function (i) {
        $scope.cart[i].total_weight = parseFloat($scope.cart[i].weight) * parseFloat($scope.cart[i].quantity);
        return $scope.cart[i].total_weight;
    };


    // get product wise sub total for purchase
    $scope.purchaseSubtotalFn = function (index) {
        var total = 0;
        total = $scope.cart[index].purchase_price * $scope.cart[index].quantity;
        $scope.cart[index].purchase_subtotal = Math.abs(total.toFixed(2));
        return $scope.cart[index].purchase_subtotal;
    }


    // get product wise sub total for sale
    $scope.setSubtotalFn = function (index) {
        var total = 0;
        total = $scope.cart[index].purchase_price * $scope.cart[index].quantity;
        $scope.cart[index].subtotal = Math.abs(total.toFixed(2));

        console.log($scope.cart[index].subtotal);
        return $scope.cart[index].subtotal;
    }


    // get total amount
    $scope.totalQuantity = 0;
    $scope.getTotalFn = function () {
        var totalAmount = totalQuantity = 0;
        angular.forEach($scope.cart, function (item) {
            totalAmount += parseFloat(item.subtotal);
            totalQuantity += !isNaN(parseFloat(item.quantity)) ? parseFloat(item.quantity) : 0;
        });
        $scope.totalQuantity = totalQuantity;

        return Math.abs(totalAmount.toFixed(2));
    }


    // calculate current balance
    $scope.getCurrentTotalFn = function () {

        var balance = parseFloat($scope.getTotalFn()) + $scope.partyInfo.previous_balance;

        $scope.partyInfo.csign = (balance < 0 ? "Payable" : "Receivable");
        $scope.partyInfo.current_balance = balance;

        return Math.abs(balance.toFixed(2));
    }


    // delete item in the card
    $scope.deleteItemFn = function (index) {
        $scope.cart.splice(index, 1);
        $scope.productCodeList.splice(index, 1);
    }
});


// add raw damage controller
app.controller('RawDamageAddController', function ($scope, $http) {

    $scope.cart = [];
    $scope.active = {
        party: false,
        product: false,
    };
    $scope.currentBalance = 0;

    // initialize variable
    $scope.amount = {
        total_quantity: 0,
        purchase_total: 0,
        sale_total: 0,
        current_balance: 0,
        paid: 0,
    }


    // add product in the card
    $scope.productCodeList = [];
    $scope.addNewProductFn = function (productCode) {

        if (typeof productCode !== 'undefined' && $scope.productCodeList.indexOf(productCode) == '-1') {

            $http({
                method: 'POST',
                url: url + 'result',
                data: {
                    table: 'stock',
                    cond: {
                        code: productCode,
                        type: 'raw'
                    }
                }
            }).success(function (response) {

                if (response.length > 0) {

                    console.log(response);

                    // push product code for check this product exists
                    $scope.productCodeList.push(productCode);
                    $scope.active.party = false;
                    $scope.active.product = false;

                    angular.forEach(response, function (item) {
                        var newItem = {
                            product_name: item.name,
                            product_code: item.code,
                            godown: item.godown,
                            maxQuantity: parseInt(item.quantity),
                            stock_qty: parseInt(item.quantity),
                            quantity: '',
                            unit: item.unit,
                            subtotal: 0,
                            purchase_price: parseFloat(item.purchase_price),
                            sale_price: parseFloat(item.sell_price),
                        };
                        $scope.cart.push(newItem);
                    });
                }
            });
        } else {
            $scope.active.product = true;
        }
    }

    // get product wise sub total for purchase
    $scope.purchaseSubtotalFn = function (index) {
        $scope.cart[index].purchase_subtotal = $scope.cart[index].purchase_price * $scope.cart[index].quantity;
        return $scope.cart[index].purchase_subtotal.toFixed();
    }

    // get product wise sub total for sale
    $scope.setSubtotalFn = function (index) {
        $scope.cart[index].subtotal = $scope.cart[index].purchase_price * $scope.cart[index].quantity;
        return $scope.cart[index].subtotal.toFixed();
    }

    // get total return quantity
    $scope.getTotalQtyFn = function () {
        var total = 0;
        angular.forEach($scope.cart, function (item) {
            total += (typeof parseFloat(item.quantity) !== "undefined" && item.quantity != "") ? parseFloat(item.quantity) : 0;
        });

        $scope.amount.total_quantity = total;
        return $scope.amount.total_quantity;
    }

    // get total purchase amount
    $scope.getPurchaseTotalFn = function () {
        var total = 0;
        angular.forEach($scope.cart, function (item) {
            total += parseFloat(item.purchase_subtotal);
        });

        $scope.amount.purchase_total = total.toFixed();
        return $scope.amount.purchase_total;
    }

    // get total return amount
    $scope.getTotalFn = function () {
        var total = 0;
        angular.forEach($scope.cart, function (item) {
            total += parseFloat(item.subtotal);
        });

        $scope.amount.sale_total = total.toFixed();
        return $scope.amount.sale_total;
    }


    // delete item in the card
    $scope.deleteItemFn = function (index) {
        $scope.cart.splice(index, 1);
        $scope.productCodeList.splice(index, 1);
    }
});


// packaging purchase entry
app.controller('PackagingPurchaseEntry', function ($scope, $http) {
    $scope.active = true;
    $scope.cart = [];
    $scope.amount = {
        total: 0,
        totalDiscount: 0,
        grandTotal: 0,
        paid: 0,
        due: 0
    };

    $scope.validation = true;

    /*$scope.exists = function(voucherNo) {

        $scope.validation = true;

        if (typeof voucherNo !== 'undefined' && voucherNo != ''){
            $http({
                method: "POST",
                url: url + "result",
                data: {
                    table: "saprecords",
                    cond: { voucher_no: voucherNo, trash: '0' },
                    select: ['voucher_no']
                }
            }).success(function(response) {
                if (response.length > 0) {
                    $scope.validation = true;
                }else{
                    $scope.validation = false;
                }
            });
        }
    };*/

    $scope.partyInfo = {
        mobile: '',
        balance: 0,
        payment: 0,
        sign: 'Receivable',
        csign: 'Receivable'
    };


    $scope.setPartyfn = function () {

        var condition = {
            from: 'parties',
            join: 'partybalance',
            cond: 'parties.code=partybalance.code',
            where: {'parties.code': $scope.partyCode}
        };

        $http({
            method: "POST",
            url: url + "readJoinData",
            data: condition
        }).success(function (response) {
            if (response.length > 0) {

                $scope.partyInfo.mobile = response[0].mobile;

                // get supplier balance
                $http({
                    method: "POST",
                    url: url + "supplier_balance",
                    data: {party_code: response[0].code}
                }).success(function (balanceRes) {
                    $scope.partyInfo.balance = Math.abs(parseFloat(balanceRes.balance).toFixed(2));
                    $scope.partyInfo.previous_balance = parseFloat(balanceRes.balance);
                    $scope.partyInfo.sign = balanceRes.status;
                });

            }
        });
    }

    // add product
    $scope.erroeMessage = false;
    $scope.checkProductCode = [];
    $scope.addNewProductFn = function () {
        if (typeof $scope.product !== 'undefined') {
            $scope.active = false;

            if ($scope.checkProductCode.includes($scope.product) != true) {

                var condition = {
                    table: 'materials',
                    cond: {
                        code: $scope.product,
                        status: 'available',
                        type: 'raw',
                        trash: 0
                    }
                };

                $http({
                    method: 'POST',
                    url: url + 'read',
                    data: condition
                }).success(function (response) {
                    if (response.length > 0) {
                        $scope.checkProductCode.push(response[0].code);

                        var name = response[0].name;
                        var str = name.replace(/_/gi, " ").toLowerCase();
                        name = str.replace(/\b[a-z]/g, function (letter) {
                            return letter.toUpperCase();
                        });

                        var item = {
                            product: name,
                            product_code: response[0].code,
                            price: parseFloat(response[0].price),
                            quantity: (typeof $scope.quantity === 'undefined') ? 0 : $scope.quantity,
                            discount: 0,
                            subtotal: 0,
                            godown: 1
                        };
                        $scope.cart.push(item);
                    } else {
                        $scope.cart = [];
                    }
                });
                $scope.erroeMessage = false;
            } else {
                $scope.erroeMessage = true;
            }

        }
    }


    $scope.setSubtotalFn = function (index) {
        var total = $scope.cart[index].subtotal = $scope.cart[index].price * $scope.cart[index].quantity;
        return $scope.cart[index].subtotal = Math.abs(total.toFixed(2));
    }

    $scope.total_quantity = 0;
    $scope.getTotalFn = function () {
        var total = totalQty = 0;
        angular.forEach($scope.cart, function (item) {
            total += parseFloat(item.subtotal);
            totalQty += !isNaN(parseFloat(item.quantity)) ? parseFloat(item.quantity) : 0;
        });

        $scope.total_quantity = totalQty;
        $scope.amount.total = total.toFixed(2);
        return $scope.amount.total;
    }

    $scope.getTotalDiscountFn = function () {
        var total = 0;
        angular.forEach($scope.cart, function (item) {
            total += parseFloat(item.discount);
        });

        $scope.amount.totalDiscount = total.toFixed(2);
        return $scope.amount.totalDiscount;
    }

    $scope.transport_code = '';
    $scope.getGrandTotalFn = function () {
        var transport_cost = (!isNaN(parseFloat($scope.transport_code)) ? parseFloat($scope.transport_code) : 0);
        $scope.amount.grandTotal = parseFloat($scope.amount.total) + parseFloat(transport_cost) - parseFloat($scope.amount.totalDiscount);
        return $scope.amount.grandTotal.toFixed(2);
    }

    $scope.getTotalDueFn = function () {
        $scope.amount.due = $scope.amount.grandTotal - $scope.amount.paid;
        return $scope.amount.due.toFixed(2);
    }

    $scope.getCurrentTotalFn = function () {
        var payment = (!isNaN(parseFloat($scope.amount.paid)) ? parseFloat($scope.amount.paid) : 0);

        var balance = $scope.partyInfo.previous_balance - parseFloat($scope.amount.grandTotal) + payment;

        $scope.partyInfo.sign = (balance < 0 ? 'Payable' : 'Receivable');

        $scope.validation = ($scope.total_quantity > 0 ? false : true);

        return Math.abs(balance.toFixed(2));
    }

    $scope.deleteItemFn = function (index) {
        $scope.checkProductCode.splice(index, 1);
        $scope.cart.splice(index, 1);
    }

});


// machinery purchase entry
app.controller('machineryPurchaseEntry', function ($scope, $http) {
    $scope.active = true;
    $scope.cart = [];
    $scope.amount = {
        total: 0,
        totalDiscount: 0,
        grandTotal: 0,
        paid: 0,
        due: 0
    };
    $scope.validation = true;

    /*$scope.exists = function(voucherNo) {

        $scope.validation = true;

        if (typeof voucherNo !== 'undefined' && voucherNo != ''){
            $http({
                method: "POST",
                url: url + "result",
                data: {
                    table: "saprecords",
                    cond: { voucher_no: voucherNo, trash: '0' },
                    select: ['voucher_no']
                }
            }).success(function(response) {
                if (response.length > 0) {
                    $scope.validation = true;
                }else{
                    $scope.validation = false;
                }
            });
        }
    };*/

    $scope.partyInfo = {
        mobile: '',
        balance: 0,
        previous_balance: 0,
        payment: 0,
        sign: 'Receivable',
        csign: 'Receivable'
    };

    $scope.setPartyfn = function () {

        var condition = {
            from: 'parties',
            join: 'partybalance',
            cond: 'parties.code=partybalance.code',
            where: {'parties.code': $scope.partyCode}
        };

        $http({
            method: "POST",
            url: url + "readJoinData",
            data: condition
        }).success(function (response) {
            if (response.length > 0) {

                $scope.partyInfo.mobile = response[0].mobile;

                // get supplier balance
                $http({
                    method: "POST",
                    url: url + "supplier_balance",
                    data: {party_code: response[0].code}
                }).success(function (balanceRes) {
                    $scope.partyInfo.balance = Math.abs(parseFloat(balanceRes.balance).toFixed(2));
                    $scope.partyInfo.previous_balance = parseFloat(balanceRes.balance);
                    $scope.partyInfo.sign = balanceRes.status;
                });

            }
        });
    }

    // add product
    $scope.erroeMessage = false;
    $scope.checkProductCode = [];
    $scope.addNewProductFn = function () {
        if (typeof $scope.product !== 'undefined') {
            $scope.active = false;

            if ($scope.checkProductCode.includes($scope.product) != true) {

                var condition = {
                    table: 'materials',
                    cond: {
                        code: $scope.product,
                        status: 'available',
                        type: 'raw',
                        trash: 0
                    }
                };

                $http({
                    method: 'POST',
                    url: url + 'read',
                    data: condition
                }).success(function (response) {
                    if (response.length > 0) {
                        $scope.checkProductCode.push(response[0].code);

                        var name = response[0].name;
                        var str = name.replace(/_/gi, " ").toLowerCase();
                        name = str.replace(/\b[a-z]/g, function (letter) {
                            return letter.toUpperCase();
                        });

                        var item = {
                            product: name,
                            product_code: response[0].code,
                            price: parseFloat(response[0].price),
                            quantity: (typeof $scope.quantity === 'undefined') ? 0 : $scope.quantity,
                            discount: 0,
                            subtotal: 0,
                            godown: 1
                        };
                        $scope.cart.push(item);
                    } else {
                        $scope.cart = [];
                    }
                });
                $scope.erroeMessage = false;
            } else {
                $scope.erroeMessage = true;
            }

        }
    }


    $scope.setSubtotalFn = function (index) {
        var total = $scope.cart[index].subtotal = $scope.cart[index].price * $scope.cart[index].quantity;
        return $scope.cart[index].subtotal = Math.abs(total.toFixed(2));
    }

    $scope.total_quantity = 0;
    $scope.getTotalFn = function () {
        var total = totalQty = 0;
        angular.forEach($scope.cart, function (item) {
            total += parseFloat(item.subtotal);
            totalQty += !isNaN(parseFloat(item.quantity)) ? parseFloat(item.quantity) : 0;
        });

        $scope.total_quantity = totalQty;

        $scope.amount.total = total.toFixed(2);
        return $scope.amount.total;
    }

    $scope.getTotalDiscountFn = function () {
        var total = 0;
        angular.forEach($scope.cart, function (item) {
            total += parseFloat(item.discount);
        });

        $scope.amount.totalDiscount = total.toFixed(2);
        return $scope.amount.totalDiscount;
    }

    $scope.transport_code = '';
    $scope.getGrandTotalFn = function () {
        var transport_cost = (!isNaN(parseFloat($scope.transport_code)) ? parseFloat($scope.transport_code) : 0);
        $scope.amount.grandTotal = parseFloat($scope.amount.total) + parseFloat(transport_cost) - parseFloat($scope.amount.totalDiscount);
        return $scope.amount.grandTotal.toFixed(2);
    }

    $scope.getTotalDueFn = function () {
        $scope.amount.due = $scope.amount.grandTotal - $scope.amount.paid;
        return $scope.amount.due.toFixed(2);
    }

    $scope.getCurrentTotalFn = function () {

        var payment = (!isNaN(parseFloat($scope.amount.paid)) ? parseFloat($scope.amount.paid) : 0);

        var balance = $scope.partyInfo.previous_balance - parseFloat($scope.amount.grandTotal) + payment;

        $scope.partyInfo.sign = (balance < 0 ? 'Payable' : 'Receivable');

        $scope.validation = ($scope.total_quantity > 0 ? false : true);

        return Math.abs(balance.toFixed(2));
    }

    $scope.deleteItemFn = function (index) {
        $scope.checkProductCode.splice(index, 1);
        $scope.cart.splice(index, 1);
    }

});


// Make recipeCtrl
app.controller('makeRecipeCtrl', function ($scope, $http) {

    $scope.cart = [];
    $scope.flower = '';
    $scope.totalRawMaterials = 0;
    $scope.totalCost = 0;
    $scope.totalWastageRation = 0;
    $scope.totalWastage = 0;
    $scope.totalProduction = 0;
    $scope.action = true;

    $scope.addRecipeItemFn = function () {

        if (typeof $scope.flower !== 'undefined' && $scope.flower > 0 && typeof $scope.category_code !== 'undefined') {

            $scope.$watch('flower', function (flower) {

                // get stock and formula 
                var condition = {
                    tableFrom: 'stock',
                    tableTo: ['tbl_formula'],
                    joinCond: ['tbl_formula.product_code=stock.code'],
                    cond: {
                        "stock.type": "raw",
                        "tbl_formula.category_code": $scope.category_code,
                    },
                    order_col: 'tbl_formula.id',
                    select: ['stock.code', 'stock.quantity', 'stock.godown', 'stock.purchase_price', 'stock.name', 'stock.unit', 'tbl_formula.category_code', 'tbl_formula.ration', 'tbl_formula.wastage']
                };

                $http({
                    method: 'POST',
                    url: url + 'join',
                    data: condition
                }).success(function (response) {
                    $scope.cart = [];

                    var total = {
                        totalRawMaterials: 0,
                        totalCost: 0,
                        totalWastageRation: 0,
                        totalWastage: 0,
                        totalProduction: 0,
                    };

                    if (response.length > 0) {
                        angular.forEach(response, function (item) {

                            var total_quantity = (parseFloat($scope.flower) * parseFloat(item.ration)) / 100;
                            var total_wastage = (parseFloat(total_quantity) * parseFloat(item.wastage)) / 100;
                            var total_costing = Math.abs((parseFloat(item.purchase_price) * parseFloat(total_quantity)).toFixed(2));
                            var total_production = Math.abs((parseFloat(total_quantity) - parseFloat(total_wastage)).toFixed(2));

                            total.totalRawMaterials += parseFloat(total_quantity);
                            total.totalCost += parseFloat(total_costing);
                            total.totalWastageRation += parseFloat(item.wastage);
                            total.totalWastage += parseFloat(total_wastage);
                            total.totalProduction += parseFloat(total_production);

                            var newItem = {
                                unit: item.unit,
                                godown: item.godown,
                                product: item.name,
                                product_code: item.code,
                                purchase_price: Math.abs(parseFloat(item.purchase_price).toFixed(2)),
                                maxQuantity: Math.abs(parseFloat(item.quantity).toFixed(2)),
                                stock_qty: Math.abs(parseFloat(item.quantity).toFixed(2)),
                                ration: parseFloat(item.ration).toFixed(5),
                                total_quantity: parseFloat(total_quantity).toFixed(5),
                                total_costing: total_costing,
                                wastage: Math.abs(parseFloat(item.wastage).toFixed(2)),
                                total_wastage: Math.abs(total_wastage.toFixed(2)),
                                total_production: total_production
                            };

                            $scope.cart.push(newItem);
                        });

                        // active submit button
                        $scope.action = false;

                        // get total
                        $scope.totalRawMaterials = Math.abs(total.totalRawMaterials.toFixed(3));
                        $scope.totalCost = Math.abs(total.totalCost.toFixed(2));
                        $scope.totalWastageRation = Math.abs((total.totalWastage * 100 / total.totalRawMaterials).toFixed(2));
                        $scope.totalWastage = Math.abs(total.totalWastage.toFixed(2));
                        $scope.totalProduction = Math.abs(total.totalProduction.toFixed(2));

                    } else {
                        $scope.action = true;
                    }
                });

            })

        }
    }

});

// pending recipeCtrl
app.controller('pendingRecipeCtrl', function ($scope, $http) {

    $scope.cart = [];
    $scope.flower = '';
    $scope.category_code = '';
    $scope.totalRawMaterials = 0;
    $scope.totalCost = 0;
    $scope.totalWastageRation = 0;
    $scope.totalWastage = 0;
    $scope.totalProduction = 0;
    $scope.action = true;


    $scope.addRecipeFn = function () {
        var recWhere = {
            table: 'pending_recipe',
            cond: {id: $scope.id}
        }
        $http({
            method: 'POST',
            url: url + 'result',
            data: recWhere
        }).success(function (recResponse) {
            if (recResponse.length > 0) {
                $scope.flower = recResponse[0].total_weight;
                $scope.category_code = recResponse[0].category_code;
            } else {
                $scope.flower = '';
                $scope.category_code = '';
            }
        });
    }

    $scope.$watch('flower', function (flower) {

        if (typeof flower !== 'undefined' && flower > 0 && typeof $scope.category_code !== 'undefined') {

            // get stock and formula
            var condition = {
                tableFrom: 'stock',
                tableTo: ['tbl_formula'],
                joinCond: ['tbl_formula.product_code=stock.code'],
                cond: {
                    "stock.type": "raw",
                    "tbl_formula.category_code": $scope.category_code,
                },
                order_col: 'tbl_formula.id',
                select: ['stock.code', 'stock.quantity', 'stock.godown', 'stock.purchase_price', 'stock.name', 'stock.unit', 'tbl_formula.category_code', 'tbl_formula.ration', 'tbl_formula.wastage']
            };

            $http({
                method: 'POST',
                url: url + 'join',
                data: condition
            }).success(function (response) {
                $scope.cart = [];

                var total = {
                    totalRawMaterials: 0,
                    totalCost: 0,
                    totalWastageRation: 0,
                    totalWastage: 0,
                    totalProduction: 0,
                };

                if (response.length > 0) {
                    angular.forEach(response, function (item) {
                        var total_quantity = (parseFloat($scope.flower) * parseFloat(item.ration)) / 100;
                        var total_wastage = (parseFloat(total_quantity) * parseFloat(item.wastage)) / 100;
                        var total_costing = Math.abs((parseFloat(item.purchase_price) * parseFloat(total_quantity)).toFixed(2));
                        var total_production = Math.abs((parseFloat(total_quantity) - parseFloat(total_wastage)).toFixed(2));

                        total.totalRawMaterials += parseFloat(total_quantity);
                        total.totalCost += parseFloat(total_costing);
                        total.totalWastageRation += parseFloat(item.wastage);
                        total.totalWastage += parseFloat(total_wastage);
                        total.totalProduction += parseFloat(total_production);

                        var newItem = {
                            unit: item.unit,
                            godown: item.godown,
                            product: item.name,
                            product_code: item.code,
                            purchase_price: Math.abs(parseFloat(item.purchase_price).toFixed(2)),
                            maxQuantity: Math.abs(parseFloat(item.quantity).toFixed(2)),
                            stock_qty: Math.abs(parseFloat(item.quantity).toFixed(2)),
                            ration: parseFloat(item.ration).toFixed(5),
                            total_quantity: parseFloat(total_quantity).toFixed(5),
                            total_costing: total_costing,
                            wastage: Math.abs(parseFloat(item.wastage).toFixed(5)),
                            total_wastage: Math.abs(total_wastage.toFixed(5)),
                            total_production: total_production
                        };

                        $scope.cart.push(newItem);
                    });

                    // active submit button
                    $scope.action = false;

                    // get total
                    $scope.totalRawMaterials = Math.abs(total.totalRawMaterials.toFixed(3));
                    $scope.totalCost = Math.abs(total.totalCost.toFixed(2));
                    $scope.totalWastageRation = Math.abs((total.totalWastage * 100 / total.totalRawMaterials).toFixed(2));
                    $scope.totalWastage = Math.abs(total.totalWastage.toFixed(2));
                    $scope.totalProduction = Math.abs(total.totalProduction.toFixed(2));

                } else {
                    $scope.action = true;
                }
            });
        }
    });
});

// Edit recipeCtrl
app.controller('editRecipeCtrl', function ($scope, $http) {

    $scope.cart = [];
    $scope.flower = 0;
    $scope.totalRawMaterials = 0;
    $scope.totalCost = 0;
    $scope.totalWastageRation = 0;
    $scope.totalWastage = 0;
    $scope.totalProduction = 0;
    $scope.action = true;


    $scope.$watch('flower', function (flower) {

        if (typeof $scope.flower !== 'undefined' && $scope.flower > 0) {

            $scope.action = false;

            // get stock and formula 
            var condition = {
                tableFrom: 'stock',
                tableTo: ['tbl_formula'],
                joinCond: ['tbl_formula.product_code = stock.code'],
                cond: {
                    "stock.type": "raw",
                    "tbl_formula.category_code": $scope.category_code,
                },
                select: ['stock.code', 'stock.quantity', 'stock.godown', 'stock.purchase_price', 'stock.name', 'stock.unit', 'tbl_formula.category_code', 'tbl_formula.ration', 'tbl_formula.wastage']
            };

            $http({
                method: 'POST',
                url: url + 'join',
                data: condition
            }).success(function (response) {

                $scope.cart = [];

                var total = {
                    totalRawMaterials: 0,
                    totalCost: 0,
                    totalWastageRation: 0,
                    totalWastage: 0,
                    totalProduction: 0,
                };

                angular.forEach(response, function (item) {
                    var total_quantity = (parseFloat($scope.flower) * parseFloat(item.ration)) / 100;
                    var total_wastage = (parseFloat(total_quantity) * parseFloat(item.wastage)) / 100;
                    var total_costing = Math.abs((parseFloat(item.purchase_price) * parseFloat(total_quantity)).toFixed(2));
                    var total_production = Math.abs((parseFloat(total_quantity) - parseFloat(total_wastage)).toFixed(2));

                    total.totalRawMaterials += parseFloat(total_quantity);
                    total.totalCost += parseFloat(total_costing);
                    total.totalWastageRation += parseFloat(item.wastage);
                    total.totalWastage += parseFloat(total_wastage);
                    total.totalProduction += parseFloat(total_production);

                    var newItem = {
                        unit: item.unit,
                        godown: item.godown,
                        product: item.name,
                        product_code: item.code,
                        purchase_price: Math.abs(parseFloat(item.purchase_price).toFixed(2)),
                        maxQuantity: Math.abs(parseFloat(item.quantity).toFixed(2)),
                        stock_qty: Math.abs(parseFloat(item.quantity).toFixed(2)),
                        ration: parseFloat(item.ration).toFixed(5),
                        total_quantity: parseFloat(total_quantity).toFixed(5),
                        total_costing: total_costing,
                        wastage: Math.abs(parseFloat(item.wastage).toFixed(5)),
                        total_wastage: Math.abs(total_wastage.toFixed(5)),
                        total_production: total_production
                    };

                    $scope.cart.push(newItem);

                });


                // get total
                $scope.totalRawMaterials = total.totalRawMaterials.toFixed(3);
                $scope.totalCost = Math.abs(total.totalCost.toFixed(2));
                $scope.totalWastageRation = Math.abs((total.totalWastage * 100 / total.totalRawMaterials).toFixed(2));
                $scope.totalWastage = Math.abs(total.totalWastage.toFixed(2));
                $scope.totalProduction = Math.abs(total.totalProduction.toFixed(2));
            });


        }
    })
});


app.controller('makeFormulaCtrl', function ($scope, $http) {

    $scope.active = true;
    $scope.erroeMessage = false;
    $scope.cart = [];
    $scope.codeArray = [];

    $scope.addNewProductFn = function () {

        if (typeof $scope.product !== 'undefined') {

            $scope.active = false;

            // check exists
            if ($scope.codeArray.includes($scope.product) != true) {

                var condition = {
                    table: 'materials',
                    cond: {
                        code: $scope.product,
                        type: 'raw',
                        status: "available"
                    }
                };

                $http({
                    method: 'POST',
                    url: url + 'read',
                    data: condition
                }).success(function (response) {

                    $scope.codeArray.push(response[0].code);

                    if (response.length > 0) {
                        var name = response[0].name;
                        var str = name.replace(/_/gi, " ").toLowerCase();
                        name = str.replace(/\b[a-z]/g, function (letter) {
                            return letter.toUpperCase();
                        });

                        var item = {
                            product: name,
                            product_code: response[0].code,
                            price: parseFloat(response[0].price),
                            unit: response[0].unit,
                            ration: '',
                            wastage: 0
                        };

                        $scope.cart.push(item);
                    }
                });

                $scope.erroeMessage = false;
            } else {
                $scope.erroeMessage = true;
            }
        }
    }

    $scope.deleteItemFn = function (index) {

        $scope.codeArray.splice(index, 1);
        $scope.cart.splice(index, 1);
    }

});


// editFormulaCtrl
app.controller('editFormulaCtrl', function ($scope, $http) {
    $scope.records = [];
    $scope.codeArray = [];

    $scope.$watch('category_code', function (category_code) {

        if ($scope.codeArray.includes($scope.product) != true) {

            // get all datat
            var transmit = {
                tableFrom: 'tbl_formula',
                tableTo: ['materials', 'category'],
                joinCond: ['materials.code=tbl_formula.product_code', 'category.code=tbl_formula.category_code'],
                cond: {
                    'tbl_formula.category_code': category_code,
                    'materials.type': 'raw',
                    'materials.status': 'available',
                    'tbl_formula.trash': 0
                },
                select: ['tbl_formula.*', 'materials.code', 'materials.name', 'materials.unit', 'category.category as category_name'],
                order_col: 'tbl_formula.id'
            };


            $http({
                method: 'POST',
                url: url + 'join',
                data: transmit
            }).success(function (response) {
                if (response.length > 0) {
                    angular.forEach(response, function (row, index) {

                        $scope.codeArray.push(row.code);

                        row['sl'] = index + 1;
                        row['ration'] = parseFloat(row.ration);
                        row['wastage'] = parseFloat(row.wastage);
                        row['purchase_price'] = parseFloat(row.purchase_price);
                        $scope.records.push(row);
                    });

                }

            });
            $scope.erroeMessage = false;
        } else {
            $scope.erroeMessage = true;
        }

        // add new item
        $scope.addNewProductFn = function () {
            if (typeof $scope.product !== 'undefined') {

                if ($scope.codeArray.includes($scope.product) != true) {
                    var condition = {
                        table: 'materials',
                        cond: {
                            trash: 0,
                            type: 'raw',
                            status: "available",
                            code: $scope.product
                        }
                    };

                    $http({
                        method: 'POST',
                        url: url + 'read',
                        data: condition
                    }).success(function (response) {

                        if (response.length > 0) {

                            $scope.codeArray.push(response[0].code);

                            var item = {
                                name: response[0].name,
                                code: response[0].code,
                                purchase_price: parseFloat(response[0].price),
                                unit: response[0].unit,
                                ration: '',
                                wastage: ''
                            };

                            $scope.records.push(item);
                        }
                    });
                    $scope.erroeMessage = false;
                } else {
                    $scope.erroeMessage = true;
                }
            }
        }


        // delete data
        $scope.deleteItemFn = function (index) {

            $scope.codeArray.splice(index, 1);

            if (typeof $scope.records[index].category_code !== 'undefined' && typeof $scope.records[index].code !== 'undefined') {

                var condition = {
                    table: 'tbl_formula',
                    cond: {
                        product_code: $scope.records[index].code,
                        category_code: $scope.records[index].category_code,
                    }
                };

                $http({
                    method: 'POST',
                    url: url + 'delete',
                    data: condition
                }).success(function (response) {
                    console.log('Delete data');
                });

                $scope.records.splice(index, 1);

            } else {
                $scope.records.splice(index, 1);
            }
        }

    });

});


// Edit Purchase Entry
app.controller('EditPurchaseEntry', function ($scope, $http) {
    $scope.cart = [];
    $scope.isDisable = true;

    $scope.$watch('voucherNo', function (voucherNo) {
        console.log('voucher', voucherNo)

        if (typeof voucherNo !== 'undefined' && voucherNo != '') {

            $http({
                method: 'post',
                url: url + 'join',
                data: {
                    tableFrom: 'sapitems',
                    tableTo: 'materials',
                    joinCond: 'sapitems.product_code=materials.code',
                    cond: {
                        'sapitems.voucher_no': voucherNo,
                        'sapitems.trash': 0,
                    },
                    select: ['sapitems.*', 'materials.name']
                }
            }).success(function (response) {
                console.log('response', response);

                if (response.length > 0) {
                    angular.forEach(response, function (row) {
                        var item = {
                            item_id: row.id,
                            product: row.name,
                            unit: row.unit,
                            code: row.product_code,
                            purchase_price: parseFloat(row.purchase_price),
                            sale_price: parseFloat(row.sale_price),
                            old_quantity: parseFloat(row.quantity),
                            quantity: parseFloat(row.quantity),
                            discount: parseFloat(row.discount),
                            subtotal: 0,
                            godown: 1
                        };

                        $scope.cart.push(item);
                    })
                }
            })


        }
    });


    $scope.partyInfo = {
        name: '',
        mobile: '',
        address: '',
        balance: 0,
        previous_balance: 0,
        current_balance: 0,
        sign: 'Receivable',
        csign: 'Receivable'
    };


    $scope.setPartyfn = function (partyCode) {

        $scope.partyInfo = {
            name: '',
            mobile: '',
            address: '',
            balance: 0,
            previous_balance: 0,
            current_balance: 0,
            sign: 'Receivable',
            csign: 'Receivable'
        };

        if (typeof partyCode !== 'undefined' && partyCode != '') {

            $http({
                method: "POST",
                url: url + "result",
                data: {
                    table: 'parties',
                    cond: {code: partyCode}
                }
            }).success(function (response) {
                console.log(response);
                if (response.length > 0) {

                    $scope.partyInfo.name = response[0].name;
                    $scope.partyInfo.mobile = response[0].mobile;
                    $scope.partyInfo.address = response[0].address;

                    // get supplier balance
                    $http({
                        method: "POST",
                        url: url + "supplier_balance",
                        data: {party_code: response[0].code}
                    }).success(function (balanceRes) {
                        $scope.partyInfo.balance = Math.abs(parseFloat(balanceRes.balance).toFixed(2));
                        $scope.partyInfo.previous_balance = parseFloat(balanceRes.balance);
                        $scope.partyInfo.sign = balanceRes.status;
                    });

                }
            });
        }
    }

    // add product
    $scope.erroeMessage = false;
    $scope.checkProductCode = [];
    $scope.addNewProductFn = function (productCode) {
        if (typeof productCode !== 'undefined' && productCode != '') {
            $scope.active = false;

            if ($scope.checkProductCode.includes(productCode) != true) {


                $http({
                    method: 'POST',
                    url: url + 'result',
                    data: {
                        table: 'materials',
                        cond: {code: productCode, trash: 0}
                    }
                }).success(function (response) {

                    if (response.length > 0) {

                        $scope.checkProductCode.push(response[0].code);

                        var item = {
                            item_id: '',
                            product: response[0].name,
                            code: response[0].code,
                            unit: response[0].unit,
                            purchase_price: parseFloat(response[0].purchase_price),
                            sale_price: parseFloat(response[0].sale_price),
                            old_quantity: 0,
                            quantity: '',
                            discount: 0,
                            subtotal: 0,
                            godown: 1
                        };
                        $scope.cart.push(item);
                    } else {
                        $scope.cart = [];
                    }
                });
                $scope.erroeMessage = false;
            } else {
                $scope.erroeMessage = true;
            }

        }
    }


    $scope.setSubtotalFn = function (index) {
        var total = $scope.cart[index].subtotal = $scope.cart[index].purchase_price * $scope.cart[index].quantity;
        return $scope.cart[index].subtotal = Math.abs(total.toFixed(2));
    }

    $scope.totalQuantity = 0;
    $scope.getTotalFn = function () {

        var totalAmount = totalQuantity = 0;

        angular.forEach($scope.cart, function (item) {
            totalAmount += parseFloat(item.subtotal);
            totalQuantity += !isNaN(parseFloat(item.quantity)) ? parseFloat(item.quantity) : 0;
        });

        $scope.totalQuantity = totalQuantity;

        return Math.abs(totalAmount.toFixed(2));
    }

    $scope.getTotalDiscountFn = function () {
        var totalDiscount = 0;
        angular.forEach($scope.cart, function (item) {
            totalDiscount += parseFloat(item.discount);
        });
        return Math.abs(totalDiscount.toFixed(2));
    }

    $scope.getGrandTotalFn = function () {
        var transportCost = (!isNaN(parseFloat($scope.transportCost)) ? parseFloat($scope.transportCost) : 0);
        var grandTotal = parseFloat($scope.getTotalFn()) + transportCost - parseFloat($scope.getTotalDiscountFn());
        return Math.abs(grandTotal.toFixed(2));
    }

    $scope.getCurrentTotalFn = function () {

        var payment = (!isNaN(parseFloat($scope.payment)) ? parseFloat($scope.payment) : 0);

        var balance = $scope.partyInfo.previous_balance - parseFloat($scope.getGrandTotalFn()) + payment;

        $scope.partyInfo.sign = (balance < 0 ? 'Payable' : 'Receivable');
        $scope.partyInfo.current_balance = balance;

        $scope.isDisable = ($scope.totalQuantity > 0 ? false : true);

        return Math.abs(balance.toFixed(2));
    }

    $scope.deleteItemCart = [];
    $scope.deleteItemFn = function (index) {

        if ($scope.cart[index].item_id) {
            var alert = confirm('Do you want to delete this data?');
            if (alert) {

                $scope.deleteItemCart.push({
                    item_id: $scope.cart[index].item_id,
                    code: $scope.cart[index].code,
                    quantity: $scope.cart[index].old_quantity,
                });

                $scope.checkProductCode.splice(index, 1);
                $scope.cart.splice(index, 1);
            }
        } else {
            $scope.checkProductCode.splice(index, 1);
            $scope.cart.splice(index, 1);
        }
    }
});

// packaging Edit Purchase Entry
app.controller('PackagingEditPurchaseEntry', function ($scope, $http) {
    $scope.partyInfo = {
        balance: '',
        previous_balance: 0,
        sign: 'Receivable',
        csign: 'Payable'
    };

    $scope.total_discount = 0;
    $scope.transport_cost = 0;
    $scope.paid = 0;

    $scope.$watch('voucher_no', function (voucher_no) {

        $scope.records = [];

        // get purchase record
        var transmit = {
            tableFrom: 'sapitems',
            tableTo: 'saprecords',
            joinCond: 'sapitems.voucher_no=saprecords.voucher_no',
            cond: {'sapitems.voucher_no': voucher_no, 'sapitems.trash': '0', 'saprecords.trash': '0'},
            select: ['sapitems.*', 'sapitems.id AS item_id', 'saprecords.*']
        };

        $http({
            method: 'POST',
            url: url + 'join',
            data: transmit
        }).success(function (response) {
            if (response.length > 0) {
                angular.forEach(response, function (row, index) {

                    // get product name
                    $http({
                        method: "POST",
                        url: url + "result",
                        data: {
                            table: "materials",
                            cond: {code: row.product_code, type: 'raw'},
                            select: 'name'
                        }
                    }).success(function (productInfo) {
                        response[index].product = productInfo[0].name;
                    });

                    response[index].discount = parseFloat(row.discount);
                    response[index].paid = parseFloat(row.paid);
                    response[index].purchase_price = parseFloat(row.purchase_price);
                    response[index].sale_price = parseFloat(row.sale_price);
                    response[index].old_quantity = parseInt(row.quantity);
                    response[index].quantity = parseInt(row.quantity);
                    response[index].discount = parseInt(row.discount);
                    response[index].subtotal = 0;
                });


                // get supplier balance
                $http({
                    method: "POST",
                    url: url + "supplier_balance",
                    data: {party_code: response[0].party_code}
                }).success(function (balanceRes) {

                    var balance = parseFloat(balanceRes.balance) + (parseFloat(response[0].total_bill) + parseFloat(response[0].transport_cost)) - (parseFloat(response[0].total_discount) + parseFloat(response[0].paid));

                    $scope.partyInfo.balance = Math.abs(balance.toFixed(2));
                    $scope.partyInfo.previous_balance = parseFloat(balance);
                    $scope.partyInfo.sign = (balance < 0 ? 'Payable' : 'Receivable');
                });

                $scope.total_discount = parseFloat(response[0].total_discount);
                $scope.transport_cost = parseFloat(response[0].transport_cost);
                $scope.paid = parseFloat(response[0].paid);

                $scope.records = response;
            }
        });
    });


    $scope.setSubtotalFn = function (index) {
        angular.forEach($scope.records, function (item) {
            item.subtotal = item.purchase_price * item.quantity;
        });

        return $scope.records[index].subtotal;
    }

    $scope.getTotalFn = function () {
        var total = 0;
        angular.forEach($scope.records, function (item) {
            total += parseFloat(item.subtotal);
        });

        return Math.abs(total.toFixed(2));
    }

    $scope.getTotalDiscountFn = function () {
        var total = 0;
        angular.forEach($scope.records, function (item) {
            total += parseFloat(item.discount);
        });

        return Math.abs(total.toFixed(2));
    }

    $scope.getGrandTotalFn = function () {
        var grand_total = $scope.getTotalFn() + $scope.transport_cost - $scope.getTotalDiscountFn();
        return Math.abs(grand_total.toFixed(2));
    }

    $scope.getCurrentTotalFn = function () {

        var payment = (!isNaN(parseFloat($scope.paid)) ? parseFloat($scope.paid) : 0);

        var balance = $scope.partyInfo.previous_balance - $scope.getGrandTotalFn() + payment;

        $scope.partyInfo.sign = (balance < 0 ? 'Payable' : 'Receivable');

        return Math.abs(balance.toFixed(2));
    }
});

// machinery Edit Purchase Entry
app.controller('machineryEditPurchaseEntry', function ($scope, $http) {

    $scope.partyInfo = {
        balance: '',
        previous_balance: 0,
        sign: 'Receivable',
        csign: 'Payable'
    };

    $scope.total_discount = 0;
    $scope.transport_cost = 0;
    $scope.paid = 0;

    $scope.$watch('voucher_no', function (voucher_no) {

        $scope.records = [];

        // get purchase record
        var transmit = {
            tableFrom: 'sapitems',
            tableTo: 'saprecords',
            joinCond: 'sapitems.voucher_no=saprecords.voucher_no',
            cond: {'sapitems.voucher_no': voucher_no, 'sapitems.trash': '0', 'saprecords.trash': '0'},
            select: ['sapitems.*', 'sapitems.id AS item_id', 'saprecords.*']
        };

        $http({
            method: 'POST',
            url: url + 'join',
            data: transmit
        }).success(function (response) {
            if (response.length > 0) {
                angular.forEach(response, function (row, index) {

                    // get product name
                    $http({
                        method: "POST",
                        url: url + "result",
                        data: {
                            table: "materials",
                            cond: {code: row.product_code, type: 'raw'},
                            select: 'name'
                        }
                    }).success(function (productInfo) {
                        response[index].product = productInfo[0].name;
                    });

                    response[index].discount = parseFloat(row.discount);
                    response[index].paid = parseFloat(row.paid);
                    response[index].purchase_price = parseFloat(row.purchase_price);
                    response[index].sale_price = parseFloat(row.sale_price);
                    response[index].old_quantity = parseInt(row.quantity);
                    response[index].quantity = parseInt(row.quantity);
                    response[index].discount = parseInt(row.discount);
                    response[index].subtotal = 0;
                });


                // get supplier balance
                $http({
                    method: "POST",
                    url: url + "supplier_balance",
                    data: {party_code: response[0].party_code}
                }).success(function (balanceRes) {

                    var balance = parseFloat(balanceRes.balance) + (parseFloat(response[0].total_bill) + parseFloat(response[0].transport_cost)) - (parseFloat(response[0].total_discount) + parseFloat(response[0].paid));

                    $scope.partyInfo.balance = Math.abs(balance.toFixed(2));
                    $scope.partyInfo.previous_balance = parseFloat(balance);
                    $scope.partyInfo.sign = (balance < 0 ? 'Payable' : 'Receivable');
                });

                $scope.total_discount = parseFloat(response[0].total_discount);
                $scope.transport_cost = parseFloat(response[0].transport_cost);
                $scope.paid = parseFloat(response[0].paid);

                $scope.records = response;
            }
        });
    });


    $scope.setSubtotalFn = function (index) {
        angular.forEach($scope.records, function (item) {
            item.subtotal = item.purchase_price * item.quantity;
        });

        return $scope.records[index].subtotal;
    }

    $scope.getTotalFn = function () {
        var total = 0;
        angular.forEach($scope.records, function (item) {
            total += parseFloat(item.subtotal);
        });

        return Math.abs(total.toFixed(2));
    }

    $scope.getTotalDiscountFn = function () {
        var total = 0;
        angular.forEach($scope.records, function (item) {
            total += parseFloat(item.discount);
        });

        return Math.abs(total.toFixed(2));
    }

    $scope.getGrandTotalFn = function () {
        var grand_total = $scope.getTotalFn() + $scope.transport_cost - $scope.getTotalDiscountFn();
        return Math.abs(grand_total.toFixed(2));
    }

    $scope.getCurrentTotalFn = function () {

        var payment = (!isNaN(parseFloat($scope.paid)) ? parseFloat($scope.paid) : 0);

        var balance = $scope.partyInfo.previous_balance - $scope.getGrandTotalFn() + payment;

        $scope.partyInfo.sign = (balance < 0 ? 'Payable' : 'Receivable');

        return Math.abs(balance.toFixed(2));
    }
});


// show Raw Stock Ctl
app.controller("showRawStockCtl", ['$scope', '$http', function ($scope, $http) {
    $scope.perPage = "20";
    $scope.allRawStocks = [];

    var where = {
        table: "stock",
        cond: {
            'type': "raw",
            'quantity >': '0'
        }
    };

    $http({
        method: "POST",
        url: url + "read",
        data: where
    }).success(function (response) {
        if (response.length > 1) {
            angular.forEach(response, function (row, key) {
                row['sl'] = key + 1;
                $scope.allRawStocks.push(row);
            });
        } else {
            $scope.allRawStocks = [];
        }

        // loading
        $("#loading").fadeOut("fast", function () {
            $("#data").fadeIn('slow');
        });
    });
}]);


// show Finish Product Stock Ctl
app.controller("showFinishProductStockCtl", ['$scope', '$http', function ($scope, $http) {
    $scope.perPage = "20";
    $scope.allfinishProduct = [];

    var where = {
        table: "stock",
        cond: {
            type: "finish_product"
        }
    };

    $http({
        method: "POST",
        url: url + "read",
        data: where
    }).success(function (response) {
        if (response.length > 0) {
            angular.forEach(response, function (row, key) {
                row['sl'] = key + 1;
                $scope.allfinishProduct.push(row);
            });
        } else {
            $scope.allfinishProduct = [];
        }

        // loading
        $("#loading").fadeOut("fast", function () {
            $("#data").fadeIn('slow');
        });
    });
}]);


// get product name
app.directive("productName", ['$http', function ($http) {
    return {
        template: "<span>{{name}}</span>",
        scope: {
            productCode: "="
        },
        link: function (scope) {
            var where = {
                table: 'products',
                cond: {'product_code': scope.productCode}
            };

            $http({
                method: 'POST',
                url: url + 'read',
                data: where
            }).success(function (response) {
                scope.name = response[0].product_name;
                console.log(response);
            });
        }
    }
}]);


// do sale controller
app.controller('DOSaleEntryCtrl', function ($scope, $http) {
    $scope.active = true;
    $scope.cart = [];

    $scope.amount = {
        labour: 0,
        total: 0,
        discount: 0,
        truck_rent: 0,
        grandTotal: 0,
        paid: 0,
        due: 0
    };

    $scope.doNo = [];

    $scope.setAllBrand = function () {
        var condition = {
            table: 'stock',
            cond: {
                category: $scope.category,
                type: 'do'
            },
            column: 'subcategory'
        };

        $http({
            method: 'POST',
            url: url + 'readDistinct',
            data: condition
        }).success(function (response) {
            $scope.allSubcategory = response;
        });
    }

    $scope.setAllProducts = function () {
        var condition = {
            table: 'stock',
            cond: {
                category: $scope.category,
                subcategory: $scope.subcategory,
                type: 'do'
            },
            column: 'product_name'
        };

        $http({
            method: 'POST',
            url: url + 'readDistinct',
            data: condition
        }).success(function (response) {
            $scope.allProducts = response;
        });
    }


    //set all do no
    $scope.setAllDONoFn = function () {
        $scope.allDONO = [];

        var condition = {
            table: 'stock',
            cond: {
                category: $scope.category,
                subcategory: $scope.subcategory,
                product_name: $scope.product,
                type: 'do'
            }
        };

        $http({
            method: 'POST',
            url: url + 'read',
            data: condition
        }).success(function (response) {
            if (response.length > 0) {
                angular.forEach(response, function (items, key) {
                    if ((items.do_in - items.do_out) > 0) {
                        $scope.allDONO.push(items);
                    }
                });
            } else {
                $scope.allDONO = [];
            }
        });
    }


    //get all available do stock from db
    $scope.getdoStockFn = function () {

        var where = {
            table: "stock",
            cond: {do_no: $scope.do_no}
        };

        $http({
            method: "POST",
            url: url + "read",
            data: where
        }).success(function (response) {
            $scope.unit = response[0].unit;
            $scope.available = (response[0].do_in - response[0].do_out) + " " + response[0].unit + "s   Available!";
            $scope.remainingStock = (response[0].do_in - response[0].do_out);
        });
    };

    $scope.addNewProductFn = function () {
        if (typeof $scope.product !== 'undefined' && $scope.remainingStock > 0) {
            $scope.active = false;
            var condition = {
                table: 'stock',
                cond: {
                    do_no: $scope.do_no,
                    category: $scope.category,
                    subcategory: $scope.subcategory,
                    product_name: $scope.product,
                    unit: $scope.unit,
                    godown: $scope.showroom_id,
                    showroom_id: $scope.showroom_id,
                    type: 'do'
                }
            };

            $http({
                method: 'POST',
                url: url + 'read',
                data: condition
            }).success(function (response) {
                console.log(response);
                angular.forEach(response, function (item) {
                    //Getting purchase price Start here
                    var condd = {
                        table: 'products',
                        cond: {product_name: item.product_name}
                    };

                    $http({
                        method: 'POST',
                        url: url + 'read',
                        data: condd
                    }).success(function (product_info) {
                        //Getting purchase price End here
                        var brand = (item.subcategory).replace(/_/gi, " ").toLowerCase();
                        var newItem = {
                            do_no: item.do_no,
                            product: item.product_name,
                            product_code: item.product_code,
                            category: item.category,
                            subcategory: item.subcategory,
                            brand: brand,
                            godown: item.godown,
                            price: parseFloat(item.sell_price),
                            maxQuantity: (parseInt(item.do_in) - parseInt(item.do_out)),
                            stock_qty: item.do_in,
                            quantity: 1.00,
                            unit: $scope.unit,
                            discount: 0,
                            subtotal: 0,
                            godown: item.godown,
                            purchase_price: parseFloat(item.purchase_price)
                        };


                        // for single product sale
                        if ($scope.cart.length == 0) {
                            $scope.cart.push(newItem);
                        } else {
                            console.log($scope.cart.indexOf(brand));
                            if ($scope.cart.indexOf(brand) > 0) {
                                $scope.cart.push(newItem);
                            }
                        }
                    });
                });
            });
        }
    }

    $scope.setSubtotalFn = function (index) {
        $scope.cart[index].subtotal = $scope.cart[index].price * $scope.cart[index].quantity;
        return $scope.cart[index].subtotal;
    }

    $scope.purchaseSubtotalFn = function (index) {
        $scope.cart[index].purchase_subtotal = $scope.cart[index].purchase_price * $scope.cart[index].quantity;
        return $scope.cart[index].purchase_subtotal;
    }

    $scope.getTotalFn = function () {
        var total = 0;
        angular.forEach($scope.cart, function (item) {
            total += parseFloat(item.subtotal);
        });

        $scope.amount.total = total;
        return $scope.amount.total;
    }

    $scope.getPurchaseTotalFn = function () {
        var total = 0;
        angular.forEach($scope.cart, function (item) {
            total += parseFloat(item.purchase_subtotal);
        });

        $scope.amount.purchase_total = total;
        return $scope.amount.purchase_total;
    }

    /* $scope.getGrandTotalFn = function(){
    	var grand_total = 0.0;
    	grand_total = parseFloat($scope.amount.total - $scope.amount.discount - $scope.commission.total) + parseFloat($scope.amount.truck_rent) + parseFloat($scope.amount.labour);
    	return $scope.amount.grandTotal = grand_total.toFixed(2);
    }*/

    $scope.getGrandTotalFn = function () {
        var grand_total = 0.0;


        grand_total = (parseFloat($scope.amount.total) - parseFloat($scope.amount.truck_rent)) + parseFloat($scope.amount.labour);
        return $scope.amount.grandTotal = grand_total.toFixed(2);
    }

    $scope.getCurrentTotalFn = function () {
        var total = 0;

        if ($scope.partyInfo.sign == 'Receivable') {
            total = ($scope.partyInfo.balance + parseFloat($scope.amount.grandTotal)) - $scope.amount.paid;

            if (total > 0) {
                $scope.partyInfo.csign = "Receivable";
            } else if (total < 0) {
                $scope.partyInfo.csign = "Payable";
            } else {
                $scope.partyInfo.csign = "Receivable";
            }
        } else {
            total = ($scope.partyInfo.balance + $scope.amount.paid) - parseFloat($scope.amount.grandTotal);

            if (total > 0) {
                $scope.partyInfo.csign = "Payable";
            } else if (total < 0) {
                $scope.partyInfo.csign = "Receivable";
            } else {
                $scope.partyInfo.csign = "Receivable";
            }
        }

        $scope.amount.due = total.toFixed(2);

        console.log($scope.stype, 1);
        if ($scope.stype == "cash") {
            $scope.isDisabled = (Math.abs(total.toFixed(2)) > 0) ? true : false;
        }

        return Math.abs(total.toFixed(2));
    }

    console.log($scope.amount.due);

    $scope.deleteItemFn = function (index) {
        $scope.cart.splice(index, 1);
    }

    $scope.partyInfo = {
        code: '',
        name: '',
        contact: '',
        address: '',
        balance: 0,
        payment: 0,
        limit: 0,
        sign: 'Receivable',
        csign: 'Receivable'
    };

    $scope.findPartyFn = function () {
        if (typeof $scope.partyCode != 'undefined') {
            var condition = {
                from: 'parties',
                join: 'partybalance',
                cond: 'parties.code=partybalance.code',
                where: {'parties.code': $scope.partyCode, 'partybalance.brand': $scope.cart[0].brand}
            };
            //console.log(condition);

            $http({
                method: 'POST',
                url: url + 'readJoinData',
                data: condition
            }).success(function (response) {

                if (response.length > 0) {
                    $scope.partyInfo.balance = Math.abs(parseFloat(response[0].balance));

                    if (parseFloat(response[0].balance) > 0) {
                        $scope.partyInfo.sign = "Payable";
                    } else if (parseFloat(response[0].balance) < 0) {
                        $scope.partyInfo.sign = "Receivable";
                    } else {
                        $scope.partyInfo.sign = "Receivable";
                    }

                    $scope.partyInfo.code = response[0].code;
                    $scope.partyInfo.name = response[0].name;
                    $scope.partyInfo.contact = response[0].contact;
                    $scope.partyInfo.address = response[0].address;
                    $scope.partyInfo.limit = response[0].credit_limit;
                } else {
                    $scope.partyInfo = {};

                    $scope.partyInfo.balance = 0;
                    $scope.partyInfo.sign = "Receivable";
                }

                console.log($scope.partyInfo);
            });
        }
    }

    // get commission total
    $scope.commission = {
        quantity: 0,
        amount: 0,
        total: 0.0
    };

    // get less total
    $scope.less = {
        quantity: 0,
        amount: 0
    };

    // get Truck total
    $scope.truck = {
        quantity: 0,
        amount: 0
    };

    $scope.totalQuantityFn = function () {
        var total = 0;

        angular.forEach($scope.cart, function (item, index) {
            total += item.quantity;
        });

        $scope.truck.quantity = total;
        $scope.commission.quantity = total;

        return $scope.truck.quantity;
    }

    $scope.getTruckTotal = function () {
        return $scope.amount.truck_rent = (parseFloat($scope.truck.quantity) * parseFloat($scope.truck.amount)).toFixed(2);
    };

    $scope.getCommissionTotal = function () {
        return $scope.commission.total = (parseFloat($scope.commission.quantity) * parseFloat($scope.commission.amount)).toFixed(2);
    };

    $scope.getLessTotal = function () {
        return $scope.amount.discount = (parseFloat($scope.less.quantity) * parseFloat($scope.less.amount)).toFixed(2);
    };


});


// do edit sale controller
app.controller('DOEditSaleCtrl', ['$scope', '$http', function ($scope, $http) {
    $scope.info = {};
    $scope.records = [];

    $scope.amount = {
        oldTotal: 0,
        newTotal: 0,
        discount: 0,
        oldTotalDiscount: 0,
        newTotalDiscount: 0,
        oldGrandTotal: 0,
        newGrandTotal: 0,
        paid: 0
    };

    $scope.$watch('info.vno', function (voucherNo) {
        // get sale record
        var transmit = {
            from: 'saprecords',
            join: 'sapitems',
            cond: 'saprecords.voucher_no=sapitems.voucher_no',
            where: {'saprecords.voucher_no': voucherNo}
        };

        // take action
        $http({
            method: 'POST',
            url: url + 'readJoinData',
            data: transmit
        }).success(function (response) {
            $scope.info.newQuantity = 0;

            if (response.length > 0) {
                angular.forEach(response, function (row, index) {
                    $scope.info.newQuantity += parseInt(row.newQuantity);

                    response[index].discount = parseFloat(row.discount);
                    response[index].paid = parseFloat(row.paid);
                    response[index].oldQuantity = parseInt(row.quantity);
                    response[index].newQuantity = parseInt(row.quantity);
                    response[index].purchase_price = parseFloat(row.purchase_price);
                    response[index].newSalePrice = parseFloat(row.sale_price);
                    response[index].oldSalePrice = parseFloat(row.sale_price);
                    response[index].oldSubtotal = 0;
                    response[index].newSubtotal = 0;

                    var where = {
                        table: "products",
                        cond: {product_code: row.product_code}
                    };

                    $http({
                        method: "POST",
                        url: url + "read",
                        data: where
                    }).success(function (info) {
                        if (info.length > 0) {
                            response[index].product = info[0].product_name;
                            response[index].brand = info[0].subcategory;
                        }
                    });
                });

                console.log(response);

                // get sr or dsr information
                var condition = {
                    table: 'sapmeta',
                    cond: {'sapmeta.voucher_no': voucherNo}
                };

                $http({
                    method: 'POST',
                    url: url + 'read',
                    data: condition
                }).success(function (response) {
                    if (response.length > 0) {
                        angular.forEach(response, function (row, index) {
                            if (row.meta_key == 'sr') {
                                $scope.info.sr = row.meta_value;
                            }
                            if (row.meta_key == 'dsr') {
                                $scope.info.dsr = row.meta_value;
                            }
                        });
                    }

                    console.log(response);
                });


                //get party information
                var party_where = {
                    table: 'parties',
                    cond: {code: response[0].party_code}
                }

                $http({
                    method: 'POST',
                    url: url + 'read',
                    data: party_where
                }).success(function (response) {
                    console.log(response);

                    $scope.info.partyMobile = response[0].contact;
                });

                // get party balance information
                $scope.info.partyCode = response[0].party_code;

                $http({
                    method: 'POST',
                    url: url + 'read',
                    data: {
                        table: 'partybalance',
                        cond: {code: response[0].party_code}
                    }
                }).success(function (info) {
                    var balance = 0;
                    if (typeof info != "undefined") {
                        balance = parseFloat(info[0].balance);
                    }


                    $scope.info.previousBalance = Math.abs(balance);
                    $scope.info.sign = (balance <= 0) ? 'Receivable' : 'Payable';
                });

                // get voucher meta
                $http({
                    method: 'POST',
                    url: url + 'read',
                    data: {
                        table: 'sapmeta',
                        cond: {voucher_no: response[0].voucher_no}
                    }
                }).success(function (meta) {
                    if (meta.length > 0) {
                        angular.forEach(meta, function (row, key) {
                            $scope.info[row.meta_key] = row.meta_value;

                            if (row.meta_key == 'truck_amount') {
                                $scope.info[row.meta_key] = parseFloat(row.meta_value);
                            }

                            if (row.meta_key == 'commission_amount') {
                                $scope.info[row.meta_key] = parseFloat(row.meta_value);
                            }

                            if (row.meta_key == 'labour_cost') {
                                $scope.info[row.meta_key] = parseFloat(row.meta_value);
                            }
                        });
                    }
                });

                $scope.info.date = response[0].sap_at;
                $scope.info.sapType = response[0].sap_type;
                $scope.info.voucher = response[0].voucher_no;
                $scope.info.partyCode = response[0].party_code;

                $scope.amount.oldTotal = parseFloat(response[0].total_bill);
                $scope.amount.oldTotalDiscount = parseFloat(response[0].total_discount);

                $scope.records = response;

                console.log($scope.info);
            }

            console.log(response);
        });
    });

    $scope.getOldSubtotalFn = function (index) {
        angular.forEach($scope.records, function (item) {
            item.oldSubtotal = item.oldSalePrice * item.oldQuantity;
        });

        return $scope.records[index].oldSubtotal;
    }

    $scope.getNewSubtotalFn = function (index) {
        angular.forEach($scope.records, function (item) {
            item.newSubtotal = item.newSalePrice * item.newQuantity;
        });

        return $scope.records[index].newSubtotal;
    }

    $scope.getOldGrandTotalFn = function () {
        $scope.amount.oldGrandTotal = $scope.amount.oldTotal - $scope.amount.oldTotalDiscount;
        return $scope.amount.oldGrandTotal;
    }

    $scope.getTotalFn = function () {
        var total = 0;
        angular.forEach($scope.records, function (item) {
            total += item.newSubtotal;
        });

        $scope.amount.newTotal = total + $scope.info.labour_cost;
        return $scope.amount.newTotal;
    }

    $scope.getNewGrandTotalFn = function () {
        $scope.amount.newGrandTotal = $scope.amount.newTotal - $scope.info.truck_rent - $scope.amount.discount;
        return $scope.amount.newGrandTotal;
    }

    $scope.getGrandTotalDifferenceFn = function () {
        var total = 0;

        total = $scope.amount.newGrandTotal - $scope.amount.oldGrandTotal;
        $scope.amount.sign = (total >= 0) ? 'Receivable' : 'Payable';
        $scope.amount.difference = Math.abs(total);

        return $scope.amount.difference;
    }

    $scope.getCurrentTotalFn = function () {
        var total = 0;

        if ($scope.amount.sign == 'Receivable' && $scope.info.sign == 'Receivable') {
            total = ($scope.amount.difference + $scope.info.previousBalance) - $scope.amount.paid;
            $scope.info.csign = 'Receivable';
        } else if ($scope.amount.sign == 'Receivable' && $scope.info.sign == 'Payable') {
            total = $scope.amount.difference - ($scope.info.previousBalance + $scope.amount.paid);
            if (total >= 0) {
                $scope.info.csign = 'Receivable';
            } else {
                $scope.info.csign = 'Payable';
            }
        } else if ($scope.amount.sign == 'Payable' && $scope.info.sign == 'Receivable') {
            total = ($scope.amount.difference + $scope.amount.paid) - $scope.info.previousBalance;
            if (total <= 0) {
                $scope.info.csign = 'Receivable';
            } else {
                $scope.info.csign = 'Payable';
            }
        } else {
            total = $scope.amount.difference + ($scope.info.previousBalance + $scope.amount.paid);
            if (total > 0) {
                $scope.info.csign = 'Payable';
            } else {
                $scope.info.csign = 'Receivable';
            }
        }

        return Math.abs(total);
    }

    $scope.getTotalProductQuantityFn = function () {
        var total = 0;

        angular.forEach($scope.records, function (row, index) {
            total += row.newQuantity;
        });

        $scope.info.newQuantity = total;

        return $scope.info.newQuantity;
    }

    $scope.getTotalTruckRentFn = function () {
        var total = 0;

        total = $scope.info.newQuantity * $scope.info.truck_amount;
        $scope.info.truck_rent = total;

        return $scope.info.truck_rent;
    }

    $scope.getCommissionTotalFn = function () {
        var total = 0;

        total = $scope.info.newQuantity * $scope.info.commission_amount;
        $scope.info.commission_total = total;

        return $scope.info.commission_total;
    }

}]);


// sale controller
app.controller('ReturnSaleCtrl', function ($scope, $http) {
    $scope.cart = [];
    $scope.amount = {
        total: 0,
        paid: 0,
        due: 0
    };

    $scope.info = {};

    $scope.$watch('vno', function () {
        var condition = {
            table: 'sale',
            cond: {voucher_number: $scope.vno}
        }

        $http({
            method: 'POST',
            url: url + 'read',
            data: condition
        }).success(function (response) {
            angular.forEach(response, function (item) {
                var row = {
                    id: item.id,
                    category: item.category,
                    subcategory: item.subcategory,
                    godown: item.godown,
                    product: item.product,
                    oldQuantity: parseInt(item.quantity),
                    quantity: parseInt(item.quantity),
                    discount: parseInt(item.discount),
                    returnQuantity: 0,
                    price: parseFloat(item.price),
                    subtotal: parseFloat(item.subtotal),
                    date: item.date,
                    voucher: item.voucher_number,
                    paid: parseFloat(item.paid),
                    due: parseFloat(item.due)
                };

                $scope.cart.push(row);

                $scope.amount.paid = row.paid;
                $scope.amount.due = row.due;
                $scope.amount.discount = row.discount;

                $scope.info.date = row.date;
                $scope.info.voucher = row.voucher;
            });
        });
    });

    $scope.changeQuantityFn = function (index) {
        $scope.cart[index].quantity;
        console.log($scope.cart[index]);
        return ($scope.cart[index].quantity - $scope.cart[index].returnQuantity);
    }

    $scope.setSubtotalFn = function (index) {
        $scope.cart[index].subtotal = $scope.cart[index].price * ($scope.cart[index].quantity - $scope.cart[index].returnQuantity);
        return $scope.cart[index].subtotal;
    }

    $scope.getTotalFn = function () {
        var total = 0;
        angular.forEach($scope.cart, function (item) {
            total += item.subtotal;
        });

        $scope.amount.total = total;
        return $scope.amount.total;
    }

    $scope.getGrandTotalFn = function () {
        var total = 0;
        total = $scope.amount.total - $scope.amount.discount;
        $scope.amount.grandTotal = total;

        return $scope.amount.grandTotal;
    }

    $scope.getTotalDueFn = function () {
        $scope.amount.due = $scope.amount.total - $scope.amount.paid;
        return $scope.amount.due;
    }

});


// Due Payment Controller
app.controller('DuePaymentCtrl', function ($scope, $http) {
    $scope.cart = [];
    $scope.amount = {
        total: 0,
        paid: 0,
        diposit: 0,
        remission: 0,
        due: 0
    };
    $scope.info = {};

    $scope.$watch('vno', function () {
        var condition = {
            table: 'sale',
            cond: {voucher_number: $scope.vno}
        }

        $http({
            method: 'POST',
            url: url + 'read',
            data: condition
        }).success(function (response) {
            angular.forEach(response, function (item) {
                var row = {
                    id: item.id,
                    category: item.category,
                    subcategory: item.subcategory,
                    godown: item.godown,
                    product: item.product,
                    oldQuantity: parseInt(item.quantity),
                    newQuantity: parseInt(item.quantity),
                    price: parseFloat(item.price),
                    subtotal: parseFloat(item.subtotal),
                    grand_total: parseFloat(item.grand_total),
                    discount: parseFloat(item.discount),
                    date: item.date,
                    voucher: item.voucher_number,
                    paid: parseFloat(item.paid),
                    remission: parseFloat(item.remission),
                    due: parseFloat(item.due)
                };

                $scope.cart.push(row);

                $scope.amount.paid = row.paid;
                $scope.amount.discount = row.discount;
                $scope.amount.total_remission = row.remission;
                $scope.amount.grand_total = row.grand_total;
                $scope.amount.due = row.due;

                $scope.info.date = row.date;
                $scope.info.voucher = row.voucher;
                console.log($scope.cart);
            });
        });
    });

    $scope.setSubtotalFn = function (index) {
        $scope.cart[index].subtotal = $scope.cart[index].price * $scope.cart[index].newQuantity;
        return $scope.cart[index].subtotal;
    }

    $scope.getTotalFn = function () {
        var total = 0;
        angular.forEach($scope.cart, function (item) {
            total += item.subtotal;
        });

        $scope.amount.total = total;
        return $scope.amount.total;
    }


    $scope.getTotalDueFn = function (d, r, tr) {
        var paid = $scope.amount.paid + parseFloat(d) + parseFloat(r) + parseFloat(tr);
        $scope.amount.due = $scope.amount.grand_total - paid;
        return $scope.amount.due;
    }

});


// credit sale controller
app.controller('CreditSaleEntryCtrl', function ($scope, $http) {
    $scope.active = true;
    $scope.cart = [];
    $scope.amount = {
        total: 0,
        totalDiscount: 0,
        grandTotal: 0,
        paid: 0,
        due: 0
    };

    $scope.setAllSubcategory = function () {
        var condition = {
            table: 'stock',
            cond: {category: $scope.category},
            column: 'subcategory'
        };

        $http({
            method: 'POST',
            url: url + 'readDistinct',
            data: condition
        }).success(function (response) {
            $scope.allSubcategory = response;
            // console.log(response);
        });
    }

    $scope.setAllProducts = function () {
        var condition = {
            table: 'stock',
            cond: {
                category: $scope.category,
                subcategory: $scope.subcategory
            },
            column: 'product_name'
        };

        $http({
            method: 'POST',
            url: url + 'readDistinct',
            data: condition
        }).success(function (response) {
            $scope.allProducts = response;
            // console.log(response);
        });
    }

    /*
    $scope.setAllGodownsFn = function(){
    	var condition = {
    		table: 'stock',
    		cond: {
    			category: $scope.category,
    			subcategory: $scope.subcategory,
    			product_name: $scope.product
    		},
    		column: 'godown'
    	};

    	$http({
    		method: 'POST',
    		url: url + 'readDistinct',
    		data: condition
    	}).success(function(response){
    		$scope.allGodown = response;
    		// console.log(response);
    	});
    }
    */

    $scope.addNewProductFn = function () {
        if (typeof $scope.product !== 'undefined') {
            $scope.active = false;

            var condition = {
                table: 'stock',
                cond: {
                    category: $scope.category,
                    subcategory: $scope.subcategory,
                    product_name: $scope.product,
                    godown: $scope.showroom_id,
                    showroom_id: $scope.showroom_id
                }
            };

            // console.log(condition);

            $http({
                method: 'POST',
                url: url + 'read',
                data: condition
            }).success(function (response) {
                angular.forEach(response, function (item) {
                    var newItem = {
                        product: item.product_name,
                        category: item.category,
                        subcategory: item.subcategory,
                        price: parseFloat(item.sell_price),
                        maxQuantity: parseInt(item.quantity),
                        quantity: 1,
                        discount: 0,
                        subtotal: 0,
                        godown: item.godown
                    };

                    $scope.cart.push(newItem);
                });
            });
        }
    }

    $scope.setSubtotalFn = function (index) {
        $scope.cart[index].subtotal = $scope.cart[index].price * $scope.cart[index].quantity;
        return $scope.cart[index].subtotal;
    }

    $scope.getTotalFn = function () {
        var total = 0;
        angular.forEach($scope.cart, function (item) {
            total += parseFloat(item.subtotal);
        });

        $scope.amount.total = total;
        return $scope.amount.total;
    }

    $scope.getTotalDueFn = function () {
        $scope.amount.due = $scope.amount.total - $scope.amount.paid;
        return $scope.amount.due;
    }

    $scope.deleteItemFn = function (index) {
        $scope.cart.splice(index, 1);
    }


    $scope.findMemberFn = function () {
        var condition = {
            table: 'members',
            cond: {member_id: $scope.memberID}
        };

        $http({
            method: 'POST',
            url: url + 'read',
            data: condition
        }).success(function (response) {
            if (response.length > 0) {
                $scope.memberInfo = {
                    member: response[0].member_full_name,
                    address: 'গ্রাম: ' + response[0].member_village + ', উপজেলা: ' + response[0].member_police_station + ', জেলা:' + response[0].member_district,
                    mobile: response[0].member_mobile_number,
                    photo: siteurl + response[0].member_photo
                };
            } else {
                $scope.memberInfo = {
                    member: '',
                    address: '',
                    mobile: '',
                    photo: siteurl + 'public/members/default.jpg'
                };
            }
        });
    }

    $scope.getInstallmentTKFn = function () {
        var total = 0;
        total = (parseFloat($scope.amount.due) / parseFloat($scope.installment_quantity)).toFixed(2);

        $scope.amount_quantity = total;
    }

    $scope.installmentTypeFn = function () {
        if ($scope.type == "weekly") {
            $scope.dateActive = true;
            $scope.dayActive = false;
        } else {
            $scope.dateActive = false;
            $scope.dayActive = true;
        }
    }

});


//Edit Credit Sale
app.controller('CreditSaleEditCtrl', function ($scope, $http) {
    $scope.cart = [];
    $scope.amount = {total: 0, paid: 0, due: 0};
    $scope.info = {};

    $scope.$watch('vno', function () {
        var condition = {
            table: 'sale',
            cond: {voucher_number: $scope.vno}
        }

        $http({
            method: 'POST',
            url: url + 'read',
            data: condition
        }).success(function (response) {
            angular.forEach(response, function (item) {
                var row = {
                    id: item.id,
                    category: item.category,
                    subcategory: item.subcategory,
                    godown: item.godown,
                    product: item.product,
                    oldQuantity: parseInt(item.quantity),
                    newQuantity: parseInt(item.quantity),
                    price: parseFloat(item.price),
                    subtotal: parseFloat(item.subtotal),
                    date: item.date,
                    voucher: item.voucher_number,
                    paid: parseFloat(item.paid),
                    due: parseFloat(item.due)
                };

                $scope.cart.push(row);

                $scope.amount.paid = row.paid;

                $scope.info.date = row.date;
                $scope.info.voucher = row.voucher;
            });
        });

        var where = {
            table: 'loan',
            cond: {voucher_number: $scope.vno}
        };

        $http({
            method: 'POST',
            url: url + 'read',
            data: where
        }).success(function (response) {
            console.log(response);
            if (response.length == 1) {
                angular.forEach(response, function (value) {

                    $scope.installment_quantity = parseFloat(value.installment_no);
                    $scope.amount_quantity = parseFloat(value.amount_per_installment);
                    $scope.type = (value.installment_type);

                    if ($scope.type == "weekly") {
                        $scope.dateActive = true;
                        $scope.dayActive = false;
                    } else {
                        $scope.dateActive = false;
                        $scope.dayActive = true;
                    }

                    $scope.installment_date = value.installment_date;
                    $scope.installment_day = value.installment_day;
                });
            }
        });

    });


    $scope.setSubtotalFn = function (index) {
        $scope.cart[index].subtotal = $scope.cart[index].price * $scope.cart[index].newQuantity;
        return $scope.cart[index].subtotal;
    }

    $scope.getTotalFn = function () {
        var total = 0;
        angular.forEach($scope.cart, function (item) {
            total += item.subtotal;
        });

        $scope.amount.total = total;
        return $scope.amount.total;
    }

    $scope.getTotalDueFn = function () {
        $scope.amount.due = $scope.amount.total - $scope.amount.paid;
        return $scope.amount.due;
    }

    $scope.getInstallmentTKFn = function () {
        $scope.amount_quantity = $scope.amount.due / $scope.installment_quantity;
    }

    $scope.installmentTypeFn = function () {
        if ($scope.type == "weekly") {
            $scope.dateActive = true;
            $scope.dayActive = false;
        } else {
            $scope.dateActive = false;
            $scope.dayActive = true;
        }
    }

});


// sale controller
app.controller('RawSaleEntryCtrl', function ($scope, $http) {

    $scope.active = true;
    $scope.active1 = false;
    $scope.cart = [];

    $scope.stype = "cash";

    $scope.presentBalance = 0;
    $scope.isDisabled = false;

    $scope.remaining_commission = 0;
    $scope.total_commission_amount = 0;

    $scope.amount = {
        labour: 0,
        total: 0,
        totalqty: 0,
        truck_rent: 0,
        grandTotal: 0,
        paid: 0,
        due: 0
    };

    //get sale type
    $scope.getsaleType = function (type) {
        if (type == "cash") {
            $scope.active = true;
            $scope.active1 = false;
            $scope.partyInfo.balance = 0;
            $scope.partyInfo.sign = "Receivable";
        } else {
            $scope.active = false;
            $scope.active1 = true;
            $scope.partyCode = "";
            $scope.partyInfo.code = "";
            $scope.partyInfo.contact = "";
            $scope.partyInfo.address = "";
        }
    };

    $scope.addNewProductFn = function () {
        if (typeof $scope.product !== 'undefined') {

            var condition = {
                table: 'stock',
                cond: {
                    code: $scope.product.trim(),
                    unit: "Kg",
                    godown: $scope.showroom_id,
                    type: 'raw'
                }
            };
            //console.log(condition);

            $http({
                method: 'POST',
                url: url + 'read',
                data: condition
            }).success(function (response) {
                angular.forEach(response, function (item) {
                    //Getting production cost  Start here
                    var condd = {
                        table: 'materials',
                        cond: {
                            code: item.code,
                            type: 'raw',
                            status: 'available',
                            trash: 0
                        }
                    };
                    //console.log(condd);

                    var name = item.name,
                        str = name.replace(/_/gi, " ").toLowerCase();
                    name = str.replace(/\b[a-z]/g, function (letter) {
                        return letter.toUpperCase();
                    });


                    $http({
                        method: 'POST',
                        url: url + 'read',
                        data: condd
                    }).success(function (product_info) {
                        //Getting production cost End here
                        var newItem = {
                            product: name,
                            product_code: item.code,
                            godown: item.godown,
                            maxQuantity: parseInt(item.quantity),
                            stock_qty: parseInt(item.quantity),
                            quantity: 1.00,
                            bags: 0,
                            unit: "Kg",
                            subtotal: 0,
                            purchase_price: parseFloat(product_info[0].production_cost),
                            sale_price: parseFloat(product_info[0].price),
                        };

                        $scope.cart.push(newItem);
                        //console.log($scope.cart);
                    });
                });
            });
        }
    }

    //calculate Bags no
    $scope.calculateBags = function (i, size) {
        var bag_no = 0;
        bag_no = parseFloat($scope.cart[i].quantity) / parseFloat(size);
        $scope.cart[i].bags = bag_no.toFixed(2);
        return $scope.cart[i].bags;
    };

    //calculate commission
    $scope.calculateTotalCommission = function () {
        var total = parseFloat($scope.amount.total),
            totalCommission = 0,
            remainingCommission = 0;

        remainingCommission = parseInt(6 - $scope.commission);
        $scope.remaining_commission = remainingCommission;

        totalCommission = parseFloat(total * (parseFloat($scope.commission) / 100));
        $scope.total_commission_amount = totalCommission.toFixed(2);

        return $scope.total_commission_amount;
    };

    $scope.setSubtotalFn = function (index) {
        $scope.cart[index].subtotal = $scope.cart[index].sale_price * $scope.cart[index].quantity;
        return $scope.cart[index].subtotal.toFixed();
    }

    $scope.purchaseSubtotalFn = function (index) {
        $scope.cart[index].purchase_subtotal = $scope.cart[index].purchase_price * $scope.cart[index].quantity;
        return $scope.cart[index].purchase_subtotal.toFixed();
    }

    $scope.getTotalFn = function () {
        var total = 0;
        angular.forEach($scope.cart, function (item) {
            total += parseFloat(item.subtotal);
        });

        $scope.amount.total = total.toFixed();
        return $scope.amount.total;
    }

    $scope.getTotalQtyFn = function () {
        var total = 0;
        angular.forEach($scope.cart, function (item) {
            total += parseFloat(item.quantity);
        });

        $scope.amount.totalqty = total;
        return $scope.amount.totalqty;
    }

    $scope.getPurchaseTotalFn = function () {
        var total = 0;
        angular.forEach($scope.cart, function (item) {
            total += parseFloat(item.purchase_subtotal);
        });

        $scope.amount.purchase_total = total.toFixed();
        return $scope.amount.purchase_total;
    }

    $scope.getGrandTotalFn = function () {
        var grand_total = 0.0;

        grand_total = (parseFloat($scope.amount.total) - parseFloat($scope.amount.truck_rent) - $scope.total_commission_amount) + parseFloat($scope.amount.labour);
        return $scope.amount.grandTotal = grand_total.toFixed(2);
    }

    $scope.getCurrentTotalFn = function () {
        var total = 0;

        if ($scope.partyInfo.sign == 'Receivable') {
            total = ($scope.partyInfo.balance + parseFloat($scope.amount.grandTotal)) - $scope.amount.paid;

            if (total > 0) {
                $scope.partyInfo.csign = "Receivable";
            } else if (total < 0) {
                $scope.partyInfo.csign = "Payable";
            } else {
                $scope.partyInfo.csign = "Receivable";
            }
        } else {
            total = ($scope.partyInfo.balance + $scope.amount.paid) - parseFloat($scope.amount.grandTotal);

            if (total > 0) {
                $scope.partyInfo.csign = "Payable";
            } else if (total < 0) {
                $scope.partyInfo.csign = "Receivable";
            } else {
                $scope.partyInfo.csign = "Receivable";
            }
        }

        $scope.amount.due = total.toFixed(2);
        $scope.presentBalance = Math.abs(total.toFixed(2));

        /*
		  console.log("Current Balance =>" +  $scope.presentBalance);
	      console.log("Current Sign =>" + $scope.partyInfo.csign);
		  console.log("Credit Limit =>" + $scope.partyInfo.cl);
		 */

        if ($scope.stype == "credit") {
            if ($scope.partyInfo.csign == "Receivable" && $scope.presentBalance <= $scope.partyInfo.cl) {
                $scope.isDisabled = false;
                $scope.message = "";
            } else if ($scope.partyInfo.csign == "Payable") {
                $scope.isDisabled = false;
                $scope.message = "";
            } else {
                $scope.isDisabled = true;
                $scope.message = "Total is being crossed the Credit Limit!";
            }
        }

        return $scope.presentBalance;
    }

    $scope.partyInfo = {
        code: '',
        name: '',
        contact: '',
        address: '',
        balance: 0,
        payment: 0,
        cl: 0,
        sign: 'Receivable',
        csign: 'Receivable'
    };

    $scope.findPartyFn = function () {
        if (typeof $scope.partyCode != 'undefined') {
            var condition = {
                from: 'crushing_parties',
                join: 'crushing_partybalance',
                cond: 'crushing_parties.code=crushing_partybalance.code',
                where: {'crushing_parties.code': $scope.partyCode}
            };

            $http({
                method: 'POST',
                url: url + 'readJoinData',
                data: condition
            }).success(function (response) {
                if (response.length > 0) {
                    $scope.partyInfo.balance = Math.abs(parseFloat(response[0].balance));

                    if (parseFloat(response[0].balance) > 0) {
                        $scope.partyInfo.sign = "Receivable";
                    } else if (parseFloat(response[0].balance) < 0) {
                        $scope.partyInfo.sign = "Payable";
                    } else {
                        $scope.partyInfo.sign = "Receivable";
                    }

                    $scope.partyInfo.code = response[0].code;
                    $scope.partyInfo.name = response[0].name;
                    $scope.partyInfo.contact = response[0].mobile;
                    $scope.partyInfo.address = response[0].address;
                    $scope.partyInfo.cl = parseFloat(response[0].credit_limit);
                } else {
                    $scope.partyInfo = {};

                    $scope.partyInfo.balance = 0;
                    $scope.partyInfo.sign = "Receivable";
                    $scope.partyInfo.cl = 0;
                }
                //console.log($scope.partyInfo);
            });
        }
    }

    $scope.deleteItemFn = function (index) {
        $scope.cart.splice(index, 1);
    }
});


//  Edit Sale Ctrl
app.controller('EditCrushingSaleCtrl', ['$scope', '$http', function ($scope, $http) {
    $scope.info = {};
    $scope.records = [];
    $scope.oldLabourCost = 0;

    $scope.amount = {
        labour: 0,
        oldTotal: 0,
        discount: 0,
        newTotal: 0,
        oldTotalDiscount: 0,
        newTotalDiscount: 0,
        oldGrandTotal: 0,
        newGrandTotal: 0,
        paid: 0,
        prevoiusPaid: 0,
        truck_rent: 0
    };

    // get commission total
    $scope.commission = {
        quantity: 0,
        amount: 0,
        total: 0.0
    };

    // get Truck total
    $scope.truck = {
        quantity: 0,
        amount: 0,
        total: 0
    };

    $scope.$watch('info.vno', function (voucherNo) {
        // get sale record
        var transmit = {
            from: 'saprecords',
            join: 'sapitems',
            cond: 'saprecords.voucher_no = sapitems.voucher_no',
            where: {'saprecords.voucher_no': voucherNo}
        };

        //console.log(transmit);

        // take action
        $http({
            method: 'POST',
            url: url + 'readJoinData',
            data: transmit
        }).success(function (response) {

            if (response.length > 0) {
                angular.forEach(response, function (row, index) {
                    response[index].discount = parseFloat(row.discount);
                    response[index].crushing_charge = parseFloat(row.crushing_charge);
                    response[index].paid = parseFloat(row.paid);
                    response[index].oldQuantity = parseInt(row.quantity);
                    response[index].newQuantity = parseInt(row.quantity);
                    response[index].purchase_price = parseFloat(row.purchase_price);
                    response[index].newSalePrice = parseFloat(row.sale_price);
                    response[index].oldSalePrice = parseFloat(row.sale_price);
                    response[index].oldSubtotal = 0;
                    response[index].newSubtotal = 0;

                    var where = {
                        table: "stock",
                        cond: {
                            code: row.product_code,
                            unit: "Kg",
                            type: "raw",
                            godown: 1
                        }
                    };

                    $http({
                        method: "POST",
                        url: url + "read",
                        data: where
                    }).success(function (info) {
                        if (info.length > 0) {
                            response[index].product = info[0].name;
                        }
                    });
                });

                // get sapmeta info
                var condition = {
                    table: 'sapmeta',
                    cond: {'sapmeta.voucher_no': voucherNo}
                };

                $http({
                    method: 'POST',
                    url: url + 'read',
                    data: condition
                }).success(function (result) {
                    //console.log(result);
                    if (result.length > 0) {
                        angular.forEach(result, function (row, index) {
                            if (row.meta_key == "truck_fare") {
                                $scope.amount.truck_rent = parseFloat(row.meta_value);
                                $scope.oldTruckRent = parseFloat(row.meta_value);
                            }
                            if (row.meta_key == "commission") {
                                $scope.commission = row.meta_value;
                            }
                            if (row.meta_key == "remaining_commission") {
                                $scope.remaining_commission = row.meta_value;
                            }
                            if (row.meta_key == "labour_cost") {
                                $scope.amount.labour = parseFloat(row.meta_value);
                                $scope.oldLabourCost = parseFloat(row.meta_value);
                            }

                        });
                    }

                });

                //get party information
                var party_where = {
                    table: 'crushing_parties',
                    cond: {code: response[0].party_code}
                }

                $http({
                    method: 'POST',
                    url: url + 'read',
                    data: party_where
                }).success(function (response) {
                    $scope.info.partyName = response[0].name;
                    $scope.info.partyCode = response[0].code;
                    $scope.info.partyMobile = response[0].mobile;
                    $scope.info.partyAddress = response[0].address;
                });


                // get party balance information

                $scope.info.partyCode = response[0].party_code;

                $http({
                    method: 'POST',
                    url: url + 'read',
                    data: {
                        table: 'crushing_partybalance',
                        cond: {code: response[0].party_code}
                    }
                }).success(function (info) {
                    var balance = parseFloat(info[0].balance);

                    $scope.info.previousBalance = Math.abs(balance);
                    $scope.info.sign = (balance >= 0) ? 'Receivable' : 'Payable';

                    //console.log(info);
                });

                $scope.info.date = response[0].sap_at;
                $scope.info.sapType = response[0].sap_type;
                $scope.info.voucher = response[0].voucher_no;
                $scope.info.partyCode = response[0].party_code;
                $scope.amount.previousPaid = response[0].paid;

                $scope.total_commission_amount = parseFloat(response[0].total_discount);

                $scope.amount.oldTotal = parseFloat(response[0].total_bill) + parseFloat(response[0].total_discount);
                $scope.amount.oldTotalDiscount = parseFloat(response[0].total_discount);

                $scope.records = response;

            }

            console.log($scope.records);
        });
    });

    $scope.getOldSubtotalFn = function (index) {
        angular.forEach($scope.records, function (item) {
            item.oldSubtotal = item.oldSalePrice * item.oldQuantity;
        });

        return $scope.records[index].oldSubtotal;
    }

    $scope.getNewSubtotalFn = function (index) {
        angular.forEach($scope.records, function (item) {
            item.newSubtotal = item.newSalePrice * item.newQuantity;
        });

        return $scope.records[index].newSubtotal;
    }

    $scope.getOldGrandTotalFn = function () {
        $scope.amount.oldGrandTotal = ($scope.amount.oldTotal - $scope.amount.oldTotalDiscount - $scope.amount.discount) + $scope.oldLabourCost - $scope.oldTruckRent;
        return $scope.amount.oldGrandTotal;
    }

    $scope.crushingChargeFn = function () {
        /*var totalQty = 0;
        angular.forEach($scope.records, function(item) {
        	totalQty += (item.newQuantity);
        });*/

        //$scope.amount.crushingCharge = ($scope.records[0].crushing_charge*totalQty);
        $scope.amount.crushingCharge = ($scope.records[0].crushing_charge);
        return $scope.amount.crushingCharge.toFixed(2);
    }

    $scope.getTotalFn = function () {
        var total = 0;
        angular.forEach($scope.records, function (item) {
            total += (item.newSubtotal) + $scope.amount.labour;
        });

        $scope.amount.newTotal = total;
        return $scope.amount.newTotal;
    }

    $scope.getNewGrandTotalFn = function () {
        $scope.amount.newGrandTotal = $scope.amount.newTotal + $scope.amount.crushingCharge;
        return $scope.amount.newGrandTotal;
    }

    $scope.getGrandTotalDifferenceFn = function () {
        var total = 0;

        total = ($scope.amount.newGrandTotal - $scope.amount.oldGrandTotal);
        $scope.amount.sign = (total >= 0) ? 'Receivable' : 'Payable';
        $scope.amount.difference = Math.abs(total);

        return $scope.amount.difference;
    }

    $scope.getCurrentTotalFn = function () {
        var total = 0;

        if ($scope.amount.sign == 'Receivable' && $scope.info.sign == 'Receivable') {
            total = ($scope.amount.difference + $scope.info.previousBalance) - $scope.amount.paid;
            $scope.info.csign = 'Receivable';
        } else if ($scope.amount.sign == 'Receivable' && $scope.info.sign == 'Payable') {
            total = $scope.amount.difference - ($scope.info.previousBalance + $scope.amount.paid);
            if (total >= 0) {
                $scope.info.csign = 'Receivable';
            } else {
                $scope.info.csign = 'Payable';
            }
        } else if ($scope.amount.sign == 'Payable' && $scope.info.sign == 'Receivable') {
            total = ($scope.amount.difference + $scope.amount.paid) - $scope.info.previousBalance;
            if (total <= 0) {
                $scope.info.csign = 'Receivable';
            } else {
                $scope.info.csign = 'Payable';
            }
        } else {
            total = $scope.amount.difference + ($scope.info.previousBalance + $scope.amount.paid);
            if (total > 0) {
                $scope.info.csign = 'Payable';
            } else {
                $scope.info.csign = 'Receivable';
            }
        }

        return Math.abs(total);
    }

    $scope.totalQuantityFn = function () {
        var total = 0;

        angular.forEach($scope.records, function (item, index) {
            total += item.newQuantity;
        });

        $scope.truck.quantity = total;
        $scope.commission.quantity = total;

        return $scope.truck.quantity;
    }

    $scope.getTruckTotal = function () {
        return $scope.amount.truck_rent = (parseFloat($scope.truck.quantity) * parseFloat($scope.truck.amount)).toFixed(2);
    };

    $scope.getCommissionTotal = function () {
        return $scope.commission.total = (parseFloat($scope.commission.quantity) * parseFloat($scope.commission.amount)).toFixed(2);
    };

}]);


// sale controller
app.controller('CrushingSaleEntryCtrl', function ($scope, $http) {

    $scope.active = true;
    $scope.active1 = false;
    $scope.cart = [];

    $scope.stype = "cash";

    $scope.presentBalance = 0;
    $scope.isDisabled = false;

    $scope.remaining_commission = 0;
    $scope.total_commission_amount = 0;

    $scope.amount = {
        labour: 0,
        total: 0,
        totalqty: 0,
        truck_rent: 0,
        grandTotal: 0,
        paid: 0,
        due: 0
    };

    //get sale type
    $scope.getsaleType = function (type) {
        if (type == "cash") {
            $scope.active = true;
            $scope.active1 = false;
            $scope.partyInfo.balance = 0;
            $scope.partyInfo.sign = "Receivable";
        } else {
            $scope.active = false;
            $scope.active1 = true;
            $scope.partyCode = "";
            $scope.partyInfo.code = "";
            $scope.partyInfo.contact = "";
            $scope.partyInfo.address = "";
        }
    };

    $scope.addNewProductFn = function () {
        if (typeof $scope.product !== 'undefined') {

            var condition = {
                table: 'stock',
                cond: {
                    code: $scope.product.trim(),
                    unit: "Kg",
                    godown: $scope.showroom_id,
                    type: 'raw'
                }
            };
            //console.log(condition);

            $http({
                method: 'POST',
                url: url + 'read',
                data: condition
            }).success(function (response) {
                angular.forEach(response, function (item) {
                    //Getting production cost  Start here
                    var condd = {
                        table: 'materials',
                        cond: {
                            code: item.code,
                            type: 'raw',
                            status: 'available',
                            trash: 0
                        }
                    };
                    //console.log(condd);

                    var name = item.name,
                        str = name.replace(/_/gi, " ").toLowerCase();
                    name = str.replace(/\b[a-z]/g, function (letter) {
                        return letter.toUpperCase();
                    });


                    $http({
                        method: 'POST',
                        url: url + 'read',
                        data: condd
                    }).success(function (product_info) {
                        //Getting production cost End here
                        var newItem = {
                            product: name,
                            product_code: item.code,
                            godown: item.godown,
                            maxQuantity: parseInt(item.quantity),
                            stock_qty: parseInt(item.quantity),
                            quantity: 1.00,
                            bags: 0,
                            unit: "Kg",
                            subtotal: 0,
                            purchase_price: parseFloat(product_info[0].production_cost),
                            sale_price: parseFloat(product_info[0].price),
                        };

                        $scope.cart.push(newItem);
                        //console.log($scope.cart);
                    });
                });
            });
        }
    }

    $scope.qty1 = $scope.qty2 = $scope.qty3 = $scope.qty4 = $scope.qty5 = 0;
    $scope.rate1 = $scope.rate2 = $scope.rate3 = $scope.rate4 = $scope.rate5 = 0;

    //calculate Crushing Charge Start
    $scope.getCrushingAmount1 = function () {
        $scope.crushingAmount1 = 0;
        $scope.crushingAmount1 = parseFloat($scope.qty1) * parseFloat($scope.rate1);
        return $scope.crushingAmount1;
    };

    $scope.getCrushingAmount2 = function () {
        $scope.crushingAmount2 = 0;
        $scope.crushingAmount2 = parseFloat($scope.qty2) * parseFloat($scope.rate2);
        return $scope.crushingAmount2;
    };

    $scope.getCrushingAmount3 = function () {
        $scope.crushingAmount3 = 0;
        $scope.crushingAmount3 = parseFloat($scope.qty3) * parseFloat($scope.rate3);
        return $scope.crushingAmount3;
    };

    $scope.getCrushingAmount4 = function () {
        $scope.crushingAmount4 = 0;
        $scope.crushingAmount4 = parseFloat($scope.qty4) * parseFloat($scope.rate4);
        return $scope.crushingAmount4;
    };

    $scope.getCrushingAmount5 = function () {
        $scope.crushingAmount5 = 0;
        $scope.crushingAmount5 = parseFloat($scope.qty5) * parseFloat($scope.rate5);
        return $scope.crushingAmount5;
    };

    $scope.getTotalCrushingAmount = function () {
        $scope.crushingTotalAmount = parseFloat($scope.crushingAmount1) + parseFloat($scope.crushingAmount2) + parseFloat($scope.crushingAmount3) + parseFloat($scope.crushingAmount4) + parseFloat($scope.crushingAmount5);
        return $scope.crushingTotalAmount;
    };
    //calculate Crushing Charge End


    //calculate Bags no
    $scope.calculateBags = function (i, size) {
        var bag_no = 0;
        bag_no = parseFloat($scope.cart[i].quantity) / parseFloat(size);
        $scope.cart[i].bags = bag_no.toFixed(2);
        return $scope.cart[i].bags;
    };

    $scope.setSubtotalFn = function (index) {
        $scope.cart[index].subtotal = $scope.cart[index].sale_price * $scope.cart[index].quantity;
        return $scope.cart[index].subtotal.toFixed();
    }

    $scope.purchaseSubtotalFn = function (index) {
        $scope.cart[index].purchase_subtotal = $scope.cart[index].purchase_price * $scope.cart[index].quantity;
        return $scope.cart[index].purchase_subtotal.toFixed();
    }

    $scope.getTotalFn = function () {
        var total = 0;
        angular.forEach($scope.cart, function (item) {
            total += parseFloat(item.subtotal);
        });

        $scope.amount.total = total.toFixed();
        return $scope.amount.total;
    }

    $scope.getTotalQtyFn = function () {
        var total = 0;
        angular.forEach($scope.cart, function (item) {
            total += parseFloat(item.quantity);
        });

        $scope.amount.totalqty = total;
        return $scope.amount.totalqty;
    }

    $scope.getPurchaseTotalFn = function () {
        var total = 0;
        angular.forEach($scope.cart, function (item) {
            total += parseFloat(item.purchase_subtotal);
        });

        $scope.amount.purchase_total = total.toFixed();
        return $scope.amount.purchase_total;
    }

    $scope.getGrandTotalFn = function () {
        var grand_total = 0.0;

        //grand_total = parseFloat($scope.amount.total)  + (parseFloat($scope.amount.crushing_charge)*parseFloat($scope.amount.totalqty)) + parseFloat($scope.amount.labour);
        grand_total = parseFloat($scope.amount.total) + (parseFloat($scope.crushingTotalAmount)) + parseFloat($scope.amount.labour);
        return $scope.amount.grandTotal = grand_total.toFixed(2);
    }

    $scope.getCurrentTotalFn = function () {
        var total = 0;

        if ($scope.partyInfo.sign == 'Receivable') {
            total = ($scope.partyInfo.balance + parseFloat($scope.amount.grandTotal)) - $scope.amount.paid;

            if (total > 0) {
                $scope.partyInfo.csign = "Receivable";
            } else if (total < 0) {
                $scope.partyInfo.csign = "Payable";
            } else {
                $scope.partyInfo.csign = "Receivable";
            }
        } else {
            total = ($scope.partyInfo.balance + $scope.amount.paid) - parseFloat($scope.amount.grandTotal);

            if (total > 0) {
                $scope.partyInfo.csign = "Payable";
            } else if (total < 0) {
                $scope.partyInfo.csign = "Receivable";
            } else {
                $scope.partyInfo.csign = "Receivable";
            }
        }

        $scope.amount.due = total.toFixed(2);
        $scope.presentBalance = Math.abs(total.toFixed(2));

        /*
		  console.log("Current Balance =>" +  $scope.presentBalance);
	      console.log("Current Sign =>" + $scope.partyInfo.csign);
		  console.log("Credit Limit =>" + $scope.partyInfo.cl);
		 */

        if ($scope.stype == "credit") {
            if ($scope.partyInfo.csign == "Receivable" && $scope.presentBalance <= $scope.partyInfo.cl) {
                $scope.isDisabled = false;
                $scope.message = "";
            } else if ($scope.partyInfo.csign == "Payable") {
                $scope.isDisabled = false;
                $scope.message = "";
            } else {
                $scope.isDisabled = true;
                $scope.message = "Total is being crossed the Credit Limit!";
            }
        }

        return $scope.presentBalance;
    }

    $scope.partyInfo = {
        code: '',
        name: '',
        contact: '',
        address: '',
        balance: 0,
        payment: 0,
        cl: 0,
        sign: 'Receivable',
        csign: 'Receivable'
    };

    $scope.findPartyFn = function () {
        if (typeof $scope.partyCode != 'undefined') {
            var condition = {
                from: 'crushing_parties',
                join: 'crushing_partybalance',
                cond: 'crushing_parties.code=crushing_partybalance.code',
                where: {'crushing_parties.code': $scope.partyCode}
            };

            $http({
                method: 'POST',
                url: url + 'readJoinData',
                data: condition
            }).success(function (response) {
                if (response.length > 0) {
                    $scope.partyInfo.balance = Math.abs(parseFloat(response[0].balance));

                    if (parseFloat(response[0].balance) > 0) {
                        $scope.partyInfo.sign = "Receivable";
                    } else if (parseFloat(response[0].balance) < 0) {
                        $scope.partyInfo.sign = "Payable";
                    } else {
                        $scope.partyInfo.sign = "Receivable";
                    }

                    $scope.partyInfo.code = response[0].code;
                    $scope.partyInfo.name = response[0].name;
                    $scope.partyInfo.contact = response[0].mobile;
                    $scope.partyInfo.address = response[0].address;
                    $scope.partyInfo.cl = parseFloat(response[0].credit_limit);
                } else {
                    $scope.partyInfo = {};

                    $scope.partyInfo.balance = 0;
                    $scope.partyInfo.sign = "Receivable";
                    $scope.partyInfo.cl = 0;
                }
                //console.log($scope.partyInfo);
            });
        }
    }

    $scope.deleteItemFn = function (index) {
        $scope.cart.splice(index, 1);
    }
});


//  Edit Sale Ctrl
app.controller('EditRawSaleEntryCtrl', ['$scope', '$http', function ($scope, $http) {
    $scope.info = {};
    $scope.records = [];
    $scope.oldLabourCost = 0;

    $scope.amount = {
        labour: 0,
        oldTotal: 0,
        discount: 0,
        newTotal: 0,
        oldTotalDiscount: 0,
        newTotalDiscount: 0,
        oldGrandTotal: 0,
        newGrandTotal: 0,
        paid: 0,
        prevoiusPaid: 0,
        truck_rent: 0
    };

    // get commission total
    $scope.commission = {
        quantity: 0,
        amount: 0,
        total: 0.0
    };

    // get Truck total
    $scope.truck = {
        quantity: 0,
        amount: 0,
        total: 0
    };

    $scope.$watch('info.vno', function (voucherNo) {
        // get sale record
        var transmit = {
            from: 'saprecords',
            join: 'sapitems',
            cond: 'saprecords.voucher_no = sapitems.voucher_no',
            where: {'saprecords.voucher_no': voucherNo}
        };

        //console.log(transmit);

        // take action
        $http({
            method: 'POST',
            url: url + 'readJoinData',
            data: transmit
        }).success(function (response) {

            if (response.length > 0) {
                angular.forEach(response, function (row, index) {
                    response[index].discount = parseFloat(row.discount);
                    response[index].paid = parseFloat(row.paid);
                    response[index].oldQuantity = parseInt(row.quantity);
                    response[index].newQuantity = parseInt(row.quantity);
                    response[index].purchase_price = parseFloat(row.purchase_price);
                    response[index].newSalePrice = parseFloat(row.sale_price);
                    response[index].oldSalePrice = parseFloat(row.sale_price);
                    response[index].oldSubtotal = 0;
                    response[index].newSubtotal = 0;

                    var where = {
                        table: "stock",
                        cond: {
                            code: row.product_code,
                            unit: "Kg",
                            type: "raw",
                            godown: 1
                        }
                    };

                    $http({
                        method: "POST",
                        url: url + "read",
                        data: where
                    }).success(function (info) {
                        if (info.length > 0) {
                            response[index].product = info[0].name;
                        }
                    });
                });

                // get sapmeta info
                var condition = {
                    table: 'sapmeta',
                    cond: {'sapmeta.voucher_no': voucherNo}
                };

                $http({
                    method: 'POST',
                    url: url + 'read',
                    data: condition
                }).success(function (result) {
                    //console.log(result);
                    if (result.length > 0) {
                        angular.forEach(result, function (row, index) {
                            if (row.meta_key == "truck_fare") {
                                $scope.amount.truck_rent = parseFloat(row.meta_value);
                                $scope.oldTruckRent = parseFloat(row.meta_value);
                            }
                            if (row.meta_key == "commission") {
                                $scope.commission = row.meta_value;
                            }
                            if (row.meta_key == "remaining_commission") {
                                $scope.remaining_commission = row.meta_value;
                            }
                            if (row.meta_key == "labour_cost") {
                                $scope.amount.labour = parseFloat(row.meta_value);
                                $scope.oldLabourCost = parseFloat(row.meta_value);
                            }

                        });
                    }

                });

                //get party information
                var party_where = {
                    table: 'parties',
                    cond: {code: response[0].party_code}
                }

                $http({
                    method: 'POST',
                    url: url + 'read',
                    data: party_where
                }).success(function (response) {
                    $scope.info.partyName = response[0].name;
                    $scope.info.partyCode = response[0].code;
                    $scope.info.partyMobile = response[0].mobile;
                    $scope.info.partyAddress = response[0].address;
                });


                // get party balance information

                $scope.info.partyCode = response[0].party_code;

                $http({
                    method: 'POST',
                    url: url + 'read',
                    data: {
                        table: 'partybalance',
                        cond: {code: response[0].party_code}
                    }
                }).success(function (info) {
                    var balance = parseFloat(info[0].balance);

                    $scope.info.previousBalance = Math.abs(balance);
                    $scope.info.sign = (balance >= 0) ? 'Receivable' : 'Payable';

                    //console.log(info);
                });

                $scope.info.date = response[0].sap_at;
                $scope.info.sapType = response[0].sap_type;
                $scope.info.voucher = response[0].voucher_no;
                $scope.info.partyCode = response[0].party_code;
                $scope.amount.previousPaid = response[0].paid;

                $scope.total_commission_amount = parseFloat(response[0].total_discount);

                $scope.amount.oldTotal = parseFloat(response[0].total_bill) + parseFloat(response[0].total_discount);
                $scope.amount.oldTotalDiscount = parseFloat(response[0].total_discount);

                $scope.records = response;

            }

            console.log($scope.records);
        });
    });

    $scope.getOldSubtotalFn = function (index) {
        angular.forEach($scope.records, function (item) {
            item.oldSubtotal = item.oldSalePrice * item.oldQuantity;
        });

        return $scope.records[index].oldSubtotal;
    }

    $scope.getNewSubtotalFn = function (index) {
        angular.forEach($scope.records, function (item) {
            item.newSubtotal = item.newSalePrice * item.newQuantity;
        });

        return $scope.records[index].newSubtotal;
    }

    $scope.getOldGrandTotalFn = function () {
        $scope.amount.oldGrandTotal = ($scope.amount.oldTotal - $scope.amount.oldTotalDiscount - $scope.amount.discount) + $scope.oldLabourCost - $scope.oldTruckRent;
        return $scope.amount.oldGrandTotal;
    }

    $scope.getTotalFn = function () {
        var total = 0;
        angular.forEach($scope.records, function (item) {
            total += (item.newSubtotal) + $scope.amount.labour;
        });

        $scope.amount.newTotal = total;
        return $scope.amount.newTotal;
    }

    $scope.getNewGrandTotalFn = function () {
        $scope.amount.newGrandTotal = $scope.amount.newTotal - $scope.amount.newTotalDiscount - $scope.amount.truck_rent;
        return $scope.amount.newGrandTotal;
    }

    $scope.getGrandTotalDifferenceFn = function () {
        var total = 0;

        total = ($scope.amount.newGrandTotal - $scope.amount.oldGrandTotal);
        $scope.amount.sign = (total >= 0) ? 'Receivable' : 'Payable';
        $scope.amount.difference = Math.abs(total);

        return $scope.amount.difference;
    }

    $scope.getCurrentTotalFn = function () {
        var total = 0;

        if ($scope.amount.sign == 'Receivable' && $scope.info.sign == 'Receivable') {
            total = ($scope.amount.difference + $scope.info.previousBalance) - $scope.amount.paid;
            $scope.info.csign = 'Receivable';
        } else if ($scope.amount.sign == 'Receivable' && $scope.info.sign == 'Payable') {
            total = $scope.amount.difference - ($scope.info.previousBalance + $scope.amount.paid);
            if (total >= 0) {
                $scope.info.csign = 'Receivable';
            } else {
                $scope.info.csign = 'Payable';
            }
        } else if ($scope.amount.sign == 'Payable' && $scope.info.sign == 'Receivable') {
            total = ($scope.amount.difference + $scope.amount.paid) - $scope.info.previousBalance;
            if (total <= 0) {
                $scope.info.csign = 'Receivable';
            } else {
                $scope.info.csign = 'Payable';
            }
        } else {
            total = $scope.amount.difference + ($scope.info.previousBalance + $scope.amount.paid);
            if (total > 0) {
                $scope.info.csign = 'Payable';
            } else {
                $scope.info.csign = 'Receivable';
            }
        }

        return Math.abs(total);
    }

    $scope.totalQuantityFn = function () {
        var total = 0;

        angular.forEach($scope.records, function (item, index) {
            total += item.newQuantity;
        });

        $scope.truck.quantity = total;
        $scope.commission.quantity = total;

        return $scope.truck.quantity;
    }

    $scope.getTruckTotal = function () {
        return $scope.amount.truck_rent = (parseFloat($scope.truck.quantity) * parseFloat($scope.truck.amount)).toFixed(2);
    };

    $scope.getCommissionTotal = function () {
        return $scope.commission.total = (parseFloat($scope.commission.quantity) * parseFloat($scope.commission.amount)).toFixed(2);
    };

}]);


// sale controller
app.controller('saleEntryCtrl', function ($scope, $http) {

    $scope.cart = [];
    $scope.isDisabled = false;

    // initial party info
    $scope.partyInfo = {
        name: '',
        mobile: '',
        address: '',
        balance: 0,
        previous_balance: 0,
        current_balance: 0,
        sign: 'Receivable',
        csign: 'Receivable'
    };


    $scope.sap_type = 'credit';
    $scope.cashBtn = 'btn-default';
    $scope.creditBtn = 'btn-success';

    $scope.setSaleType = function (saleType) {

        $scope.partyInfo = {
            name: '',
            mobile: '',
            address: '',
            balance: 0,
            previous_balance: 0,
            current_balance: 0,
            sign: 'Receivable',
            csign: 'Receivable'
        };

        if (typeof saleType !== "undefined" && saleType == 'cash') {
            
            $scope.cashBtn = 'btn-success';
            $scope.creditBtn = 'btn-default';
            $scope.sap_type = 'cash';
        } else {
            
            $scope.cashBtn = 'btn-default';
            $scope.creditBtn = 'btn-success';
            $scope.sap_type = 'credit';
        }
    }


    // get party info and balance
    $scope.findPartyFn = function (party_code) {

        $scope.partyInfo = {
            name: '',
            mobile: '',
            address: '',
            balance: 0,
            previous_balance: 0,
            current_balance: 0,
            sign: 'Receivable',
            csign: 'Receivable'
        };

        if (typeof party_code != 'undefined' && party_code != '') {

            var partyWhere = {
                table: 'parties',
                cond: {
                    type: 'client',
                    code: party_code,
                    trash: 0
                },
                select: ['code', 'name', 'mobile', 'address', 'client_type'],
                order_col: 'code',
                order_by: 'asc'
            };
            console.log(partyWhere);

            $http({
                method: 'POST',
                url: url + 'result',
                data: partyWhere
            }).success(function (partyRes) {

                if (partyRes.length > 0) {

                    // get party info
                    $scope.partyInfo.name = partyRes[0].name;
                    $scope.partyInfo.mobile = partyRes[0].mobile;
                    $scope.partyInfo.address = partyRes[0].address;

                    // get supplier balance
                    $http({
                        method: "POST",
                        url: url + "client_balance",
                        data: {party_code: partyRes[0].code}
                    }).success(function (balanceRes) {
                        $scope.partyInfo.balance = Math.abs(parseFloat(balanceRes.balance));
                        $scope.partyInfo.previous_balance = parseFloat(balanceRes.balance);
                        $scope.partyInfo.sign = balanceRes.status;
                    });

                }
            });
        }
    }

    // add product
    $scope.addNewProductFn = function (productionId) {

        if (typeof productionId !== 'undefined' && productionId != '') {

            $http({
                method: 'POST',
                url: url + 'join',
                data: {
                    tableFrom: 'production_items',
                    tableTo: 'materials',
                    joinCond: 'production_items.product_code=materials.code',
                    cond: {'production_items.id': productionId},
                    select: ['production_items.*', 'SUM(production_items.quantity - production_items.sale_quantity) AS quantity', 'materials.name', 'materials.unit', 'materials.dealer_price']
                }
            }).success(function (response) {

                if (response.length > 0) {
                    angular.forEach(response, function (row) {

                        //var salePrice = ($scope.sap_type == 'cash') ? parseFloat(row.sale_price) : parseFloat(row.dealer_price);

                        var item = {
                            production_item_id: row.id,
                            product_name: row.name,
                            product_code: row.product_code,
                            unit: row.unit,
                            stock_qty: parseFloat(row.quantity),
                            purchase_price: parseFloat(row.purchase_price),
                            sale_price: parseFloat(row.sale_price),
                            quantity: '',
                            subtotal: 0,
                        };

                        $scope.cart.push(item);
                    });
                }
            });
        }
    }

    $scope.setSubtotalFn = function (index) {
        var quantity = !isNaN(parseFloat($scope.cart[index].quantity)) ? parseFloat($scope.cart[index].quantity) : 0;
        $scope.cart[index].subtotal = $scope.cart[index].sale_price * quantity;
        return $scope.cart[index].subtotal.toFixed();
    }

    $scope.calculateWeight = function (i) {
        $scope.cart[i].total_weight = parseFloat($scope.cart[i].weight) * parseFloat($scope.cart[i].quantity);
        return $scope.cart[i].total_weight;
    };

    $scope.totalQuantity = 0;
    $scope.getTotalFn = function () {
        var totalAmount = totalQuantity = 0;
        angular.forEach($scope.cart, function (item) {
            totalAmount += parseFloat(item.subtotal);
            totalQuantity += !isNaN(parseFloat(item.quantity)) ? parseFloat(item.quantity) : 0;
        });

        $scope.totalQuantity = totalQuantity;
        return Math.abs(totalAmount.toFixed(2));
    }

    $scope.getGrandTotalFn = function () {
        var totalDiscount = !isNaN(parseFloat($scope.totalDiscount)) ? parseFloat($scope.totalDiscount) : 0;
        var grandTotal = parseFloat($scope.getTotalFn()) - totalDiscount;
        return Math.abs(grandTotal.toFixed(2));
    }

    $scope.getCurrentTotalFn = function () {

        var payment = !isNaN(parseFloat($scope.payment)) ? parseFloat($scope.payment) : 0;
        var balance = $scope.partyInfo.previous_balance + parseFloat($scope.getGrandTotalFn()) - payment;

        $scope.partyInfo.csign = (balance < 0 ? 'Payable' : 'Receivable');
        $scope.partyInfo.current_balance = balance;

        return Math.abs(balance.toFixed(2));
    }

    $scope.deleteItemFn = function (index) {
        $scope.cart.splice(index, 1);
    }
});

//  Edit Sale Ctrl
app.controller('editSaleEntryCtrl', ['$scope', '$http', function ($scope, $http) {

    $scope.cart = [];
    $scope.isDisabled = true;

    $scope.previous_balance = 0;
    $scope.current_balance = 0;
    $scope.csign = 'Receivable';


    $scope.$watch('voucher_no', function (voucherNo) {

        if (typeof voucherNo !== 'undefined' && voucherNo != '') {

            $http({
                method: 'POST',
                url: siteurl + 'sale/edit_sale/getVoucherItems',
                data: {voucher_no: voucherNo}
            }).success(function (response) {
                if (response.length > 0) {
                    angular.forEach(response, function (row) {
                        row.stock_qty = parseFloat(row.stock_qty);
                        row.quantity = parseFloat(row.quantity);
                        row.sale_price = parseFloat(row.sale_price);
                        $scope.cart.push(row);
                    });
                }
            });
        }
    });


    // add product
    $scope.addNewProductFn = function (productionId) {

        if (typeof productionId !== 'undefined' && productionId != '') {

            $http({
                method: 'POST',
                url: url + 'join',
                data: {
                    tableFrom: 'production_items',
                    tableTo: 'materials',
                    joinCond: 'production_items.product_code=materials.code',
                    cond: {'production_items.id': productionId},
                    select: ['production_items.*', 'SUM(production_items.quantity - production_items.sale_quantity) AS quantity', 'materials.name', 'materials.unit', 'materials.dealer_price']
                }
            }).success(function (response) {

                if (response.length > 0) {
                    angular.forEach(response, function (row) {

                        //var salePrice = ($scope.sap_type == 'cash') ? parseFloat(row.sale_price) : parseFloat(row.dealer_price);

                        var item = {
                            item_id: '',
                            production_item_id: row.id,
                            product_name: row.name,
                            product_code: row.product_code,
                            unit: row.unit,
                            stock_qty: parseFloat(row.quantity),
                            purchase_price: parseFloat(row.purchase_price),
                            sale_price: parseFloat(row.sale_price),
                            old_quantity: 0,
                            quantity: '',
                            subtotal: 0,
                        };

                        $scope.cart.push(item);
                    });
                }
            });
        }
    }


    $scope.setSubtotalFn = function (index) {
        var quantity = !isNaN(parseFloat($scope.cart[index].quantity)) ? parseFloat($scope.cart[index].quantity) : 0;
        $scope.cart[index].subtotal = $scope.cart[index].sale_price * quantity;
        return $scope.cart[index].subtotal.toFixed();
    }

    $scope.calculateWeight = function (i) {
        $scope.cart[i].total_weight = parseFloat($scope.cart[i].weight) * parseFloat($scope.cart[i].quantity);
        return $scope.cart[i].total_weight;
    };

    $scope.totalQuantity = 0;
    $scope.getTotalFn = function () {
        var totalAmount = totalQuantity = 0;
        angular.forEach($scope.cart, function (item) {
            totalAmount += parseFloat(item.subtotal);
            totalQuantity += !isNaN(parseFloat(item.quantity)) ? parseFloat(item.quantity) : 0;
        });

        $scope.totalQuantity = totalQuantity;
        return Math.abs(totalAmount.toFixed(2));
    }

    $scope.getGrandTotalFn = function () {
        var totalDiscount = !isNaN(parseFloat($scope.totalDiscount)) ? parseFloat($scope.totalDiscount) : 0;
        var grandTotal = parseFloat($scope.getTotalFn()) - totalDiscount;
        return Math.abs(grandTotal.toFixed(2));
    }

    $scope.getCurrentTotalFn = function () {

        var payment = !isNaN(parseFloat($scope.payment)) ? parseFloat($scope.payment) : 0;

        var balance = $scope.previous_balance + parseFloat($scope.getGrandTotalFn()) - payment;

        $scope.csign = (balance < 0 ? 'Payable' : 'Receivable');
        $scope.current_balance = balance;

        $scope.isDisabled = ($scope.totalQuantity > 0 ? false : true);

        return Math.abs(balance.toFixed(2));
    }

    $scope.deleteCart = [];
    $scope.deleteItemFn = function (index) {

        if ($scope.cart[index].item_id) {
            var alert = confirm('Do you want to delete this data?');
            if (alert) {

                $scope.deleteCart.push({
                    item_id: $scope.cart[index].item_id,
                    production_item_id: $scope.cart[index].production_item_id,
                    product_code: $scope.cart[index].product_code,
                    quantity: $scope.cart[index].old_quantity,
                })

                $scope.cart.splice(index, 1);
            }
        } else {
            $scope.cart.splice(index, 1);
        }
    }

}]);


// sale controller
app.controller('challanEntryCtrl', function ($scope, $http) {


    $scope.name = '';
    $scope.mobile = '';
    $scope.address = '';

    $scope.getTransportInfo = function (transportId) {

        $scope.name = '';
        $scope.mobile = '';
        $scope.address = '';

        if (typeof transportId !== 'undefined' && transportId != '') {
            $http({
                method: 'post',
                url: url + 'result',
                data: {
                    table: 'transport',
                    cond: {id: transportId}
                }
            }).success(function (response) {

                if (response.length > 0) {

                    $scope.name = response[0].name;
                    $scope.mobile = response[0].mobile;
                    $scope.address = response[0].address;
                }
            });
        }
    }


    $scope.cart = [];
    $scope.$watch('voucherNo', function (voucherNo) {

        if (typeof voucherNo !== 'undefined' && voucherNo != '') {


            $http({
                method: 'post',
                url: siteurl + 'sale/challan/ajaxVoucherItems',
                data: {voucher_no: voucherNo}
            }).success(function (response) {

                if (response.length > 0) {

                    angular.forEach(response, function (row) {

                        row.purchase_price = parseFloat(row.purchase_price);
                        row.sale_price = parseFloat(row.sale_price);
                        row.quantity = parseFloat(row.quantity);
                        row.subtotal = parseFloat(row.subtotal);

                        $scope.cart.push(row);
                    })
                }
            });
        }
    });

    $scope.setSubtotalFn = function (index) {
        var subtotal = $scope.cart[index].sale_price * $scope.cart[index].quantity;
        $scope.cart[index].subtotal = Math.abs(subtotal.toFixed(2));
        return $scope.cart[index].subtotal;
    }

    $scope.totalQuantity = 0;
    $scope.getTotalFn = function (index) {
        var totalAmount = totalQuantity = 0;
        angular.forEach($scope.cart, function (row) {
            totalAmount += row.subtotal;
            totalQuantity += row.quantity;
        });

        $scope.totalQuantity = totalQuantity;
        return Math.abs(totalAmount.toFixed(2));
    }

    $scope.deleteItemFn = function (index) {
        $scope.cart.splice(index, 1);
    }
});


app.controller('dueCollectCtrl', ['$scope', '$http', function ($scope, $http) {

    $scope.amount = {
        total_bill: 0,
        previousPaid: 0,
        paid: '',
        grandTotal: 0,
        remission: '',
        previousRemission: 0,
        totalRemission: 0,
        due: 0
    }

    // get previous total remission
    $scope.$watch('voucher_no', function (voucher_no) {

        var listWhere = {
            table: 'due_collectio',
            cond: {voucher_no: voucher_no}
        }

        $http({
            method: 'POST',
            url: url + 'result',
            data: listWhere
        }).success(function (response) {
            if (response.length > 0) {
                angular.forEach(response, function (item) {
                    $scope.amount.previousRemission += parseFloat(item.remission);
                });
            }
        });
    });

    // get grand total
    $scope.getTotalFn = function () {
        var total = 0;
        var paid = (typeof $scope.amount.paid !== 'undefined' && $scope.amount.paid != '') ? parseFloat($scope.amount.paid) : 0;
        total = parseFloat($scope.amount.previousPaid) + paid;
        $scope.totalPaid = total;
        return total;
    }

    // get total remission
    $scope.getTotalRemissionFn = function () {
        var remission = (typeof $scope.amount.remission !== 'undefined' && $scope.amount.remission != '') ? parseFloat($scope.amount.remission) : 0;
        var total = 0;
        total = parseFloat($scope.amount.previousRemission) + parseFloat(remission);
        $scope.remissionDiff = total;
        return total;
    }

    // get total due
    $scope.getTotalDueFn = function () {
        var total = 0;
        total = $scope.amount.total_bill - ($scope.getTotalFn() + $scope.getTotalRemissionFn());
        return total;
    }

}]);


// packaging entry ctrl
app.controller('PackageEntryCtrl', function ($scope, $http) {

    // disable submit button
    $scope.isDisabled = true;

    // all data store in this card
    $scope.cart = [];

    // set default amount
    $scope.amount = {};

    // add product
    $scope.addNewProductFn = function () {
        if (typeof $scope.productCode !== 'undefined') {

            var condition = {
                tableFrom: 'stock',
                tableTo: ['materials'],
                joinCond: ['stock.code=materials.code AND stock.type=materials.type'],
                cond: {
                    'stock.code': $scope.productCode,
                    'stock.type': 'raw',
                    //'materials.raw_type': 'packaging'
                },
                select: ['stock.*']
            };

            $http({
                method: 'POST',
                url: url + 'join',
                data: condition
            }).success(function (response) {
                if (response.length > 0) {

                    // push all product in cart
                    angular.forEach(response, function (item) {
                        var newItem = {
                            product_code: item.code,
                            product: item.name,
                            unit: item.unit,
                            godown: item.godown,
                            stock: parseFloat(item.quantity),
                            quantity: '',
                            subtotal: 0,
                            purchase_subtotal: 0,
                            purchase_price: parseFloat(item.purchase_price)
                        };
                        $scope.cart.push(newItem);
                    });
                }
            });

            $scope.isDisabled = false;
        }
    }

    // purchase subtotal
    $scope.purchaseSubtotalFn = function (index) {
        var total = 0;
        total = $scope.cart[index].purchase_price * $scope.cart[index].quantity;
        $scope.cart[index].purchase_subtotal = Math.abs(parseFloat(total).toFixed(2));
        return $scope.cart[index].purchase_subtotal;
    }

    // get total quantity
    $scope.getTotalQtyFn = function () {
        var total = 0;
        angular.forEach($scope.cart, function (item) {
            total += ((typeof parseFloat(item.quantity) !== "undefined" && item.quantity != '') ? parseFloat(item.quantity) : 0);
        });
        total = Math.abs(total.toFixed(2));
        return total;
    }

    // get purchase total
    $scope.getPurchaseTotalFn = function () {
        var total = 0;
        angular.forEach($scope.cart, function (item) {
            total += parseFloat(item.purchase_subtotal);
        });

        $scope.amount.purchase_total = Math.abs(parseFloat(total).toFixed(2));
        return $scope.amount.purchase_total;
    }

    // delete item
    $scope.deleteItemFn = function (index) {
        $scope.cart.splice(index, 1);
    }
});

// packaging entry ctrl
app.controller('machineryUsedEntryCtrl', function ($scope, $http) {

    // disable submit button
    $scope.isDisabled = true;

    // all data store in this card
    $scope.cart = [];

    // set default amount
    $scope.amount = {};

    // add product
    $scope.addNewProductFn = function () {
        if (typeof $scope.productCode !== 'undefined') {

            var condition = {
                tableFrom: 'stock',
                tableTo: ['materials'],
                joinCond: ['stock.code=materials.code AND stock.type=materials.type'],
                cond: {
                    'stock.code': $scope.productCode,
                    'stock.type': 'raw',
                },
                select: ['stock.*']
            };

            $http({
                method: 'POST',
                url: url + 'join',
                data: condition
            }).success(function (response) {
                if (response.length > 0) {

                    // push all product in cart
                    angular.forEach(response, function (item) {
                        var newItem = {
                            product_code: item.code,
                            product: item.name,
                            unit: item.unit,
                            godown: item.godown,
                            stock: parseFloat(item.quantity),
                            quantity: '',
                            subtotal: 0,
                            purchase_subtotal: 0,
                            purchase_price: parseFloat(item.purchase_price)
                        };
                        $scope.cart.push(newItem);
                    });
                }
            });

            $scope.isDisabled = false;
        }
    }

    // purchase subtotal
    $scope.purchaseSubtotalFn = function (index) {
        var total = 0;
        total = $scope.cart[index].purchase_price * $scope.cart[index].quantity;
        $scope.cart[index].purchase_subtotal = Math.abs(parseFloat(total).toFixed(2));
        return $scope.cart[index].purchase_subtotal;
    }

    // get total quantity
    $scope.getTotalQtyFn = function () {
        var total = 0;
        angular.forEach($scope.cart, function (item) {
            total += ((typeof parseFloat(item.quantity) !== "undefined" && item.quantity != '') ? parseFloat(item.quantity) : 0);
        });
        total = Math.abs(total.toFixed(2));
        return total;
    }

    // get purchase total
    $scope.getPurchaseTotalFn = function () {
        var total = 0;
        angular.forEach($scope.cart, function (item) {
            total += parseFloat(item.purchase_subtotal);
        });

        $scope.amount.purchase_total = Math.abs(parseFloat(total).toFixed(2));
        return $scope.amount.purchase_total;
    }

    // delete item
    $scope.deleteItemFn = function (index) {
        $scope.cart.splice(index, 1);
    }
});


//  Return Sale Ctrl
app.controller('ReturnSaleEntryCtrl', ['$scope', '$http', function ($scope, $http) {
    $scope.info = {};
    $scope.records = [];

    $scope.amount = {
        labour: 0,
        oldTotal: 0,
        discount: 0,
        newTotal: 0,
        oldTotalDiscount: 0,
        newTotalDiscount: 0,
        oldGrandTotal: 0,
        newGrandTotal: 0,
        paid: 0,
        truck_rent: 0
    };


    // get commission total
    $scope.commission = 0;
    $scope.remaining_commission = 0;


    // get Truck total
    $scope.truck = {
        quantity: 0,
        amount: 0,
        total: 0
    };


    $scope.$watch('info.vno', function (voucherNo) {
        // get sale record
        var transmit = {
            from: 'saprecords',
            join: 'sapitems',
            cond: 'saprecords.voucher_no = sapitems.voucher_no',
            where: {'saprecords.voucher_no': voucherNo}
        };

        //console.log(transmit);

        // take action
        $http({
            method: 'POST',
            url: url + 'readJoinData',
            data: transmit
        }).success(function (response) {

            if (response.length > 0) {
                angular.forEach(response, function (row, index) {
                    response[index].discount = parseFloat(row.discount);
                    response[index].paid = parseFloat(row.paid);
                    response[index].oldQuantity = parseInt(row.quantity);
                    response[index].newQuantity = parseInt(row.quantity);
                    response[index].purchase_price = parseFloat(row.purchase_price);
                    response[index].newSalePrice = parseFloat(row.sale_price);
                    response[index].oldSalePrice = parseFloat(row.sale_price);
                    response[index].oldSubtotal = 0;
                    response[index].newSubtotal = 0;


                    var where = {
                        table: "stock",
                        cond: {
                            code: row.product_code,
                            unit: "Kg",
                            type: "finish_product",
                            godown: 1
                        }
                    };

                    $http({
                        method: "POST",
                        url: url + "read",
                        data: where
                    }).success(function (info) {
                        if (info.length > 0) {
                            response[index].product = info[0].name;
                        }
                    });
                });


                // get sapmeta info
                var condition = {
                    table: 'sapmeta',
                    cond: {'sapmeta.voucher_no': voucherNo}
                };

                $http({
                    method: 'POST',
                    url: url + 'read',
                    data: condition
                }).success(function (result) {
                    console.log(result);
                    if (result.length > 0) {
                        angular.forEach(result, function (row, index) {
                            if (row.meta_key == "truck_fare") {
                                $scope.amount.truck_rent = parseFloat(row.meta_value);
                                $scope.oldTruckRent = parseFloat(row.meta_value);
                            }
                            if (row.meta_key == "commission") {
                                $scope.commission = row.meta_value;
                            }
                            if (row.meta_key == "remaining_commission") {
                                $scope.remaining_commission = row.meta_value;
                            }
                            if (row.meta_key == "labour_cost") {
                                $scope.amount.labour = parseFloat(row.meta_value);
                                $scope.oldLabourCost = parseFloat(row.meta_value);
                            }

                        });
                    }

                    console.log($scope.commission);

                });


                //get party information
                var party_where = {
                    table: 'parties',
                    cond: {code: response[0].party_code}
                }

                $http({
                    method: 'POST',
                    url: url + 'read',
                    data: party_where
                }).success(function (response) {
                    $scope.info.partyName = response[0].name;
                    $scope.info.partyCode = response[0].code;
                    $scope.info.partyMobile = response[0].mobile;
                    $scope.info.partyAddress = response[0].address;
                });


                // get party balance information

                $scope.info.partyCode = response[0].party_code;

                $http({
                    method: 'POST',
                    url: url + 'read',
                    data: {
                        table: 'partybalance',
                        cond: {code: response[0].party_code}
                    }
                }).success(function (info) {
                    var balance = parseFloat(info[0].balance);

                    $scope.info.previousBalance = Math.abs(balance);
                    //$scope.info.sign = (balance <= 0) ? 'Receivable' : 'Payable';
                    $scope.info.sign = (balance >= 0) ? 'Receivable' : 'Payable'; // Edit by sheam

                    console.log(info);
                });


                $scope.info.date = response[0].sap_at;
                $scope.info.sapType = response[0].sap_type;
                $scope.info.voucher = response[0].voucher_no;
                $scope.info.partyCode = response[0].party_code;

                $scope.total_commission_amount = parseFloat(response[0].total_discount);

                $scope.amount.oldTotal = parseFloat(response[0].total_bill);
                $scope.amount.oldTotalDiscount = parseFloat(response[0].total_discount);


                $scope.records = response;

            }

            console.log($scope.records);
        });
    });


    $scope.getOldSubtotalFn = function (index) {
        angular.forEach($scope.records, function (item) {
            item.oldSubtotal = item.oldSalePrice * item.oldQuantity;
        });

        return $scope.records[index].oldSubtotal;
    }

    $scope.getNewSubtotalFn = function (index) {
        angular.forEach($scope.records, function (item) {
            item.newSubtotal = item.newSalePrice * item.newQuantity;
        });

        return $scope.records[index].newSubtotal;
    }

    $scope.getOldGrandTotalFn = function () {

        $scope.amount.oldGrandTotal = $scope.amount.oldTotal;

        return $scope.amount.oldGrandTotal;

    }

    $scope.getTotalFn = function () {
        var total = 0;
        angular.forEach($scope.records, function (item) {
            total += (item.newSubtotal) + $scope.amount.labour;
        });

        $scope.amount.newTotal = total;
        return $scope.amount.newTotal;
    }


    $scope.getTotalQtyFn = function () {
        var total = 0;
        angular.forEach($scope.records, function (item) {
            total += parseFloat(item.newQuantity);
        });

        $scope.amount.totalqty = total;
        return $scope.amount.totalqty;
    }

    $scope.getNewGrandTotalFn = function () {
        //$scope.amount.newGrandTotal = $scope.amount.newTotal - $scope.amount.newTotalDiscount - $scope.amount.truck_rent;
        //$scope.amount.newGrandTotal = $scope.amount.newTotal;
        //return $scope.amount.newGrandTotal;

        var total = 0;
        angular.forEach($scope.records, function (item) {
            total += (item.newSubtotal) + $scope.amount.labour;
        });

        $scope.amount.newGrandTotal = total - $scope.amount.oldTotalDiscount - $scope.oldTruckRent;
        return $scope.amount.newGrandTotal;
    }

    $scope.getGrandTotalDifferenceFn = function () {
        var total = 0;

        total = ($scope.amount.newGrandTotal - $scope.amount.oldGrandTotal);
        $scope.amount.sign = (total >= 0) ? 'Receivable' : 'Payable';
        $scope.amount.difference = Math.abs(total);

        return $scope.amount.difference.toFixed(2);
    }

    $scope.getCurrentTotalFn = function () {
        var total = 0;

        if ($scope.amount.sign == 'Receivable' && $scope.info.sign == 'Receivable') {
            total = ($scope.amount.difference + $scope.info.previousBalance) - $scope.amount.paid;
            $scope.info.csign = 'Receivable';
        } else if ($scope.amount.sign == 'Receivable' && $scope.info.sign == 'Payable') {
            total = $scope.amount.difference - ($scope.info.previousBalance + $scope.amount.paid);
            if (total >= 0) {
                $scope.info.csign = 'Receivable';
            } else {
                $scope.info.csign = 'Payable';
            }
        } else if ($scope.amount.sign == 'Payable' && $scope.info.sign == 'Receivable') {
            //total = ($scope.amount.difference + $scope.amount.paid) - $scope.info.previousBalance;
            total = ($scope.info.previousBalance - $scope.amount.difference) + $scope.amount.paid; //Edit by Sheam
            if (total < 0) {
                $scope.info.csign = 'Payable';
            } else {
                $scope.info.csign = 'Receivable';
            }
        } else {
            total = $scope.amount.difference + ($scope.info.previousBalance - $scope.amount.paid);

            if (total > 0) {
                $scope.info.csign = 'Payable';
            } else {
                $scope.info.csign = 'Receivable';
            }
        }

        return Math.abs(total.toFixed(2));
    }


    $scope.totalQuantityFn = function () {
        var total = 0;

        angular.forEach($scope.records, function (item, index) {
            total += item.newQuantity;
        });

        $scope.truck.quantity = total;
        $scope.commission.quantity = total;

        return $scope.truck.quantity;
    }

    $scope.getTruckTotal = function () {
        return $scope.amount.truck_rent = (parseFloat($scope.truck.quantity) * parseFloat($scope.truck.amount)).toFixed(2);
    };

    $scope.getCommissionTotal = function () {
        return $scope.commission.total = (parseFloat($scope.commission.quantity) * parseFloat($scope.commission.amount)).toFixed(2);
    };


}]);

// Finish Product Adding and Editing Start here -------------------->


// Installment Contrller
app.controller('InstallmentCtrl', function ($scope) {
    $scope.installment = 1;
    $scope.lessAmount = 0;

    $scope.totalAmountFn = function (amount) {
        var total = 0;
        if ($scope.installment_number == 1) {
            total = $scope.due;
        } else {
            total = ((amount * $scope.installment) - $scope.lessAmount).toFixed(2)
        }
        return total;
    }

});


//SMS Controller
app.controller("CustomSMSCtrl", ["$scope", "$log", function ($scope, $log) {
    $scope.msgContant = "";
    $scope.totalChar = 0;
    $scope.msgSize = 1;

    $scope.$watch(function () {
        var charLength = $scope.msgContant.length,
            message = $scope.msgContant,
            messLen = 0;


        var english = /^[~!@#$%^&*(){},.:/-_=+A-Za-z0-9 ]*$/;

        if (english.test(message)) {
            if (charLength <= 160) {
                messLen = 1;
            } else if (charLength <= 306) {
                messLen = 2;
            } else if (charLength <= 459) {
                messLen = 3;
            } else if (charLength <= 612) {
                messLen = 4;
            } else if (charLength <= 765) {
                messLen = 5;
            } else if (charLength <= 918) {
                messLen = 6;
            } else if (charLength <= 1071) {
                messLen = 7;
            } else if (charLength <= 1080) {
                messLen = 8;
            } else {
                messLen = "Equal to an MMS!";
            }

        } else {
            if (charLength <= 63) {
                messLen = 1;
            } else if (charLength <= 126) {
                messLen = 2;
            } else if (charLength <= 189) {
                messLen = 3;
            } else if (charLength <= 252) {
                messLen = 4;
            } else if (charLength <= 315) {
                messLen = 5;
            } else if (charLength <= 378) {
                messLen = 6;
            } else if (charLength <= 441) {
                messLen = 7;
            } else if (charLength <= 504) {
                messLen = 8;
            } else {
                messLen = "Equal to an MMS!";
            }
        }


        $scope.totalChar = charLength;
        $scope.msgSize = messLen;
    });
}]);


app.controller('AllCustomerCtrl', function ($scope, $http, $window) {
    var getAllCustomer = function () {
        $scope.results = [];
        var condition = {
            table: 'orders',
            groupBy: 'name'
        };

        $http({
            method: 'POST',
            url: url + 'read',
            data: condition
        }).success(function (response) {
            angular.forEach(response, function (row, key) {
                row.sl = (key + 1);
            });

            $scope.results = response;
        });
    }


    $scope.deleteCustomerFn = function (ono) {
        var condition = {
            table: 'orders',
            cond: {order_no: ono}
        };

        if ($window.confirm("Are you sure want to delete this Customer?")) {
            $http({
                method: 'POST',
                url: url + 'delete',
                data: condition
            }).success(function (response) {
                getAllCustomer();
            });
        }
    }

    // call the function
    getAllCustomer();
});


app.controller('SearchReportCtrl', function ($scope, $http, $window) {
    var loadData = function () {
        $scope.orders = [];
        var condition = {
            table: 'orders',
            cond: {},
            groupBy: 'order_no'
        };

        if (typeof $scope.search !== "undefined") {
            angular.forEach($scope.search, function (value, field) {
                if (value !== "") {
                    condition.cond[field] = value;
                }
            });

            if (typeof $scope.date !== "undefined") {
                angular.forEach($scope.date, function (value, field) {
                    if (value != "" && field == "from") {
                        condition.cond["order_date >="] = value;
                    }
                    if (value != "" && field == "to") {
                        condition.cond["order_date <="] = value;
                    }
                });
            }
        } else {
            alert("Please Selete Status!");
            return false;
        }

        $http({
            method: 'POST',
            url: url + 'read',
            data: condition
        }).success(function (response) {

            if (response.length > 0) {
                console.log(response);
                $scope.active = false;
                angular.forEach(response, function (item, key) {
                    item.sl = key + 1;
                });
                $scope.orders = response;
            } else {
                $scope.orders = [];
                $scope.active = true;
            }

        });
    }

    $scope.searchDataFn = function () {
        // call the loader
        loadData();
    }

    $scope.getGrandTotalFn = function () {
        var total = 0;
        angular.forEach($scope.orders, function (item) {
            total += parseFloat(item.grand_total);
        });

        return total.toFixed(2);
    }
});


// show All Stock Product Ctrl
app.controller('showAllStockProductCtrl', function ($scope, $http, $log) {
    $scope.$watch('showroom_id', function () {
        $scope.allStockProducts = [];
        $scope.reverse = false;

        var where = {
            table: 'stock',
            cond: {
                type: 'retail',
                'quantity >=': 0
            }
        };

        if ($scope.showroom_id != "godown") {
            where.cond.showroom_id = $scope.showroom_id;
        }

        console.log(where);


        //console.log($scope.showroom_id);

        if ($scope.privilege == "admin" && $scope.showroom_id == "godown") {
            where.cond = {type: 'retail', 'quantity >=': 0};
        }

        //console.log(where);
        $http({
            method: 'POST',
            url: url + 'read',
            data: where
        }).success(function (response) {
            console.log(response);

            //Loader
            $("#loading").fadeOut("fast", function () {
                $(".loader-hide").fadeIn('slow');
            });

            angular.forEach(response, function (value, key) {
                value['sl'] = key + 1;

                //Getting showroom value Start here
                var condition = {
                    table: 'showroom',
                    cond: {showroom_id: value.showroom_id}
                };

                $http({
                    method: 'POST',
                    url: url + 'read',
                    data: condition
                }).success(function (emit) {
                    // console.log(emit);
                    if (emit.length > 0) {
                        value["godown_name"] = emit[0].name;
                    }
                });

                // Getting showroom value End here
                $scope.allStockProducts.push(value);
            });

            $log.log($scope.allStockProducts);
        });
    });

    $scope.getTotalFn = function (index) {
        var total = 0;

        total = $scope.allStockProducts[index].quantity * $scope.allStockProducts[index].sell_price;

        $scope.allStockProducts[index].total = total;

        return $scope.allStockProducts[index].total;
    }

    $scope.getQuantityTotalFn = function () {
        var total = 0;
        angular.forEach($scope.allStockProducts, function (item) {
            total += parseInt(item.quantity);
        });

        return total;
    }

    $scope.getGrandTotalFn = function () {
        var total = 0;
        angular.forEach($scope.allStockProducts, function (item) {
            total += item.total;
        });

        return total;
    }

});


// show All Stock Product Ctrl
app.controller('showAllDOStockProductCtrl', function ($scope, $http, $log) {
    $scope.$watch('showroom_id', function () {
        $scope.allStockProducts = [];
        $scope.reverse = false;

        var where = {
            table: 'stock',
            cond: {type: 'do', 'do_in >': 0}
        };


        $http({
            method: 'POST',
            url: url + 'read',
            data: where
        }).success(function (response) {

            //Loader
            $("#loading").fadeOut("fast", function () {
                $(".loader-hide").fadeIn('slow');
            });

            angular.forEach(response, function (value, key) {
                value['sl'] = key + 1;


                // get company name
                var condition = {
                    table: 'saprecords',
                    cond: {voucher_no: value.do_no}
                };

                $http({
                    method: 'POST',
                    url: url + 'read',
                    data: condition
                }).success(function (response) {

                    value['date'] = response[0].sap_at;

                    var where = {
                        table: "parties",
                        cond: {code: response[0].party_code}
                    };

                    $http({
                        method: "POST",
                        url: url + "read",
                        data: where

                    }).success(function (item) {
                        value["company"] = item[0].name;
                    });

                });


                $scope.allStockProducts.push(value);


            });

        });
    });

    $scope.getTotalFn = function (index) {
        var total = 0;

        total = $scope.allStockProducts[index].do_in * $scope.allStockProducts[index].purchase_price;

        $scope.allStockProducts[index].total = total;

        return $scope.allStockProducts[index].total;
    }

    $scope.getDoInTotalFn = function () {
        var total = 0;
        angular.forEach($scope.allStockProducts, function (item) {
            total += parseInt(item.do_in);
        });
        return total;
    }

    $scope.getDoOutTotalFn = function () {
        var total = 0;
        angular.forEach($scope.allStockProducts, function (item) {
            total += parseInt(item.do_out);
        });
        return total;
    }

    $scope.getRemainingTotalFn = function () {
        var total = 0;
        angular.forEach($scope.allStockProducts, function (item) {
            total += parseInt(item.do_in - item.do_out);
        });
        return total;
    }

    $scope.getGrandTotalFn = function () {
        var total = 0;
        angular.forEach($scope.allStockProducts, function (item) {
            total += item.total;
        });
        return total;
    }
});


//Product Distribution
app.controller("productDistribution", function ($scope, $http, $log) {

    $scope.ShowProduct = function () {
        var where = {
            table: 'showroom',
            cond: {showroom_id: $scope.showroom}
        };
        $http({
            method: 'POST',
            url: url + 'read',
            data: where
        }).success(function (response) {
            var p_type = response[0].type;
            //colecting Product Information Start here
            var where = {
                table: 'stock',
                cond: {
                    type: p_type,
                    showroom_id: "godown",
                    godown: $scope.godown,
                    "quantity >": 0
                }
            };
            //console.log(where);
            $http({
                method: 'POST',
                url: url + 'read',
                data: where
            }).success(function (response) {
                $scope.allProducts = response;
                //console.log($scope.allProducts);
            });

            //colecting Product Information End here
        });

    }

    $scope.itemName = [];
    $scope.cart = [];
    $scope.addCart = function () {
        var where = {
            table: 'stock',
            cond: {id: $scope.product_id}
        };

        $http({
            method: 'POST',
            url: url + 'read',
            data: where
        }).success(function (response) {
            var items = $scope.itemName;

            if (response.length > 0) {
                if (items.indexOf(response[0].product_name) == -1) {
                    var each_data = {
                        type: response[0].type,
                        category: response[0].category,
                        product_name: response[0].product_name,
                        subcategory: response[0].subcategory,
                        quantity: response[0].quantity,
                        sell_price: response[0].sell_price,
                        godown: response[0].godown,
                        showroom_id: response[0].showroom_id
                    }

                    $scope.itemName.push(each_data.product_name);
                    $scope.cart.push(each_data);
                }
            }
        });

        // console.log($scope.cart);
    }

    $scope.deleteItemFn = function (index) {
        $scope.cart.splice(index, 1);
        $scope.itemName.splice(index, 1);

        //console.log($scope.itemName)
    }

});


// payroll controller
app.controller("PayrollCtrl", ["$scope", "$http", "$window", "$interval", function ($scope, $http, $window, $interval) {
    $scope.profile = {
        image: siteurl + "private/images/default.png",
        active: false
    };

    $scope.msg = {active: true, content: ""};

    $scope.getProfileFn = function () {
        var where = {
            table: "employee",
            cond: {"emp_id": $scope.data.eid}
        };

        $http({
            method: "POST",
            url: url + 'read',
            data: where
        }).success(function (response) {

            // get data
            if (response.length > 0) {
                $scope.profile.eid = response[0].emp_id;
                $scope.profile.name = response[0].name;
                $scope.profile.post = response[0].designation;
                $scope.profile.mobile = response[0].mobile;
                $scope.profile.email = response[0].email;
                $scope.profile.joining = response[0].joining_date;
                $scope.profile.image = siteurl + response[0].path;

                $scope.basic_salary = parseFloat(response[0].employee_salary);
                $scope.profile.active = true;

            } else {
                $scope.msg.active = false;
                $scope.profile = {};
                $scope.profile.image = siteurl + "private/images/default.png";
                $scope.profile.active = false;
            }

        });
    }

    /*$scope.saveDataFn = function() {
        // chack existance
        var transmit = {
            table: "salary_structure",
            where: {eid: $scope.data.eid}
        };

        $http({
            method: "POST",
            url: siteurl + 'payroll/addBasicSalaryCtrl/exists',
            data: transmit
        }).success(function(response) {
            var transmit = {
                table: "salary_structure",
                dataset: $scope.data
            };

            // store the info
            if(parseInt(response) === 1){
                transmit.dataset = {basic: $scope.data.basic}
                transmit.where = {eid: $scope.data.eid};
            }

            $http({
                method: "POST",
                url: siteurl + 'payroll/addBasicSalaryCtrl/save',
                data: transmit
            }).success(function(response) {
                $scope.msg.active = true;
                $scope.msg.content = response;

                $interval(function(){$window.location.reload();},5000);
            });
        });
    }*/
}]);


app.controller("AdvancedPaymentCtrl", ["$scope", "$http", function ($scope, $http) {

    $scope.advanced_payment = [];
    $scope.total_advanced_payment = 0.00;

    $scope.profile = {
        image: siteurl + "private/images/default.png",
        active: false,
        incentive: false,
        deduction: false,
        bonus: false
    };


    $scope.getEmployeeInfoFn = function (emp_id) {

        var where = {
            table: "employee",
            cond: {emp_id: emp_id}
        };

        $http({
            method: "POST",
            url: url + "read",
            data: where
        }).success(function (response) {
            if (response.length > 0) {

                $scope.profile.active = true;


                $scope.profile.eid = response[0].emp_id;
                $scope.profile.name = response[0].name;
                $scope.profile.post = response[0].designation;
                $scope.profile.mobile = response[0].mobile;
                $scope.profile.email = response[0].email;
                $scope.profile.department = response[0].department;
                $scope.profile.joining = response[0].joining_date;
                $scope.profile.image = siteurl + response[0].path;


                // get advanced payment
                var d = new Date();
                var year = d.getFullYear();
                var month = d.getMonth() + 1;
                month = (month < 10) ? "0" + month : month;

                var where = {
                    table: "advanced_payment",
                    cond: {
                        "emp_id": response[0].emp_id,
                        "trash": '0'
                    }
                };

                $http({
                    method: "POST",
                    url: url + "read",
                    data: where
                }).success(function (response) {
                    if (response.length > 0) {
                        var total = 0.00;
                        var fullMonths = {
                            "01": "January",
                            "02": "February",
                            "03": "March",
                            "04": "April",
                            "05": "May",
                            "06": "June",
                            "07": "July",
                            "08": "August",
                            "09": "September",
                            "10": "October",
                            "11": "November",
                            "12": "December"
                        };
                        angular.forEach(response, function (row, key) {
                            response[key].delete = siteurl + 'salary/salary/delete/' + row.id;
                            response[key].month = fullMonths[row.month];
                            total += parseFloat(row.amount);
                        });

                        $scope.advanced_payment = response;
                        $scope.total_advanced_payment = total.toFixed(2);
                    } else {
                        $scope.advanced_payment = [];
                        $scope.total_advanced_payment = 0;
                    }
                });


            } else {
                $scope.profile = {};

                $scope.profile.image = siteurl + "private/images/default.png";
                $scope.profile.active = false;
                $scope.profile.incentive = false;
                $scope.profile.deduction = false;
            }

        });
    }


    $scope.getSalaryFn = function () {

        $scope.profile.salary = 0;
        $scope.profile.previous_paid = 0;
        $scope.profile.due_salary = 0;


        var year = $scope.year;
        var month = $scope.month;

        var paymentDate = year + '-' + month;

        if (typeof year !== 'undefined' && typeof month !== 'undefined' && typeof $scope.emp_id !== 'undefined' && $scope.emp_id != '') {
            
            console.log(paymentDate);

            $http({
                method: 'post',
                url: url + 'employee_salary',
                data: {emp_id: $scope.emp_id, payment_date: paymentDate}
            }).success(function (salaryInfo) {
                $scope.profile.salary = parseFloat(salaryInfo.employee_salary);
                $scope.profile.previous_paid = parseFloat(salaryInfo.advance_paid) + parseFloat(salaryInfo.paid_amount);
                $scope.profile.due_salary = parseFloat(salaryInfo.due_salary);
            });
        }
    };

    $scope.getDueFn = function () {

        var salary = !isNaN(parseFloat($scope.profile.due_salary)) ? parseFloat($scope.profile.due_salary) : 0;
        var adjustAmount = !isNaN(parseFloat($scope.adjustAmount)) ? parseFloat($scope.adjustAmount) : 0;
        var paid = !isNaN(parseFloat($scope.paid)) ? parseFloat($scope.paid) : 0;

        var due = salary + adjustAmount - paid;

        return due;
    }
}]);

app.controller('dateWisePaymentCtrl', function ($http, $scope) {

    $scope.showResult = false;
    $scope.created_at = '';

    $scope.employeeList = [];

    $scope.getAllEmployeeFn = function () {

        var payment_date = document.querySelector('#dateFrom').value;

        if (typeof payment_date !== 'undefined' && typeof $scope.type !== 'undefined') {

            $scope.created_at = payment_date;

            $http({
                method: 'post',
                url: url + 'result',
                data: {
                    table: 'employee',
                    cond: {type: $scope.type},
                    select: ['emp_id', 'name', 'mobile', 'present_address', 'employee_salary AS salary']
                }
            }).success(function (response) {

                $scope.employeeList = [];

                if (response.length > 0) {

                    $scope.showResult = true;

                    if ($scope.type == 'Daily') {
                        angular.forEach(response, function (item, index) {

                            item.sl = ++index;
                            item.attendance = 1;
                            item.salary = parseFloat(item.salary);
                            item.bonus = 0;
                            item.total = 0;
                            item.payment = 0;

                            $scope.employeeList.push(item);
                        });
                    } else {
                        angular.forEach(response, function (item, index) {

                            item.sl = ++index;
                            item.attendance = 6;
                            item.salary = parseFloat(item.salary);
                            item.bonus = 0;
                            item.total = 0;
                            item.payment = 0;

                            $scope.employeeList.push(item);
                        });
                    }
                } else {
                    $scope.showResult = false;
                }
            });
        }
    };

    $scope.getTotalSalaryFn = function (index) {
        var total = 0;
        var salary = (!isNaN(parseFloat($scope.employeeList[index].salary)) ? parseFloat($scope.employeeList[index].salary) : 0);
        var bonus = (!isNaN(parseFloat($scope.employeeList[index].bonus)) ? parseFloat($scope.employeeList[index].bonus) : 0);
        var attendance = (!isNaN(parseFloat($scope.employeeList[index].attendance)) ? parseFloat($scope.employeeList[index].attendance) : 0);

        total = (salary * attendance) + bonus;
        $scope.employeeList[index].total = total.toFixed(2);
        $scope.employeeList[index].payment = total.toFixed(2);

        return $scope.employeeList[index].total;
    };

});


// Incentive Controller
app.controller("IncentiveCtrl", ["$scope", "$http", function ($scope, $http) {
    $scope.profile = {
        image: siteurl + "private/images/default.png",
        active: false
    };

    $scope.incentives = [
        {fields: "HRA", percentage: 0},
        {fields: "DA", percentage: 0},
        {fields: "TA", percentage: 0},
        {fields: "CCA", percentage: 0},
        {fields: "Medical", percentage: 0}
    ];

    $scope.getProfileFn = function () {
        var where = {
            table: "employee",
            cond: {"emp_id": $scope.eid}
        };

        $http({
            method: "POST",
            url: url + 'read',
            data: where
        }).success(function (response) {
            // get data
            if (response.length > 0) {
                $scope.profile.eid = response[0].emp_id;
                $scope.profile.name = response[0].name;
                $scope.profile.post = response[0].designation;
                $scope.profile.mobile = response[0].mobile;
                $scope.profile.email = response[0].email;
                $scope.profile.joining = response[0].joining_date;
                $scope.profile.image = siteurl + response[0].path;

                $scope.profile.active = true;

                // get basic salary
                var transmit = {
                    table: "salary_structure",
                    cond: {eid: $scope.eid}
                };

                $http({
                    method: "POST",
                    url: url + "read",
                    data: transmit
                }).success(function (response) {
                    if (response.length > 0) {
                        $scope.amount = parseInt(response[0].basic);
                    } else {
                        alert("This employee's basic info not found!");
                    }
                });

                // check incentive active or not
                var transmit = {
                    table: "salary_structure",
                    cond: {"eid": $scope.eid}
                };

                $http({
                    method: "POST",
                    url: url + "read",
                    data: transmit
                }).success(function (response) {
                    console.log(response);
                    if (response[0].incentive === "yes") {
                        var transmit = {
                            table: "incentive_structure",
                            cond: {eid: $scope.eid}
                        };

                        $http({
                            method: "POST",
                            url: url + "read",
                            data: transmit
                        }).success(function (response) {
                            console.log(response);

                            angular.forEach(response, function (row, index) {
                                response[index].percentage = parseFloat(response[index].percentage);
                            });

                            $scope.incentives = response;
                        });
                    }
                });

            } else {
                // console.log("Employee not found!");

                $scope.profile = {};

                $scope.profile.image = siteurl + "private/images/default.png";
                $scope.profile.active = false;

                $scope.amount = 0;
            }

        });
    }

    $scope.totalFn = function (i) {
        var total = 0;
        total = $scope.amount * ($scope.incentives[i].percentage / 100);
        total = total.toFixed(2);
        return total;
    }
}]);


// Bonus Controller
app.controller("BonusCtrl", ["$scope", "$http", function ($scope, $http) {
    $scope.bonuses = [{fields: "", percentage: 0, remarks: ""}];
    $scope.profile = {
        image: siteurl + "private/images/default.png",
        active: false
    };

    $scope.getProfileFn = function () {
        var where = {
            table: "employee",
            cond: {"emp_id": $scope.eid}
        };

        $http({
            method: "POST",
            url: url + 'read',
            data: where
        }).success(function (response) {

            // get data
            if (response.length > 0) {
                $scope.profile.eid = response[0].emp_id;
                $scope.profile.name = response[0].name;
                $scope.profile.post = response[0].designation;
                $scope.profile.mobile = response[0].mobile;
                $scope.profile.email = response[0].email;
                $scope.profile.joining = response[0].joining_date;
                $scope.profile.image = siteurl + response[0].path;

                $scope.profile.active = true;
                console.log(response);

                // get bonus info
                var transmit = {
                    table: "salary_structure",
                    cond: {eid: $scope.eid}
                };

                $http({
                    method: "POST",
                    url: url + "read",
                    data: transmit
                }).success(function (response) {
                    if (response.length > 0) {
                        if (response[0].bonus === "yes") {
                            // get bonus records
                            var transmit = {
                                table: "bonus_structure",
                                cond: {eid: $scope.eid}
                            };

                            $http({
                                method: "POST",
                                url: url + "read",
                                data: transmit
                            }).success(function (response) {
                                if (response.length > 0) {
                                    angular.forEach(response, function (row, index) {
                                        response[index].percentage = parseFloat(row.percentage);
                                    });

                                    $scope.bonuses = response;
                                } else {
                                    $scope.bonuses = [{fields: "", percentage: 0, remarks: ""}];
                                }
                            });
                        }
                    }
                });
            } else {
                console.log("Employee not found!");

                $scope.profile = {};

                $scope.profile.image = siteurl + "private/images/default.png";
                $scope.profile.active = false;
            }

        });
    }

    $scope.createRowFn = function () {
        var obj = {fields: "", percentage: 0, remarks: ""};
        $scope.bonuses.push(obj);
    }

    $scope.deleteRowFn = function (index) {
        $scope.bonuses.splice(index, 1);
    }

}]);


// Deduction Controller
app.controller("DeductionCtrl", ["$scope", "$http", function ($scope, $http) {

    $scope.profile = {
        image: siteurl + "private/images/default.png",
        active: false
    };

    $scope.deductions = [
        {fields: "Advanced Pay", amount: 0},
        {fields: "Professional Tax ", amount: 0},
        {fields: "Loan", amount: 0},
        {fields: "Provisional Fund", amount: 0}
    ];

    $scope.getProfileFn = function () {
        var where = {
            table: "employee",
            cond: {"emp_id": $scope.eid}
        };

        $http({
            method: "POST",
            url: url + 'read',
            data: where
        }).success(function (response) {
            // get data
            if (response.length > 0) {
                $scope.profile.eid = response[0].emp_id;
                $scope.profile.name = response[0].name;
                $scope.profile.post = response[0].designation;
                $scope.profile.mobile = response[0].mobile;
                $scope.profile.email = response[0].email;
                $scope.profile.joining = response[0].joining_date;
                $scope.profile.image = siteurl + response[0].path;
                $scope.profile.active = true;

                // check deduction active or not
                var transmit = {
                    table: "salary_structure",
                    cond: {"eid": $scope.eid}
                };

                $http({
                    method: "POST",
                    url: url + "read",
                    data: transmit
                }).success(function (response) {
                    console.log(response);
                    if (response[0].deduction === "yes") {
                        var transmit = {
                            table: "deduction_structure",
                            cond: {eid: $scope.eid}
                        };

                        $http({
                            method: "POST",
                            url: url + "read",
                            data: transmit
                        }).success(function (response) {
                            console.log(response);

                            angular.forEach(response, function (row, index) {
                                response[index].amount = parseFloat(response[index].amount);
                            });

                            $scope.deductions = response;
                        });
                    }
                });

            } else {
                // console.log("Employee not found!");
                $scope.profile = {};

                $scope.profile.image = siteurl + "private/images/default.png";
                $scope.profile.active = false;
            }

        });
    }

}]);


app.controller("PaymentCtrl", ["$scope", "$http", function ($scope, $http) {
    $scope.basic_salary = 0;
    $scope.profile = {
        image: siteurl + "private/images/default.png",
        active: false,
        incentive: false,
        deduction: false,
        bonus: false
    };

    $scope.insentives = [];
    $scope.deductions = [];
    $scope.bonuses = [];

    $scope.amount = {
        insentives: {extra: 0},
        deductions: {extra: 0},
        bonuses: {extra: 0}
    };

    $scope.getEmployeeInfoFn = function () {
        var where = {
            table: "employee",
            cond: {emp_id: $scope.eid}
        };

        $http({
            method: "POST",
            url: url + "read",
            data: where
        }).success(function (response) {
            if (response.length > 0) {
                $scope.profile.eid = response[0].emp_id;
                $scope.profile.name = response[0].name;
                $scope.profile.post = response[0].designation;
                $scope.profile.mobile = response[0].mobile;
                $scope.profile.email = response[0].email;
                $scope.profile.joining = response[0].joining_date;
                $scope.profile.image = siteurl + response[0].path;

                $scope.profile.active = true;

                // get basic salary
                var transmit = {
                    table: "salary_structure",
                    cond: {eid: $scope.eid}
                };

                $http({
                    method: "POST",
                    url: url + "read",
                    data: transmit
                }).success(function (response) {
                    if (response.length > 0) {
                        $scope.basic_salary = parseInt(response[0].basic);

                        // incentives
                        if (response[0].incentive === "yes") {
                            // active incentives
                            $scope.profile.incentive = true;

                            // get incentives
                            var transmit = {
                                table: "incentive_structure",
                                cond: {eid: $scope.eid}
                            };

                            $http({
                                method: "POST",
                                url: url + "read",
                                data: transmit
                            }).success(function (response) {
                                if (response.length > 0) {
                                    angular.forEach(response, function (row, index) {
                                        response[index].percentage = parseFloat(row.percentage);
                                        response[index].amount = ((parseFloat(row.percentage) * $scope.basic_salary) / 100);
                                        $scope.amount.insentives[response[index].fields] = ((parseFloat(row.percentage) * $scope.basic_salary) / 100);
                                    });

                                    $scope.insentives = response;
                                } else {
                                    $scope.insentives = [];
                                    $scope.amount.insentives = {};
                                    $scope.amount.insentives.extra = 0;
                                }

                                // console.log(response);
                            });
                        }

                        // deduction
                        if (response[0].deduction === "yes") {
                            // active deduction
                            $scope.profile.deduction = true;

                            // get deduction
                            var transmit = {
                                table: "deduction_structure",
                                cond: {eid: $scope.eid}
                            };

                            $http({
                                method: "POST",
                                url: url + "read",
                                data: transmit
                            }).success(function (response) {
                                if (response.length > 0) {
                                    angular.forEach(response, function (row, index) {
                                        response[index].amount = parseFloat(row.amount);
                                        $scope.amount.deductions[response[index].fields] = parseFloat(row.amount);
                                    });

                                    $scope.deductions = response;
                                } else {
                                    $scope.deductions = [];
                                    $scope.amount.deductions = {};
                                    $scope.amount.deductions.extra = 0;
                                }

                                // console.log(response);
                            });
                        }

                        // deduction
                        if (response[0].bonus === "yes") {
                            // active deduction
                            $scope.profile.bonus = true;

                            // get deduction
                            var transmit = {
                                table: "bonus_structure",
                                cond: {eid: $scope.eid}
                            };

                            $http({
                                method: "POST",
                                url: url + "read",
                                data: transmit
                            }).success(function (response) {
                                if (response.length > 0) {
                                    angular.forEach(response, function (row, index) {
                                        response[index].percentage = parseFloat(row.percentage);
                                        response[index].amount = ((parseFloat(row.percentage) * $scope.basic_salary) / 100);
                                        $scope.amount.bonuses[response[index].fields] = ((parseFloat(row.percentage) * $scope.basic_salary) / 100);
                                    });

                                    $scope.bonuses = response;
                                } else {
                                    $scope.bonuses = [];
                                    $scope.amount.bonuses = {};
                                    $scope.amount.bonuses.extra = 0;
                                }

                                // console.log(response);
                            });
                        }
                    } else {
                        alert("This employee's basic info not found!");
                        $scope.basic_salary = 0;
                    }
                });
            } else {
                $scope.profile = {};

                $scope.profile.image = siteurl + "private/images/default.png";
                $scope.profile.active = false;
                $scope.profile.incentive = false;
                $scope.profile.deduction = false;
            }

            // console.log(response);
        });
    }

    $scope.totalFn = function () {
        var total = 0;
        var insentives = 0;
        var deductions = 0;
        var bonuses = 0;

        angular.forEach($scope.amount.insentives, function (value) {
            insentives += value;
        });

        angular.forEach($scope.amount.deductions, function (value) {
            deductions += value;
        });

        angular.forEach($scope.amount.bonuses, function (value) {
            bonuses += value;
        });

        total = ($scope.basic_salary + insentives + bonuses) - deductions;

        return total;
    }

}]);


// Salary Report
app.controller("SalaryReportCtrl", ["$scope", "$http", function ($scope, $http) {
    $scope.resultset = [];
    $scope.active = false;
    $scope.perPage = 10;

    $scope.getSalaryRecordFn = function () {
        var where = {
            "Year(date)": $scope.where.year,
            "Month(date)": $scope.where.month
        };

        $http({
            method: "POST",
            url: siteurl + "salary/salary/read_salary",
            data: where
        }).success(function (response) {
            if (response.length > 0) {
                $scope.active = true;

                angular.forEach(response, function (row, index) {
                    row.sl = index + 1;
                });

                $scope.resultset = response;
            } else {
                $scope.active = false;
                $scope.resultset = [];
            }

            console.log(response);
        });
    }
}]);


// All Payment
app.controller("AllPaymentCtrl", ["$scope", "$http", function ($scope, $http) {
    $scope.resultset = [];
    $scope.active = false;
    $scope.perPage = 10;

    $scope.getSalaryRecordFn = function () {
        var where = {
            "Year(date)": $scope.where.year,
            "Month(date)": $scope.where.month
        };

        console.log(where);

        $http({
            method: "POST",
            url: siteurl + "salary/payment/read_salary",
            data: where
        }).success(function (response) {
            if (response.length > 0) {
                $scope.active = true;

                angular.forEach(response, function (row, index) {
                    row.sl = index + 1;
                });

                $scope.resultset = response;
            } else {
                $scope.active = false;
                $scope.resultset = [];
            }

            console.log(response);
        });
    }
}]);


// Show All Supplier Transaction
app.controller('showAllSupplierTransactionCtrl', function ($scope, $http, $log) {
    $scope.allTransactions = [];
    $scope.perPage = "30";
    $scope.reverse = true;

    var where = {
        from: 'vendor',
        join: 'supplier_transaction',
        cond: 'supplier_transaction.supplier_name=vendor.id'
    };

    $http({
        method: "POST",
        url: url + "readJoinData",
        data: where
    }).success(function (response) {
        if (response.length > 0) {
            angular.forEach(response, function (value, key) {
                value['sl'] = key + 1;
                $scope.allTransactions.push(value);
            });
        } else {
            $scope.allTransactions = [];
        }

        $log.log($scope.allTransactions);
    });

});


// cost entry ctrl
app.controller('CostEntryCtrl', function ($scope, $http, $log) {

    $scope.setAllPurpose = function () {
        var condition = {
            table: "sitemeta",
            cond: {meta_key: "cost_purpose", meta_type: $scope.type}
        };

        $http({
            method: "POST",
            url: url + "read",
            data: condition
        }).success(function (response) {
            if (response.length > 0) {
                $scope.purpose = response;
            } else {
                $scope.purpose = "";
            }
        });
    }
});


// getDueCtrl
app.controller("getDueCtrl", function ($http, $scope) {

    $scope.getUpazillaFn = function () {
        $scope.upazilla = [];
        var where = {"key": $scope.zilla};

        $http({
            method: "POST",
            url: siteurl + "sale/due/return_upazila",
            data: where
        }).success(function (response) {
            if (response.length > 0) {
                $scope.upazilla = response;
            }
            console.log($scope.upazilla);
        });
    }

});


// Supplier transaction controller
app.controller("supplierTransactionCtrl", function ($http, $scope, $log) {

    //get suplier information
    $scope.getsupplierInfo = function () {
        var condition = {
            from: 'vendor',
            join: 'purchase',
            group_by: 'voucher_no',
            cond: 'vendor.id = purchase.vendor_id',
            where: {'vendor.id': $scope.supplier_name}
        };

        $http({
            method: "POST",
            url: url + "readJoinGroupByData",
            data: condition
        }).success(function (response) {
            if (response.length > 0) {
                $scope.company_name = response[0].vendor_name;
                $scope.voucher_number = response[0].voucher_no;

                var totalDue = 0;
                angular.forEach(response, function (el, i) {
                    totalDue += parseFloat(el.due);
                });

                $scope.totalBalance = Math.abs(totalDue);
                $scope.total_original_Balance = totalDue;

                if (totalDue >= 0) {
                    $scope.balanceSign = "-";
                } else {
                    $scope.balanceSign = "+";
                }
            }

            console.log(response);
        });
    };

    //claculate total due
    $scope.claculateDue = function () {
        var total = 0;
        total = parseFloat($scope.totalBalance) - parseFloat($scope.payment);
        $scope.netBalance = Math.abs(total);
        $scope.net_original_Balance = total;

        if (total >= 0) {
            $scope.netbalanceSign = "-";
        } else {
            $scope.netbalanceSign = "+";
        }
    };
});

// collection sheet
app.controller('collectionSheet', function ($scope, $http) {
    $scope.active = false;
    $scope.getUpazillaFn = function () {
        $scope.upazilla = [];
        var where = {"key": $scope.zilla};

        $http({
            method: "POST",
            url: siteurl + "sheet/sheet/return_upazila",
            data: where
        }).success(function (response) {
            if (response.length > 0) {
                $scope.upazilla = response;
                $scope.active = true;

            } else {
                $scope.active = false;
            }
            console.log($scope.upazilla);
            console.log($scope.active);
        });
    }
});


// Client transaction controller start here
app.controller('clientTransactionCtrl', ['$scope', '$http', function ($scope, $http) {


    $scope.balance = 0;
    $scope.previous_balance = 0;
    $scope.current_balance = 0;
    $scope.sign = 'Receivable';
    $scope.csign = 'Receivable';

    // get client information
    $scope.getclientInfo = function (code) {


        $scope.previous_balance = 0;
        $scope.current_balance = 0;
        $scope.sign = 'Receivable';
        $scope.csign = 'Receivable';

        if (typeof code !== 'undefined' && code != '') {

            $http({
                method: "POST",
                url: url + "client_balance",
                data: {party_code: code}
            }).success(function (balanceRes) {
                $scope.balance = Math.abs(parseFloat(balanceRes.balance));
                $scope.previous_balance = parseFloat(balanceRes.balance);
                $scope.sign = balanceRes.status;
            });
        }
    };

    $scope.getTotalFn = function () {

        var payment = !isNaN(parseFloat($scope.payment)) ? parseFloat($scope.payment) : 0;
        var remission = !isNaN(parseFloat($scope.remission)) ? parseFloat($scope.remission) : 0;
        var balance = 0;
        
        if($scope.transactionType == 'received'){
            balance = $scope.previous_balance - (payment + remission);
        }
        
        if($scope.transactionType == 'payment'){
            $scope.remission = 0;
            balance = $scope.previous_balance + payment;
        }

        $scope.csign = (balance < 0) ? "Payable" : "Receivable";
        $scope.current_balance = balance;

        return Math.abs(balance.toFixed(2));
    }

}]);


// client edit transaction controller start here
app.controller('clientTransactionEditCtrl', ['$scope', '$http', function ($scope, $http) {

    $scope.previous_balance = 0;
    $scope.current_balance = 0;
    $scope.csign = 'Receivable';

    $scope.$watchGroup(['id', 'transactionBy'], function (input) {
        if (input[1] == 'cheque') {

            $http({
                method: 'POST',
                url: url + "read",
                data: {
                    table: 'partytransactionmeta',
                    cond: {transaction_id: input[0]}
                }
            }).success(function (response) {
                if (response.length > 0) {
                    angular.forEach(response, function (row) {
                        if (row.meta_key == 'bankname') {
                            $scope.bankname = row.meta_value;
                        }
                        if (row.meta_key == 'branchname') {
                            $scope.branchname = row.meta_value;
                        }
                        if (row.meta_key == 'account_no') {
                            $scope.accountno = row.meta_value;
                        }
                        if (row.meta_key == 'chequeno') {
                            $scope.chequeno = row.meta_value;
                        }
                        if (row.meta_key == 'passdate') {
                            $scope.passdate = row.meta_value;
                        }
                    });
                }

                console.log(response);
            });
        }
    });

    $scope.getTotalFn = function () {

        var payment = !isNaN(parseFloat($scope.payment)) ? parseFloat($scope.payment) : 0;
        var remission = !isNaN(parseFloat($scope.remission)) ? parseFloat($scope.remission) : 0;
        var balance = 0;
        
        if($scope.transactionType == 'received'){
            balance = $scope.previous_balance - (payment + remission);
        }
        
        if($scope.transactionType == 'payment'){
            $scope.remission = 0;
            balance = $scope.previous_balance + payment;
        }

        $scope.csign = (balance < 0) ? "Payable" : "Receivable";
        $scope.current_balance = balance;

        return Math.abs(balance.toFixed(2));
    }

}]);


// ClientCommissionCtrl
app.controller("ClientCommissionCtrl", ["$scope", "$http", function ($scope, $http) {
    $scope.resultset = [];
    $scope.total = 0;

    // get all upazilla
    $scope.getUpazillaFn = function () {
        var where = {
            table: "parties",
            group_by: "area",
            cond: {zone: $scope.zilla}
        };

        $http({
            method: "POST",
            url: url + "readGroupByData",
            data: where
        }).success(function (response) {
            $scope.allUpazilla = response;
            //console.log(response);
        });
    }

    var condition = {
        table: 'parties',
        cond: {
            type: 'client'
        }
    };

    $http({
        method: "POST",
        url: url + 'read',
        data: condition
    }).success(function (response) {
        $scope.allClients = response;
        // console.log(response);

    });

    // get all upazilla wise cliend
    $scope.getAllClientFn = function () {
        var condition = {
            table: 'parties',
            cond: {
                type: 'client',
                zone: $scope.zilla,
                area: $scope.upazilla
            }
        };

        $http({
            method: "POST",
            url: url + 'read',
            data: condition
        }).success(function (response) {
            $scope.allClients = response;
            // console.log(response);

        });
    }


    $scope.searchCommissionFn = function () {
        var where = {};

        angular.forEach($scope.query, function (value, key) {
            if (value != "") {
                where[key] = value;
            }
        });
        console.log(where);


        angular.forEach($scope.dateset, function (value, key) {
            if (value != "") {
                if (key == "from") {
                    where["transaction_at >="] = value;
                }
                if (key == "to") {
                    where["transaction_at <="] = value;
                }
            }
        });

        $http({
            method: "POST",
            url: siteurl + "commission/client_commission/search",
            data: where
        }).success(function (response) {
            $scope.resultset = [];

            if (response.length > 0) {
                $scope.resultset = response;
            }

            console.log($scope.resultset);
        });
    }

    $scope.sumFn = function () {
        var total = 0;

        angular.forEach($scope.resultset, function (row, key) {
            if (row.action) {
                total += parseFloat(row.total);
            }
        });

        $scope.total = total;
    }


}]);


// company transaction controller start here
app.controller('CompanyTransactionCtrl', ['$scope', '$http', function ($scope, $http) {

    $scope.balance = 0;
    $scope.previous_balance = 0;
    $scope.current_balance = 0;
    $scope.sign = "Receivable";
    $scope.csign = "Receivable";

    $scope.getCompanyInfo = function (code) {

        $scope.balance = 0;
        $scope.previous_balance = 0;
        $scope.current_balance = 0;
        $scope.sign = "Receivable";
        $scope.csign = "Receivable";

        if (typeof code !== 'undefined' && code != '') {

            $http({
                method: 'post',
                url: url + 'supplier_balance',
                data: {party_code: code}
            }).success(function (response) {
                $scope.balance = Math.abs(parseFloat(response.balance));
                $scope.previous_balance = parseFloat(response.balance);
                $scope.sign = response.status;
            })
        }
    }


    $scope.getTotalFn = function () {

        var payment = !isNaN(parseFloat($scope.payment)) ? parseFloat($scope.payment) : 0;
        var commission = !isNaN(parseFloat($scope.commission)) ? parseFloat($scope.commission) : 0;
        var balance = 0;
        
        if($scope.transactionType == 'payment'){
            balance = $scope.previous_balance + (payment + commission);
        }
        
        if($scope.transactionType == 'received'){
            $scope.commission = 0;
            balance = $scope.previous_balance - payment;
        }

        $scope.csign = (balance < 0 ? 'Payable' : 'Receivable');
        $scope.current_balance = balance;

        return Math.abs(balance.toFixed(2));
    }
}]);


//Edit company Transaction
app.controller('CompanyEditTransactionCtrl', ['$scope', '$http', function ($scope, $http) {

    $scope.balance = 0;
    $scope.previous_balance = 0;
    $scope.current_balance = 0;
    $scope.sign = "Receivable";
    $scope.csign = "Receivable";

    $scope.$watchGroup(['id', 'transactionBy'], function (input) {
        if (input[1] == 'cheque') {

            $http({
                method: 'POST',
                url: url + "read",
                data: {
                    table: 'partytransactionmeta',
                    cond: {transaction_id: input[0]}
                }
            }).success(function (response) {
                if (response.length > 0) {
                    angular.forEach(response, function (row) {
                        if (row.meta_key == 'bankname') {
                            $scope.bankname = row.meta_value;
                        }
                        if (row.meta_key == 'branchname') {
                            $scope.branchname = row.meta_value;
                        }
                        if (row.meta_key == 'account_no') {
                            $scope.accountno = row.meta_value;
                        }
                        if (row.meta_key == 'chequeno') {
                            $scope.chequeno = row.meta_value;
                        }
                        if (row.meta_key == 'passdate') {
                            $scope.passdate = row.meta_value;
                        }
                    });
                }

            });
        }
    });

    $scope.getTotalFn = function () {

        var payment = !isNaN(parseFloat($scope.payment)) ? parseFloat($scope.payment) : 0;
        var commission = !isNaN(parseFloat($scope.commission)) ? parseFloat($scope.commission) : 0;
        var balance = 0;
        
        if($scope.transactionType == 'payment'){
            balance = $scope.previous_balance + (payment + commission);
        }
        
        if($scope.transactionType == 'received'){
            $scope.commission = 0;
            balance = $scope.previous_balance - payment;
        }

        $scope.csign = (balance < 0 ? 'Payable' : 'Receivable');
        $scope.current_balance = balance;

        return Math.abs(balance.toFixed(2));
    }
}]);


//vendor transaction controller start here
app.controller('VendorTransactionCtrl', ['$scope', '$http', function ($scope, $http) {
    $scope.balance = $scope.payment = 0;
    $scope.sign = $scope.csign = "Receivable";

    $scope.getVendortInfo = function () {
        var condition = {
            table: 'partybalance',
            cond: {code: $scope.clientCode}
        };

        $http({
            method: 'POST',
            url: url + 'read',
            data: condition
        }).success(function (response) {
            if (response.length > 0) {
                $scope.balance = Math.abs(parseFloat(response[0].balance));

                if (parseFloat(response[0].balance) >= 0) {
                    $scope.sign = "Receivable";
                } else {
                    $scope.sign = "Payable";
                }
            } else {
                $scope.balance = 0;
                $scope.sign = "Receivable";
            }

            console.log(response);
        });
    }

    $scope.getTotalFn = function () {
        var total = 0;

        if ($scope.sign == 'Receivable') {
            total = $scope.balance + $scope.payment;
            $scope.csign = "Receivable";
        } else {
            total = $scope.balance - $scope.payment;

            if (total <= 0) {
                $scope.csign = "Receivable";
            } else {
                $scope.csign = "Payable";
            }
        }

        return Math.abs(total);
    }

}]);


// add client ctrl
app.controller("AddClientCtrl", ['$scope', '$http', function ($scope, $http) {
    $scope.items = [{
        brand: "bsrm",
        balance: 0,
        limit: 0,
        status: "receivable"
    }];

    $scope.addNewFn = function () {
        var newobj = {
            brand: "",
            balance: 0,
            limit: 0,
            status: "receivable"
        };

        $scope.items.push(newobj);
    }

    // zilla wise upazilla
    $scope.getUpazillaFn = function () {
        $scope.upazilla = [];
        var where = {"key": $scope.zone};

        $http({
            method: "POST",
            url: siteurl + "client/client/return_upazila",
            data: where
        }).success(function (response) {
            if (response.length > 0) {
                $scope.upazilla = response;
            }
            console.log($scope.upazilla);
        });
    }


    $scope.deleteFn = function (index) {
        $scope.items.splice(index, 1);
    }

}]);


// Edit client ctrl
app.controller("EditClientCtrl", ['$scope', '$http', function ($scope, $http) {
    $scope.items = [{
        brand: "",
        balance: 0,
        limit: 0,
        status: "receivable"
    }];


    $scope.$watch("partyCode", function () {
        var where = {
            table: "partybalance",
            cond: {code: $scope.partyCode}
        };

        $http({
            method: "POST",
            url: url + "read",
            data: where
        }).success(function (response) {
            if (response.length > 0) {
                $scope.items = [];
                angular.forEach(response, function (values) {
                    values.status = (parseFloat(values.initial_balance) <= 0) ? "receivable" : "payable";
                    values.amount = Math.abs(parseFloat(values.initial_balance));
                    values.credit_limit = parseFloat(values.credit_limit);
                    $scope.items.push(values);
                });
            }
            console.log($scope.items);
        });

    });


    // zilla wise upazilla
    $scope.$watch('zone', function () {
        var where = {"key": $scope.zone};

        $http({
            method: "POST",
            url: siteurl + "client/client/return_upazila",
            data: where
        }).success(function (response) {
            if (response.length > 0) {
                $scope.upazilla = response;
            }
        });
    });


    $scope.addNewFn = function () {
        var newobj = {
            brand: "",
            balance: 0,
            limit: 0,
            status: "receivable"
        };

        $scope.items.push(newobj);
    }

    $scope.deleteFn = function (index) {
        $scope.items.splice(index, 1);
    }

}]);


// Client Upgrade Ctrl
app.controller('ClientUpgradeCtrl', ['$scope', '$http', function ($scope, $http) {

    $scope.securities = [{bank: "", branch: "", cheque: "", amount: 0}];

    $scope.$watch('code', function (value) {
        var where = {
            table: "partymeta",
            cond: {
                party_code: value,
                meta_key: 'security'
            }
        };

        $http({
            method: "POST",
            url: url + 'read',
            data: where
        }).success(function (response) {
            if (response.length > 0) {
                $scope.securities = angular.fromJson(response[0].meta_value);
            }

            console.log(response);
        });
    });

    $scope.newRowFn = function () {
        var object = {bank: "", branch: "", cheque: ""};
        $scope.securities.push(object);
    }

    $scope.deleteRowFn = function (index) {
        $scope.securities.splice(index, 1);
    }

}]);


// All Bank Transaction Ctrl
app.controller("AllBankTransactionCtrl", ["$scope", "$http", function ($scope, $http) {
    $allAccount = [];

    $scope.getAccountFn = function () {
        var where = {
            table: 'bank_account',
            cond: {bank_name: $scope.bank}
        };

        $http({
            method: "POST",
            url: url + 'read',
            data: where
        }).success(function (response) {
            if (response.length > 0) {
                $scope.allAccount = response;
            }

            console.log(response);
        });
    }

}]);


// Add Loan Transaction Ctrl
app.controller("loanTransactionCtrl", ["$scope", "$http", function ($scope, $http) {
    $scope.totalAmount = 0;
    $scope.loanStatus = '';
    $scope.totalReceived = 0;
    $scope.totalPaid = 0;
    $scope.amount = '';

    $scope.getLoanInfoFn = function (loan_id) {

        var where = {
            table: 'loan',
            cond: {
                id: loan_id,
                trash: '0'
            }
        };

        $http({
            method: "POST",
            url: url + 'result',
            data: where
        }).success(function (response) {

            if (response.length > 0) {
                $scope.totalAmount = parseFloat(response[0].amount);
                $scope.loanStatus = response[0].loan_type;
                $scope.balance = parseFloat(response[0].current_balance);
                $scope.balanceStatus = response[0].current_status;
            } else {
                $scope.totalAmount = 0;
                $scope.loanStatus = '';
                $scope.balance = 0;
                $scope.balanceStatus = '';
            }
        });


        // Current Balance Calculation
        $scope.getCurrentBalanceFn = function () {
            var total = 0;
            var amount = ((typeof $scope.amount !== 'undefined' && $scope.amount != '') ? parseFloat($scope.amount) : 0);
            if (typeof $scope.trxType !== 'undefined') {
                if ($scope.balanceStatus == 'Received') {
                    if ($scope.trxType == 'Received') {
                        total = parseFloat($scope.balance) + amount;
                    } else {
                        total = parseFloat($scope.balance) - amount;
                    }
                    $scope.currentStatus = (total > 0) ? 'Received' : 'Paid';
                } else {
                    if ($scope.trxType == 'Paid') {
                        total = parseFloat($scope.balance) + amount;
                    } else {
                        total = parseFloat($scope.balance) - amount;
                    }
                    $scope.currentStatus = (total > 0) ? 'Paid' : 'Received';
                }
            }

            return Math.abs(total);
        }
    }
}]);


//net balance sign filter
app.filter("net_balance_sign", function () {
    return function (input) {
        var sign;

        if (input >= 0) {
            sign = "-";
        } else {
            sign = "+";
        }

        return sign;
    }
});

app.filter("netBalanceFilter", function () {
    return function (value) {
        return Math.abs(value);
    }
});


//show allTargetCommissionCtrl

app.controller('allTargetCommissionCtrl', ['$scope', '$http', function ($scope, $http) {
    $scope.dataset = [];

    var loadData = function () {
        var condition = {
            table: 'commissions'
        };

        $http({
            method: 'POST',
            url: url + 'read',
            data: condition
        }).success(function (response) {
            if (response.length > 0) {
                angular.forEach(response, function (row, i) {
                    row['sl'] = i + 1;
                    $scope.dataset.push(row);
                });
            } else {
                $scope.dataset = [];
            }

            console.log($scope.dataset);
        });
    }

    loadData();
}]);

//cost controller start here
app.controller("costCtrl", ['$scope', '$http', function ($scope, $http) {
    $scope.perPage = "10";
    $scope.reverse = false;
    $scope.fields = [];

    var obj = {
        table: "cost_field",
        cond: {trash: 0}
    };

    $http({
        method: "POST",
        url: url + "read",
        data: obj
    }).success(function (response) {
        if (response.length > 0) {
            angular.forEach(response, function (values, index) {
                values['sl'] = index + 1;
                $scope.fields.push(values);
            });
        } else {
            $scope.fields = [];
        }
    });
}]);


//ChalanCtrL  start here
app.controller("chalanCtrl", ['$scope', '$http', function ($scope, $http) {
    $scope.perPage = "10";
    $scope.reverse = false;
    $scope.chalan = [];
    // Table
    var obj = {
        table: "chalan",
        cond: {trash: 0},
        group_by: "chalan_no"
    };

    $http({
        method: "POST",
        url: url + "readGroupByData",
        data: obj
    }).success(function (response) {
        if (response.length > 0) {

            angular.forEach(response, function (values, index) {
                // get client info
                var where = {
                    table: 'parties',
                    cond: {code: values.party_code}
                };

                $http({
                    method: 'POST',
                    url: url + 'read',
                    data: where
                }).success(function (party) {
                    values['sl'] = index + 1;
                    values['party'] = party[0].name;

                    $scope.chalan.push(values);
                });

                console.log($scope.chalan);
            });
        } else {
            $scope.chalan = [];
        }
    });

}]);


app.controller("chalanRowCtrl", ["$scope", "$http", function ($scope, $http) {
    $scope.addRowFn = function () {
        if (typeof $scope.raw_material != "undefined" && typeof $scope.quantity != "undefined") {

            var where = {
                table: "materials",
                cond: {
                    code: $scope.raw_material
                }
            };

            $http({
                method: "POST",
                url: url + "read",
                data: where
            }).success(function (response) {
                if (response.length == 1) {
                    var item = {
                        raw_mat: response[0].name,
                        code: $scope.raw_material,
                        quantity: $scope.quantity
                    };
                    $scope.allRecords.push(item);
                } else {
                    $scope.allRecords = [];
                }
            });
        } else {
            alert("Please Fill up all the Value!");
        }
    };
}]);


//Chalan Ctrl

// add prescription ctrl
/*app.controller("addChalanCtrl",["$scope","$http",function($scope,$http){
	 $scope.allChalan = [{
	 	product  : "",
	 	quqntity : ""
	 }];

	 var addNewItem = function(key) {
	 	var item = (key == 'chalanItem') ? {product: "", quqntity: ""} : {product: "", quqntity: ""};

	 	if(key == 'chalanItem') {
	 		$scope.allChalan.push(item);
	 	}
	 }

	 $scope.addRowChalanByClickFn = function(key){
	 	addNewItem(key);
	 };

	 $scope.removeRowChalanFn = function(i){
	 	$scope.allChalan.splice(i,1);
	 };

}]);*/


// production Contrller start here
app.controller("productionCtrl", ["$scope", "$http", function ($scope, $http) {

    // get batch no
    $scope.batchNo = '';
    $scope.$watch('batch', function (batch) {
        $http({
            method: 'post',
            url: siteurl + 'production/production/generateBatchNo'
        }).success(function (response) {
            $scope.batchNo = response;
        });
    });


    $scope.toCart = [];
    $scope.toSection = false;
    $scope.getFromProductInfoFn = function (stockId) {

        if (typeof stockId !== 'undefined') {

            $http({
                method: 'post',
                url: url + 'result',
                data: {
                    table: 'stock',
                    cond: {id: stockId}
                }
            }).success(function (response) {

                if (response.length > 0) {

                    var item = {
                        id: response[0].id,
                        code: response[0].code,
                        name: response[0].name,
                        unit: response[0].unit,
                        purchase_price: parseFloat(response[0].purchase_price),
                        sale_price: parseFloat(response[0].sale_price),
                        stock_qty: parseFloat(response[0].quantity),
                        waste_percentage: '',
                        waste_quantity: 0,
                        quantity: '',
                        subtotal: 0,
                        waste_subtotal: 0,
                    };

                    $scope.fromCart.push(item);
                    $scope.toSection = true;
                } else {
                    $scope.toSection = false;
                }
            });
        }
    }

    $scope.getWastQtyFn = function (index) {
        var quantity = (!isNaN(parseFloat($scope.fromCart[index].quantity)) ? parseFloat($scope.fromCart[index].quantity) : 0);
        var wastePercentage = (!isNaN(parseFloat($scope.fromCart[index].waste_percentage)) ? parseFloat($scope.fromCart[index].waste_percentage) : 0);
        var wasteQuantity = 0;
        if (quantity > 0 && wastePercentage > 0) {
            wasteQuantity = (quantity * wastePercentage) / 100;
        }

        $scope.fromCart[index].waste_quantity = wasteQuantity.toFixed(2);

        return $scope.fromCart[index].waste_quantity;
    }

    // get from subtotal
    $scope.fromSubtotalFn = function (index) {
        var quantity = (!isNaN(parseFloat($scope.fromCart[index].quantity)) ? parseFloat($scope.fromCart[index].quantity) : 0);
        var subtotal = $scope.fromCart[index].purchase_price * quantity;
        $scope.fromCart[index].subtotal = subtotal.toFixed(2);

        var wasteSubtotal = $scope.fromCart[index].purchase_price * parseFloat($scope.fromCart[index].waste_quantity);
        $scope.fromCart[index].waste_subtotal = wasteSubtotal.toFixed(2);

        return $scope.fromCart[index].subtotal;
    }

    // get from total quantity
    $scope.fromTotalAmount = 0;
    $scope.fromTotalWasteQty = 0;
    $scope.fromTotalWasteAmount = 0;
    $scope.getFromTotalQty = function () {
        var totalQty = totalAmount = totalWasteQty = totalWasteAmount = 0;
        angular.forEach($scope.fromCart, function (row) {
            totalAmount += parseFloat(row.subtotal);
            totalQty += (!isNaN(parseFloat(row.quantity)) ? parseFloat(row.quantity) : 0);
            totalWasteQty += parseFloat(row.waste_quantity);
            totalWasteAmount += parseFloat(row.waste_subtotal);
        })
        $scope.fromTotalAmount = totalAmount.toFixed(2);
        $scope.fromTotalWasteQty = totalWasteQty;
        $scope.fromTotalWasteAmount = totalWasteAmount.toFixed(2);
        return totalQty;
    }

    $scope.fromCart = [];
    $scope.getToProductInfoFn = function (materialId) {

        $scope.toCart = [];

        if (typeof materialId !== 'undefined' && materialId != '') {

            $http({
                method: 'post',
                url: url + 'result',
                data: {
                    table: 'materials',
                    cond: {
                        'id': materialId,
                        'type': 'finish_product'
                    }
                }
            }).success(function (response) {

                if (response.length > 0) {

                    var item = {
                        id: response[0].id,
                        code: response[0].code,
                        name: response[0].name,
                        unit: response[0].unit,
                        purchase_price: 0,
                        sale_price: parseFloat(response[0].sale_price),
                        quantity: '',
                        subtotal: 0,
                    };

                    $scope.toCart.push(item);
                }
            });
        }
    }


    // get to subtotal
    $scope.toPurchasePriceFn = function () {
        var quantity = (!isNaN(parseFloat($scope.toCart[0].quantity)) ? parseFloat($scope.toCart[0].quantity) : 0);
        var price = subtotal = 0;

        if (quantity > 0) {
            price = parseFloat($scope.fromTotalAmount) / quantity;
            subtotal = parseFloat($scope.fromTotalAmount);
        }

        $scope.toCart[0].purchase_price = price.toFixed(2);
        $scope.toCart[0].subtotal = subtotal;
        return $scope.toCart[0].purchase_price;
    }


    // get to total quantity
    $scope.isDisabled = true;
    $scope.toTotalAmount = 0;
    $scope.getToTotalQty = function () {
        var totalQty = totalAmount = 0;
        angular.forEach($scope.toCart, function (row) {
            totalAmount += parseFloat(row.subtotal);
            totalQty += (!isNaN(parseFloat(row.quantity)) ? parseFloat(row.quantity) : 0);
        })

        $scope.toTotalAmount = totalAmount.toFixed(2);
        $scope.isDisabled = ($scope.getFromTotalQty() > 0 && totalQty > 0) ? false : true;
        return totalQty;
    }

    $scope.removeFromItemFn = function (index) {
        $scope.fromCart.splice(index, 1);
    }

    $scope.removeToItemFn = function (index) {
        $scope.toCart.splice(index, 1);
    }
}]);


// production edit Contrller start here
app.controller("editProductionCtrl", ["$scope", "$http", function ($scope, $http) {

    //get product info fn
    $scope.getProductInfoFn = function () {
        var where = {
            table: "materials",
            cond: {
                code: $scope.finish_product_code
            }
        };

        console.log(where);

        $http({
            method: "POST",
            url: url + "read",
            data: where
        }).success(function (response) {
            if (response.length == 1) {
                $scope.product_name = response[0].name;
            } else {
                $scope.product_name = "";
            }
        });
    };
}]);


// chalan Contrller start here
app.controller("chalanAddCtrl", ["$scope", "$http", function ($scope, $http) {
    $scope.items = [];
    $scope.products = []

    // add new row fn
    $scope.addRowFn = function () {
        if (typeof $scope.productGiven !== "undefined") {
            if ($scope.products.indexOf($scope.productGiven) < 0) {
                var where = {
                    table: "materials",
                    cond: {
                        code: $scope.productGiven,
                        type: 'finish_product',
                        trash: 0
                    }
                };

                $http({
                    method: "POST",
                    url: url + "read",
                    data: where
                }).success(function (response) {
                    if (response.length > 0) {
                        var item = {
                            product: response[0].name,
                            code: response[0].code,
                            quantity: $scope.quantityGiven
                        };

                        $scope.items.push(item);
                        $scope.products.push(response[0].code);

                        console.log(response);
                    }
                });
            }
        }
    };


    //calculate Bags no
    $scope.calculateBags = function (i, size) {
        var bag_no = 0;
        bag_no = parseFloat($scope.items[i].quantity) / parseFloat(size);
        $scope.items[i].bags = bag_no.toFixed(2);
        return $scope.items[i].bags;
    };


    //remove row start where
    $scope.deleteItemFn = function (i) {
        $scope.items.splice(i, 1);
        $scope.products.splice(i, 1);
    };
}]);

// All Bank Transaction Ctrl
app.controller("bankLedger", ["$scope", "$http", function ($scope, $http) {
    $allAccount = [];

    $scope.getAccountFn = function () {
        var where = {
            table: 'bank_account',
            cond: {bank_name: $scope.bank}
        };

        $http({
            method: "POST",
            url: url + 'read',
            data: where
        }).success(function (response) {
            if (response.length > 0) {
                $scope.allAccount = response;
            }

            //console.log(response);
        });
    }

}]);

// All Bank Transaction Ctrl
app.controller("AllBankTransactionCtrl", ["$scope", "$http", function ($scope, $http) {
    $allAccount = [];

    $scope.getAccountFn = function () {
        var where = {
            table: 'bank_account',
            cond: {bank_name: $scope.bank}
        };

        $http({
            method: "POST",
            url: url + 'read',
            data: where
        }).success(function (response) {
            if (response.length > 0) {
                $scope.allAccount = response;
            }

            //console.log(response);
        });
    }

}]);

// production Contrller start here
app.controller("chalanEditCtrl", ["$scope", "$http", function ($scope, $http) {

    $scope.$watch("chalanNo", function (value) {
        $scope.items = [];

        var where = {
            from: "chalan",
            join: "materials",
            cond: "chalan.code=materials.code",
            where: {'chalan.chalan_no': value}
        };

        $http({
            method: "POST",
            url: url + "readJoinData",
            data: where
        }).success(function (response) {
            if (response.length > 0) {
                angular.forEach(response, function (row, index) {
                    var item = {
                        bags: parseFloat(row.bags),
                        chalan_no: row.chalan_no,
                        product: row.name,
                        code: row.code,
                        date: row.date,
                        id: parseInt(row.id),
                        party_code: row.party_code,
                        quantity: parseFloat(row.quantity),
                        size: row.size
                    };

                    $scope.items.push(item);
                });

                console.log(response);
                // console.log($scope.items);
            }
        });
    });

    $scope.calculateBags = function (index) {
        $scope.items[index].bags = $scope.items[index].quantity / parseInt($scope.items[index].size);
    }

}]);

// Client transaction controller 
app.controller('CcLoanEntryCtrl', ['$scope', '$http', function($scope, $http) {
    $scope.name = '';
    $scope.contact_info = '';
    $scope.address = '';
    $scope.bank_name = '';
    $scope.percentage = 0;
    $scope.loan_due = 0;
    $scope.interest_due = 0;
    $scope.loan_paid = 0;
    $scope.loan_charge = 0;
    $scope.interest_paid = 0;
    $scope.trx_date = 0;
    $scope.due_balance = 0;
    $scope.loan_rcv = 0;
    $scope.chargeType = 'bank_loan';
    
    $scope.setBankChargeFn = function(type){
        $scope.chargeType = type;
    }


    $scope.trxFn = function(date){
        
        $scope.getAccInfoFn($scope.acc_no,$scope.trx_date);
    } 
    // Get Account Info
    $scope.getAccInfoFn = function(acc_no,trx_date) {
        console.log(acc_no);
        console.log(trx_date);
        // Get Cleien
        var accWhere = {
            table: 'cc_loan',
            cond: {
                'acc_no' : $scope.acc_no
            },
            select: ['name','contact_info','address', 'bank_name','percentage']
        }
        $http({
            method: 'POST',
            url: url + 'result',
            data: accWhere
        }).success(function(accHolder) {
            if(accHolder.length > 0) {
                 $scope.name         = accHolder[0].name;
                 $scope.contact_info = accHolder[0].contact_info;
                 $scope.address      = accHolder[0].address;
                 $scope.bank_name    = accHolder[0].bank_name;
                 $scope.percentage   = accHolder[0].percentage;
            }
            
            $http({
    	   		method : 'POST',
    	   		url    : url + 'cc_loan_info',
    	   		data   : {'acc_no' : $scope.acc_no,'trx_date': $scope.trx_date}
	   	    }).success(function(balnceInfo){
	   	        console.log(balnceInfo);
	   	        $scope.prev_loan_rcv =balnceInfo.total_loan_rcv;
    	   	    $scope.prev_loan_paid =balnceInfo.total_loan_paid;
    	   	    $scope.prev_loan_charge =balnceInfo.total_loan_charge;
    	   		$scope.loan_due = parseFloat(balnceInfo.total_loan_due);
    	   		$scope.interest_due = parseFloat(balnceInfo.total_interest_due).toFixed(2);
    	   		$scope.due_balance = parseFloat($scope.loan_due) + parseFloat($scope.interest_due);
	   	});
            
            
        });
    }
    
    $scope.currentLoanDueFn = function(){
     return $scope.loan_due - $scope.loan_paid - $scope.loan_charge;
    };

    $scope.currentInterestDueFn = function(){
     return parseFloat($scope.interest_due - $scope.interest_paid).toFixed(2);
    };
    
    
     $scope.currentBalanceDueFn = function(){
        if($scope.trx_type == 'Paid'){
            return parseFloat($scope.due_balance) - parseFloat($scope.loan_paid) - parseFloat($scope.interest_paid);
        }else if($scope.trx_type=='Charge'){
            return parseFloat($scope.due_balance) - parseFloat($scope.loan_charge) - parseFloat($scope.interest_paid);
        }else if($scope.trx_type=='Received'){
            return parseFloat($scope.due_balance) + parseFloat($scope.loan_rcv);
        }else{
            return 0;
        }
        
     };
    
    /*Custom Watch*/
    var trx_date    = document.querySelector('#trx_date');
    $scope.trx_date = trx_date.value;
    trx_date.addEventListener('blur', function(){
        $scope.trx_date = trx_date.value;
        $scope.trxFn(trx_date.value);
    });
    /*Custom Watch End*/
}]);


//Income Ctrl
app.controller("incomeCtrl", ['$scope', '$http', function ($scope, $http) {
    $scope.perPage = "10";
    $scope.reverse = false;
    $scope.income = [];
    $scope.field_name = 'dasda';

    var obj = {
        table: "income_field"
    };

    $http({
        method: "POST",
        url: url + "read",
        data: obj
    }).success(function (response) {
        if (response.length > 0) {
            angular.forEach(response, function (values, index) {
                values['sl'] = index + 1;
                $scope.income.push(values);
            });
        } else {
            $scope.income = [];
        }
    });

    $scope.getFieldName = function (id) {
        console.log(id);
        $scope.field_name = id;
    }

}]);

    app.controller("addCommitmentCtrl", function($scope, $http) {
   
        $scope.clientList = [];
        $scope.userList = [];
    
        $scope.$watch('godown_code', function(godown_code) {
            
            
            // Get Cleient List Showroom Wise 
            var clientWhere = {
                table: 'parties',
                cond: {
                    'status'       : 'active',
                    'type'         : 'client',
                    'trash'        : 0
                },
                select: ['code', 'name', 'mobile', 'address']
            }
            
            if ($scope.godown_code != 'all') {
                clientWhere.cond['parties.godown_code'] = godown_code;
            }
            
            $http({
                method: 'POST',
                url: url + 'result',
                data: clientWhere
            }).success(function(clients) {
                if (clients.length > 0) {
                    $scope.clientList = clients;
                } else {
                    $scope.clientList = [];
                }
            });
            
            // Get User List Showroom Wise 
            var userWhere = {
                table: 'users',
                cond:{},
                select: ['id', 'name', 'mobile']
            }
            
            if ($scope.godown_code != 'all') {
                userWhere.cond['branch'] = godown_code;
            }
            
            $http({
                method: 'POST',
                url: url + 'result',
                data: userWhere
            }).success(function(users) {
                if (users.length > 0) {
                    $scope.userList = users;
                } else {
                    $scope.userList = [];
                }
            });
            
            
            
            $scope.partyInfo = [
                mobile = '',
                address = ''
            ];
            
            // default party data 
            if(typeof $scope.party_code !== 'undefined'){
                var partyWhere = {
                    table: 'parties',
                    cond: {
                        'code'  : $scope.party_code,
                        'trash' : 0
                    },
                    select: ['mobile', 'address']
                }
                
                if ($scope.godown_code != 'all') {
                    clientWhere.cond['parties.godown_code'] = godown_code;
                }
                
                $http({
                    method: 'POST',
                    url: url + 'result',
                    data: partyWhere
                }).success(function(partyResponse) {
                    if (partyResponse.length > 0) {
                        $scope.partyInfo.mobile = partyResponse[0].mobile;
                        $scope.partyInfo.address = partyResponse[0].address;
                    } 
                });
            }
            
            // get party info
            $scope.getUserInfoFn = function(){
                
                if(typeof $scope.party_code !== 'undefined'){
                    
                    var partyWhere = {
                        table: 'parties',
                        cond: {
                            'code'  : $scope.party_code,
                            'trash' : 0
                        },
                        select: ['mobile', 'address']
                    }
                    
                    if ($scope.godown_code != 'all') {
                        clientWhere.cond['parties.godown_code'] = godown_code;
                    }
                    
                    $http({
                        method: 'POST',
                        url: url + 'result',
                        data: partyWhere
                    }).success(function(partyResponse) {
                        if (partyResponse.length > 0) {
                            $scope.partyInfo.mobile = partyResponse[0].mobile;
                            $scope.partyInfo.address = partyResponse[0].address;
                        } 
                    });
                }
            }
        });
    });
    
//showSrCtrl
app.controller("showSrCtrl", function($scope, $http){
	$scope.reverse = false;
	$scope.perPage = "20";
	$scope.srList = [];

	var obj = { 'table': 'sr', cond:{'trash': 0} };

	$http({
		method : 'POST',
		url    : url+'read',
		data   : obj
	}).success(function(response) {
		angular.forEach(response, function(values, index) {
			values['sl'] = index + 1;
			$scope.srList.push(values);
			console.log(response);
		});

		 //Pre Loader
		  $("#loading").fadeOut("fast",function(){
			  $("#data").fadeIn('slow');
		  });
	});
});


//show all Category
app.controller("showzoneCtrl", function($scope, $http){
	$scope.reverse = false;
	$scope.perPage = "20";
	$scope.categories = [];

	var obj = { 'table': 'zone' };

	$http({
		method : 'POST',
		url    : url+'read',
		data   : obj
	}).success(function(response) {
		angular.forEach(response, function(values, index) {
			values['sl'] = index + 1;
			$scope.categories.push(values);
		});

		 //Pre Loader
		  $("#loading").fadeOut("fast",function(){
			  $("#data").fadeIn('slow');
		  });
	});
});

//show all Category
app.controller("srComissionCtrl", function($scope, $http){
    
    $scope.mobile = '';
    $scope.address = '';
    
    $scope.balance = 0;
    $scope.due = 0;  
    $scope.amount = 0;


	$scope.srInfoFn = function (){
	    
        var transmit = {  
            tableFrom: 'saprecords',
            tableTo: 'sr',
            joinCond: 'saprecords.sr_id=sr.id',
            cond: {
                'saprecords.sr_id': $scope.sr_id,    
                'saprecords.trash': "0",
                'sr.trash':"0",
            },
            select: ['saprecords.sr_id', 'saprecords.total_quantity', 'saprecords.voucher_no', 'saprecords.total_sr_commission', 'saprecords.trash as saprecord_trash', 'sr.*', 'sum(total_sr_commission) as balance'],
        };
        
    	$http({  
    		method : 'POST',
    		url    : url+'join',
    		data   : transmit
    	}).success(function(response) { 
    	    
    	    var balance = 0;
    	    
    	    if(response.length > 0){
                $scope.mobile = response[0].mobile;
                $scope.address = response[0].address;
                
                balance = response[0].balance;
                
                $http({  
            		method : 'POST',
            		url    : url+'result',
            		data   : {
            		    table: 'sr_comission',
            		    cond:{
            		        sr_id: $scope.sr_id, 
            		    },
            		    select: ['sum(amount) as total_paid'],
            		}
                	}).success(function(transaction) {
                	    
                	    if(transaction.length > 0){
                	        $scope.balance = balance - transaction[0].total_paid;
                	    }else{
                	        $scope.balance =  balance;
                	    }
                	    
                	});
                   
    	    }
    	});
	}
	
	$scope.dueBalanceFn = function (){
	    $scope.due = $scope.balance -  $scope.amount;
	}
});