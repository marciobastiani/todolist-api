<p>Olá {{ $user->first_name }},</p>

<p>Seja bem-vindo(a) ao {{ config('app_name') }}. Por favor, confirme seu cadastro clicando no link abaixo.</p>

<table role="presentation" border="0" cellspacing="0" cellpadding="0" class="btn btn-primary">
    <tbody>
        <tr>
            <td align="center">
                <a href="{{ $verifyEmailLink }}" target="_blank">Confirmar meu cadastro</a>
            </td>
        </tr>
    </tbody>
</table>

<p>Ou simplesmente copie e cole o link abaixo no seu navegador</p>

<p>{{ $verifyEmailLink }}</p>