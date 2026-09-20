<h1>Новая заявка на коммерческое предложение</h1>
<p><strong>Имя и компания:</strong> {{ $data->companyName }}</p>
<p><strong>Телефон:</strong> {{ $data->phone }}</p>
<p><strong>Email:</strong> {{ $data->email }}</p>
<p><strong>Описание задачи:</strong></p>
<p>{!! nl2br(e($data->taskDescription)) !!}</p>
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
