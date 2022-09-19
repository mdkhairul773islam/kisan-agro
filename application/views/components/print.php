
<div class="__print-border hide">
    <h2><?= (!empty(config_item('site_name')) ? config_item('site_name') : '') ?></h2>
    <p><?= (!empty(config_item('site_address')) ? config_item('site_address') : '') ?></p>
    <p><?= (!empty(config_item('site_mobile')) ? config_item('site_mobile') : '') ?></p>
</div>

<style>
    .__print-border {
        border-bottom: 1px solid #000;
        margin-bottom: 10px;
        padding: 0 0 10px;
        text-align: center;
    }
    .__print-border h2 {
        font-weight: bold;
        font-size: 42px;
        color: #000;
        margin: 0;
    }
    .__print-border p {
        font-size: 20px;
        color: #000;
        margin: 0;
    }
    @media print{
        aside, nav, .none, .panel-heading, .panel-footer{display: none !important;}
        .panel{
            border: 1px solid transparent;
            left: 0px;
            position: absolute;
            top: 0px;
            width: 100%;
        }
        .hide {display: block !important;}
        .block-hide {display: none;}
    }
</style>