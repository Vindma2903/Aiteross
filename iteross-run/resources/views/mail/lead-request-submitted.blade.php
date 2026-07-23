<h1>Новая заявка на коммерческое предложение</h1>
<p><strong>Имя и компания:</strong> {{ $data->companyName }}</p>
<p><strong>Телефон:</strong> {{ $data->phone }}</p>
<p><strong>Email:</strong> {{ $data->email }}</p>
<p><strong>Описание задачи:</strong></p>
<p>{!! nl2br(e($data->taskDescription)) !!}</p>
@if ($storedAttachment)
    <p><strong>Вложение:</strong> {{ $storedAttachment['original_name'] }}</p>
@else
    <p><strong>Вложение:</strong> не приложено</p>
@endif
