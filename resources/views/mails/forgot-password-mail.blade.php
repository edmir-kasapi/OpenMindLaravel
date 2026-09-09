<table width="100%" cellpadding="0" cellspacing="0" style="background:#f4f4f7;padding:40px 20px;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background:#ffffff;border-radius:8px;overflow:hidden;">
                    <tr>
                        <td style="background:#2563eb;padding:30px;text-align:center;">
                            <h1 style="margin:0;color:#ffffff;font-size:28px;">
                                OpenMind
                            </h1>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:40px;">
                            <h2 style="margin-top:0;color:#333;">
                                Reset Your Password
                            </h2>

                            <p style="color:#555;font-size:16px;line-height:1.6;">
                                Hello!,
                            </p>

                            <p style="color:#555;font-size:16px;line-height:1.6;">
                                We received a request to reset your password. Click the button below to choose a new password.
                            </p>

                            <table cellpadding="0" cellspacing="0" align="center" style="margin:35px auto;">
                                <tr>
                                    <td align="center" bgcolor="#2563eb" style="border-radius:6px;">
                                        <a href="{{ $actionUrl }}"
                                           style="display:inline-block;padding:14px 28px;color:#ffffff;text-decoration:none;font-size:16px;font-weight:bold;">
                                            Reset Password
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <p style="color:#555;font-size:16px;line-height:1.6;">
                                This password reset link will expire in
                                <strong>{{ config('auth.passwords.users.expire') }}</strong>
                                minutes.
                            </p>

                            <p style="color:#555;font-size:16px;line-height:1.6;">
                                If you didn't request a password reset, you can safely ignore this email.
                            </p>

                            <hr style="border:none;border-top:1px solid #e5e7eb;margin:30px 0;">

                            <p style="font-size:13px;color:#777;">
                                If the button above doesn't work, copy and paste this link into your browser:
                            </p>

                            <p style="font-size:13px;word-break:break-all;">
                                <a href="{{ $actionUrl }}" style="color:#2563eb;">
                                    {{ $actionUrl }}
                                </a>
                            </p>

                            <p style="margin-top:40px;color:#555;">
                                Regards,<br>
                                <strong>OpenMind Team</strong>
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:20px;background:#f9fafb;text-align:center;color:#999;font-size:12px;">
                            © {{ date('Y') }} OpenMind . All rights reserved.
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>