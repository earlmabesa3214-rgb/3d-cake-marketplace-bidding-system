<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Baker Application Update</title>
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

      {{-- RED REJECTED BANNER --}}
      <tr><td style="background:#C0392B;padding:18px 40px;text-align:center;">
        <span style="font-size:1.3rem;vertical-align:middle;">📋</span>
        <span style="color:#fff;font-size:1.05rem;font-weight:700;margin-left:8px;vertical-align:middle;">Application Status Update</span>
      </td></tr>

      {{-- BODY --}}
      <tr><td style="background:#FFFDF9;padding:40px 40px 32px;border-left:1.5px solid #E2CDB8;border-right:1.5px solid #E2CDB8;">
        <p style="margin:0 0 16px;font-size:1rem;color:#2D1A0E;">Hi <strong>{{ $bakerName }}</strong>,</p>
        <p style="margin:0 0 24px;font-size:.95rem;color:#5C3D2E;line-height:1.7;">
          Thank you for applying to become a baker on BakeSphere. After carefully reviewing your application for
          <strong style="color:#C07850;">{{ $shopName }}</strong>,
          we were <strong style="color:#C0392B;">unable to approve it</strong> at this time.
        </p>

        {{-- REASON BOX (only shows if reason provided) --}}
        @if(!empty($reason))
        <table width="100%" cellpadding="0" cellspacing="0" style="background:#FDF0EE;border:1.5px solid #F5C5BE;border-radius:12px;margin-bottom:28px;">
          <tr><td style="padding:20px 24px;">
            <div style="font-size:.65rem;font-weight:700;text-transform:uppercase;letter-spacing:.18em;color:#C0392B;margin-bottom:8px;">Reason for Rejection</div>
            <p style="margin:0;font-size:.9rem;color:#8B2A1E;line-height:1.65;">{{ $reason }}</p>
          </td></tr>
        </table>
        @endif

        {{-- WHAT TO DO BOX --}}
        <table width="100%" cellpadding="0" cellspacing="0" style="background:#F5E6D8;border:1.5px solid #E2CDB8;border-radius:12px;margin-bottom:28px;">
          <tr><td style="padding:20px 24px;">
            <div style="font-size:.65rem;font-weight:700;text-transform:uppercase;letter-spacing:.18em;color:#9A7A65;margin-bottom:12px;">What you can do</div>
            <table width="100%" cellpadding="0" cellspacing="0">
              <tr><td style="padding:6px 0;font-size:.88rem;color:#5C3D2E;"><span style="color:#C07850;margin-right:8px;">→</span> Review and update your submitted documents</td></tr>
              <tr><td style="padding:6px 0;font-size:.88rem;color:#5C3D2E;"><span style="color:#C07850;margin-right:8px;">→</span> Contact our support team for clarification</td></tr>
              <tr><td style="padding:6px 0;font-size:.88rem;color:#5C3D2E;"><span style="color:#C07850;margin-right:8px;">→</span> Reapply once your documents are complete</td></tr>
            </table>
          </td></tr>
        </table>

        {{-- CTA --}}
        <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:28px;">
          <tr><td align="center">
            <a href="{{ $supportUrl }}"
               style="display:inline-block;padding:14px 40px;background:linear-gradient(135deg,#7B4F3A,#C07850);color:#fff;text-decoration:none;border-radius:10px;font-size:.95rem;font-weight:700;letter-spacing:.02em;">
              📩 Contact Support
            </a>
          </td></tr>
        </table>

        <p style="margin:0;font-size:.85rem;color:#9A7A65;line-height:1.65;">
          We appreciate your interest in joining BakeSphere and hope to work with you in the future.
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