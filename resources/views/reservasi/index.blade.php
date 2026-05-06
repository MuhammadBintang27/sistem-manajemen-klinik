<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Miss Dentist Meulaboh - Reservasi Online</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,400;1,600&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        :root {
            --rose:        #C8416E;
            --rose-dark:   #A93460;
            --rose-deep:   #8B2750;
            --rose-mid:    #DE7AA4;
            --rose-light:  #F5CEDE;
            --rose-pale:   #FBF0F5;
            --rose-faint:  #FEF8FB;
            --ink:         #1A1118;
            --ink-mid:     #3D2A35;
            --slate:       #7A6872;
            --cream:       #FDFAF8;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--cream);
            color: var(--ink);
            -webkit-font-smoothing: antialiased;
        }

        .font-display {
            font-family: 'Playfair Display', serif;
        }
     

        /* ── Scroll reveal ── */
        .reveal {
            opacity: 0;
            transform: translateY(32px);
            transition: opacity 0.8s cubic-bezier(0.22,1,0.36,1), transform 0.8s cubic-bezier(0.22,1,0.36,1);
        }
        .reveal.visible { opacity: 1; transform: translateY(0); }
        .reveal-delay-1 { transition-delay: 0.1s; }
        .reveal-delay-2 { transition-delay: 0.2s; }
        .reveal-delay-3 { transition-delay: 0.3s; }

        /* ── Navbar ── */
        .navbar {
            position: fixed;
            top: 0; left: 0; right: 0;
            z-index: 100;
            background: rgba(200, 65, 110, 0.97);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(255,255,255,0.12);
        }
        .navbar-inner {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 24px;
            height: 68px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }
        .logo-icon {
            width: 38px; height: 38px;
            background: rgba(255,255,255,0.18);
            border-radius: 12px;
            border: 1px solid rgba(255,255,255,0.25);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .logo-text { color: #fff; }
        .logo-text .name {
            font-family: 'Playfair Display', serif;
            font-size: 18px;
            font-weight: 600;
            letter-spacing: 0.3px;
            line-height: 1;
        }
        .logo-text .sub {
            font-size: 10px;
            font-weight: 400;
            color: rgba(255,255,255,0.65);
            letter-spacing: 1.5px;
            text-transform: uppercase;
            margin-top: 2px;
        }
        .nav-links {
            display: flex;
            align-items: center;
            gap: 36px;
        }
        .nav-links a {
            color: rgba(255,255,255,0.78);
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            letter-spacing: 0.2px;
            transition: color 0.2s;
        }
        .nav-links a:hover { color: #fff; }
        .btn-reservasi {
            background: #fff;
            color: var(--rose-deep) !important;
            padding: 9px 22px;
            border-radius: 100px;
            font-weight: 600 !important;
            font-size: 13.5px !important;
            letter-spacing: 0.2px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.12);
            transition: box-shadow 0.2s, transform 0.2s !important;
        }
        .btn-reservasi:hover {
            box-shadow: 0 4px 20px rgba(0,0,0,0.18) !important;
            transform: translateY(-1px) !important;
        }
        .menu-btn {
            display: none;
            background: none;
            border: none;
            cursor: pointer;
            color: #fff;
            padding: 4px;
        }
        #mobileMenu {
            display: none;
            flex-direction: column;
            padding: 8px 24px 16px;
            border-top: 1px solid rgba(255,255,255,0.12);
            gap: 2px;
        }
        #mobileMenu.open { display: flex; }
        #mobileMenu a {
            display: block;
            padding: 10px 12px;
            color: rgba(255,255,255,0.82);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            border-radius: 8px;
            transition: background 0.15s, color 0.15s;
        }
        #mobileMenu a:hover { background: rgba(255,255,255,0.1); color: #fff; }

        /* ── Hero ── */
        .hero {
            padding-top: 68px;
            min-height: 100vh;
            background: linear-gradient(150deg, #B83068 0%, #C8416E 35%, #D46690 65%, #C04070 100%);
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
        }
        .hero-texture {
            position: absolute;
            inset: 0;
            background-image:
                radial-gradient(ellipse 70% 50% at 75% 35%, rgba(255,200,220,0.15) 0%, transparent 65%),
                radial-gradient(ellipse 40% 60% at 10% 70%, rgba(100,20,60,0.4) 0%, transparent 55%),
                radial-gradient(ellipse 30% 30% at 85% 80%, rgba(180,50,100,0.3) 0%, transparent 50%);
        }
        /* Decorative circle */
        .hero-circle {
            position: absolute;
            top: 50%;
            right: -8%;
            transform: translateY(-50%);
            width: 560px;
            height: 560px;
            border-radius: 50%;
            border: 1px solid rgba(255,255,255,0.08);
            pointer-events: none;
        }
        .hero-circle::before {
            content: '';
            position: absolute;
            inset: 32px;
            border-radius: 50%;
            border: 1px solid rgba(255,255,255,0.06);
        }
        .hero-circle::after {
            content: '';
            position: absolute;
            inset: 64px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(255,255,255,0.04) 0%, transparent 70%);
        }
        /* Bottom wave */
        .hero-wave {
            position: absolute;
            bottom: -2px; left: 0; right: 0;
        }
        .hero-inner {
            max-width: 1200px;
            margin: 0 auto;
            padding: 60px 24px 100px;
            width: 100%;
            position: relative;
            z-index: 2;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: center;
        }
        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(255,255,255,0.12);
            border: 1px solid rgba(255,255,255,0.22);
            color: rgba(255,255,255,0.9);
            font-size: 12.5px;
            font-weight: 500;
            letter-spacing: 0.3px;
            padding: 7px 16px;
            border-radius: 100px;
            margin-bottom: 28px;
        }
        .hero-badge-dot {
            width: 7px; height: 7px;
            border-radius: 50%;
            background: rgba(255,255,255,0.8);
            animation: pulse-dot 2.5s ease-in-out infinite;
        }
        @keyframes pulse-dot {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.4; transform: scale(1.4); }
        }
        .hero-title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(44px, 5.5vw, 72px);
            font-weight: 600;
            color: #fff;
            line-height: 1.08;
            letter-spacing: -0.5px;
            margin-bottom: 20px;
        }
        .hero-title em {
            font-style: italic;
            color: rgba(255,255,255,0.72);
            font-weight: 400;
        }
        .hero-desc {
            color: rgba(255,255,255,0.78);
            font-size: 16px;
            line-height: 1.7;
            max-width: 420px;
            margin-bottom: 36px;
        }
        .hero-cta {
            display: flex;
            gap: 14px;
            flex-wrap: wrap;
        }
        .btn-primary-hero {
            background: #fff;
            color: var(--rose-deep);
            padding: 15px 32px;
            border-radius: 100px;
            font-weight: 600;
            font-size: 15px;
            text-decoration: none;
            box-shadow: 0 8px 32px rgba(0,0,0,0.18);
            transition: transform 0.2s, box-shadow 0.2s;
            white-space: nowrap;
        }
        .btn-primary-hero:hover {
            transform: translateY(-2px);
            box-shadow: 0 14px 40px rgba(0,0,0,0.22);
        }
        .btn-outline-hero {
            border: 1.5px solid rgba(255,255,255,0.45);
            color: #fff;
            padding: 15px 32px;
            border-radius: 100px;
            font-weight: 500;
            font-size: 15px;
            text-decoration: none;
            transition: background 0.2s, border-color 0.2s;
        }
        .btn-outline-hero:hover {
            background: rgba(255,255,255,0.1);
            border-color: rgba(255,255,255,0.7);
        }

        /* Hero right: 2 stat cards */
        .hero-stats {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }
        .hero-stat-card {
            background: rgba(255,255,255,0.12);
            border: 1px solid rgba(255,255,255,0.2);
            backdrop-filter: blur(12px);
            border-radius: 20px;
            padding: 28px 24px;
            color: #fff;
            position: relative;
            overflow: hidden;
        }
        .hero-stat-card::before {
            content: '';
            position: absolute;
            top: -30%;
            right: -20%;
            width: 100px; height: 100px;
            border-radius: 50%;
            background: rgba(255,255,255,0.05);
        }
        .hero-stat-card:nth-child(2) { margin-top: 28px; }
        .hero-stat-card .num {
            font-family: 'Playfair Display', serif;
            font-size: 42px;
            font-weight: 700;
            line-height: 1;
            margin-bottom: 6px;
        }
        .hero-stat-card .label {
            font-size: 12.5px;
            color: rgba(255,255,255,0.65);
            font-weight: 400;
            letter-spacing: 0.2px;
        }
        /* small decorative divider */
        .hero-stat-card .divider {
            width: 28px;
            height: 2px;
            background: rgba(255,255,255,0.35);
            border-radius: 1px;
            margin-bottom: 10px;
        }

        /* ── Section shared ── */
        .section-tag {
            display: inline-block;
            background: var(--rose-pale);
            color: var(--rose);
            font-size: 11.5px;
            font-weight: 600;
            letter-spacing: 1.8px;
            text-transform: uppercase;
            padding: 5px 14px;
            border-radius: 100px;
            border: 1px solid var(--rose-light);
            margin-bottom: 16px;
        }
        .section-title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(32px, 4vw, 50px);
            font-weight: 600;
            color: var(--ink);
            line-height: 1.1;
            letter-spacing: -0.3px;
        }
        .section-sub {
            font-size: 15.5px;
            color: var(--slate);
            line-height: 1.65;
            max-width: 520px;
            margin: 0 auto;
        }

        /* ── Services ── */
        .services-section {
            padding: 96px 24px;
            background: var(--cream);
        }
        .services-inner { max-width: 1200px; margin: 0 auto; }
        .services-header {
            text-align: center;
            margin-bottom: 56px;
        }
        .services-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }
        .service-card {
            background: #fff;
            border: 1px solid rgba(200,65,110,0.1);
            border-radius: 20px;
            padding: 32px 28px;
            position: relative;
            overflow: hidden;
            transition: transform 0.3s cubic-bezier(0.22,1,0.36,1), box-shadow 0.3s, border-color 0.3s;
        }
        .service-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--rose), var(--rose-mid));
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.35s cubic-bezier(0.22,1,0.36,1);
        }
        .service-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 24px 48px rgba(200,65,110,0.1);
            border-color: var(--rose-light);
        }
        .service-card:hover::before { transform: scaleX(1); }
        
        .service-card:hover .service-icon { background: var(--rose-light); }
        .service-card h3 {
            font-family: 'Playfair Display', serif;
            font-size: 20px;
            
            font-weight: 600;
            margin-bottom: 10px;
        }
        .service-card p {
            font-size: 13.5px;
            color: var(--slate);
            line-height: 1.65;
            margin-bottom: 16px;
        }
        .service-price {
            font-size: 13px;
            font-weight: 600;
            color: var(--rose);
            letter-spacing: 0.2px;
        }

        /* ── About ── */
        .about-section {
            padding: 96px 24px;
            background: #fff;
        }
        .about-inner {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 72px;
            align-items: center;
        }
        .about-img-wrap {
            position: relative;
        }
        .about-img-frame {
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 32px 80px rgba(200,65,110,0.12);
            position: relative;
        }
        .about-img-frame img {
            width: 100%;
            height: 420px;
            object-fit: cover;
            display: block;
        }
        .about-img-frame::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, transparent 55%, rgba(140,30,60,0.15) 100%);
        }
        /* decorative shape behind image */
        .about-img-bg {
            position: absolute;
            inset: -20px -20px 20px 20px;
            border-radius: 28px;
            background: var(--rose-pale);
            z-index: -1;
        }
        .about-badge {
            position: absolute;
            bottom: -20px;
            right: -20px;
            background: #fff;
            border: 1px solid var(--rose-light);
            border-radius: 18px;
            padding: 16px 20px;
            box-shadow: 0 8px 32px rgba(200,65,110,0.12);
            display: flex;
            align-items: center;
            gap: 12px;
            z-index: 10;
        }
        .about-badge-icon {
            width: 40px; height: 40px;
            background: var(--rose-pale);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .about-badge-icon svg { color: var(--rose); width: 18px; height: 18px; }
        .about-badge-text .title {
            font-weight: 600;
            font-size: 13px;
            color: var(--ink);
            line-height: 1;
        }
        .about-badge-text .sub {
            font-size: 11px;
            color: var(--slate);
            margin-top: 3px;
        }
        .about-text .section-tag { margin-bottom: 12px; }
        .about-text .section-title { text-align: left; margin-bottom: 18px; }
        .about-desc {
            font-size: 15px;
            color: var(--slate);
            line-height: 1.75;
            margin-bottom: 32px;
        }
        .about-checks {
            display: flex;
            flex-direction: column;
            gap: 18px;
            margin-bottom: 40px;
        }
        .check-item {
            display: flex;
            align-items: flex-start;
            gap: 14px;
        }
        .check-icon {
            width: 34px; height: 34px;
            background: var(--rose-pale);
            border-radius: 10px;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 1px;
        }
        .check-icon svg { color: var(--rose); width: 15px; height: 15px; }
        .check-text .title {
            font-size: 14.5px;
            font-weight: 600;
            color: var(--ink-mid);
            margin-bottom: 3px;
        }
        .check-text .sub {
            font-size: 13px;
            color: var(--slate);
            line-height: 1.55;
        }
        .about-stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
        }
        .stat-box {
            background: var(--rose-faint);
            border: 1px solid var(--rose-light);
            border-radius: 16px;
            padding: 18px 12px;
            text-align: center;
        }
        .stat-num {
            font-family: 'Playfair Display', serif;
            font-size: 28px;
            font-weight: 700;
            background: linear-gradient(135deg, var(--rose), var(--rose-mid));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            line-height: 1;
        }
        .stat-label {
            font-size: 11.5px;
            color: var(--slate);
            margin-top: 5px;
        }

        /* ── Gallery ── */
        .gallery-section {
            padding: 96px 24px;
            background: var(--rose-faint);
        }
        .gallery-inner { max-width: 1200px; margin: 0 auto; }
        .gallery-header {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            margin-bottom: 44px;
            gap: 24px;
        }
        .gallery-header-text .section-title { text-align: left; }
        .gallery-view-all {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 13.5px;
            font-weight: 600;
            color: var(--rose);
            text-decoration: none;
            white-space: nowrap;
            padding-bottom: 2px;
            border-bottom: 1.5px solid var(--rose-light);
            transition: border-color 0.2s, color 0.2s;
            flex-shrink: 0;
        }
        .gallery-view-all:hover { color: var(--rose-dark); border-color: var(--rose); }
        .gallery-view-all svg { width: 14px; height: 14px; transition: transform 0.2s; }
        .gallery-view-all:hover svg { transform: translateX(3px); }

        /* Masonry-ish grid */
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            grid-template-rows: auto auto;
            gap: 14px;
        }
        .gallery-item {
            border-radius: 16px;
            overflow: hidden;
            position: relative;
            background: var(--rose-light);
            cursor: pointer;
        }
        .gallery-item:nth-child(1) {
            grid-column: span 2;
            grid-row: span 2;
        }
        .gallery-item:nth-child(4) {
            grid-column: span 2;
        }
        .gallery-item img {
            width: 100%; height: 100%;
            object-fit: cover;
            display: block;
            transition: transform 0.5s cubic-bezier(0.22,1,0.36,1);
        }
        .gallery-item:nth-child(1) img { min-height: 340px; }
        .gallery-item:not(:nth-child(1)) img { min-height: 160px; }
        .gallery-item:hover img { transform: scale(1.04); }
        /* Overlay */
        .gallery-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, transparent 50%, rgba(100,20,50,0.5) 100%);
            opacity: 0;
            transition: opacity 0.3s;
            display: flex;
            align-items: flex-end;
            padding: 18px;
        }
        .gallery-item:hover .gallery-overlay { opacity: 1; }
        .gallery-overlay-label {
            color: #fff;
            font-size: 13px;
            font-weight: 500;
            letter-spacing: 0.2px;
        }
        /* Placeholder for empty slots */
        .gallery-placeholder {
            border-radius: 16px;
            background: linear-gradient(135deg, var(--rose-pale), var(--rose-light));
            border: 2px dashed var(--rose-light);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 10px;
            min-height: 160px;
            cursor: default;
        }
        .gallery-placeholder svg { color: var(--rose-mid); width: 28px; height: 28px; opacity: 0.6; }
        .gallery-placeholder span {
            font-size: 12px;
            color: var(--rose-mid);
            font-weight: 500;
            opacity: 0.75;
        }

        /* ── Testimonials ── */
        .testimonials-section {
            padding: 96px 24px;
            background: var(--cream);
        }
        .testimonials-inner { max-width: 1200px; margin: 0 auto; }
        .testimonials-header { text-align: center; margin-bottom: 52px; }
        .testimonials-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }
        .testimonial-card {
            background: #fff;
            border: 1px solid rgba(200,65,110,0.1);
            border-radius: 20px;
            padding: 30px 28px;
            position: relative;
            overflow: hidden;
        }
        .testimonial-card::before {
            content: '"';
            position: absolute;
            top: -8px;
            right: 24px;
            font-family: 'Playfair Display', serif;
            font-size: 100px;
            font-style: italic;
            color: var(--rose-pale);
            line-height: 1;
            pointer-events: none;
        }
        .testimonial-stars {
            display: flex;
            gap: 2px;
            margin-bottom: 14px;
        }
        .star {
            width: 14px; height: 14px;
            color: var(--rose);
        }
        .testimonial-text {
            font-size: 14px;
            color: var(--slate);
            line-height: 1.7;
            margin-bottom: 22px;
        }
        .testimonial-author {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .author-avatar {
            width: 38px; height: 38px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--rose), var(--rose-mid));
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Playfair Display', serif;
            font-size: 16px;
            font-weight: 600;
            color: #fff;
            flex-shrink: 0;
        }
        .author-name {
            font-size: 14px;
            font-weight: 600;
            color: var(--ink-mid);
            line-height: 1;
        }
        .author-role {
            font-size: 11.5px;
            color: var(--slate);
            margin-top: 3px;
        }

        /* ── CTA ── */
        .cta-section {
            padding: 96px 24px;
            background: linear-gradient(145deg, var(--rose-dark) 0%, var(--rose) 55%, #D46690 100%);
            position: relative;
            overflow: hidden;
        }
        .cta-bg-circle {
            position: absolute;
            border-radius: 50%;
            pointer-events: none;
        }
        .cta-bg-circle-1 {
            width: 600px; height: 600px;
            top: -200px; right: -150px;
            background: radial-gradient(circle, rgba(255,200,220,0.1) 0%, transparent 65%);
        }
        .cta-bg-circle-2 {
            width: 400px; height: 400px;
            bottom: -150px; left: -80px;
            background: radial-gradient(circle, rgba(80,10,40,0.3) 0%, transparent 60%);
        }
        .cta-inner {
            max-width: 700px;
            margin: 0 auto;
            text-align: center;
            position: relative;
            z-index: 2;
        }
        .cta-tag {
            display: inline-block;
            background: rgba(255,255,255,0.15);
            border: 1px solid rgba(255,255,255,0.25);
            color: rgba(255,255,255,0.9);
            font-size: 11.5px;
            font-weight: 600;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            padding: 6px 16px;
            border-radius: 100px;
            margin-bottom: 24px;
        }
        .cta-title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(36px, 5vw, 60px);
            font-weight: 600;
            color: #fff;
            line-height: 1.1;
            margin-bottom: 18px;
            letter-spacing: -0.3px;
        }
        .cta-desc {
            font-size: 16px;
            color: rgba(255,255,255,0.78);
            line-height: 1.65;
            margin-bottom: 40px;
        }
        .btn-cta {
            display: inline-block;
            background: #fff;
            color: var(--rose-deep);
            padding: 17px 44px;
            border-radius: 100px;
            font-weight: 600;
            font-size: 15.5px;
            text-decoration: none;
            box-shadow: 0 12px 40px rgba(0,0,0,0.18);
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .btn-cta:hover {
            transform: translateY(-2px);
            box-shadow: 0 18px 50px rgba(0,0,0,0.22);
        }
        .cta-note {
            font-size: 13px;
            color: rgba(255,255,255,0.55);
            margin-top: 16px;
        }

        /* ── Contact ── */
        .contact-section {
            padding: 88px 24px;
            background: #14101A;
        }
        .contact-inner { max-width: 1200px; margin: 0 auto; }
        .contact-header { text-align: center; margin-bottom: 48px; }
        .contact-header .section-title { color: #fff; }
        .contact-header .section-sub { color: rgba(255,255,255,0.45); }
        .contact-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 18px;
        }
        .contact-card {
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 20px;
            padding: 32px 24px;
            text-align: center;
            transition: border-color 0.25s, background 0.25s;
        }
        .contact-card:hover {
            border-color: rgba(200,65,110,0.4);
            background: rgba(200,65,110,0.05);
        }
        .contact-icon-wrap {
            width: 52px; height: 52px;
            background: rgba(200,65,110,0.12);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            transition: background 0.25s;
        }
        .contact-card:hover .contact-icon-wrap { background: rgba(200,65,110,0.22); }
        .contact-icon-wrap svg { color: var(--rose-mid); width: 22px; height: 22px; }
        .contact-card-label {
            font-size: 10.5px;
            font-weight: 600;
            letter-spacing: 1.8px;
            text-transform: uppercase;
            color: rgba(255,255,255,0.4);
            margin-bottom: 8px;
        }
        .contact-card-value {
            font-family: 'Playfair Display', serif;
            font-size: 20px;
            font-weight: 500;
            color: rgba(255,255,255,0.9);
            line-height: 1.2;
        }
        .contact-card-sub {
            font-size: 12px;
            color: rgba(255,255,255,0.35);
            margin-top: 6px;
        }

        /* ── Footer ── */
        .footer {
            background: #0D0A12;
            padding: 24px;
            border-top: 1px solid rgba(255,255,255,0.05);
        }
        .footer-inner {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
        }
        .footer-logo {
            display: flex;
            align-items: center;
            gap: 8px;
            color: rgba(255,255,255,0.55);
            font-size: 13px;
        }
        .footer-logo svg { color: var(--rose-mid); width: 16px; height: 16px; }
        .footer-copy {
            font-size: 12px;
            color: rgba(255,255,255,0.3);
        }
        .footer-links {
            display: flex;
            gap: 20px;
        }
        .footer-links a {
            font-size: 12px;
            color: rgba(255,255,255,0.35);
            text-decoration: none;
            transition: color 0.2s;
        }
        .footer-links a:hover { color: rgba(255,255,255,0.65); }

        /* ── Responsive ── */
        @media (max-width: 1024px) {
            .hero-inner { grid-template-columns: 1fr; gap: 48px; }
            .hero-circle { display: none; }
            .hero-stats {
                grid-template-columns: repeat(2, 1fr);
                max-width: 400px;
            }
            .hero-stat-card:nth-child(2) { margin-top: 0; }
            .about-inner { grid-template-columns: 1fr; gap: 56px; }
            .about-img-bg { display: none; }
            .services-grid { grid-template-columns: repeat(2, 1fr); }
            .gallery-grid { grid-template-columns: repeat(2, 1fr); }
            .gallery-item:nth-child(1) { grid-column: span 2; }
            .gallery-item:nth-child(4) { grid-column: span 1; }
        }
        @media (max-width: 768px) {
            .nav-links { display: none; }
            .menu-btn { display: block; }
            .services-grid { grid-template-columns: 1fr; }
            .testimonials-grid { grid-template-columns: 1fr; }
            .contact-grid { grid-template-columns: 1fr; }
            .gallery-grid { grid-template-columns: repeat(2, 1fr); }
            .gallery-item:nth-child(1) { grid-column: span 2; }
            .gallery-item:nth-child(4) { grid-column: span 2; }
            .footer-inner { flex-direction: column; text-align: center; }
            .gallery-header { flex-direction: column; align-items: flex-start; }
        }
        @media (max-width: 500px) {
            .hero-cta { flex-direction: column; }
            .btn-primary-hero, .btn-outline-hero { text-align: center; }
            .about-stats { grid-template-columns: repeat(3, 1fr); }
            .about-badge { right: 0; bottom: -16px; }
        }
    </style>
</head>
<body>

    <!-- ─── Navbar ─── -->
    <nav class="navbar">
        <div class="navbar-inner">
            <a href="#" class="logo">
                <div class="logo-icon">
                    <img src="{{ asset('image/logo.png') }}" alt="Logo" class="w-full h-full object-contain">
                </div>
                <div class="logo-text">
                    <div class="name">Miss Dentist</div>
                    <div class="sub">Meulaboh</div>
                </div>
            </a>

            <nav class="nav-links">
                <a href="#layanan">Layanan</a>
                <a href="#tentang">Tentang</a>
                <a href="#galeri">Galeri</a>
                <a href="#kontak">Kontak</a>
                <a href="{{ route('reservasi.create') }}" class="btn-reservasi">Buat Reservasi</a>
            </nav>

            <button class="menu-btn" onclick="document.getElementById('mobileMenu').classList.toggle('open')" aria-label="Menu">
                <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>
        <div id="mobileMenu">
            <a href="#layanan">Layanan</a>
            <a href="#tentang">Tentang</a>
            <a href="#galeri">Galeri</a>
            <a href="#kontak">Kontak</a>
            <a href="{{ route('reservasi.create') }}" style="color:rgba(255,255,255,0.9);font-weight:600;">Buat Reservasi</a>
        </div>
    </nav>

    <!-- ─── Hero ─── -->
    <section class="hero">
        <div class="hero-texture"></div>
        <div class="hero-circle"></div>
        <div class="hero-inner">
            <!-- Left -->
            <div>
                <div class="hero-badge">
                    <span class="hero-badge-dot"></span>
                    Klinik Terpercaya Sejak 2010
                </div>
                <h1 class="hero-title">
                    Senyum Sehat,<br>
                    <em>Hidup Bahagia</em>
                </h1>
                <p class="hero-desc">
                    Perawatan gigi profesional oleh dokter berpengalaman dengan teknologi modern. Kami hadir untuk memberikan yang terbaik bagi senyum Anda.
                </p>
                <div class="hero-cta">
                    <a href="{{ route('reservasi.create') }}" class="btn-primary-hero">Buat Reservasi Sekarang</a>
                    <a href="#layanan" class="btn-outline-hero">Lihat Layanan</a>
                </div>
            </div>

            <!-- Right: 2 stat cards only -->
            <div class="hero-stats">
                <div class="hero-stat-card">
                    <div class="divider"></div>
                    <div class="num">5.000+</div>
                    <div class="label">Pasien telah terlayani</div>
                </div>
                <div class="hero-stat-card">
                    <div class="divider"></div>
                    <div class="num">98%</div>
                    <div class="label">Tingkat kepuasan pasien</div>
                </div>
            </div>
        </div>

        <div style="position:absolute;bottom:-2px;left:0;right:0;height:80px;background:white;clip-path:ellipse(55% 100% at 50% 100%);"></div>
    </section>

    <!-- ─── Services ─── -->
    <section id="layanan" class="services-section">
        <div class="services-inner">
            <div class="services-header reveal">
                <span class="section-tag">Layanan Kami</span>
                <h2 class="section-title" style="margin-bottom:14px;">Perawatan Lengkap<br>untuk Senyum Sempurna</h2>
                <p class="section-sub">Berbagai perawatan gigi profesional dengan standar medis tertinggi untuk seluruh keluarga</p>
            </div>

            <div class="services-grid">
                <div class="service-card reveal">
                    
                    <h3 class="text-primary-600">Pembersihan Gigi</h3>
                    <p>Pembersihan karang gigi dan plak secara profesional menggunakan ultrasonic scaler terkini.</p>
                </div>
                <div class="service-card reveal reveal-delay-1">
                    
                    <h3 class="text-primary-600">Penambalan Gigi</h3>
                    <p>Penambalan gigi berlubang dengan bahan komposit sewarna gigi, tahan lama dan estetis.</p>
                </div>
                <div class="service-card reveal reveal-delay-2">
                    
                    <h3 class="text-primary-600">Whitening Gigi</h3>
                    <p>Pemutihan gigi profesional dengan teknologi laser untuk hasil lebih cerah dan tahan lama.</p>
                </div>
                <div class="service-card reveal">
                   
                    <h3 class="text-primary-600">Kawat Gigi</h3>
                    <p>Pemasangan kawat gigi konvensional dan transparan untuk merapikan susunan gigi secara optimal.</p>
                </div>
                <div class="service-card reveal reveal-delay-1">
                    
                    <h3 class="text-primary-600">Pencabutan Gigi</h3>
                    <p>Tindakan pencabutan gigi yang aman dan minim rasa sakit dengan anestesi lokal modern.</p>
                </div>
                <div class="service-card reveal reveal-delay-2">
                    
                    <h3 class="text-primary-600">Implan Gigi</h3>
                    <p>Solusi permanen mengganti gigi yang hilang dengan implan titanium berkualitas tinggi dan tahan lama.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ─── About ─── -->
    <section id="tentang" class="about-section">
        <div class="about-inner">
            <!-- Image -->
            <div class="about-img-wrap reveal">
                <div class="about-img-bg"></div>
                <div class="about-img-frame">
                    <img src="https://images.unsplash.com/photo-1629909613654-28e377c37b09?w=700&q=80" alt="Klinik Miss Dentist Meulaboh">
                </div>
                <div class="about-badge">
                    <div class="about-badge-icon">
                        <svg fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
                    </div>
                    <div class="about-badge-text">
                        <div class="title">Terakreditasi</div>
                        <div class="sub">Kemenkes RI</div>
                    </div>
                </div>
            </div>

            <!-- Text -->
            <div class="about-text reveal">
                <span class="section-tag">Tentang Kami</span>
                <h2 class="section-title">Mengapa Memilih<br>Miss Dentist Meulaboh?</h2>
                <p class="about-desc">
                    Sejak 2010, kami telah menjadi pilihan utama masyarakat Meulaboh untuk perawatan gigi yang komprehensif. Dengan tim dokter berpengalaman dan fasilitas modern, kami berkomitmen memberikan pengalaman terbaik untuk setiap pasien.
                </p>

                <div class="about-checks">
                    <div class="check-item">
                        <div class="check-icon">
                            <svg fill="currentColor" viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/></svg>
                        </div>
                        <div class="check-text">
                            <div class="title">Dokter Berpengalaman & Tersertifikasi</div>
                            <div class="sub">Tim dokter kami memiliki spesialisasi dan pengalaman luas di bidangnya.</div>
                        </div>
                    </div>
                    <div class="check-item">
                        <div class="check-icon">
                            <svg fill="currentColor" viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/></svg>
                        </div>
                        <div class="check-text">
                            <div class="title">Peralatan Medis Modern</div>
                            <div class="sub">Teknologi digital X-ray, laser, dan peralatan canggih lainnya.</div>
                        </div>
                    </div>
                    <div class="check-item">
                        <div class="check-icon">
                            <svg fill="currentColor" viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/></svg>
                        </div>
                        <div class="check-text">
                            <div class="title">Lingkungan Steril & Nyaman</div>
                            <div class="sub">Standar kebersihan tinggi dan ruangan yang dirancang untuk kenyamanan Anda.</div>
                        </div>
                    </div>
                </div>

                <div class="about-stats">
                    <div class="stat-box">
                        <div class="stat-num">5K+</div>
                        <div class="stat-label">Pasien</div>
                    </div>
                    <div class="stat-box">
                        <div class="stat-num">10+</div>
                        <div class="stat-label">Dokter</div>
                    </div>
                    <div class="stat-box">
                        <div class="stat-num">15+</div>
                        <div class="stat-label">Tahun</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ─── Gallery ─── -->
    <section id="galeri" class="gallery-section">
        <div class="gallery-inner">
            <div class="gallery-header reveal">
                <div class="gallery-header-text">
                    <span class="section-tag">Galeri Klinik</span>
                    <h2 class="section-title">Fasilitas &amp;<br>Suasana Klinik</h2>
                </div>
                <a href="#" class="gallery-view-all">
                    Lihat Semua
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
            </div>

            <div class="gallery-grid reveal">
                <!-- Slot 1: large -->
                <div class="gallery-item">
                    <div class="gallery-placeholder" style="min-height:340px;">
                        <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M13.5 12h.008v.008H13.5V12zm-6 3.75h12.75a2.25 2.25 0 002.25-2.25V6.75a2.25 2.25 0 00-2.25-2.25H4.5A2.25 2.25 0 002.25 6.75v8.25A2.25 2.25 0 004.5 18z"/>
                        </svg>
                        <span>Foto Utama Klinik</span>
                    </div>
                </div>
                <!-- Slot 2 -->
                <div class="gallery-item">
                    <div class="gallery-placeholder">
                        <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M13.5 12h.008v.008H13.5V12zm-6 3.75h12.75a2.25 2.25 0 002.25-2.25V6.75a2.25 2.25 0 00-2.25-2.25H4.5A2.25 2.25 0 002.25 6.75v8.25A2.25 2.25 0 004.5 18z"/>
                        </svg>
                        <span>Ruang Perawatan</span>
                    </div>
                </div>
                <!-- Slot 3 -->
                <div class="gallery-item">
                    <div class="gallery-placeholder">
                        <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M13.5 12h.008v.008H13.5V12zm-6 3.75h12.75a2.25 2.25 0 002.25-2.25V6.75a2.25 2.25 0 00-2.25-2.25H4.5A2.25 2.25 0 002.25 6.75v8.25A2.25 2.25 0 004.5 18z"/>
                        </svg>
                        <span>Tim Dokter</span>
                    </div>
                </div>
                <!-- Slot 4: wide -->
                <div class="gallery-item">
                    <div class="gallery-placeholder">
                        <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M13.5 12h.008v.008H13.5V12zm-6 3.75h12.75a2.25 2.25 0 002.25-2.25V6.75a2.25 2.25 0 00-2.25-2.25H4.5A2.25 2.25 0 002.25 6.75v8.25A2.25 2.25 0 004.5 18z"/>
                        </svg>
                        <span>Ruang Tunggu</span>
                    </div>
                </div>
                
            </div>

            <p class="reveal" style="text-align:center;margin-top:24px;font-size:13px;color:var(--slate);">
                Ganti placeholder di atas dengan tag <code style="background:var(--rose-pale);color:var(--rose);padding:2px 6px;border-radius:4px;font-size:12px;">&lt;img&gt;</code> foto klinik Anda.
            </p>
        </div>
    </section>

    <!-- ─── Testimonials ─── -->
    <section class="testimonials-section">
        <div class="testimonials-inner">
            <div class="testimonials-header reveal">
                <span class="section-tag">Testimoni</span>
                <h2 class="section-title" style="margin-bottom:12px;">Kata Pasien Kami</h2>
                <p class="section-sub">Kepuasan pasien adalah prioritas utama kami</p>
            </div>
            <div class="testimonials-grid">
                <div class="testimonial-card reveal">
                    <div class="testimonial-stars">
                        <svg class="star" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="star" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="star" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="star" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="star" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    </div>
                    <p class="testimonial-text">Pelayanan sangat profesional dan ramah. Dokternya sabar menjelaskan kondisi gigi saya. Klinik bersih dan suasananya nyaman sekali.</p>
                    <div class="testimonial-author">
                        <div class="author-avatar">A</div>
                        <div>
                            <div class="author-name">Anisa R.</div>
                            <div class="author-role">Pasien Setia</div>
                        </div>
                    </div>
                </div>
                <div class="testimonial-card reveal reveal-delay-1">
                    <div class="testimonial-stars">
                        <svg class="star" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="star" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="star" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="star" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="star" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    </div>
                    <p class="testimonial-text">Proses reservasi online sangat mudah dan responsif. Perawatan kawat gigi saya berjalan lancar dari awal sampai akhir. Sangat direkomendasikan!</p>
                    <div class="testimonial-author">
                        <div class="author-avatar">B</div>
                        <div>
                            <div class="author-name">Budi S.</div>
                            <div class="author-role">Pasien Baru</div>
                        </div>
                    </div>
                </div>
                <div class="testimonial-card reveal reveal-delay-2">
                    <div class="testimonial-stars">
                        <svg class="star" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="star" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="star" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="star" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="star" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    </div>
                    <p class="testimonial-text">Hasil whitening gigi luar biasa! Dokternya sangat teliti dan peralatan kliniknya modern. Saya puas dan pasti akan kembali lagi.</p>
                    <div class="testimonial-author">
                        <div class="author-avatar">C</div>
                        <div>
                            <div class="author-name">Citra M.</div>
                            <div class="author-role">Pasien Setia</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ─── CTA ─── -->
    <section class="cta-section">
        <div class="cta-bg-circle cta-bg-circle-1"></div>
        <div class="cta-bg-circle cta-bg-circle-2"></div>
        <div class="cta-inner reveal">
            <span class="cta-tag">Reservasi Online 24/7</span>
            <h2 class="cta-title">Jadwalkan Kunjungan<br>Anda Sekarang</h2>
            <p class="cta-desc">Proses reservasi mudah dan cepat. Pilih jadwal yang sesuai dan dokter yang Anda inginkan.</p>
            <a href="{{ route('reservasi.create') }}" class="btn-cta">Buat Reservasi Gratis</a>
            <p class="cta-note">Tidak dipungut biaya pendaftaran. Konfirmasi via telepon dalam 24 jam.</p>
        </div>
    </section>

    <!-- ─── Contact ─── -->
    <section id="kontak" class="contact-section">
        <div class="contact-inner">
            <div class="contact-header reveal">
                <h2 class="section-title">Hubungi Kami</h2>
                <p class="section-sub" style="color:rgba(255,255,255,0.45);margin-top:10px;">Kami siap melayani Anda Senin–Sabtu, 08.00–20.00 WIB</p>
            </div>
            <div class="contact-grid reveal">
                <div class="contact-card">
                    <div class="contact-icon-wrap">
                        <svg fill="currentColor" viewBox="0 0 24 24"><path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/></svg>
                    </div>
                    <div class="contact-card-label">Telepon</div>
                    <div class="contact-card-value">+62 123 456 789</div>
                    <div class="contact-card-sub">Senin–Sabtu, 08–20 WIB</div>
                </div>
                <div class="contact-card">
                    <div class="contact-icon-wrap">
                        <svg fill="currentColor" viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
                    </div>
                    <div class="contact-card-label">Email</div>
                    <div class="contact-card-value" style="font-size:16px;">info@missdentist.com</div>
                    <div class="contact-card-sub">Respon dalam 24 jam</div>
                </div>
                <div class="contact-card">
                    <div class="contact-icon-wrap">
                        <svg fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>
                    </div>
                    <div class="contact-card-label">Alamat</div>
                    <div class="contact-card-value" style="font-size:17px;">Jl. Kesehatan No. 123</div>
                    <div class="contact-card-sub">Meulaboh, Aceh Barat</div>
                </div>
            </div>
        </div>
    </section>

    <!-- ─── Footer ─── -->
    <footer class="footer">
        <div class="footer-inner">
            <div class="footer-logo">
                <svg fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C8.5 2 6 4.1 6 7c0 2.5 1.5 4.5 3 5.5V19c0 1.1.9 2 2 2h2c1.1 0 2-.9 2-2v-6.5c1.5-1 3-3 3-5.5 0-2.9-2.5-5-6-5z"/></svg>
                <span>Miss Dentist Meulaboh</span>
            </div>
            <p class="footer-copy">&copy; 2026 Miss Dentist Meulaboh. Semua hak dilindungi.</p>
            <div class="footer-links">
                <a href="#">Kebijakan Privasi</a>
                <a href="#">Syarat &amp; Ketentuan</a>
            </div>
        </div>
    </footer>

    <script>
        // Scroll reveal
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry, i) => {
                if (entry.isIntersecting) {
                    const delay = entry.target.classList.contains('reveal-delay-1') ? 100
                                : entry.target.classList.contains('reveal-delay-2') ? 200
                                : entry.target.classList.contains('reveal-delay-3') ? 300 : 0;
                    setTimeout(() => entry.target.classList.add('visible'), delay);
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.08 });
        document.querySelectorAll('.reveal').forEach(el => observer.observe(el));

        // Smooth scroll + close mobile menu
        document.querySelectorAll('a[href^="#"]').forEach(a => {
            a.addEventListener('click', e => {
                const id = a.getAttribute('href');
                if (id === '#') return;
                const el = document.querySelector(id);
                if (el) {
                    e.preventDefault();
                    el.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
                document.getElementById('mobileMenu').classList.remove('open');
            });
        });
    </script>
</body>
</html>