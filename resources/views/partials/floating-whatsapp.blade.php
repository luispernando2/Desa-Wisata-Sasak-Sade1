@php
    $waNumber = '082145903035';
    $waLink = 'https://wa.me/6282145903035';
@endphp

<a href="{{ $waLink }}"
   class="floating-wa"
   target="_blank"
   rel="noopener noreferrer"
   aria-label="Chat WhatsApp">

    <span class="floating-wa__icon" aria-hidden="true">

        <img
            src="https://api.iconify.design/logos/whatsapp-icon.svg"
            alt="WhatsApp"
            class="floating-wa__img"
            loading="lazy"
        >

    </span>

    <span class="floating-wa__bubble" aria-hidden="true">
        Mau tanya wisata? Chat kami 😊
    </span>

</a>

<style>

    .floating-wa{
        position: fixed;
        right: 24px;
        bottom: 24px;
        z-index: 9999;

        display: flex;
        align-items: center;
        gap: 14px;

        text-decoration: none;
    }

    .floating-wa__icon{
        width: 68px;
        height: 68px;

        border-radius: 50%;

        background: #25D366;

        display: flex;
        align-items: center;
        justify-content: center;

        box-shadow:
            0 10px 30px rgba(37,211,102,0.35);

        animation: waFloat 2.5s ease-in-out infinite;

        transition: all 0.3s ease;
    }

    .floating-wa__icon:hover{
        transform: scale(1.08);
    }

    .floating-wa__img{
        width: 36px;
        height: 36px;
    }

    .floating-wa__bubble{
        background: rgba(255,255,255,0.95);

        backdrop-filter: blur(10px);

        padding: 14px 18px;

        border-radius: 18px;

        color: #222;
        font-weight: 600;
        font-size: 14px;

        box-shadow:
            0 10px 30px rgba(0,0,0,0.10);

        white-space: nowrap;
    }

    @keyframes waFloat{

        0%{
            transform: translateY(0px);
        }

        50%{
            transform: translateY(-8px);
        }

        100%{
            transform: translateY(0px);
        }

    }

    @media(max-width: 768px){

        .floating-wa{
            right: 18px;
            bottom: 18px;
        }

        .floating-wa__icon{
            width: 58px;
            height: 58px;
        }

        .floating-wa__img{
            width: 30px;
            height: 30px;
        }

        .floating-wa__bubble{
            display: none;
        }

    }

</style>