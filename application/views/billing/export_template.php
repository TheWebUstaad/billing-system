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
            font-size: 11px;
            line-height: 1.3;
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
            font-size: 11px;
        }
        
        .info-table td {
            padding: 8px;
            border: 1px solid #333;
        }
        
        .bills-table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
            border: 2px solid #333;
            table-layout: fixed;
        }
        
        .bills-table th {
            background-color: #333;
            color: white;
            padding: 8px 4px;
            font-weight: bold;
            font-size: 10px;
            border: 1px solid #333;
            word-wrap: break-word;
        }
        
        .bills-table td {
            padding: 6px 4px;
            border: 1px solid #333;
            text-align: center;
            font-family: 'DejaVu Sans', Arial, sans-serif;
            word-wrap: break-word;
            vertical-align: middle;
            font-size: 10px;
        }
        
        .text-left {
            text-align: left !important;
        }
        
        .text-center {
            text-align: center !important;
        }
        
        .text-right {
            text-align: right !important;
        }
        
        .summary-table {
            width: 100%;
            border-collapse: collapse;
            border: 2px solid #333;
            margin-top: 15px;
        }
        
        .summary-table th {
            background-color: #e9ecef;
            padding: 10px;
            text-align: left;
            font-weight: bold;
            border: 1px solid #333;
        }
        
        .summary-table td {
            padding: 10px;
            border: 1px solid #333;
        }
        
        .total-row {
            font-weight: bold;
            background-color: #f8f9fa;
            font-size: 12px;
        }
        
        .footer-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            border: 1px solid #333;
        }
        
        .footer-table td {
            padding: 10px;
            text-align: center;
            border: 1px solid #333;
            background-color: #f5f5f5;
            font-size: 10px;
        }
        
        .page-break {
            page-break-before: always;
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
                <br><strong style="font-size: 14px; color: #666;">BILLS EXPORT REPORT</strong>
            </td>
        </tr>
    </table>

    <!-- Export Information Table -->
    <table class="info-table">
        <tr>
            <th width="25%">Export Date & Time</th>
            <td width="25%"><?php echo date('d M Y, h:i A', strtotime($export_date)); ?></td>
            <th width="25%">Date Range</th>
            <td width="25%"><?php echo date('d M Y', strtotime($from_date)); ?> to <?php echo date('d M Y', strtotime($to_date)); ?></td>
        </tr>
        <tr>
            <th>Total Bills</th>
            <td><strong><?php echo $total_bills; ?></strong></td>
            <th>Total Amount</th>
            <td><strong><?php echo $settings['currency_symbol'] ?? '₹'; ?> <?php echo number_format($total_amount, 2); ?></strong></td>
        </tr>
        <?php if (!empty($search)): ?>
        <tr>
            <th>Search Filter</th>
            <td colspan="3"><?php echo $search; ?></td>
        </tr>
        <?php endif; ?>
    </table>

    <!-- Bills Table -->
    <table class="bills-table">
        <thead>
            <tr>
                <th style="width: 21%; text-align: left;">Bill Number</th>
                <th style="width: 16%; text-align: left;">Customer</th>
                <th style="width: 18%; text-align: right;">Amount</th>
                <th style="width: 25%; text-align: center;">Date & Time</th>
                <th style="width: 20%; text-align: center;">Items</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($bills)): ?>
                <?php $counter = 1; ?>
                <?php foreach ($bills as $bill): ?>
                <tr>
                    <td class="text-left" style="padding-left: 8px; font-weight: bold;">
                        <?php echo $bill->bill_number; ?>
                    </td>
                    <td class="text-left" style="padding-left: 8px;">
                        <strong><?php echo !empty($bill->customer_name) ? $bill->customer_name : 'Walk-in Customer'; ?></strong>
                        <?php if (!empty($bill->customer_phone)): ?>
                            <br><small><?php echo $bill->customer_phone; ?></small>
                        <?php endif; ?>
                    </td>
                    <td class="text-right" style="padding-right: 8px; font-weight: bold;">
                        <?php echo $settings['currency_symbol'] ?? '₹'; ?> <?php echo number_format($bill->total_amount, 2); ?>
                    </td>
                    <td class="text-center">
                        <?php echo date('d M Y', strtotime($bill->created_at)); ?>
                        <br><small><?php echo date('h:i A', strtotime($bill->created_at)); ?></small>
                    </td>
                    <td class="text-center">
                        <?php echo isset($bill->items) ? count($bill->items) : 0; ?>
                    </td>
                </tr>
                <?php 
                // Add page break every 25 records
                if ($counter % 25 == 0 && $counter < count($bills)): 
                ?>
                </tbody>
                </table>
                <div class="page-break"></div>
                
                <!-- Header on new page -->
                <table class="header-table">
                    <tr>
                        <td style="font-size: 16px; font-weight: bold;">
                            <?php echo $settings['shop_name'] ?? 'Billing System'; ?>
                            <br><strong style="font-size: 14px; color: #666;">BILLS EXPORT REPORT (Continued)</strong>
                        </td>
                    </tr>
                </table>
                
                <table class="bills-table">
                    <thead>
                        <tr>
                            <th style="width: 18%; text-align: left;">Bill Number</th>
                            <th style="width: 32%; text-align: left;">Customer</th>
                            <th style="width: 18%; text-align: right;">Amount</th>
                            <th style="width: 22%; text-align: center;">Date & Time</th>
                            <th style="width: 10%; text-align: center;">Items</th>
                        </tr>
                    </thead>
                    <tbody>
                <?php endif; ?>
                <?php $counter++; ?>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center" style="padding: 20px; color: #666;">
                        No bills found for the selected date range
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Summary Table -->
    <table class="summary-table">
        <tr class="total-row">
            <th width="70%">EXPORT SUMMARY</th>
            <td width="30%" class="text-right"><strong>TOTAL: <?php echo $settings['currency_symbol'] ?? '₹'; ?> <?php echo number_format($total_amount, 2); ?></strong></td>
        </tr>
        <tr>
            <th>Total Bills Exported</th>
            <td class="text-right"><?php echo $total_bills; ?> bills</td>
        </tr>
        <tr>
            <th>Date Range</th>
            <td class="text-right"><?php echo date('d M Y', strtotime($from_date)); ?> to <?php echo date('d M Y', strtotime($to_date)); ?></td>
        </tr>
    </table>

    <!-- Footer Table -->
    <table class="footer-table">
        <tr>
            <td>
                <strong>Generated by <?php echo $settings['shop_name'] ?? 'Billing System'; ?></strong><br>
                Export Date: <?php echo date('d M Y, h:i A', strtotime($export_date)); ?> | 
                Report covers <?php echo $total_bills; ?> bills from <?php echo date('d M Y', strtotime($from_date)); ?> to <?php echo date('d M Y', strtotime($to_date)); ?>
            </td>
        </tr>
    </table>
</body>
</html> 