<script src="<?php echo site_url('private/js/ngscript/editDoSaleController.js?').time(); ?>"></script>
<style>  
	.table2 tr td {
		padding: 0 !important;
	}

	.table2 tr td input {
		border: 1px solid transparent;
	}

	input[type=number]::-webkit-inner-spin-button,
	input[type=number]::-webkit-outer-spin-button {
		-webkit-appearance: none;
		margin: 0;
	}

	input[type=number] {
		-moz-appearance: textfield;
	}
</style>
<div class="container-fluid" ng-controller="editDoSaleController" ng-cloak>
   <div class="row">
      <?php echo $confirmation; ?>
      <div class="panel panel-default">
         <div class="panel-heading panal-header">
            <div class="panal-header-title">
               <h1 class="pull-left">Edit DO Sale</h1>
            </div>
         </div>
         <div class="panel-body" ng-cloak>
            <!-- horizontal form -->
            <?php
               $attr = array('id' => 'form');
               echo form_open('sale/edit_do_sale?vno='.$result->voucher_no, $attr);
               ?>
            <div class="row">
               <div class="col-md-3">
                  <div class="form-group">
                     <div class="input-group date" id="datetimepicker">
                        <input type="text" name="date" value="<?php echo date('Y-m-d'); ?>" class="form-control" placeholder="YYYY-MM-DD" required readonly>
                        <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                     </div>
                  </div>
               </div>
               <div class="col-md-4">
                  <select ui-select2="{ allowClear: true}" class="form-control" ng-model='product_code'
                     data-placeholder="Select Product" ng-change="addNewProductFn()">
                     <option value="" selected disable> </option>
                     <option ng-repeat="product in allProducts" value="{{product.code}}">Batch No ({{product.batch_no}}) - {{product.name}}</option>
                  </select>
               </div>
            </div>
            <hr>
            <!-- necessary  input hidden -->
            <input type="hidden" name="godown_code" ng-init="godown_code = '<?= $result->godown_code ?>'" ng-model="godown_code" value="<?= $result->godown_code ?>">
            <input type="hidden" name="voucher_no" ng-model="voucher_no" ng-init="voucher_no='<?= $result->voucher_no?>'" />
            <input type="hidden" ng-model="party_code" ng-init="party_code='<?= $result->party_code?>'" />
            
            <table class="table table-bordered table2">
               <tr>
                  <th style="width: 40px;">SL</th>
                  <th>Item Code </th>
                  <th width="220px" >Item Description</th>
                  <th>Stock Qty</th>
                  <th width="120px">Unit</th>
                  <th width="120px">Bag Size</th>
                  <th width="120px">No. of Bag</th>
                  <th width="120px">Quantity</th>
                  <th width="100px">Total</th>
                  <th style="width: 50px;">Action</th>
               </tr>
               <tr ng-repeat="item in cart">
                  <td style="padding: 6px 8px !important;">
                     {{ $index + 1 }}
                  </td>
                  <td>
                     <input type="text" class="form-control" name="product_code[]" value="{{ item.product_code }}" readonly>
                     <input type="hidden" class="form-control" name="id[]" value="{{ item.item_id }}" readonly>
                     <input type="hidden" name="sale_price[]" class="form-control" min="0" ng-value="item.sale_price" step="any" required>
                     <input type="hidden" name="purchase_price[]" min="0" ng-value="item.purchase_price" step="any" required>
                  </td>
                  <td>
                     <p> {{item.product}} Batch No: {{item.batch_no}} {{item.specification}}</p>
                  </td>
                  <td> <input type="text" class="form-control" ng-model="item.stock_qty" readonly> </td>
                  <td>
                     <input type="text" name="unit[]" class="form-control" ng-model="item.unit" readonly>
                  </td>
                  <td>
                     <input type="number" name="bag_size[]" class="form-control" min="0"  ng-model="item.bag_size" readonly>
                  </td>
                  <td>
                     <input type="number" name="no_of_bag[]" class="form-control" min="0" ng-max="maxQuantity" ng-model="item.no_of_bag">
                  </td>  
                  <td>
                     <input type="number" name="order_quantity[]" class="form-control" ng-value="calculateTotalQty($index)" readonly>
                  </td>
                  <td>
                     <input type="number" class="form-control" ng-value="setSubtotalFn($index)" readonly>
                     <input type="hidden" ng-value="purchaseSubtotalFn($index)" step="any">
                  </td>
                  <td class="text-center">
                     <a title="Delete" class="btn btn-danger" ng-click="deleteItemFn($index)">
                     <i class="fa fa-times fa-lg"></i>
                     </a>
                  </td>
               </tr>
               <tr>
                  <th class="text-right" colspan="7">Total</th>
                  <th class="text-right" ng-bind="getTotalQtyFn()"></th>
                  <th colspan="2">{{ getTotalFn() }} Tk</th>
               </tr>
            </table>
            <!-- Product Delete Items-->
            <span ng-repeat="row in trashCart">
               <input type="hidden" name="delete_id[]" ng-value="row.item_id">
               <input type="hidden" name="delete_code[]" ng-value="row.product_code">
            </span>
            <hr>
            <div class="row form-horizontal">
               <div class="col-md-6">
                  <!-- Client List -->
                  <div class="form-group">
                     <label class="col-md-3 control-label">Client</label>
                     <div class="col-md-9">
                        <input type="text" ng-model="partyInfo.name" class="form-control" readonly/>
                     </div>
                  </div>
                  <div class="form-group">
                     <label class="col-md-3 control-label">Mobile </label>
                     <div class="col-md-9">
                        <input type="text" ng-model="partyInfo.mobile" class="form-control" readonly>
                     </div>
                  </div>
                  <div class="form-group">
                     <label class="col-md-3 control-label">Address </label>
                     <div class="col-md-9">
                        <p class="p-textarea" ng-bind="partyInfo.address"></p>
                     </div>
                  </div>
                  <div class="form-group" ng-hide="!party_code">
                     <label class="col-md-3 control-label">Due Limit</label>
                     <div class="col-md-9">
                        <div class="row">
                           <div class="col-md-1">
                              <div class="checkbox" style="padding-left: 5px;">
                                 <label><input type="checkbox" style="padding-left: 5px; transform: scale(2);" ng-model="dueLimitCheck" ng-clicked="dueLimitCheckFn()" ng-change="dueLimitCheckFn()"></label>
                              </div>
                           </div>
                           <div class="col-md-11">
                              <div class="input-group">
                                 <span class="input-group-addon">{{partyInfo.dueLimit}} %</span>
                                 <input type="text" class="form-control" ng-value="getVoucherPayAmountFn()" readonly>
                                 <span class="input-group-addon"> Tk</span>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="form-group" ng-if="!dueLimitCheck">
                     <label class="col-md-3 control-label">Reference <span class="req">*</span></label>
                     <div class="col-md-9">
                        <input type="text" name="due_limit_reference" class="form-control" placeholder="Reference" value="<?= $result->due_limit_reference?>" required>
                     </div>
                  </div>
               </div>
               <div class="col-md-6">
                  <div class="form-group">
                     <label class="col-md-4 control-label">Previous Balance </label>
                     <div class="col-md-8">
                        <div class="row">
                           <div class="col-md-7">
                              <input type="number" ng-model="partyInfo.balance" class="form-control"
                                 step="any" readonly>
                           </div>
                           <div class="col-md-5">
                              <input type="text" ng-value="partyInfo.sign" class="form-control" readonly>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="form-group">
                     <label class="col-md-4 control-label">Paid</label>
                     <div class="col-md-8">
                        <div class="row">
                           <div class="col-md-7">
                              <input type="number" name="paid" ng-model="amount.paid" class="form-control" step="any">
                              <input type="hidden" name="total" ng-value="getTotalFn()" class="form-control" step="any" readonly>
                              <input type="hidden" name="totalqty" ng-value="getTotalQtyFn()" class="form-control" step="any"
                                 readonly>
                           </div>
                           <div class="col-md-5">
                              <select name="method" class="form-control" ng-init="transactionBy='cash'" ng-model="transactionBy"
                                 required>
                                 <option value="cash">Cash</option>
                                 <option value="cheque">Cheque</option>
                                 <option value="bKash">bKash</option>
                              </select>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="form-group">
                     <label class="col-md-4 control-label">Current Balance </label>
                     <div class="col-md-8">
                        <div class="row">
                           <div class="col-md-7">
                              <input type="number" ng-value="getCurrentTotalFn()" class="form-control" step="any" readonly>
                           </div>
                           <div class="col-md-5">
                              <input type="text" ng-value="partyInfo.csign" class="form-control" readonly>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="form-group" >
                     <p class="col-md-12 text-right" style="font-weight: bold; color: red; font-size: 17px; margin: 0;" ng-bind="message"></p>
                  </div>
                  <div class="form-group" ng-if="amount.paid >= getVoucherPayAmountFn()">
                     <div class="col-md-12 text-right">
                        <input type="submit" name="save" value="Save" ng-disabled="isDisabled"  class="btn btn-primary">
                     </div>
                  </div>
               </div>
            </div>
            <?php echo form_close(); ?>
         </div>
         <div class="panel-footer">&nbsp;</div>
      </div>
   </div>
</div>
<script type="text/javascript">
   $(document).ready(function(){
       $('#datetimepicker').datetimepicker({
           format: 'YYYY-MM-DD'
       });
   });
</script>