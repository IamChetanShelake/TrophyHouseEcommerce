<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact Form Submission - Trophy House</title>
    <style>
        body {
            background-color: #f5f7fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
            padding: 0;
            margin: 0;
        }

        .email-wrapper {
            max-width: 640px;
            margin: 30px auto;
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            overflow: hidden;
        }

        .email-header {
            background-color: #EEC714;
            color: #fff;
            text-align: center;
            padding: 20px;
            font-size: 24px;
            font-weight: 600;
        }

        .email-body {
            padding: 30px;
        }

        .email-body p {
            font-size: 15px;
            margin: 12px 0;
        }

        .label {
            font-weight: 600;
            color: #111;
            display: inline-block;
            width: 120px;
        }

        .footer {
            background: #f1f1f1;
            padding: 15px;
            text-align: center;
            font-size: 13px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="email-header">
            New Contact Form Submission
        </div>
        <div class="email-body">
            <p><span class="label">Name:</span> {{ $contact->name }}</p>
            <p><span class="label">Email:</span> {{ $contact->email }}</p>
            <p><span class="label">Phone:</span> {{ $contact->phone }}</p>
            <p><span class="label">Subject:</span> {{ $contact->subject }}</p>
            <p><span class="label">Message:</span> {{ $contact->message }}</p>
            <p><span class="label">Submitted At:</span> {{ $contact->created_at->format('d M Y, H:i') }}</p>
        </div>
        <div class="footer">
            This message was sent from the Trophy House website. For internal use only.
        </div>
    </div>
</body>
</html>
