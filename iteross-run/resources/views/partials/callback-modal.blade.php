    <div class="proposal-modal" data-proposal-modal aria-hidden="true">
        <div class="proposal-modal-card" role="dialog" aria-modal="true" aria-labelledby="proposal-modal-title">
            <div class="proposal-modal-header">
                <div>
                    <h3 id="proposal-modal-title">Получить предложение</h3>
                    <p>Оставьте контакты, и мы свяжемся с вами, чтобы обсудить задачу и подготовить предложение.</p>
                </div>
                <button type="button" class="proposal-modal-close" data-close-proposal-modal aria-label="Закрыть окно">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="M6 6L18 18M18 6L6 18" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                    </svg>
                </button>
            </div>

            <form class="proposal-modal-form" method="POST" action="{{ route('callback-requests.store') }}" enctype="multipart/form-data">
                @csrf
                @if (session('callback_status'))
                    <div class="lead-form-feedback lead-form-feedback--success">{{ session('callback_status') }}</div>
                @endif

                @if ($errors->callbackRequest->any())
                    <div class="lead-form-feedback lead-form-feedback--error">
                        <ul>
                            @foreach ($errors->callbackRequest->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="proposal-modal-field">
                    <label for="proposal-name">Имя</label>
                    <input
                        id="proposal-name"
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        placeholder="Иван Иванов"
                        required
                        class="@if($errors->callbackRequest->has('name')) is-invalid @endif"
                    >
                    @if ($errors->callbackRequest->has('name'))
                        <div class="field-error">{{ $errors->callbackRequest->first('name') }}</div>
                    @endif
                </div>

                <div class="proposal-modal-field">
                    <label for="proposal-phone">Номер телефона</label>
                    <input
                        id="proposal-phone"
                        type="tel"
                        name="phone"
                        value="{{ old('phone') }}"
                        placeholder="+7 (___) ___-__-__"
                        required
                        class="@if($errors->callbackRequest->has('phone')) is-invalid @endif"
                    >
                    @if ($errors->callbackRequest->has('phone'))
                        <div class="field-error">{{ $errors->callbackRequest->first('phone') }}</div>
                    @endif
                </div>

                <div class="proposal-modal-field">
                    <label for="proposal-description">Описание задачи</label>
                    <textarea
                        id="proposal-description"
                        name="description"
                        placeholder="Опишите задачу, если хотите"
                        class="@if($errors->callbackRequest->has('description')) is-invalid @endif"
                    >{{ old('description') }}</textarea>
                    @if ($errors->callbackRequest->has('description'))
                        <div class="field-error">{{ $errors->callbackRequest->first('description') }}</div>
                    @endif
                </div>

                @php
                    $callbackAttachmentErrors = collect([$errors->callbackRequest->get('attachments'), $errors->callbackRequest->get('attachments.*')])->flatten()->unique()->values();
                @endphp
                <label class="file-box @if($callbackAttachmentErrors->isNotEmpty()) is-invalid @endif">
                    <input type="file" name="attachments[]" multiple data-max-files="10" data-max-total-mb="20" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                    <strong>Прикрепите файлы</strong>
                    <span>PDF, DOC, JPG, PNG — до 10 файлов, всего до 20 МБ</span>
                    <span class="file-box-name" data-file-name>Файлы не выбраны</span>
                </label>
                <div class="field-error" data-file-error @if($callbackAttachmentErrors->isEmpty()) hidden @endif>@foreach ($callbackAttachmentErrors as $attachmentError){{ $attachmentError }}@if(! $loop->last)<br>@endif @endforeach</div>

                <button type="submit" class="proposal-modal-submit">Заказать звонок</button>
            </form>
        </div>
    </div>
