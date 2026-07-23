<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Админка | АЙТЕРОСС</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@400;500;600;700&display=swap');
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: 'IBM Plex Sans', system-ui, sans-serif;
            color: #14161A;
            background: #FFFFFF;
        }
        .shell {
            width: 100%;
            min-height: 100vh;
            display: flex;
            background: #FFFFFF;
        }
        .sidebar {
            width: 320px;
            flex: none;
            padding: 34px 24px;
            background: #FFFFFF;
            border-right: 1px solid #E3E6EA;
            display: flex;
            flex-direction: column;
            gap: 24px;
        }
        .brand {
            font-size: 20px;
            font-weight: 700;
            letter-spacing: 0.3px;
            color: #0B2545;
        }
        .sidebar-subtitle {
            margin: 6px 0 0;
            color: #8891A0;
            line-height: 1.6;
            font-size: 13px;
        }
        .nav {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }
        .nav > a:nth-of-type(1) { order: 1; }
        .nav > a:nth-of-type(2) { order: 2; }
        .nav > a:nth-of-type(3) { order: 3; }
        .nav > a:nth-of-type(4) { order: 4; }
        .nav > a:nth-of-type(5) { order: 5; }
        .nav-title {
            padding: 18px 14px 8px;
            margin-top: 8px;
            border-top: 1px solid #E3E6EA;
            color: #8891A0;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.5px;
        }
        .nav-link {
            display: flex;
            align-items: center;
            min-height: 52px;
            padding: 0 14px;
            border-radius: 14px;
            color: #14161A;
            text-decoration: none;
            font-size: 15px;
            font-weight: 600;
            transition: background 0.15s ease, color 0.15s ease;
        }
        .nav-link:hover {
            background: #F5F7FB;
        }
        .nav-link--active {
            background: #EAF1FB;
            color: #1657C4;
        }
        .sidebar-footer {
            margin-top: auto;
            padding-top: 20px;
            border-top: 1px solid #E3E6EA;
        }
        .logout-button {
            width: 100%;
            min-height: 52px;
            border: 1px solid #F0D7D7;
            border-radius: 14px;
            background: transparent;
            color: #D34040;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
        }
        .logout-button:hover {
            background: #FDF4F4;
        }
        .main {
            flex: 1;
            min-width: 0;
            padding: 36px 48px;
        }
        .hero {
            margin-bottom: 28px;
        }
        .hero h1 {
            margin: 0 0 14px;
            font-size: 26px;
        }
        .hero p {
            margin: 0;
            color: #8891A0;
            line-height: 1.6;
            font-size: 14.5px;
            max-width: 760px;
        }
        .content-card {
            background: #FFFFFF;
            border: 1px solid #E3E6EA;
            border-radius: 22px;
            padding: 36px 48px 44px;
            min-height: 690px;
        }
        .toast-stack {
            position: fixed;
            top: 24px;
            right: 24px;
            z-index: 3000;
            display: grid;
            gap: 12px;
            pointer-events: none;
        }
        .toast {
            width: min(360px, calc(100vw - 32px));
            padding: 16px 18px;
            border-radius: 16px;
            border: 1px solid #B9E7C9;
            background: #FFFFFF;
            box-shadow: 0 24px 48px -28px rgba(11, 37, 69, 0.35);
            display: flex;
            align-items: flex-start;
            gap: 12px;
            pointer-events: auto;
            opacity: 1;
            transform: translateY(0);
            transition: opacity 0.2s ease, transform 0.2s ease;
        }
        .toast.is-hiding {
            opacity: 0;
            transform: translateY(-10px);
        }
        .toast__accent {
            width: 10px;
            min-width: 10px;
            align-self: stretch;
            border-radius: 999px;
            background: #22C55E;
        }
        .toast__body {
            flex: 1;
            min-width: 0;
        }
        .toast__title {
            margin: 0 0 4px;
            font-size: 14px;
            font-weight: 700;
            color: #14161A;
        }
        .toast__message {
            margin: 0;
            color: #526070;
            font-size: 14px;
            line-height: 1.5;
        }
        .toast__close {
            width: 28px;
            height: 28px;
            padding: 0;
            border: none;
            border-radius: 8px;
            background: transparent;
            color: #7E8896;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        .toast__close:hover {
            background: #F5F7FB;
            color: #14161A;
        }
        .pages-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 26px;
            max-width: 760px;
        }
        .page-tile {
            display: flex;
            flex-direction: column;
            gap: 18px;
            padding: 30px;
            border-radius: 14px;
            text-decoration: none;
            color: #14161A;
            border: 1px solid #E3E6EA;
            background: #fff;
            font-weight: 600;
            min-height: 176px;
            transition: transform 0.15s ease, border-color 0.15s ease, box-shadow 0.15s ease;
        }
        .page-tile:hover {
            transform: translateY(-1px);
            border-color: #1657C4;
            box-shadow: 0 12px 28px -16px rgba(11, 37, 69, 0.2);
        }
        .page-icon {
            width: 52px;
            height: 52px;
            border-radius: 12px;
            background: #EAF1FB;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .page-tile__label {
            font-size: 16px;
            font-weight: 700;
            line-height: 1.3;
        }
        .placeholder-panel {
            display: grid;
            gap: 20px;
            max-width: 760px;
        }
        .placeholder-box {
            background: #fff;
            border: 1px solid #E3E6EA;
            border-radius: 18px;
            padding: 28px;
        }
        .placeholder-box h2 {
            margin: 0 0 12px;
            font-size: 18px;
        }
        .placeholder-box p,
        .placeholder-box li {
            margin: 0;
            color: #5B6470;
            line-height: 1.7;
        }
        .placeholder-box ul {
            margin: 0;
            padding-left: 20px;
        }
        .orders-shell {
            display: grid;
            grid-template-columns: 360px minmax(0, 1fr);
            gap: 24px;
            align-items: start;
        }
        .orders-list,
        .order-workspace {
            display: grid;
            gap: 16px;
        }
        .orders-list-card,
        .order-detail-card,
        .order-summary-card {
            background: #fff;
            border: 1px solid #E3E6EA;
            border-radius: 18px;
            padding: 22px;
        }
        .orders-list-title,
        .order-section-title {
            margin: 0 0 14px;
            font-size: 18px;
            font-weight: 700;
        }
        .orders-stack {
            display: grid;
            gap: 12px;
        }
        .order-card {
            width: 100%;
            padding: 16px 18px;
            border: 1.5px solid #D6DAE0;
            border-radius: 16px;
            background: #FFFFFF;
            text-align: left;
            cursor: pointer;
            font-family: inherit;
            transition: border-color 0.15s ease, box-shadow 0.15s ease, transform 0.15s ease;
        }
        .order-card:hover {
            border-color: #1657C4;
            box-shadow: 0 12px 28px -18px rgba(11, 37, 69, 0.28);
            transform: translateY(-1px);
        }
        .order-card.is-active {
            border-color: #1657C4;
            background: #F8FBFF;
            box-shadow: 0 16px 30px -22px rgba(22, 87, 196, 0.34);
        }
        .order-card-top,
        .order-card-bottom,
        .order-customer-head,
        .order-summary-row,
        .product-preview-head,
        .product-preview-price {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }
        .order-card-id {
            font-size: 13px;
            font-weight: 700;
            color: #1657C4;
            letter-spacing: 0.3px;
        }
        .order-card-date,
        .order-card-note,
        .order-meta,
        .order-summary-hint,
        .product-preview-desc,
        .product-preview-unit {
            color: #6A7381;
            font-size: 13px;
            line-height: 1.6;
        }
        .order-card-company,
        .order-summary-main,
        .order-customer-title,
        .product-preview-name {
            font-size: 15px;
            font-weight: 700;
            color: #14161A;
        }
        .order-card-contact {
            color: #14161A;
            font-size: 13px;
            font-weight: 600;
        }
        .status-pill {
            display: inline-flex;
            align-items: center;
            min-height: 28px;
            padding: 0 12px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 700;
            white-space: nowrap;
        }
        .status-pill--new {
            background: #EAF1FB;
            color: #1657C4;
        }
        .status-pill--progress {
            background: #FFF3E8;
            color: #B26A1F;
        }
        .status-pill--done {
            background: #EAF7EE;
            color: #227A44;
        }
        .order-pane {
            display: none;
        }
        .order-pane.is-active {
            display: grid;
            gap: 16px;
        }
        .order-customer-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 14px;
        }
        .order-customer-card {
            border: 1px solid #E3E6EA;
            border-radius: 16px;
            padding: 16px;
            background: #FBFCFE;
        }
        .order-meta {
            margin-top: 4px;
        }
        .order-processing-grid {
            display: grid;
            grid-template-columns: minmax(0, 1.2fr) 320px;
            gap: 16px;
            align-items: start;
        }
        .order-product-panel {
            border: 1px solid #E3E6EA;
            border-radius: 18px;
            padding: 18px;
            background: #fff;
            display: grid;
            gap: 16px;
        }
        .product-preview {
            border: 1px solid #E3E6EA;
            border-radius: 16px;
            padding: 16px;
            background: #F9FBFD;
            display: grid;
            grid-template-columns: 108px minmax(0, 1fr);
            gap: 14px;
            align-items: start;
        }
        .product-preview-image,
        .product-preview-placeholder {
            width: 108px;
            height: 108px;
            border-radius: 18px;
            overflow: hidden;
            border: 1px solid #E3E6EA;
            background: #FFFFFF;
        }
        .product-preview-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }
        .product-preview-placeholder {
            display: flex;
            align-items: center;
            justify-content: center;
            color: #98A2B3;
        }
        .product-preview-info {
            display: grid;
            gap: 10px;
        }
        .product-preview-price strong {
            font-size: 20px;
            color: #14161A;
        }
        .order-summary-card {
            position: sticky;
            top: 24px;
        }
        .order-summary-stack {
            display: grid;
            gap: 14px;
        }
        .order-summary-row {
            align-items: start;
        }
        .order-summary-label {
            color: #8891A0;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.4px;
            text-transform: uppercase;
        }
        .order-summary-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 8px;
        }
        .status-select {
            width: 100%;
            min-width: 180px;
            min-height: 42px;
            border: 1.5px solid #D6DAE0;
            border-radius: 10px;
            padding: 0 12px;
            font: inherit;
            color: #14161A;
            background: #fff;
            outline: none;
        }
        .status-select:focus {
            border-color: #1657C4;
            box-shadow: 0 0 0 4px rgba(22, 87, 196, 0.12);
        }
        .products-shell {
            display: grid;
            gap: 20px;
        }
        .products-toolbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
        }
        .toolbar-actions {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }
        .products-filters {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            align-items: center;
            padding: 18px;
            border: 1px solid #E3E6EA;
            border-radius: 18px;
            background: #fff;
        }
        .products-title {
            margin: 0;
            font-size: 20px;
        }
        .primary-button,
        .secondary-button,
        .danger-button {
            min-height: 46px;
            padding: 0 18px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            text-decoration: none;
            font-family: inherit;
        }
        .primary-button {
            border: none;
            background: #1657C4;
            color: #fff;
        }
        .primary-button:hover {
            background: #123F94;
        }
        .secondary-button {
            border: 1.5px solid #1657C4;
            background: #fff;
            color: #1657C4;
        }
        .secondary-button:hover {
            background: #EAF1FB;
        }
        .filter-reset-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 118px;
            white-space: nowrap;
            border-color: #D6DEE8;
            color: #526070;
        }
        .filter-reset-button:hover {
            background: #F5F7FB;
            border-color: #C7D2DF;
            color: #14161A;
        }
        .danger-button {
            border: 1px solid #F0D7D7;
            background: #fff;
            color: #D34040;
        }
        .danger-button:hover {
            background: #FDF4F4;
        }
        .products-table-wrap {
            overflow-x: auto;
            border: 1px solid #E3E6EA;
            border-radius: 18px;
            background: #fff;
        }
        .products-table {
            width: 100%;
            min-width: 980px;
            border-collapse: collapse;
        }
        .products-table th,
        .products-table td {
            padding: 16px 18px;
            border-bottom: 1px solid #EDEFF2;
            vertical-align: top;
            text-align: left;
        }
        .products-table th {
            background: #F8FAFD;
            color: #7E8896;
            font-size: 12px;
            letter-spacing: 0.4px;
            text-transform: uppercase;
        }
        .products-table tr:last-child td {
            border-bottom: none;
        }
        .products-table tbody tr[data-edit-modal-id] {
            cursor: pointer;
        }
        .table-product-name {
            font-size: 15px;
            font-weight: 700;
            margin-bottom: 6px;
        }
        .table-product-cell {
            display: grid;
            grid-template-columns: 72px minmax(0, 1fr);
            gap: 14px;
            align-items: start;
        }
        .table-product-image,
        .table-product-placeholder {
            width: 72px;
            height: 72px;
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid #E3E6EA;
            background: #F5F7FB;
            flex: none;
        }
        .table-product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }
        .table-product-placeholder {
            display: flex;
            align-items: center;
            justify-content: center;
            color: #98A2B3;
        }
        .table-product-desc {
            color: #6A7381;
            font-size: 13px;
            line-height: 1.5;
            max-width: 320px;
        }
        .table-chips {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }
        .table-chip {
            display: inline-flex;
            align-items: center;
            min-height: 30px;
            padding: 0 12px;
            border-radius: 999px;
            background: #F5F7FB;
            color: #526070;
            font-size: 12px;
            font-weight: 700;
        }
        .table-chip--hidden {
            background: #FFF3E8;
            color: #B26A1F;
        }
        .table-actions {
            position: relative;
            display: inline-flex;
            justify-content: flex-end;
        }
        .table-actions form {
            margin: 0;
        }
        .table-actions-menu {
            position: absolute;
            top: calc(100% + 8px);
            right: 0;
            z-index: 30;
            min-width: 220px;
            padding: 8px;
            border: 1px solid #E3E6EA;
            border-radius: 14px;
            background: #FFFFFF;
            box-shadow: 0 20px 40px -28px rgba(11, 37, 69, 0.4);
            display: none;
        }
        .table-actions.is-open .table-actions-menu {
            display: grid;
            gap: 4px;
        }
        .table-actions-trigger {
            width: 38px;
            height: 38px;
            padding: 0;
            border: 1px solid #D9E1EA;
            border-radius: 10px;
            background: #FFFFFF;
            color: #526070;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        .table-actions-trigger:hover {
            background: #F5F7FB;
            color: #0B2545;
        }
        .table-action-item {
            width: 100%;
            min-height: 40px;
            padding: 0 12px;
            border: none;
            border-radius: 10px;
            background: transparent;
            color: #14161A;
            text-align: left;
            font-size: 14px;
            font-weight: 600;
            font-family: inherit;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            text-decoration: none;
        }
        .table-action-item:hover {
            background: #F5F7FB;
        }
        .table-action-item--danger {
            color: #D34040;
        }
        .table-action-item--danger:hover {
            background: #FDF4F4;
        }
        .link-button {
            border: none;
            background: transparent;
            color: #1657C4;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            padding: 0;
            font-family: inherit;
        }
        .link-button:hover {
            color: #123F94;
        }
        .empty-box {
            border: 1px dashed #CBD4DE;
            border-radius: 18px;
            padding: 28px;
            color: #5B6470;
            line-height: 1.7;
            background: #FBFCFE;
        }
        .modal-backdrop {
            position: fixed;
            inset: 0;
            background: rgba(11, 37, 69, 0.45);
            display: none;
            align-items: center;
            justify-content: center;
            padding: 20px;
            z-index: 2000;
        }
        .modal-backdrop.is-open {
            display: flex;
        }
        .modal-card {
            width: 100%;
            max-width: 760px;
            max-height: calc(100vh - 40px);
            overflow-y: auto;
            background: #fff;
            border-radius: 22px;
            border: 1px solid #E3E6EA;
            box-shadow: 0 36px 80px -36px rgba(11, 37, 69, 0.45);
            padding: 28px;
        }
        .modal-header {
            display: flex;
            align-items: start;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 20px;
        }
        .modal-header h2 {
            margin: 0 0 8px;
            font-size: 24px;
        }
        .modal-header p {
            margin: 0;
            color: #6A7381;
            line-height: 1.6;
            font-size: 14px;
        }
        .icon-button {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            border: 1px solid #D8DEE6;
            background: #fff;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex: none;
        }
        .icon-button:hover {
            background: #F5F7FB;
        }
        .product-form-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 16px;
            align-items: start;
        }
        .field {
            display: flex;
            flex-direction: column;
            align-items: stretch;
            gap: 8px;
            align-self: start;
        }
        .field--full {
            grid-column: 1 / -1;
        }
        .field label {
            font-size: 13px;
            font-weight: 700;
            color: #8891A0;
            letter-spacing: 0.3px;
            line-height: 1.25;
            margin: 0;
        }
        .field input,
        .field select,
        .field textarea {
            width: 100%;
            border: 1.5px solid #D6DAE0;
            border-radius: 10px;
            padding: 12px 14px;
            font-size: 15px;
            font-family: inherit;
            outline: none;
            background: #fff;
        }
        .field input,
        .field select {
            min-height: 48px;
        }
        .field textarea {
            min-height: 110px;
            resize: vertical;
        }
        .field input[type="file"] {
            min-height: 62px;
            padding: 11px 14px;
            display: flex;
            align-items: center;
        }
        .field input:focus,
        .field select:focus,
        .field textarea:focus {
            border-color: #1657C4;
            box-shadow: 0 0 0 4px rgba(22, 87, 196, 0.12);
        }
        .filter-input,
        .filter-select {
            min-height: 46px;
            border: 1.5px solid #D6DAE0;
            border-radius: 10px;
            padding: 0 14px;
            font-size: 14px;
            font-family: inherit;
            outline: none;
            background: #fff;
        }
        .filter-input {
            min-width: 280px;
            flex: 1;
        }
        .filter-select {
            min-width: 220px;
        }
        .filter-input:focus,
        .filter-select:focus {
            border-color: #1657C4;
            box-shadow: 0 0 0 4px rgba(22, 87, 196, 0.12);
        }
        .toggle-row {
            display: flex;
            align-items: center;
            gap: 12px;
            min-height: 48px;
            flex-wrap: wrap;
        }
        .field-note {
            color: #6A7381;
            font-size: 13px;
            line-height: 1.5;
            word-break: break-word;
        }
        .analog-settings {
            display: grid;
            gap: 16px;
            padding: 18px;
            border: 1px solid #E3E6EA;
            border-radius: 16px;
            background: #F8FAFD;
        }
        .analog-mode-row {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }
        .analog-mode-row label {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #14161A;
            font-size: 14px;
            font-weight: 600;
        }
        .analog-manual-panel {
            display: grid;
            gap: 14px;
            padding-top: 4px;
        }
        .analog-manual-panel[hidden] {
            display: none;
        }
        .analog-search-grid {
            display: grid;
            grid-template-columns: minmax(0, 1fr) 220px auto;
            gap: 12px;
            align-items: end;
        }
        .analog-selected-list {
            display: grid;
            gap: 10px;
        }
        .analog-selected-item {
            display: grid;
            grid-template-columns: minmax(0, 1fr) auto;
            gap: 12px;
            align-items: center;
            padding: 12px 14px;
            border: 1px solid #D6DAE0;
            border-radius: 12px;
            background: #FFFFFF;
        }
        .analog-selected-main {
            min-width: 0;
        }
        .analog-selected-title {
            font-size: 14px;
            font-weight: 700;
            color: #14161A;
            line-height: 1.4;
        }
        .analog-selected-meta {
            margin-top: 3px;
            font-size: 13px;
            color: #6A7381;
        }
        .analog-selected-actions {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }
        .analog-chip-button {
            min-width: 36px;
            height: 36px;
            padding: 0 12px;
            border: 1px solid #D6DAE0;
            border-radius: 10px;
            background: #fff;
            color: #14161A;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
        }
        .analog-chip-button:hover {
            border-color: #1657C4;
            background: #F5F8FF;
        }
        .analog-chip-button:disabled {
            opacity: 0.45;
            cursor: default;
            background: #F5F7FB;
        }
        .analog-empty {
            display: none !important;
            padding: 16px;
            border-radius: 12px;
            border: 1px dashed #C9D3DF;
            color: #6A7381;
            font-size: 14px;
            background: #FFFFFF;
        }
        .analog-limit {
            font-size: 13px;
            color: #6A7381;
        }
        .analog-limit.is-danger {
            color: #D34040;
        }
        .field-error {
            color: #D34040;
            font-size: 13px;
            font-weight: 600;
            line-height: 1.5;
        }
        .import-format {
            margin: 0;
            padding-left: 18px;
            color: #5B6470;
            font-size: 13px;
            line-height: 1.6;
        }
        .import-format strong {
            color: #14161A;
        }
        .image-library {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(116px, 1fr));
            grid-auto-rows: 118px;
            gap: 12px;
        }
        .image-library-option {
            position: relative;
            display: block;
            cursor: pointer;
            height: 118px;
        }
        .image-library-option input {
            position: absolute;
            opacity: 0;
            pointer-events: none;
        }
        .image-library-card,
        .image-library-empty {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100%;
            border: 1.5px solid #D6DAE0;
            border-radius: 14px;
            background: #FFFFFF;
            padding: 8px;
            transition: border-color 0.2s ease, box-shadow 0.2s ease, transform 0.2s ease;
        }
        .image-library-empty {
            text-align: center;
            color: #5A6270;
            font-size: 12px;
            line-height: 1.25;
            overflow: hidden;
        }
        .image-library-card img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            object-position: center;
            border-radius: 10px;
            background: #F3F6FB;
            padding: 6px;
        }
        .image-library-name {
            display: none;
        }
        .image-library-option input:checked + .image-library-card,
        .image-library-option input:checked + .image-library-empty {
            border-color: #1657C4;
            box-shadow: 0 0 0 4px rgba(22, 87, 196, 0.12);
            transform: translateY(-1px);
        }
        .modal-actions {
            margin-top: 20px;
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            flex-wrap: wrap;
        }
        @media (max-width: 1440px) {
            .sidebar {
                width: 284px;
                padding: 30px 18px;
            }
            .main {
                padding: 28px 32px;
            }
            .content-card {
                padding: 28px 30px 34px;
            }
            .products-filters {
                padding: 16px;
            }
            .filter-input {
                min-width: 220px;
            }
            .filter-select {
                min-width: 180px;
            }
            .products-table {
                min-width: 920px;
            }
            .products-table th,
            .products-table td {
                padding: 14px 14px;
            }
            .table-product-cell {
                grid-template-columns: 60px minmax(0, 1fr);
                gap: 12px;
            }
            .table-product-image,
            .table-product-placeholder {
                width: 60px;
                height: 60px;
                border-radius: 14px;
            }
            .table-product-desc {
                max-width: 250px;
            }
            .modal-backdrop {
                padding: 18px;
            }
            .product-modal-card {
                max-width: 680px;
                max-height: calc(100vh - 36px);
                padding: 24px;
                border-radius: 20px;
            }
            .modal-header {
                gap: 14px;
                margin-bottom: 18px;
            }
            .modal-header h2 {
                font-size: 22px;
                margin-bottom: 6px;
            }
            .modal-header p {
                font-size: 13px;
            }
            .icon-button {
                width: 38px;
                height: 38px;
            }
            .product-form-grid {
                gap: 14px;
            }
            .field label,
            .field-note {
                font-size: 12px;
            }
            .field input,
            .field select,
            .field textarea {
                padding: 11px 13px;
                font-size: 14px;
            }
            .field input,
            .field select,
            .toggle-row {
                min-height: 44px;
            }
            .field input[type="file"] {
                min-height: 58px;
                padding: 10px 12px;
            }
            .field textarea {
                min-height: 96px;
            }
            .image-library {
                grid-template-columns: repeat(auto-fill, minmax(108px, 1fr));
                grid-auto-rows: 108px;
                gap: 10px;
            }
            .image-library-option {
                height: 108px;
            }
            .image-library-card,
            .image-library-empty {
                padding: 9px;
                border-radius: 12px;
            }
            .image-library-empty {
                min-height: 124px;
            }
            .analog-search-grid {
                grid-template-columns: 1fr;
            }
            .modal-actions {
                margin-top: 18px;
                gap: 10px;
            }
        }
        @media (max-width: 1100px) {
            .orders-shell,
            .order-processing-grid {
                grid-template-columns: 1fr;
            }
            .order-summary-card {
                position: static;
            }
            .order-customer-grid {
                grid-template-columns: 1fr;
            }
            .pages-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }
        @media (max-width: 900px) {
            .shell {
                flex-direction: column;
            }
            .sidebar {
                width: 100%;
                border-right: none;
                border-bottom: 1px solid #E3E6EA;
            }
            .main {
                padding: 28px 20px;
            }
            .content-card {
                padding: 28px 20px 32px;
                min-height: auto;
            }
            .pages-grid,
            .product-form-grid {
                grid-template-columns: 1fr;
            }
            .analog-selected-item {
                grid-template-columns: 1fr;
            }
            .products-toolbar,
            .modal-header,
            .modal-actions {
                align-items: flex-start;
            }
        }
    </style>
