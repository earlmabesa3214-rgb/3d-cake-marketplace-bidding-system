<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Baker Application Approved</title>
</head>
<body style="margin:0;padding:0;background:#FDF6F0;font-family:'Segoe UI',Arial,sans-serif;">
<table width="100%" cellpadding="0" cellspacing="0" style="background:#FDF6F0;padding:40px 20px;">
  <tr><td align="center">
    <table width="600" cellpadding="0" cellspacing="0" style="max-width:600px;width:100%;">

      {{-- HEADER --}}
      <tr><td style="background:linear-gradient(135deg,#3D2314,#7B4F3A);border-radius:16px 16px 0 0;padding:32px 40px;text-align:center;">
        <div style="font-size:2rem;margin-bottom:8px;">🎂</div>
        <div style="font-family:Georgia,serif;font-size:1.6rem;color:#E8C9A8;font-weight:700;">
          Bake<span style="color:#C07850;">Sphere</span>
        </div>
        <div style="font-size:.72rem;color:rgba(255,255,255,.4);letter-spacing:.18em;text-transform:uppercase;margin-top:4px;">Baker Portal</div>
      </td></tr>

      {{-- GREEN APPROVED BANNER --}}
      <tr><td style="background:#5B8F6A;padding:18px 40px;text-align:center;">
        <span style="font-size:1.3rem;vertical-align:middle;">🎉</span>
        <span style="color:#fff;font-size:1.05rem;font-weight:700;margin-left:8px;vertical-align:middle;">Your Application is Approved!</span>
      </td></tr>

      {{-- BODY --}}
      <tr><td style="background:#FFFDF9;padding:40px 40px 32px;border-left:1.5px solid #E2CDB8;border-right:1.5px solid #E2CDB8;">
        <p style="margin:0 0 16px;font-size:1rem;color:#2D1A0E;">Hi <strong>{{ $bakerName }}</strong>,</p>
        <p style="margin:0 0 24px;font-size:.95rem;color:#5C3D2E;line-height:1.7;">
          Great news! Your baker application for
          <strong style="color:#C07850;">{{ $shopName }}</strong>
          has been reviewed and <strong style="color:#5B8F6A;">approved</strong> by our admin team.
        </p>

        {{-- INFO BOX --}}
        <table width="100%" cellpadding="0" cellspacing="0" style="background:#F5E6D8;border:1.5px solid #E2CDB8;border-radius:12px;margin-bottom:28px;">
          <tr><td style="padding:20px 24px;">
            <div style="font-size:.65rem;font-weight:700;text-transform:uppercase;letter-spacing:.18em;color:#9A7A65;margin-bottom:12px;">What happens next</div>
            <table width="100%" cellpadding="0" cellspacing="0">
              <tr><td style="padding:6px 0;font-size:.88rem;color:#5C3D2E;"><span style="color:#5B8F6A;margin-right:8px;font-weight:700;">✓</span> Log in to your Baker Dashboard</td></tr>
              <tr><td style="padding:6px 0;font-size:.88rem;color:#5C3D2E;"><span style="color:#5B8F6A;margin-right:8px;font-weight:700;">✓</span> Browse customer cake requests</td></tr>
              <tr><td style="padding:6px 0;font-size:.88rem;color:#5C3D2E;"><span style="color:#5B8F6A;margin-right:8px;font-weight:700;">✓</span> Submit your bids and start earning</td></tr>
            </table>
          </td></tr>
        </table>

        {{-- CTA --}}
        <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:28px;">
          <tr><td align="center">
            <a href="{{ $loginUrl }}"
               style="display:inline-block;padding:14px 40px;background:linear-gradient(135deg,#7B4F3A,#C07850);color:#fff;text-decoration:none;border-radius:10px;font-size:.95rem;font-weight:700;letter-spacing:.02em;">
              🎂 Go to Baker Dashboard
            </a>
          </td></tr>
        </table>

        <p style="margin:0;font-size:.85rem;color:#9A7A65;line-height:1.65;">
          Welcome to the BakeSphere community! We're thrilled to have you on board. If you have any questions, feel free to reach out to our support team.
        </p>
      </td></tr>

      {{-- FOOTER --}}
      <tr><td style="background:#F5E6D8;border:1.5px solid #E2CDB8;border-top:none;border-radius:0 0 16px 16px;padding:20px 40px;text-align:center;">
        <p style="margin:0 0 4px;font-size:.75rem;color:#9A7A65;">— The BakeSphere Team</p>
        <p style="margin:0;font-size:.68rem;color:#C0A080;">© {{ date('Y') }} BakeSphere. All rights reserved.</p>
      </td></tr>

    </table>
  </td></tr>
</table>
</body>
</html>