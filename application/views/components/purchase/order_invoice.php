<style>
    .invoice {
        text-align: center;
        margin-bottom: 0;
    }
    .invoice h4 {
        border: 1px solid #212121;
        border-radius: 25px;
        padding: 4px 25px;
        font-size: 14px;
        margin-top: 10px;
        font-weight: bold;
        display: inline-block;
    }
    .signature_box {
        border: 1px solid transparent;
        margin-top: 65px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .signature_box h4 {
        border-top: 2px dashed #212121;
        color: #212121;
        padding: 6px 0;
        margin: 10px 0 0;
        font-size: 17px;
    }
</style>

<div class="container-fluid">
    <div class="row">
        <div class="panel panel-default ">
            <div class="panel-heading none">
                <div class="panal-header-title">
                    <h1 class="pull-left">Voucher Details</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>

            <div class="panel-body">
                <!-- Print banner -->
                <?php $this->load->view('components/print'); ?>
                <div class="invoice hide">
                    <h4>Purchase Order</h4>
                </div>
                <table class="table table-bordered">
                    <tr>
                        <th rowspan="3">Invoice To<br>Kishan Udyog Ltd. (Happy Fish)<br>Head Office Navana Yusuf Infinity. 16 Mohakhali<br>Commercial Area. Dhaka-1212.<br>Factory: Durbajuri, Mulia, Narail</th>
                        <th>Voucher No.<br>Rz/Sep/22/213</th>
                        <th>Dated<br>4-Sep-22</th>
                    </tr>
                    <tr>
                        <th></th>
                        <th>Mode/Terms of Payment<br>By Bank Deposit After Recelpt</th>
                    </tr>
                    <tr>
                        <th>Reference No. & Date.<br>Rz/Sep/22/213</th>
                        <th>Other References<br>Your Offer of 13 Aug 2022</th>
                    </tr>
                    <tr>
                        <th>Supplier (Bill from)<br>Arifs Bangladesh Ltd.<br>Lal Bhaban 18, Rajuk Avenue, Motijheel C/A, Dhaka-1000 <br> Attn: Mr Adhir, Cell: +880-1762628-902</th>
                        <th colspan="2">Terms of Delivery<br>
                            1. Delivered Buty Paid (DDP), Factory as per Inco-terms 2010<br>
                            2. Delivery Schedulo: Within 03 Days<br>
                            3. Delay Demurrage: 2% of the Contract Value/day<br>
                            5. Please Provide Mushak 6.3 with the Delivery
                        </th>
                    </tr>
                </table>
                
                <table class="table table-bordered">
                    <tr>
                        <th rowspan="2">SL No</th>
                        <th colspan="2" class="text-center">Description of Goods</th>
                        <th>Due on</th>
                        <th class="text-right" rowspan="2">Quantity</th>
                        <th class="text-right" rowspan="2">Rate</th>
                        <th class="text-right" rowspan="2">Unit</th>
                        <th class="text-right" rowspan="2">Disc. %</th>
                        <th class="text-right" rowspan="2">Amount</th>
                    </tr>
                    <tr>
                        <th class="text-center">Item</th>
                        <th class="text-center">Specification</th>
                    </tr>
                    <tr>
                        <td>01</td>
                        <td>Toxin Binder K</td>
                        <td>Toxin Binder K</td>
                        <td>6-Sep-22</td>
                        <td class="text-right">1,000.00 kg</td>
                        <td class="text-right">105.00</td>
                        <td class="text-right">kg</td>
                        <td class="text-right"></td>
                        <td class="text-right">1,05,000.00</td>
                    </tr>
                    <tr>
                        <th></th>
                        <th colspan="2" class="text-right">Total</th>
                        <th></th>
                        <th class="text-right">1,000.00 kg</th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th class="text-right">Tk 1,05,000.00</th>
                    </tr>
                </table>
                
                <p><strong>In Words: One Lakh Five Taka Only</strong></p>
                <p style="margin-top: 45px;"><strong>Remark:</strong> Test</p>
                
                <div class="signature_box">
                    <h4>Prepared By</h4>
                    <h4>Verified By</h4>
                    <h4>Authorized Signature</h4>
                </div>
            </div>
            
            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
