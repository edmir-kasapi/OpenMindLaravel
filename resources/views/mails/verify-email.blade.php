<table width="100%" cellpadding="0" cellspacing="0" style="background:#f4f7fb;padding:40px 20px;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background:#ffffff;border-radius:12px;overflow:hidden;box-shadow:0 4px 12px rgba(0,0,0,.08);">

                    <!-- Header -->
                    <tr>
                        <td align="center" style="background:#2563eb;padding:30px;">
                            <h1 style="margin:0;color:#ffffff;font-size:28px;">
                                OpenMind
                            </h1>
                        </td>
                    </tr>

                    <!-- Content -->
                    <tr>
                        <td style="padding:40px;color:#374151;">
                            <h2 style="margin-top:0;color:#111827;">
                                Verify Your Email Address
                            </h2>

                            <p style="font-size:16px;line-height:1.7;">
                                Hello,
                            </p>

                            <p style="font-size:16px;line-height:1.7;">
                                Thank you for creating an account with
                                <strong>OpenMind</strong>.
                                Please verify your email address by clicking the button below.
                            </p>

                            <table cellpadding="0" cellspacing="0" style="margin:35px auto;">
                                <tr>
                                    <td align="center">
                                        <a href="{{ $verificationUrl }}"
                                           style="background:#2563eb;color:#ffffff;text-decoration:none;padding:14px 32px;border-radius:8px;font-size:16px;font-weight:bold;display:inline-block;">
                                            Verify Email
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <p style="font-size:15px;color:#6b7280;line-height:1.7;">
                                If the button doesn't work, copy and paste this link into your browser:
                            </p>

                            <p style="word-break:break-all;font-size:14px;color:#2563eb;">
                                {{ $verificationUrl }}
                            </p>

                            <hr style="border:none;border-top:1px solid #e5e7eb;margin:30px 0;">

                            <p style="font-size:14px;color:#6b7280;line-height:1.7;">
                                If you did not create an account, you can safely ignore this email.
                            </p>

                            <p style="font-size:14px;color:#6b7280;">
                                This verification link will expire automatically.
                            </p>

                            <p style="margin-top:40px;">
                                Regards,<br>
                                <strong>OpenMind Team</strong>
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td align="center" style="background:#f9fafb;padding:20px;color:#9ca3af;font-size:13px;">
                            © {{ date('Y') }} OpenMind . All rights reserved.
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>