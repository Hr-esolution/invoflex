<form method="POST" action="{{ route('admin.users.update', $user) }}">
    @csrf @method('PUT')
    <label>Rôle</label>
    <select name="role" style="width:100%; padding:10px; margin:10px 0;">
        <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>Utilisateur</option>
        <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Administrateur</option>
    </select>
    <button type="submit" class="btn">Mettre à jour</button>
</form>