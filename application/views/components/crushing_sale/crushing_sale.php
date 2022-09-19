<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" />

<style>
    .table2 tr td{padding: 0 !important;}
    .table2 tr td input{border: 1px solid transparent;}

    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button{-webkit-appearance: none;margin: 0;}
    input[type=number] {-moz-appearance: textfield;}
</style>

<div class="container-fluid" ng-controller="CrushingSaleEntryCtrl">
    <div class="row">
        <?php echo $confirmation; ?>

        <div class="panel panel-default">
            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>Add Crushing Sale
                </div>
                <div class="panal-header-title pull-left">
                    <p style="color: red;font-weight:bold; margin-left: 25px;"><?php echo "Last voucher: ".$last_voucher[0]->voucher_no ;?></p>
                </div>
            </div>

            <div class="panel-body" ng-cloak>
                <!-- horizontal form -->
                <?php
                $attr = array('class' => 'form-horizontal');
                echo form_open('', $attr);
                ?>

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <div class="col-md-12">
                                <div class="input-group date" id="datetimepicker">
                                    <input type="text" name="date" value="<?php echo date("Y-m-d"); ?>" class="form-control" placeholder="YYYY-MM-DD" required>
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <div class="col-md-12">
                                <input type="text" name="voucher_number"
                                 value="<?php if($voucher_number != NULL){echo $voucher_number;} ?>"
                                 placeholder="Voucher No" class="form-control" required readonly>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                         <div class="form-group">
                             <div class="col-md-12">
                                 <select class="selectpicker form-control" ng-model="product" data-show-subtext="true" data-live-search="true"  required>
                                     <option value="" selected disabled>Raw Product</option>
                                     <?php if($allProducts != NULL){ foreach ($allProducts as $key => $value) { ?>
                                         <option value="<?php echo $value->code; ?> "><?php echo filter($value->name); ?></option>
                                     <?php } } ?>
                                 </select>
                             </div>
                          </div>
                     </div>
                     

                     <div class="col-md-2">
                         <div ng-init="showroom_id='<?php echo $branch; ?>'">
                             <div>
                                 <a class="btn btn-success" ng-click="addNewProductFn()">
                                     <i class="fa fa-plus fa-lg" aria-hidden="true"></i>
                                 </a>
                             </div>
                         </div>
                     </div>
                </div>
            <hr>

                <table class="table table-bordered table2">
                    <tr>
                        <th style="width: 40px;">SL</th>
                        <th style="width:275px;">Product Name</th>
                        <th width="120px">Stock</th>
                        <th width="80px">Quantity</th>
                        <th width="80px">Size</th>
                        <th width="80px">Bags</th>
                        <th width="100px">Sale Price</th>
                        <th width="100px">Total</th>
                        <th style="width: 50px;">Action</th>
                    </tr>

                    <tr ng-repeat="item in cart">
                        <td style="padding: 6px 8px !important;">{{ $index + 1 }}</td>

                        <td>
                            <input type="text" name="product[]" class="form-control" ng-model="item.product" readonly>
                            <input type="hidden" name="product_code[]" value="{{ item.product_code }}">
                            <input type="hidden" name="unit[]" class="form-control" value="{{item.unit}}">
                        </td>

                        <td>
                            <input type="text" class="form-control" ng-model="item.stock_qty" readonly>
                        </td>

                        <td>
                            <input type="number" name="quantity[]" class="form-control" min="1" max="{{ item.maxQuantity }}" ng-model="item.quantity" step="any">
                        </td>

                        <td>
                            <select class="form-control" name="bagSize[]" ng-model="bag_size" ng-change="calculateBags($index,bag_size);" required>
                                <option value="" selected disabled>&nbsp;</option>
                                 <?php foreach (config_item('bag_size') as $key => $value) { ?>
                                     <option value="<?php echo $key; ?>"><?php echo filter($value); ?></option>
                                 <?php } ?>
                            </select>
                        </td>

                        <td>
                            <input type="text" name="bags_no[]" ng-value="item.bags" class="form-control" readonly>
                        </td>

                        <td>
                            <input type="number" name="sale_price[]" class="form-control" min="0" ng-model="item.sale_price" step="any">
                            <input type="hidden" name="purchase_price[]" min="0" ng-value="item.purchase_price" step="any">
                        </td>

                        <td>
                            <input type="number" class="form-control" ng-value="setSubtotalFn($index)" readonly>
                            <input type="hidden"  ng-value="purchaseSubtotalFn($index)" step="any">
                        </td>

                        <td class="text-center">
                            <a title="Delete" class="btn btn-danger" ng-click="deleteItemFn($index)">
                                <i class="fa fa-times fa-lg"></i>
                            </a>
                        </td>
                    </tr>
                </table>
                <hr>

                <div class="row">
                    
                    <div class="col-md-6">
                        <table class="table table-bordered table2">
                            <tr>
                                <th> Crushing</th>
                                <th class="text-center">Qty.</th>
                                <th class="text-center">Rate</th>
                                <th class="text-center">Amount</th>
                            </tr>
                            
                            <tr>
                                <th><b>1.5 mm</b></th>
                                <th><input name="qty1" ng-model="qty1" min="0" step="any" type="number" class="form-control"></th>
                                <th><input name="rate1" ng-model="rate1" min="0" step="any" type="number" class="form-control"></th>
                                <th><input name="crushing_amount1" ng-model="getCrushingAmount1()" type="number" class="form-control" readonly></th>
                            </tr>
        
                            <tr>
                                <th><b>2.0 mm</b></th>
                                <th><input name="qty2" ng-model="qty2" min="0" step="any" type="number" class="form-control"></th>
                                <th><input name="rate2" ng-model="rate2" min="0" step="any" type="number" class="form-control"></th>
                                <th><input name="crushing_amount2" ng-model="getCrushingAmount2()" type="number" class="form-control" readonly></th>
                            </tr>
                            
                            <tr>
                                <th><b>3.0 mm</b></th>
                                <th><input name="qty3" ng-model="qty3" min="0" step="any" type="number" class="form-control"></th>
                                <th><input name="rate3" ng-model="rate3" min="0" step="any" type="number" class="form-control"></th>
                                <th><input name="crushing_amount3" ng-model="getCrushingAmount3()" type="number" class="form-control" readonly></th>
                            </tr>
                            
                            <tr>
                                <th><b>4.0 mm</b></th>
                                <th><input name="qty4" ng-model="qty4" min="0" step="any" type="number" class="form-control"></th>
                                <th><input name="rate4" ng-model="rate4" min="0" step="any" type="number" class="form-control"></th>
                                <th><input name="crushing_amount4" ng-model="getCrushingAmount4()" type="number" class="form-control" readonly></th>
                            </tr>
                            
                            <tr>
                                <th><b>5.0 mm</b></th>
                                <th><input name="qty5" ng-model="qty5" min="0" step="any" type="number" class="form-control"></th>
                                <th><input name="rate5" ng-model="rate5" min="0" step="any" type="number" class="form-control"></th>
                                <th><input name="crushing_amount5" ng-model="getCrushingAmount5()" type="number" class="form-control" readonly></th>
                            </tr>
                        </table>
                    </div>
                    
                    
                    <div class="col-md-6">

                        <!-- <div class="form-group">
                          <label class="col-md-4 control-label">Labour Cost</label>
                          <div class="col-md-8">
                              <input type="number" min=0 name="meta[labour_cost]" ng-model="amount.labour" class="form-control" step="any">
                          </div>
                        </div> -->
    
                          <div class="form-group">
                              <label class="col-md-4 control-label"> Total Quantity </label>
                              <div class="col-md-8">
                                  <input type="number" name="totalqty" ng-value="getTotalQtyFn()" class="form-control" step="any" readonly>
                              </div>
                          </div>
    
    	                    <div class="form-group">
    	                        <label class="col-md-4 control-label"> Total </label>
    	                        <div class="col-md-8">
    	                            <input type="number" name="total" ng-value="getTotalFn()" class="form-control" step="any" readonly>
                                    <input type="hidden" name="purchase_total" ng-value="getPurchaseTotalFn()" class="form-control" readonly>
    	                        </div>
    	                    </div>
    	                    
    	                    <div class="form-group">
    	                        <label class="col-md-4 control-label">Crushing Charge <span class="req"></span></label>
                                <div class="col-md-8">
    	                            <div class="row">
                                        <div class="col-md-12">
                                            <!--<input type="number" name="crushing_charge" ng-model="amount.crushing_charge" class="form-control" step="any" readonly>-->
                                            <input type="number" name="crushing_charge" ng-model="getTotalCrushingAmount()" class="form-control" step="any" readonly>
                                        </div>
                                    </div>
                                </div>
    	                    </div>
    
    	                    <div class="form-group">
    	                        <label class="col-md-4 control-label">Grand Total</label>
    	                        <div class="col-md-8">
    	                            <input type="number" name="grand_total" ng-value="getGrandTotalFn()" class="form-control" step="any" readonly>
    	                        </div>
    	                    </div>
    
                            <div class="form-group">
                                <label class="col-md-4 control-label">Previous Balance </label>
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-7">
                                            <input type="number" name="previous_balance" ng-model="partyInfo.balance" class="form-control" step="any" readonly>
                                        </div>
    
                                        <div class="col-md-5">
                                            <input type="text" name="previous_sign" ng-value="partyInfo.sign" class="form-control" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
    
    	                    <div class="form-group">
    	                        <label class="col-md-4 control-label">Paid <span class="req">*</span></label>
                                <div class="col-md-8">
    	                            <div class="row">
                                        <div class="col-md-7">
                                            <input type="number" name="paid" ng-model="amount.paid" class="form-control" step="any">
                                        </div>
                                        <div class="col-md-5">
                                            <select
    											name="method"
    											class="form-control"
    											ng-init="transactionBy='cash'"
    											ng-model="transactionBy" required>
                                                <option value="cash">Cash</option>
                                                <option value="cheque">Cheque</option>
                                                <option value="bKash">bKash</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
    	                    </div>
    
                            <!-- for selecting cheque -->
                            <div ng-if="transactionBy == 'cheque'">
                                <div class="form-group">
                                    <label class="col-md-4 control-label">
                                        Bank Name <span class="req">*</span>
                                    </label>
    
                                    <div class="col-md-8">
                                        <select  name="meta[bankname]" class="form-control">
                                          <option value="" selected disabled>&nbsp;</option>
                                          <?php foreach (config_item("banks") as $key => $value) { ?>
                                              <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                          <?php } ?>
                                        </select>
                                    </div>
                                </div>
    
                                <div class="form-group">
                                    <label class="col-md-4 control-label">
                                        Branch Name <span class="req">*</span>
                                    </label>
    
                                    <div class="col-md-8">
                                        <input type="text" name="meta[branchname]" class="form-control">
                                    </div>
                                </div>
    
                                <div class="form-group">
                                    <label class="col-md-4 control-label">
                                        Cheque No <span class="req">*</span>
                                    </label>
    
                                    <div class="col-md-8">
                                        <input type="text" name="meta[chequeno]" class="form-control">
                                    </div>
                                </div>
    
                                <div class="form-group">
                                    <label class="col-md-4 control-label">
                                        Pass Date <span class="req">*</span>
                                    </label>
    
                                    <div class="col-md-8">
                                        <input type="text" name="meta[passdate]" placeholder="YYYY-MM-DD" class="form-control">
                                        <input type="hidden" name="meta[status]" value="pending">
                                    </div>
                                </div>
                            </div>
    
                            <div class="form-group">
                                <label class="col-md-4 control-label">Current Balance </label>
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-7">
                                            <input type="number" name="current_balance" ng-value="getCurrentTotalFn()" class="form-control" step="any" readonly>
                                        </div>
    
                                        <div class="col-md-5">
                                            <input type="text" name="current_sign" ng-value="partyInfo.csign" class="form-control" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <!-- Sum Part End -->
                    </div> 
                        
                        
                    <!-- Address Part Start -->
                    <div class="col-md-6">
                        <div class="form-group">
                          <label class="col-md-3 control-label">Sale Type <span class="req">&nbsp;</span></label>
                            <div class="col-md-9">
                              <label ng-click="getsaleType('cash')">
                                <input type="radio" name="stype"  ng-model="stype" checked value="cash">
                                <span>Cash</span>
                              </label>

                              <label ng-click="getsaleType('credit')" style="margin-left: 20px;">
                                <input type="radio" name="stype"  ng-model="stype" value="credit">
                                <span>Credit</span>
                              </label>
                          </div>
                        </div>


                        <div  ng-init="active=true;" ng-show="active">
                            <div class="form-group">
                                <label class="col-md-3 control-label">Client </label>
                                <div class="col-md-9">
                                    <input type="text" name="name" class="form-control" >
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">Mobile</label>
                                <div class="col-md-9">
                                    <input type="text" name="mobile_number"  class="form-control">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">Address </label>
                                <div class="col-md-9">
                                    <textarea name="details_address" rows="4" class="form-control" ></textarea>
                                </div>
                            </div>
                        </div>



                       <div ng-init="active1=false;" ng-show="active1">
                          <!-- <div class="form-group">
                              <label class="col-md-3 control-label">Client ID</label>
                              <div class="col-md-9">
                                  <input list="allpartyList"
                                      name="code"
                                      ng-model="partyCode"
                                      ng-change="findPartyFn()"
                                      class="form-control">

                                      <datalist id="allpartyList">
                                      <?php
                                      //if($allClients != null){
                                          //foreach ($allClients as $key => $row) {
                                      ?>
                                      <option value="<?php //echo $row->code; ?>">
                                            <?php //echo $row->name." [ ". $row->address." ]"; ?>
                                      </option>
                                      <?php //}} ?>
                                  </datalist>
                              </div>
                          </div> -->

                          <div class="form-group">
                              <label class="col-md-3 control-label">Client</label>
                              <div class="col-md-9">
                                  <select
                                      name="code"
                                      ng-model="partyCode"
                                      ng-change="findPartyFn()"
                                      class="selectpicker form-control"
                                      data-show-subtext="true"
                                      data-live-search="true" >

                                      <option value="" selected disabled>&nbsp;</option>

                                      <?php
                                      if($allClients != null){
                                          foreach ($allClients as $key => $row) {
                                      ?>
                                      <option value="<?php echo $row->code; ?>">
                                            <?php echo filter($row->name)." ( ".$row->address." ) "; ?>
                                      </option>
                                      <?php }} ?>
                                  </select>
                              </div>
                          </div>

                           <!-- <div class="form-group">
                              <label class="col-md-3 control-label">Client</label>
                              <div class="col-md-9">
                                  <input type="text"  ng-model="partyInfo.name" class="form-control" readonly>
                              </div>
                                                     </div> -->

                          <div class="form-group">
                              <label class="col-md-3 control-label">Mobile  </label>
                              <div class="col-md-9">
                                  <input type="text" name="mobile" ng-model="partyInfo.contact" class="form-control" readonly>
                              </div>
                          </div>

                          <div class="form-group">
                              <label class="col-md-3 control-label">Address </label>
                              <div class="col-md-9">
                                  <textarea name="address" class="form-control" readonly>{{ partyInfo.address }}</textarea>
                              </div>
                          </div>
                      </div>
                    </div>
                    <!-- Address Part End -->
                </div>
                
                

                <div class="btn-group pull-right">
                    <input
                        type="submit"
                        name="save"
                        value="Save"
                        class="btn btn-primary"
                        ng-init="isDisabled=false;" ng-hide="isDisabled" >
                </div>

                <div class="btn-group pull-right">
                    <p ng-bind="message" style="font-weight:bold;color:red;font-size:18px;"></p>
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>
