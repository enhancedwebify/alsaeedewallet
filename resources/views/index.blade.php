<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>محفظة العائلة الإلكترونية - الصفحة الرئيسية</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        /* Your brand color scheme */
        :root{
            --color-main: #660099;
            --color-main-light: #66009940;
        }

        body {
            background-color: #f0f2f5;
            color: #333;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            text-align: right;
        }
        .hero-section {
            /* Using a gradient with your main color */
            /* background: linear-gradient(to right, var(--color-main), #5a008a); */
            background-image: url("{{asset('img/Gemini_Generated_Image_b6xqab6xqab6xqab.png')}}");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            color: white;
            padding: 80px 0;
            text-align: center;
            position: relative; /* Add this to enable the wave's absolute positioning */
            z-index: 1; /* A base z-index for the hero section */
            overflow: hidden; /* Important to contain the pseudo-element */
        }
        /* The CSS for the Wavy Divider on the Hero Section */
        .hero-section::after {
            content: '';
            position: absolute;
            bottom: 0px;
            left: 0;
            width: 100%;
            height: 100px; /* Adjust this to change the wave height */
             background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none"><path d="M0,120V90C200,60,400,150,600,90S1000,120,1200,90V120H0z" fill="%23ffffff"/></svg>');
    background-size: 100% 100%;
            z-index: 2; /* Place the wave on top of the hero section's content */
        }
        .hero-section h1 {
            font-size: 3.5rem;
            font-weight: 700;
        }
        .hero-section p {
            font-size: 1.25rem;
            margin-top: 20px;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
        }
        .cta-button {
            margin-top: 30px;
            font-size: 1.1rem;
            padding: 12px 30px;
            background-color: white;
            color: var(--color-main);
            border: 2px solid white;
            font-weight: bold;
            transition: all 0.3s ease;
        }
        .cta-button:hover {
            background-color: var(--color-main);
            color: white;
        }
        .features-section {
            padding: 60px 0;
            background-color: #ffffff;
            position: relative; /* This is crucial for positioning the wave */
            background-color: #ffffff;
            z-index: 1; /* To ensure the wave is below the features section */
        }
        .features-section h2 {
            margin-bottom: 40px;
            color: var(--color-main);
            text-align: center;
        }
        /* The CSS for the Wavy Divider */
        .features-section::before {
            content: '';
            position: absolute;
            top: 00px; /* Adjust this value to control how much of the wave is visible */
            left: 0;
            width: 100%;
            height: 50px;
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none"><path d="M0,0V30C200,60,400,60,600,30S1000,0,1200,30V0H0z" fill="%23ffffff"/></svg>');
            background-size: 100% 100%;
        }
        .feature-card {
            background-color: var(--color-main-light);
            border-radius: 10px;
            padding: 30px;
            text-align: center;
            height: 274px;
            border: 1px solid #e9ecef;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        .feature-card h4 {
            margin-top: 15px;
            font-weight: 600;
            color: var(--color-main);
        }
        .feature-icon {
            font-size: 3rem;
            color: var(--color-main);
        }
        .footer {
            background-color: #343a40;
            color: white;
            padding: 20px 0;
            text-align: center;
            margin-top: 50px;
        }
    </style>
    <link rel="stylesheet" href="{{asset('css/styles.css')}}" type="text/css">
</head>
<body>


    <header class="hero-section">
        <div class="container" data-aos="fade-up">
            <h1 data-aos="fade-up" data-aos-duration="1000">محفظة آل سعيد الإلكترونية</h1>
            <p data-aos="fade-up" data-aos-delay="300" data-aos-duration="1000">
                حل متكامل لإدارة الأموال والمساهمات والقروض العائلية بسهولة وأمان.
                سجل الآن لتنظيم أموال عائلتك بطريقة حديثة وشفافة.
            </p>
            <a href="{{ route('register') }}" class="btn cta-button" data-aos="fade-up" data-aos-delay="600" data-aos-duration="1000">ابدأ الآن</a>
        </div>
    </header>

    <main class="features-section">
        <div class="container">
            <h2 data-aos="fade-up">خدمات المستفيدين</h2>
            <div class="row g-4">
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="feature-card">
                        <i class="bi bi-wallet2 feature-icon"></i>
                        <h4 class="mt-3">إدارة المساهمات</h4>
                        <p>تتبع المساهمات الشهرية من جميع أفراد العائلة بشكل آلي ومنظم.</p>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="400">
                    <div class="feature-card">
                        <i class="bi bi-cash-stack feature-icon"></i>
                        <h4 class="mt-3">نظام القروض</h4>
                        <p>إدارة طلبات القروض العائلية ومتابعة عمليات السداد بمرونة وشفافية.</p>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="600">
                    <div class="feature-card">
                        <i class="bi bi-shield-lock feature-icon"></i>
                        <h4 class="mt-3">أمان تام</h4>
                        <p>نضمن حماية بياناتك ومعاملاتك المالية بأحدث تقنيات الأمان والحماية.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="container my-4 py-3">
            <h2 data-aos="fade-up">سجل الدخول لمتابعة طلباتك ومساهماتك</h2>
            <div class="row g-4">
                <a href="{{route('user.login')}}" class="col-md-6 text-decoration-none" data-aos="fade-up" data-aos-delay="200">
                    <div class="feature-card">
                        <i class="bi bi-person feature-icon"></i>
                        <h4 class="mt-3">دخول الأفراد</h4>
                        <p class="text-dark">تتبع مساهماتك وانشاء الطلبات.</p>
                    </div>
                </a>
                <a href="{{route('superuser.login')}}" class="col-md-6 text-decoration-none" data-aos="fade-up" data-aos-delay="200">
                    <div class="feature-card">
                        <i class="bi bi-person feature-icon"></i>
                        <h4 class="mt-3">دخول المدراء</h4>
                        <p class="text-dark">تتبع مساهماتك وانشاء الطلبات.</p>
                    </div>
                </a>

            </div>
        </div>
    </main>

    <footer class="footer">
        <div class="container">
            <p>&copy; {{date("Y")}} محفظة العائلة الإلكترونية. جميع الحقوق محفوظة.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>
</html>
