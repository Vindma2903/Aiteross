<style>
    .unified-site-footer .container {
        max-width: 1360px;
        margin: 0 auto;
        padding-left: 20px;
        padding-right: 20px;
    }
    .unified-site-footer {
        background: #33363C;
        color: #FFFFFF;
        margin-top: 0;
    }
    .unified-site-footer__top {
        padding-top: 52px;
        padding-bottom: 48px;
    }
    .unified-site-footer__grid {
        display: grid;
        grid-template-columns: 1.35fr 0.8fr 0.9fr 0.9fr;
        gap: 28px;
    }
    .unified-site-footer__brand {
        color: #FFFFFF;
        font-size: 20px;
        font-weight: 700;
        letter-spacing: 0.4px;
        margin-bottom: 16px;
    }
    .unified-site-footer__copy {
        margin: 0;
        color: rgba(255,255,255,0.68);
        line-height: 1.7;
        max-width: 320px;
    }
    .unified-site-footer__socials {
        display: flex;
        gap: 10px;
        margin-top: 24px;
    }
    .unified-site-footer__title {
        color: rgba(255,255,255,0.52);
        font-size: 12.5px;
        font-weight: 700;
        letter-spacing: 1px;
        margin-bottom: 16px;
    }
    .unified-site-footer__nav,
    .unified-site-footer__contact,
    .unified-site-footer__legal {
        display: grid;
        gap: 12px;
    }
    .unified-site-footer__nav a,
    .unified-site-footer__contact a {
        color: #FFFFFF;
        text-decoration: none;
        transition: color 0.15s ease;
    }
    .unified-site-footer__nav a:hover,
    .unified-site-footer__contact a:hover {
        color: #8FB6FF;
    }
    .unified-site-footer__contact,
    .unified-site-footer__legal {
        color: rgba(255,255,255,0.7);
        line-height: 1.65;
    }
    .unified-site-footer__legal {
        gap: 8px;
        font-size: 13.5px;
    }
    .unified-site-footer__bottom {
        padding-top: 18px;
        padding-bottom: 22px;
        border-top: 1px solid rgba(255,255,255,0.1);
        color: rgba(255,255,255,0.5);
        font-size: 13px;
    }
    @media (max-width: 1180px) {
        .unified-site-footer__grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }
    @media (max-width: 760px) {
        .unified-site-footer__top,
        .unified-site-footer__bottom,
        .unified-site-footer .container {
            padding-left: 16px;
            padding-right: 16px;
        }
        .unified-site-footer__grid {
            grid-template-columns: 1fr;
            gap: 24px;
        }
    }
</style>
