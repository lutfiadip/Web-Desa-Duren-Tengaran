@extends('layouts.app')

@section('title', 'Hubungi Kami - Pemerintah Desa Duren')

@section('styles')
<style>
    /* --- HERO HEADER --- */
    .contact-hero {
        background: linear-gradient(180deg, rgba(30, 58, 138, 0.9) 0%, rgba(30, 58, 138, 0.7) 100%),
                    url('{{ $profile && $profile->hero_bg_image ? asset($profile->hero_bg_image) : "" }}') center/cover no-repeat;
        padding: 160px 5% 100px;
        text-align: center;
        color: var(--white);
        position: relative;
    }
    
    .contact-hero h1 {
        font-size: 3rem;
        font-weight: 800;
        margin-bottom: 15px;
        letter-spacing: -1px;
        line-height: 1.2;
    }

    .contact-hero p {
        font-size: 1.1rem;
        color: #e2e8f0;
        max-width: 700px;
        margin: 0 auto;
    }

    /* --- BREADCRUMB --- */
    .breadcrumb {
        position: absolute;
        top: 30px;
        left: 5%;
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.95rem;
        font-weight: 500;
    }
    
    .breadcrumb a {
        color: #cbd5e1;
        text-decoration: none;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }
    
    .breadcrumb a:hover {
        color: var(--white);
    }
    
    .breadcrumb .separator {
        color: #94a3b8;
    }
    
    .breadcrumb .current {
        color: var(--white);
        font-weight: 600;
    }

    /* --- CONTACT LAYOUT --- */
    .contact-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 60px 5% 80px;
        display: grid;
        grid-template-columns: 1fr 1.2fr;
        gap: 40px;
    }

    @media (max-width: 992px) {
        .contact-container {
            grid-template-columns: 1fr;
            max-width: 800px;
        }
    }

    /* --- INFO CARD --- */
    .info-box {
        background: var(--white);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-lg);
        padding: 40px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        height: 100%;
    }

    .info-list {
        display: flex;
        flex-direction: column;
        gap: 25px;
        list-style: none;
        margin-bottom: 30px;
    }

    .info-item {
        display: flex;
        gap: 20px;
        align-items: flex-start;
    }

    .info-icon {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        background-color: #eff6ff;
        color: var(--primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        flex-shrink: 0;
        border: 1px solid rgba(37, 99, 235, 0.1);
    }

    .info-details h4 {
        font-size: 1.05rem;
        font-weight: 800;
        color: var(--text-dark);
        margin-bottom: 5px;
    }

    .info-details p {
        font-size: 0.95rem;
        color: var(--text-muted);
        line-height: 1.6;
    }


</style>
@endsection

@section('content')
    <!-- HERO HEADER -->
    <section class="contact-hero">
        <nav class="breadcrumb">
            <a href="{{ route('home') }}"><i class="fa-solid fa-house" style="font-size: 0.85rem;"></i> Beranda</a>
            <span class="separator">/</span>
            <span class="current">Kontak</span>
        </nav>
        <h1>Hubungi Kami</h1>
        <p>Pemerintah Desa Duren berkomitmen melayani kebutuhan informasi dan administrasi masyarakat. Silakan hubungi kami melalui saluran informasi resmi di bawah ini.</p>
    </section>

    <!-- CONTACT CONTAINER -->
    <div class="contact-container">
        
        <!-- INFO BOX -->
        <div class="info-box">
            <div>
                <h3 style="font-size: 1.4rem; font-weight: 800; color: var(--text-dark); margin-bottom: 25px;">Informasi Kontak Resmi</h3>
                
                <ul class="info-list">
                    @if($profile && $profile->address)
                    <li class="info-item">
                        <div class="info-icon">
                            <i class="fa-solid fa-map-location-dot"></i>
                        </div>
                        <div class="info-details">
                            <h4>Alamat Kantor</h4>
                            <p>{{ $profile->address }}</p>
                        </div>
                    </li>
                    @endif

                    @if($profile && $profile->email)
                    <li class="info-item">
                        <div class="info-icon">
                            <i class="fa-solid fa-envelope"></i>
                        </div>
                        <div class="info-details">
                            <h4>Email Resmi</h4>
                            <p>
                                <a href="mailto:{{ $profile->email }}" style="color: inherit; text-decoration: none; transition: var(--transition);" onmouseover="this.style.color='var(--primary)'" onmouseout="this.style.color='inherit'">
                                    {{ $profile->email }}
                                </a>
                            </p>
                        </div>
                    </li>
                    @endif

                    @if($profile && $profile->phone)
                    <li class="info-item">
                        <div class="info-icon">
                            <i class="fa-solid fa-phone"></i>
                        </div>
                        <div class="info-details">
                            <h4>Telepon / Fax</h4>
                            <p>{{ $profile->phone }}</p>
                        </div>
                    </li>
                    @endif

                    @if($profile && $profile->office_hours)
                    <li class="info-item">
                        <div class="info-icon">
                            <i class="fa-solid fa-clock"></i>
                        </div>
                        <div class="info-details">
                            <h4>Jam Operasional Kantor</h4>
                            <p>{{ $profile->office_hours }}</p>
                        </div>
                    </li>
                    @endif
                </ul>
            </div>

            <!-- MEDIA SOSIAL & WHATSAPP -->
            <div style="margin-top: 0; padding-top: 10px;">
                <h4 style="font-size: 1.05rem; font-weight: 800; color: var(--text-dark); margin-bottom: 15px; text-align: center;">Media Sosial & Chat</h4>
                <div style="display: flex; gap: 15px; justify-content: center; flex-wrap: wrap;">
                    @if($profile && $profile->phone)
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $profile->phone) }}?text=Halo%20Admin%20Desa%20Duren,%20saya%20ingin%20bertanya%20mengenai%20pelayanan%20desa." target="_blank"
                        style="background: #dcf8c6; width: 45px; height: 45px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #25D366; text-decoration: none; transition: var(--transition); border: 1px solid rgba(37, 211, 102, 0.2);"
                        onmouseover="this.style.background='#25D366'; this.style.color='white';" onmouseout="this.style.background='#dcf8c6'; this.style.color='#25D366';" title="Hubungi lewat WhatsApp">
                        <i class="fa-brands fa-whatsapp" style="font-size: 1.4rem;"></i>
                    </a>
                    @endif

                    @if($profile && $profile->facebook && $profile->facebook !== '#')
                    <a href="{{ $profile->getFacebookLink() }}" target="_blank"
                        style="background: #eff6ff; width: 45px; height: 45px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #1877F2; text-decoration: none; transition: var(--transition); border: 1px solid rgba(24, 119, 242, 0.2);"
                        onmouseover="this.style.background='#1877F2'; this.style.color='white';" onmouseout="this.style.background='#eff6ff'; this.style.color='#1877F2';" title="Facebook">
                        <i class="fa-brands fa-facebook-f" style="font-size: 1.2rem;"></i>
                    </a>
                    @endif
                    
                    @if($profile && $profile->instagram && $profile->instagram !== '#')
                    <a href="{{ $profile->getInstagramLink() }}" target="_blank"
                        style="background: #fce7f3; width: 45px; height: 45px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #E1306C; text-decoration: none; transition: var(--transition); border: 1px solid rgba(225, 48, 108, 0.2);"
                        onmouseover="this.style.background='#E1306C'; this.style.color='white';" onmouseout="this.style.background='#fce7f3'; this.style.color='#E1306C';" title="Instagram">
                        <i class="fa-brands fa-instagram" style="font-size: 1.3rem;"></i>
                    </a>
                    @endif
                    
                    @if($profile && $profile->youtube && $profile->youtube !== '#')
                    <a href="{{ $profile->getYoutubeLink() }}" target="_blank"
                        style="background: #fee2e2; width: 45px; height: 45px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #FF0000; text-decoration: none; transition: var(--transition); border: 1px solid rgba(255, 0, 0, 0.2);"
                        onmouseover="this.style.background='#FF0000'; this.style.color='white';" onmouseout="this.style.background='#fee2e2'; this.style.color='#FF0000';" title="YouTube">
                        <i class="fa-brands fa-youtube" style="font-size: 1.2rem;"></i>
                    </a>
                    @endif
                </div>
            </div>
        </div>

        <!-- GOOGLE MAP BOX -->
        @php
            $mapUrl = ($profile && $profile->office_maps_url) ? $profile->office_maps_url : 'https://maps.google.com/maps?q=Kantor%20Kepala%20Desa%20Duren%20Tengaran&t=&z=15&ie=UTF8&iwloc=&output=embed';
            
            // If user pastes an entire iframe code, extract the src
            if (preg_match('/src="([^"]+)"/', $mapUrl, $matches)) {
                $mapUrl = $matches[1];
            } else if (str_contains($mapUrl, '/maps/d/')) {
                $mapUrl = preg_replace('/\/maps\/d\/(?:u\/\d+\/)?(?:edit|viewer)/', '/maps/d/embed', $mapUrl);
            } else if (str_contains($mapUrl, 'maps.google.com/maps') && !str_contains($mapUrl, 'output=embed') && !str_contains($mapUrl, 'maps/embed')) {
                $mapUrl .= (str_contains($mapUrl, '?') ? '&' : '?') . 'output=embed';
            }
        @endphp
        <div class="map-box" style="background: var(--white); border: 1px solid var(--border-color); border-radius: var(--radius-lg); padding: 25px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02); display: flex; flex-direction: column; min-height: 450px;">
            <h3 style="font-size: 1.4rem; font-weight: 800; color: var(--text-dark); margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
                <i class="fa-solid fa-map-location-dot" style="color: var(--primary);"></i> Peta Lokasi Kantor Desa
            </h3>
            <div style="flex-grow: 1; border-radius: var(--radius-md); overflow: hidden; border: 1px solid var(--border-color); position: relative; min-height: 350px; background: #e2e8f0;">
                <iframe src="{{ $mapUrl }}" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: 0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </div>
@endsection
