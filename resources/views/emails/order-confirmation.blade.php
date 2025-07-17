<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f8f9fa;
        }
        .email-container {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 600;
        }
        .header p {
            margin: 10px 0 0 0;
            opacity: 0.9;
        }
        .content {
            padding: 30px;
        }
        .order-info {
            background-color: #f8f9fa;
            border-radius: 6px;
            padding: 20px;
            margin-bottom: 30px;
        }
        .order-info h2 {
            color: #495057;
            margin-top: 0;
            font-size: 20px;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        .info-label {
            font-weight: 600;
            color: #6c757d;
        }
        .info-value {
            color: #495057;
        }
        .order-items {
            margin-bottom: 30px;
        }
        .order-items h3 {
            color: #495057;
            border-bottom: 2px solid #e9ecef;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid #e9ecef;
        }
        .item:last-child {
            border-bottom: none;
        }
        .item-details {
            flex: 1;
        }
        .item-name {
            font-weight: 600;
            color: #495057;
            margin-bottom: 5px;
        }
        .item-quantity {
            color: #6c757d;
            font-size: 14px;
        }
        .item-price {
            font-weight: 600;
            color: #495057;
            text-align: right;
            min-width: 80px;
        }
        .total-section {
            background-color: #f8f9fa;
            border-radius: 6px;
            padding: 20px;
            margin-bottom: 30px;
        }
        .total-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        .total-final {
            font-size: 18px;
            font-weight: 700;
            color: #495057;
            border-top: 2px solid #dee2e6;
            padding-top: 15px;
            margin-top: 15px;
        }
        .status-badge {
            display: inline-block;
            background-color: #ffc107;
            color: #212529;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 30px;
            text-align: center;
            border-top: 1px solid #dee2e6;
        }
        .footer p {
            margin: 0;
            color: #6c757d;
            font-size: 14px;
        }
        .footer a {
            color: #667eea;
            text-decoration: none;
        }
        .footer a:hover {
            text-decoration: underline;
        }
        @media (max-width: 600px) {
            .info-row, .item, .total-row {
                flex-direction: column;
                align-items: flex-start;
            }
            .item-price {
                text-align: left;
                margin-top: 5px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>Order Confirmed!</h1>
            <p>Thank you for your purchase, {{ $user->name }}!</p>
        </div>
        
        <div class="content">
            <div class="order-info">
                <h2>Order Information</h2>
                <div class="info-row">
                    <span class="info-label">Order Number:</span>
                    <span class="info-value">#{{ $order->id }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Order Date:</span>
                    <span class="info-value">{{ $order->created_at->format('F j, Y \a\t g:i A') }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Status:</span>
                    <span class="info-value">
                        <span class="status-badge">{{ ucfirst($order->status) }}</span>
                    </span>
                </div>
                <div class="info-row">
                    <span class="info-label">Customer:</span>
                    <span class="info-value">{{ $user->name }} ({{ $user->email }})</span>
                </div>
            </div>

            <div class="order-items">
                <h3>Order Items</h3>
                @foreach($orderItems as $item)
                <div class="item">
                    <div class="item-details">
                        <div class="item-name">{{ $item->product->name }}</div>
                        <div class="item-quantity">Quantity: {{ $item->quantity }}</div>
                    </div>
                    <div class="item-price">
                        ${{ number_format($item->price * $item->quantity, 2) }}
                    </div>
                </div>
                @endforeach
            </div>

            <div class="total-section">
                <div class="total-row">
                    <span>Subtotal:</span>
                    <span>${{ number_format($order->total_amount, 2) }}</span>
                </div>
                <div class="total-row">
                    <span>Shipping:</span>
                    <span>Free</span>
                </div>
                <div class="total-row">
                    <span>Tax:</span>
                    <span>$0.00</span>
                </div>
                <div class="total-row total-final">
                    <span>Total:</span>
                    <span>${{ number_format($order->total_amount, 2) }}</span>
                </div>
            </div>

            <p>We're processing your order and will send you another email with tracking information once your items have been shipped.</p>
            
            <p>If you have any questions about your order, please don't hesitate to contact our customer support team.</p>
        </div>

        <div class="footer">
            <p>Thank you for shopping with us!</p>
            <p>
                <a href="#">Visit our website</a> | 
                <a href="#">Contact Support</a> | 
                <a href="#">Track Your Order</a>
            </p>
        </div>
    </div>
</body>
</html>