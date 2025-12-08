<!-- Colonne "Rôle" avec badge -->
<td>
    <span class="user-role role-{{ $user->role }}">{{ $user->role === 'admin' ? 'Administrateur' : 'Utilisateur' }}</span>
</td>
<td style="text-align:right;">
    <a href="{{ route('admin.users.edit', $user) }}" style="color:#4361ee;">✏️</a>
</td>