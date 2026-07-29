<style>
    .topbar {
        border-bottom: 1px solid #EDEFF2;
        background: #FFFFFF;
    }
    .topbar-inner {
        max-width: 1360px;
        margin: 0 auto;
        padding: 0 20px;
        min-height: 58px;
        display: flex;
        align-items: center;
        gap: 28px;
    }
    .topbar-nav {
        display: flex;
        align-items: center;
        gap: 22px;
        flex-wrap: wrap;
    }
    .topbar-nav a,
    .topbar-email,
    .header-link,
    .social-circle {
        text-decoration: none;
    }
    .topbar-nav a {
        color: #5B6470;
        font-size: 14.5px;
        font-weight: 500;
        white-space: nowrap;
        transition: color 0.15s ease;
    }
    .topbar-nav a:hover,
    .topbar-email:hover,
    .header-link:hover {
        color: #0B2545;
    }
    .topbar-spacer {
        flex: 1;
    }
    .topbar-phone {
        color: #14161A;
        font-size: 14.5px;
        font-weight: 600;
        white-space: nowrap;
        text-decoration: none;
    }
    .topbar-email {
        color: #5B6470;
        font-size: 14.5px;
        font-weight: 500;
        white-space: nowrap;
        transition: color 0.15s ease;
    }
    .social-row {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .social-circle {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: #F1F3F6;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex: none;
        transition: background 0.15s ease;
    }
    .social-circle img {
        width: 16px;
        height: 16px;
        object-fit: contain;
        display: block;
    }
    .social-circle:hover {
        background: #E3E6EA;
    }
    .callback-button,
    .catalog-button,
    .search-submit {
        border: none;
        cursor: pointer;
        font-family: inherit;
        transition: background 0.15s ease;
    }
    .callback-button {
        min-height: 40px;
        padding: 10px 18px;
        border-radius: 100px;
        background: #1657C4;
        color: #fff;
        font-size: 14px;
        font-weight: 600;
        white-space: nowrap;
        display: inline-flex;
        align-items: center;
    }
    .callback-button:hover,
    .catalog-button:hover,
    .search-submit:hover {
        background: #123F94;
    }
    .site-header {
        position: sticky;
        top: 0;
        z-index: 100;
        background: #FFFFFF;
        border-bottom: 1px solid #E3E6EA;
        box-shadow: 0 4px 16px rgba(11, 37, 69, 0.08);
    }
    .header-inner {
        max-width: 1360px;
        margin: 0 auto;
        padding: 0 20px;
        min-height: 74px;
        display: flex;
        align-items: center;
        gap: 20px;
    }
    .brand {
        text-decoration: none;
        flex: none;
    }
    .brand-name {
        color: #0B2545;
        font-size: 22px;
        font-weight: 700;
        letter-spacing: 0.3px;
        white-space: nowrap;
    }
    .catalog-button {
        display: inline-flex;
        align-items: center;
        background: #1657C4;
        color: #fff;
        padding: 12px 22px;
        border-radius: 100px;
        font-size: 15px;
        font-weight: 600;
        white-space: nowrap;
        flex: none;
        text-decoration: none;
    }
    .header-search {
        flex: 1;
        min-width: 180px;
    }
    .search-box {
        display: flex;
        align-items: center;
        gap: 10px;
        background: #fff;
        border: 1.5px solid #1657C4;
        border-radius: 100px;
        padding: 0 6px 0 20px;
        height: 46px;
    }
    .search-box input {
        flex: 1;
        min-width: 0;
        border: none;
        background: transparent;
        outline: none;
        font-size: 14.5px;
        font-family: inherit;
        color: #14161A;
    }
    .search-submit {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: #1657C4;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex: none;
    }
    .header-actions {
        display: flex;
        align-items: center;
        gap: 20px;
        flex: none;
    }
    .header-link {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        color: #14161A;
        font-size: 14.5px;
        font-weight: 500;
        white-space: nowrap;
        transition: color 0.15s ease;
    }
    .header-count {
        min-width: 18px;
        height: 18px;
        padding: 0 6px;
        border-radius: 999px;
        background: #1657C4;
        color: #fff;
        font-size: 11px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    .account-menu {
        position: relative;
        flex: none;
    }
    .account-menu-trigger {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        border: none;
        background: transparent;
        padding: 0;
        color: #14161A;
        font-size: 14.5px;
        font-weight: 500;
        font-family: inherit;
        cursor: pointer;
        white-space: nowrap;
    }
    .account-menu-trigger:hover {
        color: #0B2545;
    }
    .account-menu-panel {
        position: absolute;
        top: calc(100% + 14px);
        right: 0;
        min-width: 220px;
        padding: 10px;
        border-radius: 16px;
        border: 1px solid #E3E6EA;
        background: #FFFFFF;
        box-shadow: 0 24px 48px -24px rgba(11, 37, 69, 0.22);
        display: none;
        z-index: 130;
    }
    .account-menu.is-open .account-menu-panel {
        display: block;
    }
    .account-menu-item,
    .account-menu-logout {
        width: 100%;
        display: flex;
        align-items: center;
        gap: 10px;
        min-height: 44px;
        padding: 0 14px;
        border-radius: 12px;
        color: #14161A;
        text-decoration: none;
        background: #FFFFFF;
        font-size: 14px;
        font-weight: 600;
        transition: background 0.15s ease, color 0.15s ease;
    }
    .account-menu-item:hover,
    .account-menu-logout:hover {
        background: #F4F7FB;
        color: #1657C4;
    }
    .account-menu-logout {
        border: none;
        font-family: inherit;
        cursor: pointer;
    }
    .account-menu-form {
        margin: 0;
    }
    @media (max-width: 1400px) {
        .topbar-email {
            display: none;
        }
    }
    @media (max-width: 980px) {
        .topbar-inner,
        .header-inner {
            padding-top: 14px;
            padding-bottom: 14px;
            flex-wrap: wrap;
        }
        .topbar-spacer {
            display: none;
        }
        .header-actions {
            flex-wrap: wrap;
        }
        .header-search {
            order: 10;
            width: 100%;
            flex-basis: 100%;
        }
    }
    @media (max-width: 760px) {
        .topbar-inner,
        .header-inner {
            padding-left: 16px;
            padding-right: 16px;
            gap: 14px;
        }
    }
</style>
