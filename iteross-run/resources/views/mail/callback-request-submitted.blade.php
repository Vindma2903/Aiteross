<h1>Новая заявка на обратный звонок</h1>
<p><strong>Имя:</strong> {{ $data->name }}</p>
<p><strong>Телефон:</strong> {{ $data->phone }}</p>
<p><strong>Описание задачи:</strong></p>
<p>{!! nl2br(e($data->description !== '' ? $data->description : 'Не указано')) !!}</p>
@if (count($storedAttachments) > 0)
    <p><strong>Вложения ({{ count($storedAttachments) }}):</strong></p>
    <ul>
        @foreach ($storedAttachments as $attachment)
            <li>{{ $attachment['original_name'] }}</li>
        @endforeach
    </ul>
@else
    <p><strong>Вложения:</strong> не приложены</p>
@endif
