<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            margin: 0;
            padding: 15px;
            color: #333;
            font-size: 13px;
            line-height: 1.4;
        }
        
        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            border: 2px solid #333;
        }
        
        .header-table td {
            padding: 15px;
            text-align: center;
            border: 1px solid #333;
            background-color: #f5f5f5;
        }
        
        .company-name {
            font-size: 22px;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 5px;
        }
        
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
            border: 1px solid #333;
        }
        
        .info-table th {
            background-color: #e9ecef;
            padding: 8px;
            text-align: left;
            font-weight: bold;
            border: 1px solid #333;
            font-size: 12px;
        }
        
        .info-table td {
            padding: 8px;
            border: 1px solid #333;
        }
        
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
            border: 2px solid #333;
            table-layout: fixed;
        }
        
        .items-table th {
            background-color: #333;
            color: white;
            padding: 8px 4px;
            text-align: center;
            font-weight: bold;
            font-size: 11px;
            border: 1px solid #333;
            word-wrap: break-word;
        }
        
        .items-table td {
            padding: 6px 4px;
            border: 1px solid #333;
            text-align: center;
            font-family: 'DejaVu Sans', Arial, sans-serif;
            word-wrap: break-word;
            vertical-align: middle;
        }
        
        .text-left {
            text-align: left;
        }
        
        .text-center {
            text-align: center;
        }
        
        .text-right {
            text-align: right;
        }
        
        .totals-table {
            width: 100%;
            border-collapse: collapse;
            border: 2px solid #333;
            margin-top: 15px;
        }
        
        .totals-table th {
            background-color: #e9ecef;
            padding: 10px;
            text-align: left;
            font-weight: bold;
            border: 1px solid #333;
        }
        
        .totals-table td {
            padding: 10px;
            border: 1px solid #333;
        }
        
        .total-row {
            font-weight: bold;
            background-color: #f8f9fa;
        }
        
        .footer-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            border: 1px solid #333;
        }
        
        .footer-table td {
            padding: 15px;
            text-align: center;
            border: 1px solid #333;
            background-color: #f5f5f5;
        }
        
        .urdu-text {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            direction: rtl;
            text-align: right;
        }
    </style>
</head>
<body>
    <!-- Header Table -->
<table class="header-table">
    <tr>
        <td style="font-size: 16px; font-weight: bold;">
            <?php echo $settings['shop_name'] ?? 'Billing System'; ?>
            <?php if (!empty($settings['phone'])): ?> | Contact: <?php echo $settings['phone']; ?><?php endif; ?>
        </td>
    </tr>
</table>

    <!-- Bill Information Table -->
<table class="info-table">
    <tr>
        <th width="25%">Bill Number</th>
        <td width="25%"><?php echo $bill->bill_number; ?></td>
        <th width="25%">Customer Name</th>
        <td width="25%"><?php echo !empty($bill->customer_name) ? $bill->customer_name : 'Walk-in Customer'; ?></td>
    </tr>
    <tr>
        <th>Date & Time</th>
        <td><?php echo date('d M Y, h:i A', strtotime($bill->created_at)); ?></td>
        <th>Customer Phone</th>
        <td><?php echo !empty($bill->customer_phone) ? $bill->customer_phone : 'N/A'; ?></td>
    </tr>
</table>

    <!-- Items Table -->
<table class="items-table">
    <thead>
        <tr>
            <th style="width: 8%;">S.No</th>
            <th style="width: 42%;">Item Description</th>
            <th style="width: 10%;">Qty</th>
            <th style="width: 20%;">Unit Price</th>
            <th style="width: 20%;">Total Price</th>
        </tr>
    </thead>
    <tbody>
        <?php $counter = 1; ?>
        <?php foreach ($bill->items as $item): ?>
        <tr>
            <td style="text-align: center; width: 8%;"><?php echo $counter++; ?></td>
            <td style="text-align: left; width: 42%; padding-left: 8px;"><?php echo $item->title; ?></td>
            <td style="text-align: center; width: 10%;"><?php echo $item->quantity; ?></td>
            <td style="text-align: right; width: 20%; padding-right: 8px;"><?php echo number_format($item->unit_price, 2); ?></td>
            <td style="text-align: right; width: 20%; padding-right: 8px;"><?php echo number_format($item->total_price, 2); ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

    <!-- Totals Table -->
<table class="totals-table">
    <tr class="total-row">
        <th width="70%">Grand Total</th>
        <td width="30%" class="text-right"><strong><?php echo $settings['currency_symbol'] ?? '₹'; ?> <?php echo number_format($bill->total_amount, 2); ?></strong></td>
    </tr>
</table>

    <!-- Footer Table -->
    <table class="footer-table">
        <tr>
            <td>
                <?php if (!empty($settings['invoice_footer'])): ?>
                    <?php echo $settings['invoice_footer']; ?>
                <?php else: ?>
                    Generated by Billing System - <?php echo date('Y'); ?>
                <?php endif; ?>
            </td>
        </tr>
    </table>
</body>
</html> 