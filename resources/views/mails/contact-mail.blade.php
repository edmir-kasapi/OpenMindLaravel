<table width="100%" cellpadding="0" cellspacing="0" style="background:#f4f4f4;padding:30px 0;">
    <tr>
        <td align="center">
            <table width="600" cellpadding="0" cellspacing="0"
                style="background:#ffffff;border-radius:8px;overflow:hidden;box-shadow:0 2px 8px rgba(0,0,0,.08);">

                <!-- Header -->
                <tr>
                    <td style="background:#2563eb;padding:24px;text-align:center;">
                        <h1 style="margin:0;color:#ffffff;font-size:24px;">
                            New Contact Form Submission
                        </h1>
                    </td>
                </tr>

                <!-- Body -->
                <tr>
                    <td style="padding:32px;">
                        <p style="margin-top:0;font-size:16px;color:#333;">
                            You have received a new message from your website contact form.
                        </p>

                        <table width="100%" cellpadding="8" cellspacing="0" style="border-collapse:collapse;">
                            <tr>
                                <td style="width:140px;font-weight:bold;color:#555;border-bottom:1px solid #eee;">
                                    Name
                                </td>
                                <td style="border-bottom:1px solid #eee;">
                                    {{ $contact['name'] }}
                                </td>
                            </tr>

                            <tr>
                                <td style="font-weight:bold;color:#555;border-bottom:1px solid #eee;">
                                    Email
                                </td>
                                <td style="border-bottom:1px solid #eee;">
                                    <a href="mailto:{{ $contact['email'] }}">
                                        {{ $contact['email'] }}
                                    </a>
                                </td>
                            </tr>

                        </table>

                        <h3 style="margin-top:32px;color:#333;">
                            Message
                        </h3>

                        <div
                            style="padding:20px;background:#f8fafc;border-left:4px solid #2563eb;border-radius:4px;color:#444;line-height:1.6;white-space:pre-wrap;">
                            {{ $contact['message'] }}
                        </div>

                        <p style="margin-top:32px;color:#777;font-size:14px;">
                            This email was automatically generated from your website contact form.
                        </p>
                    </td>
                </tr>

                <!-- Footer -->
                <tr>
                    <td style="background:#f8f8f8;padding:20px;text-align:center;font-size:13px;color:#888;">
                        © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
                    </td>
                </tr>

            </table>
        </td>
    </tr>
</table>
