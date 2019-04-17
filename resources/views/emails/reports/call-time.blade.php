@component('mail::message')

# Call Time Report

@component('mail::table')
| User          | Calls         | Call Time |  Average |
| :------------ | :-----------: | :-------: | :------: |
@foreach($users as $user)
| {{ $user['name'] }} | {{ $user['total_calls'] }} | {{ date('H:i:s', mktime(0, 0, $user['total_call_time'])) }} | {{ date('H:i:s', mktime(0, 0, $user['average_call_duration'])) }} |
@endforeach
@endcomponent

@endcomponent
