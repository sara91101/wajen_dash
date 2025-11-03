<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تنبيه نفاد المادة الخام - {{ config('app.name') }}</title>
    <style>
        /* Base Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #f5f7fa;
            color: #333;
            line-height: 1.6;
            padding: 20px;
        }
        
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        }
        
        /* Header */
        .header {
            background: linear-gradient(135deg, #2c7744 0%, #5a9e6a 100%);
            color: white;
            padding: 30px 20px;
            text-align: center;
            position: relative;
        }
        
        .header::after {
            content: "";
            position: absolute;
            bottom: -10px;
            right: 50%;
            transform: translateX(50%);
            width: 0;
            height: 0;
            border-left: 15px solid transparent;
            border-right: 15px solid transparent;
            border-top: 15px solid #2c7744;
        }
        
        .header h1 {
            font-size: 28px;
            margin-bottom: 10px;
        }
        
        .header p {
            opacity: 0.9;
            font-size: 16px;
        }
        
        /* Content */
        .content {
            padding: 30px;
        }
        
        .alert-box {
            background: linear-gradient(to left, #fff9e6 0%, #fff0cc 100%);
            border-right: 5px solid #ffc107;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 25px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
        }
        
        .alert-title {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }
        
        .alert-icon {
            background: #ffc107;
            color: #333;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-left: 15px;
            font-weight: bold;
            font-size: 20px;
        }
        
        .alert-content h3 {
            color: #b38705;
            font-size: 20px;
        }
        
        .details-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin: 20px 0;
        }
        
        .detail-item {
            background: white;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }
        
        .detail-value {
            font-size: 22px;
            font-weight: bold;
            color: #2c7744;
            margin: 8px 0;
        }
        
        .detail-label {
            font-size: 14px;
            color: #666;
        }
        
        .progress-container {
            margin: 25px 0;
        }
        
        .progress-label {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            font-size: 14px;
        }
        
        .progress-bar {
            height: 10px;
            background: #e9ecef;
            border-radius: 5px;
            overflow: hidden;
        }
        
        .progress-fill {
            height: 100%;
            background: linear-gradient(to left, #2c7744 0%, #5a9e6a 100%);
            width: {{ $reorderLevel }};
            border-radius: 5px;
        }
        
        .action-section {
            text-align: center;
            margin: 30px 0;
        }
        
        .action-button {
            display: inline-block;
            background: linear-gradient(to left, #2c7744 0%, #5a9e6a 100%);
            color: white;
            padding: 14px 35px;
            border-radius: 30px;
            text-decoration: none;
            font-weight: bold;
            font-size: 16px;
            box-shadow: 0 4px 10px rgba(44, 119, 68, 0.3);
            transition: all 0.3s ease;
        }
        
        .action-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(44, 119, 68, 0.4);
        }
        
        .contact-info {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            margin-top: 25px;
        }
        
        /* Footer */
        .footer {
            background: #2c3e50;
            color: #ecf0f1;
            padding: 25px 20px;
            text-align: center;
        }
        
        .footer-links {
            margin: 15px 0;
        }
        
        .footer-links a {
            color: #ecf0f1;
            margin: 0 10px;
            text-decoration: none;
            font-size: 14px;
        }
        
        .copyright {
            font-size: 12px;
            opacity: 0.7;
            margin-top: 15px;
        }
        
        /* Responsive */
        @media (max-width: 600px) {
            .details-grid {
                grid-template-columns: 1fr;
            }
            
            .content {
                padding: 20px;
            }
            
            body {
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>تنبيه بقرب انتهاء المادة الخام</h1>
            <p>نحرص على إبقائكم على اطلاع دائم بمستويات المخزون</p>
        </div>
        
        <div class="content">
            <div class="alert-box">
                <div class="alert-title">
                    <div class="alert-icon">!</div>
                    <div class="alert-content">
                        <h3>تنبيه: المادة الخام على وشك النفاد</h3>
                        <p>يرجى اتخاذ الإجراء اللازم لتجنب أي انقطاع في الإمدادات</p>
                    </div>
                </div>
                
                <div class="details-grid">
                    <div class="detail-item">
                        <div class="detail-label">المادة الخام</div>
                        <div class="detail-value">{{ $materialName }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">الكمية المتاحة</div>
                        <div class="detail-value">{{ $currentQuantity }} {{ $unit }}</div>
                    </div>
                    @if(!is_null($depletionDate))
                    <div class="detail-item">
                        <div class="detail-label">تاريخ النفاد المتوقع</div>
                        <div class="detail-value">{{ $depletionDate }}</div>
                    </div>
                    @endif
                    @if(!is_null($depletionPercentage))
                    <div class="detail-item">
                        <div class="detail-label">مستوى التنبيه</div>
                        <div class="detail-value">{{ $depletionPercentage }}%</div>
                    </div>
                    @endif
                </div>
                
                <div class="progress-container">
                    <div class="progress-label">
                        <span>المخزون الحالي</span>
                        <span>النفاد الكامل</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill"></div>
                    </div>
                </div>
            </div>
            
            <p>عزيزي {{ $customerName }},</p>
            <p>نود إعلامكم أن الكمية المتوفرة من المادة الخام <strong>{{ $materialName }}</strong> المخصصة لطلباتكم على وشك النفاد.</p>
            <p>لضمان استمرارية عملياتكم الإنتاجية دون أي انقطاع، نوصي بتقديم طلبكم الجديد في أقرب وقت ممكن.</p>
            
            <div class="action-section">
                <a href="{{ $inventoryUrl }}" class="action-button">تصفح الكميات</a>
            </div>
            
            <div class="contact-info">
                <p>للاستفسارات، يرجى التواصل معنا على:</p>
                <p><strong>هاتف:</strong> {{ $companyPhone }} | <strong>بريد إلكتروني:</strong> {{ $companyEmail }}</p>
            </div>
        </div>
        
        <div class="footer">
            <p>شكراً لثقتكم بنا</p>
            <div class="footer-links">
                <a href="{{ $websiteUrl }}">الموقع الإلكتروني</a>
                <a href="{{ $productsUrl }}">منتجاتنا</a>
                <a href="{{ $contactUrl }}">اتصل بنا</a>
            </div>
            <div class="copyright">
                © {{ date('Y') }} جميع الحقوق محفوظة | {{ $companyName }}
            </div>
        </div>
    </div>
</body>
</html>