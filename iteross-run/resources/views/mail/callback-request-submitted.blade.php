<h1>Новая заявка на обратный звонок</h1>
<p><strong>Имя:</strong> {{ $data->name }}</p>
<p><strong>Телефон:</strong> {{ $data->phone }}</p>
<p><strong>Описание задачи:</strong></p>
<p>{!! nl2br(e($data->description !== '' ? $data->description : 'Не указано')) !!}</p>
@if ($storedAttachment)
    <p><strong>Вложение:</strong> {{ $storedAttachment['original_name'] }}</p>
@else
    <p><strong>Вложение:</strong> не приложено</p>
@endif