</head>
<body>
    @if (session('status'))
        <div class="toast-stack" data-toast-stack>
            <div class="toast" data-toast>
                <div class="toast__accent" aria-hidden="true"></div>
                <div class="toast__body">
                    <p class="toast__title">Готово</p>
                    <p class="toast__message">{{ session('status') }}</p>
                </div>
                <button type="button" class="toast__close" data-toast-close aria-label="Закрыть уведомление">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="M6 6L18 18M18 6L6 18" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                    </svg>
                </button>
            </div>
        </div>
    @endif

    <div class="shell">
        <aside class="sidebar">
            <div>
                <div class="brand">АЙТЕРОСС</div>
                <p class="sidebar-subtitle">Панель администратора</p>
            </div>

            <nav class="nav">

                <div class="nav-title">УПРАВЛЕНИЕ</div>
                <a href="{{ route('admin.dashboard', ['section' => 'orders']) }}" class="nav-link{{ $selectedSection === 'orders' ? ' nav-link--active' : '' }}">Заявки</a>
                <a href="{{ route('admin.pages.editor', ['page' => 'catalog']) }}" class="nav-link{{ request()->routeIs('admin.pages.editor') && request()->route('page') === 'catalog' ? ' nav-link--active' : '' }}">Категории</a>
                <a href="{{ route('admin.dashboard', ['section' => 'products']) }}" class="nav-link{{ $selectedSection === 'products' ? ' nav-link--active' : '' }}">Товары</a>
                <a href="{{ route('admin.pages.editor', ['page' => 'home']) }}" class="nav-link{{ request()->routeIs('admin.pages.editor') && request()->route('page') === 'home' ? ' nav-link--active' : '' }}">Главная</a>
                <a href="{{ route('admin.pages.editor', ['page' => 'delivery']) }}" class="nav-link{{ request()->routeIs('admin.pages.editor') && request()->route('page') === 'delivery' ? ' nav-link--active' : '' }}">Доставка</a>
                <a href="{{ route('admin.pages.editor', ['page' => 'product']) }}" class="nav-link{{ request()->routeIs('admin.pages.editor') && request()->route('page') === 'product' ? ' nav-link--active' : '' }}">Карточка товара</a>
            </nav>

            <div class="sidebar-footer">
                <form action="{{ route('logout') }}" method="post">
                    @csrf
                    <button type="submit" class="logout-button">Выйти</button>
                </form>
            </div>
        </aside>

        <main class="main">
            <section class="hero">
                <div>
                    @if ($selectedSection === 'pages')
                        <h1>Страницы сайта</h1>
                        <p>Выберите страницу, для которой нужно открыть отдельную полноценную страницу редактора.</p>
                    @elseif ($selectedSection === 'orders')
                        <h1>Заявки</h1>
                        <p>В этом разделе администратор создаёт и ведёт заявки. Сейчас доступен фронтовый прототип с кнопкой создания и таблицей заявок со статусами.</p>
                    @else
                        <h1>Товары</h1>
                        <p>На этой странице есть таблица товаров и pop-up окно для создания новой позиции.</p>
                    @endif
                </div>
            </section>

            <section class="content-card">
                @if ($selectedSection === 'pages')
                    <div class="pages-grid">
                        @foreach (['delivery', 'product'] as $slug)
                            <a href="{{ route('admin.pages.editor', ['page' => $slug]) }}" class="page-tile">
                                <div class="page-icon">
                                    <svg width="19" height="19" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                        <path d="M4 4h16v16H4z" stroke="#1657C4" stroke-width="1.6"/>
                                        <path d="M4 9h16M9 9v11" stroke="#1657C4" stroke-width="1.6"/>
                                    </svg>
                                </div>
                                <div class="page-tile__label">{{ $staticPages[$slug]['label'] }}</div>
                            </a>
                        @endforeach
                    </div>
                @elseif ($selectedSection === 'orders')
                    @php
                        $canCreateOrders = $catalogOptions->isNotEmpty() && $orderContacts->isNotEmpty();
                    @endphp

                    <div class="products-shell">
                        <div class="products-toolbar">
                            <h2 class="products-title">Список заявок</h2>
                            <div class="toolbar-actions">
                                <button type="button" class="primary-button" data-open-order-modal @disabled(! $canCreateOrders)>Создать заявку</button>
                            </div>
                        </div>

                        @if (! $canCreateOrders)
                            <div class="empty-box">Для создания заявок нужен хотя бы один товар в каталоге и хотя бы один пользователь с ролью клиента.</div>
                        @elseif ($orders->isEmpty())
                            <div class="empty-box">Пока нет заявок для отображения. Нажмите `Создать заявку`, чтобы добавить первую запись.</div>
                        @else
                            <div class="products-table-wrap">
                                <table class="products-table">
                                    <thead>
                                        <tr>
                                            <th>Товар</th>
                                            <th>Номер</th>
                                            <th>Клиент</th>
                                            <th>Количество</th>
                                            <th>Создана</th>
                                            <th>Статус</th>
                                            <th>Действия</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orders as $order)
                                            <tr
                                                data-order-row
                                                data-order-update-url="{{ route('admin.orders.update', $order) }}"
                                                data-order-id="{{ $order->order_number }}"
                                                data-order-manager="{{ $order->user_id }}"
                                                data-order-product-id="{{ $order->product_id }}"
                                                data-order-quantity="{{ $order->quantity }}"
                                                data-order-status="{{ $order->status }}"
                                            >
                                                <td>
                                                    <div class="table-product-cell">
                                                        @if ($order->product_image)
                                                            <div class="table-product-image">
                                                                <img src="{{ $order->product_image }}" alt="{{ $order->product_name }}">
                                                            </div>
                                                        @else
                                                            <div class="table-product-placeholder">
                                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                                                    <path d="M4 6h16v12H4z" stroke="currentColor" stroke-width="1.5"/>
                                                                    <path d="M7 15l3-3 2 2 4-4 2 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                                </svg>
                                                            </div>
                                                        @endif
                                                        <div>
                                                            <div class="table-product-name">{{ $order->product_name }}</div>
                                                            <div class="table-product-desc">{{ $order->product_description ?: 'Описание товара не указано.' }}</div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="table-product-name">{{ $order->order_number }}</div>
                                                    <div class="table-product-desc">Создана администратором</div>
                                                </td>
                                                <td>
                                                    <div class="table-product-name">{{ $order->user?->company ?: 'Компания не указана' }}</div>
                                                    <div class="table-product-desc">{{ $order->user?->name ?: 'Контакт не указан' }}</div>
                                                </td>
                                                <td>{{ $order->quantityLabel() }}</td>
                                                <td>{{ $order->created_at?->format('d.m.Y H:i') }}</td>
                                                <td>
                                                    <select class="status-select" data-order-status-control>
                                                        <option value="forming" @selected($order->status === 'forming')>Формируем заказ</option>
                                                        <option value="shipping" @selected($order->status === 'shipping')>В доставке</option>
                                                        <option value="delivered" @selected($order->status === 'delivered')>Доставлено</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <div class="table-actions" data-actions-menu>
                                                        <button
                                                            type="button"
                                                            class="table-actions-trigger"
                                                            data-actions-trigger
                                                            aria-haspopup="true"
                                                            aria-expanded="false"
                                                            aria-label="Действия с заявкой"
                                                        >
                                                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                                                <circle cx="5" cy="12" r="1.8" fill="currentColor"/>
                                                                <circle cx="12" cy="12" r="1.8" fill="currentColor"/>
                                                                <circle cx="19" cy="12" r="1.8" fill="currentColor"/>
                                                            </svg>
                                                        </button>
                                                        <div class="table-actions-menu" role="menu">
                                                            <button type="button" class="table-action-item" data-edit-order role="menuitem">Редактировать</button>
                                                            <form action="{{ route('admin.orders.destroy', $order) }}" method="post" onsubmit="return confirm('Удалить заявку {{ $order->order_number }}?');">
                                                                @csrf
                                                                @method('delete')
                                                                <button type="submit" class="table-action-item table-action-item--danger" role="menuitem">Удалить</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>

                    <div class="modal-backdrop" id="create-order-modal" aria-hidden="true">
                        <div class="modal-card product-modal-card" role="dialog" aria-modal="true" aria-labelledby="create-order-title">
                            <div class="modal-header">
                                <div>
                                    <h2 id="create-order-title" data-order-modal-title>Создать заявку</h2>
                                    <p data-order-modal-description>Создайте заявку, выберите клиента, товар, количество и статус заказа.</p>
                                </div>
                                <button type="button" class="icon-button" data-close-order-modal aria-label="Закрыть окно">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                        <path d="M5 5L19 19M19 5L5 19" stroke="#3A4048" stroke-width="1.8" stroke-linecap="round"/>
                                    </svg>
                                </button>
                            </div>

                            <form action="{{ route('admin.orders.store') }}" method="post" data-order-form data-create-action="{{ route('admin.orders.store') }}">
                                @csrf
                                <input type="hidden" name="_method" value="POST" data-order-form-method>
                                <input type="hidden" name="order_id" value="{{ old('order_id') }}" data-order-current-id>
                                <div class="product-form-grid">
                                    <div class="field">
                                        <label for="order-id">Номер заявки</label>
                                        <input id="order-id" type="text" data-order-id-input placeholder="Будет присвоен после создания" readonly>
                                    </div>

                                    <div class="field">
                                        <label for="order-customer-manager">Контактное лицо</label>
                                        <select id="order-customer-manager" name="user_id" data-order-manager-select required>
                                            @foreach ($orderContacts as $contact)
                                                <option value="{{ $contact->id }}" @selected((string) old('user_id') === (string) $contact->id)>
                                                    {{ $contact->name }}{{ $contact->company ? ' — '.$contact->company : '' }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @if ($errors->createOrder->has('user_id'))
                                            <div class="field-error">{{ $errors->createOrder->first('user_id') }}</div>
                                        @elseif ($errors->updateOrder->has('user_id'))
                                            <div class="field-error">{{ $errors->updateOrder->first('user_id') }}</div>
                                        @endif
                                    </div>

                                    <div class="field field--full">
                                        <label for="order-product-select">Товар</label>
                                        <select id="order-product-select" name="product_id" data-create-order-product-select required>
                                            @foreach ($catalogOptions as $product)
                                                <option value="{{ $product->id }}" data-name="{{ $product->name }}" data-image="{{ $product->image ?? '' }}" data-description="{{ $product->description ?? '' }}" data-price="{{ number_format($product->price, 0, ',', ' ') }} ₽" data-unit-label="{{ $product->unit_mode === 'packs' ? 'упаковок' : 'шт.' }}" data-unit-details="{{ $product->unitDetailsLabel() ?? '' }}" @selected((string) old('product_id') === (string) $product->id)>{{ $product->name }} · {{ $product->sku }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->createOrder->has('product_id'))
                                            <div class="field-error">{{ $errors->createOrder->first('product_id') }}</div>
                                        @elseif ($errors->updateOrder->has('product_id'))
                                            <div class="field-error">{{ $errors->updateOrder->first('product_id') }}</div>
                                        @endif
                                    </div>

                                    <div class="field">
                                        <label for="order-quantity">Количество</label>
                                        <select id="order-quantity" name="quantity" data-order-quantity-select required>
                                            @for ($qty = 1; $qty <= 10; $qty++)
                                                <option value="{{ $qty }}" @selected((string) old('quantity', '1') === (string) $qty)>{{ $qty }}</option>
                                            @endfor
                                        </select>
                                        @if ($errors->createOrder->has('quantity'))
                                            <div class="field-error">{{ $errors->createOrder->first('quantity') }}</div>
                                        @elseif ($errors->updateOrder->has('quantity'))
                                            <div class="field-error">{{ $errors->updateOrder->first('quantity') }}</div>
                                        @endif
                                    </div>

                                    <div class="field">
                                        <label for="order-status">Статус</label>
                                        <select id="order-status" name="status" data-order-modal-status-select required>
                                            <option value="forming" @selected(old('status', 'forming') === 'forming')>Формируем заказ</option>
                                            <option value="shipping" @selected(old('status') === 'shipping')>В доставке</option>
                                            <option value="delivered" @selected(old('status') === 'delivered')>Доставлено</option>
                                        </select>
                                        @if ($errors->createOrder->has('status'))
                                            <div class="field-error">{{ $errors->createOrder->first('status') }}</div>
                                        @elseif ($errors->updateOrder->has('status'))
                                            <div class="field-error">{{ $errors->updateOrder->first('status') }}</div>
                                        @endif
                                    </div>

                                    <div class="field field--full">
                                        <label>Предпросмотр товара</label>
                                        <div class="product-preview" data-create-order-preview>
                                            <div class="product-preview-placeholder" data-create-order-image-wrap>
                                                <svg width="34" height="34" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                                    <path d="M4 6h16v12H4z" stroke="currentColor" stroke-width="1.5"/>
                                                    <path d="M7 15l3-3 2 2 4-4 2 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                            </div>
                                            <div class="product-preview-info">
                                                <div class="product-preview-name" data-create-order-name>Выберите товар</div>
                                                <div class="product-preview-desc" data-create-order-description>Описание и цена подтягиваются автоматически из каталога.</div>
                                                <div class="product-preview-price">
                                                    <strong data-create-order-price>—</strong>
                                                </div>
                                                <div class="product-preview-unit" data-create-order-unit>Количество и единица измерения будут указаны в заявке.</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal-actions">
                                    <button type="button" class="secondary-button" data-close-order-modal>Отмена</button>
                                    <button type="submit" class="primary-button" data-order-submit-button>Создать заявку</button>
                                </div>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="products-shell">
                        <div class="products-toolbar">
                            <h2 class="products-title">Список товаров</h2>
                            <div class="toolbar-actions">
                                <button type="button" class="secondary-button" data-open-import-modal>Импорт из Excel</button>
                                <button type="button" class="primary-button" data-open-create-modal>Создать товар</button>
                            </div>
                        </div>

                        <form method="get" action="{{ route('admin.dashboard') }}" class="products-filters">
                            <input type="hidden" name="section" value="products">
                            <input
                                type="text"
                                name="search"
                                value="{{ $productSearch }}"
                                class="filter-input"
                                placeholder="Поиск по названию или артикулу"
                            >
                            <select name="category" class="filter-select" data-product-category-filter>
                                <option value="">Все категории</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" @selected((string) $productCategory === (string) $category->id)>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="primary-button">Найти</button>
                            <a href="{{ route('admin.dashboard', ['section' => 'products']) }}" class="secondary-button filter-reset-button">Сбросить</a>
                        </form>

                        @if ($products->isEmpty())
                            <div class="empty-box">По текущему фильтру товары не найдены. Попробуйте изменить поиск, категорию или создайте новую позицию.</div>
                        @else
                            <div class="products-table-wrap">
                                <table class="products-table">
                                    <thead>
                                        <tr>
                                            <th>Товар</th>
                                            <th>Артикул</th>
                                            <th>Категория</th>
                                            <th>Цена</th>
                                            <th>Остаток</th>
                                            <th>Статус</th>
                                            <th>Действия</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($products as $product)
                                            <tr data-edit-modal-id="edit-product-{{ $product->id }}">
                                                <td>
                                                    <div class="table-product-cell">
                                                        @if ($product->image)
                                                            <div class="table-product-image">
                                                                <img src="{{ $product->image }}" alt="{{ $product->name }}">
                                                            </div>
                                                        @else
                                                            <div class="table-product-placeholder" aria-hidden="true">
                                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                                    <rect x="4" y="5" width="16" height="14" rx="3" stroke="currentColor" stroke-width="1.6"/>
                                                                    <circle cx="9" cy="10" r="1.5" fill="currentColor"/>
                                                                    <path d="M7 16l3.2-3.2a1 1 0 0 1 1.4 0L14 15l1.6-1.6a1 1 0 0 1 1.4 0L19 15.4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                                                                </svg>
                                                            </div>
                                                        @endif
                                                        <div>
                                                            <div class="table-product-name">{{ $product->name }}</div>
                                                            <div class="table-product-desc">{{ $product->description ?: 'Без описания' }}</div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td><strong>{{ $product->sku }}</strong></td>
                                                <td>{{ $product->category?->name ?? 'Без категории' }}</td>
                                                <td>{{ number_format($product->price, 0, ',', ' ') }} ₽ / {{ $product->unitShortLabel() }}</td>
                                                <td>
                                                    {{ $product->stockLabel() }}
                                                    @if ($product->unitDetailsLabel())
                                                        <div class="table-product-desc">{{ $product->unitDetailsLabel() }}</div>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="table-chips">
                                                        <span class="table-chip{{ $product->is_visible ? '' : ' table-chip--hidden' }}">
                                                            {{ $product->is_visible ? 'Виден' : 'Скрыт' }}
                                                        </span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="table-actions" data-actions-menu>
                                                        <button
                                                            type="button"
                                                            class="table-actions-trigger"
                                                            data-actions-trigger
                                                            aria-haspopup="true"
                                                            aria-expanded="false"
                                                            aria-label="Действия с товаром"
                                                        >
                                                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                                                <circle cx="5" cy="12" r="1.8" fill="currentColor"/>
                                                                <circle cx="12" cy="12" r="1.8" fill="currentColor"/>
                                                                <circle cx="19" cy="12" r="1.8" fill="currentColor"/>
                                                            </svg>
                                                        </button>
                                                        <div class="table-actions-menu" role="menu">
                                                            <button type="button" class="table-action-item" data-open-edit-modal="edit-product-{{ $product->id }}" role="menuitem">Редактировать</button>
                                                            <form action="{{ route('admin.products.visibility', $product) }}" method="post">
                                                                @csrf
                                                                @method('PATCH')
                                                                <input type="hidden" name="is_visible" value="{{ $product->is_visible ? 0 : 1 }}">
                                                                <button type="submit" class="table-action-item" role="menuitem">{{ $product->is_visible ? 'Скрыть в каталоге' : 'Показать в каталоге' }}</button>
                                                            </form>
                                                            <form action="{{ route('admin.products.destroy', $product) }}" method="post">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="table-action-item table-action-item--danger" role="menuitem">Удалить</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                @endif
            </section>
        </main>
    </div>

    @if ($selectedSection === 'products')
        <div class="modal-backdrop" id="import-products-modal" aria-hidden="true">
            <div class="modal-card product-modal-card" role="dialog" aria-modal="true" aria-labelledby="import-products-title">
                <div class="modal-header">
                    <div>
                        <h2 id="import-products-title">Импорт товаров</h2>
                        <p>Загрузите Excel или CSV-файл. Если товар с таким артикулом уже есть, он обновится, а новая позиция создастся автоматически.</p>
                    </div>
                    <button type="button" class="icon-button" data-close-import-modal aria-label="Закрыть окно">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M5 5L19 19M19 5L5 19" stroke="#3A4048" stroke-width="1.8" stroke-linecap="round"/>
                        </svg>
                    </button>
                </div>

                <form action="{{ route('admin.products.import') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="product-form-grid">
                        <div class="field field--full">
                            <label for="import-file">Файл</label>
                            <input id="import-file" type="file" name="file" accept=".xlsx,.csv,.txt" required>
                            <div class="field-note">Поддерживаются файлы `.xlsx`, `.csv`, `.txt` до 10 МБ.</div>
                            @if ($errors->importProducts->has('file'))
                                <div class="field-error">{{ $errors->importProducts->first('file') }}</div>
                            @endif
                        </div>

                        <div class="field field--full">
                            <label>Поддерживаемые колонки</label>
                            <ul class="import-format">
                                <li><strong>Обязательные:</strong> Название, Артикул</li>
                                <li><strong>Дополнительные:</strong> Категория, Цена, Остаток, Единица, Множитель, Описание, Видимость, Фото</li>
                                <li><strong>Для колонки Фото:</strong> можно указать `https://...`, `/storage/product-images/file.jpg`, `product-images/file.jpg` или просто `file.jpg`</li>
                                <li><strong>Можно и на английском:</strong> `name`, `sku`, `category`, `price`, `stock_quantity`, `unit`, `unit_mode`, `unit_multiplier`, `multiplier`, `description`, `is_visible`, `image`, `photo`</li>
                            </ul>
                        </div>
                    </div>

                    <div class="modal-actions">
                        <button type="button" class="secondary-button" data-close-import-modal>Отмена</button>
                        <button type="submit" class="primary-button">Загрузить файл</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="modal-backdrop" id="create-product-modal" aria-hidden="true">
            <div class="modal-card product-modal-card" role="dialog" aria-modal="true" aria-labelledby="create-product-title">
                <div class="modal-header">
                    <div>
                        <h2 id="create-product-title">Создать товар</h2>
                        <p>Заполните основные поля нового товара. После сохранения он сразу появится в таблице.</p>
                    </div>
                    <button type="button" class="icon-button" data-close-create-modal aria-label="Закрыть окно">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M5 5L19 19M19 5L5 19" stroke="#3A4048" stroke-width="1.8" stroke-linecap="round"/>
                        </svg>
                    </button>
                </div>

                <form action="{{ route('admin.products.store') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="product-form-grid">
                        <div class="field">
                            <label for="create-name">Название</label>
                            <input id="create-name" type="text" name="name" value="{{ old('name') }}" required>
                        </div>

                        <div class="field">
                            <label for="create-sku">Артикул</label>
                            <input id="create-sku" type="text" name="sku" value="{{ old('sku') }}" required>
                        </div>

                        <div class="field">
                            <label for="create-category">Категория</label>
                            <select id="create-category" name="category_id">
                                <option value="">Без категории</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="field">
                            <label for="create-price">Цена, ₽</label>
                            <input id="create-price" type="number" min="0" name="price" value="{{ old('price', 0) }}" required>
                        </div>

                        <div class="field">
                            <label for="create-stock">Остаток</label>
                            <input id="create-stock" type="number" min="0" name="stock_quantity" value="{{ old('stock_quantity', 0) }}" required>
                        </div>

                        <div class="field">
                            <label for="create-unit-mode">Единица продажи</label>
                            <select id="create-unit-mode" name="unit_mode">
                                <option value="pieces" @selected(old('unit_mode', 'pieces') === 'pieces')>Штуки</option>
                                <option value="packs" @selected(old('unit_mode') === 'packs')>Упаковки</option>
                            </select>
                        </div>

                        <div class="field">
                            <label for="create-unit-multiplier">Множитель</label>
                            <input id="create-unit-multiplier" type="number" min="1" name="unit_multiplier" value="{{ old('unit_multiplier', 1) }}" required>
                            <div class="field-note">Если выбраны упаковки, укажите сколько штук в одной упаковке. Для штук оставьте `1`.</div>
                        </div>

                        <div class="field">
                            <label for="create-image">Фотография товара</label>
                            <input id="create-image" type="file" name="image" accept="image/*">
                            <div class="field-note">Можно загрузить новый файл или выбрать уже загруженное изображение ниже.</div>
                        </div>

                        <div class="field field--full">
                            <label>Библиотека загруженных изображений</label>
                            @if ($productImageLibrary->isNotEmpty())
                                <div class="image-library">
                                    <label class="image-library-option">
                                        <input type="radio" name="existing_image" value="" @checked(old('existing_image', '') === '')>
                                        <span class="image-library-empty">Не выбирать из библиотеки</span>
                                    </label>
                                    @foreach ($productImageLibrary as $libraryImage)
                                        <label class="image-library-option">
                                            <input type="radio" name="existing_image" value="{{ $libraryImage['url'] }}" @checked(old('existing_image') === $libraryImage['url'])>
                                            <span class="image-library-card">
                                                <img src="{{ $libraryImage['url'] }}" alt="{{ $libraryImage['name'] }}">
                                                <span class="image-library-name">{{ $libraryImage['name'] }}</span>
                                            </span>
                                        </label>
                                    @endforeach
                                </div>
                            @else
                                <div class="field-note">Пока нет загруженных изображений. Сначала загрузите хотя бы одну фотографию товара.</div>
                            @endif
                        </div>

                        <div class="field field--full">
                            <label for="create-description">Описание</label>
                            <textarea id="create-description" name="description">{{ old('description') }}</textarea>
                        </div>

                        <div class="field field--full">
                            <label>Видимость на сайте</label>
                            <div class="toggle-row">
                                <label><input type="radio" name="is_visible" value="1" @checked(old('is_visible', '1') == '1')> Показывать</label>
                                <label><input type="radio" name="is_visible" value="0" @checked(old('is_visible') == '0')> Скрыть</label>
                            </div>
                        </div>
                    </div>

                    <div class="modal-actions">
                        <button type="button" class="secondary-button" data-close-create-modal>Отмена</button>
                        <button type="submit" class="primary-button">Создать товар</button>
                    </div>
                </form>
            </div>
        </div>

        @foreach ($products as $product)
            <div class="modal-backdrop" id="edit-product-{{ $product->id }}" aria-hidden="true">
                <div class="modal-card product-modal-card" role="dialog" aria-modal="true" aria-labelledby="edit-product-title-{{ $product->id }}">
                    <div class="modal-header">
                        <div>
                            <h2 id="edit-product-title-{{ $product->id }}">Редактировать товар</h2>
                            <p>зменения сохранятся в базу и сразу отразятся в каталоге и в админке.</p>
                        </div>
                        <button type="button" class="icon-button" data-close-edit-modal="edit-product-{{ $product->id }}" aria-label="Закрыть окно">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <path d="M5 5L19 19M19 5L5 19" stroke="#3A4048" stroke-width="1.8" stroke-linecap="round"/>
                            </svg>
                        </button>
                    </div>

                    <form action="{{ route('admin.products.update', $product) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="product-form-grid">
                            <div class="field">
                                <label for="name-{{ $product->id }}">Название</label>
                                <input id="name-{{ $product->id }}" type="text" name="name" value="{{ $product->name }}" required>
                            </div>

                            <div class="field">
                                <label for="sku-{{ $product->id }}">Артикул</label>
                                <input id="sku-{{ $product->id }}" type="text" name="sku" value="{{ $product->sku }}" required>
                            </div>

                            <div class="field">
                                <label for="category-{{ $product->id }}">Категория</label>
                                <select id="category-{{ $product->id }}" name="category_id">
                                    <option value="">Без категории</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" @selected((string) $product->category_id === (string) $category->id)>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="field">
                                <label for="price-{{ $product->id }}">Цена, ₽</label>
                                <input id="price-{{ $product->id }}" type="number" min="0" name="price" value="{{ $product->price }}" required>
                            </div>

                            <div class="field">
                                <label for="stock-{{ $product->id }}">Остаток</label>
                                <input id="stock-{{ $product->id }}" type="number" min="0" name="stock_quantity" value="{{ $product->stock_quantity }}" required>
                            </div>

                            <div class="field">
                                <label for="unit-mode-{{ $product->id }}">Единица продажи</label>
                                <select id="unit-mode-{{ $product->id }}" name="unit_mode">
                                    <option value="pieces" @selected($product->unit_mode === 'pieces')>Штуки</option>
                                    <option value="packs" @selected($product->unit_mode === 'packs')>Упаковки</option>
                                </select>
                            </div>

                            <div class="field">
                                <label for="unit-multiplier-{{ $product->id }}">Множитель</label>
                                <input id="unit-multiplier-{{ $product->id }}" type="number" min="1" name="unit_multiplier" value="{{ $product->unit_multiplier }}" required>
                                <div class="field-note">Если выбраны упаковки, укажите сколько штук в одной упаковке. Для штук оставьте `1`.</div>
                            </div>

                            <div class="field">
                                <label for="image-{{ $product->id }}">Новое фото товара</label>
                                <input id="image-{{ $product->id }}" type="file" name="image" accept="image/*">
                                @if ($product->image)
                                    <div class="field-note">Текущее изображение: {{ $product->image }}</div>
                                @endif
                                <div class="field-note">Можно загрузить новый файл или выбрать изображение из библиотеки ниже.</div>
                            </div>

                            <div class="field field--full">
                                <label>Библиотека загруженных изображений</label>
                                @if ($productImageLibrary->isNotEmpty())
                                    <div class="image-library">
                                        <label class="image-library-option">
                                            <input type="radio" name="existing_image" value="" @checked(! $product->image || ! $productImageLibrary->contains(fn ($libraryImage) => $libraryImage['url'] === $product->image))>
                                            <span class="image-library-empty">Оставить текущее изображение без замены</span>
                                        </label>
                                        @foreach ($productImageLibrary as $libraryImage)
                                            <label class="image-library-option">
                                                <input type="radio" name="existing_image" value="{{ $libraryImage['url'] }}" @checked($product->image === $libraryImage['url'])>
                                                <span class="image-library-card">
                                                    <img src="{{ $libraryImage['url'] }}" alt="{{ $libraryImage['name'] }}">
                                                    <span class="image-library-name">{{ $libraryImage['name'] }}</span>
                                                </span>
                                            </label>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="field-note">В библиотеке пока нет загруженных изображений.</div>
                                @endif
                            </div>

                            <div class="field field--full">
                                <label for="description-{{ $product->id }}">Описание</label>
                                <textarea id="description-{{ $product->id }}" name="description">{{ $product->description }}</textarea>
                            </div>

                            <div class="field field--full">
                                <label>Аналоги</label>
                                <div class="analog-settings" data-analog-editor data-product-id="{{ $product->id }}">
                                    <div class="analog-mode-row">
                                        <label><input type="radio" name="analog_mode" value="automatic" @checked(($product->analog_mode ?? 'automatic') === 'automatic') data-analog-mode> Автоматически</label>
                                        <label><input type="radio" name="analog_mode" value="manual" @checked(($product->analog_mode ?? 'automatic') === 'manual') data-analog-mode> Вручную</label>
                                    </div>
                                    <div class="field-note">Автоматический режим показывает товары из той же категории. В ручном режиме можно выбрать до 10 конкретных аналогов и задать порядок показа.</div>

                                    <div class="analog-manual-panel" data-analog-manual-panel @if (($product->analog_mode ?? 'automatic') !== 'manual') hidden @endif>
                                        <div class="analog-search-grid">
                                            <div class="field">
                                                <label for="analog-search-{{ $product->id }}">Поиск по названию или артикулу</label>
                                                <input id="analog-search-{{ $product->id }}" type="text" placeholder="Начните вводить название или SKU" data-analog-search>
                                            </div>
                                            <div class="field">
                                                <label for="analog-select-{{ $product->id }}">Товар</label>
                                                <select id="analog-select-{{ $product->id }}" data-analog-select>
                                                    <option value="">Выберите товар</option>
                                                    @foreach ($catalogOptions as $analogOption)
                                                        @continue($analogOption->id === $product->id)
                                                        <option value="{{ $analogOption->id }}" data-name="{{ $analogOption->name }}" data-sku="{{ $analogOption->sku }}">{{ $analogOption->name }} · {{ $analogOption->sku }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <button type="button" class="primary-button" data-analog-add>Добавить</button>
                                        </div>

                                        <div class="analog-limit" data-analog-limit>Выбрано 0 из 10.</div>

                                        <div class="analog-selected-list" data-analog-selected-list>
                                            @foreach ($product->manualAnalogs as $manualAnalog)
                                                <div class="analog-selected-item" data-analog-selected-item data-id="{{ $manualAnalog->id }}" data-name="{{ $manualAnalog->name }}" data-sku="{{ $manualAnalog->sku }}">
                                                    <div class="analog-selected-main">
                                                        <div class="analog-selected-title">{{ $manualAnalog->name }}</div>
                                                        <div class="analog-selected-meta">{{ $manualAnalog->sku }}</div>
                                                    </div>
                                                    <div class="analog-selected-actions">
                                                        <button type="button" class="analog-chip-button" data-analog-up aria-label="Поднять выше">↑</button>
                                                        <button type="button" class="analog-chip-button" data-analog-down aria-label="Опустить ниже">↓</button>
                                                        <button type="button" class="analog-chip-button" data-analog-remove aria-label="Удалить">Удалить</button>
                                                    </div>
                                                    <input type="hidden" name="manual_analog_ids[]" value="{{ $manualAnalog->id }}">
                                                </div>
                                            @endforeach
                                        </div>

                                        <template data-analog-item-template>
                                            <div class="analog-selected-item" data-analog-selected-item>
                                                <div class="analog-selected-main">
                                                    <div class="analog-selected-title"></div>
                                                    <div class="analog-selected-meta"></div>
                                                </div>
                                                <div class="analog-selected-actions">
                                                    <button type="button" class="analog-chip-button" data-analog-up aria-label="Поднять выше">↑</button>
                                                    <button type="button" class="analog-chip-button" data-analog-down aria-label="Опустить ниже">↓</button>
                                                    <button type="button" class="analog-chip-button" data-analog-remove aria-label="Удалить">Удалить</button>
                                                </div>
                                                <input type="hidden" name="manual_analog_ids[]">
                                            </div>
                                        </template>

                                        <div class="analog-empty" data-analog-empty @if ($product->manualAnalogs->isNotEmpty()) hidden @endif>Пока не выбраны ручные аналоги.</div>
                                    </div>
                                </div>
                            </div>

                            <div class="field field--full">
                                <label>Видимость на сайте</label>
                                <div class="toggle-row">
                                    <label><input type="radio" name="is_visible" value="1" @checked($product->is_visible)> Показывать</label>
                                    <label><input type="radio" name="is_visible" value="0" @checked(! $product->is_visible)> Скрыть</label>
                                </div>
                            </div>
                        </div>

                        <div class="modal-actions">
                            <button type="button" class="secondary-button" data-close-edit-modal="edit-product-{{ $product->id }}">Отмена</button>
                            <button type="submit" class="primary-button">Сохранить изменения</button>
                        </div>
                    </form>
                </div>
            </div>
        @endforeach
    @endif

    @if ($selectedSection === 'orders')
        <script>
            (function () {
                var modal = document.getElementById('create-order-modal');
                var openButton = document.querySelector('[data-open-order-modal]');
                var productSelect = document.querySelector('[data-create-order-product-select]');
                var managerSelect = document.querySelector('[data-order-manager-select]');
                var quantitySelect = document.querySelector('[data-order-quantity-select]');
                var statusSelect = document.querySelector('[data-order-modal-status-select]');
                var orderIdInput = document.querySelector('[data-order-id-input]');
                var modalTitle = document.querySelector('[data-order-modal-title]');
                var modalDescription = document.querySelector('[data-order-modal-description]');
                var submitButton = document.querySelector('[data-order-submit-button]');
                var orderForm = document.querySelector('[data-order-form]');
                var orderFormMethod = document.querySelector('[data-order-form-method]');
                var currentOrderIdInput = document.querySelector('[data-order-current-id]');

                if (!modal || !openButton || !productSelect || !managerSelect || !quantitySelect || !statusSelect || !orderIdInput || !modalTitle || !modalDescription || !submitButton || !orderForm || !orderFormMethod || !currentOrderIdInput) {
                    return;
                }

                function openModal() {
                    modal.classList.add('is-open');
                    modal.setAttribute('aria-hidden', 'false');
                }

                function closeModal() {
                    modal.classList.remove('is-open');
                    modal.setAttribute('aria-hidden', 'true');
                }

                function updateProductPreview() {
                    var selectedOption = productSelect.options[productSelect.selectedIndex];
                    var imageWrap = document.querySelector('[data-create-order-image-wrap]');
                    var nameNode = document.querySelector('[data-create-order-name]');
                    var descNode = document.querySelector('[data-create-order-description]');
                    var priceNode = document.querySelector('[data-create-order-price]');
                    var unitNode = document.querySelector('[data-create-order-unit]');

                    var image = selectedOption.dataset.image || '';
                    var name = selectedOption.dataset.name || '';
                    var description = selectedOption.dataset.description || 'Описание товара появится после выбора позиции.';
                    var price = selectedOption.dataset.price || '—';
                    var unitLabel = selectedOption.dataset.unitLabel || 'шт.';
                    var unitDetails = selectedOption.dataset.unitDetails || 'Можно выбрать количество ниже.';

                    if (imageWrap) {
                        imageWrap.innerHTML = image
                            ? '<img src="' + image + '" alt="' + name.replace(/"/g, '&quot;') + '">'
                            : '<svg width="34" height="34" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M4 6h16v12H4z" stroke="currentColor" stroke-width="1.5"/><path d="M7 15l3-3 2 2 4-4 2 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>';
                        imageWrap.className = image ? 'product-preview-image' : 'product-preview-placeholder';
                        imageWrap.setAttribute('data-product-preview-image-wrap', '');
                    }

                    if (nameNode) nameNode.textContent = name;
                    if (descNode) descNode.textContent = description;
                    if (priceNode) priceNode.textContent = price;
                    if (unitNode) unitNode.textContent = unitDetails || ('Единица продажи: ' + unitLabel);
                }

                function fillCreateMode() {
                    orderForm.dataset.mode = 'create';
                    orderForm.action = orderForm.dataset.createAction;
                    orderFormMethod.value = 'POST';
                    currentOrderIdInput.value = '';
                    modalTitle.textContent = 'Создать заявку';
                    modalDescription.textContent = 'Создайте заявку, выберите клиента, товар, количество и статус заказа.';
                    submitButton.textContent = 'Создать заявку';
                    orderIdInput.value = '';
                    orderIdInput.placeholder = 'Будет присвоен после создания';
                    managerSelect.selectedIndex = 0;
                    productSelect.selectedIndex = 0;
                    quantitySelect.value = '1';
                    statusSelect.value = 'forming';
                    updateProductPreview();
                }

                function fillEditMode(row) {
                    orderForm.dataset.mode = 'edit';
                    orderForm.action = row.dataset.orderUpdateUrl || orderForm.dataset.createAction;
                    orderFormMethod.value = 'PUT';
                    currentOrderIdInput.value = row.dataset.orderId || '';
                    modalTitle.textContent = 'Редактировать заявку';
                    modalDescription.textContent = 'Измените параметры заявки. Сохранение изменений будет подключено следующим шагом.';
                    submitButton.textContent = 'Сохранить изменения';
                    orderIdInput.value = row.dataset.orderId || '';
                    managerSelect.value = row.dataset.orderManager || managerSelect.options[0].value;
                    productSelect.value = row.dataset.orderProductId || productSelect.options[0].value;
                    quantitySelect.value = row.dataset.orderQuantity || '1';
                    statusSelect.value = row.dataset.orderStatus || 'forming';
                    updateProductPreview();
                }

                function closeAllActionMenus() {
                    document.querySelectorAll('[data-actions-menu].is-open').forEach(function (menu) {
                        menu.classList.remove('is-open');
                        var trigger = menu.querySelector('[data-actions-trigger]');
                        if (trigger) {
                            trigger.setAttribute('aria-expanded', 'false');
                        }
                    });
                }

                openButton.addEventListener('click', function () {
                    fillCreateMode();
                    openModal();
                });

                document.querySelectorAll('[data-close-order-modal]').forEach(function (button) {
                    button.addEventListener('click', closeModal);
                });

                modal.addEventListener('click', function (event) {
                    if (event.target === modal) {
                        closeModal();
                    }
                });

                document.addEventListener('keydown', function (event) {
                    if (event.key === 'Escape' && modal.classList.contains('is-open')) {
                        closeModal();
                    }

                    if (event.key === 'Escape') {
                        closeAllActionMenus();
                    }
                });

                productSelect.addEventListener('change', updateProductPreview);
                updateProductPreview();

                document.querySelectorAll('[data-actions-trigger]').forEach(function (button) {
                    button.addEventListener('click', function (event) {
                        event.stopPropagation();
                        var menu = button.closest('[data-actions-menu]');
                        var shouldOpen = menu && !menu.classList.contains('is-open');

                        closeAllActionMenus();

                        if (shouldOpen && menu) {
                            menu.classList.add('is-open');
                            button.setAttribute('aria-expanded', 'true');
                        }
                    });
                });

                document.addEventListener('click', function (event) {
                    if (!event.target.closest('[data-actions-menu]')) {
                        closeAllActionMenus();
                    }
                });

                document.querySelectorAll('[data-edit-order]').forEach(function (button) {
                    button.addEventListener('click', function (event) {
                        event.stopPropagation();
                        var row = button.closest('tr[data-order-row]');
                        closeAllActionMenus();
                        if (!row) {
                            return;
                        }

                        fillEditMode(row);
                        openModal();
                    });
                });

                document.querySelectorAll('.products-table tbody tr').forEach(function (row) {
                    row.addEventListener('click', function (event) {
                        if (event.target.closest('[data-actions-menu]') || event.target.closest('[data-order-status-control]')) {
                            return;
                        }

                        fillEditMode(row);
                        openModal();
                    });
                });

                if ({{ $errors->createOrder->isNotEmpty() ? 'true' : 'false' }}) {
                    orderForm.dataset.mode = 'create';
                    modalTitle.textContent = 'Создать заявку';
                    modalDescription.textContent = 'Исправьте ошибки в форме и отправьте заявку снова.';
                    submitButton.textContent = 'Создать заявку';
                    openModal();
                    updateProductPreview();
                }

                if ({{ $errors->updateOrder->isNotEmpty() ? 'true' : 'false' }}) {
                    var failedOrderRow = document.querySelector('tr[data-order-row][data-order-id="{{ old('order_id') }}"]');
                    if (failedOrderRow) {
                        fillEditMode(failedOrderRow);
                    } else {
                        fillCreateMode();
                    }
                    modalDescription.textContent = 'РСЃРїСЂР°РІСЊС‚Рµ РѕС€РёР±РєРё РІ С„РѕСЂРјРµ Рё СЃРѕС…СЂР°РЅРёС‚Рµ РёР·РјРµРЅРµРЅРёСЏ РµС‰Рµ СЂР°Р·.';
                    openModal();
                    updateProductPreview();
                }
            })();
        </script>
    @endif

    @if ($selectedSection === 'products')
        <script>
            (function () {
                var modal = document.getElementById('create-product-modal');
                var openButton = document.querySelector('[data-open-create-modal]');
                var importModal = document.getElementById('import-products-modal');
                var importOpenButton = document.querySelector('[data-open-import-modal]');

                function openModal() {
                    if (!modal) {
                        return;
                    }

                    modal.classList.add('is-open');
                    modal.setAttribute('aria-hidden', 'false');
                }

                function closeModal() {
                    if (!modal) {
                        return;
                    }

                    modal.classList.remove('is-open');
                    modal.setAttribute('aria-hidden', 'true');
                }

                function openImportModal() {
                    if (!importModal) {
                        return;
                    }

                    importModal.classList.add('is-open');
                    importModal.setAttribute('aria-hidden', 'false');
                }

                function closeImportModal() {
                    if (!importModal) {
                        return;
                    }

                    importModal.classList.remove('is-open');
                    importModal.setAttribute('aria-hidden', 'true');
                }

                if (openButton) {
                    openButton.addEventListener('click', openModal);
                }

                if (importOpenButton) {
                    importOpenButton.addEventListener('click', openImportModal);
                }

                document.querySelectorAll('[data-close-create-modal]').forEach(function (button) {
                    button.addEventListener('click', closeModal);
                });

                document.querySelectorAll('[data-close-import-modal]').forEach(function (button) {
                    button.addEventListener('click', closeImportModal);
                });

                if (modal) {
                    modal.addEventListener('click', function (event) {
                        if (event.target === modal) {
                            closeModal();
                        }
                    });
                }

                if (importModal) {
                    importModal.addEventListener('click', function (event) {
                        if (event.target === importModal) {
                            closeImportModal();
                        }
                    });
                }

                function openNamedModal(modalId) {
                    var targetModal = modalId ? document.getElementById(modalId) : null;
                    if (!targetModal) {
                        return;
                    }

                    targetModal.classList.add('is-open');
                    targetModal.setAttribute('aria-hidden', 'false');
                }

                function closeNamedModal(modalId) {
                    var targetModal = modalId ? document.getElementById(modalId) : null;
                    if (!targetModal) {
                        return;
                    }

                    targetModal.classList.remove('is-open');
                    targetModal.setAttribute('aria-hidden', 'true');
                }

                document.querySelectorAll('[data-open-edit-modal]').forEach(function (button) {
                    button.addEventListener('click', function () {
                        openNamedModal(button.getAttribute('data-open-edit-modal'));
                        closeAllActionMenus();
                    });
                });

                document.querySelectorAll('.products-table tbody tr[data-edit-modal-id]').forEach(function (row) {
                    row.addEventListener('click', function (event) {
                        if (
                            event.target.closest('[data-actions-menu]') ||
                            event.target.closest('button') ||
                            event.target.closest('a') ||
                            event.target.closest('input') ||
                            event.target.closest('select') ||
                            event.target.closest('textarea') ||
                            event.target.closest('form')
                        ) {
                            return;
                        }

                        openNamedModal(row.getAttribute('data-edit-modal-id'));
                    });
                });

                document.querySelectorAll('[data-close-edit-modal]').forEach(function (button) {
                    button.addEventListener('click', function () {
                        closeNamedModal(button.getAttribute('data-close-edit-modal'));
                    });
                });

                document.querySelectorAll('.modal-backdrop[id^="edit-product-"]').forEach(function (editModal) {
                    editModal.addEventListener('click', function (event) {
                        if (event.target === editModal) {
                            closeNamedModal(editModal.id);
                        }
                    });
                });

                function closeAllActionMenus() {
                    document.querySelectorAll('[data-actions-menu].is-open').forEach(function (menu) {
                        menu.classList.remove('is-open');
                        var trigger = menu.querySelector('[data-actions-trigger]');
                        if (trigger) {
                            trigger.setAttribute('aria-expanded', 'false');
                        }
                    });
                }

                document.querySelectorAll('[data-actions-trigger]').forEach(function (button) {
                    button.addEventListener('click', function (event) {
                        event.stopPropagation();
                        var menu = button.closest('[data-actions-menu]');
                        var shouldOpen = menu && !menu.classList.contains('is-open');

                        closeAllActionMenus();

                        if (shouldOpen && menu) {
                            menu.classList.add('is-open');
                            button.setAttribute('aria-expanded', 'true');
                        }
                    });
                });

                document.addEventListener('click', function (event) {
                    if (!event.target.closest('[data-actions-menu]')) {
                        closeAllActionMenus();
                    }
                });

                document.addEventListener('keydown', function (event) {
                    if (event.key === 'Escape') {
                        closeAllActionMenus();
                    }
                });

                var categoryFilter = document.querySelector('[data-product-category-filter]');
                if (categoryFilter && categoryFilter.form) {
                    categoryFilter.addEventListener('change', function () {
                        categoryFilter.form.submit();
                    });
                }

                document.querySelectorAll('[data-analog-editor]').forEach(function (editor) {
                    var modeInputs = editor.querySelectorAll('[data-analog-mode]');
                    var manualPanel = editor.querySelector('[data-analog-manual-panel]');
                    var searchInput = editor.querySelector('[data-analog-search]');
                    var select = editor.querySelector('[data-analog-select]');
                    var addButton = editor.querySelector('[data-analog-add]');
                    var selectedList = editor.querySelector('[data-analog-selected-list]');
                    var emptyState = editor.querySelector('[data-analog-empty]');
                    var limitLabel = editor.querySelector('[data-analog-limit]');
                    var template = editor.querySelector('[data-analog-item-template]');
                    var maxItems = 10;

                    if (!manualPanel || !select || !addButton || !selectedList || !emptyState || !limitLabel || !template) {
                        return;
                    }

                    function getItems() {
                        return Array.prototype.slice.call(selectedList.querySelectorAll('[data-analog-selected-item]'));
                    }

                    function updateMoveButtons() {
                        var items = getItems();
                        items.forEach(function (item, index) {
                            var upButton = item.querySelector('[data-analog-up]');
                            var downButton = item.querySelector('[data-analog-down]');

                            if (upButton) {
                                upButton.disabled = index === 0;
                            }

                            if (downButton) {
                                downButton.disabled = index === items.length - 1;
                            }
                        });
                    }

                    function updateEmptyState() {
                        emptyState.hidden = getItems().length > 0;
                    }

                    function updateLimitLabel() {
                        var count = getItems().length;
                        limitLabel.textContent = 'Выбрано ' + count + ' из ' + maxItems + '.';
                        limitLabel.classList.toggle('is-danger', count >= maxItems);
                    }

                    function toggleManualPanel() {
                        var mode = editor.querySelector('[data-analog-mode]:checked');
                        manualPanel.hidden = !mode || mode.value !== 'manual';
                    }

                    function updateAddButtonState() {
                        var selectedOption = select.options[select.selectedIndex];
                        addButton.disabled = !selectedOption || !selectedOption.value || getItems().length >= maxItems;
                    }

                    function syncState() {
                        updateMoveButtons();
                        updateEmptyState();
                        updateLimitLabel();
                        filterOptions(searchInput ? searchInput.value : '');
                        updateAddButtonState();
                        toggleManualPanel();
                    }

                    function hasSelectedProduct(productId) {
                        return getItems().some(function (item) {
                            return item.getAttribute('data-id') === String(productId);
                        });
                    }

                    function attachItemHandlers(item) {
                        var removeButton = item.querySelector('[data-analog-remove]');
                        var upButton = item.querySelector('[data-analog-up]');
                        var downButton = item.querySelector('[data-analog-down]');

                        if (removeButton) {
                            removeButton.addEventListener('click', function () {
                                item.remove();
                                syncState();
                            });
                        }

                        if (upButton) {
                            upButton.addEventListener('click', function () {
                                var previous = item.previousElementSibling;
                                if (previous) {
                                    selectedList.insertBefore(item, previous);
                                    syncState();
                                }
                            });
                        }

                        if (downButton) {
                            downButton.addEventListener('click', function () {
                                var next = item.nextElementSibling;
                                if (next) {
                                    selectedList.insertBefore(next, item);
                                    syncState();
                                }
                            });
                        }
                    }

                    function addSelectedItem(option) {
                        if (!option || !option.value) {
                            return;
                        }

                        if (getItems().length >= maxItems || hasSelectedProduct(option.value)) {
                            syncState();
                            return;
                        }

                        var fragment = template.content.cloneNode(true);
                        var item = fragment.querySelector('[data-analog-selected-item]');
                        var title = fragment.querySelector('.analog-selected-title');
                        var meta = fragment.querySelector('.analog-selected-meta');
                        var hiddenInput = fragment.querySelector('input[name="manual_analog_ids[]"]');

                        if (!item || !title || !meta || !hiddenInput) {
                            return;
                        }

                        item.setAttribute('data-id', option.value);
                        item.setAttribute('data-name', option.getAttribute('data-name') || option.textContent.trim());
                        item.setAttribute('data-sku', option.getAttribute('data-sku') || '');
                        title.textContent = option.getAttribute('data-name') || option.textContent.trim();
                        meta.textContent = option.getAttribute('data-sku') || '';
                        hiddenInput.value = option.value;

                        selectedList.appendChild(fragment);
                        attachItemHandlers(selectedList.lastElementChild);
                        select.value = '';
                        if (searchInput) {
                            searchInput.value = '';
                            filterOptions('');
                        }
                        syncState();
                    }

                    function filterOptions(term) {
                        var normalized = (term || '').trim().toLowerCase();
                        var firstMatchedValue = '';
                        Array.prototype.slice.call(select.options).forEach(function (option, index) {
                            if (index === 0) {
                                option.hidden = false;
                                return;
                            }

                            var label = (option.textContent || '').toLowerCase();
                            var name = (option.getAttribute('data-name') || '').toLowerCase();
                            var sku = (option.getAttribute('data-sku') || '').toLowerCase();
                            var matchesSearch = normalized === '' || label.indexOf(normalized) !== -1 || name.indexOf(normalized) !== -1 || sku.indexOf(normalized) !== -1;
                            var alreadySelected = hasSelectedProduct(option.value);

                            option.hidden = !matchesSearch || alreadySelected;

                            if (!option.hidden && firstMatchedValue === '') {
                                firstMatchedValue = option.value;
                            }
                        });

                        select.value = firstMatchedValue;
                        updateAddButtonState();
                    }

                    getItems().forEach(attachItemHandlers);

                    modeInputs.forEach(function (input) {
                        input.addEventListener('change', syncState);
                    });

                    addButton.addEventListener('click', function () {
                        addSelectedItem(select.options[select.selectedIndex]);
                    });

                    if (searchInput) {
                        searchInput.addEventListener('input', function () {
                            filterOptions(searchInput.value);
                        });

                        searchInput.addEventListener('keydown', function (event) {
                            if (event.key === 'Enter') {
                                event.preventDefault();
                                addSelectedItem(select.options[select.selectedIndex]);
                            }
                        });
                    }

                    syncState();
                });

                var toast = document.querySelector('[data-toast]');
                var toastClose = document.querySelector('[data-toast-close]');

                function hideToast() {
                    if (!toast || toast.classList.contains('is-hiding')) {
                        return;
                    }

                    toast.classList.add('is-hiding');

                    window.setTimeout(function () {
                        var stack = document.querySelector('[data-toast-stack]');
                        if (stack) {
                            stack.remove();
                        }
                    }, 220);
                }

                if (toast) {
                    window.setTimeout(hideToast, 3200);
                }

                if (toastClose) {
                    toastClose.addEventListener('click', hideToast);
                }

                if ({{ old('_open_import_modal') === '1' || $errors->importProducts->isNotEmpty() ? 'true' : 'false' }}) {
                    openImportModal();
                }
            })();
        </script>
    @endif
</body>
</html>
