<style>
    .print_style h4, .print_style h5, .print_style p {margin: 0 !important; padding: 0 !important;}
</style>
<?php /* 
<div class="container-fluid block-hide">
    <div class="row">
    <?php echo $this->session->flashdata('confirmation'); ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panal-header-title pull-left">
                    <h1>PL Report</h1>
                </div>
            </div>

            <div class="panel-body no-padding">
                <div class="no-title">&nbsp;</div>
                <!-- horizontal form -->
                <?php
                    $attribute = array('name' => '','class' => 'form-horizontal','id' => '');
                    echo form_open_multipart('', $attribute);
                ?>
                <div class="form-group">
                    <div class="col-md-7">
                        <div class="btn-group pull-right">
                            <input class="btn btn-primary" type="submit" name="show" value="Show">
                        </div>
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
*/ ?>

<div class="container-fluid">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading none">
                <div class="panal-header-title pull-left">
                    <h1>PL Report</h1>
                </div>
                <a href="#" class="pull-right none" style="margin-top: 0px; font-size: 14px;" onclick="window.print()">
                    <i class="fa fa-print"></i> Print
                </a>
            </div>

            <div class="panel-body">
                <!-- Print banner -->
                <?php $this->load->view('components/print'); ?>
                <div class="print_style hide text-center">
                    <h4>Statement of Financial Position</h4>
                    <h5>As at  30.04.2022</h5>
                    <!--<p>March</p>-->
                </div>
                
                <table class="table table-bordered">
                    <tr>
                        <th style="width: 45px;">SL</th>
                        <th>Particulars</th>
                        <th class="text-center">Note</th>
                        <th class="text-center">2021</th>
                        <th class="text-center">2022</th>
                    </tr>
                    <tr>
                        <th colspan="5">Assets</th>
                    </tr>
                    <tr>
                        <th></th>
                        <th colspan="4">Non Current Assets:</th>
                    </tr>
                    <tr>
                        <td>01</td>
                        <td>Property Plant and equipment</td>
                        <td class="text-center">4</td>
                        <td class="text-center">0</td>
                        <td class="text-center">0</td>
                    </tr>
                    <tr>
                        <td>02</td>
                        <td>Capital Work in Progress</td>
                        <td class="text-center">5</td>
                        <td class="text-center">0</td>
                        <td class="text-center">0</td>
                    </tr>
                    <tr>
                        <td>03</td>
                        <td>Intangible assets</td>
                        <td class="text-center">6</td>
                        <td class="text-center">0</td>
                        <td class="text-center">0</td>
                    </tr>
                    <tr>
                        <td>04</td>
                        <td>Investment</td>
                        <td class="text-center">7</td>
                        <td class="text-center">0</td>
                        <td class="text-center">0</td>
                    </tr>
                    <tr>
                        <th></th>
                        <th colspan="2">Total non-current asstes</th>
                        <th class="text-center">0</th>
                        <th class="text-center">0</th>
                    </tr>
                    
                    <tr>
                        <th></th>
                        <th colspan="4">Curret Assets:</th>
                    </tr>
                    <tr>
                        <td>05</td>
                        <td>Inventoties</td>
                        <td class="text-center">8</td>
                        <td class="text-center">0</td>
                        <td class="text-center">0</td>
                    </tr>
                    <tr>
                        <td>06</td>
                        <td>Account Receivables</td>
                        <td class="text-center">9</td>
                        <td class="text-center">0</td>
                        <td class="text-center">0</td>
                    </tr>
                    <tr>
                        <td>07</td>
                        <td>Loan to related companies</td>
                        <td class="text-center">10</td>
                        <td class="text-center">0</td>
                        <td class="text-center">0</td>
                    </tr>
                    <tr>
                        <td>08</td>
                        <td>Advance, Deposit & Prepayments</td>
                        <td class="text-center">11</td>
                        <td class="text-center">0</td>
                        <td class="text-center">0</td>
                    </tr>
                    <tr>
                        <td>09</td>
                        <td>Cash & cash equivalents</td>
                        <td class="text-center">12</td>
                        <td class="text-center">0</td>
                        <td class="text-center">0</td>
                    </tr>
                    <tr>
                        <th></th>
                        <th colspan="2">Total current asstts</th>
                        <th class="text-center">0</th>
                        <th class="text-center">0</th>
                    </tr>
                    <tr>
                        <th colspan="3">Total Assets</th>
                        <th class="text-center">0</th>
                        <th class="text-center">0</th>
                    </tr>
                    <tr>
                        <th></th>
                        <th colspan="4">Equity & Liabilities</th>
                    </tr>
                    <tr>
                        <td>10</td>
                        <td>Share Capital</td>
                        <td class="text-center">13</td>
                        <td class="text-center">0</td>
                        <td class="text-center">0</td>
                    </tr>
                    <tr>
                        <td>11</td>
                        <td>Retained earnings</td>
                        <td class="text-center"></td>
                        <td class="text-center"></td>
                        <td class="text-center"></td>
                    </tr>
                    <tr>
                        <td>12</td>
                        <td>Revaluation reserve</td>
                        <td class="text-center"></td>
                        <td class="text-center"></td>
                        <td class="text-center"></td>
                    </tr>
                    <tr>
                        <th></th>
                        <th colspan="2">Equity attributable to owners of the company</th>
                        <th class="text-center">0</th>
                        <th class="text-center">0</th>
                    </tr>
                </table>
                
                <table class="table table-bordered">
                    <tr>
                        <th style="width: 45px;">SL</th>
                        <th>Particulars</th>
                        <th class="text-center">Note</th>
                        <th class="text-center">2021</th>
                        <th class="text-center">2022</th>
                    </tr>
                    <tr>
                        <th colspan="5">Liabilities</th>
                    </tr>
                    <tr>
                        <th></th>
                        <th colspan="4">Non-current liabilities:</th>
                    </tr>
                    <tr>
                        <td>13</td>
                        <td>Loan term borrowings</td>
                        <td class="text-center">14</td>
                        <td class="text-center">0</td>
                        <td class="text-center">0</td>
                    </tr>
                    <tr>
                        <td>14</td>
                        <td>Deferred tax liability</td>
                        <td class="text-center">15</td>
                        <td class="text-center">0</td>
                        <td class="text-center">0</td>
                    </tr>
                    <tr>
                        <th></th>
                        <th colspan="2">Total non-current liabilities</th>
                        <th class="text-center">0</th>
                        <th class="text-center">0</th>
                    </tr>
                    <tr>
                        <th></th>
                        <th colspan="4">Current liabilities:</th>
                    </tr>
                    <tr>
                        <td>15</td>
                        <td>Accounts payable</td>
                        <td class="text-center">16</td>
                        <td class="text-center">0</td>
                        <td class="text-center">0</td>
                    </tr>
                    <tr>
                        <td>16</td>
                        <td>Short term borrowings</td>
                        <td class="text-center">17</td>
                        <td class="text-center">0</td>
                        <td class="text-center">0</td>
                    </tr>
                    <tr>
                        <td>17</td>
                        <td>Loan from related companies</td>
                        <td class="text-center">18</td>
                        <td class="text-center">0</td>
                        <td class="text-center">0</td>
                    </tr>
                    <tr>
                        <td>18</td>
                        <td>Liabilities for expenses</td>
                        <td class="text-center">19</td>
                        <td class="text-center">0</td>
                        <td class="text-center">0</td>
                    </tr>
                    <tr>
                        <td>19</td>
                        <td>Provision for income tax</td>
                        <td class="text-center">20</td>
                        <td class="text-center">0</td>
                        <td class="text-center">0</td>
                    </tr>
                    <tr>
                        <td>20</td>
                        <td>Provision for WPPF and Welfare Fund</td>
                        <td class="text-center">21</td>
                        <td class="text-center">0</td>
                        <td class="text-center">0</td>
                    </tr>
                    <tr>
                        <td>21</td>
                        <td>Other liabilities</td>
                        <td class="text-center">22</td>
                        <td class="text-center">0</td>
                        <td class="text-center">0</td>
                    </tr>
                    <tr>
                        <th></th>
                        <th colspan="2">Total current liabilities</th>
                        <th class="text-center">0</th>
                        <th class="text-center">0</th>
                    </tr>
                    <tr>
                        <th colspan="3">Total liabilities</th>
                        <th class="text-center">0</th>
                        <th class="text-center">0</th>
                    </tr>
                    <tr>
                        <th colspan="3">Total Equities and Liabilities</th>
                        <th class="text-center">0</th>
                        <th class="text-center">0</th>
                    </tr>
                </table>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>

