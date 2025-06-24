<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Inventory Report</title>
    <style>
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .shop-name {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        
        .report-title {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .report-date {
            font-size: 11px;
            color: #666;
            margin-bottom: 20px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }
        
        th {
            background-color: #333;
            color: white;
            font-weight: bold;
            padding: 8px 4px;
            text-align: center;
            border: 1px solid #333;
            font-size: 10px;
            word-wrap: break-word;
        }
        
        td {
            padding: 6px 4px;
            border: 1px solid #333;
            font-size: 10px;
            text-align: center;
            word-wrap: break-word;
            vertical-align: middle;
        }
        
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        
        .text-right {
            text-align: right !important;
        }
        
        .text-center {
            text-align: center !important;
        }
        
        .text-left {
            text-align: left !important;
        }
        
        .total-row {
            font-weight: bold;
            background-color: #f0f0f0 !important;
        }
        
        .no-items {
            text-align: center;
            padding: 30px;
            color: #666;
            font-style: italic;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="shop-name"><?php echo $settings['shop_name'] ?? 'Billing System'; ?></div>
        <div class="report-title">Inventory Report</div>
        <div class="report-date">Date: <?php echo $export_date; ?></div>
    </div>

    <?php if (!empty($items)): ?>
        <!-- Items Table -->
        <table>
            <thead>
                <tr>
                    <th style="width: 33%;">Sr#</th>
                    <th style="width: 33%;">Item Name</th>
                    <th style="width: 34%;">Price</th>
                </tr>
            </thead>
            <tbody>
                <?php $sr_no = 1; foreach ($items as $item): ?>
                    <tr>
                        <td class="text-center"><?php echo $sr_no++; ?></td>
                        <td class="text-left" style="padding-left: 8px;"><?php echo $item->title; ?></td>
                        <td class="text-right" style="padding-right: 8px; font-weight: bold;"><?php echo $settings['currency_symbol'] ?? '₹'; ?> <?php echo number_format($item->price, 2); ?></td>
                    </tr>
                <?php endforeach; ?>
                
                <!-- Total Row -->
                <tr class="total-row">
                    <td colspan="3" class="text-right" style="padding-right: 8px;"><strong>Total Items: <?php echo $total_items; ?></strong></td>
                    <td class="text-right" style="padding-right: 8px;"><strong><?php echo $settings['currency_symbol'] ?? '₹'; ?> <?php echo number_format($total_value, 2); ?></strong></td>
                </tr>
            </tbody>
        </table>
        
    <?php else: ?>
        <div class="no-items">
            No items found
            <?php if ($search): ?>
                for search: "<?php echo htmlspecialchars($search); ?>"
            <?php endif; ?>
        </div>
    <?php endif; ?>
</body>
</html> 