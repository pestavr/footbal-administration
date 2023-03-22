@component('mail::message')
# Ενημέρωση

Αγαπητέ/ή κ. {{ $maildata['name'] }},

{{ $maildata['message'] }}

Συνδεθείτε στην εφαρμογή για να αποδεχθείτε τον ορισμό
@component('mail::button', ['url' => $maildata['url']])
Συνδεθείτε στην εφαρμογή
@endcomponent

Ευχαριστούμε,<br>
Επιτροπή Διαιτησίας της {{ $maildata['eps'] }}
@endcomponent
