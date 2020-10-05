Hello {{$user->name}}
Thank you for create an account. Please verify email using the following link:
{{route('users.verify', $user->verification_token)}}