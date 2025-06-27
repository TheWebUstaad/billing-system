<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            margin: 0;
            padding: 10px;
            color: #333;
            font-size: 9px;
            line-height: 1.3;
        }
        .business-header {
            text-align: center;
            margin-bottom: 15px;
            padding: 8px 10px;
            border-bottom: 2px solid #333;
        }
        .business-name {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 4px;
        }
        .business-info {
            font-size: 8px;
            color: #666;
            padding-top: 2px;
        }
        .customer-info {
            margin-bottom: 15px;
            font-size: 8px;
            border: 1px solid #333;
            background-color: #f9f9f9;
        }
        .customer-info-table {
            width: 100%;
            font-size: 8px;
            border-collapse: separate;
            border-spacing: 0;
        }
        .customer-info-table td {
            padding: 8px 12px;
            vertical-align: top;
            border: none;
        }
        .info-label {
            font-weight: bold;
            margin-right: 3px;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #333;
            font-size: 8px;
            margin-bottom: 15px;
        }
        .items-table th {
            background-color: #333;
            color: white;
            padding: 6px 8px;
            text-align: center;
            font-weight: bold;
            border: 1px solid #333;
        }
        .items-table td {
            padding: 5px 8px;
            border: 1px solid #333;
            text-align: center;
        }
        .text-left { text-align: left !important; }
        .text-right { text-align: right !important; }
        .text-center { text-align: center !important; }
        .footer {
            text-align: center;
            margin-top: 15px;
            padding: 8px;
            font-size: 7px;
            color: #666;
            border-top: 1px solid #ddd;
        }
    </style>
</head>
<body>
    <div class="business-header">
        <div class="business-name"><?php echo $settings['shop_name'] ?? 'SHOP NAME'; ?></div>
        <div class="business-info">
            <?php 
            $info = array();
            if (!empty($settings['phone'])) $info[] = 'Ph: ' . $settings['phone'];
            if (!empty($settings['address'])) $info[] = $settings['address'];
            echo implode(' | ', $info);
            ?>
        </div>
    </div>

    <div class="customer-info">
        <table class="customer-info-table" cellpadding="4" cellspacing="2" style="margin: 4px;">
            <tr>
                <td style="padding: 3px 6px;"><span class="info-label">Customer:</span> <?php echo !empty($bill->customer_name) ? $bill->customer_name : 'Walk-in'; ?></td>
                <td style="padding: 3px 6px;"><span class="info-label">Ph:</span> <?php echo !empty($bill->customer_phone) ? $bill->customer_phone : '-'; ?></td>
            </tr>
            <tr>
                <td style="padding: 3px 6px;"><span class="info-label">Bill:</span> <?php echo $bill->bill_number; ?></td>
                <td style="padding: 3px 6px;"><span class="info-label">Date:</span> <?php echo date('d-M-y h:i A', strtotime($bill->created_at)); ?></td>
            </tr>
        </table>
    </div>

    <table class="items-table">
        <thead>
            <tr>
                <th style="width: 6%;">No</th>
                <th style="width: 40%;">Item</th>
                <th style="width: 10%;">Qty</th>
                <th style="width: 30%;">Price</th>
                <th style="width: 14%;">amount</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $counter = 1; 
            $total_qty = 0;
            
            // Group items by title and unit_price
            $grouped_items = array();
            foreach ($bill->items as $item) {
                $key = $item->title . '_' . $item->unit_price;
                if (!isset($grouped_items[$key])) {
                    $grouped_items[$key] = array(
                        'title' => $item->title,
                        'unit_price' => $item->unit_price,
                        'quantity' => 0,
                        'total_price' => 0
                    );
                }
                $grouped_items[$key]['quantity'] += $item->quantity;
                $grouped_items[$key]['total_price'] += $item->total_price;
                $total_qty += $item->quantity;
            }
            ?>
            <?php foreach ($grouped_items as $item): ?>
            <tr>
                <td class="text-center"><?php echo $counter++; ?></td>
                <td class="text-left"><?php echo $item['title']; ?></td>
                <td class="text-center"><?php echo $item['quantity']; ?></td>
                <td class="text-right"><?php echo number_format($item['unit_price'], 0); ?></td>
                <td class="text-right"><?php echo number_format($item['total_price'], 0); ?></td>
            </tr>
            <?php endforeach; ?>

            <tr style="background-color: #f5f5f5;">
                <td colspan="2" style="font-weight: bold;">Total</td>
                <td class="text-center" style="font-weight: bold;"><?php echo $total_qty; ?></td>
                <td></td>
                <td class="text-right" style="font-weight: bold;"><?php echo $settings['currency_symbol'] ?? 'PKR'; ?> <?php echo number_format($bill->total_amount, 0); ?></td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        Thank you for your business!
    </div>
</body>
</html>