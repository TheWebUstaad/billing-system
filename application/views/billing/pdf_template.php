<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            /* margin: 0; */
            /* padding: 10px; */
            color: #333;
            font-size: 9px;
            /* line-height: 1.3; */
            width: 100%;
        }
        .business-header {
            margin-bottom: 15px;
            /* padding: 8px 10px; */
            border-bottom: 2px solid #333;
            text-align: center;
        }
        .business-logo {
            display: block;
            margin-left: auto;
            margin-right: auto;
            text-align: center;
        }
        .business-name {
            font-size: 10px;
            font-weight: bold;
            /* margin-bottom: 4px; */
            text-align: center;
        }
        .business-info {
            font-size: 8px;
            color: #666;
            padding-top: 2px;
        }
        .half-wrapper {
            display: flex;
            justify-content: space-between;
            gap: 10px;
        }
        .customer-info {
            font-size: 8px;
            /* border: 1px solid #333; */
            /* background-color: #f9f9f9; */
            width: 80%;
            box-sizing: border-box;

        }
        .customer-info-table {
           
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
            box-sizing: border-box;
            padding: 5px;
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
            font-size: 12px;
        }
        .text-left { text-align: left !important; }
        .text-right { text-align: right !important; }
        .text-center { text-align: center !important; }
        .text-serial { text-align: center !important;
        width: 6%;
        }
        .text-title { 
            text-align: left !important;
            width: 40%;
        }
        .text-quantity { text-align: center !important;
        width: 15%;
        }
        .text-price { text-align: center !important;
        width: 15%;
        }
        .text-totla { text-align: center !important;
        width: 10%;
        }
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
        <div class="business-logo">
            <?php if (!empty($settings['logo'])): ?>
                <img src="<?php echo base_url('uploads/logos/' . $settings['logo']); ?>" alt="Shop Logo" style="height:50px; width:50px; display:block; margin-left:auto; margin-right:auto;">
            <?php endif; ?>
        </div>
        <div class="business-name">
            <?php echo !empty($settings['shop_name']) ? $settings['shop_name'] : 'Shop Name'; ?>
        </div>
        <div class="business-info">
            <?php 
            $info = array();
            if (!empty($settings['phone'])) $info[] = 'Ph: ' . $settings['phone'];
            if (!empty($settings['address'])) $info[] = $settings['address'];
            echo implode(' | ', $info);
            ?>
        </div>
    </div>
    <div class="half-wrapper">
    <div class="customer-info">
        <table class="customer-info-table" cellpadding="4" cellspacing="2" style="margin: 4px;">
            <tr>
                <td style="padding: 3px 6px;font-size: 10px; font-weight: bold;"><span class="info-label"></span> <?php echo !empty($bill->customer_name) ? $bill->customer_name : 'Walk-in'; ?></td>
                <td style="padding: 3px 6px;font-size: 12px; font-weight: bold;"><span class="info-label"></span> <?php echo date('d/m/Y', strtotime($bill->created_at)); ?></td>
                <td style="padding: 3px 6px;font-size: 12px; font-weight: bold;"><span class="info-label"></span> Bill No:<?php echo $bill->bill_number; ?></td>
            </tr>
        </table>
    </div>

        <table class="items-table">
            <thead>
                <tr>
                    <th style="width: 6%;">No</th>
                    <th style="width: 40%;">Item</th>
                    <th style="width: 15%;">Qty</th>
                    <th style="width: 15%;">Price</th>
                    <th style="width: 20%;">Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $counter = 1; 
                $total_qty = 0;
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
                    <td class="text-serial"><?php echo $counter++; ?></td>
                    <td class="text-title"><?php echo $item['title']; ?></td>
                    <td class="text-quantity"><?php echo $item['quantity']; ?></td>
                    <td class="text-price"><?php echo number_format($item['unit_price'], 2); ?></td>
                    <td class="text-total"><?php echo number_format($item['total_price'], 2); ?></td>
                </tr>
                <?php endforeach; ?>

                <tr style="background-color: #f5f5f5;">
                    <td colspan="2" style="font-weight: bold;">Total</td>
                    <td class="text-center" style="font-weight: bold;"><?php echo $total_qty; ?></td>
                    <td></td>
                    <td class="text-right" style="font-weight: bold;"> <?php echo number_format($bill->total_amount, 2); ?></td>
                </tr>
            </tbody>
        </table>
    </div>
    <!-- <div class="footer">
     power by websaaz solutions
    </div> -->
</body>
</html>
