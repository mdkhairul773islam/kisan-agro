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
                    <h1>P/L Report</h1>
                </div>
                <a href="#" class="pull-right none" style="margin-top: 0px; font-size: 14px;" onclick="window.print()">
                    <i class="fa fa-print"></i> Print
                </a>
            </div>

            <div class="panel-body">
                <!-- Print banner -->
                <?php $this->load->view('components/print'); ?>
                <div class="print_style hide text-center">
                    <h4>Statement of Comprehensive Income</h4>
                    <h5>For the year ended 2022</h5>
                    <p>March</p>
                </div>
                
                <table class="table table-bordered">
                    <tr>
                        <th>SL</th>
                        <th>Description</th>
                        <th>Note</th>
                        <th>2021</th>
                        <th>2022</th>
                    </tr>
                    <tr>
                        <td>01</td>
                        <td>Revenue/Sales</td>
                        <td class="text-center">23</td>
                        <td class="text-center"></td>
                        <td class="text-center"></td>
                    </tr>
                    <tr>
                        <td>02</td>
                        <td>Cost of sales</td>
                        <td class="text-center">24</td>
                        <td class="text-center"></td>
                        <td class="text-center"></td>
                    </tr>
                    <tr>
                        <td>03</td>
                        <td>Gross profit</td>
                        <td class="text-center"></td>
                        <td class="text-center">0</td>
                        <td class="text-center">0</td>
                    </tr>
                    <tr>
                        <td>04</td>
                        <td>Seling & distribution cost</td>
                        <td class="text-center">25</td>
                        <td class="text-center">0</td>
                        <td class="text-center">0</td>
                    </tr>
                    <tr>
                        <td>05</td>
                        <td>Adminstrative cost</td>
                        <td class="text-center">26</td>
                        <td class="text-center">0</td>
                        <td class="text-center">0</td>
                    </tr>
                    <tr>
                        <td>06</td>
                        <td></td>
                        <td class="text-center"></td>
                        <td class="text-center">0</td>
                        <td class="text-center">0</td>
                    </tr>
                    <tr>
                        <td>07</td>
                        <td>Other operating income</td>
                        <td class="text-center">27</td>
                        <td class="text-center">0</td>
                        <td class="text-center">0</td>
                    </tr>
                    <tr>
                        <td>08</td>
                        <td>Profit from operating activities</td>
                        <td class="text-center"></td>
                        <td class="text-center">0</td>
                        <td class="text-center">0</td>
                    </tr>
                    <tr>
                        <td>09</td>
                        <td>Finance costs</td>
                        <td class="text-center">28</td>
                        <td class="text-center">0</td>
                        <td class="text-center">0</td>
                    </tr>
                    <tr>
                        <td>09</td>
                        <td>Finance income</td>
                        <td class="text-center">29</td>
                        <td class="text-center">0</td>
                        <td class="text-center">0</td>
                    </tr>
                    <tr>
                        <td>10</td>
                        <td>Profit before WPPF and Welfare Fund</td>
                        <td class="text-center"></td>
                        <td class="text-center">0</td>
                        <td class="text-center">0</td>
                    </tr>
                    <tr>
                        <td>11</td>
                        <td>Contribution to WPPF and Welfare Fund</td>
                        <td class="text-center"></td>
                        <td class="text-center">0</td>
                        <td class="text-center">0</td>
                    </tr>
                    <tr>
                        <td>12</td>
                        <td>Profit before income tax</td>
                        <td class="text-center"></td>
                        <td class="text-center">0</td>
                        <td class="text-center">0</td>
                    </tr>
                    <tr>
                        <td>13</td>
                        <td>Provision for income tax:</td>
                        <td class="text-center"></td>
                        <td class="text-center"></td>
                        <td class="text-center"></td>
                    </tr>
                    <tr>
                        <td>14</td>
                        <td>Current tax</td>
                        <td class="text-center"></td>
                        <td class="text-center">0</td>
                        <td class="text-center">0</td>
                    </tr>
                    <tr>
                        <td>15</td>
                        <td>Deferred tax</td>
                        <td class="text-center"></td>
                        <td class="text-center">0</td>
                        <td class="text-center">0</td>
                    </tr>
                    <tr>
                        <td>16</td>
                        <td>Profit after tax for the year</td>
                        <td class="text-center"></td>
                        <td class="text-center">0</td>
                        <td class="text-center">0</td>
                    </tr>
                    <tr>
                        <td>17</td>
                        <td>Other comprehensive income</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>18</td>
                        <td>Revaluation surplus of property, plant and equipment</td>
                        <td class="text-center"></td>
                        <td class="text-center">0</td>
                        <td class="text-center">0</td>
                    </tr>
                    <tr>
                        <td>19</td>
                        <td>Deferred tax on revaluation surplus of assets</td>
                        <td class="text-center"></td>
                        <td class="text-center">0</td>
                        <td class="text-center">0</td>
                    </tr>
                    <tr>
                        <th colspan="3">Total comprehensive income for the year</th>
                        <th class="text-center">0</th>
                        <th class="text-center">0</th>
                    </tr>
                </table>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>

