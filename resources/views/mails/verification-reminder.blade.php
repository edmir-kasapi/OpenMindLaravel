<table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f6f8; padding:40px 0;">
    <tr>
        <td align="center">

            <table width="600" cellpadding="0" cellspacing="0"
                   style="background-color:#ffffff; border-radius:8px; overflow:hidden; box-shadow:0 2px 8px rgba(0,0,0,0.08);">

                <!-- Header -->
                <tr>
                    <td style="background-color:#2563eb; padding:30px; text-align:center;">
                        <h1 style="color:#ffffff; margin:0; font-size:24px;">
                            Verify Your Email Address
                        </h1>
                    </td>
                </tr>

                <!-- Content -->
                <tr>
                    <td style="padding:40px 35px; color:#333333; font-size:16px; line-height:1.6;">

                        <p>
                            Hi <strong>{{ $user_name}}</strong>,
                        </p>

                        <p>
                            We noticed that your email address has not been verified yet.
                            Please verify your email address to keep your account active and secure.
                        </p>

                        <p>
                            Email verification helps us protect your account and ensures that
                            you receive important notifications.
                        </p>

                        <p>
                            Please verify your email address before
                            <strong>{{ $verification_deadline }}</strong>.
                            If your email remains unverified after this date, your account may
                            be deleted and your data may no longer be accessible.
                        </p>

                        <p>
                            If you have already verified your email address, you can safely
                            ignore this message.
                        </p>

                        <p>
                            Thank you,<br>
                            <strong>OpenMind Team</strong>
                        </p>

                    </td>
                </tr>

                <!-- Footer -->
                <tr>
                    <td style="background-color:#f8fafc; padding:20px 35px; text-align:center; color:#6b7280; font-size:13px;">

                        <p style="margin:0;">
                            This email was sent because an account associated with this email
                            address has not completed verification.
                        </p>

                        <p style="margin:10px 0 0;">
                            © {{date('Y')}} OpenMind. All rights reserved.
                        </p>

                    </td>
                </tr>

            </table>

        </td>
    </tr>
</table>
