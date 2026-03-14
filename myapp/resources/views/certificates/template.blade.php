<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Certificate of Completion - {{ $course->title }}</title>
    <style>
        @page { margin: 0; }
        * { margin: 0; padding: 0; }
        body {
            font-family: 'DejaVu Serif', 'Times New Roman', serif;
            color: #1f2937;
            line-height: 1.6;
            background: #fffbeb;
        }
        .certificate-wrapper {
            padding: 40px;
        }
        .certificate {
            border: 6px solid #b45309;
            padding: 50px 60px;
            background: #fffbeb;
            position: relative;
        }
        .certificate-inner {
            border: 2px solid #d4a574;
            padding: 45px 50px;
            text-align: center;
        }
        .logo-text {
            font-size: 32px;
            font-weight: bold;
            color: #92400e;
            letter-spacing: 6px;
            margin-bottom: 5px;
        }
        .logo-line {
            width: 150px;
            height: 2px;
            background: #b45309;
            margin: 15px auto 20px;
        }
        .certificate-title {
            font-size: 24px;
            color: #b45309;
            font-weight: bold;
            letter-spacing: 3px;
            text-transform: uppercase;
            margin-bottom: 35px;
        }
        .certify-text {
            font-size: 14px;
            color: #78350f;
            margin-bottom: 15px;
            font-style: italic;
        }
        .recipient-name {
            font-size: 28px;
            font-weight: bold;
            color: #1f2937;
            margin: 15px 0 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #b45309;
            display: inline-block;
            letter-spacing: 1px;
        }
        .course-text {
            font-size: 13px;
            color: #78350f;
            margin: 20px 0 8px;
        }
        .course-name {
            font-size: 20px;
            font-weight: bold;
            color: #1f2937;
            margin-bottom: 30px;
        }
        .seal-wrapper {
            width: 72px;
            height: 72px;
            border: 3px solid #b45309;
            border-radius: 50%;
            margin: 25px auto;
            overflow: hidden;
        }
        .seal-table {
            width: 100%;
            height: 100%;
            border-collapse: collapse;
        }
        .seal-cell {
            text-align: center;
            vertical-align: middle;
            font-size: 8px;
            font-weight: bold;
            color: #b45309;
            letter-spacing: 0.5px;
        }
        .details {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #d4a574;
        }
        .detail-row {
            font-size: 12px;
            color: #4b5563;
            margin: 6px 0;
        }
        .detail-label {
            font-weight: bold;
            color: #78350f;
        }
        .certificate-id {
            font-size: 10px;
            color: #9ca3af;
            margin-top: 25px;
            letter-spacing: 1px;
        }
    </style>
</head>
<body>
    <div class="certificate-wrapper">
        <div class="certificate">
            <div class="certificate-inner">
                <div class="logo-text">LMS</div>
                <div class="logo-line"></div>
                <div class="certificate-title">Certificate of Completion</div>

                <p class="certify-text">This is to certify that</p>
                <p class="recipient-name">{{ $user->name }}</p>
                <p class="course-text">has successfully completed the course</p>
                <p class="course-name">{{ $course->title }}</p>

                <div class="seal-wrapper">
                    <table class="seal-table"><tr><td class="seal-cell">VERIFIED</td></tr></table>
                </div>

                <div class="details">
                    <p class="detail-row"><span class="detail-label">Instructor:</span> {{ $course->instructor->name }}</p>
                    <p class="detail-row"><span class="detail-label">Date of Completion:</span> {{ $certificate->issued_at->format('F j, Y') }}</p>
                </div>

                <p class="certificate-id">Certificate ID: {{ $certificate->certificate_code }}</p>
            </div>
        </div>
    </div>
</body>
</html>
