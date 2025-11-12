<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>اقتراحات العملاء - نظام سكيل تاكس</title>
    <style>
        /* Reset styles for email clients */
        body, table, td, div, p, a {
            margin: 0;
            padding: 0;
            border: 0;
            font-size: 100%;
            font: inherit;
            vertical-align: baseline;
        }
        
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            -webkit-font-smoothing: antialiased;
        }
        
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }
        
        .header {
            background: linear-gradient(135deg, #2c5aa0 0%, #1e3a8a 100%);
            color: white;
            padding: 25px 20px;
            text-align: center;
        }
        
        .header h1 {
            font-size: 24px;
            margin: 0;
            font-weight: 600;
        }
        
        .header p {
            margin: 10px 0 0;
            opacity: 0.9;
        }
        
        .content {
            padding: 25px;
        }
        
        .greeting {
            font-size: 18px;
            margin-bottom: 20px;
            color: #2c5aa0;
            font-weight: 600;
        }
        
        .message-box {
            background-color: #f8f9fa;
            border-right: 4px solid #2c5aa0;
            padding: 18px;
            margin: 20px 0;
            border-radius: 4px;
        }
        
        .message-box.important {
            border-right-color: #e53e3e;
            background-color: #fed7d7;
        }
        
        .message-box.success {
            border-right-color: #38a169;
            background-color: #c6f6d5;
        }
        
        .feedback-details {
            width: 100%;
            border-collapse: collapse;
            margin: 25px 0;
            background-color: #f8f9fa;
            border-radius: 6px;
            overflow: hidden;
        }
        
        .feedback-details td {
            padding: 12px 15px;
            border-bottom: 1px solid #e2e8f0;
        }
        
        .feedback-details tr:last-child td {
            border-bottom: none;
        }
        
        .feedback-details .label {
            font-weight: bold;
            color: #2d3748;
            width: 30%;
            background-color: #edf2f7;
        }
        
        .feedback-content {
            background-color: #f7fafc;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 15px;
            margin: 20px 0;
        }
        
        .feedback-content h3 {
            margin: 0 0 10px;
            color: #2c5aa0;
            font-size: 16px;
        }
        
        .feedback-content p {
            margin: 0;
            line-height: 1.7;
        }
        
        .action-buttons {
            text-align: center;
            margin: 30px 0 20px;
        }
        
        .button {
            display: inline-block;
            background: linear-gradient(135deg, #2c5aa0 0%, #1e3a8a 100%);
            color: white;
            text-decoration: none;
            padding: 12px 25px;
            border-radius: 6px;
            margin: 5px 10px;
            font-weight: 600;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        
        .button.alert {
            background: linear-gradient(135deg, #e53e3e 0%, #c53030 100%);
        }
        
        .button.success {
            background: linear-gradient(135deg, #38a169 0%, #2f855a 100%);
        }
        
        .footer {
            background-color: #2d3748;
            color: #cbd5e0;
            padding: 25px 20px;
            text-align: center;
            font-size: 14px;
            line-height: 1.6;
        }
        
        .footer p {
            margin: 0 0 15px;
            font-size: 16px;
            color: #fff;
        }
        
        .footer-links {
            margin: 15px 0;
        }
        
        .footer-links a {
            color: #90cdf4;
            text-decoration: none;
            margin: 0 12px;
            font-size: 14px;
        }
        
        .footer-links a:hover {
            text-decoration: underline;
        }
        
        .copyright {
            margin-top: 20px;
            padding-top: 15px;
            border-top: 1px solid #4a5568;
            color: #a0aec0;
            font-size: 13px;
        }
        
        .restaurant-info {
            background-color: #edf2f7;
            padding: 15px;
            border-radius: 6px;
            margin: 20px 0;
        }
        
        .rating {
            color: #f6ad55;
            font-size: 18px;
            margin: 10px 0;
        }
        
        @media only screen and (max-width: 480px) {
            .email-container {
                width: 100% !important;
                border-radius: 0;
            }
            
            .header h1 {
                font-size: 20px;
            }
            
            .content {
                padding: 15px;
            }
            
            .feedback-details .label {
                width: 40%;
            }
            
            .button {
                display: block;
                margin: 10px 0;
                text-align: center;
            }
            
            .footer-links a {
                display: block;
                margin: 8px 0;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="header">
            <h1>نظام سكيل تاكس - إدارة العلاقات مع العملاء</h1>
            <p>اقتراحات وشكاوى العملاء</p>
        </div>
        
        <!-- Content -->
        <div class="content">
            <p class="greeting">عزيزي فريق المطعم،</p>
            
            <p>لقد تلقينا ملاحظات جديدة من أحد العملاء عبر المنيو الإلكتروني. يرجى الاطلاع على التفاصيل أدناه:</p>
            
            <div class="restaurant-info">
                <p><strong>المطعم:</strong> {{ $businessName }} - {{ $branchName }}</p>
                <p><strong>التاريخ والوقت:</strong> {{ $dateTime }}</p>
            </div>
            
            <table class="feedback-details">
                <tr>
                    <td class="label">نوع الرسالة:</td>
                    <td>
                        <span style="color: {{ $messageType === 'complaint' ? '#e53e3e' : '#2c5aa0' }}; font-weight: bold;">
                            {{ $messageType === 'complaint' ? 'شكوى' : 'مقترح' }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <td class="label">اسم العميل:</td>
                    <td>{{ $senderName }}</td>
                </tr>
                <tr>
                    <td class="label">رقم الهاتف:</td>
                    <td>{{ $senderPhoneNumber }}</td>
                </tr>
            </table>
            
            <div class="feedback-content">
                <h3>تفاصيل الملاحظات:</h3>
                <p>{{ $userMessage }}</p>
            </div>
            
            @if($messageType === 'complaint')
            <div class="message-box important">
                <p><strong>ملاحظة:</strong> هذه الشكوى تتطلب متابعة فورية حسب سياسة خدمة العملاء.</p>
            </div>
            @endif
            
            <div class="action-buttons">
                <a href="https://v1.skilltax.sa/menu/messagesList?p=1" class="button success">عرض التفاصيل الكاملة في النظام</a>
            </div>
            
            <p>مع خالص التحيات،<br>نظام سكيل تاكس - إدارة العلاقات مع العملاء</p>
        </div>
        
        <!-- Footer -->
        <div class="footer">
            <p>شكراً لثقتم بنا</p>
            <div class="footer-links">
                <a href="{{ $websiteUrl ?? '#' }}">الموقع الإلكتروني</a>
                <a href="{{ $productsUrl ?? '#' }}">منتجاتنا</a>
                <a href="{{ $contactUrl ?? '#' }}">اتصل بنا</a>
            </div>
            <div class="copyright">
                © {{ date('Y') }} جميع الحقوق محفوظة | {{ 'سكيل ناكس' ?? 'شركة المهارات' }}
            </div>
        </div>
    </div>
</body>
</html>