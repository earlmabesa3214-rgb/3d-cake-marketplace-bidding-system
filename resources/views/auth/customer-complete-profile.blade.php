
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complete Your Profile — BakeSphere</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --cream: #FDF6F0; --warm-white: #FFFDF9;
            --brown-dark: #5C3D2E; --brown-mid: #7B4F3A;
            --brown-accent: #C07850; --brown-light: #E8C9A8;
            --brown-pale: #F5E6D8; --border: #E2CDB8;
            --text-dark: #2D1A0E; --text-muted: #9A7A65;
            --err: #C0392B; --success: #5B8F6A;
        }
        html, body { min-height: 100vh; font-family: 'Plus Jakarta Sans', sans-serif; background: var(--cream); color: var(--text-dark); }

        /* TOP BANNER */
        .top-banner { background: linear-gradient(135deg, #3D2314, #7B4F3A); padding: .75rem 2.5rem; display: flex; align-items: center; justify-content: space-between; }
        .top-banner-left { display: flex; align-items: center; gap: 1.25rem; }
        
      .top-banner-brand { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 1.2rem; color: var(--brown-light); font-weight: 700; }
        .top-banner-brand span { color: var(--brown-accent); }
        .btn-back-login { display: inline-flex; align-items: center; gap: .4rem; font-size: .75rem; font-weight: 600; color: rgba(255,255,255,.55); background: rgba(255,255,255,.08); border: 1px solid rgba(255,255,255,.15); border-radius: 7px; padding: .35rem .75rem; text-decoration: none; transition: all .2s; }
        .btn-back-login:hover { background: rgba(255,255,255,.15); color: rgba(255,255,255,.85); border-color: rgba(255,255,255,.3); }
   

        /* PROGRESS STEPS */
        .progress-wrap { background: var(--warm-white); border-bottom: 1.5px solid var(--border); padding: .7rem 2.5rem; display: flex; align-items: center; }
        .step { display: flex; align-items: center; gap: .45rem; font-size: .75rem; color: var(--text-muted); white-space: nowrap; }
        .step.done   { color: var(--success); }
        .step.active { color: var(--brown-accent); font-weight: 600; }
        .step-num { width: 20px; height: 20px; border-radius: 50%; border: 2px solid currentColor; display: flex; align-items: center; justify-content: center; font-size: .64rem; font-weight: 700; flex-shrink: 0; }
        .step.done .step-num   { background: var(--success); color: #fff; border-color: var(--success); }
        .step.active .step-num { background: var(--brown-accent); color: #fff; border-color: var(--brown-accent); }
        .step-line { flex: 1; height: 1.5px; background: var(--border); margin: 0 .6rem; }

        /* PAGE BODY */
        .page-body { display: flex; align-items: center; justify-content: center; padding: 2.5rem 1.5rem 4rem; }

        body {
            min-height: 100vh; background: var(--cream);
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .card {
            background: var(--warm-white); border: 1.5px solid var(--border);
            border-radius: 20px; padding: 2.5rem 2rem; max-width: 560px;
            width: 100%; box-shadow: 0 16px 48px rgba(92,61,46,.10);
        }
        .brand { text-align: center; margin-bottom: 1.75rem; }
     .brand-name { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 1.5rem; color: var(--brown-dark); font-weight: 700; }
        .brand-name span { color: var(--brown-accent); }
        .brand-sub { font-size: .72rem; color: var(--text-muted); margin-top: .2rem; }

        .avatar-wrap { display: flex; align-items: center; gap: .85rem; background: var(--brown-pale); border: 1.5px solid var(--border); border-radius: 12px; padding: .85rem 1rem; margin-bottom: 1.25rem; }
        .avatar { width: 44px; height: 44px; border-radius: 50%; object-fit: cover; border: 2px solid var(--border); }
        .avatar-placeholder { width: 44px; height: 44px; border-radius: 50%; background: var(--brown-accent); display: flex; align-items: center; justify-content: center; font-size: 1.1rem; font-weight: 700; color: #fff; flex-shrink: 0; }
        .avatar-name { font-size: .9rem; font-weight: 700; color: var(--brown-dark); }
        .avatar-email { font-size: .75rem; color: var(--text-muted); margin-top: .1rem; }
        .locked-badge { font-size: .58rem; background: var(--success); color: #fff; padding: .12rem .4rem; border-radius: 20px; font-weight: 700; margin-left: auto; white-space: nowrap; }

        .prefill-notice { display: flex; align-items: flex-start; gap: .65rem; background: #EEF6FF; border: 1.5px solid #BFD9F5; border-radius: 10px; padding: .75rem 1rem; margin-bottom: 1.5rem; font-size: .8rem; color: #1E5C9B; line-height: 1.6; }

        .section-label { font-size: .62rem; font-weight: 700; text-transform: uppercase; letter-spacing: .2em; color: var(--brown-accent); margin: 1.5rem 0 .85rem; padding-bottom: .5rem; border-bottom: 1.5px solid var(--border); display: flex; align-items: center; gap: .4rem; }
        .section-label:first-of-type { margin-top: 0; }
/* ── Combo Box ── */
        .combo-wrap { position: relative; }
        .combo-wrap .form-input { padding-right: 2.2rem; cursor: pointer; }
        .combo-wrap::after { content: '▾'; position: absolute; right: .85rem; top: 50%; transform: translateY(-50%); color: var(--text-muted); pointer-events: none; font-size: .8rem; }
        .combo-dropdown {
            display: none; position: absolute; top: calc(100% + 4px); left: 0; right: 0;
            background: var(--warm-white); border: 1.5px solid var(--brown-accent);
            border-radius: 10px; z-index: 200; max-height: 200px; overflow-y: auto;
            box-shadow: 0 8px 24px rgba(92,61,46,.15);
        }
        .combo-dropdown.open { display: block; }
        .combo-option {
            padding: .55rem 1rem; font-size: .85rem; color: var(--text-dark);
            cursor: pointer; transition: background .12s;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .combo-option:hover, .combo-option.highlighted { background: var(--brown-pale); color: var(--brown-dark); font-weight: 600; }
        .combo-option.no-result { color: var(--text-muted); font-style: italic; cursor: default; }
        .combo-option.no-result:hover { background: none; }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: .85rem; }
        .form-row-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: .85rem; }
        .form-group { margin-bottom: 1rem; }
        .form-label { display: block; font-size: .82rem; font-weight: 600; color: var(--brown-dark); margin-bottom: .4rem; }
        .form-label .req { color: var(--brown-accent); }
        .form-label .hint { font-size: .7rem; font-weight: 400; color: var(--text-muted); margin-left: 3px; }
        .form-input { width: 100%; padding: .7rem 1rem; border: 1.5px solid var(--border); border-radius: 10px; font-size: .88rem; font-family:'Plus Jakarta Sans', sans-serif; background: var(--warm-white); color: var(--text-dark); outline: none; transition: border-color .2s, box-shadow .2s; }
        .form-input:focus { border-color: var(--brown-accent); box-shadow: 0 0 0 3px rgba(192,120,80,.12); }
        .form-input.is-invalid { border-color: var(--err); }
        select.form-input { appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%239A7A65' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14L2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right .85rem center; }
        .field-error { font-size: .74rem; color: var(--err); margin-top: .3rem; }
        .field-note { font-size: .71rem; color: var(--text-muted); margin-top: .25rem; }

        .btn-submit { width: 100%; padding: .9rem; background: linear-gradient(135deg, var(--brown-mid), var(--brown-accent)); color: #fff; border: none; border-radius: 10px; font-size: .95rem; font-weight: 700; font-family:'Plus Jakarta Sans', sans-serif; cursor: pointer; margin-top: 1.25rem; box-shadow: 0 5px 16px rgba(123,79,58,.28); transition: all .2s; }
        .btn-submit:hover { background: linear-gradient(135deg, var(--brown-accent), #D4906A); transform: translateY(-1px); }

        .logout-link { text-align: center; margin-top: 1rem; font-size: .78rem; color: var(--text-muted); }

        @media (max-width: 540px) { .form-row, .form-row-3 { grid-template-columns: 1fr; } }
</style>
</head>
<body>

<!-- TOP BANNER -->
<div class="top-banner">
    <div class="top-banner-left">
        <a href="{{ route('login') }}" class="btn-back-login">&#8592; Back to Login</a>
        <div class="top-banner-brand">Bake<span>Sphere</span></div>
    </div>

</div>

<!-- PROGRESS STEPS -->
<div class="progress-wrap">
    <div class="step done">
        <div class="step-num">&#10003;</div>
        <span>Google Sign-Up</span>
    </div>
    <div class="step-line"></div>
    <div class="step active">
        <div class="step-num">2</div>
        <span>Complete Profile</span>
    </div>
    <div class="step-line"></div>
    <div class="step">
        <div class="step-num">3</div>
        <span>Start Ordering</span>
    </div>
</div>

<div class="page-body">
<div class="card">

    <div class="brand">
        <div class="brand-name">Bake<span>Sphere</span></div>
        <div class="brand-sub">One last step before you start ordering 🎂</div>
    </div>

    <div class="avatar-wrap">
        @if($user->profile_photo)
            <img src="{{ $user->profile_photo }}" class="avatar" alt="Profile">
        @else
            <div class="avatar-placeholder">{{ strtoupper(substr($user->first_name, 0, 1)) }}</div>
        @endif
        <div>
            <div class="avatar-name">{{ $user->first_name }} {{ $user->last_name }}</div>
            <div class="avatar-email">{{ $user->email }}</div>
        </div>
        <span class="locked-badge">✓ From Google</span>
    </div>

    <div class="prefill-notice">
        ℹ️ <span>Your name and email were filled in from Google. Please complete the remaining details below to finish your customer profile.</span>
    </div>

    @if($errors->any())
        <div style="background:#FDF0EE;border:1px solid #F5C5BE;border-radius:9px;padding:.75rem 1rem;margin-bottom:1rem;font-size:.82rem;color:#8B2A1E;">
            ✕ {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('customer.complete-profile.store') }}">
        @csrf

        {{-- PERSONAL --}}
        <div class="section-label">👤 Personal Details</div>

        <div class="form-row">
            <div class="form-group">
                <label class="form-label">Middle Name <span class="hint">(optional)</span></label>
                <input type="text" name="middle_name" class="form-input" value="{{ old('middle_name') }}" placeholder="Santos">
            </div>
            <div class="form-group">
                <label class="form-label">Suffix <span class="hint">(optional)</span></label>
                <select name="suffix" class="form-input">
                    <option value="">— None —</option>
                    <option value="Jr." {{ old('suffix')=='Jr.'?'selected':'' }}>Jr.</option>
                    <option value="Sr." {{ old('suffix')=='Sr.'?'selected':'' }}>Sr.</option>
                    <option value="II"  {{ old('suffix')=='II' ?'selected':'' }}>II</option>
                    <option value="III" {{ old('suffix')=='III'?'selected':'' }}>III</option>
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label class="form-label">Phone Number <span class="req">*</span> <span class="hint">(11 digits)</span></label>
                <input type="text" name="phone" id="phone" class="form-input"
                       placeholder="09XXXXXXXXX" maxlength="11" inputmode="numeric"
                       value="{{ old('phone') }}" required>
                <div class="field-error" id="phone_err" style="display:none;"></div>
                @error('phone') <div class="field-error">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label class="form-label">Birthdate <span class="req">*</span></label>
                <input type="date" name="birthdate" class="form-input"
                       value="{{ old('birthdate') }}" required>
                <div class="field-note">Must be 18 years old or older.</div>
                @error('birthdate') <div class="field-error">{{ $message }}</div> @enderror
            </div>
        </div>

        {{-- DELIVERY ADDRESS --}}
        <div class="section-label">📍 Delivery Address</div>

     <div class="form-group">
            <label class="form-label">Street / House No. / Barangay <span class="req">*</span></label>
            <input type="text" name="address_line" class="form-input"
                   value="{{ old('address_line') }}"
                   placeholder="123 Sampaguita St., Brgy. Poblacion" required>
            @error('address_line') <div class="field-error">{{ $message }}</div> @enderror
        </div>

        <div class="form-row-3">
            <div class="form-group" style="position:relative;">
                <label class="form-label">Province <span class="req">*</span></label>
                <div class="combo-wrap" id="cp-province-wrap">
                    <input type="text" id="cp-province-display" class="form-input"
                        placeholder="Type province..." autocomplete="off" required>
                    <input type="hidden" name="province" id="cp-province-val" value="{{ old('province') }}">
                    <div class="combo-dropdown" id="cp-province-drop"></div>
                </div>
                @error('province') <div class="field-error">{{ $message }}</div> @enderror
            </div>
            <div class="form-group" style="position:relative;">
                <label class="form-label">City / Municipality <span class="req">*</span></label>
                <div class="combo-wrap" id="cp-city-wrap">
                    <input type="text" id="cp-city-display" class="form-input"
                        placeholder="Select province first..." autocomplete="off" required>
                    <input type="hidden" name="city" id="cp-city-val" value="{{ old('city') }}">
                    <div class="combo-dropdown" id="cp-city-drop"></div>
                </div>
                @error('city') <div class="field-error">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label class="form-label">ZIP Code <span class="req">*</span></label>
                <input type="text" name="zip" id="zip" class="form-input"
                       value="{{ old('zip') }}" placeholder="4110"
                       maxlength="4" inputmode="numeric" required>
                @error('zip') <div class="field-error">{{ $message }}</div> @enderror
            </div>
        </div>
        <button type="submit" class="btn-submit">🛍️ Complete Profile &amp; Start Ordering</button>
    </form>

    <div class="logout-link">
        Wrong account?
        <form method="POST" action="{{ route('logout') }}" style="display:inline;">
            @csrf
            <button type="submit" style="background:none;border:none;cursor:pointer;color:var(--brown-accent);font-weight:600;font-size:.78rem;font-family:'Plus Jakarta Sans',sans-serif;">Sign out</button>
        </form>
    </div>

</div>
</div>
<script>
    // Phone
    const phone = document.getElementById('phone');
    const phoneErr = document.getElementById('phone_err');
    phone.addEventListener('input', function() { this.value = this.value.replace(/\D/g,'').slice(0,11); });
    phone.addEventListener('blur', function() {
        if (this.value.length > 0 && this.value.length !== 11) {
            phoneErr.textContent = 'Must be exactly 11 digits (e.g. 09XXXXXXXXX).';
            phoneErr.style.display = 'block'; this.classList.add('is-invalid');
        } else { phoneErr.style.display = 'none'; this.classList.remove('is-invalid'); }
    });

    // ZIP
    const zip = document.getElementById('zip');
    if (zip) zip.addEventListener('input', function() { this.value = this.value.replace(/\D/g,'').slice(0,4); });

    // Birthdate — 18+
    const bd = document.querySelector('input[name="birthdate"]');
    if (bd) {
        const today = new Date();
        const max = new Date(today.getFullYear()-18, today.getMonth(), today.getDate());
        bd.setAttribute('max', max.toISOString().split('T')[0]);
        bd.addEventListener('change', function() {
            if (new Date(this.value) > max) this.classList.add('is-invalid');
            else this.classList.remove('is-invalid');
        });
    }
    /* ══ PHILIPPINES PROVINCE → CITY COMBOBOX ══ */
    const PH_DATA = {
      "Metro Manila": ["Caloocan","Las Piñas","Makati","Malabon","Mandaluyong","Manila","Marikina","Muntinlupa","Navotas","Parañaque","Pasay","Pasig","Pateros","Quezon City","San Juan","Taguig","Valenzuela"],
      "Cavite": ["Alfonso","Amadeo","Bacoor","Carmona","Dasmariñas","General Emilio Aguinaldo","General Mariano Alvarez","General Trias","Imus","Indang","Kawit","Magallanes","Maragondon","Mendez","Naic","Noveleta","Rosario","Silang","Tagaytay","Tanza","Ternate","Trece Martires"],
      "Laguna": ["Alaminos","Bay","Biñan","Cabuyao","Calamba","Calauan","Cavinti","Famy","Kalayaan","Liliw","Los Baños","Luisiana","Lumban","Mabitac","Magdalena","Majayjay","Nagcarlan","Paete","Pagsanjan","Pakil","Pangil","Pila","Rizal","San Pablo","San Pedro","Santa Cruz","Santa Maria","Santo Tomas","Siniloan","Victoria"],
      "Batangas": ["Agoncillo","Alitagtag","Balayan","Balete","Batangas City","Bauan","Calaca","Calatagan","Cuenca","Ibaan","Laurel","Lemery","Lian","Lipa","Lobo","Mabini","Malvar","Mataasnakahoy","Nasugbu","Padre Garcia","Rosario","San Jose","San Juan","San Luis","San Nicolas","San Pascual","Santa Teresita","Santo Tomas","Taal","Talisay","Taysan","Tingloy","Tuy"],
      "Rizal": ["Angono","Antipolo","Baras","Binangonan","Cainta","Cardona","Jala-Jala","Morong","Pililla","Rodriguez","San Mateo","Tanay","Taytay","Teresa"],
      "Bulacan": ["Angat","Balagtas","Baliuag","Bocaue","Bulakan","Bustos","Calumpit","Doña Remedios Trinidad","Guiguinto","Hagonoy","Malolos","Marilao","Meycauayan","Norzagaray","Obando","Pandi","Paombong","Plaridel","Pulilan","San Ildefonso","San Jose del Monte","San Miguel","San Rafael","Santa Maria"],
      "Pampanga": ["Angeles","Apalit","Arayat","Bacolor","Candaba","Floridablanca","Guagua","Lubao","Mabalacat","Macabebe","Magalang","Masantol","Mexico","Minalin","Porac","San Fernando","San Luis","San Simon","Santa Ana","Santa Rita","Santo Tomas","Sasmuan"],
      "Tarlac": ["Anao","Bamban","Camiling","Capas","Concepcion","Gerona","La Paz","Mayantoc","Moncada","Paniqui","Pura","Ramos","San Clemente","San Jose","San Manuel","Santa Ignacia","Tarlac City","Victoria"],
      "Cebu": ["Alcantara","Alcoy","Alegria","Aloguinsan","Argao","Asturias","Badian","Balamban","Bantayan","Barili","Bogo","Boljoon","Borbon","Carmen","Catmon","Cebu City","Compostela","Consolacion","Cordova","Daanbantayan","Dalaguete","Danao","Dumanjug","Ginatilan","Lapu-Lapu","Liloan","Madridejos","Malabuyoc","Mandaue","Medellin","Minglanilla","Moalboal","Naga","Oslob","Pilar","Pinamungajan","Poro","Ronda","Samboan","San Fernando","San Francisco","San Remigio","Santa Fe","Santander","Sibonga","Sogod","Tabogon","Tabuelan","Talisay","Toledo","Tuburan","Tudela"],
      "Davao del Sur": ["Bansalan","Davao City","Digos","Don Marcelino","Hagonoy","Jose Abad Santos","Kiblawan","Magsaysay","Malalag","Matanao","Padada","Santa Cruz","Sta. Maria","Sulop"],
      "Iloilo": ["Ajuy","Alimodian","Anilao","Badiangan","Balasan","Banate","Barotac Nuevo","Barotac Viejo","Batad","Bingawan","Cabatuan","Calinog","Carles","Concepcion","Dingle","Dueñas","Dumangas","Estancia","Guimbal","Igbaras","Iloilo City","Janiuay","Lambunao","Leganes","Lemery","Leon","Maasin","Miagao","Mina","New Lucena","Oton","Passi","Pavia","Pototan","San Dionisio","San Enrique","San Joaquin","San Miguel","San Rafael","Santa Barbara","Sara","Tigbauan","Tubungan","Zarraga"],
      "Negros Occidental": ["Bacolod","Bago","Binalbagan","Cadiz","Calatrava","Candoni","Cauayan","Enrique B. Magalona","Escalante","Himamaylan","Hinigaran","Hinoba-an","Ilog","Isabela","Kabankalan","La Carlota","La Castellana","Manapla","Moises Padilla","Murcia","Pontevedra","Pulupandan","Sagay","San Carlos","San Enrique","Silay","Sipalay","Talisay","Toboso","Valladolid","Victorias"],
      "Cagayan de Oro": ["Cagayan de Oro"],
      "Zamboanga del Sur": ["Aurora","Bayog","Dimataling","Dinas","Dumalinao","Dumingag","Guipos","Josefina","Kumalarang","Labangan","Lakewood","Lapuyan","Mahayag","Margosatubig","Midsalip","Molave","Pagadian","Pitogo","Ramon Magsaysay","San Miguel","San Pablo","Tabina","Tambulig","Tukuran","Vincenzo A. Sagun","Zamboanga City"],
      "Pangasinan": ["Agno","Aguilar","Alaminos","Alcala","Anda","Asingan","Balungao","Bani","Basista","Bautista","Bayambang","Binalonan","Binmaley","Bolinao","Bugallon","Burgos","Calasiao","Dagupan","Dasol","Infanta","Labrador","Laoac","Lingayen","Mabini","Malasiqui","Manaoag","Mangaldan","Mangatarem","Mapandan","Moncada","Natividad","Pozorrubio","Rosales","San Carlos","San Fabian","San Jacinto","San Manuel","San Nicolas","San Quintin","Santa Barbara","Santa Maria","Santo Tomas","Sison","Sual","Tayug","Umingan","Urbiztondo","Urdaneta","Villasis"],
      "Isabela": ["Alicia","Angadanan","Aurora","Benito Soliven","Burgos","Cabagan","Cabatuan","Cauayan","Cordon","Dinapigue","Divilacan","Echague","Gamu","Ilagan","Jones","Luna","Maconacon","Mallig","Naguilian","Palanan","Quezon","Quirino","Ramon","Reina Mercedes","Roxas","San Agustin","San Guillermo","San Isidro","San Manuel","San Mariano","San Mateo","San Pablo","Santa Maria","Santiago","Santo Tomas","Tumauini"],
      "Nueva Ecija": ["Aliaga","Bongabon","Cabanatuan","Cabiao","Carranglan","Cuyapo","Gabaldon","General Mamerto Natividad","General Tinio","Guimba","Jaen","Laur","Licab","Llanera","Lupao","Muñoz","Nampicuan","Palayan","Pantabangan","Peñaranda","Quezon","Rizal","San Antonio","San Isidro","San Jose","San Leonardo","Santa Rosa","Santo Domingo","Talavera","Talugtug","Zaragoza"],
      "Albay": ["Bacacay","Camalig","Daraga","Guinobatan","Jovellar","Legazpi","Libon","Ligao","Malilipot","Malinao","Manito","Oas","Pio Duran","Polangui","Rapu-Rapu","Santo Domingo","Tabaco","Tiwi"],
      "Quezon": ["Agdangan","Alabat","Atimonan","Buenavista","Burdeos","Calauag","Candelaria","Catanauan","Dolores","General Luna","General Nakar","Guinayangan","Gumaca","Infanta","Jomalig","Lopez","Lucban","Lucena","Macalelon","Mauban","Mulanay","Padre Burgos","Pagbilao","Panukulan","Patnanungan","Perez","Pitogo","Plaridel","Polillo","Quezon","Real","Sampaloc","San Andres","San Antonio","San Francisco","San Narciso","Sariaya","Tagkawayan","Tayabas","Tiaong","Unson"],
      "Camarines Sur": ["Baao","Balatan","Bato","Bombon","Buhi","Bula","Cabusao","Calabanga","Camaligan","Canaman","Caramoan","Del Gallego","Gainza","Garchitorena","Goa","Iriga","Lagonoy","Libmanan","Lupi","Magarao","Milaor","Minalabac","Nabua","Naga","Ocampo","Pamplona","Pasacao","Pili","Presentacion","Ragay","Sagñay","San Fernando","San Jose","Sipocot","Siruma","Tigaon","Tinambac"],
      "Leyte": ["Abuyog","Alangalang","Albuera","Babatngon","Barugo","Bato","Baybay","Burauen","Calubian","Capoocan","Carigara","Dagami","Dulag","Hilongos","Hindang","Inopacan","Isabel","Jaro","Javier","Julita","Kananga","La Paz","Leyte","MacArthur","Mahaplag","Matag-ob","Matalom","Mayorga","Merida","Ormoc","Palo","Palompon","Pastrana","San Isidro","San Miguel","Santa Fe","Tabango","Tabontabon","Tacloban","Tanauan","Tolosa","Tunga","Villaba"],
      "South Cotabato": ["Banga","General Santos","Koronadal","Lake Sebu","Norala","Polomolok","Santo Niño","Surallah","T'boli","Tampakan","Tantangan","Tupi"],
      "Misamis Oriental": ["Alubijid","Balingasag","Balingoan","Binuangan","Cagayan de Oro","Claveria","El Salvador","Gingoog","Gitagum","Initao","Jasaan","Kinoguitan","Lagonglong","Laguindingan","Libertad","Lugait","Magsaysay","Manticao","Medina","Naawan","Opol","Salay","Sugbongcogon","Tagoloan","Talisayan","Villanueva"],
      "Bukidnon": ["Baungon","Cabanglasan","Damulog","Dangcagan","Don Carlos","Impasugong","Kadingilan","Kalilangan","Kibawe","Kitaotao","Lantapan","Libona","Malaybalay","Malitbog","Manolo Fortich","Maramag","Pangantucan","Quezon","San Fernando","Sumilao","Talakag","Valencia"],
      "Benguet": ["Atok","Baguio","Bakun","Bokod","Buguias","Itogon","Kabayan","Kapangan","Kibungan","La Trinidad","Mankayan","Sablan","Tuba","Tublay"],
      "Mountain Province": ["Barlig","Bauko","Besao","Bontoc","Natonin","Paracelis","Sabangan","Sadanga","Sagada","Tadian"],
      "Ifugao": ["Aguinaldo","Alfonso Lista","Asipulo","Banaue","Hingyon","Hungduan","Kiangan","Lagawe","Lamut","Mayoyao","Tinoc"],
      "Kalinga": ["Balbalan","Lubuagan","Pasil","Pinukpuk","Rizal","Tabuk","Tanudan","Tinglayan"],
      "Apayao": ["Calanasan","Conner","Flora","Kabugao","Luna","Pudtol","Santa Marcela"],
      "Abra": ["Bangued","Boliney","Bucay","Bucloc","Daguioman","Danglas","Dolores","La Paz","Lacub","Lagangilang","Lagayan","Langiden","Licuan-Baay","Luba","Malibcong","Manabo","Peñarrubia","Pidigan","Pilar","Sallapadan","San Isidro","San Juan","San Quintin","Tayum","Tineg","Tubo","Villaviciosa"],
      "Ilocos Norte": ["Adams","Bacarra","Badoc","Bangui","Banna","Batac","Burgos","Carasi","Currimao","Dingras","Dumalneg","Laoag","Marcos","Nueva Era","Pagudpud","Paoay","Pasuquin","Piddig","Pinili","San Nicolas","Sarrat","Solsona","Vintar"],
      "Ilocos Sur": ["Alilem","Banayoyo","Bantay","Burgos","Cabugao","Caoayan","Cervantes","Galimuyod","Gregorio del Pilar","Lidlidda","Magsingal","Nagbukel","Narvacan","Quirino","Salcedo","San Emilio","San Esteban","San Ildefonso","San Juan","San Vicente","Santa","Santa Catalina","Santa Cruz","Santa Lucia","Santa Maria","Santiago","Santo Domingo","Sigay","Sinait","Sugpon","Suyo","Tagudin","Vigan"],
      "La Union": ["Agoo","Aringay","Bacnotan","Bagulin","Balaoan","Bangar","Bauang","Burgos","Caba","Luna","Naguilian","Pugo","Rosario","San Fernando","San Gabriel","San Juan","Santo Tomas","Santol","Sudipen","Tubao"],
      "Cagayan": ["Abulug","Alcala","Allacapan","Amulung","Aparri","Baggao","Ballesteros","Buguey","Calayan","Camalaniugan","Claveria","Enrile","Gattaran","Gonzaga","Iguig","Lal-lo","Lasam","Pamplona","Peñablanca","Piat","Rizal","Sanchez-Mira","Santa Ana","Santa Praxedes","Santa Teresita","Santo Niño","Solana","Tuao","Tuguegarao"],
      "Quirino": ["Aglipay","Cabarroguis","Diffun","Maddela","Nagtipunan","Saguday"],
      "Nueva Vizcaya": ["Alfonso Castañeda","Ambaguio","Aritao","Bagabag","Bambang","Bayombong","Diadi","Dupax del Norte","Dupax del Sur","Kasibu","Kayapa","Quezon","Santa Fe","Solano","Villaverde"],
      "Aurora": ["Baler","Casiguran","Dilasag","Dinalungan","Dingalan","Dipaculao","Maria Aurora","San Luis"],
      "Bataan": ["Abucay","Bagac","Balanga","Dinalupihan","Hermosa","Limay","Mariveles","Morong","Orani","Orion","Pilar","Samal"],
      "Zambales": ["Botolan","Cabangan","Candelaria","Castillejos","Iba","Masinloc","Olongapo","Palauig","San Antonio","San Felipe","San Marcelino","San Narciso","Santa Cruz","Subic"],
      "Batanes": ["Basco","Itbayat","Ivana","Mahatao","Sabtang","Uyugan"],
      "Marinduque": ["Boac","Buenavista","Gasan","Mogpog","Santa Cruz","Torrijos"],
      "Occidental Mindoro": ["Abra de Ilog","Calintaan","Looc","Lubang","Magsaysay","Mamburao","Paluan","Rizal","Sablayan","San Jose","Santa Cruz"],
      "Oriental Mindoro": ["Baco","Bansud","Bongabong","Bulalacao","Calapan","Gloria","Mansalay","Naujan","Pinamalayan","Pola","Puerto Galera","Roxas","San Teodoro","Socorro","Victoria"],
      "Romblon": ["Alcantara","Banton","Cajidiocan","Calatrava","Concepcion","Corcuera","Ferrol","Looc","Magdiwang","Odiongan","Romblon","San Agustin","San Andres","San Fernando","San Jose","Santa Fe","Santa Maria"],
      "Palawan": ["Aborlan","Agutaya","Araceli","Balabac","Bataraza","Brooke's Point","Busuanga","Cagayancillo","Coron","Culion","Cuyo","Dumaran","El Nido","Espanola","Kalayaan","Linapacan","Magsaysay","Narra","Puerto Princesa","Quezon","Rizal","Roxas","San Vicente","Sofronio Española","Taytay"],
      "Sorsogon": ["Barcelona","Bulan","Bulusan","Casiguran","Castilla","Donsol","Gubat","Irosin","Juban","Magallanes","Matnog","Pilar","Prieto Diaz","Santa Magdalena","Sorsogon City"],
      "Masbate": ["Aroroy","Baleno","Balud","Batuan","Cataingan","Cawayan","Claveria","Dimasalang","Esperanza","Mandaon","Masbate City","Milagros","Mobo","Monreal","Palanas","Pio V. Corpuz","Placer","San Fernando","San Jacinto","San Pascual","Uson"],
      "Biliran": ["Almeria","Biliran","Cabucgayan","Caibiran","Culaba","Kawayan","Maripipi","Naval"],
      "Eastern Samar": ["Arteche","Balangiga","Balangkayan","Borongan","Can-avid","Dolores","General MacArthur","Giporlos","Guiuan","Hernani","Jipapad","Lawaan","Llorente","Maslog","Maydolong","Mercedes","Oras","Quinapondan","Salcedo","San Julian","San Policarpo","Sulat","Taft"],
      "Northern Samar": ["Allen","Biri","Bobon","Capul","Catarman","Catubig","Gamay","Lapinig","Las Navas","Lavezares","Lope de Vega","Mapanas","Mondragon","Palapag","Pambujan","Rosario","San Antonio","San Isidro","San Jose","San Roque","San Vicente","Silvino Lobos","Victoria"],
      "Western Samar": ["Almagro","Basey","Calbayog","Calbiga","Catbalogan","Daram","Gandara","Hinabangan","Jiabong","Marabut","Matuguinao","Motiong","Pagsanghan","Paranas","Pinabacdao","San Jorge","San Jose de Buan","San Sebastian","Santa Margarita","Santa Rita","Santo Niño","Tagapul-an","Talalora","Tarangnan","Villareal","Zumarraga"],
      "Surigao del Norte": ["Alegria","Bacuag","Burgos","Claver","Dapa","Del Carmen","General Luna","Gigaquit","Mainit","Malimono","Pilar","Placer","San Benito","San Francisco","San Isidro","Santa Monica","Sison","Socorro","Surigao City","Tagana-an","Tubod"],
      "Surigao del Sur": ["Barobo","Bayabas","Bislig","Cagwait","Cantilan","Carmen","Carrascal","Cortes","Hinatuan","Lanuza","Lianga","Lingig","Madrid","Marihatag","San Agustin","San Miguel","Tagbina","Tago","Tandag"],
      "Agusan del Norte": ["Buenavista","Butuan","Cabadbaran","Carmen","Jabonga","Kitcharao","Las Nieves","Magallanes","Nasipit","Remedios T. Romualdez","Santiago","Tubay"],
      "Agusan del Sur": ["Bayugan","Bunawan","Esperanza","La Paz","Loreto","Prosperidad","Rosario","San Francisco","San Luis","Santa Josefa","Sibagat","Talacogon","Trento","Veruela"],
      "Misamis Occidental": ["Aloran","Baliangao","Bonifacio","Calamba","Clarin","Concepcion","Don Victoriano Chiongbian","Jimenez","Lopez Jaena","Oroquieta","Ozamiz","Panaon","Plaridel","Sapang Dalaga","Sinacaban","Tangub","Tudela"],
      "Lanao del Norte": ["Bacolod","Baloi","Baroy","Iligan","Kapatagan","Kauswagan","Kolambugan","Lala","Linamon","Magsaysay","Maigo","Matungao","Munai","Nunungan","Pantao Ragat","Pantar","Poona Piagapo","Salvador","Sapad","Sultan Naga Dimaporo","Tagoloan","Tangkal","Tubod"],
      "Zamboanga del Norte": ["Baliguian","Dapitan","Dipolog","Godod","Gutalac","Jose Dalman","Kalawit","Katipunan","La Libertad","Labason","Leon B. Postigo","Liloy","Manukan","Mutia","Piñan","Polanco","President Manuel A. Roxas","Rizal","Roxas","Salug","Sergio Osmeña Sr.","Siayan","Sibuco","Sibutad","Sindangan","Siocon","Sirawai","Tampilisan"],
      "Compostela Valley": ["Compostela","Laak","Mabini","Maco","Maragusan","Mawab","Monkayo","Montevista","Nabunturan","New Bataan","Pantukan"],
      "Davao del Norte": ["Asuncion","Braulio E. Dujali","Carmen","Kapalong","New Corella","Panabo","San Isidro","Santo Tomas","Tagum","Talaingod"],
      "Davao Oriental": ["Baganga","Banaybanay","Boston","Caraga","Cateel","Governor Generoso","Lupon","Manay","Mati","San Isidro","Tarragona"],
      "North Cotabato": ["Alamada","Aleosan","Arakan","Banisilan","Carmen","Cotabato City","Kabacan","Kidapawan","Libungan","Magpet","Makilala","Matalam","Midsayap","M'lang","Pigkawayan","Pikit","President Roxas","Tulunan"],
      "Sultan Kudarat": ["Bagumbayan","Columbio","Esperanza","Isulan","Kalamansig","Lebak","Lutayan","Lambayong","Palimbang","President Quirino","Senator Ninoy Aquino","Tacurong"],
      "Sarangani": ["Alabel","Glan","Kiamba","Maasim","Maitum","Malapatan","Malungon"],
      "Maguindanao": ["Ampatuan","Barira","Buldon","Buluan","Cotabato City","Datu Abdullah Sangki","Datu Anggal Midtimbang","Datu Blah T. Sinsuat","Datu Hoffer Ampatuan","Datu Montawal","Datu Odin Sinsuat","Datu Paglas","Datu Piang","Datu Salibo","Datu Saudi-Ampatuan","Datu Unsay","General Salipada K. Pendatun","Guindulungan","Kabuntalan","Mangudadatu","Mamasapano","Northern Kabuntalan","Pagalungan","Paglat","Pandag","Parang","Rajah Buayan","Shariff Aguak","Shariff Saydona Mustapha","South Upi","Sultan Kudarat","Sultan Mastura","Sultan sa Barongis","Talayan","Talitay","Upi"],
      "Lanao del Sur": ["Bacolod-Kalawi","Balabagan","Balindong","Bayang","Binidayan","Buadiposo-Buntong","Bubong","Bumbaran","Butig","Calanogas","Ditsaan-Ramain","Ganassi","Kapai","Kapatagan","Lumba-Bayabao","Lumbaca-Unayan","Lumbatan","Lumbayanague","Madalum","Madamba","Maguing","Malabang","Marantao","Marawi","Marogong","Masiu","Mulondo","Pagayawan","Piagapo","Picong","Poona Bayabao","Pualas","Saguiaran","Sultan Dumalondong","Tagoloan II","Tamparan","Taraka","Tubaran","Tugaya","Wao"],
      "Basilan": ["Akbar","Al-Barka","Hadji Mohammad Ajul","Hadji Muhtamad","Isabela","Lamitan","Lantawan","Maluso","Sumisip","Tabuan-Lasa","Tipo-Tipo","Tuburan","Ungkaya Pukan"],
      "Sulu": ["Hadji Panglima Tahil","Indanan","Jolo","Kalingalan Caluang","Lugus","Luuk","Maimbung","Old Panamao","Omar","Pandami","Panglima Estino","Pangutaran","Parang","Pata","Patikul","Talipao","Tapul","Tongkil"],
      "Tawi-Tawi": ["Bongao","Languyan","Mapun","Panglima Sugala","Sapa-Sapa","Sibutu","Simunul","Sitangkai","South Ubian","Tandubas","Turtle Islands"]
    };

    function makeCombo(provinceDisplayId, provinceValId, provinceDropId, cityDisplayId, cityValId, cityDropId, oldProvince, oldCity) {
        const provDisplay = document.getElementById(provinceDisplayId);
        const provVal     = document.getElementById(provinceValId);
        const provDrop    = document.getElementById(provinceDropId);
        const cityDisplay = document.getElementById(cityDisplayId);
        const cityVal     = document.getElementById(cityValId);
        const cityDrop    = document.getElementById(cityDropId);

        const provinces = Object.keys(PH_DATA).sort();

        function renderDrop(drop, items, onSelect) {
            drop.innerHTML = '';
            if (!items.length) {
                drop.innerHTML = '<div class="combo-option no-result">No results found</div>';
            } else {
                items.forEach(function(item) {
                    const d = document.createElement('div');
                    d.className = 'combo-option';
                    d.textContent = item;
                    d.addEventListener('mousedown', function(e) { e.preventDefault(); onSelect(item); });
                    drop.appendChild(d);
                });
            }
            drop.classList.add('open');
        }

        function closeAll() { provDrop.classList.remove('open'); cityDrop.classList.remove('open'); }

        // Province input
        provDisplay.addEventListener('focus', function() {
            const q = this.value.trim().toLowerCase();
            const filtered = provinces.filter(p => p.toLowerCase().includes(q));
            renderDrop(provDrop, filtered, function(val) {
                provDisplay.value = val; provVal.value = val;
                provDrop.classList.remove('open');
                cityDisplay.value = ''; cityVal.value = '';
                cityDisplay.placeholder = 'Type city...';
            });
        });
        provDisplay.addEventListener('input', function() {
            const q = this.value.trim().toLowerCase();
            provVal.value = '';
            const filtered = provinces.filter(p => p.toLowerCase().includes(q));
            renderDrop(provDrop, filtered, function(val) {
                provDisplay.value = val; provVal.value = val;
                provDrop.classList.remove('open');
                cityDisplay.value = ''; cityVal.value = '';
                cityDisplay.placeholder = 'Type city...';
            });
        });

        // City input
        cityDisplay.addEventListener('focus', function() {
            const prov = provVal.value;
            if (!prov) { cityDrop.classList.remove('open'); return; }
            const cities = (PH_DATA[prov] || []).slice().sort();
            const q = this.value.trim().toLowerCase();
            const filtered = cities.filter(c => c.toLowerCase().includes(q));
            renderDrop(cityDrop, filtered, function(val) {
                cityDisplay.value = val; cityVal.value = val;
                cityDrop.classList.remove('open');
            });
        });
        cityDisplay.addEventListener('input', function() {
            const prov = provVal.value;
            if (!prov) return;
            const cities = (PH_DATA[prov] || []).slice().sort();
            const q = this.value.trim().toLowerCase();
            const filtered = cities.filter(c => c.toLowerCase().includes(q));
            renderDrop(cityDrop, filtered, function(val) {
                cityDisplay.value = val; cityVal.value = val;
                cityDrop.classList.remove('open');
            });
        });

        // Close on outside click
        document.addEventListener('mousedown', function(e) {
            if (!provDrop.contains(e.target) && e.target !== provDisplay) provDrop.classList.remove('open');
            if (!cityDrop.contains(e.target) && e.target !== cityDisplay) cityDrop.classList.remove('open');
        });

        // Restore old values on validation fail
        if (oldProvince) { provDisplay.value = oldProvince; provVal.value = oldProvince; cityDisplay.placeholder = 'Type city...'; }
        if (oldCity)     { cityDisplay.value = oldCity;     cityVal.value = oldCity; }
    }
        makeCombo('cp-province-display','cp-province-val','cp-province-drop','cp-city-display','cp-city-val','cp-city-drop','{{ old("province") }}','{{ old("city") }}');

</script>
</body>
</html>