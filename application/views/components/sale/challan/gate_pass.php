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
        margin-top: 0;
        display: inline-block;
    }
    .table > tbody > tr > td {padding: 2px 6px}
    @media print {
        .table > tbody > tr > th,
        .table > tbody > tr > td {padding: 2px 6px;}
    }
    .header_info {
        margin-bottom: 15px;
        flex-wrap: wrap;
        display: flex;
        width: 100%;
    }
    .header_info li {
        min-width: 220px;
        width: 33.33%;
        font-size: 15px;
        margin: 5px 0;
    }
    .header_info li strong {
        display: inline-block;
        min-width: 50px;
    }
    .signature_box {
        border: 1px solid transparent;
        margin-top: 45px;
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
                    <h1 class="pull-left">Gate Pass</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>
            
            <div class="panel-body">
                <!-- Print banner -->
                <?php $this->load->view('components/print'); ?>
                <div class="invoice hide">
                    <h4>Gate pass/Challan</h4>
                </div>
                
                <ul class="header_info">
                    <li><strong>Supplier Name</strong> : Aminur Islam</li>
                    <li><strong>Voucher No</strong> : 1354685</li>
                    <li><strong>Date</strong> : 15-10-2021</li>
                    <li><strong>Driver Name</strong> : 156321321</li>
                    <li><strong>Mobile</strong> : 0191027482</li>
                    <li style="width: 66.66%;"><strong>Address</strong> : Freelance It Lab</li>
                </ul>
                
                <table class="table table-bordered">
                    <tr>
                        <th style="width: 45px;">SL</th>
                        <th>Raw Materials</th>
                        <th>Unit</th>
                        <th class="text-right">Quantity</th>
                        <th class="text-right">Price</th>
                        <th class="text-right">Amount</th>
                    </tr>
                    <tr>
                        <td>01</td>
                        <td>Test Data</td>
                        <td>120</td>
                        <td class="text-right">45</td>
                        <td class="text-right">230</td>
                        <td class="text-right">1240</td>
                    </tr>
                </table>
                
                
                <div class="signature_box" style="padding-top: 15px;">
                    <h4>Received By</h4>
                </div>
                <div class="signature_box">
                    <h4>Store Department</h4>
                    <h4>Checked By</h4>
                    <h4>Authorised By</h4>
                </div>
            </div>
            
            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
