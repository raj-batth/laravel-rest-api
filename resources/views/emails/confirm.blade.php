Hello {{$user->name}}
You have changed your email, Please verify your new email using the following link:
{{route('users.verify', $user->verification_token)}}