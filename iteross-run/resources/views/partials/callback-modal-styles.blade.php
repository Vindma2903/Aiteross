<style>
        .proposal-modal {
            position: fixed;
            inset: 0;
            z-index: 500;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 24px;
            background: rgba(11, 37, 69, 0.46);
        }
        .proposal-modal.is-open {
            display: flex;
        }
        .proposal-modal-card {
            width: min(100%, 560px);
            border-radius: 22px;
            background: #FFFFFF;
            box-shadow: 0 32px 80px rgba(11, 37, 69, 0.24);
            overflow: hidden;
        }
        .proposal-modal-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 16px;
            padding: 28px 28px 0;
        }
        .proposal-modal-header h3 {
            margin: 0 0 8px;
            color: #0B2545;
            font-size: 28px;
            line-height: 1.1;
        }
        .proposal-modal-header p {
            margin: 0;
            color: #5B6470;
            font-size: 15px;
            line-height: 1.6;
        }
        .proposal-modal-close {
            width: 42px;
            height: 42px;
            border: 1px solid #D8DEE6;
            border-radius: 50%;
            background: #FFFFFF;
            color: #3A4048;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            flex: none;
        }
        .proposal-modal-close:hover {
            background: #F5F7FB;
        }
        .proposal-modal-form {
            display: grid;
            gap: 16px;
            padding: 24px 28px 28px;
        }
        .proposal-modal-field {
            display: grid;
            gap: 8px;
        }
        .proposal-modal-field label {
            color: #6A7381;
            font-size: 13px;
            font-weight: 700;
            letter-spacing: 0.2px;
        }
        .proposal-modal-field input,
        .proposal-modal-field textarea {
            width: 100%;
            border: 1.5px solid #D6DAE0;
            border-radius: 12px;
            background: #FFFFFF;
            padding: 14px 16px;
            color: #14161A;
            font-size: 15px;
            font-family: inherit;
            outline: none;
        }
        .proposal-modal-field textarea {
            min-height: 132px;
            resize: vertical;
        }
        .proposal-modal-field input:focus,
        .proposal-modal-field textarea:focus {
            border-color: #1657C4;
            box-shadow: 0 0 0 4px rgba(22, 87, 196, 0.12);
        }
        .proposal-modal-field input.is-invalid,
        .proposal-modal-field textarea.is-invalid {
            border-color: #D05353;
            box-shadow: 0 0 0 4px rgba(208, 83, 83, 0.12);
        }
        .proposal-modal-submit {
            min-height: 52px;
            border-radius: 14px;
            background: #1657C4;
            color: #FFFFFF;
            font-size: 15px;
            font-weight: 700;
        }
        .proposal-modal-submit:hover {
            background: #123F94;
        }
        .lead-form-feedback {
            border-radius: 12px;
            padding: 14px 16px;
            font-size: 14px;
            line-height: 1.5;
        }
        .lead-form-feedback--success {
            background: #EAF7EE;
            border: 1px solid #B7DFC0;
            color: #1F6B33;
        }
        .lead-form-feedback--error {
            background: #FFF3F3;
            border: 1px solid #F2CACA;
            color: #A33A3A;
        }
        .lead-form-feedback ul {
            margin: 0;
            padding-left: 18px;
        }
        .field-error {
            margin-top: 8px;
            color: #B03D3D;
            font-size: 13px;
            line-height: 1.5;
        }
        .file-box {
            border: 1.5px dashed #C9D3E0;
            border-radius: 12px;
            background: #FFFFFF;
            padding: 18px 16px;
            color: #5B6470;
            font-size: 14px;
            line-height: 1.6;
            text-align: center;
            cursor: pointer;
            transition: border-color 0.15s ease, background 0.15s ease, box-shadow 0.15s ease;
        }
        .file-box:hover {
            border-color: #1657C4;
            background: #F8FBFF;
        }
        .file-box:focus-within {
            border-color: #1657C4;
            box-shadow: 0 0 0 4px rgba(22, 87, 196, 0.12);
        }
        .file-box input {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: -1px;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            white-space: nowrap;
            border: 0;
        }
        .file-box strong {
            display: block;
            color: #1657C4;
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 6px;
        }
        .file-box span {
            display: block;
        }
        .file-box-name {
            margin-top: 10px;
            color: #14161A;
            font-weight: 600;
            line-height: 1.5;
        }
        .file-box.is-invalid {
            border-color: #D05353;
            box-shadow: 0 0 0 4px rgba(208, 83, 83, 0.12);
        }
        @media (max-width: 760px) {
            .proposal-modal {
                padding: 16px;
            }
            .proposal-modal-header,
            .proposal-modal-form {
                padding-left: 20px;
                padding-right: 20px;
            }
            .proposal-modal-header h3 {
                font-size: 24px;
            }
        }
</style>
